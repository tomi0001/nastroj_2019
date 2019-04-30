<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App\Http\Services\calendar as Calendar;
use App\Http\Services\mood as Mood;
use App\Http\Services\AIMood as AI;
use App\Http\Services\search as Search;
use App\Http\Services\common as Common;
use Illuminate\Support\Facades\Input as Input;
use Barryvdh\DomPDF\Facade as PDF;
class ControllerSearch extends BaseController
{
    public function main() {
        //PDF::setOptions(['dpi' => 150, 'defaultFont' => 'pdfBackend']);
        if ( (Auth::check()) ) {
            $Common = new Common;
            $year = $Common->selectFirstYear();
            
            return View("Search.main")->with("yearFrom",$year)
                    ->with("yearTo",date("Y"));
        }
    }
    
    public function searchAction() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $Search = new Search;
            if (empty(Input::get("page"))) {
                $page = 0;
            }
            else {
                $page = Input::get("page");
            }
            //$Search->createQuestionForSleep($page);
            if (Input::get("type") == "mood") {
                $Search->createQuestion($page);
            }
            else {
                $Search->createQuestionForSleep($page);
            }
            
            $Search->sortMoods(false);
            //$Ai = new AI;
            //for ($i=1;$i <= 24;$i++) {
                //$a[] = $Ai->selectAverageMood($i,$i,"2019-03-01","2019-04-03");
            //}
            //print ("<pre>");
            //print_r( $Search->list);
            //$i = 0;
            //foreach ($Search->list as $s) {
                //print $s->level_mood . "<br>";
                //if ($s->level_mood == 1) {
                  //  print "s";
                    
                //}
                //$i++;
            //}
            //print "<br>";
            //print $i;
            /*
            var_dump ($Search->arrayList);
            for ($i=0;$i < count($Mood->arrayList);$i++) {
                print $Mood->arrayList[$i]["date_start"];
            }
             * 
             */
            
            return View("Search.action")->with("list",$Search->arrayList)
                    ->with("paginate",$Search->list)
                    ->with("percent",$Search->listPercent)
                    ->with("count",count($Search->list));
            //print ("<pre>");
            //print_r($Search->qestion);
        }
        
    }
    public function savePDF() {
        //PDF::setOptions(['dpi' => 150, 'defaultFont' => 'pdfBackend']);
        $Search = new Search;
        //$html = iconv('UTF-8','Windows-1250',"ążćźół");
        //$html = "żżźżźąśœęłð„źfcb";
        $Search->selectPDF(Input::get("date_start"),Input::get("date_end"),Input::get("whatWork"),Input::get("drugs"));
        $Search->sortMoods(Input::get("whatWork"),true);
        //print count($Search->list);
        //var_dump($Search->arrayList);
        //$text = iconv('utf-8','iso-8859-2',$Search->arrayList);
        $pdf = PDF::loadView('PDF.File',['list' => $Search->arrayList]);
        //$pdf = PDF::loadView('PDF.File',['list' => $html]);
        //$pdf->AddFont('arial_ce','','arial_ce.php');

        //$pdf->AddPage();

        //$pdf->SetFont('arial_ce','',35);
        //$text = iconv('utf-8','iso-8859-2',$text);
        return $pdf->download("moods_" . Input::get("date_start") . " - " .  Input::get("date_end") . ".pdf");
        //return $pdf->stream();
    }
    
    public function searchAI() {
        $AI = new AI;
        //print "jano";
        //$AI->selectDays
        //$list = $AI->selectAverageMood(Input::get("hourFrom"), Input::get("hourTo"), Input::get("yearFrom") . "-" . Input::get("monthFrom")  . "-" . Input::get("dayFrom"),  Input::get("yearTo") . "-" . Input::get("monthTo")  . "-" . Input::get("dayTo"),Input::get("type"),Input::get("day"));
        $list = $AI->selectDays(Input::get("hourFrom"), Input::get("hourTo"), 
                Input::get("yearFrom") . "-" . Input::get("monthFrom")  . "-" . Input::get("dayFrom"), 
                Input::get("yearTo") . "-" . Input::get("monthTo")  . "-" . Input::get("dayTo"),
                Input::get("type"),Input::get("day"));
        return View("Ajax.showAverage")->with("days",$AI->days)->with("list",$list)->with("day",Input::get("day"));
       /*
        //$b = $AI->sumAverage([[1,-1,1],[1,2,1],[1,3,1],[1,3,1],[1,5,1]]);
        //print count($a);
        //print Input::get("day");
        
        $average = $AI->sumAverage($AI->arrayAI);
        //print_r($average);
        
        //print ("<pre>");
        //print_r ($average);
        //$c = $AI->sortMood($b);
        
        if (Input::get("day") == "on") {
            $hour = $AI->selectHour(Input::get("hourFrom"),Input::get("hourTo"));
            //var_dump($hour);
            //return View("Search.AI")->with("hour",$hour)
              // ->with("list",$average)
               // ->with("type","hour");
            
        }
        else {
            $day = $AI->selectday(Input::get("yearFrom") . "-" . Input::get("monthFrom")  . "-" . Input::get("dayFrom"),Input::get("yearTo") . "-" . Input::get("monthTo")  . "-" . Input::get("dayTo"));
            //return View("Search.AI")->with("day",$day)
              //  ->with("list",$average)
                //->with("type","day");
        }
        
       
        
         
         * 
         */
      

        //print ("<pre>");
        //print_r($b);
        //print $c;
    }
}