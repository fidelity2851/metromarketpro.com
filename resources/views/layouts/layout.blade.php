<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VestTrade Solutions | @yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600&family=Poppins:wght@100;200;300;400;500;800&display=swap"
        rel="stylesheet">

    <!--stylesheet-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="font/flaticon.css"> -->

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @livewireStyles
</head>

<body>

    <div class="housing d-flex ">

        <!-- KYC Modal -->
        <div class="modal fade" id="gobal_kyc" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                @livewire('kyc-modal')
            </div>
        </div>


        {{-- Side MenuBar --}}
        <div id="menu_con" class="acct_menu_con shadow">
            <div class="col acct_menu_header_con d-flex justify-content-center align-items-center sticky-top">
                <!-- <p class="acct_menu_header">VESTPRO</p> -->
                <img src="{{ $GlobalSettings->dark_logo ? asset('storage/settings/'.$GlobalSettings->dark_logo) : asset('images/logo.png') }}"
                    alt="" width="200" class="bg-light rounded">
                <span id="close_menu" class="acct_menu_bar d-xl-none ml-auto"> <i class="fas fa-times"></i> </span>
            </div>
            <div class="col d-flex acct_menu_head_con border-bottom p-4">
                <img src="{{ auth()->user()->image ? asset('storage/profile/'.auth()->user()->image) : asset('images/custom.jpg') }}"
                    alt="User Image" class="acct_menu_img">
                <div class="col ">
                    <p class="acct_menu_head">{{ auth()->user()->username }}</p>
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

            <div class="acct_menu_link_con overflow-auto">
                <a href="{{ Route('dashboard') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-th-large"></i> </span>
                        Dashboard
                    </p>
                </a>
                <a href="{{ Route('deposit') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-donate"></i> </span>
                        Fund your account
                    </p>
                </a>
                <a href="{{ Route('invest') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fa-solid fa-cubes"></i> </span>
                        Invest
                    </p>
                </a>
                <a href="{{ Route('withdrawal') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fa-solid fa-dollar-sign"></i> </span>
                        Withdraw funds
                    </p>
                </a>
                {{-- <a href="{{ Route('transfer-funds') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fa-solid fa-arrow-right-arrow-left"></i> </span>
                        Transfer funds
                    </p>
                </a> --}}
                <a href="{{ Route('payout') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fa-solid fa-briefcase"></i> </span>
                        Transaction history
                    </p>
                </a>
                {{-- <div class="drop_menu_link_con">
                    <a href="#" class="text-decoration-none">
                        <p class="acct_menu_link d-flex">
                            <span class="acct_menu_icon mr-3"> <i class="fas fa-donate"></i> </span>
                            Transactions
                            <span class="acct_menu_icon ml-auto"> <i class="fas fa-angle-down"></i> </span>
                        </p>
                    </a>
                    <div class="drop_menu_link_cont">

                    </div>
                </div> --}}
                @can('adminOnly')
                <a href="{{ Route('plans') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-boxes"></i> </span>
                        Plans
                    </p>
                </a>
                @endcan
                @canany(['adminOnly', 'teamOnly'])
                <div class="drop_menu_link_con">
                    <a href="#" class="text-decoration-none">
                        <p class="acct_menu_link d-flex">
                            <span class="acct_menu_icon mr-3"> <i class="fas fa-users"></i> </span>
                            Users
                            <span class="acct_menu_icon ml-auto"> <i class="fas fa-angle-down"></i> </span>
                        </p>
                    </a>
                    <div class="drop_menu_link_cont">
                        <a href="{{ Route('users') }}" class="text-decoration-none">
                            <p class="drop_menu_link">Client</p>
                        </a>
                        {{-- @can('adminOnly')
                        <a href="{{ Route('teams') }}" class="text-decoration-none">
                            <p class="drop_menu_link">Manager</p>
                        </a>
                        @endcan --}}
                    </div>
                </div>
                @endcanany
                {{-- <a href="{{ Route('tickets') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-headset"></i> </span>
                        Support
                    </p>
                </a> --}}
                @can('adminOnly')
                <a href="{{ Route('kyc') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="far fa-id-card"></i> </span>
                        KYC Portal
                    </p>
                </a>
                @endcan
                <a href="{{ Route('referrals') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-user-plus"></i> </span>
                        Refer user
                    </p>
                </a>
                {{-- <a href="{{ Route('notifications') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-bell"></i> </span>
                        Notification
                    </p>
                </a> --}}
                @can('adminOnly')
                <a href="{{ Route('deposit-methods') }}" class="text-decoration-none">
                    <p class="acct_menu_link">
                        <span class="acct_menu_icon mr-3"> <i class="fas fa-donate"></i> </span>
                        Deposit Methods
                    </p>
                </a>
                @endcan
                <div class="drop_menu_link_con mb-2">
                    <a href="#" class="text-decoration-none">
                        <p class="acct_menu_link d-flex">
                            <span class="acct_menu_icon mr-3"> <i class="fas fa-cog"></i> </span>
                            Settings
                            <span class="acct_menu_icon ml-auto"> <i class="fas fa-angle-down"></i> </span>
                        </p>
                    </a>
                    <div class="drop_menu_link_cont">
                        <a href="{{ Route('profile') }}" class="text-decoration-none">
                            <p class="drop_menu_link">Profile Settings</p>
                        </a>
                        {{-- <a href="{{ Route('2fa') }}" class="text-decoration-none">
                            <p class="drop_menu_link">2FA</p>
                        </a> --}}
                        @can('adminOnly')

                        <a href="{{ Route('settings') }}" class="text-decoration-none">
                            <p class="drop_menu_link">General Settings</p>
                        </a>
                        @endcan
                    </div>
                </div>
                {{-- Translator --}}
                <div class="gtranslate_wrapper bg-white ml-4 mb-5"></div>
                <script>
                    window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","flag_size":16}
                </script>
                <script src="https://cdn.gtranslate.net/widgets/latest/popup.js" defer></script>
            </div>

            <div class="acct_menu_bottom_con position-fixed ">
                <p class="acct_menu_bottom_text">&copy; {{ now()->year }}. <br> All Right Resevered.</p>
            </div>

        </div>


        {{-- Page Content --}}
        @yield('content')
    </div>

    <!--Javescripts-->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/account.js') }}"></script>

    <!-- Toastify JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @livewireScripts

    {{-- Tigger Toastify Js --}}
    <script>
        document.addEventListener('showToast', (event) => {
                Toastify({
                text: event.detail[0].message,
                className: 'tos_head',
                duration: 3000,
                close: true,
                style: {
                    background: event.detail[0].status ? "#0cc70c" : "#df0534",
                }

                }).showToast();
            })
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/66bcc125146b7af4a43a5f51/1i58l4va6';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>