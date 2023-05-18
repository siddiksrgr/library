@extends('layouts.admin')

@section('header', 'Catalog')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <a href="{{ url('catalogs/create') }}" class="btn btn-sm btn-primary pull-right">Create New Catalog</a>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Name</th>
              <th>Total Books</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($catalogs as $key => $catalog)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $catalog->name }}</td>
              <td>{{ count($catalog->books) }}</td>
              <td>{{ convert_date_time($catalog->created_at) }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ url('catalogs/'.$catalog->id.'/edit') }}" class="btn btn-warning btn-sm mr-1">Edit</a>
                  <form action="{{ url('catalogs', ['id' => $catalog->id]) }}" method="post">
                    <input type="submit" value="Delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                    @method('delete') 
                    @csrf()
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-danger text-center">No data</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
