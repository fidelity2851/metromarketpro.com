<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VestPro | Clients</title>

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
                    <p class="acct_header">CLIENTS</p>
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

                <div class="col d-xl-flex justify-content-between align-items-start mb-5">
                    <div class="d-sm-flex align-items-center mb-4 mb-xl-0">
                        <img src="images/custom.jpg" alt="" class="acct_user_img">
                        <div class="acct_user_details ml-sm-4">
                            <p class="acct_user_name">John Doe</p>
                            <p class="acct_user_email">username@email.com</p>
                            <p class="acct_menu_hint d-flex align-items-center"> <img src="images/verified.png" alt="" class="mr-1"> Verified</span>
                            <div class="mt-3">
                                <a href="edit_client.php" class="text-decoration-none mr-2">
                                    <button type="button" class="acct_user_btn">Edit</button>
                                </a>
                                <button type="button" class="acct_user_btn2" data-toggle="modal" data-target="#gobal_kyc">KYC</button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-xl-7 d-md-flex justify-content-between px-0">
                        <div class="col acct_dep_cont d-flex align-items-center shadow-sm mr-md-5 mb-4 mb-md-0">
                            <span class="acct_dep_hint">Active Balance</span>
                            <span class="acct_dep_icon mr-4"> <i class="fas fa-wallet "></i> </span>
                            <div class="">
                                <p class="acct_dep_header">$540,000,000</p>
                                <p class="acct_dep_text">Avaliable Balance</p>
                            </div>
                        </div>
                        <div class="col acct_dep_cont d-flex align-items-center shadow-sm">
                            <span class="acct_dep_hint2">Inactive Deposits</span>
                            <span class="acct_dep_icon"> <i class="fas fa-donate mr-4"></i> </span>
                            <div class="">
                                <p class="acct_dep_header">$540,000,000</p>
                                <p class="acct_dep_text">Pending Deposits</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="col acct_newdep_cont shadow-sm ">
                        <div class="d-md-flex justify-content-between align-items-start mb-4">
                            <p class="acct_user_header mb-3 mb-md-0">Login History</p>

                        </div>
                        <div class=" table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th class="table_head" scope="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck"></label>
                                            </div>
                                        </th>
                                        <th class="table_head" scope="col">#</th>
                                        <th class="table_head" scope="col">Browser Name</th>
                                        <th class="table_head" scope="col">IP Address</th>
                                        <th class="table_head" scope="col">Status</th>
                                        <th class="table_head" scope="col">Login On</th>
                                        <th class="table_head" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="table_data" scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck"></label>
                                            </div>
                                        </th>
                                        <th class="table_data" scope="row"> 1 </th>
                                        <td class="table_data">John Doe</td>
                                        <td class="table_data">Admin@email.com</td>
                                        <td class="table_data">
                                            <span class="table_status2">Offline</span>
                                        </td>
                                        <td class="table_data">12 Aug 2020, 11:42am</td>
                                        <td class="table_data">
                                            <a href="#" class="text-decoration-none mr-2"> <button class="table_btn2">Logout</button> </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-end mt-3">
                            <div class="mb-2 mb-md-0 mx-auto mx-md-0">
                                <button type="button" class="table_btn4 mr-2">Delete</button>
                                <button type="button" class="table_btn5 mr-2">Resolved</button>
                                <button type="button" class="table_btn3 mr-2">Pending</button>
                            </div>
                            <div class="d-flex align-items-center mx-auto mx-md-0">
                                <p class="pagi_num">
                                    << </p>
                                        <p class="pagi_num_active">1</p>
                                        <p class="pagi_num">2</p>
                                        <p class="pagi_num">3</p>
                                        <p class="pagi_num"> >> </p>
                            </div>
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