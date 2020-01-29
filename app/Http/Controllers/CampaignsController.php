<?php

namespace App\Http\Controllers;

use App\campaign;
use App\Jobs\CampaignTrack;
use App\optimization;
use App\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View user campaigns Method
    public function index()
    {
        $campaigns = campaign::where('user_id', Auth::user()->id)->get();
        return view('dashboard.campaigns')->with('campaigns', $campaigns);
    }

    // View campaign Method
    public function view($id)
    {
        $campaign = campaign::where('user_id', Auth::user()->id)->where('id', $id)->first();
        $alphaCode = $this->countryToCode($campaign->site->metric->countryName);
        $alphaCode = ($alphaCode === false) ? null : strtolower($alphaCode); 
        return view('dashboard.campaigns.view',['campaign'=> $campaign, 'countryCode' => $alphaCode]);
    }

    public function viewOptimization($campaign_id,$page_id){
        $campaign = campaign::where('user_id', Auth::user()->id)->where('id', $campaign_id)->first();
        if($campaign === null){
            return abort(404);
        }
        $optimization = $campaign->optimization()->where('id',$page_id)->first();
        if($optimization === null || $optimization->report === null){
            return abort(404);
        }
        // adapt the report for the view template
        $newRequest = array();
        $counter = 0;
        foreach ($optimization->report  as $key => $value) {
            if (gettype($value) == "boolean" ) {
                $newRequest['checks'][$counter]["type"] = empty($value) ? "glyphicon-remove-sign text-danger" : "glyphicon-ok-sign text-success";
                $newRequest['checks'][$counter]["title"] = __($key);
                $newRequest['checks'][$counter]["infosection"]["infoword"] =__('about-issue');
                $newRequest['checks'][$counter]["infosection"]["info"] =__($key."Info"); 
                $newRequest['checks'][$counter]["text_before_attributes"] =  '<h4>'.__('how-to-fix').'</h4>'.'<p>'.__($key."Fix").'</p>';

                // $newRequest['checks'][$counter]["list_before_attributes"] =  array_fill(0, 6, 'banana');
                $counter++;
            }
            else{
                $newRequest[$key] = $value;
            }
        }
        return view('dashboard.pageOptimization')->with('report',$newRequest);
    }

    // Return Create New Campaign View
    public function create()
    {
        return view('dashboard.campaigns.create');
    }

    /**
     * Return True if inputs are in correct format 
     * False if not
     */
    private function filterInputs(Request $request, $site = null, $exact = null)
    {
        if ($site == null && $exact == null) {
            $site = $request->get('site');
            $exact = $request->get('exact');
        }

        if (!is_bool($exact)) {
            $exactText = strtolower($exact);
            if ($exactText === "true") {
                $exact = true;
            } elseif ($exactText === "false") {
                $exact = false;
            } else {
                $exact = boolval($exactText);
            }
        }

        // validate url parameter
        $site = (stripos($site, "https://") === false && stripos($site, "http://") === false) ? "http://" . $site : $site;
        $isGoodUrl = !empty(filter_var($site, FILTER_VALIDATE_URL));

        if (!$isGoodUrl) {
            return false;
        } else {
            return true;
        }
    }

    public function store(Request $request)
    {

        $campaign = new campaign();
        $campaign->user_id = Auth::user()->id;
        $campaign->name = $request->get('name');

        $interval = (int) $request->get('interval');
        // validate interval
        if ($interval > 30)
            $interval = 30;
        if ($interval < 7)
            $interval = 7;

        $campaign->interval = $interval;
        // validate exact check box        
        $exact = $request->get('exact') !== null;
        $site = $request->get('url');

        // validate inputs
        $areGoodInputs = $this->filterInputs($request, $site, $exact);
        if (!$areGoodInputs) {
            return;
        }

        $crawlingController = new CrawlingController();
        // check if site data is existed
        $existedSite = Site::where('host', $site)->first();

        if ($existedSite === null) {
            // if site isn't exist

            // create new site
            $siteId = $crawlingController->createNewSite($site, $exact);
            // assign campaign to the site
            $campaign->site_id = $siteId;
            // save campaign data
            $campaign->save();

            // TODO : set the remaining pages of the user account as a limit for the crawling request

            // send crawling request
            $crawlingController->sendCrawlingRequest($site, $siteId, $exact);
        } else {
            // site is existed
            // assign campaign to the site
            $campaign->site_id = $existedSite->id;
            // save campaign data
            $campaign->save();
        }

        // check if there are pages to optimize
        if (!empty($request->get('keyword')[0]) && !empty($request->get('page-link')[0])) {
            // there are pages to optimize
            for ($i = 0; $i < count($request->get('page-link')); $i++) {
                $optimization = new optimization();
                $optimization->campaign_id = $campaign->id;
                // remove trailing slashes in URL
                $inputUrl = rtrim($request->get('page-link')[$i], "/");
                $optimization->url = $inputUrl;
                $optimization->keyword = $request->get('keyword')[$i];
                $optimization->save();
            } // end for
        } // end if

        // change the status of the campaign
        $campaign->status = "Waiting";
        // save data
        $campaign->save();

        // Add the job of geting metrics , pageInsights , page optimizations and sending email to queue
        CampaignTrack::dispatch($campaign->id);

        // redirect to seo campaigns view
        return redirect(route('lang.seo-campaigns', app()->getLocale()));
    }

    /**
     * Delete the campain and all of its data
     */
    public function destroy($id)
    {
        $site = campaign::findOrFail($id);
        $site->delete();
        return redirect(route('lang.seo-campaigns', app()->getLocale()));
    }

    // Return Edit Campaign View
    public function edit($id)
    {
        $campaign = campaign::findOrFail($id);
        return view('dashboard.campaigns.edit')->with('campaign', $campaign);
    }

    // store the edits of the campaign
    public function saveEdit(Request $request)
    {
        $id = $request->get('id');
        $campaign = campaign::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if ($campaign === null) {
            return;
        }
        $campaign->name = $request->get('name');
        $interval = (int) $request->get('interval');
        // validate interval
        if ($interval > 30)
            $interval = 30;
        if ($interval < 7)
            $interval = 7;

        $campaign->interval = $interval;
        // change the status of the campaign
        $campaign->status = "Waiting";
        // save changes
        $campaign->save();
        // keep ids of optimizations that will not be deleted
        $noDelete = [];
        // check if there are pages to optimize
        if (!empty($request->get('keyword')[0]) && !empty($request->get('page-link')[0])) {
            // there are pages to optimize
            for ($i = 0; $i < count($request->get('page-link')); $i++) {
                // check if this optimization is not existed in the db
                $foundOptimization = $campaign->optimization()->where('url', $request->get('page-link')[$i])->where('keyword', $request->get('keyword')[$i])->first();
                if ($foundOptimization === null) {
                    $optimization = new optimization();
                    $optimization->campaign_id = $campaign->id;
                    // remove trailing slashes in URL
                    $inputUrl = rtrim($request->get('page-link')[$i], "/");
                    $optimization->url = $inputUrl;
                    $optimization->keyword = $request->get('keyword')[$i];
                    $optimization->save();
                    // add the id to noDelete
                    $noDelete[] = $optimization->id;
                } else {
                    // add the id of foundOptimization to noDelete
                    $noDelete[] = $foundOptimization->id;
                }
            } // end for
        } // end if

        // delete all optimizations from database if the user delete them
        if (empty($noDelete)) {
            // delete all previous optimization
            $campaign->optimization()->delete();
        }

        // delete optimization from our database if the user delete it
        foreach ($campaign->optimization as $optimization) {
            if (!in_array($optimization->id, $noDelete)) {
                $optimization->delete();
            }
        }

        // Add update optimization job to queue
        CampaignTrack::dispatch($campaign->id, false, true, false, false);

        // redirect to seo campaigns view
        return redirect(route('lang.seo-campaigns', app()->getLocale()));
    }

    /**
     * Add campaigns that has to be updated to queue
     */
    public static function scheduleCampaign()
    {
        $campaigns = campaign::where('status', 'Finished')->oldest('last_track_at')->get();
        foreach ($campaigns as $campaign) {
            if ($campaign->last_track_at <  Carbon::now()->subDay($campaign->interval)) {
                // this campaign has to be updated
                CampaignTrack::dispatch($campaign->id);
            }
        }
    }

    /**
     * static function to convert country name to  ISO 3166-1-alpha-2 code
     */
    public static function countryToCode($country){

        // $country = strtoupper($country);

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France, French Republic',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands the',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal, Portuguese Republic',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia (Slovak Republic)',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland, Swiss Confederation',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );

        return array_search($country,$countryList);
    }
}
