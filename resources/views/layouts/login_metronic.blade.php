<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml/DTD/xhtml1-transitional.dtd" >

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt" slick-uniqueid="3">
<head>
    <meta name="_token" content="{{ csrf_token() }}"/>

    @include('partials.assets.styles_login')
</head>
<body class=" login" cz-shortcut-listen="true">
<!-- BEGIN LOGO -->
<div class="logo">
    @if(file_exists(asset('img/logo2.png')))
        <a href="{{url('/')}}"> <img src="{{asset('img/logo2.png')}}" alt="Logo " title="Logo" class="logo-default"></a>
    @endif
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    @include('flash::message')
    @yield('conteudo')
</div>
<div class="copyright"> © {{date('Y')}}.</div>

@include('partials.assets.scripts_login')
@include('partials.modal.lg')

</body>
</html>

