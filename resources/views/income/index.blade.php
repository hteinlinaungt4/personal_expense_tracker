@extends('layouts.master')
@section('title', 'Income')
@section('income', 'active')
@section('content')

    <!-- Button trigger modal -->
  <div class="d-flex justify-content-end">
    <button id="createBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add Income
    </button>
  </div>

    <table class="table table-bordered table-hover table-striped" id="datatable">
        <thead>
            <tr>
                <th>Category</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
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
                    <input type="hidden" name="income_id" id="income_id">
                    <div class="modal-body">
                        @csrf
                        <select class="form-control mb-3" name="category_id" id="">
                          <option value="">Select Category</option>
                          @foreach ($categories as $category)
                            <option value="{{$category->id}}" @selected(old('category_id') == $category->id)  >{{$category->name}}</option>
                          @endforeach
                        </select>
                        <textarea name="description" id=""class="form-control mb-3" rows="10" placeholder="Enter Description"></textarea>
                        <input type="number" class="form-control" name="amount" placeholder="Enter Amount">
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
                    url: '{{ route('income.datatable') }}'
                },
                processing: true,
                serverSide: true,
                responsive: true,
                search: true,
                mark: true,
                columns: [
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'actions'
                    },
                ],
            });



            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#income_id').val(id);

                $.ajax({
                    url: '{{ route('income.show', ':id') }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#staticBackdrop').modal('show');
                        $('#staticBackdropLabel').text('Edit Category');
                        $('#form').attr('action', '{{ route('category.update', ':id') }}'
                            .replace(':id', id));
                        $('textarea[name="description"]').val(response.description);
                        $('input[name="amount"]').val(response.amount);
                        $('select[name="category_id"]').val(response.category_id);

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
                $('#income_id').val('');
                $('#staticBackdropLabel').text('Add Category');
                $('#form').attr('action', '{{ route('income.store') }}');
                $('input[name="description"]').val('');
                $('input[name="amount"]').val('');
                $('select[name="category_id"]').val('');
            });



            $('#form').submit(function(e) {
                e.preventDefault();
                var id = $('#income_id').val();

                var description = $('textarea[name="description"]').val();
                var category_id = $('select[name="category_id"]').val();
                var amount = $('input[name="amount"]').val();
                var url = id ? '{{ route('income.update', ':id') }}'.replace(':id', id) :
                    '{{ route('income.store') }}';

                $.ajax({
                    url: url,
                    type: id ? 'PUT' : 'POST',
                    data: {
                        description: description,
                        category_id: category_id,
                        amount: amount
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
