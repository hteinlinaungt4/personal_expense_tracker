<div>
    <a data-id="{{$model->id}}" class="btn btn-warning edit-btn"><i class="fas fa-edit"></i> Edit</a>
    <a  href="#" data-url="{{route('category.destroy',$model->id)}}" class="btn btn-danger delete-btn" > <i class="fas fa-trash"></i> Delete</a>
</div>
