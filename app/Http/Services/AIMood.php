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
class AIMood extends mood {
    public $arrayAI = [];
    public $z = 0;
    public $j = 0;
    public $second = 0;
    public $d = 0;
    public $days = [];
    public function selectDays($hourStart,$hourEnd,$dataStart,$dataEnd,$type,$dayInput = "") {
        $daystart = strtotime($dataStart);
        $dayend = strtotime($dataEnd);
        $days = [];
        $sum = 0;
        $j = 0;
        for ($i = $daystart;$i <= $dayend;$i += 86400 ) {
            $days[$j] = $this->calculateAverage($hourStart,$hourEnd,date("Y-m-d",$i),date("Y-m-d",$i+86400),$type);
            $sum += $days[$j];
            
            $this->days[$j] = date("Y-m-d",$i);
            $j++;
        }
        if ($dayInput == "on") {
            //$this->days = [""];
            if ($j == 0) {
                return 0;
            }
            return [round($sum / $j,2)];
        }
        return $days;
    }
    private function calculateAverage($hourStart,$hourEnd,$dataStart,$dataEnd,$type,$dayInput = "") {
//        $Moods = new Moods;
        $Moods = Moods::query();
        $idUsers = Auth::User()->id;
        $hour = Auth::User()->start_day;
        $average = 0;
        $second = 0;
        $sum = 0;
        //print $hour;
          //      $j = 0;
        //$result2 = [];
        //$result = [];
        //$x = 0;
        //$i = 0;
        //print "jakis";
        if ($hourStart == "" and $hourEnd == "") {
            $hourStart = $hour;
            $hourEnd = $hour;
        }
        else if ($hourStart == "") {
            $hourStart = $hour;
        }
        else if ($hourEnd == "") {
            $hourEnd = $hour;
        }

        $Moods->select(DB::Raw("(DATE(IF(HOUR(date_start) >= '$hour', date_start,Date_add(date_start, INTERVAL - 1 DAY) )) ) as dat  "))
               ->selectRaw("date_start as date_start")
                ->selectRaw("date_end as date_end")
                ->selectRaw("level_anxiety as level_anxiety")
                ->selectRaw("level_nervousness as level_nervousness")
                ->selectRaw("level_stimulation as level_stimulation")
                ->selectRaw("level_mood as level_mood")
                
                      ->where("id_users",$idUsers);
        if ($dataStart != "") {
            $Moods->where("date_start",">=",$dataStart);
            $Moods->where("date_start","<=",$dataEnd);
        }
        //if ($dataEnd != "") {
          //  $Moods->where("date_end","<=",$dataEnd);
        //}
        //if ($hourStart != "") {
            //$Moods->whereRaw("hour(date_start) >= $hourStart ");
           $Moods->whereRaw("(hour(time(date_start)) BETWEEN $hourStart AND $hourEnd or hour(time(date_end)) BETWEEN $hourStart AND $hourEnd or hour(time(date_start)) < '$hourStart' and hour(time(date_end)) > '$hourEnd')");
            
        //}
        //if ($hourEnd != "") {
          //  $Moods->whereRaw("hour(date_end) >= $hourEnd ");
        //}
        $list = $Moods->get();
        foreach ($list as $moodss) {
            $time1 = strtotime($moodss->date_start);
            $time2 = strtotime($moodss->date_end);
             $divi1 = explode(" ",$moodss->date_start);
             $divi2 = explode(" ",$moodss->date_end);
                //$dated1 = strtotime($moodss->date_start);
                //$dated2 = strtotime($moodss->date_end);
                //$dateDiv = $dated2 - $dated1;
                $dateComparate1 = $divi1[0] . " " . $hourStart . ":00:00";
                $dateComparate2 = $divi2[0] . " " . $hourEnd . ":00:00";
                $sumHour = ($dateComparate2 - $dateComparate1);
            //if (($dateComparate1 - $time1) > 0) {
                
            //}
            //if ($moodss->date_start != $moodss->date_start)
            if ($time1 < $dateComparate1) {
                $div = $dateComparate1;
            }
            else {
                $div = $time1;
            }
            if ($time2 < $dateComparate2) {
                $div2 = $dateComparate2;
            }
            else {
                $div2 = $time2;
            }
            //print $moodss->date_start ."  -  " . $moodss->date_end .  "<br>";
            //if ($type=)
               if ($type == "anxiety") {
                    $sum += ($div2 - $div) * $moodss->level_anxiety;
                }
                else if ($type == "nervousness") {
                    $sum += ($div2 - $div) * $moodss->level_nervousness;
                }
                else if ($type == "stimulation") {
                    $sum += ($div2 - $div) *  $moodss->level_stimulation;
                }
                else {
                    $sum += ($div2 - $div) * $moodss->level_mood;
                }
            $second += $div2 - $div;
            
            //print "s";
        }
        if ($second == 0) {
            return 0;
        }
        return round($sum  / $second,2);
        //->orderBy("date_start")
                              //->get();
    }
    
    public function selectDay($start,$end) {
        $second = strtotime($start);
        $second2 = strtotime($end);
        if ($second > $second2) {
            return false;
        }
        $list = [];
        $j = 0;
        for ($i=$second;$i <= $second2;$i+=86400) {
            $list[$j] = date("Y-m-d",$i);
            $j++;
        }
        return $list;
    }
    public function selectHour($start,$end) {
        if ($start > $end) {
            return false;
        }
        else {
            $i = 0;
            $hour = [];
            while ($i <= $end) {
                $hour[$i] = $start + $i;
                $i++;
            }
            return $hour;
        }
    }
    private function selectAverageMood3($hourStart,$hourEnd,$dataStart,$dataEnd,$type,$p) {
        $Moods = new Moods;
        $idUsers = Auth::User()->id;
                $j = 0;
        $result2 = [];
        $result = [];
        $x = 0;
        $i = 0;
       $mood =  $Moods                ->where("id_users",$idUsers)
                              ->where("date_start",">=",$dataStart)
                              ->where("date_end","<=",$dataEnd)
                              //->whereRaw("hour(date_start) = $i ")->get();
                              //->orderBy("date_start")
                              ->whereRaw("(hour(time(date_start)) BETWEEN $hourStart AND $hourEnd or hour(time(date_end)) BETWEEN $hourStart AND $hourEnd or hour(time(date_start)) < '$hourStart' and hour(time(date_end)) > '$hourEnd')")
                              ->get();
        foreach ($mood as $moodss) {
            
            $divi = explode(" ",$moodss->date_start);
                $dated1 = strtotime($moodss->date_start);
                $dated2 = strtotime($moodss->date_end);
                $dateDiv = $dated2 - $dated1;
                $dateComparate = $divi[0] . " " . $hourStart . ":00:00";
                $second = strtotime($dateComparate);
                $second2 = $second + 3600;
                //$datesum = ($second - $dated1) - ($second2 - $dated2);
                if ($dated1 < $second) {
                    $datesum = ($dated2 - $second);
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated2 - $second;
                    //$div = $dateDiv - $div2 - $div1 ;
                    $div =  $dateDiv  - $div2;
                }
                else if ($dated2 > $second2) {
                    $datesum = ($second2 - $dated1);
                    //$div = $datesum;
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated1 - $second;
                    //$div = $div2 + $div1 - $dateDiv;
                    $div = ($dated2 - $dated1) - $div1;
                    
                }
                else {
                    $datesum = ($dated1 - $second );
                    $div = 3600;
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated1 - $second;
                    $div =$dateDiv ;
                }
                //$datesum = ($dated1 - $second ) + ($dated2 - $second2);
                if ($datesum >= 3600) {
                    $datesum = 3600;
                }
                else if ($datesum < 0) {
                    $datesum = -$datesum;
                }
                
                
                
                $second3 = $second2 - $second;
                //$result = $datesum - $second;
                //print $datesum . "<br>";
                //$result2[$x] =  (($datesum) * $moodss->level_mood) / $div;
                if ($type == "anxiety") {
                    $result[$x] = $moodss->level_anxiety * $div;
                }
                else if ($type == "nervousness") {
                    $result[$x] = $moodss->level_nervousness * $div;
                }
                else if ($type == "stimulation") {
                    $result[$x] = $moodss->level_stimulation * $div;
                }
                else {
                    //array_push($this->arrayAI, $moodss->level_mood * $div);
                    if (empty($this->arrayAI[$this->d][$this->j][0])) {
                        $this->arrayAI[$this->d][$this->j][0] = ($moodss->level_mood * $div);
                        $this->arrayAI[$this->d][$this->j][1] = $div;
                    }
                    else {
                        
                        $this->arrayAI[$this->d][$this->j][0] += ($moodss->level_mood * $div);
                        $this->arrayAI[$this->d][$this->j][1] += $div;
                    }
                    //$this->arrayAI[$this->j][2] =+ $div;
                    //$this->arrayAI[$this->j][1] = 
                    $result[$x] = $moodss->level_mood * $div;
                    print $result[$x] .  " " . $div ."<br>";
                }
                
                //$this->second += $div;
                
                //$result2[$x] =   $datesum;
                $x++;
                $j++;
                //$this->j++;
            }
            if (empty($this->arrayAI[$this->j][0])) {
                $this->arrayAI[$this->j][0] = 0;
            }
            if (empty($this->arrayAI[$this->j][1])) {
                $this->arrayAI[$this->j][1] = 0;
            }
            //$this->j++;
            
            
        }
        
    
    
    private function selectAverageMood2($hourStart,$hourEnd,$dataStart,$dataEnd,$type,$p) {
        $Moods = new Moods;
        $idUsers = Auth::User()->id;
        $j = 0;
        $result2 = [];
        $result = [];
        $x = 0;
        $i = 0;
        //for ($i = $hourStart;$i <= $hourEnd;$i++) {
            $mood = $Moods
                              //->selectRaw("(unix_timestamp(date_end) - unix_timestamp(date_start)) as div1")
              
            
                              //->select("level_mood")
                              //->select("date_start")
                              //->select("date_end")
                    //          ->select("level_mood")
                      //        ->select("level_mood")
                        //      ->select("level_mood")
             
                              ->where("id_users",$idUsers)
                              ->where("date_start",">=",$dataStart)
                              ->where("date_end","<=",$dataEnd)
                              //->whereRaw("hour(date_start) = $i ")->get();
             
                              ->whereRaw("(hour(time(date_start)) BETWEEN $hourStart AND $hourEnd or hour(time(date_end)) BETWEEN $hourStart AND $hourEnd or hour(time(date_start)) < '$hourStart' and hour(time(date_end)) > '$hourEnd')")
                              //->orderBy("date_start")
                              ->get();
             
             
            //$x = 0;
            foreach($mood as $moodss) {
                //print "jaki";
                //$result = $moods->div - 3600;
                $divi = explode(" ",$moodss->date_start);
                $dated1 = strtotime($moodss->date_start);
                $dated2 = strtotime($moodss->date_end);
                $dateDiv = $dated2 - $dated1;
                $dateComparate = $divi[0] . " " . $hourStart . ":00:00";
                $second = strtotime($dateComparate);
                $second2 = $second + 3600;
                //$datesum = ($second - $dated1) - ($second2 - $dated2);
                if ($dated1 < $second) {
                    $datesum = ($dated2 - $second);
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated1 - $second;
                    $div =$dateDiv + $div2 - $div1;
                }
                else if ($dated2 > $second2) {
                    $datesum = ($second2 - $dated1);
                    //$div = $datesum;
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated1 - $second;
                    $div =$dateDiv + $div2 - $div1;
                    
                }
                else {
                    $datesum = ($dated1 - $second );
                    $div = 3600;
                    $div1 = $dated2  -  $second2;
                    $div2 = $dated1 - $second;
                    $div =$dateDiv + $div2 - $div1;
                }
                //$datesum = ($dated1 - $second ) + ($dated2 - $second2);
                if ($datesum >= 3600) {
                    $datesum = 3600;
                }
                else if ($datesum < 0) {
                    $datesum = -$datesum;
                }
                
                
                
                $second3 = $second2 - $second;
                //$result = $datesum - $second;
                //print $datesum . "<br>";
                //$result2[$x] =  (($datesum) * $moodss->level_mood) / $div;
                if ($type == "anxiety") {
                    $result[$x] = $moodss->level_anxiety * $div;
                }
                else if ($type == "nervousness") {
                    $result[$x] = $moodss->level_nervousness * $div;
                }
                else if ($type == "stimulation") {
                    $result[$x] = $moodss->level_stimulation * $div;
                }
                else {
                    //array_push($this->arrayAI, $moodss->level_mood * $div);
                    $this->arrayAI[$this->j][] = ($moodss->level_mood * $div);
                    $result[$x] = $moodss->level_mood * $div;
                }
                //$result2[$x] =   $datesum;
                $x++;
            }
            $this->z++;
            $j++;
        //}
            if ($x == 0) {
                return null;
            }
         //print ;
         
         //return $result;             
                
    }
        
    public function sortMood($list) {
        $sort = $list;
        asort($sort);
        $count = count($sort)-1;
        $tmp = 0;
        $tmp2 = 0;
        /*
        $sum = $sort[$count] - $sort[0];
        if ($sum < 0 ) {
            $sum = -$sum;
        }
        if ($sum < 0.1 and $sum <= 1) {
            //$div = ;
        }
        else if ($sum < 1 and $sum <=10) {
            //$div = 
        }
        if ($sum == 0) {
            $sum = 1;
        }
         * 
         */
        for ($i=0;$i < count($sort) / 2;$i++) {
            $tmp = $sort[$count] - $sort[$i];
            $count--;
            if ($tmp < 0) {
                $tmp = -$tmp;
            }
            $tmp2 += $tmp;
        }
        if (count($sort) == 0)  {
            return 0;
        }
        //$max = max()
        
        return ($tmp2 / count($sort));
    }
    public function selectAverageMood($hourStart,$hourEnd,$dataStart,$dataEnd,$type,$dayInput) {
        $second = strtotime($dataStart);
        $second2 = strtotime($dataEnd);
        $j = 0;
        $day = [];
        $tmp = [];
        $z = 0;
        
        $sum = $hourEnd - $hourStart;
        if ($dayInput != "on") {
            $inc = 86400;
        }
        else {
            $inc = 3600;
        }
        //print $inc;
        for ($i=$second;$i < $second2;$i+=$inc) {
            $date = date("Y-m-d H:i:s",$i);
            $date2 = date("Y-m-d H:i:s",$i+$inc);
            //$this->j = 0;
            for ($z = 0;$z <= $sum;$z++) {
                if ($dayInput != "on") {
                    //for ()
                     //$this->selectAverageMood2($hourStart+$z,$hourStart+$z,$date,$date2,$type,$z);
                    $this->selectAverageMood3($hourStart+$z,$hourStart+$z,$date,$date2,$type,$z);
                    
                }
                else {
                    $this->selectAverageMood3($hourStart+$z,$hourStart+$z,$date,$date2,$type,$z);
                     //$this->selectAverageMood2($hourStart+$z,$hourStart+$z,$date,$date2,$type,$z);
                    //$day["day"] = $this->selectAverageMood2($hourStart+$z,$hourStart+$z,$date,$date2,$type);
                }
                
                //if ($tmp == null) {
                     //= 0;
                    //continue;
                //}
                //else {
                //   $day[$z][$j] = $tmp;
                //}
                //if ($this->arrayAI[$this->j][1] == 0) {
                 //   continue;
               // }
                
                //$this->arrayAI[$this->d][$this->j][2] = $this->arrayAI[$this->d][$this->j][0] / 3600;
                                        if (date("Y-m-d",$i) != date("Y-m-d",$i+$inc)   and $i != $second) {
                $this->d++;
            }
            $this->j++;
            }
            
            print "<br><br>";

        }
        return $day;
    }
    public function sumAverage($list) {
        $listNew = [];
        for ($i=0;$i < count($list);$i++) {
            //for ($j=0;$j < count($list[$i]);$j++) {
                //$a[$i] = $this->sortMood($list[$i]);
                //$tmp[$j] = $this->sortMood($list[$j][$i]);
                $listNew[$i] = $this->sortMood($list[$i]) / 25200;
            //}
            //$listNew[$i] = $this->sortMood($tmp);
            //$listNew[$i] = 1;
        }
        return $listNew;
    }
    private function sum($list) {
        $sum = 0;
        for ($i=0;$i < count($list);$i++) {
            $sum += $list[$i];
        }
        return $sum / $i;
    }
    
}