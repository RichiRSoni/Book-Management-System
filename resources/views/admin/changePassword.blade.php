@extends('layouts.master')

@section('content')


<br/><br/><br/><br/><br/><div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- &lt;div id="app"&gt; --}}
                @include('flash-message')
                <div class="card-header"><b>Change Password</b></div>
   
                <div class="card-body">
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf 
   
                         {{-- @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach  --}}
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>
                            
  
                            <div class="col-md-6">
                                <input id="password" type="password"  name="current_password" class="form-control @error('current_password') is-invalid @enderror" value="{{old('current_password')}}" >
                                <i class="far fa-eye" id="togglePassword" style="margin-left:0px; cursor: pointer;">Show Password</i> 
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
  
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="{{old('current_password')}}" >
                                <i class="far fa-eye" id="togglePassword" style="margin-left:0px; cursor: pointer;">Show Password</i> 
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
    
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password" value="{{old('current_password')}}" >
                                <i class="far fa-eye" id="togglePassword" style="margin-left:0px; cursor: pointer;">Show Password</i> 
                                @error('new_confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
   
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>  
<script>
     const togglePassword = document.querySelector('#togglePassword');
     const password = document.querySelector('#password');
 
     togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
</script>
@endsection