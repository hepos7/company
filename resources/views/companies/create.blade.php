@extends('master')
@section('content')
    <div class="container col-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <h3>Create new company</h3>
        <form  action="/companies" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="Name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
              <label for="Address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Logo</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file"  onchange="loadFile(event)" accept="image/*" class="custom-file-input" name="image" >
                    <label class="custom-file-label" for="exampleInputFile"> Pick Logo</label>
                  </div>
                </div>
              </div>
              
              <div class="col-4">
                <div>
                </div>   
                <div>
                  <img id="showImage"  width="200" height="200" >
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