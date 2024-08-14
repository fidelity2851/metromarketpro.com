<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Manage Ticket</p>
        <a href="{{route('tickets')}}" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i
                    class="fas fa-arrow-left mr-2"></i> Back</button> </a>
    </div>
    <div class="col">
        <div class="col acct_newdep_cont shadow-sm ">
            <div class="col px-0 mr-xl-5 mb-5 mb-xl-0">
                <div class="d-sm-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center mb-3 mb-sm-0">
                        <img src="{{ $ticket->user->image ? asset('storage/profile/'.$ticket->user->image) : asset('images/custom.jpg') }}"
                            alt="" class="acct_sup_img mr-3">
                        <div class="">
                            <p class="acct_sup_name">{{$ticket->user->fullname}}</p>
                            @if ($ticket->user->isVerified)
                            <p class="acct_menu_hint d-flex align-items-center"> <img
                                    src="{{asset('images/verified.png')}}" alt="" class="mr-1"> Verified</p>
                            @else
                            <p class="acct_menu_hint text-danger">
                                Not Verified
                            </p>
                            @endif
                            <span class="acct_sup_status3">{{$ticket->manager ? $ticket->manager->fullname : 'No
                                Manager'}}</span>
                        </div>
                    </div>
                    <div class="">
                        @if ($ticket->status)
                        <button type="button" wire:loading.remove wire:target="MarkPending,MarkResolved"
                            wire:click="MarkPending({{$ticket->id}})" class="acct_sup_btn">Mark as Pending</button>
                        @else
                        <button type="button" wire:loading.remove wire:target="MarkPending,MarkResolved"
                            wire:click="MarkResolved({{$ticket->id}})" class="acct_sup_btn">Mark as resolved</button>
                        @endif
                        <button type="button" wire:loading wire:target="MarkPending,MarkResolved"
                            class="acct_sup_btn disabled" disabled>Processing...</button>
                        <a href="{{route('edit-ticket', $ticket->id)}}"><button type="button"
                                class="acct_sup_btn ml-2">Edit</button></a>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <span class="acct_sup_date mr-3"> <i class="fas fa-calendar-alt mr-1"></i>
                            {{Carbon\Carbon::parse($ticket->created_at)->toFormattedDateString()}}</span>
                        @if ($ticket->status)
                        <span class="acct_sup_status mr-3">Resolved</span>
                        @else
                        <span class="acct_sup_status5 mr-3">Pending</span>
                        @endif
                        <span class="acct_sup_status2 text-capitalize">{{$ticket->priority}}</span>
                    </div>
                </div>
                <div class="mb-4">
                    <span class="acct_sup_status4 text-capitalize">{{$ticket->category}}</span>
                    <p class="acct_sup_title">Subject: <span>{{$ticket->subject}}</span> </p>
                    <p class="acct_sup_desc">{{$ticket->message}}</p>
                </div>
                <div class="acct_sup_cont_con d-flex flex-column-reverse mb-4">
                    @foreach ($ticket->messages as $item)
                    <div class="acct_sup_cont d-flex align-self-start">
                        <img src="{{ $ticket->user->image ? asset('storage/profile/'.$ticket->user->image) : asset('images/custom.jpg') }}"
                            alt="" class="acct_sup_img2 mr-2">
                        <div>
                            <p class="acct_sup_username">{{ $item->user->fullname }}</p>
                            <pre class="acct_sup_msg">{{ $item->message }}</pre>
                            <p class="acct_sup_time">
                                {{Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</p>
                        </div>
                        <span
                            onclick="return confirm('Are you sure you want to delete?')  || event.stopImmediatePropagation()"
                            wire:click="DeleteMessage({{$item->id}})" class="acct_sup_error ml-auto">
                            <i class="fa fa-trash"></i>
                        </span>
                    </div>
                    @endforeach
                </div>
                @if ($ticket->status == false)
                <form wire:submit.prevent="SendMessage()" method="post" class="">
                    <div class="mb-3 ">
                        <textarea wire:model.lazy="message" class="acct_box" cols="30" rows="4"
                            placeholder="Write your comments..."></textarea>
                        @error('message')<span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>

                    <button wire:loading.remove wire:target="SendMessage" type="submit" class="acct_btn2">Send</button>
                    <button wire:loading wire:target="SendMessage" type="submit" class="acct_btn2 disabled"
                        disabled>Sending...</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>