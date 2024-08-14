<form wire:submit.prevent="MakeWithdrawal()" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Withdraw Fund</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if($GlobalSettings->allow_withdrawal)
    <div class="modal-body">
        <div class="">
            @can('adminOnly')
            <div class="mb-3">
                <label class="acct_modal_label">Client Name / Email
                    <div wire:loading wire:target="SearchUsers" class="spinner-border spinner-border-sm text-success"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="search" wire:model.lazy="search" wire:keyup="SearchUsers" class="acct_modal_box py-1 mb-1"
                    placeholder="Search for user">
                <select wire:model.live="client" class="acct_modal_sel">
                    @if (count($users) != 0)
                    <option value="">Select User</option>
                    @else
                    <option value="">No user found</option>
                    @endif
                    @foreach ($users as $item)
                    <option value="{{$item->id}}" {{$client==$item->id ? 'selected' : ''}}>{{$item->fullname}} -
                        {{$item->email}}</option>
                    @endforeach
                </select>
                @error('client')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @endcan

            <div class="mb-3">
                <label class="acct_modal_label">Withdrawal Method <div wire:loading wire:target="withdrawal_method" class="spinner-border spinner-border-sm text-success"
                    role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </label>
                <div class="d-flex flex-wrap">
                    @foreach (App\Enums\WithdrawalMethod::cases() as $item)
                    <label class="d-flex rounded bg-light p-2 mr-4">
                        <input type="radio" wire:model.live="withdrawal_method" class="mr-2" value="{{ $item->value }}">
                        <p class="acct_modal_head">{{ $item->name }}</p>
                    </label>
                    @endforeach
                </div>
                @error('withdrawal_method')<span class="acct_box_error">{{ $message }}</span> @enderror
                @if ($withdrawal_method)
                <div class="col rounded bg-light py-2 mt-2">
                    <div class="d-md-flex justify-content-between">
                        <p class="acct_modal_head">Min Withdrawal: ${{ $GlobalSettings->min_withdrawal }}</p>
                        <p class="acct_modal_head">Withdrawal Fee: {{ $GlobalSettings->withdrawal_fee_type ==
                            'percentage' ? $GlobalSettings->withdrawal_fee . '%' : '$'. $GlobalSettings->withdrawal_fee
                            }}</p>
                    </div>
                    <hr>
                    @if (!$withdrawal_details)
                    <span class="acct_box_error">No Withdrawal Details Found <br> Go to <a href="{{route('profile')}}">settings</a> to update your withdrwal details</span>
                    @endif
                    @if ($withdrawal_method == App\Enums\WithdrawalMethod::CRYPTO->value)
                    <p class="acct_modal_head"><strong>{{$withdrawal_details?->bitcoin_address}}</strong></p>
                    <span class="acct_modal_text">{{ '(' . $withdrawal_details?->network_type . ')'}}</span>
                    @endif
                    {{-- @if ($withdrawal_method == App\Enums\WithdrawalMethod::WIRE_TRANSFER->value)
                    <p class="acct_modal_head"><strong>{{$withdrawal_details?->bank_name}}</strong></p>
                    <p class="acct_modal_head"><strong>{{$withdrawal_details?->account_number}}</strong></p>
                    <span class="acct_modal_text">{{$withdrawal_details?->account_name}}</span>
                    @endif --}}
                </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="acct_modal_label">Enter Amount (USD) <div wire:loading wire:target="ammount" class="spinner-border spinner-border-sm text-success"
                    role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </label>
                <input type="number" wire:model.live="ammount" class="acct_modal_box" min="1" placeholder="Eg. 500">
                <p class="acct_modal_head">Amount To Recieve: ${{ number_format(intval($ammount -
                    $this->fee))}}</p>
                @error('ammount')<span class="acct_box_error">{{ $message }}</span> @enderror
                <p class="acct_modal_label text-right">
                    Available Balance = <span>${{ number_format($this->availableBalance()) }}</span>
                </p>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading.remove wire:target="MakeWithdrawal" type="submit" class="acct_modal_btn">Submit</button>
        <button wire:loading wire:target="MakeWithdrawal" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
    </div>
    @else
    <h3 class="acct_modal_header text-danger p-3">Withdrawal has been disabled, Contact Admin</h3>
    @endif
</form>