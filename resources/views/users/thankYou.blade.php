@extends('layouts.userMaster');
@section('content')
{{-- @include('flash-message') --}}
<div class="container">
    <!-- tittle heading -->
    <h3 class="tittle-w3l">Thank You!
        <span class="heading-style">
            <i></i>
            <i></i>
            <i></i>
        </span>
    </h3> 
<!-- banner -->
@include('flash-message')
<div>
    <center><img src="/images/background2.png" alt="libraryhome"  ></center>             
</div>
 <center><h3>Thank You!Keep Shopping with us</h3></center>
 <center><h2>We will contact you back sortly to confirm your residence details && check your Confirmation mail</h2></center>
@endsection