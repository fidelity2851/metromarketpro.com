<div class="col py-4 px-0 px-md-3">


    <!-- Identity Preview Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="acct_modal_header" id="exampleModalLabel">Identification Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('storage/kyc/' . $kyc->verify_proof)}}" alt="" class="kyc_img">
                </div>
                <div class="modal-footer">
                    <button type="button" class="acct_modal_btn2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Address Proof Preview Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="acct_modal_header" id="exampleModalLabel2"> Address Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('storage/kyc/' . $kyc->address_proof)}}" alt="" class="kyc_img">
                </div>
                <div class="modal-footer">
                    <button type="button" class="acct_modal_btn2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Passport Preview Modal -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="acct_modal_header" id="exampleModalLabel2"> Passport Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{asset('storage/kyc/' . $kyc->passport)}}" alt="" class="kyc_img">
                </div>
                <div class="modal-footer">
                    <button type="button" class="acct_modal_btn2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-sm-0">Manage KYC</p>
        <a href="{{ route('kyc') }}" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i
                    class="fas fa-arrow-left mr-2"></i> Back</button> </a>
    </div>
    <div class="col">
        <div class="col acct_newdep_cont shadow-sm ">
            <div class="col d-flex px-0">
                <div class="col col-xl-6 px-0">
                    <div class="d-sm-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center mb-3 mb-sm-0">
                            <img src="{{ $kyc->user->image ? asset('storage/profile/'.$kyc->user->image) : asset('images/custom.jpg') }}"
                                alt="" class="acct_sup_img mr-3">
                            <div class="">
                                <p class="acct_sup_name">{{ $kyc->user->fullname }}</p>
                                @if ($kyc->user->isVerified)
                                <p class="acct_menu_hint d-flex align-items-center">
                                    <img src="{{ asset('images/verified.png') }}" alt="" class="mr-1">
                                    Verified
                                </p>
                                @else
                                <p class="acct_menu_hint text-danger">
                                    Not Verified
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="d-sm-flex align-items-center">
                            <span class="acct_sup_date mr-3"> <i class="fas fa-calendar-alt mr-1"></i>
                                {{ date("F jS, Y", strtotime($kyc->created_at)) }}</span>
                            @switch($kyc->status)
                            @case('Approved')
                            <span class="acct_sup_status mr-3">{{ App\Enums\KycStatus::APPROVED->value }}</span>
                            @break
                            @case('Pending')
                            <span class="acct_sup_status5 mr-3">{{ App\Enums\KycStatus::PENDING->value }}</span>
                            @break
                            @case('Rejected')
                            <span class="acct_sup_status2 mr-3">{{ App\Enums\KycStatus::REJECTED->value }}</span>
                            @break
                            @default

                            @endswitch
                            {{-- <span class="acct_sup_status3">John Doe</span> --}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">


                    </div>
                    <form wire:submit.prevent="UpdateKyc()" class="col px-0">
                        <div class="mb-3">
                            <label class="acct_label text-uppercase">Identification Document [ID] <span
                                    class="acct_down_link" data-toggle="modal" data-target="#exampleModal">View
                                    Document</span> </label>
                            <div class="">
                                <label class="acct_label">
                                    <small class="font-weight-bold">Approve Status</small>
                                </label>
                                <div class="">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref1" wire:model.live="id_verify"
                                            class="custom-control-input" value="{{true}}">
                                        <label class="custom-control-label acct_label" for="ref1">Approved</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref2" wire:model.live="id_verify"
                                            class="custom-control-input" value="{{0}}">
                                        <label class="custom-control-label acct_label" for="ref2">Rejected</label>
                                    </div>
                                </div>
                                @if ($id_verify == false)
                                <textarea wire:model.lazy="id_reason" class="acct_box" cols="30" rows="4"
                                    value="{{ $kyc->verify_reason }}" placeholder="Reasons"></textarea>
                                @error('id_reason') <span class="acct_box_error">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="acct_label text-uppercase">Address verification document [Other] <span
                                    class="acct_down_link" data-toggle="modal" data-target="#exampleModal2">View
                                    Document</span> </label>
                            <div class="">
                                <label class="acct_label">
                                    <small class="font-weight-bold">Approve Status</small>
                                </label>
                                <div class="">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref3" wire:model.live="address_verify"
                                            class="custom-control-input" value="{{true}}">
                                        <label class="custom-control-label acct_label" for="ref3">Approved</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref4" wire:model.live="address_verify"
                                            class="custom-control-input" value="{{0}}">
                                        <label class="custom-control-label acct_label" for="ref4">Rejected</label>
                                    </div>
                                </div>
                                @if ($address_verify == false)
                                <textarea wire:model.lazy="address_reason" class="acct_box" cols="30" rows="4"
                                    placeholder="Reasons"></textarea>
                                @error('address_reason') <span class="acct_box_error">{{ $message }}</span> @enderror
                                @endif
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="acct_label text-uppercase">Passport document [Other] <span
                                    class="acct_down_link" data-toggle="modal" data-target="#exampleModal3">View
                                    Document</span> </label>
                            <div class="">
                                <label class="acct_label">
                                    <small class="font-weight-bold">Approve Status</small>
                                </label>
                                <div class="">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref5" wire:model.live="passport_verify"
                                            class="custom-control-input" value="{{true}}">
                                        <label class="custom-control-label acct_label" for="ref5">Approved</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ref6" wire:model.live="passport_verify"
                                            class="custom-control-input" value="{{0}}">
                                        <label class="custom-control-label acct_label" for="ref6">Rejected</label>
                                    </div>
                                </div>
                                @if ($passport_verify == false)
                                <textarea wire:model.lazy="passport_reason" class="acct_box" cols="30" rows="4"
                                    placeholder="Reasons"></textarea>
                                @error('passport_reason') <span class="acct_box_error">{{ $message }}</span> @enderror
                                @endif
                            </div>

                        </div> --}}


                        <button wire:loading wire:target="UpdateKyc" type="button" class="acct_btn2 disabled"
                            disabled>Processing...</button>
                        <button wire:loading.remove wire:target="UpdateKyc" type="submit"
                            class="acct_btn2">Update</button>

                    </form>


                </div>

            </div>

        </div>
    </div>

</div>