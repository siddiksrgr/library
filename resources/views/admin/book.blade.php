@extends('layouts.admin')

@section('header', 'Book')

@section('content')
<div id="controller">
  <div class="row">
    <div class="col-md-5 offset-md-3">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" class="form-control" autocomplete="off" placeholder="Search from title" v-model="search">
      </div>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary" @click="addData()">Create New Book</button>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12" v-for="book in filteredList">
      <div class="info-box" v-on:click="editData(book)" style="cursor:pointer">
        <div class="info-box-content">
          <span class="info-box-text h5">@{{ book.title }} ( @{{ book.qty }} )</span>
          <span class="info-box-number">Rp. @{{ format(book.price) }},-</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <form :action="actionUrl" method="post" @submit="submitForm($event, book.id)"> 
          @csrf
          <input type="hidden" name="_method" value="PUT" v-if="editStatus">

          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Book</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="number" class="form-control" name="isbn" id="isbn" :value="book.isbn" placeholder="Enter isbn" required>
              </div>
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" :value="book.title" placeholder="Enter title" required>
              </div>
              <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" name="year" id="year" :value="book.year" placeholder="Enter year" required>
              </div>
              <div class="form-group">
                <label>Publisher</label>
                <select name="publisher_id" class="form-control">
                  @foreach($publishers as $publisher)
                  <option :selected="book.publisher_id == {{ $publisher->id  }}" value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Author</label>
                <select name="author_id" class="form-control">
                  @foreach($authors as $author)
                  <option :selected="book.author_id == {{ $author->id  }}" value="{{ $author->id }}">{{ $author->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Katalog</label>
                <select name="catalog_id" class="form-control">
                  @foreach($catalogs as $catalog)
                  <option :selected="book.catalog_id == {{ $catalog->id  }}" value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="qty">Stok</label>
                <input type="number" class="form-control" name="qty" id="qty" :value="book.qty" placeholder="Enter stok" required>
              </div>
              <div class="form-group">
                <label for="price">Harga Pinjam</label>
                <input type="number" class="form-control" name="price" id="price" :value="book.price" placeholder="Enter price" required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default bg-danger" v-if="editStatus" v-on:click="deleteData(book.id)">Delete</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  var actionUrl = '{{ url('books') }}';
  var apiUrl = '{{ url('api/books') }}';

  var controller = new Vue({
    el: "#controller",
    data: {
      books: [],
      search: '', 
      book: {},
      editStatus: false,
      actionUrl,
      apiUrl,
    },
    mounted: function () {
      this.get_books();
    },
    methods: {
      get_books(){
        const _this = this;
        $.ajax({
          url: apiUrl,
          method: 'GET',
          success: function (data) {
            _this.books = JSON.parse(data);
          },
          error: function (error) {
            console.log(error);
          }
        });
      },
      format(x){
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); 
      },
      addData(){
        this.book = {};
        this.editStatus = false;
        $('#modal-default').modal();
      },
      editData(book){
        this.book = book;
        this.editStatus = true;
        $('#modal-default').modal();
      },
      deleteData(id){
        if (confirm("Are you sure?")) {
          axios.post(this.actionUrl + "/" + id, { _method: "DELETE" }).then((response) => {
            $("#modal-default").modal("hide");
            this.get_books();
            alert("Data has been removed"); 
          });
        }
      },
      submitForm(event, id) {
        event.preventDefault();
        const _this = this;
        var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + "/" + id;
        axios.post(actionUrl, new FormData($(event.target)[0]))
        .then((response) => {
            $("#modal-default").modal("hide");
            _this.get_books();
        });
      },
    },
    computed: {
      filteredList() {
        return this.books.filter(book => {
          return book.title.toLowerCase().includes(this.search.toLowerCase())
        })
      }
    }
});
</script>
@endsection