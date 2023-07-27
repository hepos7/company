@extends('master')
@section('content')
    <div class="container col-4">
        
        <h3>Edit Employee</h3>
        <form  action="/employees/{{ $employee->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="Name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}">
            </div>
            <div class="mb-3">
              <label for="Address" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}">
            </div>
            <div class="mb-3">
              <label for="Password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
              <label for="Password Confirmation" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <label for="Company">Company</label>
              <select name="company_id" class="form-control" >
              @foreach($companies as $company)
                <option value="{{  $company->id }}"@if ($employee->company_id==$company->id) selected @endif >{{$company->name  }}</option>
              @endforeach
            </select>
            <div class="form-group">
                <label for="exampleInputFile">Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file"   onchange="loadFile(event)" accept="image/*" class="form-control" name="image" >
                    <label class="custom-file-label" for="exampleInputFile"> Pick Image</label>
                  </div>
                </div>
              </div>
              
              <div class="col-4">
                <div>
                </div>   
                <div>
                  <img id="showImage" src="{{ url('storage/' . $employee->image) }}"  width="200" height="200" >
                </div>               
                
              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          <div class="col-5">
            @if ($errors->any())
                <div class="text-left p-20">
                    @foreach ($errors->all() as $error )
                        <li class=" text-danger ">
                            {{ $error }}
                        </li>
                    @endforeach
            
                </div>
            @endif
          </div>
    </div>

    <script>
        var loadFile = function(event) {
          var image = document.getElementById('showImage');
          image.src = URL.createObjectURL(event.target.files[0]);
        };
        
      </script> 
@endsection