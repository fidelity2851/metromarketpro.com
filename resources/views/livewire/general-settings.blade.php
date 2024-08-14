<div class="col acct_cont_con px-0">

    <x-top-header title="Settings" />

    <div class="col py-4 px-0 px-md-3">

        <div class="col d-flex justify-content-between align-items-center mb-4">
            <p class="acct_cont_header">General Settings</p>
        </div>

        <div class="col">
            <div class="col acct_newdep_cont shadow-sm ">
                <div class="d-flex align-items-start mb-4">
                    <div class="acct_user_tab_con nav" id="myTab" role="tablist">
                        <p class="acct_user_tab active" id="nav-company-tab" data-toggle="tab" href="#nav-company"
                            role="tab" aria-controls="nav-company" aria-selected="true">Company Information</p>
                        <p class="acct_user_tab" id="nav-site-tab" data-toggle="tab" href="#nav-site" role="tab"
                            aria-controls="nav-siteemail" aria-selected="false">Site Settings</p>
                        {{-- <p class="acct_user_tab" id="nav-email-tab" data-toggle="tab" href="#nav-email" role="tab"
                            aria-controls="nav-email" aria-selected="false">Email & SMS Settings</p> --}}
                        <p class="acct_user_tab" id="nav-referral-tab" data-toggle="tab" href="#nav-referral" role="tab"
                            aria-controls="nav-referral" aria-selected="false">Referral Settings</p>
                        <p class="acct_user_tab" id="nav-kyc-tab" data-toggle="tab" href="#nav-kyc" role="tab"
                            aria-controls="nav-kyc" aria-selected="false">KYC verification Settings</p>
                    </div>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <form method="post" wire:submit.prevent="UpdateCompanySettings()" class="tab-pane fade show active"
                        id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab" enctype="multipart/form-data">
                        <div class="col d-lg-flex px-0">
                            <div class="col px-0 mr-lg-5">
                                <div class="mb-3">
                                    <label class="acct_label">Company Name</label>
                                    <input type="text" wire:model.lazy="company_name" class="acct_box" min="1"
                                        placeholder="Enter company name">
                                    @error('company_name') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="d-md-flex">
                                    <div class="col px-0 mr-md-3 mb-3">
                                        <label class="acct_label">Company Phone</label>
                                        <input type="tel" wire:model.lazy="company_phone" class="acct_box"
                                            placeholder="000-000-0000">
                                        @error('company_phone') <span class="acct_box_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col px-0 mb-3">
                                        <label class="acct_label">Company Tel</label>
                                        <input type="tel" wire:model.lazy="company_tel" class="acct_box"
                                            placeholder="000-000-0000">
                                        @error('company_tel') <span class="acct_box_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Company Email</label>
                                    <input type="text" wire:model.lazy="company_email" class="acct_box"
                                        placeholder="Enter company email">
                                    @error('company_email') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Company URL</label>
                                    <input type="text" wire:model.lazy="company_url" class="acct_box"
                                        placeholder="Enter company URL">
                                    @error('company_url') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Company Address</label>
                                    <textarea wire:model.lazy="company_address" class="acct_box" cols="30"
                                        rows="5"></textarea>
                                    @error('company_address') <span class="acct_box_error">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>
                            <div class="col px-0">
                                <div class="d-md-flex">
                                    <div class="col px-0 mb-3">
                                        <label class="acct_label">Currency</label>
                                        <select wire:model.lazy="currency" class="acct_sel">
                                            <option value="null" disabled>Select currency</option>
                                            <option value="$">Dollar</option>
                                            <option value="₦">Naira</option>
                                        </select>
                                        @error('currency') <span class="acct_box_error">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Default Language</label>
                                    <select wire:model.lazy="language" class="acct_sel">
                                        <option value="null" disabled>Select language</option>
                                        <option value="English">English</option>
                                        <option value="Russian">Russian</option>
                                        <option value="Português">Português</option>
                                        <option value="Español">Español</option>
                                        <option value="German">German</option>
                                        <option value="Portugues br">Portugues br</option>
                                        <option value="Tr">Tr</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Swedish">Swedish</option>
                                        <option value="Indonesia">Indonesia</option>
                                    </select>
                                    @error('language') <span class="acct_box_error">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Minimum withdrawal</label>
                                    <input type="number" wire:model.lazy="min_withdrawal" class="acct_box" placeholder="">
                                    @error('min_withdrawal') <span class="acct_box_error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label"> Withdrawal Fee Type</label>
                                    <select wire:model.lazy="withdrawal_fee_type" class="acct_sel">
                                        <option value="">Choose Here</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                    @error('withdrawal_fee_type') <span class="acct_box_error">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="acct_label">Withdrawal Feee</label>
                                    <input type="number" wire:model.lazy="withdrawal_fee" class="acct_box" placeholder="Eg. 20">
                                    @error('withdrawal_fee') <span class="acct_box_error">{{ $message }}</span>@enderror
                                </div>
                                <div class="d-sm-flex mb-3">
                                    <img src="{{ $white_logo_preview ? asset('storage/settings/'.$white_logo_preview) : asset('images/paypal.png')}}" class="rounded set_img mr-3">
                                    <div class="col px-0">
                                        <label class="acct_label">White Logo</label>
                                        <div class="custom-file">
                                            <input type="file" wire:model="white_logo" class="acct_box"
                                                id="inputGroupFile03">
                                            @error('white_logo') <span class="acct_box_error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-sm-flex mb-3">
                                    <img src="{{ $dark_logo_preview ? asset('storage/settings/'.$dark_logo_preview) : 'images/stripe.jpg'}}" class="rounded set_img mr-3">
                                    <div class="col px-0">
                                        <label class="acct_label">Dark Logo</label>
                                        <div class="custom-file">
                                            <input type="file" wire:model="dark_logo" class="acct_box"
                                                id="inputGroupFile03">
                                            @error('dark_logo') <span class="acct_box_error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="d-sm-flex mb-3">
                                    <img src="{{ $favicon_preview ? asset('storage/settings/'.$favicon_preview) : asset('images/paystack.jpg')}}" class="rounded set_img mr-3">
                                    <div class="col px-0">
                                        <label class="acct_label">Favicon</label>
                                        <div class="custom-file">
                                            <input type="file" wire:model="favicon" class="acct_box"
                                                id="inputGroupFile03">
                                            @error('favicon') <span class="acct_box_error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button wire:loading.remove wire:target='UpdateCompanySettings' type="submit" class="acct_btn2">Update</button>
                            <button wire:loading wire:target='UpdateCompanySettings' type="button" class="acct_btn2 disabled" disabled>Processing...</button>
                        </div>
                    </form>
                    <div class="tab-pane fade" id="nav-site" role="tabpanel" aria-labelledby="nav-site-tab">
                        @livewire('settings.site-settings')
                    </div>
                    <div class="tab-pane fade" id="nav-email" role="tabpanel" aria-labelledby="nav-email-tab">
                       @livewire('settings.email-sms-settings')
                    </div>
                    <div class="tab-pane fade" id="nav-referral" role="tabpanel" aria-labelledby="nav-referral-tab">
                       @livewire('settings.referral-settings')
                    </div>
                    <div class="tab-pane fade" id="nav-kyc" role="tabpanel" aria-labelledby="nav-kyc-tab">
                       @livewire('settings.kyc-verification-settings')
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>