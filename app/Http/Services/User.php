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
//use App\User as Users;
//class User
class User {
   public $errors = [];
   //public $errorsPassword = [];
   public function checkField()   {
       $User = new Users;
       $ifLogin = $User->where("login",Input::get("login"))->first();
       if (Input::get("login") == "") {
           array_push($this->errors, "Login nie może być pusty");
       }
       if (count($ifLogin) != 0 ) {
           array_push($this->errors, "Jest juz taki login wpisz inny");
       }
       
       if (((int)Input::get("start_day") != Input::get("start_day")
               or (Input::get("start_day") < 0 or Input::get("start_day") > 23 )) and Input::get("start_day") != "") {
           array_push($this->errors, "Godzina zaczęcia dnia musi być wartością od 0 do 23");
       }
       $this->checkPassword(Input::get("password"),Input::get("password_confirm"));
       
       
   }
   private function checkPassword($password,$password_confirm) {
       if (strlen($password) < 5) {
           array_push($this->errors, "Podane hasło musi mieć minumum 5 znaków");
       }
       if ($password != $password_confirm) {
           array_push($this->errors, "Podane hasła się różnią");
       }
   }
   public function add() {
       $Users = new Users;
       $Users->login = Input::get("login");
       $Users->password = Hash::make(Input::get("password"));
       $Users->start_day = Input::get("start_day");
       $Users->save();
       //$Users->login = Input::get("login");
       //$Users->login = Input::get("login");
   }
}