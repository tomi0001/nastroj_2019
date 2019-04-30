<div class="center" style="width: 40%;">
    <table class="table">
      @if ($day == "on")
      <tr>
            <td>
                Dla tego czasu
            </td>
            <td>
                {{$list[0]}}
            </td>
        </tr>
      
      
      
      @else
        @for ($i=0;$i < count($days);$i++)
        <tr>
            <td>
                {{$days[$i]}}
            </td>
            <td>
                {{$list[$i]}}
            </td>
        </tr>
        @endfor
      @endif
    </table>
</div>