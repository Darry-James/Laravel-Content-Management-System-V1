@extends('layouts.app')




@section('content')

@auth

<div class="d-flex justify-content-end mb-2">
<a href="{{route('categories.create')}}" class="btn btn-success float-right">Add Category</a>

</div>


<div class="card card-default">
<div class="card-header">Categories</div>
<div class="card-body">

@if ($categories->count() > 0 )

<table class="table">
<thead>
<th>Name</th>
<th></th>

</thead>

<tbody>
@foreach($categories as $category)

<tr>

<td>

{{$category->name}}


</td>

<td>  
<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm">Edit
</a>


<button class="btn btn-danger btn-sm" onclick="handleDelete({{ $category->id }})">Delete</button>


</td>



</tr>

@endforeach

</tbody>
</table>



<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="POST" id="deleteCategoryForm">

    @method('DELETE')

    @csrf
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <span class="text-center text-bold">Are you sure you want to delete this category ?</span>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-danger">Yes, Delete</button>

      <button type="button" class="btn btn-info" data-dismiss="modal">No, Go back<button>
       
      </div>
    </div>
    
    
    </form>
  </div>
</div>
<!-- End Modal -->

@else
<h3 class="text-center">No Categories Yet.</h3>

@endif


</div>


@else



<span class="list-group-item text-danger">Please login to continue.</span>

</div>

@endauth

@endsection


@section('scripts')

<script>
function handleDelete(id) {

var form = document.getElementById('deleteCategoryForm')
form.action= 'categories/' + id 
$('#deleteModal') .modal('show')



}

</script>

@endsection