<div class="col acct_header_con d-flex justify-content-between align-items-center sticky-top px-3 px-sm-4">
    <div class="d-flex align-items-center">
        <span id="open_menu" class="acct_menu_bar d-xl-none mr-2 mr-sm-4"> <i class="fas fa-bars"></i>
        </span>
        <p class="acct_header">{{ $title }}</p>
    </div>
    <div class=" d-flex align-items-center">

        {{-- <a href="{{ route('notifications') }}" class="text-decoration-none">
            <span class="acct_header_icon position-relative "> <span class="acct_header_dot"></span> <i
                    class="fas fa-bell"></i> </span>
        </a> --}}
        @if (!auth()->user()->isVerified)
        <span class="acct_header_line mx-1 mx-sm-3"></span>

        @if ($GlobalSettings->kyc_active)
        <span class="acct_header_icon position-relative " data-toggle="modal" data-target="#gobal_kyc">
            <i class="fas fa-certificate"></i> <span class="acct_header_text">KYC</span>
        </span>
        @endif
        @endif
        <span class="acct_header_line mx-1 mx-sm-3"></span>
        <div class="dropdown ">
            <img src="{{ auth()->user()->image ? asset('storage/profile/' . auth()->user()->image) : asset('images/custom.jpg')}}"
                alt="" class="acct_header_img" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="dropdownMenuButton">
                <a href="{{ route('profile')}}" class="text-decoration-none">
                    <p class="acct_header_link">Personal Settings</p>
                </a>
                @can('adminOnly')
                <a href="{{ route('settings')}}" class="text-decoration-none">
                    <p class="acct_header_link">Account Settings</p>
                </a>
                @endcan
                <form action="{{ Route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="col acct_header_link border-0">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>