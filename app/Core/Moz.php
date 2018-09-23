<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 * @param $url
 *
 * Request URL Example :
 * http://lsapi.seomoz.com/linkscape/url-metrics/moz.com%2fblog?Cols=4&AccessID=member-cf180f7081&Expires=1225138899&Signature=LmXYcPqc%2BkapNKzHzYz2BI4SXfC%3D
 *
 *
 * Cols=103079266336
 *
 * Access ID:mozscape-b8c7023e7a
 *
 * Secret Key:5ec326509fe6cc73fd0333c67022a273
 *
 **/

class Moz{

    public $accessID;
    public $secretKey;
    public $expires;
    public $objectURL;
    //Set defualt to our required data
    public $cols=103079266336;
    private $urlSafeSignature;
    private $error='';
    private $response;

    /**
     * Moz constructor.
     * @param $accessID
     * @param $secretKey
     * @param $expires
     */
    function __construct($accessID,$secretKey,$expires){

        // Get your access id and secret key here: https://moz.com/products/api/keys
        $this->accessID = $accessID;
        $this->secretKey = $secretKey;

        // Set your expires times for several minutes into the future.
        // An expires time excessively far in the future will not be honored by the Mozscape API.
        $this->expires = time() + $expires;

        // Put each parameter on a new line.
        $stringToSign = $this->accessID."\n".$this->expires;

        // Get the "raw" or binary output of the hmac hash.
        $binarySignature = hash_hmac('sha1', $stringToSign, $this->secretKey, true);

        // Base64-encode it and then url-encode that.
        $this->urlSafeSignature = urlencode(base64_encode($binarySignature));
    }

    /**
     * @param $url
     */
    function setURL($url){
        // Specify the URL that you want link metrics for.
        $this->objectURL = $url;
    }

    /**
     * @param $cols
     */
    function setCols($cols){
        // Add up all the bit flags you want returned.
        // Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
        $this->cols = $cols;
    }

    /**
     * @param $type
     * @return bool
     */
    function sendRequest($type){
        // Put it all together and you get your request URL.
        // This example uses the Mozscape URL Metrics API.
        switch ($type) {
            case 'data':
                $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($this->objectURL)."?Cols=".$this->cols."&AccessID=".$this->accessID."&Expires=".$this->expires."&Signature=".$this->urlSafeSignature;
                break;

            case 'links':
                $requestUrl = "http://lsapi.seomoz.com/linkscape/links/".urlencode($this->objectURL)."?AccessID=".$this->accessID."&Expires=".$this->expires."&Signature=".$this->urlSafeSignature."&Scope=page_to_domain&Filter=external+follow&Sort=page_authority&SourceCols=4&TargetCols=4&LinkCols=4&Limit=10";
                break;
            default:
                return false;
                break;
        }

        // Use Curl to send off your request.
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($requestUrl);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        if ( $content === false ){
            $this->error = curl_error( $ch );
            return false;
        }
        curl_close($ch);
        $data = json_decode($content,true);
        $this->response=$data;
    }

    // This function can name the response from request with cols= 103079266336
    function getNamedResponse(){
        if(!empty($this->error))
            return false;
        else{
            $this->response['External Equity Links'] = $this->response['ueid'];
            $this->response['Links'] = $this->response['uid'];
            $this->response['MozRank: URL normalized'] = $this->response['umrp'];
            $this->response['MozRank: URL raw'] = $this->response['umrr'];
            $this->response['MozRank: Subdomain normalized'] = $this->response['fmrp'];
            $this->response['MozRank: Subdomain raw'] = $this->response['fmrr'];
            $this->response['Page Authority'] = $this->response['upa'];
            $this->response['Domain Authority'] = $this->response['pda'];
            unset($this->response['ueid'],$this->response['uid'],$this->response['umrp'],$this->response['umrr'],$this->response['fmrp'],$this->response['fmrr'],$this->response['upa'],$this->response['pda']);
            return $this->response;
        }
    }

    function getRawResponse(){
        if(!empty($this->error))
            return false;
        else
            return $this->response;
    }

    function getError(){
        return $this->error;
    }
}