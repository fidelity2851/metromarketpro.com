<form wire:submit.prevent="updateUserPassword" method="POST" class="col col-lg-6 px-0 mr-lg-5 mb-5">
    <div class="mb-3">
        <label class="acct_label">Old Password</label>
        <input type="password" wire:model.lazy='old_password' class="acct_box" placeholder="Old Password">
        @error('old_password') <span class="acct_box_error">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="acct_label">New Password</label>
        <input type="password" wire:model.lazy='new_password' class="acct_box" placeholder="New Password">
        @error('new_password') <span class="acct_box_error">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label class="acct_label">Confirm Password</label>
        <input type="password" wire:model.lazy='new_password_confirmation' class="acct_box"
            placeholder="Confirm Password">
    </div>
    <div class="mt-2">
        <button wire:loading.remove wire:target="updateUserPassword" type="submit" class="acct_btn2">Update</button>
        <button wire:loading wire:target="updateUserPassword" type="submit" class="acct_btn2 disabled"
            disabled>Processing...</button>
    </div>

</form>