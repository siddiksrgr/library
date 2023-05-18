@extends('layouts.admin')

@section('header', 'Member')

@section('content')
<div id="controller">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <a href="#" @click="addData()" data-toggle="modal" data-target="#modal-default" class="btn btn-sm btn-primary pull-right">Create New Member</a>
        </div>
        <div class="card-body table-responsive">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <form :action="actionUrl" method="post" @submit="submitForm($event, data.id)">
        @csrf
        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Member</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" :value="data.name" name="name" id="name" placeholder="Enter name" required autofocus>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" :value="data.email" name="email" id="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="gender">Gender</label>
              <select class="form-control" :value="data.gender" name="gender" id="gender" placeholder="Choose gender" required>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="phone_number">Phone Number</label>
              <input type="number" class="form-control" :value="data.phone_number" name="phone_number" id="phone_number" placeholder="Enter phone number" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" :value="data.address" name="address" id="address" placeholder="Enter address" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var actionUrl = '{{ url('members') }}';
  var apiUrl = '{{ url('api/members') }}';

  var columns = [
    {data: 'DT_RowIndex', class: 'text-center', orderable: 'false'},
    {data: 'name', class: 'text-center', orderable: 'false'},
    {data: 'email', class: 'text-center', orderable: 'false'},
    {data: 'gender', class: 'text-center', orderable: 'false'},
    {data: 'phone_number', class: 'text-center', orderable: 'false'},
    {data: 'address', class: 'text-center', orderable: 'false'},
    {data: 'date', class: 'text-center', orderable: 'false'},
    {render: function(index, row, data, meta) { 
        return `<a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</a> 
        <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a> `;
      }, orderable: false, width: '200px', class: 'text-center' },
  ];
</script>
<script src="{{ asset('js/data.js') }}"></script>
@endsection

