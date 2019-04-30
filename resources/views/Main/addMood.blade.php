<div class='addMood'>
    <div class='center'><span class='title'>  DODAJ NOWY NASTRÓJ</span></div>
    <form method='get'>
    <table class='table addMood'>
        <tr>
            
            <td width='50%' rowspan="2" class='center'>
                <br>
                Godzina rozpoczęcia
                
            </td>
            <td>
                <input type='time' name='start_mood_time' class='form-control' value='{{$time_mood}}'>
            </td>
        </tr>
        <tr>
            
            
            <td>
                <input type='date' name='start_mood_date' class='form-control' value='{{$date_mood}}'>
            </td>
        </tr>
        
        <tr>
            
            <td width='50%' rowspan="2" class='center'>
                <br>
                Godzina zakończenia
            </td>
            <td>
                <input type='time' name='end_mood_time' class='form-control' value='{{$time_mood2}}'>
            </td>
        </tr>
        <tr>
            
            
            <td>
                <input type='date' name='end_mood_date' class='form-control' value='{{$date_mood2}}'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Poziom Nastroju (skala od -20 do +20)
            </td>
            <td>
                <input type='text' name='mood' class='form-control'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Poziom lęku (skala od -20 do +20)
            </td>
            <td>
                <input type='text' name='anxienty' class='form-control'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Poziom zdenerowania (skala od -20 do +20)
            </td>
            <td>
                <input type='text' name='nervousness' class='form-control'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Poziom Pobudzenia (skala od -20 do +20)
            </td>
            <td>
                <input type='text' name='stimulation' class='form-control'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Ilośc epizodów psychotycznych
            </td>
            <td>
                <input type='text' name='psychotic' class='form-control'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                <br><br>
                Co robiłem
            </td>
            <td>
                
                <textarea name='what_work' class='form-control' rows='5'></textarea>
            </td>
        </tr>
    
    </table>
        <div class='center'>
            <input type='button' class='btn btn-primary' onclick='addDrugs()' value='Dodaj więcej leków'>
        </div>
        <div id='drugs'>
        </div>
        <div class='drugss' id="drug__">
            
            
            <br>
            
        </div>
        <div class='center'>
            <input type='button' onclick="addMood('{{url('/Mood/add')}}')" class='btn btn-primary' value='Dodaj nastrój'>
            
        </div>
    </form>
    <div class="center " id="addResult">
    </div>
</div>