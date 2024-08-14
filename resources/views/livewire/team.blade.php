<div class="col py-4 px-0 px-md-3">

    <div class="col d-lg-flex justify-content-between align-items-center mb-5">
        <button type="button" class="acct_cont_btn mb-4 mb-lg-0" data-toggle="modal" data-target="#staticBackdrop">New
            Team Member</button>
        <div class="col col-lg-9 col-xl-8 d-md-flex justify-content-between px-0">
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm mb-4 mb-md-0 mr-md-5">
                <span class="acct_dep_hint">Active Manager</span>
                <span class="acct_dep_icon mr-4"> <i class="fas fa-users "></i> </span>
                <div class="">
                    <p class="acct_dep_header">{{ $this->teamCount() }}</p>
                    <p class="acct_dep_text">Registered Manager</p>
                </div>
            </div>
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm">
                <span class="acct_dep_hint2">Blocked Manager</span>
                <span class="acct_dep_icon"> <i class="fas fa-users mr-4"></i> </span>
                <div class="">
                    <p class="acct_dep_header">{{ $this->blocked_teamCount() }}</p>
                    <p class="acct_dep_text">Blocked Manager</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col d-lg-flex justify-content-start align-items-center mb-4">
        <form wire:submit.prevent="" method="post" class="col d-lg-flex justify-content-between align-items-end px-0">
            <input type="search" wire:model.live="search" class="col col-lg-4 acct_form_box shadow-sm mb-3"
                placeholder="Enter your search">
            <div class="col col-lg-6 d-md-flex">
                <div class="col mb-3">
                    <label class="acct_sort_label mr-1">Sort By</label>
                    <select wire:model.lazy="sort_by" class="col acct_sort_sel">
                        <option value="">All status</option>
                        <option value="{{1}}">Active</option>
                        <option value="{{0}}">Blocked</option>
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

    <div class="col" wire:loading
        wire:target='search,sort_by,order_by,per_page,DeleteClient,ApproveMultipleClient,BlockMultipleClient,ApproveClient,BlockClient'>
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
                            <input type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck"></label>
                        </div>
                    </th>
                    <th class="table_head" scope="col">#</th>
                    <th class="table_head" scope="col">Name</th>
                    <th class="table_head" scope="col">Email Address</th>
                    <th class="table_head" scope="col">Client Count</th>
                    <th class="table_head" scope="col">Status</th>
                    <th class="table_head" scope="col">Created On</th>
                    <th class="table_head" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $item)
                <tr>
                    <th class="table_data" scope="row">
                        <div class="custom-control custom-checkbox">
                            <input wire:model.live="team_ids" value="{{ $item->id }}" type="checkbox"
                                class="custom-control-input" id="clientCheck{{$item->id}}" {{ $select_all_checkbox
                                ? 'checked' : '' }}>
                            <label class="custom-control-label" for="clientCheck{{$item->id}}"></label>
                        </div>
                    </th>
                    <th class="table_data">
                        {{ $loop->iteration }}
                    </th>
                    <td class="table_data">{{ $item->fullname }}</td>
                    <td class="table_data">{{ $item->email }}</td>
                    <td class="table_data">{{ $item->clients->count()}}</td>
                    <td class="table_data">
                        @if ($item->status == true)
                        <span class="table_status">Active</span>
                        @else
                        <span class="table_status3">Blocked</span>
                        @endif

                        @if ($item->isVerified)
                        <span class="table_status4">Verified</span>
                        @else
                        <span class="table_status2">Not Verified</span>
                        @endif
                    </td>
                    <td class="table_data">{{ Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</td>
                    <td class="table_data">
                        @if ($item->status == false)
                        <button wire:click="ApproveTeam({{ $item->id }})" class="table_btn5 mr-2">Approve</button>
                        @else
                        <button wire:click="BlockTeam({{ $item->id }})" class="table_btn4 mr-2">Block</button>
                        @endif
                        <a href="{{ route('edit-team', $item->id) }}" class="text-decoration-none mr-2"> <button
                                class="table_btn1">Edit</button> </a>
                        <button
                            onclick="return confirm('Are you sure you want to delete this user?')  || event.stopImmediatePropagation()"
                            wire:click="DeleteTeam({{ $item->id }})" class="table_btn2">Delete</button>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        @if($teams->isEmpty())
        <div class="d-flex justify-content-center bg-white mb-4">
            <img src="images/no_result.png" alt="" class="">
        </div>
        @endif

    </div>

    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">
        <div class="mb-2 mb-md-0 mx-auto mx-md-0">
            @if (count($team_ids) && $teams->isNotEmpty())
            <button wire:click='ApproveMultipleTeam()' type="button" class="table_btn5 mr-2">Approve</button>
            <button wire:click='BlockMultipleTeam()' type="button" class="table_btn4 mr-2">Block</button>
            @endif
        </div>

        {{ $teams->links() }}
    </div>

</div>