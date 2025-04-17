@extends('layouts.master')
@section('title', 'Categories')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" id="createBtn">
                    <i class="fa fa-plus-circle"></i> Create
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="categoryTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr id="row-{{ $category->id }}">
                            <td class="cat-name">{{ $category->name }}</td>
                            <td class="cat-created">{{ $category->created_at->format('d-m-Y h:i:s A') }}</td>
                            <td class="cat-updated">{{ $category->updated_at->format('d-m-Y h:i:s A') }}</td>
                            <td>
                                <button class="btn btn-primary edit-btn" data-id="{{ $category->id }}">Edit</button>
                                <button class="btn btn-danger delete-btn" data-id="{{ $category->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form">
                    @csrf
                    <input type="hidden" id="categoryId">
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control" id="categoryName" placeholder="Enter category name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="formSubmitBtn">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Open modal for create
        $('#createBtn').on('click', function () {
            $('#form')[0].reset();
            $('#categoryId').val('');
            $('#staticBackdropLabel').text('Create Category');
            $('#formSubmitBtn').text('Create');
            $('#staticBackdrop').modal('show');
        });

        // Edit Category
        $(document).on('click', '.edit-btn', function () {
            const id = $(this).data('id');

            $.get('/category/' + id, function (data) {
                $('#categoryId').val(data.id);
                $('#categoryName').val(data.name);
                $('#staticBackdropLabel').text('Edit Category');
                $('#formSubmitBtn').text('Update');
                $('#staticBackdrop').modal('show');
            });
        });

        // Create/Update Submit
        $('#form').on('submit', function (e) {
            e.preventDefault();
            const id = $('#categoryId').val();
            const name = $('#categoryName').val();
            const url = id ? `/category/${id}` : `{{ route('category.store') }}`;
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function (res) {
                    $('#staticBackdrop').modal('hide');
                    $('#form')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: id ? 'Updated!' : 'Created!',
                        text: res.message
                    });

                    const now = new Date();
                    const createdAt = now.toLocaleString('en-GB');

                    if (id) {
                        const row = $('#row-' + id);
                        row.find('.cat-name').text(name);
                        row.find('.cat-updated').text(createdAt);
                    } else {
                        $('#categoryTable tbody').append(`
                            <tr id="row-${res.id}">
                                <td class="cat-name">${name}</td>
                                <td class="cat-created">${createdAt}</td>
                                <td class="cat-updated">${createdAt}</td>
                                <td>
                                    <button class="btn btn-primary edit-btn" data-id="${res.id}">Edit</button>
                                    <button class="btn btn-danger delete-btn" data-id="${res.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.message
                    });
                }
            });
        });

        // Delete Category
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/category/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            $('#row-' + id).remove();
                            Swal.fire('Deleted!', res.message, 'success');
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseText, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
