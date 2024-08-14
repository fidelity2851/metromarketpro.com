<div class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Withdrawal Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
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
        <div class="">
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Client Name:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->fullname }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Withdrawal Method :</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->withdrawal_type }}</p>
            </div>
            @if ($withdrawal_details?->withdrawal_type == App\Enums\WithdrawalMethod::CRYPTO->value)
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Address:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->withdrawal_method?->bitcoin_address }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Network Type:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->withdrawal_method?->network_type }}</p>
            </div>
            @endif
            {{-- @if ($withdrawal_details?->withdrawal_type == App\Enums\WithdrawalMethod::WIRE_TRANSFER->value)
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Bank name:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->withdrawal_method->bank_name }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Account Number:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->withdrawal_method->account_number }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Account Name:</p>
                <p class="acct_modal_text ml-3">{{ $withdrawal_details?->user->withdrawal_method->account_name }}</p>
            </div>
            @endif --}}
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Withdrawed Amount:</p>
                <p class="acct_modal_text ml-3">${{ number_format($withdrawal_details?->amount) }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Withdrawal Fee:</p>
                <p class="acct_modal_text ml-3">${{ number_format($withdrawal_details?->fee) }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Recieved Amount:</p>
                <p class="acct_modal_text ml-3">${{ number_format($withdrawal_details?->amount -
                    $withdrawal_details?->fee) }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Created Date:</p>
                <p class="acct_modal_text ml-3">{{
                    Carbon\Carbon::parse($withdrawal_details?->created_at)->toFormattedDateString() }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Status:</p>
                <p class="acct_modal_text ml-3">
                    @if ($withdrawal_details?->status == true)
                    <span class="table_status">Approved</span>
                    @else
                    <span class="table_status2">Pending</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="acct_modal_btn2" data-dismiss="modal" aria-label="Close">Close</button>
    </div>
</div>