@extends('layouts.master')
@section('title', 'Categories')

@section('content')

    <!-- Button trigger modal -->
  <div class="d-flex justify-content-end">
    <button id="createBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add Category
    </button>
  </div>

    <table class="table table-bordered table-hover table-striped" id="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="form">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="category_id">
                        <input type="text" name="name" class="form-control" placeholder="Enter Category Name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit " class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var datatable = new DataTable('#datatable', {
                ajax: {
                    url: '{{ route('category.datatable') }}'
                },
                processing: true,
                serverSide: true,
                responsive: true,
                search: true,
                mark: true,
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'actions'
                    },
                ],
            });



            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#category_id').val(id);

                $.ajax({
                    url: '{{ route('category.show', ':id') }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#staticBackdrop').modal('show');
                        $('#staticBackdropLabel').text('Edit Category');
                        $('#form').attr('action', '{{ route('category.update', ':id') }}'
                            .replace(':id', id));
                        $('input[name="name"]').val(response.name);
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        })
                    }

                });
            });

            $("#createBtn").click(function() {
                $('#staticBackdrop').modal('show');
                $('#category_id').val('');
                $('#staticBackdropLabel').text('Add Category');
                $('#form').attr('action', '{{ route('category.store') }}');
                $('input[name="name"]').val('');
            });



            $('#form').submit(function(e) {
                e.preventDefault();
                var id = $('#category_id').val();

                var name = $('input[name="name"]').val();
                var url = id ? '{{ route('category.update', ':id') }}'.replace(':id', id) :
                    '{{ route('category.store') }}';

                $.ajax({
                    url: url,
                    type: id ? 'PUT' : 'POST',
                    data: {
                        name: name,
                    },
                    success: function(response) {
                        $('#staticBackdrop').modal('hide');
                        datatable.draw();
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success'
                        })
                    },
                    error: function(response) {
                        $('#form')[0].reset();
                        var errors = response.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>';
                        });
                        Swal.fire({
                            title: 'Error',
                            html: '<ul>' + errorHtml + '</ul>',
                            icon: 'error'
                        });
                    }
                });

            });


            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: 'Delete',
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                    timer: 1500
                                });
                                datatable.ajax.reload();
                            },
                            error: function(response) {
                                var errors = response.responseJSON.errors;
                                var errorHtml = '';
                                $.each(errors, function(key, value) {
                                    errorHtml += '<li>' + value + '</li>';
                                });
                                Swal.fire({
                                    title: 'Error',
                                    html: '<ul>' + errorHtml + '</ul>',
                                    icon: 'error'
                                });
                            }

                        });

                    }
                });


            })


        });
    </script>
@endpush
