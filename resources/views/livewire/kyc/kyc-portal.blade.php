<div class="col py-4 px-0 px-md-3">

    <div class="col mb-5">
        <p class="acct_cont_header">Know your customer</p>
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
                        <option value="{{ App\Enums\KycStatus::APPROVED->value }}">Approved</option>
                        <option value="{{ App\Enums\KycStatus::PENDING->value }}">Pending</option>
                        <option value="{{ App\Enums\KycStatus::REJECTED->value }}">Rejected</option>
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

    <div class="col" wire:loading wire:target='search,sort_by,order_by,per_page,DeleteKyc,ApproveKyc,RejectKyc'>
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
                    <th class="table_head" scope="col">
                        <div class="custom-control custom-checkbox">
                            <input wire:click.live="$toggle('select_all_checkbox')" type="checkbox"
                                class="custom-control-input" id="kycCheck">
                            <label class="custom-control-label" for="kycCheck"></label>
                        </div>
                    </th>
                    <th class="table_head" scope="col">
                        #
                    </th>
                    <th class="table_head" scope="col">Client Name</th>
                    <th class="table_head" scope="col">Email</th>
                    <th class="table_head" scope="col">Status</th>
                    <th class="table_head" scope="col">Submited On</th>
                    <th class="table_head" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kycs as $item)
                <tr>
                    <td class="table_data">
                        <div class="custom-control custom-checkbox">
                            <input wire:model.live="kyc_ids" value="{{ $item->id }}" type="checkbox"
                                class="custom-control-input" id="kycCheck{{$item->id}}" {{ $select_all_checkbox
                                ? 'checked' : '' }}>
                            <label class="custom-control-label" for="kycCheck{{$item->id}}"></label>
                        </div>
                    </td>
                    <td class="table_data">
                        {{ $loop->iteration }}
                    </td>
                    <td class="table_data">{{ $item->user->fullname }}</td>
                    <td class="table_data">{{ $item->user->email }}</td>
                    <td class="table_data">
                        @switch($item->status)
                        @case('Approved')
                        <span class="table_status">{{ App\Enums\KycStatus::APPROVED->value }}</span>
                        @break
                        @case('Pending')
                        <span class="table_status2">{{ App\Enums\KycStatus::PENDING->value }}</span>
                        @break
                        @case('Rejected')
                        <span class="table_status3">{{ App\Enums\KycStatus::REJECTED->value }}</span>
                        @break
                        @default

                        @endswitch
                    </td>
                    <td class="table_data">{{ date("F jS, Y", strtotime($item->created_at)) }}</td>
                    <td class="table_data">
                        <a href="{{ route('edit-kyc', $item->id) }}" class="text-decoration-none mr-2"> <span
                                class="table_btn1">View</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($kycs->isEmpty())
        <div class="d-flex justify-content-center bg-white mb-4">
            <img src="images/no_result.png" alt="" class="">
        </div>
        @endif
    </div>



    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">
        <div class="mb-2 mb-md-0 mx-auto mx-md-0">
            @if (count($kyc_ids) && $kycs->isNotEmpty())
            <button
                onclick="return confirm('Are you sure you want to delete this kycs?')  || event.stopImmediatePropagation()"
                wire:click='DeleteKyc()' type="button" class="table_btn4 mr-2">Delete</button>
            <button wire:click='ApproveKyc()' type="button" class="table_btn5 mr-2">Approve</button>
            <button wire:click='RejectKyc()' type="button" class="table_btn3 mr-2">Reject</button>
            @endif
        </div>

        {{ $kycs->links() }}
    </div>

</div>