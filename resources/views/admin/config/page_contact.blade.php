@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
  </ol>
  <h1 class="page-title">Contact</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="pageContact">
       <div class="row">
            <div class="form-group col-md-6">
              <label class="form-control-label">Telephone</label>
              <input type="text" class="form-control" name="telephone" 
                placeholder="Telephone" value="{{ isset($config['telephone']) ? $config['telephone'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">Email ID</label>
              <input type="text" class="form-control" name="email" 
                placeholder="Email ID" value="{{ isset($config['email']) ? $config['email'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
                <label class="form-control-label">Address</label>
                <textarea name="address" class="form-control">{{ isset($config['address']) ? $config['address'] : '' }}</textarea>
            </div>

            <div class="form-group col-md-6">
                <label class="form-control-label">Map Iframe Code</label>
                <textarea name="map" class="form-control">{{ isset($config['map']) ? $config['map'] : '' }}</textarea>
            </div>

        </div>

      <hr>
      <div class="form-group row">
        <div class="col-md-4">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-default btn-outline">Reset</button>
        </div>
      </div>
      
    </form>
  </div>
</div>

       
      <!-- End Panel Basic -->
</div>

@endsection
