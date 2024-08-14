<div class="col py-4 px-0 px-md-3">

    <div class="col d-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header">All Transactions</p>
    </div>

    <div class="col d-lg-flex justify-content-between align-items-center mb-4">
        <form wire:submit.prevent="" method="post" class="col d-lg-flex justify-content-between align-items-end px-0">
            <input type="search" wire:model.live="search" class="col col-lg-4 acct_form_box shadow-sm mb-3"
                placeholder="Search clients...">
            <div class="col col-lg-6 d-md-flex">
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Sort By</label>
                    <select wire:model.lazy="sort_by" class="col acct_sort_sel">
                        <option value="">All status</option>
                        <option value="{{1}}">Success</option>
                        <option value="{{0}}">Pending</option>
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

    <div wire:loading wire:target='search,sort_by,order_by,per_page' class="col">
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

    <div class="col table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th class="table_head" scope="col">#</th>
                    <th class="table_head" scope="col">Transaction id</th>
                    @can('adminOnly')
                    <th class="table_head" scope="col">Client Name</th>
                    @endcan
                    <th class="table_head" scope="col">Payment Type</th>
                    <th class="table_head" scope="col">Amount</th>
                    <th class="table_head" scope="col">Status</th>
                    <th class="table_head" scope="col">Created On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payouts as $item)
                <tr>
                    <th class="table_data" scope="row"> {{ $loop->iteration }} </th>
                    <th class="table_data" scope="row"> {{$item->trx_num}} </th>
                    @can('adminOnly')
                    <td class="table_data">{{$item->user->fullname}}</td>
                    @endcan
                    <td class="table_data">{{basename($item->transactionable_type)}}</td>
                    <td class="table_data"><b>${{$item->amount}}</b> </td>
                    <td class="table_data">
                        @switch($item->status)
                        @case(true)
                        <span class="table_status">Success</span>
                        @break
                        @case(false)
                        <span class="table_status2">Pending</span>
                        @break
                        @default
                        <span class="table_status3">Canceled</span>
                        @endswitch
                    </td>
                    <td class="table_data">{{Carbon\Carbon::parse($item->created_at)->toFormattedDateString()}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($payouts->isEmpty())
    <div class="d-flex justify-content-center bg-white mb-4">
        <img src="images/no_result.png" alt="" class="">
    </div>
    @endif

    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">

        {{ $payouts->links() }}
    </div>

</div>