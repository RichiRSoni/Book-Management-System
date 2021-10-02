@extends('layouts.userMaster')

@section('content')
    <div class="container"> 
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- &lt;div id="app"&gt; --}}
                @include('flash-message')
                <div class="card-header">
                    <center><h3>Your Profile</h3></div></center>
                    <br/>
                <div class="card-body">
                    <form method="post" >
                        
                        @csrf 
   
                         {{-- @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach  --}}
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Name</label>
                            
                            <div class="col-md-6">
                                {{-- @foreach($abc as $user) --}}
                                <input id="password" type="text"  name="name" class="form-control @error('name') is-invalid @enderror" value="{{auth()->user()->name}}" autocomplete="current-password">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Email</label>
  
                            <div class="col-md-6">
                                <input id="new_password" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{auth()->user()->email}}" autocomplete="current-password">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                        </div>
     
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                {{-- <button type="submit" class="btn btn-primary"> --}}
                                    <a href="{{route('profile.edit',auth()->user()->id)}}" class="btn btn-primary">Edit Profile</a>
            
                                {{-- </button> --}}
                            </div>
                        </div>
                        {{-- @endforeach --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection