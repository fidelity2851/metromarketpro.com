<div class="col py-4 px-0 px-md-3">

    <div class="col d-lg-flex justify-content-between align-items-center mb-5">
        @cannot('teamOnly')
        <button type="button" class="acct_cont_btn mb-4 mb-lg-0 mr-3" data-toggle="modal"
            data-target="#staticBackdrop">New
            Investment</button>
        <button type="button" class="acct_cont_btn mb-4 mb-lg-0" data-toggle="modal" data-target="#staticBackdrop2">Top
            Up Investment</button>
        @endcannot
        <div class="col col-lg-9 col-xl-8 d-md-flex justify-content-between px-0 ml-auto">
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm  mb-4 mb-md-0 mr-md-5">
                <span class="acct_dep_hint">Invested Amount</span>
                <span class="acct_dep_icon mr-4"> <i class="fas fa-wallet "></i> </span>
                <div class="">
                    <p class="acct_dep_header">${{ number_format($this->investedAmount()) }}</p>
                    <p class="acct_dep_text">Invested Amount</p>
                </div>
            </div>
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm">
                <span class="acct_dep_hint2">Total Profit</span>
                <span class="acct_dep_icon"> <i class="fas fa-donate mr-4"></i> </span>
                <div class="">
                    <p class="acct_dep_header">${{ number_format($this->totalProfit()) }}</p>
                    <p class="acct_dep_text">Total Profit</p>
                </div>
            </div>
        </div>
    </div>

    @can('adminOnly')
    <div class="col d-lg-flex justify-content-between align-items-center mb-4">
        <form wire:submit.prevent="" method="post" class="col d-lg-flex justify-content-between align-items-end px-0">
            <input type="search" wire:model.live="search" class="col col-lg-4 acct_form_box shadow-sm mb-3"
                placeholder="Search clients...">
            <div class="col col-lg-6 d-md-flex">
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Sort By</label>
                    <select wire:model.lazy="sort_by" class="col acct_sort_sel">
                        <option value="">All status</option>
                        <option value="{{1}}">Matured</option>
                        <option value="{{0}}">Running</option>
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
    @endcan

    <div wire:loading wire:target='search,sort_by,order_by,per_page,DeleteInvestment,PauseInvestment,ResumeInvestment'
        class="col">
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
                    @can('adminOnly')
                    <th class="table_head" scope="col">Client Name</th>
                    @endcan
                    <th class="table_head" scope="col">Investment Plan</th>
                    <th class="table_head" scope="col">Amount</th>
                    <th class="table_head" scope="col">Progress</th>
                    <th class="table_head" scope="col">Profit</th>
                    <th class="table_head" scope="col">Due Date</th>
                    <th class="table_head" scope="col">Created On</th>
                    <th class="table_head" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($investments as $item)
                <tr>
                    <th class="table_data" scope="row"> {{ $loop->iteration }} </th>
                    @can('adminOnly')
                    <td class="table_data">{{$item->user->fullname}}</td>
                    @endcan
                    <td class="table_data">{{$item->plan->title}}
                        (${{number_format($item->plan->min_investment)}} -
                        ${{number_format($item->plan->max_investment)}})
                    </td>
                    <td class="table_data"><b>${{number_format($item->amount)}}</b></td>
                    <td class="table_data">
                        <div class="progress table_pro">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: {{$item->run_time * 100 / floor($item->maturity / $item->interest_period)}}%;"
                                aria-valuemin="0" aria-valuemax="100">
                                {{floor($item->run_time * 100 / ($item->maturity / $item->interest_period)) . '%'}}
                            </div>
                        </div>
                        @if ($item->status)
                        <span class="table_status">Matured</span>
                        @else
                        <span class="table_status2">Running</span>
                        @endif
                    </td>
                    <td class="table_data"> <b>${{number_format($item->acc_profit, 2)}}</b> </td>
                    <td class="table_data">{{Carbon\Carbon::parse($item->due_date)->toFormattedDateString()}}</td>
                    <td class="table_data">{{Carbon\Carbon::parse($item->created_at)->toFormattedDateString()}}</td>
                    <td class="table_data">
                        <button wire:click="InvestmentInvoiceEvent({{$item->id}})" class="table_btn1" type="button"
                            data-toggle="modal" data-target="#modelId">Details</button>
                        @can('adminOnly')
                        <button
                            onclick="return confirm('Are you sure you want to delete?')  || event.stopImmediatePropagation()"
                            wire:click="DeleteInvestment({{$item->id}})" type="button"
                            class="table_btn2">Delete</button>



                        @if ($item->status == false)
                        <a href="{{ route('edit-invest-profit', $item->id) }}" class="text-decoration-none">
                            <button class="table_btn1" type="button">Edit</button>
                        </a>
                        
                        @if ($item->isActive)
                        <button wire:click="PauseInvestment({{$item->id}})" class="table_btn3"
                            type="button">Pause</button>
                        @else
                        <button wire:click="ResumeInvestment({{$item->id}})" class="table_btn5"
                            type="button">Resume</button>
                        @endif

                        @endif
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($investments->isEmpty())
    <div class="d-flex justify-content-center bg-white mb-4">
        <img src="images/no_result.png" alt="" class="">
    </div>
    @endif

    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">

        {{ $investments->links() }}
    </div>

</div>