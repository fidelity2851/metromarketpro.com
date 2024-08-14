<form wire:submit.prevent="TransferFund()" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Transfer Fund</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if($GlobalSettings->allow_transfer)
    <div class="modal-body">
        <div class="">
            @can('adminOnly')
            <div class="mb-3">
                <label class="acct_modal_label">Sender Name / Email
                    <div wire:loading wire:target="SearchSenders" class="spinner-border spinner-border-sm text-success"
                        role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="search" wire:model.lazy="search_sender" wire:keyup="SearchSenders"
                    class="acct_modal_box py-1 mb-1" placeholder="Search for user">
                <select wire:model.live="sender" class="acct_modal_sel">
                    @if (count($senders) != 0)
                    <option value="">Select User</option>
                    @else
                    <option value="">No user found</option>
                    @endif
                    @foreach ($senders as $item)
                    <option value="{{$item->id}}" {{$sender==$item->id ? 'selected' : ''}}>{{$item->fullname}} -
                        {{$item->email}}</option>
                    @endforeach
                </select>
                @error('sender')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @endcan

            <div class="mb-3">
                <label class="acct_modal_label">Receiver Email
                    <div wire:loading wire:target="SearchReceivers"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="search" wire:model.lazy="search_receiver" wire:keyup="SearchReceivers"
                    class="acct_modal_box py-1 mb-1" placeholder="Search for email">
                <select wire:model.live="receiver" class="acct_modal_sel">
                    @if (count($receivers) != 0)
                    <option value="">Select User</option>
                    @else
                    <option value="">No user found</option>
                    @endif
                    @foreach ($receivers as $item)
                    <option value="{{$item->id}}" {{$receiver==$item->id ? 'selected' : ''}}>
                        {{$item->email}}</option>
                    @endforeach
                </select>
                @error('receiver')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>


            <div class="mb-3">
                <label class="acct_modal_label">Enter Amount (USD) <div wire:loading wire:target="amount"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="number" wire:model.live="amount" class="acct_modal_box" min="1" placeholder="Eg. 500">
                {{-- <p class="acct_modal_head">Amount To Recieve: ${{ number_format(intval($amount -
                    $this->fee))}}</p> --}}
                @error('amount')<span class="acct_box_error">{{ $message }}</span> @enderror
                <p class="acct_modal_label text-right">
                    Available Balance = <span>${{ number_format($this->availableBalance()) }}</span>
                </p>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading.remove wire:target="TransferFund" type="submit" class="acct_modal_btn">Submit</button>
        <button wire:loading wire:target="TransferFund" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
    </div>
    @else
    <h3 class="acct_modal_header text-danger p-3">Transfer has been disabled, Contact Admin</h3>
    @endif
</form>