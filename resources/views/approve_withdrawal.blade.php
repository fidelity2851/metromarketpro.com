<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VestPro | Withdrawal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600&family=Poppins:wght@100;200;300;400;500;800&display=swap" rel="stylesheet">

    <!--stylesheet-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/account.css">
    <link rel="stylesheet" href="css/metro-icons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="font/flaticon.css">

</head>

<body>

    <div class="housing d-flex ">


        <div class="col acct_cont_con px-0">
            <div class="col acct_header_con d-flex justify-content-between align-items-center sticky-top px-3 px-sm-4">
                <div class="d-flex align-items-center">
                    <span id="open_menu" class="acct_menu_bar d-xl-none mr-2 mr-sm-4"> <i class="fas fa-bars"></i> </span>
                    <p class="acct_header">WITHDRAWAL</p>
                </div>
                <div class=" d-flex align-items-center">
                    <a href="notification.php" class="text-decoration-none">
                        <span class="acct_header_icon position-relative "> <span class="acct_header_dot"></span> <i class="fas fa-bell"></i> </span>
                    </a>
                    <span class="acct_header_line mx-1 mx-sm-3"></span>
                    <span class="acct_header_icon position-relative " data-toggle="modal" data-target="#gobal_kyc"> <i class="fas fa-certificate"></i> <span class="acct_header_text">KYC</span> </span>
                    <span class="acct_header_line mx-1 mx-sm-3"></span>
                    <div class="dropdown ">
                        <img src="images/custom.jpg" alt="" class="acct_header_img" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="dropdownMenuButton">
                            <a href="profile_setting.php" class="text-decoration-none">
                                <p class="acct_header_link">Personal Settings</p>
                            </a>
                            <a href="payment_method.php" class="text-decoration-none">
                                <p class="acct_header_link">Account Settings</p>
                            </a>
                            <a href="#" class="text-decoration-none">
                                <p class="acct_header_link">Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col py-4 px-0 px-md-3">

                <div class="col d-sm-flex justify-content-between align-items-center mb-4">
                    <p class="acct_cont_header mb-3 mb-sm-0">Edit Withdrawal</p>
                    <a href="withdrawal.php" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i class="fas fa-arrow-left mr-2"></i> Back</button> </a>
                </div>

                <div class="col">
                    <div class="col acct_newdep_cont shadow-sm ">
                        <div class="col d-lg-flex px-0">
                            <div class="col px-0 mr-5">
                                <div class="mb-3">
                                    <label for="" class="acct_label">Client Email</label>
                                    <input type="email" name="client_email" class="acct_box" placeholder="Valid Email Address">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="acct_label">Enter Amount (USD)</label>
                                    <input type="number" name="amount" value="500.00" class="acct_box" placeholder="Enter Amount">
                                    <p class="acct_modal_label text-right">Available Balance = <span>$500,000.00</span> </p>

                                </div>
                                <div class="mb-3">
                                    <label for="" class="acct_label">Withdrawal Date</label>
                                    <input type="datetime-local" type="date" name="date" class="acct_box" placeholder="Enter Amount">
                                </div>

                            </div>
                            <div class="col px-0">
                                <div class="mb-3">
                                    <label class="acct_label">Payment Method</label>
                                    <select class="acct_sel">
                                        <option value="">Select Payment Method</option>
                                        <option value="" selected>Bitcoin</option>
                                        <option value="">Litecoin</option>
                                        <option value="">Paystack</option>
                                        <option value="">Dogecoin</option>
                                        <option value="">Wire Transfer</option>
                                        <option value="">Stripe</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label acct_label" for="customSwitch1">APPROVE WITHDRAWAL</label>
                                </div>

                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="acct_btn2">APPROVE</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!--Javescripts-->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/metro.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/lightboxed.js"></script>
        <script src="js/index.js"></script>
        <script src="js/account.js"></script>
</body>

</html>