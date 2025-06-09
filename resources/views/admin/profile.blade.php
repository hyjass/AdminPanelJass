@extends('masterlayout')

@section('title', 'Profile')

<style>
    .card {
        width: 350px;
        background-color: #efefef;
        border: none;
        cursor: pointer;

    }

    .btn {
        border-radius: 50%
    }

    .name {
        font-size: 22px;
        font-weight: bold
    }

    .idd {
        font-size: 14px;
        font-weight: 600
    }

    .idd1 {
        font-size: 12px
    }

    .number {
        font-size: 22px;
        font-weight: bold
    }

    .follow {
        font-size: 12px;
        font-weight: 500;
        color: #444444
    }

    .btn1 {
        height: 40px;
        width: 150px;
        border: none;
        background-color: #000;
        color: #aeaeae;
        font-size: 15px
    }

    .textt span {
        font-size: 13px;
        color: #545454;
        font-weight: 500
    }

    .icons i {
        font-size: 19px
    }

    hr .new1 {
        border: 1px solid
    }

    .join {
        font-size: 14px;
        color: #a0a0a0;
        font-weight: bold
    }
</style>

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
                                    class="text buttons">Update</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center">
                <img src="https://freesvg.org/img/abstract-user-flat-4.png" height="100" width="100" />
                <input type="hidden" id="edit-id" name="id">
                <input type="text" id="username" name="name"
                    class="form-control input-field form-control-lg texts mt-3" placeholder="Username" required
                    value="{{ Auth::user()->name }}"readonly />
                <input type="email" id="email" name="email"
                    class="form-control input-field form-control-lg texts mt-3" placeholder="Email"
                    value="{{ Auth::user()->email }}" readonly />


                <div class="d-flex flex-row justify-content-center align-items-center mt-3">
                    <input type="country" id="country" name="country"
                        class="form-control input-field form-control-lg texts" placeholder="Country" readonly
                        value="{{ Auth::user()->country }}" />
                </div>

                <div class="textt mt-3">
                    <span>Role : {{ Auth::user()->role }}</span>
                </div>

                <div class=" px-2 rounded mt-4 date ">
                    <span class="join">Joined : {{ Auth::user()->created_at }}</span>
                </div>

                <button class="btn btn-warning editBtn" data-id="{{ Auth::user()->id }}"
                    data-name="{{ Auth::user()->name }}" data-email="{{ Auth::user()->email }}"
                    data-country="{{ Auth::user()->country }}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Edit Profile
                </button>
            </div>
        </div>
    </div>
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
                            alert('Success');
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
