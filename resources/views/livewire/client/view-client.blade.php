<div class="col py-4 px-0 px-md-3">

    <div class="col d-xl-flex justify-content-between align-items-start mb-5">
        <div class="d-sm-flex align-items-center mb-4 mb-xl-0">
            <img src="{{ $user->image ? asset('storage/profile/'.$user->image) : asset('images/custom.jpg') }}" alt=""
                class="acct_user_img">
            <div class="acct_user_details ml-sm-4">
                <p class="acct_user_name">{{ $user->fullname }}</p>
                <p class="acct_user_email">{{ $user->email }}</p>
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
                <div class="mt-3">
                    <a href="{{ route('edit-user', $user->id) }}" class="text-decoration-none mr-2">
                        <button type="button" class="acct_user_btn">Edit</button>
                    </a>

                </div>
            </div>
        </div>
        <div class="col col-xl-7 d-md-flex justify-content-between px-0">
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm mr-md-5 mb-4 mb-md-0">
                <span class="acct_dep_hint">Active Balance</span>
                <span class="acct_dep_icon mr-4"> <i class="fas fa-wallet "></i> </span>
                <div class="">
                    @if ($GlobalSettings->allow_withdraw_deposit)
                    <p class="acct_dep_header">${{ number_format($user->balance) }}</p>
                    @else
                    <p class="acct_dep_header">${{ number_format($user->available_balance) }}</p>
                    @endif

                    <p class="acct_dep_text">Avaliable Balance</p>
                </div>
            </div>
            <div class="col acct_dep_cont d-flex align-items-center shadow-sm">
                <span class="acct_dep_hint2">Inactive Deposits</span>
                <span class="acct_dep_icon"> <i class="fas fa-donate mr-4"></i> </span>
                <div class="">
                    <p class="acct_dep_header">${{ number_format($pending_deposit) }}</p>
                    <p class="acct_dep_text">Pending Deposits</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="col acct_newdep_cont shadow-sm ">
            <div class="d-md-flex justify-content-between align-items-start mb-4">
                <p class="acct_user_header mb-3 mb-md-0">Transactions</p>
                <div class="acct_user_tab_con nav" id="myTab" role="tablist">
                    <p class="acct_user_tab active" id="nav-deposit-tab" data-toggle="tab" href="#nav-deposit"
                        role="tab" aria-controls="nav-deposit" aria-selected="true">Deposits</p>
                    <p class="acct_user_tab" id="nav-withdraw-tab" data-toggle="tab" href="#nav-withdraw" role="tab"
                        aria-controls="nav-withdraw" aria-selected="false">Withdrawal</p>
                    <p class="acct_user_tab" id="nav-payout-tab" data-toggle="tab" href="#nav-payout" role="tab"
                        aria-controls="nav-payout" aria-selected="false">Payouts</p>
                </div>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-deposit" role="tabpanel"
                    aria-labelledby="nav-deposit-tab">
                    @livewire('client.client-deposit', ['user_id' => $user->id])
                </div>
                <div class="tab-pane fade" id="nav-withdraw" role="tabpanel" aria-labelledby="nav-withdraw-tab">
                    @livewire('client.client-withdrawal', ['user_id' => $user->id])
                </div>
                <div class="tab-pane fade" id="nav-payout" role="tabpanel" aria-labelledby="nav-payout-tab">
                    @livewire('client.client-payout', ['user_id' => $user->id])
                </div>

            </div>
        </div>
    </div>

</div>