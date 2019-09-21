<?php

namespace App\Http\Controllers;

use App\Core\ProxyProvider;
use App\Http\Controllers\BrowserController;
use App\Proxy;
use Exception;
use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class ProxyController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Get Proxy from rotator
     */
    public static function getProxy($site = null,$country =null){
        if($site == 'google'){
            if($country == null){
                $proxy = Proxy::where('google_pass',true)->where('last_use', '<', Carbon::now()->subHour())
                ->orderBy('last_use', 'asc')->orderBy('speed', 'asc')->first();
            }else{
                $proxy = Proxy::where('google_pass',true)->where('country',$country)
                ->where('last_use', '<', Carbon::now()->subHour())
                ->orderBy('last_use', 'asc')->orderBy('speed', 'asc')->first();
            }
        }else if($site == 'bing'){
            $proxy = Proxy::where('bing_pass',true)->where('last_use', '<', Carbon::now()->subHour())
                ->orderBy('last_use', 'asc')->orderBy('speed', 'asc')->first();
        }else{
            $proxy = Proxy::where('speed','<=',4000)->where('last_use', '<', Carbon::now()->subHour())
                ->orderBy('last_use', 'asc')->orderBy('speed', 'asc')->first();
        }
        if($proxy == null){
            $proxy = Proxy::orderBy('speed', 'asc')->orderBy('updated_at', 'asc')->orderBy('last_use', 'asc')->first();
            if($proxy == null){
               return; 
            }
        }
        $proxy->last_use = Carbon::now();
        $proxy->save();
        return $proxy;
    }

    /**
     * Genral method to save Proxies to database
     * $methodName is any static method of ProxyProvider class
     * 
     * *METHODS*
     * 
     * getParsedSpysMeProxy 
     * This method is scheduled to run every hour in app/Console/Kernel.php@schedule()
     *   because SpyMe update its proxy list every hour 
     * 
     *
     * getParsedPubProxy
     * This method is scheduled to run every Thirty Minutes in app/Console/Kernel.php@schedule()
     *   because pubproxy API has 50 REQUESTS PER DAY LIMIT   
     * 
     * getParsedProxyScrape
     * 
     * This method is scheduled to run every hour in app/Console/Kernel.php@schedule()
     *   but ProxyScrape update its proxy list every Fifty Minutes 
     * 
     */
    public static function saveProxiesFrom($methodName){
        $proxies = ProxyProvider::$methodName();
        $properties = array_keys($proxies[0]);
        foreach ($proxies as $proxy) {
            $newProxy = Proxy::where('proxy',$proxy['proxy'])->first();
            if($newProxy == null){
                $newProxy = new Proxy();
            }
            foreach($properties as $property){
                $newProxy->$property = $proxy[$property];
            }     
            $newProxy->is_working = true;

            $newProxy->save();
        }
    }

    public function savefromProxyFile(){
        ProxyController::saveProxiesFromCSV(app_path('proxies2.csv'),['proxy']);
    }

    /**
     * Get Real IP from cache
     */
    public static function getServerRealIP(){
        return Cache::get('real_ip');
    }

    /**
     * This function is schudeled to run twice a day @ app/Console/Kernel.php@schedule()
     * and it will update Real IP in cache
     */
    public function updateServerRealIP(){
        $ip = file_get_contents('https://ip.seeip.org');
        Cache::forever('real_ip', $ip);
        return $ip;
    }

    public static function updateProxiesPassEngines(){

        $proxies = Proxy::where('google_pass',null)->orWhere('bing_pass',null)
        ->where('speed','<=',4000)->where('is_working',true)->get();
        
        // Recheck proxies every 6 hours 
        if($proxies->isEmpty()){
            $proxies = Proxy::where('speed','<=',4000)->where('is_working',true)
            ->where('updated_at', '<=', Carbon::now()->subHour(6))
            ->orderBy('updated_at', 'asc')->get();
        }
       
        foreach($proxies as $item){       
            $proxy_url = $item->type.'://'.$item->proxy;
            $google_pass = BrowserController::isGooglePassedProxy($proxy_url);
            $bing_pass = BrowserController::isBingPassedProxy($proxy_url);
            $item->google_pass = $google_pass;
            $item->bing_pass = $bing_pass;
            $item->save();
        }
    }

    /**
     * Here is a list of urls to test the proxy agaist
     * https://github.com/
     * https://gitlab.com     * 
     * https://wikipedia.com  
     * https://my-json-server.typicode.com/typicode/demo/posts
     * https://raw.githubusercontent.com/typicode/demo/master/db.json
     * https://whatismyipaddress.com/
     * 
     * https://ip.seeip.org
     * http://icanhazip.com/
     * https://www.ipify.org/
     * http://ip-api.com/
     * https://whatismyipaddress.com/api
     * https://www.myip.com/api-docs/
     */
    /**
     * Update type,anonymity,speed,is_working,country info 
     * if you want to force update pass true
     */
    public static function updateProxiesInfo($force_update = false){

        if($force_update){
            $proxies = Proxy::all();
        }else{
            $proxies = Proxy::where('type',null)->orWhere('anonymity',null)->orWhere('speed',null)
            ->orWhere('is_working',null)->orWhere('country',null)->get();
        }

        // recheck proxies every six hours
        if($proxies->isEmpty()){
            $proxies = Proxy::where('updated_at', '<', Carbon::now()->subHour(6))
            ->orderBy('updated_at', 'asc')->get();
        }
       
        foreach($proxies as $item){
            try{
                $proxyInfo = ProxyController::getProxyTypeAndAnonymity("https://ip.seeip.org",$item->proxy);
            }catch(Exception $e){
                continue;
            }
            
            foreach($proxyInfo as $key => $value){
                $item->$key = $value;
            }
            $item->save();
        }
    }

    /**
     * Save Proxies from CSV file
     */
    public static function saveProxiesFromCSV($csv_path,$header){
        //Open the file.
        $fileHandle = fopen($csv_path, "r");

        // Find Proxy PK  index in header
        $primaryKeyIndex = array_search('proxy',$header);
        
        //Loop through the CSV rows.
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
            //Save Proxies data after validation.
            $isVaildProxy = substr_count($row[$primaryKeyIndex],".") == 3 && substr_count($row[$primaryKeyIndex],":") == 1;
            if($isVaildProxy){
                $isProxyNotExist = Proxy::where('proxy',$row[$primaryKeyIndex])->first() == null;
                if($isProxyNotExist){
                    $proxy = new Proxy();
                    foreach($header as $proberty){
                        $proxy->$proberty = $row[array_search($proberty,$header)];
                    }
                    $proxy->save();
                }
            }            
        }
    }

    /**
     * Using postgres copy command
     * Not tested yet
     */
    public function copyProxiesFromCSV($csv_path){
        DB::statement("
            CREATE TEMP TABLE tmp_table       
            AS
            SELECT * 
            FROM proxies
            WITH NO DATA;"
        );
        
        DB::statement("
            COPY tmp_table FROM '".$csv_path."';
        ");

        DB::statement("
            INSERT INTO proxies
            SELECT DISTINCT ON (proxy) *
            FROM tmp_table
            ORDER BY (proxy);
        ");
        
        DB::statement("
            DROP TABLE tmp_table;
        ");
    }

    /**
     *
     * Get a url to test the proxy agaist and 
     * the $proxy variable is set to the proxy you’d like to test (in IP:PORT format).
     * return the proxy (in IP:PORT format),
     *        type of proxy ,
     *        the level of anonymity ,
     *        speed measured in ms ,
     *        is_working as boolean ,
     *        ISO code of country
     */
    public static function getProxyTypeAndAnonymity($url, $proxy){
        $result = ProxyController::checkProxyType($url, $proxy);
        $anonymity = ProxyController::checkProxyAnonymity($result['header']);
        $country = ProxyController::getCountryCodeFromIP(explode(":",$proxy)[0]);
        $is_working = !empty($result['type']);
        return [    
            'type' => !empty($result['type']) ? $result['type'] : null,
            'anonymity' => $anonymity,
            'speed' => !empty($result['speed']) ? $result['speed'] : null,
            'is_working' => $is_working,
            'country' => $country
        ];
    }

    /**
     * Get country ISO code of IP from maxmind's GeoLite2 Country
     */
    public static function getCountryCodeFromIP($ip){
        $reader = new Reader(app_path().'/Core/GeoIP/GeoLite2-Country.mmdb');
            try {
                $record = $reader->country($ip);
                return $record->country->isoCode;
            } catch (\Exception $e) {
                return;
            }
    }

    /**
     *  Get ISO Code (ISO 3166-1 alpha-2) of country name 
     */
    public static function getISOCountryCode($country_name){
        $countries = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
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
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
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
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
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
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
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
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
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
            'FM' => 'Micronesia, Federated States Of',
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
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
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
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );
        return array_search($country_name, $countries);
    }

    /**
     * Note: Make sure the $url variable is set to your gateway URL,
     * and the $proxy variable is set to the proxy you’d like to test (in IP:PORT format).
     */
    public static function checkProxyType($url, $proxy){

        $outputArray = [];

        $headers = [];

        // HTTPS removed because its available @PHP >= 7.3
        $types = array(
            'http',        
            'socks4',
            'socks5'
        );

      
        $url = curl_init($url);
        curl_setopt($url, CURLOPT_PROXY, $proxy);       
        curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);

        // CURLOPT_TIMEOUT - The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($url, CURLOPT_TIMEOUT, 5);
        curl_setopt($url, CURLOPT_CONNECTTIMEOUT, 4); 

        // Set user agent
        $User_Agent = 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31';
        curl_setopt($url, CURLOPT_USERAGENT, $User_Agent);

        // this function is called by curl for each header received
        curl_setopt($url, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers){
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        });

        foreach ($types as $type) {
            $headers = [];
            
            switch ($type) {
                case 'http':
                    curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
                    break;
                // case 'https':
                //     curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_HTTPS);
                //     break;
                case 'socks4':
                    curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
                    break;
                // case 'socks4a':
                //     curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4A);
                //     break;
                case 'socks5':
                    curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                    break;
                // case 'socks5h':
                //     curl_setopt($url, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5_HOSTNAME);
                //     break;
            }
            $loadTime = microtime(true);
            $data = curl_exec($url);
            if (!empty($data)) {
                $outputArray['type'] = $type;
                $outputArray['speed'] = floor((microtime(true) - $loadTime) * 1000);
                break;
            }
        }

        $outputArray['header'] = $headers;
        curl_close($url);
        unset($url);
        return $outputArray;
    }

    /**
     * After you have the returned server data from the above checkProxyType function,
     * simply pass it to the function below and it will return the proxy anonymity level.
     */
    public static function checkProxyAnonymity($server = array()){

        if(empty($server)){
            return null;
        }

        // server real IP
        $realIp = ProxyController::getServerRealIP();

        $level = 'transparent';

        if (!ProxyController::in_array_r($realIp, $server)) {
            $level = 'anonymous';
            $proxyDetection = array(
                'HTTP_X_REAL_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_PROXY_ID',
                'HTTP_VIA',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_FORWARDED',
                'HTTP_CLIENT_IP',
                'HTTP_FORWARDED_FOR_IP',
                'VIA',
                'X_FORWARDED_FOR',
                'FORWARDED_FOR',
                'X_FORWARDED FORWARDED',
                'CLIENT_IP',
                'FORWARDED_FOR_IP',
                'HTTP_PROXY_CONNECTION',
                'HTTP_XROXY_CONNECTION'
            );
            if(empty(array_intersect($proxyDetection,array_keys($server)))){
                $level = 'elite';
            };
        }
        return $level;
    }

    /**
     * Recursive in_array helper
     */
    public static function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && ProxyController::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
    
        return false;
    }
}
