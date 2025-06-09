@extends('masterlayout')

@section('title', 'Admin Dashboard')

@section('data')
    <div class="container-fluid mt-3">
        <div class="card shadow-sm border-0 rounded">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between mb-3">
                    <h4 class="text-primary mb-2 mb-md-0">Manage Products</h4>
                    <button type="button" class="btn btn-primary" id="addProductBtn">
                        <i class="fa fa-plus mr-2"></i> Add Product
                    </button>
                </div>

                <!-- Responsive Table Wrapper -->
                <div class="table-responsive">

                    <div class="d-flex justify-content-between mb-3 gap-4">

                        <div class="d-flex justify-content-left align-items-center gap-2">
                            <input type="text" class="form-control datepicker" id="from" name="from"
                                autocomplete="off" placeholder="FROM" style="height: -webkit-fill-available;">
                            <input type="text" class="form-control datepicker" id="to" name="to"
                                autocomplete="off" placeholder="TO" style="height: -webkit-fill-available;">
                            <button type="submit" class="btn btn-primary searchBtn" data-type="date">
                                <i class="fas fa-search"></i>

                            </button>
                        </div>



                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <input type="text" class="searchInput form-control" placeholder="Product Name">
                            <button type="submit" class="btn btn-primary searchBtn" data-type="name"><i
                                    class="fas fa-search"></i>
                            </button>
                        </div>

                        <div class="d-flex ">
                            <button class="btn btn-primary" id="reset">Reset</button>
                        </div>


                    </div>
                    <table id="datatable" class="table table-hover table-bordered align-middle text-nowrap">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Subcategory</th>
                                <th>Created At</th>
                                <th>Specification</th>
                                <th>Image</th>
                                <th>Rate</th>
                                <th>Unit</th>
                                <th>Discount</th>
                                <th>Final Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ App\Models\Subcategory::find($product->subcategory_id)->name ?? 'N/A' }}</td>
                                    <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ $product->specifications }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset($product->image) }}" alt="Product Image"
                                                class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $product->rate }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->final_amount }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-warning editBtn" data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}" data-image="{{ $product->image }}"
                                                data-status="{{ $product->status }}"
                                                data-subcategory-id="{{ $product->subcategory_id }}"
                                                data-specification="{{ $product->specifications }}"
                                                data-rate="{{ $product->rate }}" data-unit="{{ $product->unit }}"
                                                data-quantity="{{ $product->quantity }}"
                                                data-discount="{{ $product->discount }}"
                                                data-final-amount="{{ $product->final_amount }}">
                                                <i class="fas fa-edit"></i>

                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $product->id }}">
                                                <i class="fas fa-trash-alt"></i>

                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive -->
            </div>
        </div>
    </div>



    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="productForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="product_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center fw-bold" id="productModalLabel">Add Product</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Product Name -->
                        <div class="form-group mb-3">
                            <input type="text" name="name" id="name" class="form-control form-control-lg"
                                placeholder="Product Name" required>
                        </div>

                        <!-- SubCategory -->
                        <div class="form-group mb-3">
                            <select name="subcategory_id" id="subcategory_id" class="form-control form-control-lg" required>
                                <option value="">-- Select SubCategory --</option>
                                @foreach (\App\Models\Subcategory::where('status', 'Active')->get() as $subcat)
                                    <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text subcategory_id_error"></span>
                        </div>

                        <!-- Specification -->
                        <div class="form-group mb-3">
                            <textarea name="specifications" id="specifications" class="form-control form-control-lg" rows="3"
                                placeholder="Enter detailed specification..."></textarea>
                        </div>

                        <!-- Image -->
                        <div class="form-group mb-3">
                            <input type="file" class="form-control form-control-lg" name="image" id="image"
                                placeholder="Image">
                            <span class="text-danger error-text image_error"></span>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <!-- Rate -->
                        <div class="form-group mb-3">
                            <input type="number" id="rate" name="rate" class="form-control form-control-lg"
                                placeholder="Rate" step="0.01">
                        </div>

                        <!-- Unit -->
                        <div class="form-group mb-3">
                            <input type="text" id="unit" name="unit" class="form-control form-control-lg"
                                placeholder="Units">
                        </div>

                        <!-- Discount -->
                        <div class="form-group mb-3">
                            <input type="number" id="discount" name="discount" class="form-control form-control-lg"
                                placeholder="Discount" step="0.01">
                        </div>

                        <!-- Final Amount -->
                        <div class="form-group mb-3">
                            <input type="number" id="final_amount" name="final_amount"
                                class="form-control form-control-lg" placeholder="Final Amount">
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <select name="status" class="form-control form-control-lg" id="status">
                                <option value="">--Select Status--</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2">Save Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>


@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#addProductBtn').click(() => {
                $('#productForm')[0].reset();
                $('#imagePreview').html('');
                $('#product_id').val('');
                $('#productModalLabel').text('Add Product');
                $('.error-text').text('');
                $('#productModal').modal('show');
            });

            $(document).on('click', '.editBtn', function() {
                console.log("Edit button clicked");

                const id = $(this).data('id');
                const name = $(this).data('name');
                const subcategoryId = $(this).data('subcategory-id');
                const image = $(this).data('image');
                const status = $(this).data('status');
                const specification = $(this).data('specification');
                const rate = $(this).data('rate');
                const unit = $(this).data('unit');
                const quantity = $(this).data('quantity');
                const discount = $(this).data('discount');
                const finalAmount = $(this).data('final-amount');

                $('#name').val(name);
                $('#product_id').val(id);
                $('#subcategory_id').val(subcategoryId);
                $('#specifications').val(specification);
                $('#rate').val(rate);
                $('#unit').val(unit);
                $('#discount').val(discount);
                $('#final_amount').val(finalAmount);
                if (image) {
                    $('#imagePreview').html(
                        `<img src="/${image}" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover;">`
                    );
                }
                $('select[name="status"]').val(status);
                $('#productModal').modal('show');
                $('#productModalLabel').text('Edit Product');

            });


            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.deleteProduct') }}',
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


            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                // console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.productstore') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Product saved successfully!');
                            window.location.reload();
                        } else {
                            alert('Error saving product.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('An error occurred while saving the product.');
                    }
                });
            });



            //             $('.searchInput').on('input', function() {
            //                 const x = $(this).val(); // updated value of the input
            //                 console.log("Value is " + x);

            //                 $.ajax({
            //                     url: '{{ route('common.getdata') }}',
            //                     type: 'POST',
            //                     data: {
            //                         data: "product",
            //                         search: x,
            //                     },
            //                     success: function(response) {
            //                         console.log(response);

            //                         $("tbody").empty(); // Clear existing rows
            //                         $.each(response, function(key, value) {
            //                             $('tbody').append(
            //                                 `<tr>
        //                                     <td>${key+1}</td>
        //                                     <td>${value.name}</td>
        //                                     <td>${value.subcategory_id ? value.subcategory_id : 'N/A'}</td>
        //                                     <td>${new Date(value.created_at).toLocaleString()}</td>
        //                                     <td>${value.specifications}</td>
        //                                     <td>
        //                                             ${value.image
        //                                                 ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
        //                                                 : `<span>No Image</span>`}
        //                                         </td>
        //                                     <td>${value.rate}</td>
        //                                     <td>${value.unit}</td>
        //                                     <td>${value.discount}</td>
        //                                     <td>${value.final_amount}</td>
        //                                     <td>${value.status}</td>
        //                                     <td>
        //                                         <div class="d-flex gap-1">
        //                                             <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-status="${value.status}" data-subcategory-id="${value.subcategory_id}" data-specification="${value.specifications}" data-rate="${value.rate}" data-unit="${value.unit}" data-quantity="${value.quantity}" data-discount="${value.discount}" data-final-amount="${value.final_amount}"><i class="fas fa-edit"></i>
        // </button>
        //                                             <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
        // </button>
        //                                         </div>
        //                                     </td>
        //                                 </tr>`
            //                             );
            //                         });
            //                         if (response.length === 0) {
            //                             $('tbody').append(
            //                                 '<tr><td colspan="12" class="text-center">No products found</td></tr>'
            //                             );
            //                         }
            //                     },
            //                     error: function() {
            //                         alert("Error while searching");
            //                     }

            //                 });

            //             });



            function loadData(response) {
                if (response.length === 0) {
                    $('tbody').append(
                        '<tr><td colspan="18" class="text-center">No products found</td></tr>'
                    );
                    return;
                }
                $.each(response, function(key, value) {
                    $('tbody').append(
                        `<tr>
                        <td>${key+1}</td>
                        <td>${value.name}</td>
                        <td>${value.subcategory_id ? value.subcategory_id : 'N/A'}</td>
                        <td>${new Date(value.created_at).toLocaleString()}</td>
                        <td>${value.specifications}</td>
                        <td>
                            ${value.image
                                ? `<img src="/${value.image}" alt="Image" style="width: 50px; height: 50px; object-fit: cover;">` 
                                : `<span>No Image</span>`}
                        </td>
                        <td>${value.rate}</td>
                        <td>${value.unit}</td>
                        <td>${value.discount}</td>
                        <td>${value.final_amount}</td>
                        <td>${value.status}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-status="${value.status}" data-subcategory-id="${value.subcategory_id}" data-specification="${value.specifications}" data-rate="${value.rate}" data-unit="${value.unit}" data-quantity="${value.quantity}" data-discount="${value.discount}" data-final-amount="${value.final_amount}"><i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`
                    );
                });
            }


            $('.searchBtn').click(function() {
                if ($('#from').val() && $('#to').val() && $('.searchInput').val()) {
                    console.log($('#from').val() + " " + $('#to').val() + " " + $('.searchInput')
                        .val());
                    $.post('{{ route('filter-data') }}', {
                        _token: '{{ csrf_token() }}',
                        data: 'product',
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
                    if (type === 'name') {
                        const searchValue = $(this).siblings('.searchInput').val();
                        if (!searchValue) {
                            alert("Please enter a value to search.");
                            return;
                        }

                        $.ajax({
                            url: '{{ route('common.getdata') }}',
                            type: 'POST',
                            data: {
                                data: "product",
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
                    } else if (type === 'date') {
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
                                data: "product",
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
                                location.reload();
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

                $.ajax({
                    url: '{{ route('admin.productsData') }}',
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
