<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Edit Ticket</p>
        <a href="{{route('view-ticket', $ticket->id)}}" class="text-decoration-none">
            <button type="button" class="acct_btn2"> <i class="fas fa-arrow-left mr-2"></i> Back</button>
        </a>
    </div>
    <div class="col">
        <div class="col acct_newdep_cont shadow-sm ">
            <div class="col px-0">
                <form wire:submit.prevent="UpdateTicket" method="POST" class="col px-0">

                    <div class="mb-3">
                        <label class="acct_modal_label">Subject</label>
                        <input type="text" wire:model.lazy="subject" class="acct_modal_box" min="1"
                            placeholder="Enter Subject">
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
                            <option value="{{$item->id}}" {{$manager==$item->id ? 'selected' :
                                ''}}>{{$item->fullname}} -
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


                    <button wire:loading.remove wire:target="UpdateTicket" type="submit"
                        class="acct_modal_btn">Submit</button>
                    <button wire:loading wire:target="UpdateTicket" type="button" class="acct_modal_btn disabled"
                        disabled>Processing...</button>

                </form>
            </div>

        </div>
    </div>

</div>