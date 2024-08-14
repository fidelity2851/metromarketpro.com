<form wire:submit.prevent="UpdateReferralSettings()" method="POST" class="col px-0">
    <div class="col d-lg-flex px-0">
        <div class="col px-0 mr-lg-5">
            <div class="mb-3">
                <label class="acct_label">Allow/Disable All Referral Earnings</label>
                <div class="">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref11" wire:model.lazy="referral_active" value="0" class="custom-control-input">
                        <label class="custom-control-label acct_label" for="ref11">Disable All
                            Referral Earnings</label>
                    </div>
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref22" wire:model.lazy="referral_active" value="1" class="custom-control-input"
                        >
                        <label class="custom-control-label acct_label" for="ref22">Allow Referral
                            Earnings</label>
                    </div>
                </div>
                @error('referral_active') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="acct_label">Select frequency of referral earnings</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref33" wire:model.lazy="pay_referral_once" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label" for="ref33">Once only per
                            referral</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref44" wire:model.lazy="pay_referral_once" value="0"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label" for="ref44">For each deposit
                            made by referee</label>
                    </div>
                </div>
                @error('pay_referral_once') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div>
            {{-- <div class="mb-3">
                <label class="acct_label">Payouts to accounts without
                    deposit</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref55" wire:model.lazy="pay_referral_without_deposit" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label" for="ref55">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="ref66" wire:model.lazy="pay_referral_without_deposit" value="0"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label" for="ref66">No</label>
                    </div>
                </div>
                @error('pay_referral_without_deposit') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div> --}}
        </div>
        <div class="col px-0">
            <div class="mb-3">
                <label class="acct_label"> Referral Pay Type</label>
                <select wire:model.lazy="referral_pay_type" class="acct_sel">
                    <option value="">Choose Here</option>
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                </select>
                @error('referral_pay_type') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label class="acct_label">Rate</label>
                <input type="number" wire:model.lazy="referral_pay_rate" class="acct_box" placeholder="Eg. 20">
                @error('referral_pay_rate') <span class="acct_box_error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button wire:loading.remove wire:target='UpdateReferralSettings' type="submit" class="acct_btn2">Update</button>
        <button wire:loading wire:target='UpdateReferralSettings' type="button" class="acct_btn2 disabled"
            disabled>Processing...</button>
    </div>
</form>