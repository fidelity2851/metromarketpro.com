<form wire:submit.prevent='UpdateSiteSettings()' method="POST" class="col px-0">
    <div class="row mx-0 mr-lg-5">
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Must Verify Email</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="verify1" wire:model.lazy="must_verify_email" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="verify1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="verify2" wire:model.lazy="must_verify_email" value="0" class="custom-control-input" checked>
                    <label class="custom-control-label acct_label" for="verify2">No</label>
                </div>
            </div>
            @error('must_verify_email') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Allow Deposit</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="deposit1" wire:model.lazy="allow_deposit" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="deposit1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="deposit2" wire:model.lazy="allow_deposit" value="0" class="custom-control-input" checked>
                    <label class="custom-control-label acct_label" for="deposit2">No</label>
                </div>
            </div>
            @error('allow_deposit') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Allow Investment</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="invest1" wire:model.lazy="allow_investment" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="invest1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="invest2" wire:model.lazy="allow_investment" value="0" class="custom-control-input" checked>
                    <label class="custom-control-label acct_label" for="invest2">No</label>
                </div>
            </div>
            @error('allow_investment') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Allow Withdrawal</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="withdraw1" wire:model.lazy="allow_withdrawal" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="withdraw1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="withdraw2" wire:model.lazy="allow_withdrawal" value="0" class="custom-control-input" checked>
                    <label class="custom-control-label acct_label" for="withdraw2">No</label>
                </div>
            </div>
            @error('allow_withdrawal') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Allow Transfer</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="transfer1" wire:model.lazy="allow_transfer" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="transfer1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="transfer2" wire:model.lazy="allow_transfer" value="0" class="custom-control-input" checked>
                    <label class="custom-control-label acct_label" for="transfer2">No</label>
                </div>
            </div>
            @error('allow_transfer') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
        <div class="col-12 col-md-6 mb-3">
            <label class="acct_label">Allow Withdrawal of Deposit</label>
            <div class="d-flex">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="withdraw_deposit1" wire:model.lazy="allow_withdraw_deposit" value="1" class="custom-control-input">
                    <label class="custom-control-label acct_label" for="withdraw_deposit1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="withdraw_deposit2" wire:model.lazy="allow_withdraw_deposit" value="0" class="custom-control-input"
                        checked>
                    <label class="custom-control-label acct_label" for="withdraw_deposit2">No</label>
                </div>
            </div>
            @error('allow_withdraw_deposit') <span class="acct_box_error">{{ $message }}</span>@enderror
        </div>
    </div>
    <div class="mt-4">
        <button wire:loading.remove wire:target='UpdateSiteSettings' type="submit" class="acct_btn2">Update</button>
        <button wire:loading wire:target='UpdateSiteSettings' type="button" class="acct_btn2 disabled"
            disabled>Processing...</button>
    </div>
</form>