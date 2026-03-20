<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= PRODUCT_NAME ?> | <?= $title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->

    <style>
        .loader {
            position: fixed;
            width: 100%;
            height: 100%;
            padding-top: 18%;
            z-index: 9999;
            display: block;
            background-color: white;
            opacity: 5;
            text-align: center;
            vertical-align: middle;
        }

        .loader img {
            width: 120px;
        }
    </style>
    <script>
        var BASE_URL = "<?= BASE_URL ?>";
        var CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name() ?>";
        var CSRF_TOKEN_VALUE = "<?= $this->security->get_csrf_hash() ?>";
    </script>
    <script>
        <?php
        @$ci =& get_instance();
        @$ci->load->model('ticket/Ticket_model');
        $cats = @$ci->Ticket_model->getAllCategories();
        if (!$cats) $cats = array();
        ?>
        var CATEGORY_MAP = <?= json_encode($cats) ?>;
    </script>

    <!-- Bootstrap 4 CSS (local) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome (local) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.default.css" id="theme-stylesheet">
    <!-- Select2 CSS (load before custom.css so overrides apply) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/custom.css?v=<?= time() ?>">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/img/favicon.ico">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/toastr/toastr.min.css">
    <!-- DataTables (BS4) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- Quill Editor -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

    <!-- jQuery -->
    <script src="<?= BASE_URL ?>assets/vendor/jquery/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="<?= BASE_URL ?>assets/vendor/popper.js/umd/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="<?= BASE_URL ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables (BS4) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- DataTables Buttons & Exports -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Quill Editor -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- Toastr -->
    <script src="<?= BASE_URL ?>assets/vendor/toastr/toastr.min.js"></script>
    <!-- Chart.js -->
    <script src="<?= BASE_URL ?>assets/vendor/chart.js/Chart.min.js"></script>
    <!-- Handlebars and Alpaca for Datatable Filters -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.7/handlebars.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/vendor/alpacajs/alpaca.min.css">
    <script src="<?= BASE_URL ?>assets/vendor/alpacajs/alpaca.min.js"></script>
    <!-- Tabler (custom) -->
    <script src="<?= BASE_URL ?>assets/js/tabler.js"></script>



    <script type="text/javascript">
        $(document).ready(function () {
            $('.side-navbar ul li a').each(function () {
                var url = window.location.href;
                var $this = $(this);
                if ($this.attr('href').trim() === url) {
                    var current = $this.parent();
                    var current_parent = $this.parent().parent().siblings('a').parent();
                    current.addClass('nav-active');
                    current_parent.addClass('nav-active');
                }
            })
        });

        $(function () {
            $(".loader").fadeOut("fast");
        });

        setTimeout(function () {
            $('.event-notification').fadeOut('fast');
        }, 5000); // <-- time in milliseconds
    </script>

</head>

<body>
    <div class="loader"></div>

    <div class="page">
        <!-- Main Navbar-->
        <header class="header">
            <nav class="navbar">
                <!-- Search Box-->
                <div class="search-box">
                    <button class="dismiss"><i class="icon-close"></i></button>
                    <form id="searchForm" action="#" role="search">
                        <input type="search" placeholder="What are you looking for..." class="form-control">
                    </form>
                </div>

                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <!-- Navbar Header-->
                        <div class="navbar-header">
                            <!-- Navbar Brand --><a href="<?= BASE_URL ?>user/dashboard"
                                class="navbar-brand d-none d-sm-inline-block">
                                <div class="brand-text d-none d-lg-inline-block"><?= PRODUCT_NAME ?></div>
                                <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>TIKAJ</strong></div>
                            </a>
                            <!-- Toggle Button--><a id="toggle-btn" href="#"
                                class="menu-btn active"><span></span><span></span><span></span></a>
                        </div>
                        <!-- Navbar Menu -->
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                            <li class="dotted-add-button"><a href="<?= BASE_URL ?>tickets/create_new"><i
                                        class="fa fa-plus-square"></i> New ticket</a></li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle sidebar-header d-flex align-items-center" href="#"
                                    id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="current-user-avatar"
                                        data-username="<?= $this->Session->getLoggedDetails()['username'] ?>"></div>
                                    <div class="title pl-2">
                                        <?= $this->Session->getLoggedDetails()['username'] ?>
                                    </div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?= BASE_URL ?>user/profile"><i
                                            class="fa fa-user bg-info"></i> Profile</a>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>user/change_password""><i
                                        class=" fa fa-lock bg-orange"></i> Change password</a>
                                    <div class="dropdown-divider"></div>
                                    <!-- Logout -->
                                    <a class="dropdown-item" href="<?= BASE_URL ?>auth/logout"><i
                                            class="fa fa-sign-out bg-red"></i>Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </nav>
        </header>
        <div class="page-content d-flex align-items-stretch">
            <!-- Side Navbar -->
            <nav class="side-navbar">
                <!-- Sidebar Navidation Menus-->
                <ul class="list-unstyled">
                    <!-- TODO: Change below session data fetching !-->
                    <?php
                    include_once "menus/" . $this->session->userdata('sessions_details')['type'] . ".php"; ?>
                </ul>

            </nav>
            <div class="content-inner">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom"><?= $title ?></h2>
                    </div>
                </header>