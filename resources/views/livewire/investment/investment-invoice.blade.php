<div class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Investment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div wire:loading class="col">
        <div class="d-flex justify-content-center mb-4">
            <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="modal-body">
        <div class="d-md-flex justify-content-between">
            <img src="{{asset('storage/settings/' . $GlobalSettings->dark_logo)}}" alt="Company Logo"
                class="inv_logo mb-2">
            <div class="col col-lg-5 mb-4 px-0">
                {{-- <p class="inv_header"> {{$GlobalSettings->company_name}}</p> --}}
                <p class="inv_text2">{{$GlobalSettings->company_address}}</p>
            </div>
        </div>
        <div class="d-md-flex justify-content-between align-items-start">
            <div class="col col-lg-5 inv_cont">
                <p class="inv_head"> <b>TO: </b> {{$investment_details?->user->fullname}}</p>
                <p class="inv_hint">{{$investment_details?->user->phone}}</p>
                <p class="inv_text">{{$GlobalSettings->company_name}} Member since
                    {{Carbon\Carbon::parse($investment_details?->user->created_at)->toFormattedDateString()}}</p>
            </div>
            <div class="col col-lg-5 ">
                <p class="inv_tick">Invoice</p>
                <p class="inv_sm">Invoice No: {{$investment_details?->trx_num}}</p>
                <p class="inv_sm">Invoice Date:
                    {{Carbon\Carbon::parse($investment_details?->created_at)->toFormattedDateString()}}</p>
                <p class="inv_sm">Due Date:
                    {{Carbon\Carbon::parse($investment_details?->due_date)->toFormattedDateString()}}</p>
            </div>
        </div>

        <div class="my-4">
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Transaction ID:</p>
                <p class="acct_modal_text ml-3">{{$investment_details?->trx_num}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Client Email:</p>
                <p class="acct_modal_text ml-3">{{$investment_details?->user->email}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Investment Plan:</p>
                <p class="acct_modal_text ml-3">{{$investment_details?->plan->title }}
                    ({{$GlobalSettings->currency}}{{number_format($investment_details?->plan->min_investment) . ' - $' .
                    number_format($investment_details?->plan->max_investment)}})
                </p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Invested Amount:</p>
                <p class="acct_modal_text ml-3">
                    {{$GlobalSettings->currency}}{{number_format($investment_details?->amount)}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Expected Profit:</p>
                <p class="acct_modal_text ml-3">
                    {{$GlobalSettings->currency}}{{number_format($investment_details?->profit)}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Due Date:</p>
                <p class="acct_modal_text ml-3">
                    {{Carbon\Carbon::parse($investment_details?->due_date)->toFormattedDateString()}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Created Date:</p>
                <p class="acct_modal_text ml-3">
                    {{Carbon\Carbon::parse($investment_details?->created_at)->toFormattedDateString()}}</p>
            </div>
            <div class="inv_line d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Progress:</p>
                <div class="progress inv_pro ml-3">
                    @if ($investment_details?->plan)
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        style="width: {{floor($investment_details?->run_time * 100 / ($investment_details?->maturity / $investment_details?->interest_period))}}%;"
                        aria-valuemin="0" aria-valuemax="100">
                        {{floor($investment_details?->run_time * 100 / ($investment_details?->maturity /
                        $investment_details?->interest_period)) . '%'}}
                    </div>
                    @endif
                </div>
            </div>
            <div class="inv_line border-bottom-0 d-flex justify-content-between align-items-center mb-2">
                <p class="acct_modal_head">Status:</p>
                <p class="acct_modal_text ml-3">
                    @if ($investment_details?->status == true)
                    <span class="table_status">Matured</span>
                    @else
                    <span class="table_status2">Running</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="col table-responsive">
            <table class="table table-sm table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="table_head" scope="col">Transaction ID</th>
                        <th class="table_head" scope="col">Amount</th>
                        <th class="table_head" scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($investment_details?->transaction)
                    @foreach ($investment_details->transaction as $item)
                    <tr>
                        <th class="table_data" scope="row">{{$item->trx_num}}</th>
                        <td class="table_head">{{$GlobalSettings->currency}}{{number_format($item->amount)}}</td>
                        <td class="table_data">{{Carbon\Carbon::parse($item->created_at)->toDayDateTimeString()}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        {{-- <button type="submit" class="acct_modal_btn">Download</button> --}}
        <button type="button" class="acct_modal_btn2" data-dismiss="modal" aria-label="Close">Close</button>
    </div>
</div>