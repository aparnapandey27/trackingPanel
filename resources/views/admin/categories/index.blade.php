@extends('admin.layout.app')
@section('title', 'Categories')

@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-4">{{__('Offers Categories')}}</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item">
								<a href="javascript: void(0);">{{__('Offers')}}</a>
							</li>
							<li class="breadcrumb-item active">{{__('Offers Categories')}}</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->
		<div class="card mb-4">
			<div class="card-body">
				<div class="row g-2 align-items-center">
					<div class="col-sm-6">
						<h4 class="m-0 font-weight-bold text-primary">Categories</h4>
					</div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
					<div class="col-sm-auto ms-auto">
						<div class="list-grid-nav hstack gap-1">
							<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#category">Add Category</button>
						</div>
					</div>
					<!--end col-->
				</div>
				<!--end row-->
			</div>
		</div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 shadow-lg border-left-dark">                    
                    <div class="card-body">
                        <div class="table-response">
                            <table class="table table-borderless table-hover table-striped categories" id="categories">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="category">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class=" form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control name" name="name" id="name" required
                                    placeholder="Category Name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="addCategory()">Add Category</button>
                        </div>
                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="categoryEdit" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="catName">Category Name</label>
                                <input type="text" class="form-control" name="name" id="catName" required placeholder="Category Name" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="updateCategory()">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <!-- DataTables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SweetAlert2-->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function() {
            $('#categories').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('admin.categories.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        function addCategory() {
            var category_name = $('.name').val();
            let _url = `/admin/offer/categories`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    name: category_name,
                    // _token: _token
                },

                success: function(data) {
                    console.log(data);
                    $('.name').val('');
                    $('#categories').DataTable().ajax.reload();
                    $('#category').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Categry has been Added',
                        showConfirmButton: false,
                        timer: 5000
                    })
                }
            })
        }


        function editCategory(id) {
            console.log('editCategory function called'); // Debugging line
            let _url = `/admin/offer/categories/${id}/edit`;
            $.ajax({
                url: _url,
                type: 'GET',
                success: function (res) {
                    console.log(res);
                    $('#categoryEdit').modal('show');
                    $('#category_id').val(res.id);
                    $('#catName').val(res.name);
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error: ' + error); // Debugging line
                }
            });
        }



        function updateCategory() {
            var category_name = $('#catName').val();
            var id = $('#category_id').val();
            let _url = `/admin/offer/categories/${id}`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "PUT",
                data: {
                    name: category_name,
                    // _token: _token
                },
                success: function(data) {
                    console.log(data)
                    $('#categories').DataTable().ajax.reload();

                    $('#categoryEdit').modal('hide');

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Categry has been updated',
                        showConfirmButton: false,
                        timer: 5000
                    })
                },
                error: function(response) {
                    $('#taskError').text(response.responseJSON.errors);
                }
            });
        }


        function deleteCategory(id) {
            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    $.ajax({
                        url: `/admin/offer/categories/${id}`,
                        type: 'DELETE',

                        success: function(res) {
                            $('#categories').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Categry has been deleted',
                                showConfirmButton: false,
                                timer: 5000
                            })
                        },
                        error: function(res) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                timer: 5000
                            })
                        }
                    })

                }
            })
        }
    </script>

@endpush
