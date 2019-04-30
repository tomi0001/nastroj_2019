<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
          <link rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


@for ($i=0;$i < count($list);$i++) 
@if ($i == 0 or $list[$i]["dat"] != $list[$i-1]["dat"])
Dzień {{$list[$i]["dat"]}}<br>
@endif
@if ($list[$i]["type"] == 1)
NASTRÓJ
@else
SEN
@endif
<br>
    {{$list[$i]["date_start"]}} -  {{$list[$i]["date_end"]}}<br>
    @if ($list[$i]["type"] == 1)
        Poziom nastroju {{$list[$i]["level_mood"]}} <br>
        Poziom lęku {{$list[$i]["level_anxiety"]}} <br>
        Poziom zdenerwowania {{$list[$i]["level_nervousness"]}} <br>
        Poziom pobudzenia {{$list[$i]["level_stimulation"]}} <br>
        @if ($list[$i]["epizodes_psychotik"] != 0)
        Ilośc epizodów psychotycznych {{$list[$i]["epizodes_psychotik"]}}<br>
        @endif
        {{$list[$i]["what_work"]}}
        
    @else
        @if ($list[$i]["epizodes_psychotik"] != 0)
            Ilośc Wybudzeń {{$list[$i]["epizodes_psychotik"]}}
        @endif
    @endif
    
<br><br>






@endfor









