<form wire:submit.prevent="CreateTicket" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">CREATE TICKET </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
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
                <label class="acct_modal_label">Subject</label>
                <input type="text" wire:model.lazy="subject" class="acct_modal_box" min="1" placeholder="Enter Subject">
                @error('subject')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            <div class="d-md-flex">
                <div class="col px-0 mr-md-3  mb-3">
                    <label class="acct_modal_label">Category</label>
                    <select wire:model.lazy="category" class="acct_modal_sel">
                        <option value="" selected>Choose Here</option>
                        @foreach (App\Enums\TicketCategories::cases() as $item)
                        <option value="{{$item->value}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('category')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col px-0 mb-3">
                    <label class="acct_modal_label">Priority</label>
                    <select wire:model.lazy="priority" class="acct_modal_sel">
                        <option value="" selected>Choose Here</option>
                        @foreach (App\Enums\TicketPriority::cases() as $item)
                        <option value="{{$item->value}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('priority')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
            @can('adminOnly')
            <div class="col px-0 mb-3">
                <label class="acct_modal_label">Assign to</label>
                <select wire:model.lazy="manager" class="acct_modal_sel">
                    @if (count($managers) != 0)
                    <option value="">Select User</option>
                    @else
                    <option value="">No user found</option>
                    @endif
                    @foreach ($managers as $item)
                    <option value="{{$item->id}}" {{$manager==$item->id ? 'selected' : ''}}>{{$item->fullname}} -
                        {{$item->email}}</option>
                    @endforeach
                </select>
                @error('manager')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>
            @endcan
            <div class="mb-3">
                <label class="acct_modal_label">Message</label>
                <textarea wire:model.lazy="message" class="acct_modal_box" cols="30" rows="7"
                    placeholder="Details your issue here"></textarea>
                @error('message')<span class="acct_box_error">{{ $message }}</span> @enderror
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading.remove wire:target="CreateTicket" type="submit" class="acct_modal_btn">Submit</button>
        <button wire:loading wire:target="CreateTicket" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
    </div>
</form>