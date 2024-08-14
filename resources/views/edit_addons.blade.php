<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VestPro | Plugins</title>

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
            <div class="col acct_header_con d-flex justify-content-between align-items-center sticky-top px-4">
                <div class="">
                    <span class="acct_menu_bar d-none"> <i class="fas fa-bars"></i> </span>
                    <p class="acct_header">Plugin</p>
                </div>
                <div class=" d-flex align-items-center">
                    <span class="acct_header_icon position-relative "> <span class="acct_header_dot"></span> <i class="fas fa-bell"></i> </span>
                    <span class="acct_header_line mx-3"></span>
                    <span class="acct_header_icon position-relative " data-toggle="modal" data-target="#gobal_kyc"> <i class="fas fa-certificate"></i> <span class="acct_header_text">KYC</span> </span>
                    <span class="acct_header_line mx-3"></span>
                    <div class="dropdown ">
                        <img src="images/custom.jpg" alt="" class="acct_header_img" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="dropdownMenuButton">
                            <a href="#" class="text-decoration-none">
                                <p class="acct_header_link">Personal Settings</p>
                            </a>
                            <a href="#" class="text-decoration-none">
                                <p class="acct_header_link">Account Settings</p>
                            </a>
                            <a href="#" class="text-decoration-none">
                                <p class="acct_header_link">Logout</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col py-4">

                <div class="col d-flex justify-content-between align-items-center mb-4">
                    <p class="acct_cont_header">Update Plugin</p>
                    <a href="addons.php" class="text-decoration-none"> <button type="button" class="acct_btn2"> <i class="fas fa-arrow-left mr-2"></i> Back</button> </a>
                </div>

                <div class="col">
                    <div class="col acct_newdep_cont shadow-sm ">
                        <div class="col d-flex px-0">
                            <div class="col-6 px-0">
                            <div class="mb-3">
                            <label class="acct_label">Plugin Name</label>
                            <input type="text" name="ammount" class="acct_box" min="1" placeholder="Enter plugin name">
                        </div>
                        <div class="mb-3">
                            <label class="acct_label">Public Key</label>
                            <input type="text" name="ammount" class="acct_box" min="1" placeholder="Enter public key">
                        </div>
                        <div class="mb-3">
                            <label class="acct_label">Secret Key</label>
                            <input type="text" name="ammount" class="acct_box" min="1" placeholder="Enter secret key">
                        </div>
                        <div class="mb-3">
                                <label class="acct_label">Logo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03">
                                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                                </div>
                            </div>
                        <div class="mb-3">
                            <label class="acct_label">Status</label>
                            <div class="">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="ref1" name="ref" class="custom-control-input">
                                    <label class="custom-control-label acct_label" for="ref1">Active</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="ref2" name="ref" class="custom-control-input" checked>
                                    <label class="custom-control-label acct_label" for="ref2">Inactive</label>
                                </div>
                            </div>
                        </div>

                            </div>
                            
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="acct_btn2 mr-3">Save</button>
                            <button type="submit" class="acct_btn3">Delete</button>
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