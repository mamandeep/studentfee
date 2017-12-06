<?php
$file = $theme['folder'] . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.2
    </div>
    <strong>Copyright &copy; 2016-2017 <a href="http://cup.ac.in">Central University of Punjab</a>.</strong> All rights
    reserved. For technical queries please contact: onlineadmissionsquerycup@gmail.com
</footer>
<?php } ?>
