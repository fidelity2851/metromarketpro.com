
<form wire:submit.prevent="CreateNewTeam()" method="POST" class="modal-content">
    <div class="modal-header">
        <h5 class="acct_modal_header" id="staticBackdropLabel">CREATE Team </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="">
            <div class="d-md-flex ">
                <div class="col px-0 mr-md-4 mb-3">
                    <label class="acct_modal_label">Full Name</label>
                    <input type="text" wire:model="fullname" class="acct_modal_box" placeholder="Frist & Last Name">
                    @error('fullname') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col px-0 mb-3">
                    <label class="acct_modal_label">Username</label>
                    <input type="text" wire:model="username" class="acct_modal_box" placeholder="Username">
                    @error('username') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="d-md-flex">
                <div class="col px-0 mr-md-4 mb-3">
                    <label class="acct_modal_label">Email</label>
                    <input type="email" wire:model="email" class="acct_modal_box" placeholder="Email Address">
                    @error('email') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col px-0 mb-3">
                    <label class="acct_modal_label">Referral</label>
                    <input type="text" wire:model="referral" class="acct_modal_box"
                        placeholder="Referral Code (Optional)">
                    @error('referral') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="d-md-flex">
                <div class="col px-0 mr-md-4 mb-3">
                    <label class="acct_modal_label">Password</label>
                    <input type="password" wire:model="password" class="acct_modal_box" placeholder="Password">
                    @error('password') <span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="col px-0 mb-3">
                    <label class="acct_modal_label">Comfirm Password</label>
                    <input type="password" wire:model="password_confirmation" class="acct_modal_box"
                        placeholder="Comfirm Password">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button wire:loading wire:target="CreateNewTeam" type="button" class="acct_modal_btn disabled"
            disabled>Processing...</button>
        <button wire:loading.remove wire:target="CreateNewTeam" type="submit" class="acct_modal_btn">Submit</button>
    </div>
</form>