<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class calendar
{
    
    public $month;
    public $day;
    public $action;
    public $year;
    public $day_week;

       public function return_month_text($month) {
    
            switch($month) {
              case 1 : return "Styczeń";
              case 2 : return "Luty";
              case 3 : return "Marzec";
              case 4 : return "Kwiecień";
              case 5 : return "Maj";
              case 6 : return "Czerwiec";
              case 7 : return "Lipiec";
              case 8 : return "Sierpień";
              case 9 : return "Wrzesień";
              case 10 : return "Październik";
              case 11: return "Listopad";
              case 12 : return "Grudzień";
            }

      }
    
    public function return_back_month($month,$year) {
        if ($month == 1) {
          $year--;
          $month = 12;
        }
        else {
          $month--;
        }
        return array($year,$month);
    }

  public function return_next_month($month,$year) {
    if ($month == 12) {
      $year++;
      $month = 1;
    }
    else {
      $month++;
    }
    return array($year,$month);
  }

    
        public function return_next_year($year) {
            
            return array($year+1,$this->month);
        }
        public function return_back_year($year) {
            
            return array($year-1,$this->month);
        }
    
        public function set_date($month,$action,$day,$year) {
            
            if (empty($year)) {
                
                $this->year = date("Y");
            }
            else {
                $this->year = $year;
            }
            if (empty($month)) {
                $this->month = date("m");
                
            }
            else {
                $this->month = $month;
            }
            if (empty($day)) {
                $this->day = date("d");
                
            }
            else {
                $this->day = $day;
            }
            $this->day_week = $this->set_beginning_day($this->year . "-" . $this->month . "-1");
            
            if ($this->day_week == 0) {
                $this->day_week = 7;
            }
            
    }
    
    
      private function set_beginning_day($data) {
        return date("w",strtotime($data));
      }
        public function check_month($month,$year) {

            if ($month == 12) {
            return 31;
            }
            else if ($month == 11) {
            return 30;
            }
            else if ($month == 10) {
            return 31;
            }
            else if ($month == 9) {
            return 30;
            }
            else if ($month == 8) {
            return 31;
            }
            else if ($month == 7) {
            return 31;
            }
            else if ($month == 6) {
            return 30;
            }
            else if ($month == 5) {
            return 31;
            }
            else if ($month == 4) {
            return 30;
            }
            else if ($month == 3) {
            return 31;
            }
            else if ($month == 2) {

            if ( $this->or_affordable($year) == 1) {
                return 29;
            }
            else {
                return 28;
            }

            }
            else if ($month == 1) {
            return 31;
            }


  }
  
    private function or_affordable($year)
    {
         return (($year%4 == 0 && $year%100 != 0) || $year%400 == 0);
    }
  
    
}
