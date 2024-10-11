@extends('student.layout.app')
@section('title', 'My Offer')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}"> --}}
    <!-- flags -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="card mb-4  shadow-lg">
        <div class="card-header">
            <a href="#collapseCardExample" class="d-block card-header collapsed" data-bs-toggle="collapse" role="button"
                aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
            </a>
        </div>
        <div class="collapse" id="collapseCardExample" style="">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-4 mb-4">
                        <div class="form-group">
                            <label for="name">Offer</label>
                            <input type="text" class="form-control" id="offer_name" name="name" placeholder="Offer Name"
                                style="width: 100%">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="form-group">
                            <label for="offer_type">Offer Type</label>
                            <select id='offer_type' multiple class="form-control offer_type" style="width: 100%">
                                <option value="CPL">CPL</option>
                                <option value="CPA">CPA</option>
                                <option value="CPS">CPS</option>
                                <option value="RevShare">RevShare</option>
                                <option value="Hybrid">Hybrid (CPA + Revshare)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="form-group">
                            <label for="device">Device</label>
                            <select id='device' multiple class="form-control device" style="width: 100%">
                                <option value="Desktop">Desktop</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Tablet">Tablet</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="categories">Category</label>
                                <select id='categories' multiple class="form-control categories" style="width: 100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label for="countries">Country</label>
                            <select id='countries' multiple class="form-control countries" style="width: 100%">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-lg ">
        <div class="card-header">
            <h6 class="m-0 text-primary font-weight-bold">My Offers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-borderles offers" id="offers">
                <thead class="table-light text-muted">
                        <tr>
                            <th>ID</th>
                            <th>Preview</th>
                            <th>Offer Name</th>
                            <th>Object</th>
                            <th>Payout</th>
                            <th>Category</th>
                            <th>Device</th>
                            <th>GEO</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
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
    {{-- <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.js') }}"></script> --}}
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            var table = $('#offers').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: {
                    url: "{{ route('student.offer.my') }}",
                    type: 'GET',
                    data: function(d) {
                        d.name = $('#offer_name').val();
                        d.offer_type = $('#offer_type').val();
                        d.categories = $('#categories').val();
                        d.countries = $('#countries').val();
                        d.device = $('#device').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'thumbnail',
                        name: 'thumbnail',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'offer_model',
                        name: 'offer_model'
                    },
                    {
                        data: 'payout',
                        name: 'payout'
                    },

                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'device',
                        name: 'device'
                    },
                    {
                        data: 'countries',
                        name: 'countries',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#offer_type').change(function() {
                table.ajax.reload();
            });
            $('#offer_name').change(function() {
                table.ajax.reload();
            });
            $('#categories').change(function() {
                table.ajax.reload();
            });
            $('#countries').change(function() {
                table.ajax.reload();
            });
            $('#device').change(function() {
                table.ajax.reload();
            });
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('.offer_type').select2({
            placeholder: 'Select Offer Type',
            allowClear: true
        });
        $('.device').select2({
            placeholder: 'Select Device',
            allowClear: true
        });
        $('.categories').select2({
            placeholder: 'Select Categories',
            allowClear: true,
            ajax: {
                url: '{{ route('student.getCategories') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(response) {
                    return {
                        results: response
                    }
                },
                cache: true,
                width: 'resolve'
            }
        });

        $('.countries').select2({
            placeholder: 'Select Countries',
            allowClear: true,
            ajax: {
                url: '{{ route('student.getCountries') }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(response) {
                    return {
                        results: response
                    }
                },
                cache: true,
                width: 'resolve'
            }
        });
    </script>
@endpush
