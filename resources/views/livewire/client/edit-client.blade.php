<div class="col py-4 px-0 px-md-3">

    <div class="col d-sm-flex justify-content-between align-items-center mb-4">
        <p class="acct_cont_header mb-3 mb-md-0">Edit Client</p>
        <a href="{{ route('show-user', $user->id) }}" class="text-decoration-none"> <button type="button"
                class="acct_btn2"> <i class="fas fa-arrow-left mr-2"></i> Back</button> </a>
    </div>
    <div class="col">
        <div class="col acct_newdep_cont shadow-sm ">
            <div class="col d-lg-flex px-0">
                <form wire:submit.prevent="UpdateClient()" class="col px-0 mr-lg-5">
                    <div class="d-md-flex ">
                        <div class="col px-0 mr-md-4 mb-3">
                            <label class="acct_label">Username</label>
                            <input type="text" wire:model.lazy="username" class="acct_box" placeholder="Username">
                            @error('username') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Full Name</label>
                            <input type="text" wire:model.lazy="fullname" class="acct_box" placeholder="Full name">
                            @error('fullname') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Email</label>
                            <input type="email" wire:model.lazy="email" class="acct_box" placeholder="Email Address">
                            @error('email') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Phone</label>
                            <input type="tel" wire:model.lazy="phone" class="acct_box" placeholder="Phone">
                            @error('phone') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @can('adminOnly')
                    <div class="d-md-flex">
                        <div class="col px-0 mr-md-4 mb-3">
                            <label class="acct_label">Role</label>
                            <select wire:model.lazy="role" class="acct_box">
                                @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col px-0 mb-3">
                            <label class="acct_label">Manager</label>
                            <select wire:model.lazy="manager" class="acct_box">
                                <option value="">Select here</option>
                                @foreach ($managers as $item)
                                <option value="{{ $item->id }}">{{ $item->username . ' - ' . $item->email }}</option>
                                @endforeach
                            </select>
                            @error('manager') <span class="acct_box_error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endcan
                    <div class="mb-3">
                        <label class="acct_label">Short Biograph</label>
                        <textarea wire:model.lazy="biography" class="acct_box" cols="30" rows="7"
                            placeholder="Tell us a little about your self"></textarea>
                        @error('biography') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="d-md-flex">
                        <div class="col px-0 mb-3">
                            <label class="acct_label">Google 2FA Secret</label>
                            <input type="tel" wire:model.lazy="two_fa_secret" class="acct_box" placeholder="2FA Secret" readonly>
                        </div>
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" wire:model.live="status" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label acct_label" for="customSwitch1">DEACTIVATE
                            CLIENTS</label>
                        @error('status') <span class="acct_box_error">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4">
                        <button wire:loading wire:target="UpdateClient" type="button" class="acct_btn2 disabled"
                            disabled>Processing...</button>
                        <button wire:loading.remove wire:target="UpdateClient" type="submit"
                            class="acct_btn2">Update</button>
                    </div>
                </form>
                <div class="col px-0">


                </div>
            </div>

        </div>
    </div>

</div>