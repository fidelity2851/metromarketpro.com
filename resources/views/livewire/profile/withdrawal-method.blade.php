<form wire:submit.prevent="UpdateWithdrawalMethod()" method="POST" class="col px-0">
    <div class="col d-flex px-0">
        <div class="col row px-0 mx-0">
            <div class="col-12 col-lg mb-3 px-0 mr-lg-3">
                <label class="acct_label">Bitcoin Address <span class="acct_down_link">(BTC)</span> </label>
                <input type="text" wire:model.lazy="bitcoin_address" class="acct_box" placeholder="Wallet Address">
                @error('bitcoin_address') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="col-12 col-lg mb-3 px-0">
                <label class="acct_label">Network type</label>
                <select wire:model.lazy="network_type" class="acct_sel">
                    <option value="">Select network</option>
                    <option value="BTC">Bitcoin Network</option>
                    {{-- <option value="ERC">Etherum Network</option> --}}
                    {{-- <option value="TRC">Tron Network</option> --}}
                </select>
                @error('network_type') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            {{-- <div class="col-12 mb-3 px-0">
                <label class="acct_label">Bank Details</label>
                <div class="row mx-0">
                    <div class="col-12 col-lg px-0">
                        <input type="text" wire:model.lazy="bank_name" class="acct_box mb-2 mb-lg-0"
                            placeholder="Bank name">
                        @error('bank_name') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12 col-lg px-0 mx-lg-3">
                        <input type="text" wire:model.lazy="account_number" class="acct_box mb-2 mb-lg-0"
                            placeholder="Account number">
                        @error('account_number') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12 col-lg px-0">
                        <input type="text" wire:model.lazy="account_name" class="acct_box"
                            placeholder="Account full name">
                        @error('account_name') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
    <div class="mt-2">
        <button wire:loading.remove wire:target='UpdateWithdrawalMethod' type="submit" class="acct_btn2">Update</button>
        <button wire:loading wire:target='UpdateWithdrawalMethod' type="button" class="acct_btn2 disabled"
            disabled>Processing...</button>
    </div>
</form>