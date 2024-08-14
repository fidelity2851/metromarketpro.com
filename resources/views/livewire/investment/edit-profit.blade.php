<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Edit Profit</p>
        <a href="{{ route('invest')}}" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i
                    class="fas fa-arrow-left mr-2"></i> Back</button> </a>
    </div>

    <div class="col">
        <form wire:submit.prevent="UpdateProfit()" class="col acct_newdep_cont shadow-sm ">
            <div class="col px-0">

                <div class="mb-3">
                    <label class="acct_label">Type</label>
                    <select wire:model.lazy="type" class="acct_modal_sel">
                        <option value="">Choose Here</option>
                        <option value="{{1}}">Top up</option>
                        <option value="{{2}}">Reduce</option>
                    </select>
                    @error('type') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="acct_label">Amount</label>
                    <input type="number" wire:model.lazy="amount" class="acct_modal_box" min="1" step="any">
                    @error('amount') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-4">
                <button wire:loading wire:target="UpdateProfit" type="button" class="acct_modal_btn disabled"
                    disabled>Processing...</button>
                <button wire:loading.remove wire:target="UpdateProfit" type="submit"
                    class="acct_modal_btn">Submit</button>
            </div>
        </form>
    </div>

</div>