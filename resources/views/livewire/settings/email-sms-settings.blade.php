<form wire:submit.prevent="UpdateEmailSmsSettings()" method="POST" class="col px-0">
    <div class="col d-lg-flex px-0">
        <div class="col px-0 mr-lg-5">
            <div class="d-sm-flex">
                <div class="col col-sm-7 px-0 mr-md-3 mb-3">
                    <label class="acct_label">SMTP Host</label>
                    <input type="text" wire:model.lazy="smtp_host" class="acct_box" placeholder="SMTP Host">
                    @error('smtp_host') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col px-0 mb-3">
                    <label class="acct_label">Port</label>
                    <input type="text" wire:model.lazy="smtp_port" class="acct_box" placeholder="SMTP port">
                    @error('smtp_port') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="acct_label">SMTP Protocol</label>
                <select wire:model.lazy="smtp_protocol" class="acct_sel">
                    <option value="null" disabled>Choose Here</option>
                    <option value="smtp">SMTP</option>
                    <option value="sendmail">Sendmail</option>
                    <option value="mail">Mail</option>
                </select>
                @error('smtp_protocol') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="acct_label">SMTP User (Email)</label>
                <input type="text" wire:model.lazy="smtp_user" class="acct_box" placeholder="Email">
                @error('smtp_user') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="acct_label">SMTP Password</label>
                <input type="text" wire:model.lazy="smtp_password" class="acct_box" placeholder="Password">
                @error('smtp_password') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="col px-0">
            <div class="mb-3">
                <label class="acct_label">SMS phone number</label>
                <input type="tel" wire:model.lazy="sms_phone" class="acct_box" placeholder="000-000-0000">
                @error('sms_phone') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="acct_label">Activate SMS</label>
                <div class="d-flex">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline3" wire:model.lazy="sms_active" value="1"
                            class="custom-control-input">
                        <label class="custom-control-label acct_label"
                            for="customRadioInline3">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline4" wire:model.lazy="sms_active" value="0"
                            class="custom-control-input" checked>
                        <label class="custom-control-label acct_label"
                            for="customRadioInline4">No</label>
                    </div>
                </div>
                @error('sms_active') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button wire:loading.remove wire:target='UpdateEmailSmsSettings' type="submit" class="acct_btn2">SAVE</button>
        <button wire:loading wire:target='UpdateEmailSmsSettings' type="button" class="acct_btn2 disabled" disabled>Processing...</button>
    </div>
</form>
