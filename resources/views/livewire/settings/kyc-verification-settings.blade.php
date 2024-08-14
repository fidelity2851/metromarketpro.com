<form wire:submit.prevent="UpdateKycSettings()" method="POST" class="col px-0">
    <div class="col d-lg-flex px-0">
        <div class="col col-lg-6 px-0">
            <div class="mb-3">
                <label class="acct_label">Activate KYC feature</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline5" wire:model="kyc_active" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label"
                            for="customRadioInline5">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline6" wire:model="kyc_active" value="0"
                            class="custom-control-input" checked>
                        <label class="custom-control-label acct_label"
                            for="customRadioInline6">No</label>
                    </div>
                </div>
                @error('kyc_active') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div>
            {{-- <div class="mb-3">
                <label class="acct_label">Allow client deposits without KYC verification</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline7" wire:model="deposit_without_kyc" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label"
                            for="customRadioInline7">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline8" wire:model="deposit_without_kyc" value="0"
                            class="custom-control-input" checked>
                        <label class="custom-control-label acct_label"
                            for="customRadioInline8">No</label>
                    </div>
                </div>
                @error('deposit_without_kyc') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div> --}}
            {{-- <div class="mb-3">
                <label class="acct_label">Allow client withdrawals without KYC verification</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline9" wire:model="withdraw_without_kyc" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label"
                            for="customRadioInline9">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline10" wire:model="withdraw_without_kyc" value="0"
                            class="custom-control-input" checked>
                        <label class="custom-control-label acct_label"
                            for="customRadioInline10">No</label>
                    </div>
                </div>
                @error('withdraw_without_kyc') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div> --}}
        </div>

    </div>
    <div class="mt-4">
        <button wire:loading.remove wire:target='UpdateKycSettings' type="submit" class="acct_btn2">Update</button>
        <button wire:loading wire:target='UpdateKycSettings' type="button" class="acct_btn2 disabled" disabled>Processing...</button>
    </div>
</form>
