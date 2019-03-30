<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class common
{
    public function charset_utf_fix2($string) {
 
	$utf = array(
	  "Ą" =>"%u0104",
	  "Ć" => "%u0106",
	  "Ę"  => "%u0118",
	  "Ł" => "%u0141",
	  "Ń" => "%u0143",
	  "Ó" => "%D3",
	  "Ś" => "%u015A",
	  "Ź" => "%u0179",
	  "Ż" => "%u017B",
	  "ą" => "%u0105",
	  "ć" => "%u0107",
	  "ę" => "%u0119",
	  "ł" => "%u0142",
	  "ń" => "%u0144",
	  "ó" => "%F3",
	  "ś" => "%u015B",
	  "ź" => "%u017A",
	  "ż" => "%u017C",
          " " => "&nbsp"
	);
	
	return str_replace(array_keys($utf), array_values($utf), $string);
        
	
    }
    public function charset_utf_fix($string) {
 
	$utf = array(
	 "%u0104" => "Ą",
	 "%u0106" => "Ć",
	 "%u0118" => "Ę",
	 "%u0141" => "Ł",
	 "%u0143" => "Ń",
	 "%D3" => "Ó",
	 "%u015A" => "Ś",
	 "%u0179" => "Ź",
	 "%u017B" => "Ż",
	 "%u0105" => "ą",
	 "%u0107" => "ć",
	 "%u0119" => "ę",
	 "%u0142" => "ł",
	 "%u0144" => "ń",
	 "%F3" => "ó",
	 "%u015B" => "ś",
	 "%u017A" => "ź",
	 "%u017C" => "ż",
         "%20" => " ",
            "&nbsp" => " "
	);
	
	return str_replace(array_keys($utf), array_values($utf), $string);
        
	
    }
    
}