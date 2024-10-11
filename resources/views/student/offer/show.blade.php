@extends('student.layout.app')
@section('title', 'Offer Detail')
@push('style')
    <!-- flags -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flag-icons/css/flag-icon.min.css?v=52475656') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">

            <div class="card mb-4 shadow-lg">
                <div class="card-header">
                    <h6 class="m-0 text-primary font-weight-bold">Offer Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="card-text"><span class="text-muted">Offer Name:</span> {{ $offer->name }}</p>
                            <p class="card-text"><span class="text-muted">Preview URL:</span> <a href="{{ $offer->preview_url }}">{{ $offer->preview_url }}</a></p>
                            <p class="card-text"><span class="text-muted">Conversion Flow:</span> {{ $offer->conv_flow }}</p>
                            <p class="card-text"><span class="text-muted">Category:</span>
                                @if ($offer->category_id != null)
                                    {{ $offer->category->name }}
                                @endif
                            </p>
                            <p class="card-text"><span class="text-muted">Description:</span> {!! $offer->description !!} </p>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ asset("storage/offers/$offer->thumbnail") }}" class="img-fluid img-thumbnail izoom"
                                width="150" style="max-width: 150px; max-height: 150px; min-width: 85px; min-height: 85px;">
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="card shadow-lg mb-4">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Goal and Payout</h6>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Goal Name</th>
                                    <th>Object</th>
                                    <th>Payout</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if(!$offerStudents->isEmpty())
                                   @foreach($offerStudents as $offerStudent)
                                   <tr>
                                            <td>{{ $offerStudent->name }}</td>
                                            <td>{{ $offerStudent->pay_model }}</td>
                                            <td>
                                                @if ($offerStudent->pay_model == 'RevShare')
                                                    {{ $offerStudent->percent_payout }} %
                                                @elseif ($offerStudent->pay_model == 'Hybrid')
                                                    {{ $offerStudent->default_payout }} {{ $offerStudent->currency }} +
                                                    {{ $offerStudent->percent_payout }} %
                                                @elseif ($offerStudent->pay_model == 'Dynamic')
                                                    Dynamic
                                                @else
                                                    {{ $offerStudent->default_payout }} {{ $offerStudent->currency }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($offer->goals as $goal)
                                        <tr>
                                            <td>{{ $goal->goalName->name }}</td>
                                            <td>{{ $goal->pay_model }}</td>
                                            <td>
                                                @if ($goal->pay_model == 'RevShare')
                                                    {{ $goal->percent_payout }} %
                                                @elseif ($goal->pay_model == 'Hybrid')
                                                    {{ $goal->default_payout }} {{ $offer->currency }} +
                                                    {{ $goal->percent_payout }} %
                                                @elseif ($goal->pay_model == 'Dynamic')
                                                    Dynamic
                                                @else
                                                    {{ $goal->default_payout }} {{ $offer->currency }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            
            

        </div>

        <div class="col-lg-6">
            <div class="card mb-4 shadow-lg">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Tracking Link</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if ($status == 'Approved')
                        <div class="form-group">
                            <label class="text-muted">Generated Link</label>
                            <textarea class="form-control" name="url"
                                id="url">{{ config('app.tracking_domain') ? config('app.tracking_domain') . '/' : asset('/') }}click?aid={{ auth()->user()->id }}&oid={{ $offer->id }}</textarea>
                        </div>
                        <button class="btn btn-primary btn-copy" data-clipboard-target="#url">
                            Copy Link
                        </button>
                        <button class="btn btn-danger" id="add_stusub"><i class="fa fa-plus-circle"></i>
                            Add Sub ID
                        </button>
                        <div class="form-group" id="tracking_params_div" style="display: none; margin-top: 10px">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" id="p1" value="" class="form-control" placeholder="stu sub">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" id="p2" value="" class="form-control" placeholder="stu sub2">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" id="p3" value="" class="form-control" placeholder="stu sub3">
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-4">
                                    <input type="text" id="p4" value="" class="form-control" placeholder="stu sub4">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" id="p5" value="" class="form-control" placeholder="stu sub5">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" id="p6" value="" class="form-control" placeholder="stu click">
                                </div>

                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-4">
                                    <input type="text" id="p7" value="" class="form-control" placeholder="source">
                                </div>

                            </div>
                            <div class="form-group" style="margin-top: 5px;">
                                <input type="button" id="update_link" class="btn btn-success btn-sm" value="Update">
                            </div>

                        </div>
                        <!--Profit Sharing URL Code Section Start-->
                        <button class="btn btn-primary btn-copy" id="profit_sharing_button">
                            Create Profit Sharing URL
                        </button>
                        <!-- With Goal -->
                        <div class="form-group" id="profit_sharing_with_goal" style="display: none; margin-top: 10px">
                            <div class="form-group row">
                                    <label for="goal_id1" class="col-sm-2 col-form-label">Goal 1</label>
                                    <div class="col-sm-5 col-md-5">
                                        <select class="form-select" id="goal_id1">
                                            <!--<option value="Default">Default</option>-->
                                            @foreach ($offer->goals as $goal)
                                                <!--input type="hidden" id="profit_share_payout" value="{{$goal->default_payout}}"-->
                                                <option  value="{{ $goal->goalName->name}}">{{ $goal->goalName->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5 col-md-5">
                                    <input disabled="disabled" id="profit_share1" class="form-control" type="number" value="1" />
                                    </div>

                                    <div class="form-group" style="margin-top: 5px;">
                                    <input type="button" id="submit_goal1" class="btn btn-success btn-sm" value="Submit">
                                    </div> 
                            </div>
                            
                            <div class="form-group" id="goal2_div" style="display: none; margin-top: 10px" >
                                <div class="form-group row">
                                        <label for="goal_id2" class="col-sm-2 col-form-label">Goal 2</label>
                                        <div class="col-sm-5 col-md-5">
                                            <select class="form-control"  name="goal_id2" id="goal_id2">
                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-5 col-md-5">
                                        <input type="number" id="profit_share2" value="" class="form-control" placeholder="Enter Profit Share Amount">
                                        </div>
                                </div>

                                <div class="form-group" style="margin-top: 5px;">
                                    <input type="button" id="submit_profit_with_goal" class="btn btn-success btn-sm" value="Submit">
                                </div>
                                
                            </div>
                               
                       </div>
                       <!-- Without Goal -->
                       <div class="form-group" id="profit_sharing_without_goal" style="display: none; margin-top: 10px">
                            <div class="form-group row">
                                    <label for="goal_id" class="col-sm-2 col-form-label">Goal 1</label>
                                    <div class="col-sm-5 col-md-5">
                                        <select class="form-control" id="goal_id">
                                            <option value="{{$offer->default_payout}}">Default_1</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5 col-md-5">
                                    <input type="number" id="profit_share_default" value="" class="form-control" placeholder="Enter Profit Share Amount">
                                    </div>
                            </div>
                            <div class="form-group" style="margin-top: 5px;">
                                    <input type="button" id="submit_profit_without_goal" class="btn btn-success btn-sm" value="Submit">  
                            </div>  
                            

                       </div>

                       <!-- Generating Landing Page URL-->
                       <div class="form-group" id="landing_page_div" style="display: none; margin-top: 10px">
                            
                            <div class="form-group" style="margin-top: 5px">
                                <label class="text-muted">Generated Profit Sharing URL</label>
                                <textarea class="form-control" name="url_lp"
                                    id="url_lp"></textarea>
                            </div>
                            <button class="btn btn-primary btn-copy" data-clipboard-target="#url_lp" style="margin-top: 5px">
                                Copy Profit Sharing URL
                            </button>
                        </div>
                       
                       <!-- End Profit Sharing Section -->
                    @elseif ($status == 'Available')
                        <a class="btn btn-primary" href="{{ route('student.offer.apply', $offer->id) }}">Apply Now</a>
                    @elseif ($status == 'Pending')
                        <span class="badge btn-warning">Pending</span>
                    @elseif ($status == 'Rejected')
                        <span class="badge btn-danger">Rejected</span>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>

            <div class="card mb-4 shadow-lg">
                <div class="card-header with-border">
                    <h6 class="m-0 text-primary font-weight-bold">Targeting</h6>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="card-text"><span class="text-muted">Country:</span>
                        @forelse($offer->countries as $country)
                            <i class="flag-icon flag-icon-{{ Str::lower($country->code) }}"></i> {{ $country->name }},
                        @empty
                            <i class="flag-icon flag-icon-ww"></i> World Wide
                        @endforelse
                    </p>
                    <p class="card-text"><span class="text-muted">Device:</span>
                        @forelse($offer->devices as $device)
                            @if ($device->name == 'Desktop')
                                <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>
                            @elseif ($device->name == 'Tablet')
                                <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>
                            @elseif ($device->name == 'Mobile')
                                <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>
                            @endif
                        @empty
                            <i class="bx bx-desktop" style="color:rgb(0, 0, 0)"></i>
                            <i class="bx bx-tab" style="color:rgb(0, 0, 0)"></i>
                            <i class="bx bx-mobile" style="color:rgb(0, 0, 0)"></i>
                        @endforelse
                    </p>
                    <p class="card-text"><span class="text-muted">Browser:</span>
                        @forelse($offer->browsers as $browser)
                            {{ $browser->name }},
                        @empty
                            All
                        @endforelse
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card mb-4 shadow-lg">
                <div class="card-header with-border">
                    <div class="float-right">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPostback">Add
                            Postback</button>
                    </div>
                   
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-strip table-sm">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>Offer name</th>
                                    <th>Postback URL</th>
                                    <th>Event/Goal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($postbacks as $postback)
                                    <tr>
                                        <td>{{ $offer->name }}</td>
                                        <td><input type="text" class="form-control offer-pixel-code"
                                                value="{{ $postback->postback }}"></td>
                                        <td>{{ $postback->event }}</td>
                                        <td>
                                            @if ($postback->status == '0')
                                                Pending
                                            @elseif($postback->status == '1')
                                                Active
                                            @elseif($postback->status == '2')
                                                Rejected
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; font-weight: 700; font-size: 1.85rem">No
                                            Data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $postbacks->links() }}
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPostback">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <form action="{{ route('student.postback.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <div class="modal-body">
                        <div class=" form-group">
                            <label>Event/Goal</label>
                            <select class="form-control" name="event">
                                @foreach ($offer->goals as $goal)
                                        <option value="{{ $goal->goalName->name}}">{{ $goal->goalName->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Postback</label>
                            <textarea class="form-control" name="code" required></textarea>
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
                                    title="stu Sub 1">{stu_sub}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="stu Sub 2">{stu_sub2}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="stu Sub 3">{stu_sub3}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="stu Sub 4">{stu_sub4}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="stu Sub 5">{stu_sub5}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="stu Click">{stu_click}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="Source">{source}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="Country">{country}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="Region">{region}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="City">{city}</button>
                                <button type="button" class="btn btn-rounded  btn-light btn-sm"
                                    title="Payout">{payout}</button>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Postback</button>
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
    <!-- Clipboard -->
    <script src="{{ asset('assets/libs/clipboard/clipboard.min.js') }}"></script>
    <script>
        var clipboard = new ClipboardJS('.btn-copy');
        var has_goals={{$offer->goals->count()}}>1 ? 1 :0; 
        
    </script>

    <script type="text/javascript">
         
        $(document).ready(function() {
            document.getElementById("add_stusub").onclick = function() {
                $('#tracking_params_div').toggle()
            };
            $('#update_link').click(function() {
                var params_link = {
                    stu_sub: '',
                    stu_sub2: '',
                    stu_sub3: '',
                    stu_sub4: '',
                    stu_sub5: '',
                    stu_click: '',
                    source: '',
                };
                if ($('#p1').val()) {
                    params_link.stu_sub = $('#p1').val();
                }
                if ($('#p2').val()) {
                    params_link.stu_sub2 = $('#p2').val();
                }
                if ($('#p3').val()) {
                    params_link.stu_sub3 = $('#p3').val();
                }
                if ($('#p4').val()) {
                    params_link.stu_sub4 = $('#p4').val();
                }
                if ($('#p5').val()) {
                    params_link.stu_sub5 = $('#p5').val();
                }
                if ($('#p6').val()) {
                    params_link.stu_click = $('#p6').val();
                }
                if ($('#p7').val()) {
                    params_link.source = $('#p7').val();
                }
                const querystring = encodeQueryData(params_link);
                if (querystring != 0) {
                const url = `{{ config('app.tracking_domain') ? config('app.tracking_domain') . '/' : asset('/') }}click?aid={{ auth()->user()->id }}&oid={{ $offer->id }}` + '&' + querystring;
        
                // Set the value of the '#url' input field
                const decodedUrl = decodeURIComponent(url);
                
                $('#url').val(decodedUrl);
                } else {
                    alert('NO Params Found ');
                }

               
            })
        });
        
        $(document).ready(function() {
          var goal1_name="";
          var goal2_name="";
          var profit_share_val1=0;
          var profit_share_val2=0;
          
          document.getElementById("profit_sharing_button").onclick = function() {
                if(has_goals>0)
                {
                    $('#profit_sharing_with_goal').toggle();
                }
                else
                {
                    $('#profit_sharing_without_goal').toggle(); 
                }
            }

          document.getElementById("submit_goal1").onclick = function() {
                $('#goal2_div').toggle(); 
                goal1_name=document.getElementById("goal_id1").value; 
            
                var new_goals = {{Illuminate\Support\Js::from($offer->goals)}}.filter(val => val.goal_name.name !== goal1_name);
                
                // const goals = {!! json_encode($offer->goals) !!};
                // const new_goals = goals.filter(goal => goal.goal_name.name !== goal1_name);
                console.log(new_goals);

                $("#goal_id2").empty();
                $.each(new_goals, function (key, value) {
                    $("#goal_id2")
                    .append('<option value="' + value
                        .id + '">' + value.goal_name.name + '</option>');
                });
            }

            $('#submit_profit_with_goal').click(function() {    
                var profit_share_payout1=1;
                var profit_share_payout2=0;
                goal2_id=parseInt(document.getElementById("goal_id2").value);
                const object = {{Illuminate\Support\Js::from($offer->goals)}}.find(obj => obj.id === goal2_id);
                goal2_name=object.goal_name.name;;
                profit_share_payout2=parseFloat(object.default_payout);
                
                
                if ($('#profit_share1').val()) {
                profit_share_val1=parseFloat($('#profit_share1').val());   
                }

                if ($('#profit_share2').val()) 
                {
                    profit_share_val2=parseFloat($('#profit_share2').val());
                    if((profit_share_val2)<=(profit_share_payout2-profit_share_val1))
                    {
                        $.ajax({
                        url: '{{route('student.offers.sharepay.store')}}',
                        type: "POST",
                        data: {
                            offer_id: {{$offer->id}},
                            student_id:{{ auth()->user()->id }},
                            name:"{{ $offer->name }}",
                            goal1_name:goal1_name,
                            goal1_share_payout:profit_share_val1,
                            goal2_name:goal2_name,
                            goal2_share_payout:profit_share_val2,
                            has_goals:has_goals,
                        },
                        success: function (response) { 
                         $('#landing_page_div').toggle();
                          $('#url_lp').val(
                        `{{ config('app.landingpage_domain') ? config('app.landingpage_domain') . '/' : asset('/') }}?aid={{ auth()->user()->id }}&oid={{ $offer->id }}`);
                     
                        },
                        error: function(err){ alert('Error: '+ err.statusText);}
                        });     
                     }
                     else
                     {alert('Please Enter Valid Share Value Less Than Payout.');}
                }
                else{
                    alert('Enter Profit Share Value');
                } 
            });
            

            $('#submit_profit_without_goal').click(function() {
               
                var profit_share_payout=parseFloat(document.getElementById("goal_id").value);

                if ($('#profit_share_default').val()) 
                {
                    var profit_share_val= parseFloat($('#profit_share_default').val());
                    if(profit_share_val<=profit_share_payout)
                    {
                     // save profit share url to table
                     
                     $.ajax({
                        url: '{{route('student.offers.sharepay.store')}}',
                        type: "POST",
                        data: {
                            offer_id: {{$offer->id}},
                            student_id:{{ auth()->user()->id }},
                            name:"{{ $offer->name }}",
                            goal1_name:"Default",
                            goal1_share_payout:profit_share_val,
                            has_goals:has_goals,
                        },
                        success: function (response) { 
                         $('#landing_page_div').toggle();
                          $('#url_lp').val(
                        `{{ config('app.landingpage_domain') ? config('app.landingpage_domain') . '/' : asset('/') }}?aid={{ auth()->user()->id }}&oid={{ $offer->id }}`);
                     
                        },
                        error: function(err){ alert('Error: '+ err.statusText);
                         }
                    });  
                    
                     }
                     else
                     {alert('Please Enter Valid Share Value Less Than Payout.');}
                }
                else{
                    alert('Enter Profit Share Value');
                } 
            });

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        
        });

        function encodeQueryData(data) {
            const ret = [];
            for (let d in data) {
                if (data[d] != '') {
                    ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                }
            }

            return ret.join('&');
        }

        function generateLink() {
            var _url = '{{ asset('/') }}click?pub_id=' + {{ $offer->id }} + '&offer_id=' + $('#offer_id').val();
            $('#url').val(_url);
            localStorage.setItem('url', _url)
        }

        function resetLink(btn) {
            document.getElementById('url').value = btn.dataset.url
        }
    </script>


@endpush
