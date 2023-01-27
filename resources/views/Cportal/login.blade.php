@extends('Cportal.main')

@section('content')
<form id="login-form" name="login-form" method="post" action="{{ url('cportal/login/auth') }}" autocomplete="off">
    <div>@csrf</div>
    
    @if(session('error_message'))
    <div class="alert">{{ session('error_message') }}</div>
    @endif
    
    <div>
        <label for="user_name">{{ __('cportal.user_name') }}</label>
        <input type="text" id="user_name" name="user_name" value="{{ (session('user_name'))?session('user_name'):''}}"/>
    </div>

    <div>
        <label for="user_password">{{ __('cportal.user_password') }}</label>
        <input type="password" id="user_password" name="user_password" value="{{ (session('user_password'))?session('user_password'):''}}"/>
    </div>

    <div><button type="submit">{{ __('cportal.btn_login') }}</button></div>
</form>
@endsection