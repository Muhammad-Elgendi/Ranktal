<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\BackLinks;
use App\Backlink;

class backlinksController extends Controller
{
    //TODO
    /**
     * Add validation of urls
     */

    public function getBacklinks(Request $request){
        $target = $request->get('target');
        $src = $request->get('src');
        // validate urls
        $isGoodTarget = !empty(filter_var($target, FILTER_VALIDATE_URL));
        $isGoodSrc = !empty(filter_var($src, FILTER_VALIDATE_URL));
        if( (empty($target) && empty($src)) || (!empty($src) && !$isGoodSrc) || (!empty($target)&& !$isGoodTarget) ) {
                return "Not Vaild Parameters";
        }
        elseif(!empty($target) && !empty($src)){
            $foundBacklinks = Backlink::where('source_url','like','%'.$src.'%')->where('target_url','like','%'.$target.'%')->get();
            if($foundBacklinks->isEmpty()){
                $this->getBacklinksFromApi($target,30);
            }
            $foundBacklinks = Backlink::where('source_url','like','%'.$src.'%')->where('target_url','like','%'.$target.'%')->get();
            if($foundBacklinks->isEmpty()){
                return 'No Backlinks are Found';
            }else return $foundBacklinks;
        }
        elseif(!empty($target) && empty($src)){
            $foundBacklinks = Backlink::where('target_url','like','%'.$target.'%')->get();
            if($foundBacklinks->isEmpty()){
                $this->getBacklinksFromApi($target,30);
            }
            $foundBacklinks = Backlink::where('target_url','like','%'.$target.'%')->get();
            if($foundBacklinks->isEmpty()){
                return 'No Backlinks are Found';
            }else return $foundBacklinks;
        }
        elseif(empty($target) && !empty($src)){
            $foundBacklinks = Backlink::where('source_url','like','%'.$src.'%')->get();
            if($foundBacklinks->isEmpty()){
                return 'No Backlinks are Found';
            }else return $foundBacklinks; 
        }
    
    }

    private function getBacklinksFromApi($url,$limit= null){

        $linker =new BackLinks($url,$limit);

        $class_methods = get_class_methods($linker);

        foreach ($class_methods as $method_name) {
            if($method_name != "__construct")
                $linker->$method_name();
        }

        if(!empty($linker->backlinks)){
            foreach($linker->backlinks as $backlink){
                $newLink = new Backlink();
                $newLink->source_url = $backlink['Source URL'];
                $newLink->target_url = $backlink['Target URL'];
                $newLink->anchor_text = $backlink['Anchor Text'];
                $newLink->isDoFollow = $backlink['isDoFollow'];
                $newLink->save();
            }
        }

        // var_dump(get_object_vars($p));
    }
}