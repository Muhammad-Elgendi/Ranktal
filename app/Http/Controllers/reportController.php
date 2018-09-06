<?php

namespace App\Http\Controllers;


use App\Report;
use Request;
use Artisan;
use App\Jobs\MakeReport;
use App\Core\Title;
use App\Core\Url;
use App\Core\Meta;
use App\Core\Page;
use App\Core\Heading;
use App\Core\Image;
use App\Core\Check;
use App\Core\Alexa;
use App\Core\BackLinks;
use App\Core\PageSpeed;
use App\audit;
//use App\test;
use DB;
class reportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('report.report-form');
    }

    public function makeReport(){
        $url=Request::get('url');

        $report = Report::where('inputURL', '=', $url)->first();

        if (isset($report)){
            return redirect('comprehensive-report/'.$report->id);
        }

        $statement = DB::select("SHOW TABLE STATUS LIKE 'reports'");
        $nextId = $statement[0]->Auto_increment;
        MakeReport::dispatch($url,$nextId,true);
        return redirect('comprehensive-report/'.$nextId);
    }

    public function regenerateReport($id){
        $report=Report::find($id);
        $url=$report->inputURL;
        Report::destroy($id);
        MakeReport::dispatch($url,$id,false);
        return redirect('comprehensive-report/'.$id);
    }


    public function loadReport($id){
        $report=Report::findOrFail($id);
        return $report;
    }

    public function view($id){
        return view('report.report-generation',compact('id'));
    }



}
