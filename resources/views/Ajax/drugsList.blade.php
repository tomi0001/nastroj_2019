
@foreach ($drugs as $list)
<div class='trDrugs' id='DrugsTr{{$list->id}}'>
<div class='tdDrugs'>
    {{$list->name}}
</div>
    <div class='space'>&nbsp;</div>
   <div class='tdDrugs'>
    {{$list->dose}} 
    @if ($list->type == 1)
    mg
    
    @elseif ($list->type == 2)
    Militry
    
    @else
    Ilości
    @endif
</div> 
    <div class='space'>&nbsp;</div>
<div class='tdDrugs'>
    {{$list->date}}
</div>
    <div class='space'>&nbsp;</div>
<div class='deleteDrugs'>
    <input type='button' onclick="deleteDrugsId('{{ url('/Drugs/Delete') }}',{{$list->id}})" class='btn btn-danger' value='Usuń'>
</div>
</div>
@endforeach
