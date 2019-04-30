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
use App\Http\Services\drugs as Drugs;
use App\Http\Services\common as Common;
use App\Http\Services\calendar as kalendar;

//class User
class mood extends Drugs {
    public $errors = [];
    public $second1;
    public $second2;
    public $idMood;
    public $level = [];
    public $startDay;
    public $dateStart;
    public $hourStart;
    public $hourEnd;
    public $dateEnd;
    public $dateStartHour;
    public $dateEndHour;
    public $listPercent = [];
    public $arrayList  = [];
    public $listMood = [];
    public $colorForMonth = [];
    public $color = [];
    public $colorForDay = [];
    public $colorDay = [];
    public function selectHourLastMoods(int $idUsers) {
        $Moods = new Moods;

                
        $time = $Moods->where("id_users",$idUsers)
                ->orderBy("date_end","DESC")->first();
        if ($time == "") {
            return [date("Y-m-d"),date("H:i")];
        }
        else {
            $second = strtotime($time->date_end);
            $second += 60;
            return [date("Y-m-d",$second),date("H:i",$second)];
        }
    }
    public function sumColorForMood($idUsers,$year,$month,$day = null) {
        $kalendar = new kalendar;
        $howDay = $kalendar->check_month($month,$year);
        //print "t";
        //print ;
   
        if ($day != null) {
            $this->colorForDay = $this->downloadMood($idUsers,$year,$month,$day);
            $this->colorDay["mood"] = $this->setColor($this->colorForDay);
            $this->colorDay["anxiety"] = -$this->setColor($this->colorForDay,"anxiety");
            $this->colorDay["nervousness"] = -$this->setColor($this->colorForDay,"nervousness");
            $this->colorDay["stimulation"] = $this->setColor($this->colorForDay,"stimulation");
            //$this->color[$i] = $this->setColor($this->colorForMonth[$i]);
        }
        else {
            for ($i=0;$i < $howDay;$i++) {
                //print "t";
                //if ($day == $i+1)
                $this->colorForMonth[$i] = $this->downloadMood($idUsers,$year,$month,$i+1);
                $this->color[$i] = $this->setColor($this->colorForMonth[$i]);
                //print $this->colorForMonth[$i][0]["mood"];
                //$tmp = $this->colorForMonth[$i];
                //print count($this->colorForMonth[$i]) . "<br>";
                //var_dump( $tmp);
                //print "s";

            }
        }
        //var_dump($this->colorForMonth);
    }
    /*
    public function d() {
        //$array = [ [1000, 50, 30, -3000, 800, -300, 200,0,100],[300,80,500,600,700,800,-100,-700,0],[300,4000,5000,60,7000,800,-1000,-7000,0],[3000,4000,500,6000,7000,800,-100,-70,0],[3000000,4000,5000,6000,7000,8000,-1000,-70,0],[3000000,4000,500,6000,7000,80,-100,-700000,999990]];
        $array = [ [1000, 50],[-100,-700],[-7000,0],[-70,0],[-70,0],[-700000,999990]];
        /*
         * 
         * 
         * 2
         * -1
         * 4
         * 
         * 
         * 
         * 1
         * 1
         * 4
         * 
         * 3
         * 2
         * 4
         * 
         * -4
         * 6
         * 4
         * 2 + 1  =3
         * 
         *          0
         *          1
         *          2
         *          -10
         * 
         * 
         
        $array2 =[];
        $tmp = 0;
        for ($i=0;$i < count($array);$i++) {
            for ($j = 0;$j < count($array[0]);$j++) {
                for ($z=0;$z < count($array[0]);$z++) {
                    //for ($x = 0;$x < count($array[0]);$x++) {
                        
                        
                    
                    if ($z <= count($array)+1 ) {
                        //$array2[$i][$j][$z] = 1;
                        
                        //$array2[$i][$j][$z] = 1 - $z;
                        //if ($array2[$i][$j][$z] == null) {
                          //  $array2[$i][$j][$z] = 0;
                        //}
                        //else {
                            $tmp = $tmp + ( $array[$i][$z] - $array[$i][$z+1]);
                            //$array2[$i][$j][$z] += $array[$i][0] - $array[$i][$j+1];
                        //}
                    }
                    //else {
                  
                    //}
                //}
                $array2[$i][$j][$z] = $tmp;    
                    $tmp = 0;
                }
                  
            }
            print "s<br>";
        }
        print ("<pre>");
        
        print_r($array2);
        //$a = [0,1,2,3],[0,1,1,1];
    }
     * 
     */
    private function setColor($array,$type = "mood") {
        //return null;
        if (empty($array)) {
            return null;
        }
        if ($array[$type] >= -20  and  $array[$type] < -16) {
            return -10;
        }
        if ($array[$type] >= -16  and  $array[$type] < -11) {
            return -9;
        }
        if ($array[$type] >= -11  and  $array[$type] < -7) {
            return -8;
        }
        if ($array[$type] >= -7  and  $array[$type] < -2) {
            return -7;
        }
        if ($array[$type] >= -2  and  $array[$type] < -1) {
            return -6;
        }
        if ($array[$type] >= -1  and  $array[$type] < -0.5) {
            return -5;
        }
        if ($array[$type] >= -0.5  and  $array[$type] < -0.2) {
            return -4;
        }
        if ($array[$type] >= -0.2  and  $array[$type] < -0.1) {
            return -3;
        }
        if ($array[$type] >= -0.1  and  $array[$type] < -0.05) {
            return -2;
        }
        if ($array[$type] >= -0.05  and  $array[$type] < 0) {
            return -1;
        }
        if ($array[$type] >= 0  and  $array[$type] < 0.03) {
            return 0;
        }
        if ($array[$type] >= 0.03  and  $array[$type] < 0.07) {
            return 1;
        }
        if ($array[$type] >= 0.07  and  $array[$type] < 0.1) {
            return 2;
        }
        if ($array[$type] >= 0.1  and  $array[$type] < 0.2) {
            return 3;
        }
        if ($array[$type] >= 0.2  and  $array[$type] < 0.5) {
            return 4;
        }
        if ($array[$type] >= 0.5  and  $array[$type] < 1) {
            return 5;
        }
        if ($array[$type] >= 1  and  $array[$type] < 3) {
            return 6;
        }
        if ($array[$type] >= 3  and  $array[$type] < 8) {
            return 7;
        }
        if ($array[$type] >= 8  and  $array[$type] < 12) {
            return 8;
        }
        if ($array[$type] >= 12  and  $array[$type] < 16) {
            return 9;
        }
        if ($array[$type] >= 16  and  $array[$type] <= 20) {
            return 10;
        }
    
        
        
        
        //if ($array[$type] >= - 0.01 and  $array[$type] < )
    }
    /*
    private function colorForDay($year,$month,$day) {
        $this->setHourMood($year,$month,$day,true);
    }
     * 
     */
    public function sortMoodsSleep($listMoods,$listSleep,$whatWork,$bool = false) :bool {
        $Common = new Common;
        $arraySecond = [];
        $i = 0;
        foreach ($listMoods as $Moodss) {
            
            //$this->arrayList[$i]["date_start_second"] = strtotime($Moodss->date_start);
            $this->arrayList[$i]["date_start"] = $Moodss->date_start;
            $this->arrayList[$i]["date_end"] = $Moodss->date_end;
            $this->arrayList[$i]["second"] = strtotime($Moodss->date_end) - strtotime($Moodss->date_start);
            $arraySecond[$i] = $this->arrayList[$i]["second"];
            $this->arrayList[$i]["level_mood"] = $Moodss->level_mood;
            $this->arrayList[$i]["level_anxiety"] = $Moodss->level_anxiety;
            $this->arrayList[$i]["level_nervousness"] = $Moodss->level_nervousness;
            $this->arrayList[$i]["level_stimulation"] = $Moodss->level_stimulation;
            $this->arrayList[$i]["nas"] = $Moodss->nas;
            $this->arrayList[$i]["nas2"] = $Moodss->nas2;
            $this->arrayList[$i]["nas3"] = $Moodss->nas3;
            $this->arrayList[$i]["nas4"] = $Moodss->nas4;
            $this->arrayList[$i]["color_nas"] = $this->setColor(array("mood"=>$Moodss->nas));
            $this->arrayList[$i]["color_mood"] = $this->setColor(array("mood"=>$this->arrayList[$i]["level_mood"]));
            $this->arrayList[$i]["color_anxiety"] = -$this->setColor(array("mood"=>$this->arrayList[$i]["level_mood"],"anxiety"));
            $this->arrayList[$i]["color_nervousness"] = -$this->setColor(array("mood"=>$this->arrayList[$i]["level_mood"],"nervousness"));
            $this->arrayList[$i]["color_stimulation"] = $this->setColor(array("mood"=>$this->arrayList[$i]["level_mood"],"stimulation"));
            $this->arrayList[$i]["drugs"] = $Moodss->drugs;
            if ($whatWork == "on") {
                $this->arrayList[$i]["what_work"] = $Common->charset_utf_fix($Moodss->what_work,true);
                
            }
            else if ($Moodss->what_work != "" and $whatWork == "off") {
                $this->arrayList[$i]["what_work"] = true;
            }
            /*
            else if ($whatWork == "on") {
                
                    $this->arrayList[$i]["what_work"] = $Common->charset_utf_fix($Moodss->what_work,true);
                
          
            }
             * 
             */
            else {
                $this->arrayList[$i]["what_work"] = false;
            }

            
            $this->arrayList[$i]["epizodes_psychotik"] = $Moodss->epizodes_psychotik;
            $this->arrayList[$i]["type"] = 1;
            $this->arrayList[$i]["percent"] = 0;
            $this->arrayList[$i]["id"] = $Moodss->id;
            //if ($bool == false) {
                   $this->arrayList[$i]["year"] = $Moodss->year;
                   $this->arrayList[$i]["month"] = $Moodss->month;
                   $this->arrayList[$i]["day"] = $Moodss->day;
                   $this->arrayList[$i]["dat"] = $Moodss->dat;
            //}
            //$arrayList[$i][""] = 1;
            $i++;
        }
        foreach ($listSleep as $Sleeps) {
            
            //$this->arrayList[$i]["date_start_second"] = strtotime($Sleeps->date_start);
            $this->arrayList[$i]["date_start"] = $Sleeps->date_start;
            $this->arrayList[$i]["date_end"] = $Sleeps->date_end;
            $this->arrayList[$i]["second"] = strtotime($Sleeps->date_end) - strtotime($Sleeps->date_start);
            $arraySecond[$i] = $this->arrayList[$i]["second"];
            $this->arrayList[$i]["epizodes_psychotik"] = $Sleeps->how_wake_up;
            $this->arrayList[$i]["type"] = 0;
            $this->arrayList[$i]["percent"] = 0;
            $this->arrayList[$i]["level_mood"] = 0;
            $this->arrayList[$i]["level_anxiety"] = 0;
            $this->arrayList[$i]["level_nervousness"] = 0;
            $this->arrayList[$i]["level_stimulation"] = 0;
            $this->arrayList[$i]["nas"] = $Sleeps->nas;
            $this->arrayList[$i]["nas2"] = $Sleeps->nas2;
            $this->arrayList[$i]["nas3"] = $Sleeps->nas3;
            $this->arrayList[$i]["nas4"] = $Sleeps->nas4;
            $this->arrayList[$i]["color_nas"] = $this->setColor(array("mood"=>$Sleeps->nas));
            $this->arrayList[$i]["color_mood"] = 0;
            $this->arrayList[$i]["color_anxiety"] = 0;
            $this->arrayList[$i]["color_nervousness"] = 0;
            $this->arrayList[$i]["color_stimulation"] = 0;
            $this->arrayList[$i]["what_work"] = false;
            $this->arrayList[$i]["drugs"] = 0;
            $this->arrayList[$i]["id"] = $Sleeps->id;
            //if ($bool == false) {
                   $this->arrayList[$i]["year"] = $Sleeps->year;
                   $this->arrayList[$i]["month"] = $Sleeps->month;
                   $this->arrayList[$i]["day"] = $Sleeps->day;
                   $this->arrayList[$i]["dat"] = $Sleeps->dat;
            //}
            $i++;
        }
        //print "a";
        //$array = $arrayList;
        //var_dump($arraySecond);
        //print $i;
        if ($i != 0) {
            
            array_multisort($arraySecond,SORT_ASC);
            if ($bool == true) {
                array_multisort($this->arrayList,SORT_ASC);
            }
            $longSecond = count($arraySecond);
            $this->listPercent = $this->sumPercent($arraySecond[$longSecond-1],$this->arrayList);
            return true;
        }
        return false;
        //`var_dump($arrayList);
        //print ("<pre>");
        //print_r ($list);
        //var_dump($arrayList);
        
    }
    public function sumPercent(int $second,array $list) {
        for ($i=0;$i < count($list);$i++) {
            $list[$i]["percent"] = round(($list[$i]["second"] / $second) * 100);
            if ($list[$i]["percent"] == 0) {
                $list[$i]["percent"] = 1;
            }
            $list[$i]["second"] = $this->changeSecondAtHour($list[$i]["second"] / 3600);
            
        }
        return $list;
    }
    private function changeSecondAtHour($hour) {
        if (strstr($hour,".")) {
            $div = explode(".",$hour);
            if ($div[0] == 0) {
                $min = "0." . $div[1];
                $min *= 60;
                return round($min) . " minut";
            }
            else {
                $hour = $div[0] . " Godzin i ";
                $min = "0." . $div[1];
                $min *= 60;
                return $hour . round($min) . " minut";
            }
        }
        return $hour . " Godzin";
        
    }
    public function selectDescription($id) {
        $Moods = new Moods;
        $idUsers = Auth::User()->id;
        $Common = new Common;
        
        $description = $Moods->where("id_users",$idUsers)
                ->where("id",$id)
                ->first();
        
        return $Common->charset_utf_fix($description->what_work,true);
    }
    public function updateDescription($id,$description) {
        $Moods = new Moods;
        $Common = new Common;
        $description = $Common->charset_utf_fix2($description);
        $idUsers = Auth::User()->id;
        $description2 = $Moods->where("id_users",$idUsers)
                ->where("id",$id)
                ->update(['what_work'=>$description]);
    }
    public function downloadMood(int $idUsers,$year,$month,$day) {
        $Moods = new Moods;
        $this->initStartDay();
        //$this->addSleep();
        $arrayHour = $this->setHourMood($year,$month,$day,true);
        //print $this->dateStart;
      //  $date = $year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00";
        $listMood = $Moods
                
                
                ->select("level_mood")
                ->select("level_anxiety")
                //->selectRaw("forwarding_drugs.id_drugs as drugs")   
                ->select("level_nervousness")
                ->select("level_stimulation")
                ->selectRaw("(unix_timestamp(date_end)  - unix_timestamp(date_start)) as division")
                ->selectRaw(" ((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_mood) as average_mood")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_anxiety) as average_anxiety")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_nervousness) as average_nervousness")
                ->selectRaw("((unix_timestamp(date_end)  - unix_timestamp(date_start)) * level_stimulation) as average_stimulation")
                ->where("moods.date_start",">=",$arrayHour[0])
                ->where("moods.date_start","<",$arrayHour[1])
                ->where("moods.id_users",$idUsers)
                ->get();
        $array = $this->selectAverageMoods($listMood);
        return $array;
        //var_dump($list);
    }
    private function selectAverageMoods($listMood) {
        $array = [];
        $i = 0;
        $mood = 0;
        $anxiety = 0;
        $nervousness = 0;
        $stimulation = 0;
        $division = 0;
        foreach ($listMood as $list) {
            $mood += $list->average_mood;
            $anxiety += $list->average_anxiety;
            $nervousness += $list->average_nervousness;
            $stimulation += $list->average_stimulation;
            $division += $list->division;
            $i++;
        }
        if ($i == 0) {
            return;
        }
        $array["mood"] = round($mood   / $division,2);
        $array["anxiety"] = round($anxiety / $division,2);
        $array["nervousness"]  = round($nervousness / $division,2);
        $array["stimulation"] = round($stimulation / $division,2);
        return $array;
    }
    public function downloadMoods(int $idUsers,$year,$month,$day) {
        $Moods = new Moods;
        $this->initStartDay();
        //$this->addSleep();
        $this->setHourMood($year,$month,$day);
        //print $this->dateStart;
      //  $date = $year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00";
        $this->listMood = $Moods->leftjoin("forwarding_drugs","moods.id","forwarding_drugs.id_mood")
                ->selectRaw("moods.id as id")
                ->selectRaw("forwarding_drugs.id_mood as drugs")
                ->selectRaw("moods.date_start as date_start")
                ->selectRaw("moods.date_end as date_end")
                ->selectRaw("moods.level_mood as level_mood")
                ->selectRaw("moods.level_anxiety as level_anxiety")
                ->selectRaw("moods.level_nervousness as level_nervousness")
                ->selectRaw("moods.level_stimulation  as level_stimulation")
                ->selectRaw("moods.epizodes_psychotik as epizodes_psychotik")
                ->selectRaw("moods.what_work  as what_work ")
                //->selectRaw("moods.id as id")
                
                ->where("moods.id_users",$idUsers)
                ->where("moods.date_start",">=",$this->dateStart)
                ->where("moods.date_start","<",$this->dateEnd)
                ->get();
        //print ("<pre>");
        //print_r ($this->listMood);
        return $this->listMood;
        //var_dump($list);
    }
    public function downloadSleep(int $idUsers,$year,$month,$day) {
        $Sleep = new Sleep;
        //$this->setHour($year,$month,$day);
        $this->setHourSleep($year,$month,$day);
        //print $this->dateStartHour;
        //print $this->dateEndHour;
        $list = $Sleep
                ->where("id_users",$idUsers)
                ->where("date_start",">=",$this->dateStartHour)
                ->where("date_start","<",$this->dateEndHour)
                //->where("date_end",">=", $this->)
                ->get();
        return $list;
    }
    public function selectSleep(int $idUsers,$dateStart,$dateEnd,$bool = false) {
        $Sleep = Sleep::query();
        $hour = Auth::User()->start_day;
        $Sleep->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))
                ->selectRaw("date_start as date_start")
                ->selectRaw("date_end as date_end")
                ->selectRaw("how_wake_up as how_wake_up")
                ->where("id_users",$idUsers);
                if ($dateStart != "") {
                    $Sleep->where("date_start",">=",$dateStart);
                }
                if ($dateEnd != "") {
                    $Sleep->where("date_start","<",$dateEnd);
                }
                //if ($bool == true) {
                  //  $list_sleep =    $Sleep->get();
                  //  return $list_sleep;
                //}
                //else {
                    $list =    $Sleep->get();
                    return $list;
                //}
            
        
        
    }
    private function setHourSleep($year,$month,$day) {
        $second = strtotime($year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00");
        $second2 = $second -  (3600 * 9);
        $second3 = $second + (3600 * 24);
        $this->dateStartHour = date("Y-m-d H:i:s",$second2);
        $this->dateEndHour = date("Y-m-d H:i:s",$second3);
                
    }
    private function setHourMood($year,$month,$day,$bool = false) {
        $second = strtotime($year . "-" . $month . "-" . $day . " " . $this->startDay . ":00:00");
        
        $second2 = $second + (3600 * 24);
        if ($bool == false) {
            $this->dateStart = date("Y-m-d H:i:s",$second);
            $this->dateEnd = date("Y-m-d H:i:s",$second2);
        }
        else {
            return [date("Y-m-d H:i:s",$second),date("Y-m-d H:i:s",$second2)];
        }
    }
    public function initStartDay() {
        $this->startDay = Auth::User()->start_day;
        if ($this->startDay == "") {
            $this->startDay = 0;
        }
    }
    public function selectHourSleep(int $idUsers) {
        $dateSleep = time() - 28800;
        return [date("Y-m-d",$dateSleep),date("H:i",$dateSleep)];
    }
    public function checkFieldMood() {
        //$Drugs = new Drugs;
        //for ($i = 0;$i < 4;$i++) {
        $this->checkLevel(Input::get("mood"),"poziom nastroju");
        $this->checkLevel(Input::get("anxienty"),"poziom lęku");
        $this->checkLevel(Input::get("nervousness"),"poziom zdenerowania");
        $this->checkLevel(Input::get("stimulation"),"poziom pobudzenia");
        $this->checkPsychotic(Input::get("psychotic"));
        
        //}
        //print count(Input::get("name"));
        if (Input::get("start_mood_time") == "" or Input::get("start_mood_date") == "") {
            array_push($this->errors, "Uzupełnij godzine zaczęcia");    
        }
        if (Input::get("end_mood_time") == "" or Input::get("end_mood_date") == "") {
            array_push($this->errors, "Uzupełnij godzine skończenia");
        }
        else {
            $this->checkHour(Input::get("start_mood_date") . " " . Input::get("start_mood_time") . ":00",
                    Input::get("end_mood_date") . " " . Input::get("end_mood_time") . ":00");
        }
        //if (isset(Input::get("name"))) {
            $this->checkDrugs(Input::get("name"),Input::get("dose"),Input::get("date"),Input::get('time'));
        //}
    }
    public function checkFieldSleep() {
        if (Input::get("start_sleep_time") == "" or Input::get("start_sleep_date") == "") {
            array_push($this->errors, "Uzupełnij godzine zaczęcia");    
        }
        if (Input::get("end_sleep_time") == "" or Input::get("end_sleep_date") == "") {
            array_push($this->errors, "Uzupełnij godzine skończenia");
        }
        if (Input::get("wake_up") != "" and ((int) Input::get("wake_up") != Input::get("wake_up") or Input::get("wake_up") <= 0 )) {
            array_push($this->errors, "Pole ilośc wybudzeń musi być liczbą całkowita i większą od 0");
        }
        else {
            $this->checkHour(Input::get("start_sleep_date") . " " . Input::get("start_sleep_time") . ":00",
                    Input::get("end_sleep_date") . " " . Input::get("end_sleep_time") . ":00","Sen");
        }
    }

    public function addMood() {
        $Moods = new Moods;
        $Common = new Common;
        $Moods->date_start = Input::get("start_mood_date") . " " . Input::get("start_mood_time") . ":00";
        $Moods->date_end = Input::get("end_mood_date") . " " . Input::get("end_mood_time") . ":00";
        $Moods->id_users = Auth::User()->id;
        $Moods->level_mood = $this->level[0];
        $Moods->level_anxiety = $this->level[1];
        $Moods->level_nervousness = $this->level[2];
        $Moods->level_stimulation = $this->level[3];
        $Moods->epizodes_psychotik = Input::get("psychotic");
        $Moods->what_work = $Common->charset_utf_fix2(Input::get("what_work"));
        $Moods->save();
        $id = $Moods->orderBy("id","DESC")->first();
        $this->idMood = $id->id;
        //$this->addDrugs($name, $dose, $date, $type)
        for ($i=0;$i < count(Input::get("name"));$i++) {
            
            $this->addDrugs(Input::get("name")[$i],Input::get("dose")[$i],
                    Input::get("date")[$i]  . " " . Input::get("time")[$i] . ":00",Input::get("type")[$i]);
        }
        $this->addForwardingDrugs();
    }
    public function addSleep() {
        $Sleep = new Sleep;
        $Sleep->date_start = Input::get("start_sleep_date") . " " . Input::get("start_sleep_time") . ":00";
        $Sleep->date_end = Input::get("end_sleep_date") . " " . Input::get("end_sleep_time") . ":00";
        //$Sleep->date_start = "2300-06-07 12:00:00";
        //$Sleep->date_end = "2300-06-07 12:00:00";
        $Sleep->id_users = Auth::User()->id;
        //$Sleep->id_users = 1;
        $Sleep->how_wake_up = Input::get("wake_up");
        $Sleep->save();
    }
    private function checkPsychotic($psychotic) {
        if ($psychotic == "") {
            return;
        }
        else if((int) $psychotic != $psychotic) {
            array_push($this->errors, "Ilość epizodów psychotycznych musi być liczbą całkowitą");
        }
        else if ($psychotic < 0) {
            array_push($this->errors, "Ilość epizodów psychotycznych musi być liczbą większa od 0");
        }
    }
    //private function checkDose($dose) {
      //  if (!is_numeric($level)) {
        //    array_push($this->errors, $what . " nie jest liczbą");
        //}
    //}
    private function checkLevel($level,string $what) {
        if ($level == "") {
            //$this->levelmood = 0;
            array_push($this->level, 0);
            return;
        }
        if (!is_numeric($level)) {
            array_push($this->errors, $what . " nie jest liczbą");
        }
        else if ($level > 20 or $level < -20) {
            array_push($this->errors, $what . " musi się mieścić w przedziele od -20 do +20");
        }
        else {
            array_push($this->level, $level);
        }
    }
    public function checkHourMood($dateStart,$dateEnd) {
        $Moods = new Moods;
        $Sleep = new Sleep;
        $checkMood = $Moods->where("date_end",">=",$dateStart)
                ->where("date_start","<=",$dateEnd)->first();
        $checkSleep = $Sleep->where("date_end",">=",$dateStart)
                ->where("date_start","<=",$dateEnd)->first();
        if (empty($checkMood) and empty($checkSleep)) {
            //array_push($this->errors, "Godzina nie znajduje się w przedziale czasowym nastroju");
            return true;
        }
        else {
            return false;
        }
        //$Moods->where("date_start","<=",$dateEnd)
          //      ->orwhere("date_end",">=",$dateEnd)->first();
                
    }
    public function selectHourMood($idMood) {
        $idUsers = Auth::User()->id;
        $Moods = new Moods;
        $check = $Moods->where("id_users",$idUsers)
                        ->where("id",$idMood)->first();
        if (empty($check)) {
            array_push($this->errors, "Wybrałeś błędny nastroj");
            return false;
        }
        else {
            $this->hourStart = $check->date_start;
            $this->hourEnd = $check->date_end;
            return true;
        }
    }
    private function checkHour($dateStart,$dateEnd,$type = "Nastrój") {
        $this->second1 = strtotime($dateStart);
        $this->second2 = strtotime($dateEnd);
        //print $second2;
        //$second = $second2 - $second1;
        if ($this->second1 >= $this->second2) {
            array_push($this->errors, "Godzina zaczęcia jest późniejsza niż godzina skończenia");
        }
        if ($this->second1 > time() or $this->second2 > time()) {
            array_push($this->errors, "$type jest późniejszy niż teraźniejsza data");
        }
        else if (($this->second2 - $this->second1) > 72000) {
            array_push($this->errors, "$type nie może mieć takiego dużego przedziału czasowego");
        }
        if (!$this->checkHourMood($dateStart,$dateEnd)) {
            array_push($this->errors, "Nakładanie się $type");
        }
        
    }
    public function showDescription() {
        $idUsers = Auth::User()->id;
        $Moods = new Moods;
        $Common = new Common;
        $description = $Moods->where("id_users",$idUsers)
                ->where("id",Input::get("id"))
                ->first();
        return $Common->charset_utf_fix($description->what_work);
        
    }
    public function deleteMood() {
        $idUsers = Auth::User()->id;
        $Moods = new Moods;
        $Moods->where("id_users",$idUsers)
                ->where("id",Input::get("id"))
                ->delete();
    }
    public function deleteSleep() {
        //print Input::get("id");
        $idUsers = Auth::User()->id;
        $Sleep = new Sleep;
        $Sleep->where("id_users",$idUsers)
                ->where("id",Input::get("id"))
                ->delete();
    }
    
}