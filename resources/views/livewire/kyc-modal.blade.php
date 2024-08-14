<div class="col px-0">
    @if ($isSubmited)
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="acct_modal_header" id="staticBackdropLabel">KYC is under Review.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    @else
    <form wire:submit.prevent='UploadKyc()' method="POST" class="modal-content">
        <div class="modal-header">
            <h5 class="acct_modal_header" id="staticBackdropLabel">KYC verification.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="">
                <div class="mb-3">
                    <label class="acct_label">Verification Method</label>
                    <div class="">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref01" wire:model="verify_method" value="National ID"
                                class="custom-control-input">
                            <label class="custom-control-label acct_modal_label" for="ref01">National
                                ID</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref02" wire:model="verify_method" value="Int Passport"
                                class="custom-control-input" checked>
                            <label class="custom-control-label acct_modal_label" for="ref02">Int Passport</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref03" wire:model="verify_method" value="Driver Licence"
                                class="custom-control-input" checked>
                            <label class="custom-control-label acct_modal_label" for="ref03">Driver's
                                Licence</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref04" wire:model="verify_method" value="Others"
                                class="custom-control-input" checked>
                            <label class="custom-control-label acct_modal_label" for="ref04">Others</label>
                        </div>
                    </div>
                    @error('verify_method')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="acct_modal_label">Valid identity card.
                        <small class="font-weight-bold">(Must be a clear copy)</small>
                        <div wire:loading wire:target="verify_proof"
                            class="spinner-border spinner-border-sm text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </label>
                    <div class="col col-xl-6 px-0">
                        {{-- <div class="acct_file_input">
                            <button class="btn">Upload file</button>
                        </div> --}}
                        <input wire:model='verify_proof' type="file" name="myfile" class="acct_modal_box" />


                        {{-- @if ($verify_proof)
                        <div>
                            <img src="{{ $verify_proof->temporaryUrl() }}" height="70">
                        </div>
                        @endif --}}
                    </div>
                    @error('verify_proof')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                {{-- <div class="mb-3">
                    <label class="acct_label">Address Verification</label>
                    <div class="">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref05" wire:model="address_method" value="Gas Bill"
                                class="custom-control-input">
                            <label class="custom-control-label acct_modal_label" for="ref05">Gas Bill</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref06" wire:model="address_method" value="Eletricity Bill"
                                class="custom-control-input" checked>
                            <label class="custom-control-label acct_modal_label" for="ref06">Eletricity
                                Bill</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="ref07" wire:model="address_method" value="Others"
                                class="custom-control-input" checked>
                            <label class="custom-control-label acct_modal_label" for="ref07">Others</label>
                        </div>
                    </div>
                    @error('address_method')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="acct_modal_label">Address Proof. <small class="font-weight-bold">(Must be
                            a clear copy)</small></label>
                    <div class="col col-sm-6 px-0">
                        <div class="acct_file_input">
                            <button class="btn">Upload file</button>
                            <input wire:model='address_proof' type="file" name="myfile" />
                        </div>
                        @if ($address_proof)
                        <div>
                            <img src="{{ $address_proof->temporaryUrl() }}" height="70">
                        </div>
                        @endif
                    </div>
                    @error('address_proof')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="acct_modal_label">Passport photogragh</label>
                    <div class="col col-sm-6 px-0">
                        <div class="acct_file_input">
                            <button class="btn">Upload file</button>
                            <input wire:model='passport' type="file" name="myfile" />
                        </div>
                        @if ($passport)
                        <div>
                            <img src="{{ $passport->temporaryUrl() }}" height="70">
                        </div>
                        @endif
                    </div>
                    @error('passport')<span class="acct_box_error">{{ $message }}</span> @enderror
                </div> --}}

            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button wire:loading.remove wire:target='UploadKyc' type="submit" class="acct_modal_btn">Submit</button>
            <button wire:loading wire:target='UploadKyc' type="submit" class="acct_modal_btn disabled"
                disabled>Processing...</button>
        </div>
    </form>
    @endif
</div>