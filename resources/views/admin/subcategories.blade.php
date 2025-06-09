@extends('masterlayout')

@section('title', 'Admin Dashboard')

@section('data')

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0 rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="text-primary">Manage SubCategories</h4>
                    <button type="button" class="btn btn-primary" id="addSubCategoryBtn">
                        <i class="fa fa-plus mr-2"></i> Add SubCategory
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
                            <input type="text" class="searchInput form-control" placeholder="Subcategory Name">
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
                                <th>Category</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $subcategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ App\Models\Category::where('id', $subcategory->category_id)->value('name') }}
                                    </td>
                                    <td>
                                        @if ($subcategory->image)
                                            <img src="{{ asset($subcategory->image) }}" alt="SubCategory Image"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $subcategory->status }}</td>
                                    <td>{{ $subcategory->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning editBtn" data-id="{{ $subcategory->id }}"
                                            data-name="{{ $subcategory->name }}" data-image="{{ $subcategory->image }}"
                                            data-status="{{ $subcategory->status }}"
                                            data-category-id="{{ $subcategory->category_id }}">
                                            <i class="fas fa-edit"></i>

                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $subcategory->id }}"><i
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
    <div class="modal fade" id="subCategoryModal" tabindex="-1" role="dialog" aria-labelledby="subCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="subCategoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="subcat_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center fw-bold" id="subCategoryModalLabel">Add SubCategory</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="category_id">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control form-control-lg" required>
                                <option value="">-- Select Category --</option>
                                @foreach (\App\Models\Category::where('status', 'Active')->get() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text category_id_error"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">SubCategory Name</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name"
                                placeholder="Subcategory Name" required>
                            <span class="text-danger error-text name_error"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control form-control-lg" name="image" id="image">
                            <span class="text-danger error-text image_error"></span>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control form-control-lg">
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

            $('#addSubCategoryBtn').click(() => {
                $('#subCategoryForm')[0].reset();
                $('#imagePreview').html('');
                $('#subcat_id').val('');
                $('#subCategoryModalLabel').text('Add SubCategory');
                $('.error-text').text('');
                $('#subCategoryModal').modal('show');
            });

            $(document).on('click', '.editBtn', function() {
                console.log("Edit button clicked");

                const id = $(this).data('id');
                const name = $(this).data('name');
                const categoryId = $(this).data('category-id');
                const image = $(this).data('image');
                const status = $(this).data('status');
                console.log("ID:", id, "Name:", name, "Image:", image, "Status:", status);


                $('#subcat_id').val(id);
                console.log("Category ID:", categoryId);
                $('#name').val(name);
                $('#category_id').val(categoryId);


                if (image) {
                    $('#imagePreview').html(
                        `<img src="/${image}" alt="Category Image" style="width: 50px; height: 50px; object-fit: cover;">`
                    );
                }
                $('select[name="status"]').val(status);

                $('#subCategoryModal').modal('show');
                $('#subCategoryModalLabel').text('Edit SubCategory');
            });

            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).data('id');
                console.log("Delete button clicked for ID:", id);

                $.ajax({
                    url: '{{ route('admin.deleteSubCategory') }}',
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

            $('#subCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#subcat_id').val();
                console.log(id);

                $.ajax({
                    url: '{{ route('admin.subcategory') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert("SubCategory saved successfully!");
                            $('#subCategoryModal').modal('hide');
                            location.reload();
                        } else {
                            alert("SubCategory not saved!");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error while saving subcategory:" + xhr.responseText);
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
            //             data: "subcategory",
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
        //                             <td>${value.category_id ? value.category_id : 'N/A'}</td>
        //                             <td>
        //                                 ${value.image
        //                                     ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
        //                                     : `<span>No Image</span>`}
        //                             </td>
        //                             <td>${value.status}</td>
        //                             <td>${new Date(value.created_at).toLocaleString()}</td>

        //                             <td>
        //                                 <div class="d-flex gap-1">
        //                                     <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}"
        //                                     data-category-id="${value.category_id ? value.category_id : 'N/A'}" data-image="${value.image}" data-status="${value.status}"><i class="fas fa-edit"></i>
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
            //                     '<tr><td colspan="12" class="text-center">No subcategories found</td></tr>'
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
                        .val());
                    $.post('{{ route('filter-data') }}', {
                        _token: '{{ csrf_token() }}',
                        data: 'subcategory',
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
                                data: "subcategory",
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
                                data: "subcategory",
                                from: from,
                                to: to,
                            },
                            success: function(response) {
                                console.log(response);
                                $("tbody").empty();
                                loadData(response);
                            },
                            error: function(xhr) {
                                alert('ERROR');
                            }
                        });
                    } else {
                        alert("Invalid search type.");
                    }
                }

            });

            function loadData(response) {
                if (response.length === 0) {
                    $('tbody').append(
                        '<tr><td colspan="12" class="text-center">No Subcategories found</td></tr>'
                    );
                    return;
                }
                $.each(response, function(key, value) {
                    $('tbody').append(
                        `<tr>
                            <td>${key+1}</td>
                            <td>${value.name}</td>
                            <td>${value.category_id ? value.category_id : 'N/A'}</td>
                            <td>
                                ${value.image
                                    ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
                                    : `<span>No Image</span>`}
                            </td>
                            <td>${value.status}</td>
                            <td>${new Date(value.created_at).toLocaleString()}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}"
                                    data-category-id="${value.category_id ? value.category_id : 'N/A'}" data-image="${value.image}" data-status="${value.status}"><i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`
                    );
                });
            }


            $('#reset').on('click', function() {
                $('#from').val('');
                $('#to').val('');
                $('.searchInput').val('');

                $.ajax({
                    url: '{{ route('admin.subcategorysData') }}',
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        response = typeof response === 'string' ? JSON.parse(response) :
                            response;
                        $("tbody").empty();
                        loadData(response.data);
                    },
                    error: function(xhr) {
                        console.error("error");
                    },
                });

            });
        });
    </script>
@endpush
