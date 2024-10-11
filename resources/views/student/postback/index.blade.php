@extends('student.layout.app')
@section('title', 'Postback')
@push('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                        {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPostback">Add
                            Postback</button> --}}
                            <div>
                                <h5 class="card-title mb-0">postback</h5>
                             </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                               
                               <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"data-bs-target="#addPostback"><i class="ri-add-line align-bottom me-1">
                                </i> Add Postback</button>
                               
                            </div>
                         </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-response">
                        <table class="table table-borderless table-hover table-striped postbacks" id="postbacks">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Event</th>
                                    <th>Offer name</th>
                                    <th>Status</th>
                                    <th>Code / URL</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addPostback">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Postback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class=" form-group">
                            <input type="checkbox" name="is_global" value="1" id="is_global">

                            <label for="is_global">Global Postback</label>
                        </div>
                        <div class=" form-group">
                            <label for="offerName">Offer</label>
                            <select class="form-control group offerName" name="offerName" id="offerName"
                                data-placeholder="Select Offer" required style="width: 100%">

                            </select>
                        </div>
                        <div class=" form-group">
                            <label for="eventName">Event</label>
                            <select class="form-control group1 eventName" name="eventName" id="eventName" required
                                data-placeholder="Select Event">
                                <option value="default">Default</option>
                            </select>
                        </div>
                        <div class=" form-group">
                            <label for="pbcode">Pixel/Postback</label>
                            <textarea class="form-control pbcode" name="pbcode" id="pbcode" required placeholder="Pixel / Postback Code"></textarea>
                        </div>
                        <hr>
                        <small class="tracking_macros">
                            <b>Example Postback</b><br>
                            <code>https://example.com/postback?clickid={stu_sub5}&pubid={stu_sub}&offerid={offer_id}</code>
                            <br />
                            <b>Usable URL tokens</b><br>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Campaign ID">{offer_id}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Payout in USD">{payout}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Click IP">{click_ip}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="ISO 2 Country Code">{country}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 1">{stu_sub}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 2">{stu_sub2}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 3">{stu_sub3}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 4">{stu_sub4}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Sub 5">{stu_sub5}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Stu Click">{stu_click}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm" title="Source">{source}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Country">{country}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm" title="Region">{region}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm" title="City">{city}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm" title="Payout">{payout}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Currency">{currency}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Sale Amount">{sale_amount}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Click IP">{click_ip}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Conversion IP">{conversion_ip}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Operating System">{operating_system}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Browser Name">{browser_name}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Browser Version">{browser_version}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Raw User-agent">{useragent}</button>
                            <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                title="Click Timestamp">{click_time}</button><br>
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addPostback()">Add Postback</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#postbacks').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                order: [
                    [0, 'desc']
                ],
                ajax: '{{ route('student.postback.index') }}',
                columns: [{
                        data: 'event',
                        name: 'event'
                    },
                    {
                        data: 'offer',
                        name: 'offer'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'code',
                        name: 'code'
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


        function addPostback() {
            let is_global = $('#is_global').is(':checked') ? 1 : 0;
            let offer_id = $('.offerName').val();
            let event = $('.eventName').val();
            let postback = $('.pbcode').val();
            let _url = `/student/settings/postback`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    is_global: is_global,
                    offer_id: offer_id,
                    event: event,
                    code: postback,
                },

                success: function(data) {
                    console.log(data);
                    $('.offerName').val('').trigger('change');
                    $('.eventName').val('');
                    $('.pbcode').val('');
                    $('#postbacks').DataTable().ajax.reload();
                    $('#addPostback').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Postback has been Added',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            })
        }


        function deletePostback(id) {
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
                    $.ajax({
                        url: "{{ route('student.postback.index') }}" + '/' + id,
                        type: 'DELETE',

                        success: function(res) {
                            $('#postbacks').DataTable().ajax.reload();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Postback has been deleted',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        },
                        error: function(res) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                timer: 2000
                            })
                        }
                    })

                }
            })
        }
    </script>
    <script>
        $('.offerName').select2({
            ajax: {
                url: '{{ route('student.getOffers') }}',
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

    <script>
        $(function() {
            globalPostback();
            $("#is_global").click(globalPostback);
        });

        function globalPostback() {
            if (this.checked) {
                $('#offerName').attr('disabled', true);
                $('#eventName').attr('disabled', true);
            } else {
                $('#offerName').attr('disabled', false);
                $('#eventName').attr('disabled', false)
            }
        }
    </script>
@endpush
