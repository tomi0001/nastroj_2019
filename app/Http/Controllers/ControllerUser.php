<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Services\User as User;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use DB;
class ControllerUser extends BaseController
{
    public function register() {
        return View("User.Register");
        
    }
    
    public function register_action() {
        $User = new User;
        $User->checkField();
        if (count($User->errors) != 0) {
            return back()->with("errors",$User->errors)->withInput();
        }
        else {
            $User->add();
            return Redirect("/User/Login")->with("succes","Poprownie się zarejestrowałeś możesz się zalogowac");
        }
        
    }
    public function login_action() {
            
        $user = array(
            "login" => Input::get("login"),
            "password" => Input::get("password")
            
        );
        if (Input::get('login') == "" or Input::get('password') == "" ) {
            return Redirect('/User/Login')->with('error','Uzupełnij pole login i hasło');
        }
        if (Auth::attempt($user) ) {
            return Redirect("/Main");
        }
        else {
            return Redirect('/User/Login')->with('error','Nie prawidłowy login lub hasło');
        }
        
    }
    public function login() {
        return View("User.Login");
    }
    
}