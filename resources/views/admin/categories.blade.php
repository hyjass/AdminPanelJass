@extends('masterlayout')

@section('title', 'Admin Dashboard')

@section('data')

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0 rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="text-primary">Manage Categories</h4>
                    <button type="button" class="btn btn-primary" id="addCategoryBtn">
                        <i class="fa fa-plus mr-2"></i> Add Category
                    </button>
                </div>

                <div class="table-responsive">
                    <div class="d-flex justify-content-between mb-3 gap-4">

                        <div class="d-flex justify-content-left align-items-center gap-2">
                            <input type="text" class="form-control datepicker" id="from" name="from"
                                autocomplete="off" placeholder="FROM" style="height: -webkit-fill-available;">
                            <input type="text" class="form-control datepicker" id="to" name="to"
                                autocomplete="off" placeholder="TO" style="height: -webkit-fill-available;">
                            <button type="submit" class="btn btn-primary searchBtn" data-type="date"><i
                                    class="fas fa-search"></i>
                            </button>
                        </div>



                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <input type="text" class="searchInput form-control" placeholder="Category Name">
                            <button type="submit" class="btn btn-primary searchBtn" data-type="name"><i
                                    class="fas fa-search"></i>
                            </button>
                        </div>

                        <div class="d-flex ">
                            <button class="btn btn-primary" id="reset">Reset</button>
                        </div>

                    </div>

                    <table id="datatable" class="table table-hover table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="/{{ $category->image }}" alt="Category Image"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>{{ $category->status }}</td>
                                    <td>{{ $category->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning editBtn" id="editCategoryBtn"
                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                            data-image="{{ $category->image }}" data-status="{{ $category->status }}">
                                            <i class="fas fa-edit"></i>

                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $category->id }}"><i
                                                class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="cat_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center fw-bold" id="categoryModalLabel">Add Category</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-lg" name="name" id="name"
                                placeholder="Category name" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="form-group mb-3">
                            <input type="file" class="form-control form-control-lg" name="image" id="image">
                            <span class="text-danger error-text image_error"></span>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="form-group mb-3">
                            <select name="status" class="form-control form-control-lg" aria-placeholder="status">
                                <option value="">--Select Status--</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Open modal for add
            $('#addCategoryBtn').click(() => {
                $('#categoryForm')[0].reset();
                $('#imagePreview').html('');
                $('#cat_id').val('');
                $('#categoryModalLabel').text('Add Category');
                $('.error-text').text('');
                $('#categoryModal').modal('show');
            });

            $(document).on('click', '.editBtn', function() {
                console.log("Edit button clicked");

                const id = $(this).data('id');
                const name = $(this).data('name');
                const image = $(this).data('image');
                const status = $(this).data('status');
                console.log("ID:", id, "Name:", name, "Image:", image, "Status:", status);


                $('#cat_id').val(id);
                $('#name').val(name);

                if (image) {
                    $('#imagePreview').html(
                        `<img src="/${image}" alt="Category Image" style="width: 50px; height: 50px; object-fit: cover;">`
                    );
                }
                $('select[name="status"]').val(status);

                $('#categoryModal').modal('show');
                $('#categoryModalLabel').text('Edit Category');
            });

            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.deletecategory') }}',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        alert('Deleted successfully');
                        location.reload();
                    },
                    error: function() {
                        alert("Error while deleting");
                    }
                });
            });

            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#cat_id').val();
                console.log(id);

                $.ajax({
                    url: '{{ route('admin.category') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert("Category saved successfully!");
                            $('#categoryModal').modal('hide');
                            location.reload();
                        } else {
                            alert("Category not saved!");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error while saving category:" + xhr.responseText);
                    }
                });
            });

            // $('.searchInput').on('input', function() {
            //     const x = $(this).val(); // updated value of the input
            //     console.log("Value is " + x);

            //     $.ajax({
            //         url: '{{ route('common.getdata') }}',
            //         type: 'POST',
            //         data: {
            //             data: "category",
            //             search: x,
            //         },
            //         success: function(response) {
            //             console.log(response);

            //             $("tbody").empty(); // Clear existing rows
            //             $.each(response, function(key, value) {
            //                 $('tbody').append(
            //                     `<tr>
        //                             <td>${key+1}</td>
        //                             <td>${value.name}</td>
        //                             <td>
        //                                 ${value.image
        //                                     ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
        //                                     : `<span>No Image</span>`}
        //                             </td>
        //                             <td>${value.status}</td>

        //                             <td>${new Date(value.created_at).toLocaleString()}</td>

        //                             <td>
        //                                 <div class="d-flex gap-1">
        //                                     <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-status="${value.status}"><i class="fas fa-edit"></i>
        //                                     </button>
        //                                     <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
        //                                     </button>
        //                                 </div>
        //                             </td>

        //                     </tr>`
            //                 );
            //             });
            //             if (response.length === 0) {
            //                 $('tbody').append(
            //                     '<tr><td colspan="12" class="text-center">No categories found</td></tr>'
            //                 );
            //             }
            //         },
            //         error: function() {
            //             alert("Error while searching");
            //         }

            //     });

            // });

            $('.searchBtn').click(function() {
                if ($('#from').val() && $('#to').val() && $('.searchInput').val()) {
                    console.log($('#from').val() + " " + $('#to').val() + " " + $('.searchInput')
                        .val())
                    $.post('{{ route('filter-data') }}', {
                        _token: '{{ csrf_token() }}',
                        data: 'category',
                        from: $('#from').val(),
                        to: $('#to').val(),
                        search: $('.searchInput').val()
                    }, function(response) {
                        console.log(response);
                        $("tbody").empty();
                        loadData(response);
                    });
                } else {

                    const type = $(this).data('type');

                    if (type === "name") {
                        const searchValue = $(this).siblings('.searchInput').val();
                        console.log("Search Type:", type);
                        console.log("Search Value:", searchValue);
                        $.ajax({
                            url: '{{ route('common.getdata') }}',
                            type: 'POST',
                            data: {
                                data: "category",
                                search: searchValue,
                            },
                            success: function(response) {
                                console.log(response);
                                $("tbody").empty();
                                loadData(response);
                            },
                            error: function() {
                                alert("Error while searching");
                            }
                        });

                    } else if (type == "date") {
                        const from = $('#from').val();
                        const to = $('#to').val();
                        console.log("From:", from, "To:", to);
                        if (!from || !to) {
                            alert("Please select both FROM and TO dates.");
                            return;
                        }
                        $.ajax({
                            url: '{{ route('common.getdatedata') }}',
                            type: 'POST',
                            data: {
                                data: "category",
                                from: from,
                                to: to,
                            },
                            success: function(response) {
                                console.log(response);
                                $("tbody").empty();
                                loadData(response);
                            },
                            error: function(xhr) {
                                let errMsg = xhr.responseJSON?.error || 'Something went wrong';
                                alert('Error: ' + errMsg);
                                console.error('Error details:', xhr.responseText);
                            }
                        });
                    } else {
                        alert("Invalid search type.");
                    }
                }
            });


            $('#reset').on('click', function() {
                $('#from').val('');
                $('#to').val('');
                $('.searchInput').val('');

                // window.location.reload();
                $.ajax({
                    url: '{{ route('admin.categorysData') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        response = typeof response === 'string' ? JSON.parse(response) :
                            response;
                        // response = ();
                        $("tbody").empty();
                        loadData(response.data);
                    },
                    error: function(xhr) {
                        console.error("error");
                    },
                });

            });


            function loadData(response) {
                if (response.length === 0) {
                    $('tbody').append(
                        '<tr><td colspan="18" class="text-center">No Categories found</td></tr>'
                    );
                    return;
                }
                $.each(response, function(key, value) {
                    $('tbody').append(
                        `<tr>
                            <td>${key+1}</td>
                            <td>${value.name}</td>
                            <td>
                                ${value.image 
                                    ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
                                    : `<span>No Image</span>`}
                            </td>
                            <td>${value.status}</td>
                            <td>${new Date(value.created_at).toLocaleString()}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-status="${value.status}"><i class="fas fa-edit"></i>
                                        </button>
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
                                        </button>
                                </div>  
                            </td>
                            
                    </tr>`
                    );
                });
            }


        });
    </script>
@endpush
