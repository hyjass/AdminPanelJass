<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>


    </div>
    <!-- Main content would go here -->
    <div style="margin: 20px;" class="container mt-1">
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add
        </button>
        <!-- Modal HTML -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('admin.store') }}" method="post">
                            @csrf
                            <input type="hidden" id="edit-id" name="id">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="name"
                                    class="form-control input-field form-control-lg texts" placeholder="Username"
                                    required />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email"
                                    class="form-control input-field form-control-lg texts" placeholder="Email"
                                    required />
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

                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input me-2" type="checkbox" value="" id="checkbox" required
                                    style="margin-left:10px;">
                                <label class="form-check-label texts" for="termsCheck">
                                    I agree to all Terms & Conditions
                                </label>
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
    <div class="container-fluid mt-4 d-flex align-items-center justify-content-center" style="width:900px;">

    </div>
    <pre>{{ $data }}</pre>
</div>