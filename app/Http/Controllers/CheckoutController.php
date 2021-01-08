<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Update User Plan after successful payment
    public function updatePlan(Request $request){
        // list of all plans
        // Plan ID => Plan Name
        $plans =[
            'P-5M7067117B8503722L6I5B2Q' => 'Solo',
            'P-8HM887005N024444DL6I5HPY' => 'Agency'
        ];

        // Get plan ID and subscription ID from request
        $planID = $request->get('planID');
        $subscriptionID = $request->get('subscriptionID');

        $user = Auth::user();
        // Check if vaild subscribtion was made
        if(!empty($planID) && !empty($subscriptionID) && isset($plans[$planID]) ){
            
            $user->plan = $plans[$planID];
            $user->subscription_id = $subscriptionID;
            $user->subscribed_until = Carbon::now()->addMonths(1);
            $user->save();
            return view('thankyou')
            ->with('name',$user->name)
            ->with('plan',$user->plan)
            ->with('end_date',$user->subscribed_until->toDayDateTimeString());
             
        }else{
            // Failed Payment
            return view('failedpayment')
            ->with('name',$user->name);
        }
    }

    // View current plans to user
    public function plans(){
        // Get pricing page url to scrape it
        $url = url('/');
        $parsed_url = parse_url($url);      
        $ip = 'nginx'; 
        $pricing_url = 'http://'.$ip.'/pricing';

        // We added ssl to production environment so let's use the secured url
        // but certification is only trusted by cloudflare
        
        // if (App::environment('production')) {
        //     // The environment is production
        //     $pricing_url = 'https://'.$ip.'/pricing';
        // }

        // using curl
        $curl = curl_init($pricing_url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Ranktal App");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $pricing_html = curl_exec($curl);
        curl_close($curl);

        // $pricing_html = file_get_contents($pricing_url, false);  

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($pricing_html);
        libxml_use_internal_errors(false);    
        $node =  $doc->getElementById('pricing');

        // add placeholder and remove subscribe buttons
        $selector = new \DOMXPath($doc);
        $counter = 0;
        foreach($selector->query('//a[contains(attribute::class, "btn-success")]') as $e ) {
            // create divs elements for paypal buttons
            $domElement = $doc->createElement('div');
            $domAttribute = $doc->createAttribute('id');
            
            // Value for the created attribute
            $domAttribute->value = 'plan'.$counter;
            
            // Don't forget to append it to the element
            $domElement->appendChild($domAttribute);
            
            // Append it to the document itself
            $e->parentNode->appendChild($domElement);         

            $e->parentNode->removeChild($e);
            $counter++;
        }
        // get html
        $plan_html = $doc->saveHTML($node);
        
        return view('plans',compact('plan_html'));
    }
}
