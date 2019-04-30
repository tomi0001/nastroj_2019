@extends('Layout.User')
@section('content')
<br>

<div id="login">
    <form action="{{ url('/User/Login_action')}}" method="post">
    <table class="table login">
        <tr>
            <td colspan="2">
                <span class="hight">LOGOWANIE UŻYTKOWNIKA</span>
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

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <tr>
            
            <td colspan="2">
                <input type="submit" value="Zaloguj" class="btn btn-primary">
            </td>
        </tr>
        
    </table>
    </form>
    <div id="succes">
        @if (session('succes') )
            {{session('succes')}}
        @endif
    </div>
    <div id="error">
        @if (session('error') )
            {{session('error')}}
        @endif
    </div>
</div>
@endsection