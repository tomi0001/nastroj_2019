<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input as Input;
use Auth;

use Illuminate\Support\Facades\Password as Password;
use Hash;
use DB;
use App\User as Users;
use App\Mood as Moods;
use App\Sleep as Sleep;
use App\Drug as Drug;
use App\Http\Services\mood as Mood;
use App\Forwarding_drug as Forwarding_drug;
//class User
class search  {
    public $qestion;
    public $qestion2;
    public $list;
    public $arrayList;
    public $listPercent;
    public $listMoods;
    public $listSleep;
    //public $listPercent;
    
    private function selectDate() {
        
    }
    public function sortMoods($what,$bool = false) {
        $Mood = new Mood;
        if ($bool == true) {
            //print "s";
            $Mood->sortMoodsSleep($this->list,$this->listSleep,$what,true);
        }
        else if (Input::get("type") == "mood") {
            $Mood->sortMoodsSleep($this->list,[],$what,false);
        }
        else {
            $Mood->sortMoodsSleep([],$this->list,$what,false);
        }
        $this->arrayList = $Mood->arrayList;
        $this->listPercent = $Mood->listPercent;
        $this->selectDate();

       //print $a;
       
       //var_dump($Mood->arrayList);
        //$tmp = $this->list;
        //array_multisort($tmp,SORT_ASC);
        //$longSecond = count($tmp);
        //$this->listPercent = $Mood->sumPercent($tmp[$longSecond-1],$tmp);
    }
    public function selectPDF($dateStart,$dateEnd,$whatWork = true,$drugs = false) {
        $Mood = new Mood;
        $hourStart = explode(":",Auth::User()->start_day);
        //$hour = $hourStart[0];
        $hour = Auth::User()->start_day;
        //print $hour;
        $this->qestion =  Moods::query();
        $this->qestion->select(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat  "));
               // $this->qestion->select(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat  "));
        $this->qestion->selectRaw("hour(date_start) as hour");
        $this->qestion->selectRaw("level_mood as level_mood");
        $this->qestion->selectRaw("level_anxiety as level_anxiety");
        $this->qestion->selectRaw("level_nervousness as level_nervousness");
        $this->qestion->selectRaw("level_stimulation as level_stimulation");
        $this->qestion->selectRaw("epizodes_psychotik as epizodes_psychotik");
        $this->qestion->selectRaw("date_start as date_start");
        $this->qestion->selectRaw("date_end as date_end");
        $this->qestion->selectRaw("what_work as what_work");
        $this->qestion->selectRaw("moods.id as id");
        $this->qestion->selectRaw("forwarding_drugs.id_drugs as drugs");
        
        $this->qestion->selectRaw("year((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as year");
        $this->qestion->selectRaw("month((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as month");
        $this->qestion->selectRaw("day((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as day");
        $this->qestion->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as divi");
        $this->qestion->selectRaw("hour(date_start) as hour");
        $this->qestion->selectRaw("year((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as year");
        $this->qestion->selectRaw("month((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as month");
        $this->qestion->selectRaw("day((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as day");
        $this->qestion->leftjoin("forwarding_drugs","forwarding_drugs.id_mood","moods.id");
        if ($drugs == true) {
            $this->qestion->leftjoin("drugs","drugs.id","forwarding_drugs.id_drugs");
        }
        if ($dateStart != "") {
            $this->qestion->where("date_start",">=",$dateStart);
        }
        if ($dateEnd != "") {
            $this->qestion->where("date_end","<=",$dateEnd);
        }
        $this->qestion->where("moods.id_users",Auth::User()->id);
        $this->list = $this->qestion->get();
        $this->listSleep = $Mood->selectSleep(Auth::User()->id,$dateStart,$dateEnd,true);
    }
    private function setHour() {
        $second1 = 0;
        if (Input::get("hour1") != "") {
            $second1 = (int) Input::get("hour1") * 3600;
        }
        if (Input::get("min1") != "") {
            $second1 += (int) Input::get("min1") * 60;
        }
        $second2 = 0;
        if (Input::get("hour2") != "") {
            $second2 = (int) Input::get("hour2") * 3600;
        }
        if (Input::get("min2") != "") {
            $second2 += (int) Input::get("min2") * 60;
        }
        //if ($second1 == 0)
        return array($second1,$second2);
    }
    public function createQuestion($page) {
        //print $_SERVER["REMOTE_ADDR"];
        
        $hourStart = explode(":",Auth::User()->start_day);
        //$hour = $hourStart[0];
        $hour = Auth::User()->start_day;
        //print $hour;
        $this->qestion =  Moods::query();
        //$Moods;


        
        $this->qestion->select(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) as dat  "));
        $this->qestion->selectRaw("hour(date_start) as hour");
        $this->qestion->selectRaw("level_mood as level_mood");
        $this->qestion->selectRaw("level_anxiety as level_anxiety");
        $this->qestion->selectRaw("level_nervousness as level_nervousness");
        $this->qestion->selectRaw("level_stimulation as level_stimulation");
        $this->qestion->selectRaw("epizodes_psychotik as epizodes_psychotik");
        $this->qestion->selectRaw("date_start as date_start");
        $this->qestion->selectRaw("date_end as date_end");
        $this->qestion->selectRaw("what_work as what_work");
        $this->qestion->selectRaw("moods.id as id");
        $this->qestion->selectRaw("forwarding_drugs.id_drugs as drugs");
        
        $this->qestion->selectRaw("year((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as year");
        $this->qestion->selectRaw("month((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as month");
        $this->qestion->selectRaw("day((DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) )) as day");
        $this->qestion->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as divi");
        $this->qestion->selectRaw("hour(date_start) as hour");
        //$this->qestion->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as second");
        if (Input::get("moodForDay") != "") {
            
            $this->qestion->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) as nas");
            $this->qestion->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas2");
            $this->qestion->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas3");
            $this->qestion->selectRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) as nas4");
        }
        $this->qestion->leftjoin("forwarding_drugs","forwarding_drugs.id_mood","moods.id");
        if (Input::get("drugs") != "") {
            $this->qestion->leftjoin("drugs","drugs.id","forwarding_drugs.id_drugs");
        }
        $this->qestion->where("moods.id_users",Auth::User()->id);
        if (Input::get("moodForDay") != "") {
            $this->setGroup();
        }
        
        else {
            //$this->qestion->where("nas",">=",Input::get("moodFrom"));
            $this->setWhere();
        }
        if (Input::get("drugs") != "") {
            $this->setDrugs();
        }
        $this->setDate();
        $this->sort($page);
        
        //$this->qestion->limit(5);
        
        $this->list = $this->qestion->Paginate(15);
    }
    public function createQuestionForSleep($page) {
        
        $hourStart = explode(":",Auth::User()->start_day);
        //$hour = $hourStart[0];
        $hour = Auth::User()->start_day;
        //print $hour;
        $this->qestion =  Sleep::query();
        //$Moods;


        
        $this->qestion->select(DB::Raw("(DATE(IF(HOUR(sleeps.date_start) >= '$hour', sleeps.date_start,Date_add(sleeps.date_start, INTERVAL - 1 DAY) )) ) as dat  "));
        $this->qestion->selectRaw("hour(date_start) as hour");
        $this->qestion->selectRaw("date_start as date_start");
        $this->qestion->selectRaw("date_end as date_end");

        $this->qestion->selectRaw("sleeps.id as id");

        
        $this->qestion->selectRaw("year((DATE(IF(HOUR(sleeps.date_start) >= '$hour', sleeps.date_start,Date_add(sleeps.date_start, INTERVAL - 1 DAY) )) )) as year");
        $this->qestion->selectRaw("month((DATE(IF(HOUR(sleeps.date_start) >= '$hour', sleeps.date_start,Date_add(sleeps.date_start, INTERVAL - 1 DAY) )) )) as month");
        $this->qestion->selectRaw("day((DATE(IF(HOUR(sleeps.date_start) >= '$hour', sleeps.date_start,Date_add(sleeps.date_start, INTERVAL - 1 DAY) )) )) as day");
        $this->qestion->selectRaw("TIMESTAMPDIFF (SECOND, date_start , date_end) as divi");
        $this->qestion->selectRaw("hour(date_start) as hour");


        $this->qestion->where("sleeps.id_users",Auth::User()->id);

        

            //$this->qestion->where("nas",">=",Input::get("moodFrom"));
            $this->setWhere();


        $this->setDate();
        $this->sort($page);
        
        //$this->qestion->limit(5);
        
        $this->list = $this->qestion->Paginate(15);
        
    }
    private function setDrugs() {
        $this->qestion->where("drugs.name", Input::get("drugs") );
    }
    private function sort($page) {
        if (Input::get("sort") == "date") {
            $this->qestion->orderBy("date_start");
        }
        else if (Input::get("sort") == "hour") {
            $this->qestion->orderBy("hour");
        }
        else if (Input::get("sort") == "mood") {
            $this->qestion->orderBy("level_mood");
        }
        else if (Input::get("sort") == "anxiety") {
            $this->qestion->orderBy("level_anxiety");
        }
        else if (Input::get("sort") == "nervousness") {
            $this->qestion->orderBy("level_nervousness");
        }
        else if (Input::get("sort") == "stimulation") {
            $this->qestion->orderBy("level_stimulation");
        }
        else {
            $this->qestion->orderBy("divi","DESC");
        }
        $this->qestion->offset($page);
    }
    private function setDate() {
        if (Input::get("yearFrom") != "") {
            $this->qestion->whereRaw("year(date_start) >= " . Input::get("yearFrom") );
        }
        if (Input::get("yearTo") != "") {
            $this->qestion->whereRaw("year(date_start) <= " . Input::get("yearTo") );
        }
        if (Input::get("monthFrom") != "") {
            $this->qestion->whereRaw("month(date_start) >= " . Input::get("monthFrom") );
        }
        if (Input::get("monthTo") != "") {
            $this->qestion->whereRaw("month(date_start) <= " . Input::get("monthTo") );
        }
        if (Input::get("dayFrom") != "") {
            $this->qestion->whereRaw("day(date_start) >= " . Input::get("dayFrom") );
        }
        if (Input::get("dayTo") != "") {
            $this->qestion->whereRaw("day(date_start) <= " . Input::get("dayTo") );
        }
        if (Input::get("hourFrom") != "") {
            $this->qestion->whereRaw("hour(date_start) >= " . Input::get("hourFrom") );
        }
        if (Input::get("hourTo") != "") {
            $this->qestion->whereRaw("hour(date_start) <= " . Input::get("hourTo") );
        }

    }
    private function setGroup() {
        $hourStart = explode(":",Auth::User()->start_day);
        //$hour = $hourStart[0];
        $hour = Auth::User()->start_day;
        //$this->qestion->groupBy(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "));
        $this->qestion->groupBy(DB::Raw("(DATE(IF(HOUR(moods.date_start) >= '$hour', moods.date_start,Date_add(moods.date_start, INTERVAL - 1 DAY) )) ) "));
        if (Input::get("moodFrom") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) >= '" . Input::get("moodFrom") . "'");
        }
        if (Input::get("moodTo") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, moods.date_start , moods.date_end)  * moods.level_mood) / "
                   . "sum(TIMESTAMPDIFF(second,moods.date_start,moods.date_end)),2) <= '" . Input::get("moodTo") . "'");
        }
        if (Input::get("anxietyFrom") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >=" . Input::get("anxietyFrom"));
        }
        if (Input::get("anxietyTo") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_anxiety) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . Input::get("anxietyTo"));
        }
        if (Input::get("nervousnessFrom") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >= " .Input::get("nervousnessFrom"));
        }
        if (Input::get("nervousnessTo") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  *  	level_nervousness ) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . Input::get("nervousnessTo"));
        }
        if (Input::get("stimulationFrom") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) >= " . Input::get("stimulationFrom"));
        }
        if (Input::get("stimulationTo") != "") {
            $this->qestion->havingRaw("round(sum(TIMESTAMPDIFF (SECOND, date_start , date_end)  * level_stimulation) / "
                   . "sum(TIMESTAMPDIFF(second,date_start,date_end)),2) <= " . Input::get("stimulationTo"));
        }
        //if (Input::get("moodFrom") != "") {
          //  $this->qestion->having("nas",">=",Input::get("moodFrom"));
        //}
        
    }
    private function setWhere() {
        $second = $this->setHour();
        if (Input::get("moodFrom") != "") {
            $this->qestion->whereRaw("level_mood >=' " . Input::get("moodFrom") . "'");
        }
        if (Input::get("moodTo") != "") {
            $this->qestion->whereRaw("level_mood <='" . Input::get("moodTo") . "'");
        }
        if (Input::get("anxietyFrom") != "") {
            $this->qestion->where("level_anxiety",">=",Input::get("anxietyFrom"));
        }
        if (Input::get("anxietyTo") != "") {
            $this->qestion->where("level_anxiety","<=",Input::get("anxietyTo"));
        }
        if (Input::get("nervousnessFrom") != "") {
            $this->qestion->where("level_nervousness",">=",Input::get("nervousnessFrom"));
        }
        if (Input::get("nervousnessTo") != "") {
            $this->qestion->where("level_nervousness","<=",Input::get("nervousnessTo"));
        }
        if (Input::get("stimulationFrom") != "") {
            $this->qestion->where("level_stimulation",">=",Input::get("stimulationFrom"));
        }
        if (Input::get("stimulationTo") != "") {
            $this->qestion->where("level_stimulation","<=",Input::get("stimulationTo"));
        }
        if (Input::get("what_work") != "") {
            $this->qestion->where("what_work","LIKE","%" . Input::get("what_work") . "%");
        }
        if ($second[0] != 0) {
            $this->qestion->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) >= '" . $second[0] . "'");
        }
        if ($second[1] != 0) {
            $this->qestion->whereRaw("(TIMESTAMPDIFF (SECOND, date_start , date_end)) <= '" . $second[1] . "'");
        }
    }
}