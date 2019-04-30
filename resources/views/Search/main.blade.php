@extends('Layout.Main')

@section('content')
<div class="search">
    <table class="table">
        <form action="{{ url('/Produkt/Search_action')}}" method="get">
        <tr>
            <td class="center">
                Nastrój
            </td>
            <td width="20%">
                <input type="text" name="moodFrom" class="form-control typeMood">
            </td>
            <td class="center">
                do
            </td>
            <td width="20%">
                <input type="text" name="moodTo" class="form-control typeMood">
            </td>
            <td width="20%"class="mini" rowspan="4">
                <br><br><br><br>
                Wartośc dla jednego dnia
                <input type="checkbox" name="moodForDay" class="form-control typeMood">
            </td>
        </tr>
        <tr>
            <td class="center">
                Lęk
            </td>
            <td width="20%">
                <input type="text" name="anxietyFrom" class="form-control typeMood">
            </td>
            <td class="center">
                do
            </td>
            <td width="20%">
                <input type="text" name="anxietyTo" class="form-control typeMood">
            </td>

        </tr>
        <tr>
            <td class="center">
                Zdenerwowanie
            </td>
            <td width="20%">
                <input type="text" name="nervousnessFrom" class="form-control typeMood">
            </td>
            <td class="center">
                do
            </td>
            <td width="20%">
                <input type="text" name="nervousnessTo" class="form-control typeMood">
            </td>

        </tr>
        <tr>
            <td class="center">
                Pobudzenie
            </td>
            <td width="20%">
                <input type="text" name="stimulationFrom" class="form-control typeMood">
            </td>
            <td class="center">
                do
            </td>
            <td width="20%">
                <input type="text" name="stimulationTo" class="form-control typeMood">
            </td>

        </tr>
        <tr>
            <td class="center">
                Długośc <span class="mooddd">nastroju</span> od
            </td>
            <td width="20%" >
                <input type="text" name="hour1" class="form-control" placeholder="Godziny">
            </td>
            <td></td>
            <td width="20%">
                <input type="text" name="min1" class="form-control" placeholder="Minuty">
            </td>

        </tr>
        <tr>
            <td class="center">
                Długośc <span class="mooddd">nastroju</span> do
            </td>
            <td width="20%">
                <input type="text" name="hour2" class="form-control" placeholder="Godziny">
            </td>
            <td class="center">
            </td>
            <td width="20%">
                <input type="text" name="min2" class="form-control" placeholder="Minuty">
            </td>

        </tr>
    </table>
    <table class="table">
        <tr>
            <td class="center" width="18%">
                Data od
            </td>
            <td width="17%">
                <select name="yearFrom" class="form-control" >
                    <option value=""></option>
                    @for ($i = $yearFrom;$i <= $yearTo;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
               
            </td>
            <td class="center"  width="17%">
                <select name="monthFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 12;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="dayFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 31;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="hourFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 0;$i <= 23;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>

            <td width="20%"class="mini">
 
            </td>
        </tr>
       <tr>
            <td class="center" width="18%">
                Data do
            </td>
            <td width="17%">
                <select name="yearTo" class="form-control" >
                    <option value=""></option>
                    @for ($i = $yearFrom;$i <= $yearTo;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
               
            </td>
            <td class="center"  width="17%">
                <select name="monthTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 12;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="dayTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 31;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="hourTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 0;$i <= 23;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>

            <td width="20%"class="mini">
 
            </td>
        </tr>
     </table>
    <table class="table">
        <tr>
            <td class="center">
                Słowa kluczowe co robiłem
                
            </td>
            <td class="center">
                <input type="text" name="what_work" class="form-control typeMood">
                
            </td>
        </tr>
        <tr>
            <td class="center">
                Wyszukaj następujące leki
                
            </td>
            <td class="center">
                <input type="text" name="drugs" class="form-control typeMood">
                
            </td>
        </tr>
        <tr>
            <td class="center">
                Sortuj według
                
            </td>
            <td class="center">
                <select name="sort" class="form-control" id="sort">
                    <option value="date">Według daty</option>
                    <option value="hour">Według Godziny</option>
                    <option value="mood">Według nastroju</option>
                    <option value="anxiety">Według lęku</option>
                    <option value="nervousness">Według zdenerwowania</option>
                    <option value="stimulation">Według pobudzenia</option>
                    <option value="longMood">Według długości trwania nastroju</option>
                </select>
                
            </td>
        </tr>
        <tr>
            <td class="center">
                Co ma wyszukać
            </td>
            <td>
                <select id="type" name="type" class="form-control" onchange="changeMood()">
                    <option value="mood">Nastrój</option>
                    <option value="sleep">Sen</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="center">
                <input type="submit" value="Szukaj" class="btn btn-primary">
            </td>
            
        </tr>
        
    </table>
        </form>
        <table class="table">
            <form  method="get">
                <tr>
                    <td colspan="6" class="center">
                        Oblicz średnią trwania nastrojów 
                    </td>
                </tr>
        <tr>
            <td class="center" width="18%">
                Data od
            </td>
            <td width="17%">
                <select name="yearFrom" class="form-control" >
                    <option value=""></option>
                    @for ($i = $yearFrom;$i <= $yearTo;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
               
            </td>
            <td class="center"  width="17%">
                <select name="monthFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 12;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="dayFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 31;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="hourFrom" class="form-control">
                    <option value=""></option>
                    @for ($i = 0;$i <= 23;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>

            <td class="center">
                <select name="type" class="form-control">
                    <option value="mood">Nastroju</option>
                    
                    <option value="anxiety">lęku</option>
                    <option value="nervousness">zdenerwowania</option>
                    <option value="stimulation">pobudzenia</option>
                    
                </select>
            </td>
        </tr>
       <tr>
            <td class="center" width="18%">
                Data do
            </td>
            <td width="17%">
                <select name="yearTo" class="form-control" >
                    <option value=""></option>
                    @for ($i = $yearFrom;$i <= $yearTo;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
               
            </td>
            <td class="center"  width="17%">
                <select name="monthTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 12;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="dayTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 1;$i <= 31;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                <select name="hourTo" class="form-control">
                    <option value=""></option>
                    @for ($i = 0;$i <= 23;$i++)
                    <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </td>
            <td class="center">
                    Dla dnia <input type="checkbox" name="day">
            </td>


        </tr>
        <tr>
            <td colspan="6" class="center">
                <input type="button" onclick="searchAI('{{url('/Produkt/actionAI')}}')" value="Szukaj" class="btn btn-primary">
            </td>
        </tr>
        <tr>
        <td colspan="6">
            <div id="AI" class="center"></div>
            
        </td>
        </tr>
            </form>
            
        </table>
        <table class="table">
            <form action="{{ url('/PDF/generate')}}">
                <tr>
                    <td class="center" colspan="8">
                        Generuj PDF dla podanych dat
                    </td>
                </tr>
                <tr>
                    <td class="center">
                        Data rozpoczęcia
                    </td>
                    <td>
                        <input type="date" class="form-control" name="date_start">
                    </td>
                    <td class="center">
                        Data zakończenia
                    </td>
                    <td>
                        <input type="date" class="form-control" name="date_end">
                    </td>
                    <td class="center">
                        Czy leki też wydrukować ?
                    </td>
                    <td>
                        <input type="checkbox" class="form-control" name="drugs">
                    </td>
                    <td class="center">
                        Czy treśc opisu też wydrukować
                    </td>
                    <td>
                        <input type="checkbox" class="form-control" name="whatWork">
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="center">
                        <input type="submit" class="btn btn-primary" value="Generuj">
                    </td>
                </tr>
                
            </form>
        </table>
</div>
@endsection