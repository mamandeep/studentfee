<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($theme['title']) ? $theme['title'] : 'AdminLTE 2'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap'); ?>
    <!-- Font Awesome -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/font-awesome.min'); ?>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
    <?php echo $this->Html->css('AdminLTE./css/ionicons.min'); ?>
    <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
<!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <?php echo $this->Html->css('AdminLTE./css/skins/skin-blue'); ?>
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap-datepicker3'); ?>
    <?php echo $this->fetch('css'); ?>
    <!-- jQuery 2.1.4 -->
    <?php echo $this->Html->script('AdminLTE./plugins/jQuery/jQuery-2.1.4.min', ['block' => 'scriptTop']); ?>
    <?php echo $this->fetch('scriptTop'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <div id="navBarTop">
                <div id="subDiv1"><?php echo $this->Html->image('AdminLTE./img/cup_logo.png', [
                "alt" => "Central Univeristy of Punjab",
                'url' => 'http://www.cup.edu.in',
                'height'=>'100px',
                'style' => 'padding-left: 50px;'
            ]); ?> </div>
                <div id="subDiv2">
                    <table width="100%">
                        <tr>
                            <td class="navTopHeaderFirst">Central University of Punjab</td>
                        </tr>
                        <tr>
                            <td class="navTopHeaderSecond">Online Fee Submission Portal for Students</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- Logo --><!--
            <div style="display: block;">
            
                <div style="padding-left: 200px; float: right;">
                    <div>123</div>
                    <div>456</div> 
                    <ul style="padding-left: 200px;">
                        <span style="font-size: 48px; font-weight: bold; color: white;">CENTRAL UNIVERSITY OF PUNJAB</span>
                        <li style="font-size: 28px; font-weight: bold; color: white;">Online Counselling Portal for PG Admissions - 2017</li>
                    </ul>-->
                <!--</div>
            </div>-->
            
                <?php /* ?>
            <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><?php echo $theme['logo']['mini'] ?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">CENTRAL UNIVERSITY OF PUNJAB</span>
            </a> <?php */ ?>
            <!-- Header Navbar: style can be found in header.less -->
            <?php echo $this->element('nav-top') ?>
        </header>

        <!-- Left side column. contains the sidebar -->
        <?php echo $this->element('aside-main-sidebar'); ?>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="padding-left: 10px;">

            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Flash->render('auth'); ?>
            <?php echo $this->fetch('content'); ?>

        </div>
        <!-- /.content-wrapper -->

        <?php echo $this->element('footer'); ?>

        <!-- Control Sidebar -->
        <?php echo $this->element('aside-control-sidebar'); ?>

        <!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- Bootstrap 3.3.5 -->
<?php echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap'); ?>
<?php echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap-datepicker.min'); ?>
<!-- SlimScroll -->
<?php echo $this->Html->script('AdminLTE./plugins/slimScroll/jquery.slimscroll.min'); ?>
<!-- FastClick -->
<?php echo $this->Html->script('AdminLTE./plugins/fastclick/fastclick'); ?>
<!-- AdminLTE App -->
<?php echo $this->Html->script('AdminLTE.AdminLTE.min'); ?>
<?php //echo $this->Html->script('jquery.min'); ?>
<?php //echo $this->Html->script('bootstrap.min'); ?>
<!-- AdminLTE for demo purposes -->
<?php echo $this->fetch('script'); ?>
<?php echo $this->fetch('scriptBotton'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".navbar .menu").slimscroll({
            height: "200px",
            alwaysVisible: false,
            size: "3px"
        }).css("width", "100%");

        var a = $('a[href="<?php echo $this->request->webroot . $this->request->url ?>"]');
        if (!a.parent().hasClass('treeview')) {
            a.parent().addClass('active').parents('.treeview').addClass('active');
        }
    });
</script>
</body>
</html>
