<form wire:submit.prevent="TopUpYourInvestment" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">Top Up Investment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @if($GlobalSettings->allow_investment)
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
                <label class="acct_modal_label">Active Investments
                    <div wire:loading wire:target="investment_plan"
                        class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </label>
                <select class="acct_modal_sel" wire:model.live="investment_plan">
                    <option value="">Select a running investment</option>
                    @foreach ($investments as $item)
                    <option value="{{$item->id}}">{{$item->plan->title}}
                        (${{number_format($item->plan->min_investment)}} -
                        ${{number_format($item->plan->max_investment)}})</option>
                    @endforeach
                </select>
                @error('investment_plan')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @foreach ($investments as $item)
            @if ($item->id == $investment_plan)
            <div class="col rounded bg-light py-2 my-2">
                <div class="d-md-flex justify-content-between">
                    <p class="acct_modal_head">Invested Amount: {{$GlobalSettings->currency}}{{
                        number_format($item->amount) }}</p>
                    <p class="acct_modal_head">Profit: {{$GlobalSettings->currency}}{{
                        number_format($item->profit) }}</p>
                </div>
                <hr>
                <p class="acct_modal_head">Interest Rate: <strong>
                        {{ $item->plan->rate_type == 'fixed' ? $GlobalSettings->currency : ''}}
                        {{$item->plan->rate_number}}{{$item->plan->rate_type == 'percent' ? '%' : ''}}
                    </strong></p>
                <p class="acct_modal_head">Interest Period: <strong>
                        @switch($item->plan->interest_period)
                        @case(App\Enums\InterestPeriod::HOURLY->value)
                        <b>Hourly</b>
                        @break
                        @case(App\Enums\InterestPeriod::DAILY->value)
                        <b>Daily</b>
                        @break
                        @case(App\Enums\InterestPeriod::WEEKLY->value)
                        <b>Weekly</b>
                        @break
                        @case(App\Enums\InterestPeriod::MONTHLY->value)
                        <b>Monthly</b>
                        @break
                        @case(App\Enums\InterestPeriod::ANNUALLY->value)
                        <b>Yearly</b>
                        @break
                        @default

                        @endswitch
                    </strong></p>
                <p class="acct_modal_head">Maturity after: <strong>
                        @switch($item->plan->maturity)
                        @case(App\Enums\Maturity::DAY->value)
                        <b>Day</b>
                        @break
                        @case(App\Enums\Maturity::WEEK->value)
                        <b>Week</b>
                        @break
                        @case(App\Enums\Maturity::MONTH->value)
                        <b>Month</b>
                        @break
                        @case(App\Enums\Maturity::YEAR->value)
                        <b>Year</b>
                        @break
                        @default

                        @endswitch
                    </strong></p>
            </div>
            @endif
            @endforeach
            <div class="mb-3">
                <label class="acct_modal_label">Enter Amount</label>
                <input type="number" wire:model.live="amount" class="acct_modal_box" min="1" placeholder="Eg. 500">
                @error('amount')<span class="acct_box_error">{{ $message }}</span> @enderror
                <p class="acct_modal_label text-right">
                    Available Balance = <span>${{ number_format($this->availableBalance()) }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading.remove wire:target="TopUpYourInvestment" type="submit"
            class="acct_modal_btn">Submit</button>
        <button wire:loading wire:target="TopUpYourInvestment" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
    </div>
    @else
    <h3 class="acct_modal_header text-danger p-3">Invesment has been disabled, Contact Admin</h3>
    @endif
</form>