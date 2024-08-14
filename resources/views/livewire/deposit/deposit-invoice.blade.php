<div class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Deposit Details</h5>
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
                <p class="acct_modal_head">Transaction ID:</p>
                <p class="acct_modal_text ml-3">{{ $deposit_details?->trx_num }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Client Email:</p>
                <p class="acct_modal_text ml-3">{{ $deposit_details?->user->email }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Payment Method:</p>
                <p class="acct_modal_text ml-3">{{ $deposit_details?->deposit_method->name }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Deposited Amount:</p>
                <p class="acct_modal_text ml-3">${{ $deposit_details?->amount }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Deposit Fee:</p>
                <p class="acct_modal_text ml-3">${{ $deposit_details?->fee }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Amount Received:</p>
                <p class="acct_modal_text ml-3">${{ $deposit_details?->amount }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Created Date:</p>
                <p class="acct_modal_text ml-3">{{ date("F jS, Y",strtotime($deposit_details?->created_at)) }}</p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <p class="acct_modal_head">Status:</p>
                <p class="acct_modal_text ml-3">
                    @if ($deposit_details?->status == true)
                    <span class="table_status">Approved</span>
                    @else
                    <span class="table_status2">Pending</span>
                    @endif
                </p>
            </div>
            <div class="mb-2">
                <p class="acct_modal_head">Proof:</p>
                @if ($deposit_details?->proof)
                <img src="{{ asset('storage/deposit/'. $deposit_details?->proof) }}" alt="" height="300px">
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="acct_modal_btn2" data-dismiss="modal" aria-label="Close">Close</button>
    </div>
</div>