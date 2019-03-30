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
    
}