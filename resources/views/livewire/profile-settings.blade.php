<div class="col acct_cont_con px-0">

    <x-top-header title="Profile" />

    <div class="col py-4 px-0 px-md-3">

        <div class="col d-flex justify-content-between align-items-start mb-5">
            <div class="d-sm-flex align-items-center">
                <img src="{{ $user->image ? asset('/storage/profile/'.$user->image) : asset('images/custom.jpg') }}"
                    alt="" class="acct_user_img">
                <div class="acct_user_details ml-sm-4">
                    <p class="acct_user_name">{{ $user?->fullname }}</p>
                    <p class="acct_user_email">{{ $user?->email }}</p>
                    @if (($GlobalSettings->must_verify_email ? auth()->user()->email_verified_at : true) ||
                    ($GlobalSettings->kyc_active ? auth()->user()->isVerified : true))
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
        </div>

        <div class="col">
            <div class="col acct_newdep_cont shadow-sm ">
                <div class="d-md-flex justify-content-between align-items-start mb-4">
                    <p class="acct_user_header">Account Details</p>
                    <div class="acct_user_tab_con nav" id="myTab" role="tablist">
                        <p class="acct_user_tab active" id="nav-deposit-tab" data-toggle="tab" href="#nav-deposit"
                            role="tab" aria-controls="nav-deposit" aria-selected="true">My Profile</p>
                        <p class="acct_user_tab" id="nav-withdraw-tab" data-toggle="tab" href="#nav-withdraw" role="tab"
                            aria-controls="nav-withdraw" aria-selected="false">Payment Account</p>
                        <p class="acct_user_tab" id="nav-payout-tab" data-toggle="tab" href="#nav-payout" role="tab"
                            aria-controls="nav-payout" aria-selected="false">Security</p>
                    </div>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-deposit" role="tabpanel"
                        aria-labelledby="nav-deposit-tab">
                        <div class="col d-lg-flex px-0">
                            <form wire:submit.prevent="updateUserProfile" method="POST"
                                class="col px-0 mr-lg-5 mb-5 mb-lg-0" enctype="multipart/form-data">
                                <div class="d-md-flex">
                                    <div class="col px-0 mr-md-4 mb-3">
                                        <label class="acct_label">Username</label>
                                        <input type="text" wire:model.lazy='username' class="acct_box"
                                            placeholder="First name">
                                        @error('username') <span class="acct_box_error">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col px-0 mb-3">
                                        <label class="acct_label">Fullname</label>
                                        <input type="text" wire:model.lazy='fullname' class="acct_box"
                                            placeholder="Last name">
                                        @error('fullname') <span class="acct_box_error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Email</label>
                                    <input type="email" wire:model.lazy='email' class="acct_box"
                                        placeholder="Email Address" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Phone</label>
                                    <input type="tel" wire:model.lazy='phone' class="acct_box"
                                        placeholder="000-000-0000">
                                    @error('phone') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="d-flex mb-3">
                                    <img src="{{ $user->image ? asset('/storage/profile/'.$user->image) : asset('images/custom.jpg') }}"
                                        class="rounded mr-3" height="100px" width="100px"
                                        style="object-fit: scale-down">
                                    <div class="col px-0">
                                        <label class="acct_label">Profile Picture</label>
                                        <div class="">
                                            <input type="file" wire:model.lazy='image' class="acct_box"
                                                id="profileimage">
                                        </div>
                                        @error('image') <span class="acct_box_error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Short Biograph <small>(Optional)</small> </label>
                                    <textarea wire:model.lazy="biography" class="acct_box" cols="30" rows="5"
                                        placeholder="Tell us a little about your self"></textarea>
                                    @error('biography') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="mt-2">
                                    <button wire:loading.remove wire:target="updateUserProfile" type="submit"
                                        class="acct_btn2">Update</button>
                                    <button wire:loading wire:target="updateUserProfile" type="submit"
                                        class="acct_btn2 disabled" disabled>Processing...</button>
                                </div>
                            </form>
                            <div class="col px-0">
                                <x-refer-earn-box></x-refer-earn-box>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="nav-withdraw" role="tabpanel" aria-labelledby="nav-withdraw-tab">
                        @livewire('profile.withdrawal-method')
                    </div>
                    <div class="tab-pane fade" id="nav-payout" role="tabpanel" aria-labelledby="nav-payout-tab">
                        <div class="col d-lg-flex px-0">
                            {{-- Update Password Component --}}
                            @livewire('profile.update-password')

                            
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>