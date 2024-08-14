@extends('layouts.layout')

@section('title')
Dashboard
@endsection

@section('content')
<div class="col acct_cont_con px-0">

    <x-top-header title="Dashboard">
    </x-top-header>

    <div class="col py-4 px-0 px-md-3">

        <div class="col d-md-flex justify-content-between align-items-center mb-1">
            <div class="mb-3 mb-md-0">
                <p class="acct_head">Welcome!</p>
                <p class="acct_name">{{ auth()->user()->fullname }}!</p>
                {{-- <p class="acct_text">This is an overview of your account.</p> --}}
            </div>
            <div class="d-flex">

                {{-- <a href="{{ route('deposit') }}" class="text-decoration-none mr-3">
                    <button type="button" class="acct_btn2 ">DEPOSIT <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </a> --}}
                {{-- @can('adminOnly')
                <a href="{{ route('withdrawal') }}" class="text-decoration-none">
                    <button type="button" class="acct_btn ">WITHDRAWAL <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </a>
                @endcan --}}
                {{-- @can('userOnly')
                <a href="{{ route('invest') }}" class="text-decoration-none">
                    <button type="button" class="acct_btn ">INVEST <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </a>
                @endcan --}}
            </div>
        </div>

        <div class="row mx-0 mb-3">
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light mr-3"> <i class="fas fa-donate"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Total Deposit</p>
                        <p class="acct_dash_num">${{ number_format($total_deposit) }}</p>
                    </div>
                </div>
            </div>

            @canany(['userOnly', 'teamOnly'])
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light1 mr-3"> <i class="fas fa-wallet"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Avaliable Balance</p>
                        <p class="acct_dash_num">${{ number_format($total_balance ?? 0) }}</p>
                    </div>
                </div>
            </div>
            @endcanany
            @can('userOnly')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light mr-3"> <i class="fas fa-box-open"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Active Investment</p>
                        <p class="acct_dash_num">{{ number_format($active_package) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light2 mr-3"> <i class="fas fa-dollar-sign"></i></span>
                    <div class="">
                        <p class="acct_dash_text">Total Profit</p>
                        <p class="acct_dash_num">${{ number_format($total_profit) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light3 mr-3"> <i class="fas fa-user-friends"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Ref. Bonus</p>
                        <p class="acct_dash_num">${{ number_format($referral_bonus) }}</p>
                    </div>
                </div>
            </div>
            @endcan
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light1 mr-3"> <i class="fas fa-upload"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Total Withdrawal</p>
                        <p class="acct_dash_num">${{ number_format($total_withdrawal) }}</p>
                    </div>
                </div>
            </div>

            @can('adminOnly')
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon light mr-3"> <i class="fas fa-boxes"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Total Packages</p>
                        <p class="acct_dash_num">{{ number_format($total_package) }}</p>
                    </div>
                </div>
            </div>
            @endcan

            @canany(['adminOnly', 'teamOnly'])
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 ">
                <div class="col acct_cont d-flex flex-wrap align-items-center p-4">
                    <span class="acct_dash_icon mr-3"> <i class="fas fa-users"></i> </span>
                    <div class="">
                        <p class="acct_dash_text">Total Users</p>
                        <p class="acct_dash_num">{{ number_format($total_users) }}</p>
                    </div>
                </div>
            </div>
            @endcanany


        </div>

        @can('userOnly')
        {{-- <div class="col d-lg-flex justify-content-between align-items-center mb-5">
            <div class="col col-lg-7 col-xl mr-lg-5 px-0">
                <p class="acct_dash_head">Active Investments</p>
                <div class="col d-flex overflow-auto px-0">
                    <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-4 dash_pro_cont_con shadow-sm px-0 mr-4 mb-3">
                        <div class="dash_pro_cont1">
                            <div class="mb-2">
                                <p class="dash_pro_text">Upcoming Equit Round</p>
                                <p class="dash_pro_text2">$2,500,000</p>
                            </div>
                            <div class="">
                                <p class="dash_pro_text">Investment Start Date</p>
                                <p class="dash_pro_date">18/09/2017</p>
                            </div>
                        </div>
                        <div class="dash_pro_cont2">
                            <div class="">
                                <p class="dash_pro_head">INVESTMENT PROGRESS <span
                                        class="dash_pro_cent float-right">21%</span> </p>
                                <div class="progress dash_pro_col_con">
                                    <div class="progress-bar dash_pro_col" role="progressbar" style="width: 25%;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="dash_pro_num">$524,000</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-4 dash_pro_cont_con shadow-sm px-0 mr-4 mb-3">
                        <div class="dash_pro_cont1">
                            <div class="mb-2">
                                <p class="dash_pro_text">Upcoming Equit Round</p>
                                <p class="dash_pro_text2">$2,500,000</p>
                            </div>
                            <div class="">
                                <p class="dash_pro_text">Investment Start Date</p>
                                <p class="dash_pro_date">18/09/2017</p>
                            </div>
                        </div>
                        <div class="dash_pro_cont2">
                            <div class="">
                                <p class="dash_pro_head">INVESTMENT PROGRESS <span
                                        class="dash_pro_cent float-right">21%</span> </p>
                                <div class="progress dash_pro_col_con">
                                    <div class="progress-bar dash_pro_col" role="progressbar" style="width: 25%;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="dash_pro_num">$524,000</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-4 dash_pro_cont_con shadow-sm px-0 mr-4 mb-3">
                        <div class="dash_pro_cont1">
                            <div class="mb-2">
                                <p class="dash_pro_text">Upcoming Equit Round</p>
                                <p class="dash_pro_text2">$2,500,000</p>
                            </div>
                            <div class="">
                                <p class="dash_pro_text">Investment Start Date</p>
                                <p class="dash_pro_date">18/09/2017</p>
                            </div>
                        </div>
                        <div class="dash_pro_cont2">
                            <div class="">
                                <p class="dash_pro_head">INVESTMENT PROGRESS <span
                                        class="dash_pro_cent float-right">21%</span> </p>
                                <div class="progress dash_pro_col_con">
                                    <div class="progress-bar dash_pro_col" role="progressbar" style="width: 25%;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="dash_pro_num">$524,000</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5 col-lg-6 col-xl-4 dash_pro_cont_con shadow-sm px-0 mr-4 mb-3">
                        <div class="dash_pro_cont1">
                            <div class="mb-2">
                                <p class="dash_pro_text">Upcoming Equit Round</p>
                                <p class="dash_pro_text2">$2,500,000</p>
                            </div>
                            <div class="">
                                <p class="dash_pro_text">Investment Start Date</p>
                                <p class="dash_pro_date">18/09/2017</p>
                            </div>
                        </div>
                        <div class="dash_pro_cont2">
                            <div class="">
                                <p class="dash_pro_head">INVESTMENT PROGRESS <span
                                        class="dash_pro_cent float-right">21%</span> </p>
                                <div class="progress dash_pro_col_con">
                                    <div class="progress-bar dash_pro_col" role="progressbar" style="width: 25%;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="dash_pro_num">$524,000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-lg col-xl-4 dash_ref_con overflow-hidden p-3 p-sm-4 mt-4">
                <p class="dash_ref_header">Refer & Earn</p>
                <p class="dash_ref_head">Referral Link: <span id="referral_link" class="dash_ref_text">{{
                        route('register') }}?referral={{auth()->user()->referral_code}}</span> </p>
                <form action="#" method="post">
                    <input type="email" name="friend_email" class="dash_ref_box mb-3" placeholder="Enter Email Address">
                    <div class="d-sm-flex">
                        <button type="submit" class="col dash_ref_btn mb-2 mb-sm-0 mr-sm-4">Invite
                            Friends</button>
                        <button id="referral_btn" type="button" class="col dash_ref_btn2">Copy Link</button>
                    </div>
                </form>
            </div>
        </div> --}}
        @endcan

        <div class="col d-lg-flex align-items-start mb-5">
            {{-- <div class="col col-lg-7 col-xl dash_chart_cont shadow-sm mr-lg-5 mb-5 mb-lg-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="dash_pay_header">Today's Payouts</p>
                    <a href="#" class="text-decoration-none"> <span class="dash_pay_hint">View all</span> </a>
                </div>
                <div class="table-responsive">
                    <table class="dash_pay_table ">
                        <thead>
                            <tr>
                                <th class="dash_pay_head" scope="col">TRANSACTION CODE</th>
                                <th class="dash_pay_head" scope="col">Type</th>
                                <th class="dash_pay_head" scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_transactions as $item)
                            <tr>
                                <td class="dash_pay_text text-uppercase">{{$item->trx_num}}</td>
                                <td class="dash_pay_text">{{basename($item->transactionable_type)}}</td>
                                <td class="dash_pay_text">${{number_format($item->amount)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
            {{-- Refer Link Box --}}
            <div class="col col-xl-10 mx-auto px-0">
                <x-refer-earn-box></x-refer-earn-box>
            </div>
        </div>

        <div class="row mx-0">

            <div class="col-12 mb-5">
                <p class="acct_dash_head">Crypto Trading Data</p>
                <style>
                    .tradingview-widget-copyright {
                        font-size: 13px !important;
                        line-height: 32px !important;
                        text-align: center !important;
                        vertical-align: middle !important;
                        font-family: 'Trebuchet MS', Tahoma, Arial, sans-serif !important;
                        color: #9db2bd !important;
                    }

                    .tradingview-widget-copyright .blue-text {
                        color: #3bb3e4 !important;
                    }

                    .tradingview-widget-copyright a {
                        text-decoration: none !important;
                        color: #9db2bd !important;
                    }

                    .tradingview-widget-copyright a:visited {
                        color: #9db2bd !important;
                    }

                    .tradingview-widget-copyright a:hover .blue-text {
                        color: #38acdb !important;
                    }

                    .tradingview-widget-copyright a:active .blue-text {
                        color: #299dcd !important;
                    }

                    .tradingview-widget-copyright a:visited .blue-text {
                        color: #3bb3e4 !important;
                    }
                </style>
                <iframe allowtransparency="true" style="box-sizing: border-box; height: calc(500px); width: 100%;"
                    src="https://s.tradingview.com/cryptomktscreenerwidget/#%7B%22width%22%3A%22100%25%22%2C%22height%22%3A%22400%22%2C%22defaultColumn%22%3A%22overview%22%2C%22screener_type%22%3A%22crypto_mkt%22%2C%22displayCurrency%22%3A%22USD%22%2C%22locale%22%3A%22en%22%2C%22market%22%3A%22crypto%22%2C%22enableScrolling%22%3Atrue%2C%22utm_source%22%3A%22btchomemining.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22cryptomktscreener%22%7D"
                    frameborder="0"></iframe>
                <!-- <div style="height: 32px; line-height: 32px; width: 100%; text-align: center; vertical-align: middle;">
                <a ref="nofollow noopener" target="_blank" href="assets/http://www.tradingview.com" style="color: rgb(173, 174, 176); font-family: Tahoma, Arial, sans-serif; font-size: 13px;">Cryptocurrency
                    Market by <span style="color: #3BB3E4">TradingView</span></a>
                </div> -->
            </div>

            <div class="col-12 mb-4">
                <p class="acct_dash_head">Forex Market Data</p>
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <!-- <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/currencies/forex-cross-rates/" rel="noopener" target="_blank"><span class="blue-text">Exchange Rates</span></a> by TradingView</div> -->
                    <script type="text/javascript"
                        src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js" async>
                        {
                            "width": "100%",
                            "height": "500",
                            "currencies": [
                                "EUR",
                                "USD",
                                "JPY",
                                "GBP",
                                "CHF",
                                "AUD",
                                "CAD",
                                "NZD",
                                "CNY"
                            ],
                            "isTransparent": false,
                            "colorTheme": "light",
                            "locale": "en"
                        }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

        </div>

    </div>

</div>
@endsection