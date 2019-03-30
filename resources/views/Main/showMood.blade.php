<body onload='hideDiv({{$count}})'>
<div class='center'>
  <div class='center2'>
      @if (!empty($colorDay) )
    <div class='level{{$colorDay["mood"]}}' style='width: 100%'>
        Poziom nastróju dla tego dnia {{$colorForDay["mood"]}}
    </div>
    <div class='level{{$colorDay["anxiety"]}}' style='width: 100%'>
        Poziom lęku dla tego dnia {{$colorForDay["anxiety"]}}
    </div>
    <div class='level{{$colorDay["nervousness"]}}' style='width: 100%'>
        Poziom zdenerwowania dla tego dnia {{$colorForDay["nervousness"]}}
    </div>
    <div class='level{{$colorDay["stimulation"]}}' style='width: 100%'>
        Poziom pobudzenia dla tego dnia {{$colorForDay["stimulation"]}}
    </div>
      @endif
  </div>
    <br>
    <div class='mood'>
        
    <table class=' table table-borderless '>

        @for ($i = 0;$i < count($listMood);$i++)
        @php
        $j = $i+1;
        @endphp
                    <tr class="border">
                <td colspan="5">
                    
                </td>
            </tr>
                 <tr class='idMood{{$i}} ' >

                    <td colspan="5" class='boldTitle'>
                        <div class='center'>{{$j}}</div>
                    </td>
                </tr>
            @if ($listMood[$i]["type"] == 1)
                <tr class='idMood{{$i}}'>

                    <td colspan="5">
                        <div class='level{{$listMood[$i]["color_mood"]}}' style='width:{{$listPercent[$i]["percent"]}}%;'>
                        &nbsp;
                        </div>
                    </td>
                </tr>
                <tr class='idMood{{$i}}'>
                    <td class='bold' width='25%' colspan="1">
                         {{$listMood[$i]["date_start"]}} - 
                    </td>
                    <td class='bold' width='25%' colspan="1">
                        {{$listMood[$i]["date_end"]}}
                    </td>
                    <td class='bold' width='50%' colspan="3">
                        <div class='center'>Czar trwania:  &nbsp;&nbsp;&nbsp;&nbsp;   {{$listPercent[$i]["second"]}}</div>
                    </td>
                    
                </tr>
                <tr class='idMood{{$i}}'>
                    <td class='bold' width='25%'>
                         Poziom nastroju: {{$listMood[$i]["level_mood"]}}
                    </td>
                    <td class='bold' width='25%'>
                        Poziom lęku: {{$listMood[$i]["level_anxiety"]}}
                    </td>
                    <td class='bold' width='25%' colspan="2">
                         Poziom zdenerwowania: {{$listMood[$i]["level_nervousness"]}}
                    </td>
                    <td class='bold' width='25%'>
                        Poziom pobudzenia: {{$listMood[$i]["level_stimulation"]}}
                    </td>

                </tr>
                @if ($listMood[$i]["epizodes_psychotik"] != 0)
                <tr class='idMood{{$i}}'>
                    
                    <td class='boldWarning' width='25%' colspan="5">
                         Ilość epizodów psychotycznych = {{$listMood[$i]["epizodes_psychotik"]}} 
                    </td>
                    
                    
                </tr>
 
                @endif
                   <tr class='idMood{{$i}}'>
                    <td>
                        @if ($listMood[$i]["drugs"] != "")
                        <button onclick="showDrugs('{{url('/Drugs/show')}}')" class="btn btn-primary">Pokaż leki</button>
                        @else
                        <button class="btn btn-danger" disabled>Nie było leków</button>
                        @endif
                        
                    </td>
                    <td>
     
                        <button onclick="addDrugs({{$i}})" class="btn btn-primary">Dodaj leki</button>
                       
                    </td>
                    <td>
     
                        <button onclick="deleteMood('{{url('/Mood/delete')}}',{{$listMood[$i]["id"]}},{{$i}})" class="btn btn-danger">Usuń nastrój</button>
                       
                    </td>
                    <td>
     
                        <button onclick="addDescription('{{url('/Mood/addDescription')}}')" class="btn btn-primary">Edytuj dodaj opis</button>
                       
                    </td>
                    <td>
                        @if ($listMood[$i]["what_work"] == true)
                        <button onclick="showDescription('{{url('/Mood/showDescription')}}',{{$listMood[$i]["id"]}},{{$i}})" class="btn btn-primary">Pokaż opis</button>
                        @else
                        <button  class="btn btn-danger" disabled>Nie było opisu</button>
                        @endif
                    </td>
                </tr>
                <tr class='idMood{{$i}}'>
                    <td colspan='5'>
                        <div id='showDescription{{$i}}' class='center'></div>
                    </td>
                    
                </tr>
                <tr>
                    
                    <td colspan="5">
                        
                        <div class="drugss{{$i}} center " style='width: 50%;'></div>
                    </td>
                    
                    
                </tr>
                <tr>
                    
                    <td colspan="5">
                        
                        <div class="drugsss{{$i}} center"></div>
                    </td>
                    
                    
                </tr>
            @else
                 <tr class='idMood{{$i}}'>

                     <td colspan="5">
                        <div class='levelsleep' style='width:{{$listPercent[$i]["percent"]}}%;'>
                        &nbsp;
                        </div>
                    </td>
                </tr> 
                <tr class='idMood{{$i}}'>
                    <td class='boldSleep' width='25%' colspan="1">
                         {{$listMood[$i]["date_start"]}} - 
                    </td>
                    <td class='boldSleep' width='25%' colspan="1">
                        {{$listMood[$i]["date_end"]}}
                    </td>
                    <td class='boldSleep' width='50%' colspan="3">
                        Czar trwania:  &nbsp;&nbsp;&nbsp;&nbsp;   {{$listPercent[$i]["second"]}}
                    </td>
                    
                </tr>
                <tr class='idMood{{$i}}'>
                    <td class='boldSleep' width='25%' colspan="5">
                        <button onclick="deleteSleep('{{ url('/Sleep/delete')}}',{{$listMood[$i]["id"]}},{{$i}})" class='btn btn-danger'>usuń sen</button>
                    </td>
                    
                    
                </tr>
                @if ($listMood[$i]["epizodes_psychotik"] != 0)
                <tr class='idMood{{$i}}'>
                    
                    <td class='boldSleep' width='25%' colspan="5">
                         Ilośc wybudzeń {{$listMood[$i]["epizodes_psychotik"]}} 
                    </td>
                    
                    
                </tr>
                @endif
            @endif
            <tr class='idMood{{$i}}'>
                <td colspan="5">
                    <br><br>
                </td>
            </tr>

                   
        @endfor
    </table>
    </div>
</div>