<form wire:submit.prevent="UpdateDepositMethod()" method="POST" class="col col-lg-6 px-0">
    <div class="mb-5">
        <div class="mb-3">
            <label class="acct_modal_label">Title</label>
            <input type="text" wire:model.lazy="title" class="acct_modal_box" min="1" placeholder="Eg. Bitcoin">
            @error('title') <span class="acct_box_error">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="acct_modal_label">Deposit Method</label>
            <select wire:model.lazy="deposit_method" class="acct_modal_sel">
                <option selected>Choose Here</option>
                @foreach (App\Enums\DepositMethod::cases() as $item)
                <option value="{{ $item->value }}">{{ $item->value }}</option>
                @endforeach
            </select>
            @error('deposit_method') <span class="acct_box_error">{{ $message }}</span> @enderror
        </div>
        @if ($deposit_method === App\Enums\DepositMethod::CRYPTO->value)
        <div class="d-md-flex">
            <div class="col col-md-8 mr-md-3 mb-3 px-0">
                <label class="acct_modal_label">Wallet Address</label>
                <input type="text" wire:model.lazy="wallet_address" class="acct_modal_box" min="1"
                    placeholder="Enter Wallet Address">
                @error('wallet_address') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="col mb-3 px-0">
                <label class="acct_modal_label">Network Type</label>
                <input type="text" wire:model.lazy="network_type" class="acct_modal_box" min="1"
                    placeholder="Eg. ETH, BSC, TRC">
                @error('network_type') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="acct_modal_label">QR Code</label>
            <div class="custom-file mb-3">
                <input wire:model="qr_code" type="file" class="acct_modal_box">
                {{-- <label class="custom-file-label" for="inputGroupFile03">Choose file</label> --}}
                @if ($qr_code)
                <div class="mt-3">
                    <img src="{{ $qr_code->temporaryUrl() }}" height="70">
                </div>
                @endif
                @if ($old_qr_code)
                <div class="mt-3">
                    <img src="{{ asset('storage/settings/deposit_method/'.$old_qr_code) }}" height="80">
                </div>
                @endif
            </div>
            @error('qr_code') <span class="acct_box_error">{{ $message }}</span> @enderror
        </div>
        @endif

        @if ($deposit_method === App\Enums\DepositMethod::WIRE_TRANSFER->value)
        <div class="">
            <div class="col mb-3 px-0">
                <label class="acct_modal_label">Bank Name</label>
                <input type="text" wire:model.lazy="bank_name" class="acct_modal_box" min="1"
                    placeholder="Enter bank name">
                @error('bank_name') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="d-md-flex">
                <div class="col mr-md-3 mb-3 px-0">
                    <label class="acct_modal_label">Account Name</label>
                    <input type="text" wire:model.lazy="account_name" class="acct_modal_box" min="1"
                        placeholder="Enter account name">
                    @error('account_name') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3 px-0">
                    <label class="acct_modal_label">Account Number</label>
                    <input type="text" wire:model.lazy="account_number" class="acct_modal_box" min="1"
                        placeholder="1234567890">
                    @error('account_number') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        @endif

        <div class="d-md-flex">
            <div class="col col-md-8 mr-md-3 mb-3 px-0">
                <label class="acct_modal_label">Minimum Deposit</label>
                <input type="number" wire:model.lazy="min_deposit" class="acct_modal_box" min="1" placeholder="Eg. 100">
                @error('min_deposit') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="col mb-3 px-0">
                <label class="acct_modal_label">Deposit Fee</label>
                <input type="number" wire:model.lazy="fee" class="acct_modal_box" placeholder="Eg. 10">
                @error('fee') <span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="acct_modal_label">Logo</label>
            <div class="custom-file mb-3">
                <input wire:model="logo" type="file" class="acct_modal_box">
                {{-- <label class="custom-file-label" for="inputGroupFile03">Choose file</label> --}}
                @if ($logo)
                <div class="mt-3">
                    <img src="{{ $logo->temporaryUrl() }}" height="70">
                </div>
                @endif
                @if ($old_logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/settings/deposit_method/'.$old_logo) }}" height="70">
                </div>
                @endif
            </div>
            @error('logo') <span class="acct_box_error">{{ $message }}</span> @enderror
        </div>
    </div>

    <button wire:loading.remove wire:target="UpdateDepositMethod()" type="submit" class="acct_modal_btn">Submit</button>
    <button wire:loading wire:target="UpdateDepositMethod()" type="button" class="acct_modal_btn disabled"
        disabled>Processing...</button>
</form>