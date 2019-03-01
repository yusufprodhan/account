<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $title; ?></title>

        <!-- Bootstrap -->
        <link href="<?= site_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?= site_url(); ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?= site_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?= site_url(); ?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- bootstrap-wysiwyg -->
        <link href="<?= site_url(); ?>assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
        <!-- select 2 css -->
        <link href="<?= site_url(); ?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- NProgress -->
        <link href="<?= site_url(); ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="<?= site_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<!--        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->

        <!-- Datatables -->
        <link href="<?= site_url(); ?>assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?= site_url(); ?>assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?= site_url(); ?>assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?= site_url(); ?>assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?= site_url(); ?>assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

        <!-- bootstrap-datetimepicker -->
        <link href="<?= site_url(); ?>assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <!-- bootstrap-daterangepicker -->
        <link href="<?= site_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- Custom styling plugins -->
        <link href="<?= site_url(); ?>assets/build/css/custom.css" rel="stylesheet">
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="<?php echo site_url() ?>admin" class="site_title"> <span><?php if(!empty($company_info)){echo $company_info[0]['company_name'];}?></span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img src="" alt="..." class="img-circle profile_img" width="65px">
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2><?php if(!empty($username)){echo $username;}?></h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">                                
                                <ul class="nav side-menu">
                                    <li><a href="<?= site_url() . $_SESSION['username']; ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                                    <?php if ($_SESSION['user_type'] == 'admin'): ?>                                        
                                        <li>
                                            <a><i class="fa fa-address-book"></i>Company Setup<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                                                                
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/updateCompanyInfo">Update Company info</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a><i class="fa fa-sitemap"></i> Group <span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/createGroup">Create Group</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/groupListOfAccount">Group List</a></li>                                                                             
                                            </ul>
                                        </li>
                                        <li>
                                            <a><i class="fa fa-calculator"></i> Account<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/createLedger">Create Account</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/groupListOfAccount">Account List</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/updateLedger">Update Ledger</a></li>
                                            </ul>
                                        </li>
<!--                                        <li>
                                            <a><i class="fa fa-truck"></i>Truck Entry<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                
                                                <li><a href="<?//= site_url() . $_SESSION['user_type']; ?>/memberTruckEntry">Member Truck Entry</a></li>
                                                <li><a href="<?//= site_url() . $_SESSION['user_type']; ?>/nonMemberTruckEntry">Non Member Truck Entry</a></li>
                                            </ul>
                                        </li>-->
                                        <li>
                                            <a><i class="fa fa-dollar"></i>Voucher Entry<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/paymentVoucher">Payment Voucher</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/receiveVoucher">Receive Voucher</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/journalVoucher">Journal Voucher</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/contraVoucher">Contra Voucher</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/memberTruckVoucher">Member Truck Voucher</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/nonMemberTruckVoucher">Non Member Voucher</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a><i class="fa fa-pie-chart"></i>Reports<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">
                                                <li>
                                                    <a>Transaction Reports<span class="fa fa-chevron-down"></span></a>
                                                    <ul class="nav child_menu">
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/paymentVoucherReport">Payment Voucher Report</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/receiveVoucherReport">Receive Voucher Report</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/journalVoucherReport">Journal Voucher Report</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/cashStatement">Cash Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/bankStatement">Bank Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/cashAndBankStatement">Cash & Bank Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/chequeStatement">Cheque Statement</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a>Account Reports<span class="fa fa-chevron-down"></span></a>
                                                    <ul class="nav child_menu">
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/ledgerWiseAccountStatement">Ledger Wise Account Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/journalStatement">Journal Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/groupWiseLedgerStatement">Group Wise Ledger Statement</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a>Financial State. Report<span class="fa fa-chevron-down"></span></a>
                                                    <ul class="nav child_menu">
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/atAGlanceStatement">At a Glance Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/incomeStatement">Income Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/expensesStatement">Expenses Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/accountPayableStatement">Account Payable Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/accountReceivableStatement">Account Receivable Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/profitAndLossAccount">Profit & Loss Account</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/trialBalanceStatement">Trial Balance Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/balanceSheet">Balance Sheet</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a>Truck Report<span class="fa fa-chevron-down"></span></a>
                                                    <ul class="nav child_menu">
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/truckMemberReport">Truck Member Report</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/truckStatementMemberwise">Truck Statement Memberwise</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/truckStatementDetails">Truck Statement Details</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/truckIncomeStatement">Truck Income Statement</a></li>
                                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/truckStatementNonMemberwise">Truck Statement Non Memberwise</a></li>
                                                    </ul>
                                                </li>
                                            </ul>

                                        </li>
                                        <li>
                                            <a><i class="fa fa-wrench"></i>Configure<span class="fa fa-chevron-down"></span></a>
                                            <ul class="nav child_menu">                                                
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/member">Member</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/addTruck">Truck</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/createPayMode">Pay Mode</a></li>
                                                <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/chequeRegister">Cheque Register</a></li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>                                    
                                    <li><a href="<?= site_url(); ?>login"><i class="fa fa-sign-out"></i> Logout</a></li>                                    
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= site_url(); ?>login">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="
                                        <?php
                                        //if ($profile_image == TRUE) {
                                        //echo site_url() . 'assets/uploads/' . $_SESSION['user_id'] . '/' . $profile_image;
                                        // } else {
                                        //   echo site_url() . 'assets/images/user.png';
                                        //}
                                        ?>" alt=""><?= $username; ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="<?= site_url() . $_SESSION['user_type']; ?>/profile"> Profile</a></li>
                                        <li>
                                            <a href="<?= site_url() . $_SESSION['user_type']; ?>/settings">
                                                <span class="badge bg-red pull-right">50%</span>
                                                <span>Settings</span>
                                            </a>
                                        </li>                                        
                                        <li><a href="<?= site_url(); ?>login/"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>

                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green">6</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <?= $contents ?>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Developed by <a href="http://hdyit.com/">hdyit.com</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- compose -->
        <div class="compose col-md-6 col-xs-12">
            <div class="compose-header">
                New Message
                <button type="button" class="close compose-close">
                    <span>×</span>
                </button>
            </div>

            <div class="compose-body">
                <div id="alerts"></div>

                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a data-edit="fontSize 5">
                                    <p style="font-size:17px">Huge</p>
                                </a>
                            </li>
                            <li>
                                <a data-edit="fontSize 3">
                                    <p style="font-size:14px">Normal</p>
                                </a>
                            </li>
                            <li>
                                <a data-edit="fontSize 1">
                                    <p style="font-size:11px">Small</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                        <div class="dropdown-menu input-append">
                            <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                            <button class="btn" type="button">Add</button>
                        </div>
                        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>

                <div id="editor" class="editor-wrapper"></div>
            </div>

            <div class="compose-footer">
                <button id="send" class="btn btn-sm btn-success" type="button">Send</button>
            </div>
        </div>
        <!-- /compose -->

        <!-- Bootstrap -->
        <script src="<?= site_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="<?= site_url(); ?>assets/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?= site_url(); ?>assets/vendors/nprogress/nprogress.js"></script>
        <!-- bootstrap-wysiwyg -->
        <script src="<?= site_url(); ?>assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/google-code-prettify/src/prettify.js"></script>

        <!---Form wizard jquery file -->
        <script src="<?= site_url(); ?>assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

        <!-- FastClick -->
        <script src="<?= site_url(); ?>assets/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?= site_url(); ?>assets/vendors/nprogress/nprogress.js"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="<?= site_url(); ?>assets/vendors/moment/min/moment.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script> 
        
        <!-- bootstrap-datetimepicker -->      
        <script src="<?= site_url(); ?>assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

        <!-- bootstrap-daterangepicker -->
        <script src="<?= site_url(); ?>assets/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- Datatables -->
        <script src="<?= site_url(); ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/jszip/dist/jszip.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?= site_url(); ?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>

        <!-- iCheck -->
        <script src="<?= site_url(); ?>assets/vendors/iCheck/icheck.min.js"></script>
        <!-- Select2 js -->
        <script src="<?= site_url(); ?>assets/vendors/select2/dist/js/select2.js" type="text/javascript"></script>
        <!-- Custom Theme Scripts -->
        <script src="<?= site_url(); ?>assets/build/js/custom.js"></script>
        <script src="<?= site_url(); ?>assets/build/js/custom.noyon.js" type="text/javascript"></script>   

        <script type="text/javascript">
            $(document).ready(function () {

                $('.dateinput').datetimepicker({
                    format: 'DD-MM-YYYY',
                    defaultDate:new Date(),                    
                });

            });
        </script>
    </body>
</html>