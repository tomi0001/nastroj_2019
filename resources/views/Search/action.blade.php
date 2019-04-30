@extends('Layout.Main')

@section('content')
<body onload='hideDiv({{$count}})'>
<br>
<div class="searchaction">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th class="center" width="150px">
                Data zaczęcia
                
            </th>
            <th class="center" width="150px">
                Data skończenia
                
            </th>
            <th class="center" width="150px">
                Poziom nastroju
                
            </th>
            <th class="center" width="150px">
                Poziom lęku
                
            </th>
            <th class="center" width="150px">
                Poziom zdenerwowania
                
            </th>
            <th class="center" width="150px">
                Poziom pobudzenia
                
            </th>

        </tr>
        </thead>
        @for ($i=0;$i < count($list);$i++)
        @if ($i == 0 or $list[$i]['dat'] != $list[$i-1]['dat'])
        <tr>
            <td colspan="6">
                <br>
                <div class="title center">{{$list[$i]['dat']}}</div>
                <br>
           
        

            </td>
        </tr>
            
        @endif
        <tr class="search">
            <td colspan="6">
              <table width="100%" border="0">
            
                    <tr>
                        <td class="center" width="150px">

                        {{$list[$i]['date_start']}}

                    </td>
                    <td class="center"  width="16%" width="150px">
                        {{$list[$i]['date_end']}}

                    </td>
                    @if ($list[$i]['type'] == 1)
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]['nas']))
                            {{$list[$i]['level_mood']}}
                            @else
                            {{$list[$i]['nas']}}
                            @endif


                        </td>
                        <td class="center"  width="16%" width="150px">

                            @if (!isset($list[$i]['nas']))
                            {{$list[$i]['level_anxiety']}}
                            @else
                            {{$list[$i]['nas2']}}
                            @endif
                        </td>
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]['nas']))
                            {{$list[$i]['level_nervousness']}}
                            @else
                            {{$list[$i]['nas3']}}
                            @endif


                        </td>
                        <td class="center"  width="16%" width="150px">
                            @if (!isset($list[$i]['nas']))
                            {{$list[$i]['level_stimulation']}}
                            @else
                            {{$list[$i]['nas4']}}
                            @endif


                        </td>
                    @else
                        <td class='boldWarning' colspan="4" width="64%">
                              @if ($list[$i]['epizodes_psychotik'] > 0)
                                Ilośc wybudzeń {{$list[$i]['epizodes_psychotik']}}
                              @endif
                        </td>
                    @endif
                  </tr>
                     <tr>
                        <td colspan="6">
                            <br>
                          @if ($list[$i]['type'] == 1)
                            @if (!isset($list[$i]['nas']))
                            <div class="level{{$list[$i]['color_mood']}}" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>
                            @else
                            <div class="level{{$list[$i]['color_nas']}}" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>

                            @endif
                          @else
                          <div class="levelsleep" style='width: {{$percent[$i]["percent"]}}%';>&nbsp;</div>
                          @endif
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <br>
                            {{$percent[$i]['second']}}
                        </td>
                        @if ($list[$i]['type'] == 1)
                        <td>
                            <br>
                            @if ($list[$i]['what_work'] == true)
                            <button onclick="showDescription('{{url('/Mood/showDescription')}}','{{$list[$i]['id']}}','{{$i}}')" class='btn btn-primary'>Co robiłeś</button>
                            @else
                            <button class='btn btn-danger' disabled>Nic nie robiłeś</button>
                            @endif
                        </td>
                        <td>
                            <br>
                            @if ($list[$i]['drugs'] == true)
                            <button onclick="showDrugs('{{url('/Drugs/show')}}','{{$i}}','{{$list[$i]['id']}}')" class='btn btn-primary'>Pokaż leki</button>
                            @else
                            <button class='btn btn-danger' disabled>Nie było leków</button>
                            @endif
                        </td>
                        @endif
                        <td>
                            <br>
             
                            <a href='{{url('/Main')}}/{{$list[$i]["year"]}}/{{$list[$i]["month"]}}/{{$list[$i]["day"]}}'><button class='btn btn-primary'>Idź do dnia</button></a>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <br>
                            <div id='showDescription{{$i}}'></div>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <br>
                            <div id='showDrugss{{$i}}'></div>
                            
                            <br>
                        </td>
                    </tr>
                    
                    
        </table>
           </td> 
           
        </tr>

        @endfor

        <tr>
            <td colspan="6" class="center">
                
                {{$paginate->appends(['sort'=>Input::get('sort')])
                ->appends(['moodFrom'=>Input::get("moodFrom")])
                ->appends(['moodTo'=>Input::get("moodTo")])
                ->appends(['anxietyFrom'=>Input::get("anxietyFrom")])
                ->appends(['anxietyTo'=>Input::get("anxietyTo")])
                ->appends(['nervousnessFrom'=>Input::get("nervousnessFrom")])
                ->appends(['nervousnessTo'=>Input::get("nervousnessTo")])
                ->appends(['stimulationFrom'=>Input::get("stimulationFrom")])
                ->appends(['stimulationTo'=>Input::get("stimulationTo")])
                ->appends(['yearFrom'=>Input::get("yearFrom")])
                ->appends(['monthFrom'=>Input::get("monthFrom")])
                ->appends(['dayFrom'=>Input::get("dayFrom")])
                ->appends(['yearTo'=>Input::get("yearTo")])
                ->appends(['monthTo'=>Input::get("monthTo")])
                ->appends(['dayTo'=>Input::get("dayTo")])
                ->appends(['hourFrom'=>Input::get("hourFrom")])
                ->appends(['hourTo'=>Input::get("hourTo")])
                ->appends(['what_work'=>Input::get("what_work")])
                ->appends(['drugs'=>Input::get("drugs")])
                ->appends(['moodForDay'=>Input::get("moodForDay")])
                ->appends(['type'=>Input::get("type")])
        
                ->links()}}
            </td>
        </tr>
    </table>
</div>

@endsection