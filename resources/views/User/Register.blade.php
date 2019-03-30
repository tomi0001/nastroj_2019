@extends('Layout.User')
@section('content')
<br>

<div id="login">
    <form action="{{ url('/User/Register_action')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">REJESTRACJA UŻYTKOWNIKA</span>
            </td>
            
        </tr>
        <tr>
            <td width="40%">
                Twój login
            </td>
            <td>
                <input type="text" name="login" class="form-control" value="{{Input::old("login")}}">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Twoje hasło
            </td>
            <td>
                <input type="password" name="password" class="form-control">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Wpisz jeszcze raz swoje hasło
            </td>
            <td>
                <input type="password" name="password_confirm" class="form-control">
            </td>
        </tr>
        <tr>
            <td width="40%">
                Początek dnia
            </td>
            <td>
                <input type="number" name="start_day" class="form-control" value="{{Input::old("start_day")}}">
            </td>
        </tr>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zarejestruj" class="btn btn-primary">
            </td>
        </tr>
        
    </table>
    </form>
    <div id="error">
        @foreach ($errors as $error)
        {{$error}}<br>
        @endforeach
    </div>
</div>
@endsection