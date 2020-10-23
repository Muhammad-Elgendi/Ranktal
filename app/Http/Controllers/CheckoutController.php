<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        // Check if vaild subscribtion was made
        if(!empty($planID) && !empty($subscriptionID) && isset($plans[$planID]) ){
            Auth::user()->plan = $plans[$planID];
            Auth::user()->subscription_id = $subscriptionID;
            Auth::user()->subscribed_until = Carbon::now()->addDay(30);
            Auth::user()->save();
            return "Successful payment :)";
        }

        return "Failed payment :(";

    }

    // View current plans to user
    public function plans(){
        // Get pricing page url to scrape it
        $url = url('/');
        $parsed_url = parse_url($url);      
        $ip = $_SERVER['REMOTE_ADDR']; 
        $pricing_url = 'http://'.$ip.'/pricing';
        $pricing_html = file_get_contents($pricing_url, false);  
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
