<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App\Http\Services\calendar as Calendar;
use App\Http\Services\mood as Mood;
use App\Http\Services\drugs as Drugs;
use Illuminate\Support\Facades\Input as Input;
class ControllerMood extends BaseController
{
    public function add() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            //$Drugs = new Drugs;
            $Mood->checkFieldMood();
            if (count($Mood->errors) != 0) {
                return View("Ajax.error")->with("error",$Mood->errors);
            }
            else {
                $Mood->addMood();
                return View("Ajax.succes")->with("succes","Poprawnie dodano nastrój");
            }
            
        }
    }
    public function addSleep() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $Mood->checkFieldSleep();
            if (count($Mood->errors) != 0) {
                return View("Ajax.error")->with("error",$Mood->errors);
            }
            else {
                $Mood->addSleep();
                return View("Ajax.succes")->with("succes","Poprawnie dodano sen");
            }
        }
    }
    
    public function showDescription() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $description = $Mood->showDescription();
            return View("Ajax.description")->with("description",$description);
        }
    }
    public function delete() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $Mood->deleteMood();
        }
    }
    public function deleteSleep() {
        if ( (Auth::check()) ) {
            
            $Mood = new Mood;
            $Mood->deleteSleep();
        }
    }
    public function addDescription() {
         if ( (Auth::check()) ) {
             $Mood = new Mood;
             //print "s";
             $description = $Mood->selectDescription(Input::get("id"));
             return View("Ajax.editDescription")->with("description",$description)
                     ->with("idMood",Input::get("id"));
         }
    }
    public function editDescription() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
             //$description = $Mood->selectDescription(Input::get("id"));
             $Mood->updateDescription(Input::get("id"),Input::get("description"));
             return View("Ajax.succes")->with("succes","Poprwnie zmodyfikowano wpis");
        }
    }
    public function addDrugs() {
        if ( (Auth::check()) ) {
            
            $Mood = new Mood;
            //print "s";
            if (count(Input::get("name")) != 0) {
            $result = $Mood->checkDrugs(Input::get("name"),Input::get("dose"),Input::get("date"),Input::get("time"));
            //foreach ($Mood->errors as $er) {
                //print $er;
            //}
            
            $id = $Mood->selectHourMood(Input::get("idMood"));
            if ($id == true) {
            $check = $Mood->checkHourMood($Mood->hourStart,$Mood->hourEnd);
            
            if (count($Mood->errors) != 0) {
                return View("Ajax.error")->with("error",$Mood->errors);
            }
            else {
                $Mood->idMood = Input::get("idMood");
                for ($i=0;$i < count(Input::get("name"));$i++) {
                    //print Input::get("type")[$i];
                    $Mood->addDrugs(Input::get("name")[$i],Input::get("dose")[$i],Input::get("date")[$i] . " " . Input::get("time")[$i] . ":00",Input::get("type")[$i]);
                }
                $Mood->addForwardingDrugs();
                return View("Ajax.succes")->with("succes","Pomyslnie dodano");
            }
            }
            
        }
        else {
            //print "kto";
        }
            
        }
            //print Input::get("idMood");
            
            
        }
        
    public function deleteDrugs() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $Mood->deleteDrugs(Input::get("id"));
        }
    }
    public function showDrugs() {
        if ( (Auth::check()) ) {
            $Mood = new Mood;
            $list = $Mood->selectDrugs(Input::get("id"));
            return View("Ajax.drugsList")->with("drugs",$list);
        }
    }
        
    
}