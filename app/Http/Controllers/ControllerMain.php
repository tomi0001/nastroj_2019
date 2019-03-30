<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App\Http\Services\calendar as Calendar;
use App\Http\Services\mood as Mood;
class ControllerMain extends BaseController
{
    public function Main($year = "",$month = "",$day = "",$action = "") {
        //$response = $this->get('/');

        //$response->assertStatus(200);
        if ( (Auth::check()) ) {
            
            $kalendar = new Calendar();
            $Moods = new Mood;
            //$Moods->d();
            $kalendar->set_date($month,$action,$day,$year);
            //$Drugs = new Drugs;
            $timeLast  = $Moods->selectHourLastMoods(Auth::User()->id);
            $timeSleep = $Moods->selectHourSleep(Auth::User()->id);
            $listMoods = $Moods->downloadMoods(Auth::User()->id,$kalendar->year,$kalendar->month,$kalendar->day);
            //print("<pre>");
            //print_r ($listMoods);
            
            $listSleep = $Moods->downloadSleep(Auth::User()->id,$kalendar->year,$kalendar->month,$kalendar->day);
            $Moods->sortMoodsSleep($listMoods,$listSleep);
            $Moods->sumColorForMood(Auth::User()->id,$kalendar->year,$kalendar->month);
            if (count($listMoods) != 0) {
                $Moods->sumColorForMood(Auth::User()->id,$kalendar->year,$kalendar->month,$kalendar->day);
            }
            $how_day_month = $kalendar->check_month($kalendar->month,$kalendar->year);
            $back_month = $kalendar->return_back_month($kalendar->month,$kalendar->year);
            $next_month = $kalendar->return_next_month($kalendar->month,$kalendar->year);
            $text_month = $kalendar->return_month_text($kalendar->month);
            $next_year  = $kalendar->return_next_year($kalendar->year);
            $back_year  = $kalendar->return_back_year($kalendar->year);
            
            return View("Main.Main") ->with("month",$kalendar->month)
                    ->with("year",$kalendar->year)
                    ->with("day",$kalendar->day)
                    ->with("action",$kalendar->action)
                    ->with("how_day_month",$how_day_month)
                    ->with("back",$back_month)
                    ->with("next",$next_month)
                    ->with("back_year",$back_year)
                    ->with("next_year",$next_year)
                    ->with("text_month",$text_month)
                    ->with("day2",1)
                    ->with("day1",1)
                    ->with("date_mood",$timeLast[0])
                    ->with("time_mood",$timeLast[1])
                    ->with("date_mood2",date("Y-m-d"))
                    ->with("time_mood2",date("H:i"))
                    ->with("date_sleep",$timeSleep[0])
                    ->with("time_sleep",$timeSleep[1])
                    ->with("day3",$kalendar->day)
                    ->with("listMood",$Moods->arrayList)
                    ->with("count",count($Moods->arrayList))
                    ->with("listPercent",$Moods->listPercent)
                    ->with("colorForDay",$Moods->colorForDay)
                    ->with("colorDay",$Moods->colorDay)
                    //->with("color",[-1,0,-2,0,-3,0,-4,0,-5,0,-6,0,-7,0,-8,0,-9,0,-10,0,-4,0,0,0,0,0,-5,0,0,0,-6])
//                    ->with("color",[-1,-2,-3,-4,-5,-6,0,1,2,3,4,5,6,7,8,9,10,-7,-8,-9,-10,1,null,1,1,1,1,1,1,1,1,1])
                    //->with("color",[null,null,null,null,0,1,-4,5,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,])
                    ->with("color",$Moods->color)
                    ->with("day_week",$kalendar->day_week);
        }
        else {
            return Redirect("/User/Login")->with("error","Wylogowałeś się");
        }
    }
    
}