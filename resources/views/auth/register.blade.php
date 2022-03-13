@extends('layouts.header')

@section('title', App\MaintenanceLocale::getLocale(72))

@section('content')

{{-- systems-css --}}
<link rel="stylesheet" href="{{ asset('resources/css/chosen/choices.min.css') }}">
<script src="{{ asset("resources/js/chosen/choices.min.js") }}"></script>
<link rel="stylesheet" href="{{ asset('resources/css/systems.css') }}">

{{-- register-page-css --}}
<link rel="stylesheet" href="{{ asset('css/content-page/register-page.css') }}">

<div class="container">
    <br>
    <br>
    <br>
    <br>    
    <div class="row">
    
        <div class="col-lg-8  mx-auto" style="text-align:center">
            
           <img class="img-fluid" alt="Responsive image" src="/login-images/{{ $pagecontents->register }}" width="80px;" style="display: block; margin: 0px auto;">

           <form method="POST" action="{{ route('register') }}" id="form">
            @csrf
            <label class="label-26 text-muted font-weight-light">
                {{ App\MaintenanceLocale::getLocale(72) }}
            </label>
            {{--   <input type="text" value="{{$decrypt}}" id="roleID" name="roleID" hidden> --}}
            <br>
            {{-- <span class="badge badge-pill badge-info bdges">
            {{ App\MaintenanceLocale::getLocale(73) }}: {{$account->name}}
        </span> --}}

        @include('flash-message')
        
        <div class="register_inputs">

            <div class="form-group row">
                <div class="col-sm-8 mx-auto">
                    <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(73) }}</label>
                    <select class="form-control  input-size-2" id="roleID" name="roleID">
                        <option hidden></option>
                        <option value="1">{{ App\MaintenanceLocale::getLocale(78) }}</option>
                        <option value="5">Student</option>
                        <option value="2">{{ App\MaintenanceLocale::getLocale(630) }}</option>
                        <option value="3">{{ App\MaintenanceLocale::getLocale(631) }}</option>
                        <option value="4">{{ App\MaintenanceLocale::getLocale(81) }}</option>
                        <option value="5">{{ App\MaintenanceLocale::getLocale(632) }}</option>
                    </select>
                    
                    <div class="error-container" style="text-align:left">
                        <label class="label-error error-roles">{{ App\MaintenanceLocale::getLocale(511) }}</label>
                    </div>
                </div>
            </div>
    
        <div class="form-group row">
            
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(74) }}</label>

                <input type="text" class="form-control input-size-2" name="UserName" id="UserName" value="{{ old('UserName') }}">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-username">{{ App\MaintenanceLocale::getLocale(102) }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class=" col-form-label label-14" id="firstClass">{{ App\MaintenanceLocale::getLocale(39) }}</label>
                <input type="text" class="form-control input-size-2" name="firstName" id="firstName" value="{{ old('firstName') }}">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-firstname">{{ App\MaintenanceLocale::getLocale(103) }}</label>
                </div>
            </div>
            
        </div>

        <div class="form-group row lastname-div">
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(40) }}</label>
                <input type="text" class="form-control input-size-2" name="lastName" id="lastName" value="{{ old('lastName') }}">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-lastname">{{ App\MaintenanceLocale::getLocale(104) }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(41) }}</label>
                <input type="text" class="form-control input-size-2" id="email" name="email" value="{{ old('email') }}">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-email">{{ App\MaintenanceLocale::getLocale(105) }}</label>
                </div>
            </div>
            
        </div>

        <div class="form-group row">
            
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(100) }}</label>
                <input type="password" class="form-control input-size-2" id="password" name="password">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-password">{{ App\MaintenanceLocale::getLocale(106) }}</label>
                </div>
            </div>
            
        </div>

        <div class="form-group row">
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class=" col-form-label label-14">{{ App\MaintenanceLocale::getLocale(75) }}</label>
                <input type="password" class="form-control input-size-2" id="password_confirmation" name="password_confirmation">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-password2">{{ App\MaintenanceLocale::getLocale(108) }}</label>
                </div>
            </div>
		</div>

        <div class="form-group row" id="birthdateDiv">
            <div class="col-sm-8 mx-auto">
                <label for="birthdate" class=" col-form-label label-14">{{ App\MaintenanceLocale::getLocale(419) }}</label>
                <input type="date" class="form-control input-size-2" id="birthdate" name="birthdate">

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-birthdate">{{ $message['ER:01:33'] }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="genderDiv">
            <div class="col-sm-8 mx-auto">
                <label for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(436) }}</label>
                <select class="form-control input-size-2" id="gender" name="gender">
                    @foreach($genders as $val)
                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endforeach
                </select>

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-gender">{{ $message['ER:01:35'] }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="countryDiv">
            <div class="col-sm-8 mx-auto">
                <h1 for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(332) }}:</h1>
                
                <select class="form-control input-size-2" name="country" id="country"> 
                    @foreach($countries as $val)
                    <option value="{{ $val->id }}">{{ $val->nicename }}</option>
                    @endforeach
                </select>

                <div class="error-container" style="text-align:left;">
                    <label class="label-error error-country">{{ $message['ER:00:23'] }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="specializationDiv">
            <div class="col-sm-8 mx-auto">
                <h1 for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(438) }}:</h1>
                
                <select class="form-control input-size-2" id="specialization" placeholder="{{ App\MaintenanceLocale::getLocale(457) }}" multiple name="specialization[]">
                    @foreach($specializations as $specialization)
                    <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                    @endforeach
                </select>   

                <div class="error-container" style="text-align: left;">
                    <label class="label-error error-specialization">{{ App\MaintenanceLocale::getLocale(449) }}.</label>
                </div>
            </div>
        </div>

        <div class="form-group row" id="ceritificatesDiv">
            <div class="col-sm-8 mx-auto">
                <h1 for="staticEmail" class="col-form-label label-14">{{ App\MaintenanceLocale::getLocale(543) }}:</h1>
                
                <select class="form-control input-size-2" id="ceritificates" placeholder="{{ App\MaintenanceLocale::getLocale(633) }}" multiple name="ceritificates[]">
                   <option value="N1" @if($errors->any()) @if(old('type')==="N1") selected @endif @endif>N1</option>
                   <option value="N2" @if($errors->any()) @if(old('type')==="N2") selected @endif @endif>N2</option> 
                   <option value="N3" @if($errors->any()) @if(old('type')==="N3") selected @endif @endif>N3</option> 
                   <option value="N4" @if($errors->any()) @if(old('type')==="N4") selected @endif @endif>N4</option> 
                   <option value="N5" @if($errors->any()) @if(old('type')==="N5") selected @endif @endif>N5</option> 
                   <option value="Others" @if($errors->any()) @if(old('type')==="Others") selected @endif @endif>Others</option> 
                </select>   

                <div class="error-container" style="text-align: left;">
                    <label class="label-error error-ceritificates">{{ $message['ER:00:99'] }}.</label>
                </div>
            </div>
        </div>
		
        <div class="form-group row" style="margin-top:5%">
            <div class="col-sm-8 mx-auto">
                <input class="form-check-input"  type="checkbox" name="terms" id="inlineFormCheck" style="top: 2px;">
                <label class="text-muted" for="inlineFormCheck"> 
                    {{ App\MaintenanceLocale::getLocale(76) }} <a href="/privacy" target="_blank">{{ App\MaintenanceLocale::getLocale(61) }}</a> & <a href="/terms" target="_blank">{{ App\MaintenanceLocale::getLocale(60) }}</a>
                </label>

                <div class="error-container" style="text-align:left">
                    <label class="label-error error-privacy">{{ App\MaintenanceLocale::getLocale(195) }}</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-8 mx-auto ">
                <button class="btn btn-primary col-sm-12 col-xs-12 register" type="button" style="background-color: #FF3333; color: white; border:none"> 
                    {{ App\MaintenanceLocale::getLocale(48) }}
                </button>
                <small class="text-center text-muted text-center mx-auto d-block" style="margin-top: 100px;">{{ App\MaintenanceLocale::getLocale(500) }} <a href="{{ route('login') }}">{{ App\MaintenanceLocale::getLocale(501) }}</a></small></p>
            </div>
        </div>
    </div>
</form>
</div>
</div>

</div>
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script>
    $(document).ready(function(){
        $('#birthdate').attr('max' , moment().subtract(16, 'years').format("YYYY-MM-DD"));
        var multipleCancelButton = new Choices('#ceritificates', {
            removeItemButton: true,
            noResultsText: '{{ App\MaintenanceLocale::getLocale(120) }}',
            noChoicesText: '{{ App\MaintenanceLocale::getLocale(357) }}',
            loadingText: '{{ App\MaintenanceLocale::getLocale(212) }}'
        });

        var multipleCancelButton = new Choices('#specialization', {
            removeItemButton: true,
            noResultsText: '{{ App\MaintenanceLocale::getLocale(120) }}',
            noChoicesText: '{{ App\MaintenanceLocale::getLocale(357) }}',
            loadingText: '{{ App\MaintenanceLocale::getLocale(212) }}'
        });
    });

$(".register").click(function(e) {
    $(".label-error").hide();
    $(".error-email").empty();
    $(".error-password2").empty();

    var username    = $("#UserName").val();
    firstname   = $("#firstName").val();
    lastname    = $("#lastName").val();
    email_add   = $("#email").val();
    password    = $("#password").val();
    password2   = $("#password_confirmation").val();
	roles       = $("#roleID").val();
    gender      = $("#gender").val();
    birthdate   = $("#birthdate").val();
    country     = $("#country").val();
    specialization = $("#specialization").val();
    ceritificates = $("#ceritificates").val();
    filter      = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if(roles===null || roles==="" || username===null || username==="" || firstname===null || firstname==="" || lastname===null || lastname==="" || email_add===null || email_add==="" || password===null || password==="" || password2===null || password2==="" || $('#inlineFormCheck').is(":checked") === false || !filter.test(email_add) || (roles==="1" && (gender==="" || birthdate==="" || country==="" || specialization==="" || ceritificates===""))) {
        if(username===null || username==="") {
            $(".error-username").show();
            $("#UserName").css('border', '1px solid red');
        }

        if(firstname===null || firstname==="") {
            $(".error-firstname").show();
            $("#firstName").css('border', '1px solid red');
        }

        if(lastname===null || lastname==="") {
            $(".error-lastname").show();
            $("#lastName").css('border', '1px solid red');
        }

        if(!filter.test(email_add) || email_add==="") {
            if(email_add===null || email_add==="") {
                $(".error-email").show();
                $(".error-email").append("{{ App\MaintenanceLocale::getLocale(105) }}");
                $("#email").css('border', '1px solid red');
            }
            else {
                $(".error-email").show();
                $(".error-email").append('{{ App\MaintenanceLocale::getLocale(194) }}');
                $("#email").css('border', '1px solid red');
            }
        }

        if(password===null || password==="") {
            $(".error-password").show();
            $("#password").css('border', '1px solid red');
        }

        if(password2===null || password2==="" || password !== password2) {
            if(password2===null || password2==="") {
                $(".error-password2").show();
                $(".error-password2").append("{{ App\MaintenanceLocale::getLocale(107) }}");
                $("#password_confirmation").css('border', '1px solid red');
            }
            else {
                $(".error-password2").show();
                $(".error-password2").append("{{ App\MaintenanceLocale::getLocale(108) }}");
                $("#password_confirmation").css('border', '1px solid red');
            }
        }

		if(roles===null || roles==="") {
            $(".error-roles").show();
            $("#roleID").css('border', '1px solid red');
        }

        if($('#inlineFormCheck').is(":checked") === false) {
            $(".error-privacy").show();
        }

        if(roles==="1" && (gender===null || gender==="")) {
            $(".error-gender").show();
            $("#gender").css('border', '1px solid red');
        }

        if(roles==="1" && (birthdate===null || birthdate==="")) {
            $(".error-birthdate").show();
            $(".error-birthdate").html("Birth Date is required.");
            $("#birthdate").css('border', '1px solid red');
        } else {
            if(roles==="1" && birthdate > moment().subtract(16, 'years').format("YYYY-MM-DD")) {
            $(".error-birthdate").show();
            $(".error-birthdate").html("Birth Date is invalid.");
            $("#birthdate").css('border', '1px solid red');
            }
        }

        if(roles==="1" && (country===null || country==="")) {
            $(".error-country").show();
            $("#country").css('border', '1px solid red');
        }

        if(roles==="1" && (specialization===null || specialization==="")) {
            $(".error-specialization").show();
            $("#specialization").css('border', '1px solid red');
        }

        if(roles==="1" && (ceritificates===null || ceritificates==="")) {
            $(".error-ceritificates").show();
            $("#ceritificates").css('border', '1px solid red');
        }
    }
    else {
        document.getElementById("form").submit();
    }
});

$('#roleID').change(function() {

    if($(this).val()==="1") {

        $(".lastname-div").show();
        $("#genderDiv").show();
        $("#countryDiv").show();
        $("#birthdateDiv").show();
        $("#specializationDiv").show();
        $("#ceritificatesDiv").show();
        $("#firstClass").html("First Name");

    }

    else if($(this).val()==="2") {

        $("#lastName").val("-");
        $(".lastname-div").hide();
        $("#countryDiv").hide();
        $("#genderDiv").hide();
        $("#specializationDiv").hide();
        $("#ceritificatesDiv").hide();
        $("#birthdateDiv").hide();
        $("#firstClass").html("Company Name");

    }

    else if($(this).val()==="3") {

        $("#specializationDiv").hide();
        $("#ceritificatesDiv").hide();
        $("#countryDiv").hide();
        $("#genderDiv").hide();
        $("#birthdateDiv").hide();
        $("#lastName").val("-");
        $(".lastname-div").hide();
        $("#firstClass").html("Organization Name");

    }

    else {

        $("#specializationDiv").hide();
        $("#ceritificatesDiv").hide();
        $("#countryDiv").hide();
        $("#genderDiv").hide();
        $("#birthdateDiv").hide();
        $("#lastName").val("-");
        $(".lastname-div").hide();
        $("#firstClass").html("School Name");

    }

	$(".error-roles").hide();
	$(this).css("border", "");
});

$('#inlineFormCheck').change(function() {
    if(this.checked) {
        $(".error-privacy").hide();
    }
    else {
        $(".error-privacy").show();
    }
});

$('#UserName').keyup(function() {
    var length = $(this).val().length;

    if(length < 1) {
        $(".error-username").show();
        $(this).css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-username").hide();
    }
});

$('#firstName').keyup(function() {
    var length = $(this).val().length;
        roleID = $("#roleID").val();

    if(length < 1) {

        if(roleID==="1") {

            $(".error-firstname").html("First Name is required.");

        }
        else if(roleID==="2") {

            $("#lastName").val('-');
            $(".error-firstname").html("Company Name is required.");

        }
        else if(roleID==="3") {

            $("#lastName").val('-');
            $(".error-firstname").html("Organization Name is required.");

        }
        else {

            $("#lastName").val('-');
            $(".error-firstname").html("School Name is required.");

        }

        $(".error-firstname").show();
        $(this).css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-firstname").hide();
    }
});

$('#lastName').keyup(function() {
    var length = $(this).val().length;

    if(length < 1) {
        $(".error-lastname").show();
        $(this).css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-lastname").hide();
    }
});

$('#email').keyup(function() {
    $(".error-email").empty();

    var email   = $(this).val();
    length  = $(this).val().length;
    filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if(length < 1) {
        $(".error-email").show();
        $(".error-email").append('{{ App\MaintenanceLocale::getLocale(105) }}');
        $(this).css('border', '1px solid red');
    }
    else if(!filter.test(email)) {
        $(".error-email").show();
        $(".error-email").append('{{ App\MaintenanceLocale::getLocale(194) }}');
        $(this).css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-email").hide();
    }
});

$('#password').keyup(function() {
    var length = $(this).val().length;

    if(length < 1) {
        $(".error-password").show();
        $(this).css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-password").hide();
    }
});

$('#password_confirmation').keyup(function() {
    $(".error-password2").empty();
    var password2   = $("#password_confirmation").val();
    password    = $("#password").val();
    length      = $(this).val().length;

    if(length < 1) {
        $(".error-password2").show();
        $(".error-password2").append("{{ App\MaintenanceLocale::getLocale(107) }}");
        $(this).css('border', '1px solid red');
    }
    else if(password !== password2) {
        $(".error-password2").show();
        $(".error-password2").append("{{ App\MaintenanceLocale::getLocale(108) }}");
        $("#password_confirmation").css('border', '1px solid red');
    }
    else {
        $(this).css('border', '');
        $(".error-password2").hide();
    }
});
</script>
@endsection