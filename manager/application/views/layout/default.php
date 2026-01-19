<?php echo doctype('html5'); ?>
<html  lang="en">
<head>
<?php echo meta($meta); ?>
    
<!DOCTYPE html> 
<html  lang="en">
<head>

    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
    </style>


    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> Claim Charts </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->baseUrl; ?>/public/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->baseUrl; ?>/public/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->baseUrl; ?>/public/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->baseUrl; ?>/public/images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?php echo $Layout->baseUrl; ?>/public/images/icons/favicon.png">



    <!-- HELPERS -->


<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/helpers/utils.css">



<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/elements/buttons.css">


<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/widgets/datatable/datatable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/widgets/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/widgets/datepicker-ui/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/widgets/slidebars/slidebars.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/themes/admin/color-schemes/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/themes/components/default.css">


<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>/public/helpers/admin-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-core/jquery-ui-position.js"></script>

    <script type="text/javascript">
        $(window).load(function(){
            setTimeout(function() {
                $('#loading').fadeOut( 400, "linear" );
            }, 300);
        });
    </script>



</head>


    <body>
    <div id="sb-site">
    

    <div id="loading">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <div id="page-wrapper">
       
        
		<div id="page-sidebar">
    <div class="scroll-sidebar">
        

    <ul id="sidebar-menu">
    <li class="header"><span>Dashboard</span></li>
	<li>
        <a href="#" title="Orders">
            <i class="glyph-icon icon-linecons-diamond"></i>
            <span>Agreements</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/term_of_use" title="Buttons"><span>Term Of Use </span></a></li>
                <li><a href="<?php echo site_url(); ?>api/privacy_policy" title="Buttons"><span>Privacy Policy </span></a></li>
                <li><a href="<?php echo site_url(); ?>api/sme_agreement" title="Buttons"><span>SME Agreement </span></a></li>
                <li><a href="<?php echo site_url(); ?>api/nda" title="Buttons"><span>NDA </span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
    <li>
        <a href="#" title="Orders">
            <i class="glyph-icon icon-linecons-diamond"></i>
            <span>Orders</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/order_list" title="Buttons"><span>Orders List </span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
    <!--<li>
        <a href="#" title="Projects">
            <i class="glyph-icon icon-linecons-lightbulb"></i>
            <span>Projects</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/project_list" title="Chart boxes"><span>Projects List</span></a></li>
            </ul>

        </div>
    </li>-->
    <li>
        <a href="#" title="Forms UI">
            <i class="glyph-icon icon-linecons-eye"></i>
            <span>Reports</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/report_list" title="Reports"><span>Reports</span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
	<li>
        <a href="#" title="Forms UI">
            <i class="glyph-icon icon-linecons-eye"></i>
            <span>Transactions</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/transaction_list" title="Transactions"><span>Transactions</span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
    <li>
        <a href="#" title="Experts">
            <i class="glyph-icon icon-linecons-wallet"></i>
            <span>Experts</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/expert_list" title="Experts"><span>Experts List </span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
	<li>
        <a href="#" title="Experts">
            <i class="glyph-icon icon-linecons-mail"></i>
            <span>Mass Payments</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/mass_payments" title="Experts"><span>Pay to Experts</span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
	<li>
        <a href="#" title="Experts">
            <i class="glyph-icon icon-linecons-wallet"></i>
            <span>Discount</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/discount_list" title="Experts"><span>Discount List </span></a></li>
                <li><a href="<?php echo site_url(); ?>api/add_discount" title="Experts"><span>Add Discount</span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
    <li>
        <a href="#" title="Paypal Settings">
            <i class="glyph-icon icon-linecons-megaphone"></i>
            <span>Paypal Settings</span>
        </a>
        <div class="sidebar-submenu">

            <ul>
                <li><a href="<?php echo site_url(); ?>api/paypal_setting" title="Paypal Settings"><span>Paypal Settings</span></a></li>
            </ul>

        </div><!-- .sidebar-submenu -->
    </li>
    </ul><!-- #sidebar-menu -->


    </div>
</div>
        
		<div id="page-content-wrapper">
            <div id="page-content">
                
<?php echo $contents_for_layout; ?>
                    

            </div>
        </div>
    </div>

<!-- Superclick -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/widgets/superclick/superclick.js"></script>

<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>/public/js-init/widgets-init.js"></script>

<script>
 /* Sidebar menu */
    $(function() {

        $('#sidebar-menu').superclick({
            animation: {
                height: 'show'
            },
            animationOut: {
                height: 'hide'
            }
        });

    });
</script>
<style>

.ui-datepicker table{margin:0px;}
.ui-datepicker{border:1px solid #efefef;background:white;z-index:555 !important}
.table{background:white !important;}
</style>

</div>
</body>
</html>