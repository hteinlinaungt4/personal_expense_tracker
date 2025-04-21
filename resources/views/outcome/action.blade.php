<div>
    <a data-id="{{$outcome->id}}" class="btn btn-warning edit-btn"><i class="fas fa-edit"></i> Edit</a>
    <a  href="#" data-url="{{route('outcome.destroy',$outcome->id)}}" class="btn btn-danger delete-btn" > <i class="fas fa-trash"></i> Delete</a>
</div>
