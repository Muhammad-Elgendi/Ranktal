<?php

namespace App\Http\Controllers;

use App\BulkReport;
use App\Jobs\MakeMiniReport;
use App\MiniReport;
use DB;
use Illuminate\Http\Request;

class MiniReportController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('miniReport.mini-report-form');
    }

    /**
     * @return mixed
     */
    public function makeBulkReports(Request $request){

        $json=$request->get('urls');
        $report=new BulkReport();
        $report->arrayOfReports=$json;
        $report->save();

        $array=json_decode($json,true);

        foreach ($array as $url) {
            $statement = DB::select("SELECT nextval('mini_reports_id_seq');");
            $nextId = $statement[0]+1;
            MakeMiniReport::dispatch($url, $nextId,true)->onQueue('bulk-reports');;
        }

        return redirect('bulk-report/'.$report->id);

    }

    public function makeReport(Request $request){

        $url=$request->get('url');

        $report = MiniReport::where('inputURL', '=', $url)->first();

        if (isset($report)){
            return redirect('on-page-report/'.$report->id);
        }

        $statement = DB::select("SHOW TABLE STATUS LIKE 'mini_reports'");
        $nextId = $statement[0]->Auto_increment;
        MakeMiniReport::dispatch($url,$nextId,true);
        return redirect('on-page-report/'.$nextId);

    }

    public function regenerateReport($id){
        $report=MiniReport::find($id);
        $url=$report->inputURL;
        MiniReport::destroy($id);
        MakeMiniReport::dispatch($url,$id,false);
        return redirect('on-page-report/'.$id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function loadReport($id){
        $report=MiniReport::findOrFail($id);
        return $report;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function loadBulkReports($id){
        $report=BulkReport::findOrFail($id);
        return $report;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function loadMiniReports(Request $request){
        $url =$request->input('report');
        $report = MiniReport::where('inputURL', '=', $url)->first();
        return $report;
    }


    public function bulkView($id){
        return view('miniReport.bulk-report-generation',compact('id'));
    }


    public function view($id){
        return view('miniReport.mini-report-generation',compact('id'));
    }
}