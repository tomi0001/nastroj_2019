<table class="" width="40%" align="center">
    
@if ($type == "hour")
    @for ($i=0;$i < count($hour);$i++)
    <tr>

        <td>Godzina -  {{$hour[$i]}} </td><td> {{$list[$i]}}</td>
      


    </tr>
    @endfor
@else
    @for ($i=0;$i < count($day);$i++)
    <tr>

       
        
        <td>Dzień -  {{$day[$i]}} </td><td> {{$list[$i]}}</td>


    </tr>
    @endfor
@endif

</table>