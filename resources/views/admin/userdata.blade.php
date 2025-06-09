@extends('masterlayout')

@section('title', 'Admin Dashboard')

@section('data')
    <!-- Main content would go here -->

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0 rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="text-primary">Manage Users</h4>
                    <button type="button" class="btn btn-primary" id="addUserBtn" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="fa fa-plus mr-2"></i> Add User
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
                            <input type="text" class="searchInput form-control" placeholder="User Name">
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
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Country</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 0;
                            @endphp
                            @foreach ($data as $d)
                                @if ($d->role != 'admin')
                                    <tr>
                                        <td>{{ ++$counter }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->role }}</td>
                                        <td>{{ $d->country }}</td>
                                        <td>{{ $d->created_at }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editBtn" data-id="{{ $d->id }}"
                                                data-name="{{ $d->name }}" data-email="{{ $d->email }}"
                                                data-country="{{ $d->country }}" data-role="{{ $d->role }}"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fas fa-edit"></i>

                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $d->id }}">
                                                <i class="fas fa-trash-alt"></i>

                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div style="margin: 20px;" class="container mt-1">
        <!-- Modal HTML -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center fw-bold" id="exampleModalLabel">Add User</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="adminForm" method="post">
                            @csrf
                            <input type="hidden" id="edit-id" name="id">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="name"
                                    class="form-control input-field form-control-lg texts" placeholder="Username"
                                    required />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email"
                                    class="form-control input-field form-control-lg texts" placeholder="Email" required />
                            </div>


                            <div data-mdb-input-init class="form-outline mb-4">

                                <select class="form-select texts rounded-0" name="country">
                                    <option value="">Country</option>
                                    <option value="United States of America">United States of America</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="India">India</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Argentina">Argentina</option>
                                </select>

                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password"
                                    class="form-control input-field form-control-lg texts" name="password"
                                    placeholder="Password" required />
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('#addUserBtn').click(() => {
                // $('#userForm')[0].reset();
                $('#imagePreview').html('');
                $('#user_id').val('');
                $('#userModalLabel').text('Add User');
                $('.error-text').text('');
                $('#userModal').modal('show');
            });

            $(document).on('click', '.editBtn', function() {
                console.log("Edit button clicked");
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const country = $(this).data('country');
                const role = $(this).data('role');

                $('#exampleModalLabel').text('Edit User');
                $('#password').prop('required', false); // Make password field optional on edit
                $('#password').hide();
                console.log("ID:", id, "Name:", name, "Email:", email, "Country:", country, "Role:",
                    role);


                $('#edit-id').val(id);
                $('select[name="role"]').val(role);
                $('#username').val(
                    name);
                $('#email').val(email);
                $('select[name="country"]').val(country);
            });

            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '{{ route('delete') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        console.log('Deleted successfully');
                        location.reload();
                    },
                    error: function() {
                        console.log("Error while deleting");
                    }
                });
            });

            $('#adminForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert("Data saved successfully!");
                            location.reload();
                        } else {
                            alert("Error");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error while saving data:" + xhr.responseText);
                    }
                });
            });

            //         $('.searchInput').on('input', function() {
            //             const x = $(this).val(); // updated value of the input
            //             console.log("Value is " + x);


            //             $.ajax({
            //                 url: '{{ route('common.getdata') }}',
            //                 type: 'POST',
            //                 data: {
            //                     data: "user",
            //                     search: x,
            //                 },
            //                 success: function(response) {
            //                     console.log(response);

            //                     $("tbody").empty(); // Clear existing rows
            //                     $.each(response, function(key, value) {
            //                         if (value.role != 'admin') {

            //                             $('tbody').append(
            //                                 `<tr>
        //                                     <td>${key+1}</td>
        //                                     <td>${value.name}</td>
        //                                     <td>${value.email}</td>
        //                                     <td>${value.role}</td>
        //                                     <td>${value.country}</td>
        //                                     <td>${new Date(value.created_at).toLocaleString()}</td>
        //                                     <td>
        //                                         <div class="d-flex gap-1">
        //                                             <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-email="${value.email}" data-country="${value.country}" data-role="${value.role}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-edit"></i>
        // </button>
        //                                             <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>

        //                                                 </button>
        //                                         </div>
        //                                     </td>
        //                                 </tr>`
            //                             );
            //                         }
            //                     });
            //                     if (response.length === 0) {
            //                         $('tbody').append(
            //                             '<tr><td colspan="12" class="text-center">No users found</td></tr>'
            //                         );
            //                     }
            //                 },
            //                 error: function() {
            //                     alert("Error while searching");
            //                 }

            //             });

            //         });

            function loadData(response) {
                if (response.length === 0) {
                    $('tbody').append(
                        '<tr><td colspan="18" class="text-center">No users found</td></tr>'
                    );
                    return;
                }
                $.each(response, function(key, value) {
                    if (value.role != 'admin') {
                        $('tbody').append(
                            `<tr>
                                <td>${key+1}</td>
                                <td>${value.name}</td>
                                <td>${value.email}</td>
                                <td>${value.role}</td>
                                <td>${value.country}</td>
                                <td>${new Date(value.created_at).toLocaleString()}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-warning editBtn" data-id="${value.id}" data-name="${value.name}" data-image="${value.image}" data-email="${value.email}" data-country="${value.country}" data-role="${value.role}" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${value.id}"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`
                        );
                    }
                });
            }


            $('.searchBtn').click(function() {
                if ($('#from').val() && $('#to').val() && $('.searchInput').val()) {
                    console.log($('#from').val() + " " + $('#to').val() + " " + $('.searchInput')
                        .val());
                    $.post('{{ route('filter-data') }}', {
                        _token: '{{ csrf_token() }}',
                        data: 'user',
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
                    if (!type) {
                        alert("Search type is not defined.");
                        return;
                    }

                    if (type === "name") {
                        const searchValue = $(this).siblings('.searchInput').val();
                        if (!searchValue) {
                            alert("Please enter a search value.");
                            return;
                        }
                        console.log("Search Type:", type);
                        console.log("Search Value:", searchValue);
                        $.ajax({
                            url: '{{ route('common.getdata') }}',
                            type: 'POST',
                            data: {
                                data: "user",
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
                        if (!from || !to) {
                            alert("Please select both FROM and TO dates.");
                            return;
                        }
                        console.log("From:", from, "To:", to);
                        $.ajax({
                            url: '{{ route('common.getdatedata') }}',
                            type: 'POST',
                            data: {
                                data: "user",
                                from: from,
                                to: to,
                            },
                            success: function(response) {
                                console.log(response);
                                $("tbody").empty();
                                loadData(response);
                            },
                            error: function(xhr) {
                                let errMsg = xhr.responseJSON?.error ||
                                    'Something went wrong';
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
                    url: '{{ route('admin.usersData') }}',
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
        });
    </script>
@endpush
