@extends('layouts.admin')

@section('header', 'Catalog')

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Catalog</h3>
      </div>
      <form action="{{ url('catalogs/'.$catalog->id) }}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="card-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" value="{{ $catalog->name }}" name="name" id="name" placeholder="Enter name catalog" required autofocus>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
