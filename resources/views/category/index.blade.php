@extends('layouts.master')
@section('title', 'Categories')

@section('content')
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fa fa-plus-circle"></i> Create
                </button>
            </div>


        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Name</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Salary</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Category Create Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm">
                    @csrf
                    <div class="modal-body">
                        <input type="text" id="categoryName" class="form-control" placeholder="Please Enter Category Name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();

            let name = $('#categoryName').val();
            let token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route("category.store") }}', // Adjust to your route
                type: 'POST',
                data: {
                    _token: token,
                    name: name
                },
                success: function (response) {
                    $('#staticBackdrop').modal('hide');
                    $('#categoryForm')[0].reset();

                    // Optional: Show success message or update category list
                    alert('Category created successfully!');
                },
                error: function (xhr) {
                    // Optional: Show error
                    alert('Error occurred: ' + xhr.responseJSON.message);
                }
            });

        }) });
</script>
@endpush


