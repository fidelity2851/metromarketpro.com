<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Deposit Method</p>
        <button type="button" class="acct_btn2" data-toggle="modal" data-target="#staticBackdrop">New payment
            method</button>
    </div>

    <div class="row mx-0">
        @foreach ($methods as $item)
        <div class="col-12 col-sm-6 col-lg-4 mb-4 ">
            <div class="col acct_pay_cont d-flex align-items-center shadow-sm mb-2">
                <img src="{{ asset('storage/settings/deposit_method/'.$item->logo) }}" alt="" class="acct_pay_img mr-3">
                <div class="">
                    <p class="acct_pay_head">{{ $item->name }}</p>
                    <p class="acct_text mb-0">{{ $item->deposit_method }}</p>
                    @if ($item->status == true)
                    <p class="acct_pay_status">Active</p>
                    @else
                    <p class="acct_pay_status2">Inactive</p>
                    @endif
                    <a href="{{ route('edit-deposit-method', ['method' => $item->id]) }}" class="text-decoration-none">
                        <button type="button" class="acct_btn2">Edit</button>
                    </a>

                    @if ($item->status)
                    <button wire:loading.remove wire:target="DisableMethod" wire:click="DisableMethod({{$item->id}})" type="button"
                        class="acct_btn3 ml-2">Disable</button>
                    <button wire:loading wire:target="DisableMethod" type="button"
                        class="acct_btn3 disabled ml-2" disabled>Processing...</button>
                    @else
                    <button wire:loading.remove wire:target="EnableMethod" wire:click="EnableMethod({{$item->id}})" type="button"
                        class="acct_btn ml-2">Enable</button>
                    <button wire:loading wire:target="EnableMethod" type="button"
                        class="acct_btn disabled ml-2" disabled>Processing...</button>
                    @endif

                    {{-- <button type="button" wire:click="DeleteDepositMethod({{$item->id}})"
                        wire:confirm="Are you sure you want to delete?" class="acct_btn3">Delete</button> --}}
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="col d-flex justify-content-center align-items-end mt-3">
        <div class="d-flex align-items-center mx-auto mx-md-0">
            {{ $methods->links() }}
        </div>
    </div>

</div>