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
use App\Drug as Drug;
use App\Http\Services\mood as Mood;
use App\Forwarding_drug as Forwarding_drug;
//class User
class drugs  {
    public $arrayDrugsId = [];
    public function checkDrugs($name,$dose,$date,$time) {
        for ($i = 0;$i < count($name);$i++) {
            if ($name[$i] == "") {
                array_push($this->errors, "Musisz uzupełnić nazwę któregoś z leków");
            }
            if (!is_numeric($dose[$i])) {
                array_push($this->errors, "Dawka leku musi być liczbą");
            }
            $this->checkDate($date[$i] . " " . $time[$i] . ":00");
            
        }
    }
    public function addDrugs($name,$dose,$date,$type) {
        $Drug = new Drug;
        $Drug->name = $name;
        $Drug->dose = $dose;
        $Drug->date = $date;
        $Drug->id_users = Auth::User()->id;
        $Drug->type = $type;
        $Drug->save();
        $id = $Drug->orderBy("id","DESC")->first();
        array_push($this->arrayDrugsId, $id->id);
    }
    public function addForwardingDrugs() {
        
        for ($i=0;$i < count($this->arrayDrugsId);$i++) {
            $Forwarding = new Forwarding_drug;
            $Forwarding->id_drugs = $this->arrayDrugsId[$i];
            $Forwarding->id_mood = $this->idMood;
            $Forwarding->save();
            
        }
        
    }
    private function checkDate($date) {
        //print "s";
        //$Mood = new Mood;
        if ($this->second1 != "" and $this->second2 != "") {
            $intDate = strtotime($date);
            if ($intDate < $this->second1 or $intDate > $this->second2) {
                array_push($this->errors, "Godzina leku nie nakłada się na godziny nastroju");
            }
        }
    }
}