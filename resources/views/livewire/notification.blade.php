<div class="col py-4 px-0 px-md-3">

    <div class="col d-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header">Notification</p>
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

    <div wire:loading wire:target='search,sort_by,order_by,per_page,DeleteNotification' class="col">
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


    <div class="col col-lg-10 accordion mx-auto" id="accordionExample">
        @foreach ($notifications as $item)
        <div class="col acct_not_con shadow-sm mb-3">
            <div class="acct_not_head_con d-lg-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="custom-control custom-checkbox mr-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck"></label>
                    </div>
                    <p class="acct_not_head {{$item->read_at ? 'read' : ''}}" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">{{ json_encode($item->data, true) }}
                    </p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="acct_not_date mr-4">{{Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
                    <div class="">
                        <span class="acct_not_icon mr-2"> <i class="fas fa-envelope-open"></i> </span>
                        <span
                            onclick="return confirm('Are you sure you want to delete this Record?')  || event.stopImmediatePropagation()"
                            wire:click="DeleteNotification({{ $item->id }})" class="acct_not_icon2"> <i
                                class="fas fa-trash-alt"></i> </span>
                    </div>
                </div>
            </div>
            <div id="collapseOne" class="acct_not_cont collapse mt-2" aria-labelledby="headingOne"
                data-parent="#accordionExample">
                <p class="acct_not_text">
                    {{$item->data}}
                </p>
            </div>
        </div>
        @endforeach
    </div>

    @if($notifications->isEmpty())
    <div class="d-flex justify-content-center bg-white mb-4">
        <img src="images/no_result.png" alt="" class="">
    </div>
    @endif

    <div class="col d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">

        {{ $notifications->links() }}
    </div>

</div>