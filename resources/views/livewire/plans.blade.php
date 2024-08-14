<div class="col py-4 px-0 px-md-3">

    <div class="col mb-5">
        <button type="button" class="acct_cont_btn" data-toggle="modal" data-target="#staticBackdrop">New
            Plan</button>
    </div>


    <div class="col d-lg-flex justify-content-start align-items-center mb-4">
        <form wire:submit.prevent="" method="post" class="col d-lg-flex justify-content-between align-items-end px-0">
            <input type="search" wire:model.live="search" class="col col-lg-4 acct_form_box shadow-sm mb-3"
                placeholder="Enter your search">
            <div class="col col-lg-6 d-md-flex">
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Sort By</label>
                    <select wire:model.lazy="sort_by" class="col acct_sort_sel">
                        <option value="">All type</option>
                        @foreach (App\Enums\InterestPeriod::cases() as $item)
                        <option value="{{$item->value}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Order By</label>
                    <select wire:model.lazy="order_by" class="col acct_sort_sel">
                        <option value="desc">DESC</option>
                        <option value="asc">ASC</option>
                    </select>
                </div>
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Per Page</label>
                    <select wire:model.lazy="per_page" class="col acct_sort_sel">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            {{-- <button type="submit" class="col acct_form_btn mb-3">Search</button> --}}

        </form>
    </div>

    <div class="col" wire:loading wire:target='search,sort_by,order_by,per_page,ActivatePlan,BlockPlan,'>
        <div class="d-flex justify-content-center mb-4">
            <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="row mx-0">
        @foreach ($plans as $item)
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 my-3">
            <div class="col acct_with_cont">
                <p class="acct_with_header">{{$item->title}} <br> <span>({{$item->sub_title}})</span> </p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="acct_with_text">Minimum Amount</span>
                    <span class="acct_with_text"> <b>${{$item->min_investment}}</b> </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="acct_with_text">Maximum Amount</span>
                    <span class="acct_with_text"> <b>${{$item->max_investment}}</b> </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="acct_with_text">Interest Rate</span>
                    <span class="acct_with_text"> <b>{{ $item->rate_type == 'fixed' ? '$' : ''}}{{$item->rate_number}}{{
                            $item->rate_type == 'percent' ? '%' : ''}}</b> </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="acct_with_text">Interest Period</span>
                    <span class="acct_with_text">
                        @switch($item->interest_period)
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
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="acct_with_text">Maturity after a</span>
                    <span class="acct_with_text">
                        @switch($item->maturity)
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
                    </span>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('edit-plan', $item->id) }}" class="text-decoration-none mr-4"> <button
                            type="button" class="acct_with_btn ">Edit</button> </a>
                    @if ($item->status == true)
                    <button wire:click='BlockPlan({{$item->id}})' type="button" class="acct_with_btn2">Block</button>
                    @else
                    <button wire:click='ActivatePlan({{$item->id}})' type="button"
                        class="acct_with_btn3">Activate</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($plans->isEmpty())
    <div class="d-flex justify-content-center bg-white mb-4">
        <img src="images/no_result.png" alt="" class="">
    </div>
    @endif

    <div class="d-flex justify-content-center">
        {{ $plans->links() }}
    </div>

</div>