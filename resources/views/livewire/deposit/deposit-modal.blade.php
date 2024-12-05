<form wire:submit.prevent="MakeDeposit()" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Deposit Fund</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if ($GlobalSettings->allow_deposit)
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
                <label class="acct_modal_label">Payment Method <div wire:loading wire:target="deposit_method"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div></label>
                <div class="d-flex flex-wrap">
                    @foreach ($deposit_methods as $item)
                    <label class="d-flex rounded bg-light px-2 mr-4">
                        <input type="radio" wire:model.live="deposit_method" class="mr-1" value="{{ $item->id }}">
                        <p class="acct_modal_head mb-0">
                            <img src="{{ asset('storage/settings/deposit_method/'.$item->logo) }}" alt="" class=" mr-1"
                                height="30px"> <strong>{{ $item->name }}</strong>
                        </p>
                    </label>
                    @endforeach

                </div>
                @error('deposit_method')<span class="acct_box_error">{{ $message }}</span> @enderror
                @foreach ($deposit_methods as $item)
                @if ($item->id == $deposit_method)
                <div class="col rounded bg-light py-2 mt-2">
                    <div class="d-md-flex justify-content-between">
                        <p class="acct_modal_head">Min Deposit: {{$GlobalSettings->currency}}{{ $item->min_deposit }}
                        </p>
                        <p class="acct_modal_head">Deposit Fee: {{$GlobalSettings->currency}}{{ $item->fee }}</p>
                    </div>
                    <hr>
                    <img src="{{ asset('storage/settings/deposit_method/'.$item->qr_code) }}" alt="" class="mr-1"
                        height="80px">
                    <div class="d-flex d-flex align-items-center">
                        <h6 class="text-truncate" id="wallet"><strong>{{ $item->deposit_method ==
                                App\Enums\DepositMethod::CRYPTO->value ? $item->wallet_address : $item->bank_name
                                }}</strong></h6>
                        @if ($item->deposit_method == App\Enums\DepositMethod::CRYPTO->value)
                        <span onclick="copyAccountToClipboard('wallet')" id="copy_acct" class="ml-auto acct_modal_text"
                            style="cursor: pointer;"><i class="fas fa-copy" aria-hidden="true"></i> copy </span>
                        @endif
                    </div>
                    @if ($item->account_number)
                    <div class="d-flex d-flex align-items-center">
                        <h4><strong id="acct_number">{{ $item->deposit_method ==
                                App\Enums\DepositMethod::CRYPTO->value ? '' : $item->account_number }} </strong>
                        </h4>
                        <span onclick="copyAccountToClipboard('acct_number')" id="copy_acct"
                            class="ml-auto acct_modal_text" style="cursor: pointer;"><i class="fas fa-copy"
                                aria-hidden="true"></i> copy </span>
                    </div>
                    @endif
                    <h6 class=""> {{ $item->deposit_method ==
                        App\Enums\DepositMethod::CRYPTO->value ? '('.$item->network_type.')' : $item->account_name
                        }}</h6>
                </div>
                <p class="acct_modal_text text-dark mt-1">
                    Copy the above details and deposit, then upload your proof of payment.
                </p>
                @endif
                @endforeach
            </div>
            <div class="mb-3">
                <label class="acct_modal_label">Enter Amount (USD) <div wire:loading wire:target="ammount"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="number" wire:model.lazy="ammount" class="acct_modal_box" min="1" placeholder="Eg. 500">
                <p class="acct_modal_head">Amount To Pay: ${{ intval($ammount) + $deposit_fee}}</p>
                @error('ammount')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @can('userOnly')
            <div class="mb-3">
                <label class="acct_modal_label">Proof of payment <div wire:loading wire:target="proof"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <input type="file" wire:model.live="proof" class="acct_modal_box">
                {{-- @if ($proof)
                <div>
                    <img src="{{ $proof->temporaryUrl() }}" height="70">
                </div>
                @endif --}}
                @error('proof')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @endcan
        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading.remove wire:target="MakeDeposit" type="submit" class="acct_modal_btn">Submit</button>
        <button wire:loading wire:target="MakeDeposit" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
    </div>
    @else
    <h3 class="acct_modal_header text-danger p-3">Deposit has been disabled, Contact Admin</h3>
    @endif
</form>

<script>
    const copyToClipboard = (id) => {
        const element = document.getElementById(id);
        const text = element.textContent || element.innerText; // Get only the text content

        // Use modern Clipboard API if available
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    showCopySuccess();
                })
                .catch((err) => {
                    console.error('Clipboard API failed, falling back:', err);
                    fallbackCopyText(text); // Use fallback if Clipboard API fails
                });
        } else {
            fallbackCopyText(text); // Use fallback for older browsers or unsupported platforms
        }
    };

    const fallbackCopyText = (text) => {
        // Create a hidden textarea for the fallback copy
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed'; // Prevent it from affecting the page layout
        textarea.style.opacity = '0'; // Make it invisible
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy'); // Use the legacy copy command
            showCopySuccess();
        } catch (err) {
            console.error('Fallback copy failed:', err);
        }

        document.body.removeChild(textarea); // Remove the textarea after copying
    };

    const showCopySuccess = () => {
        const copyElement = document.getElementById('copy_acct');
        copyElement.innerText = 'Copied!';
        setTimeout(() => {
            copyElement.innerText = 'Copy'; // Reset to "Copy" after 2 seconds
        }, 2000);
    };

    const copyAccountToClipboard = (id) => {
        copyToClipboard(id); // Call the main copy function
    };

    window.copyTextById = copyAccountToClipboard; // Expose function globally for testing
</script>