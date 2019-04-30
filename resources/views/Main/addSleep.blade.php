<div class='addMood'>
    <div class='center'><span class='title'>DODAJ NOWY SEN</span></div>
    <form method='get'>
    <table class='table addMood'>
        <tr>
            
            <td width='50%' rowspan="2" class='center'>
                <br>
                Godzina rozpoczęcia
            </td>
            <td>
                <input type='time' name='start_sleep_time' class='form-control' value='{{$time_sleep}}'>
            </td>
        </tr>
        <tr>
            
            
            <td>
                <input type='date' name='start_sleep_date' class='form-control' value='{{$date_sleep}}'>
            </td>
        </tr>
        
        <tr>
            
            <td width='50%' rowspan="2" class='center'>
                <br>
                Godzina zakończenia
            </td>
            <td>
                <input type='time' name='end_sleep_time' class='form-control' value='{{$time_mood2}}'>
            </td>
        </tr>
        <tr>
            
            
            <td>
                <input type='date' name='end_sleep_date' class='form-control' value='{{$date_mood2}}'>
            </td>
        </tr>
        <tr>
            
            <td width='50%' class='center'>
                
                Ilość wybudzeń
            </td>
            <td>
                <input type='text' name='wake_up' class='form-control'>
            </td>
        </tr>
        
    
    </table>
        
        <div class='center'>
            <input type='button' onclick="addSleep('{{url('/Sleep/add')}}')" class='btn btn-primary' value='Dodaj sen'>
            
        </div>
    </form>
    <div class="center " id="addResultSleep">
    </div>
</div>