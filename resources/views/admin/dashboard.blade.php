@extends('masterlayout')

@section('title', 'Admin Dashboard')

@section('data')
    <div style="margin: 20px;" class="container mt-1">

        <!-- Modal HTML -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="edit-form" method="post">
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
                            <button data-mdb-button-init data-mdb-ripple-init
                                class="btn gradient btn-secondary btn-lg btn-block" type="submit"><span
                                    class="text buttons">SIGN
                                    UP</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Country</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if (Auth::check())
                    <td>{{ Auth::user()->id }}</td>
                    <td>{{ Auth::user()->name }}</td>
                    <td>{{ Auth::user()->email }}</td>
                    <td>{{ Auth::user()->country }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning editBtn" data-id="{{ Auth::user()->id }}"
                            data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}"
                            data-country="{{ Auth::user()->country }}" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
            </tr>
        @else
            <tr>
                <td colspan="5">No data available</td>
            </tr>
            @endif

        </tbody>
    </table>
@endsection

@push('scriptforuser')
    <script>
        $(document).ready(function() {
            $('.editBtn').on('click', function() {
                console.log("Edit button clicked");
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const country = $(this).data('country');

                // console.log($(this));    
                console.log(id + " " + name + " " + email + " " + country);

                $('#edit-id').val(id);
                $('#username').val(name);
                $('#email').val(email);
                $('select').val(country);
                $('.text').text('Update');
            });


            $('#edit-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('store') }}',
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert("Error");
                        }
                        $("#password").show();
                    },
                    error: function(xhr) {
                        alert("Error while updating:" + xhr.responseText);
                    }
                });
            });

        });
    </script>
@endpush
