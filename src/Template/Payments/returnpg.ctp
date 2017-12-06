<?php use Cake\Routing\Router; ?>
<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

table {
    width: 100%;
}

th {
    height: 50px;
    text-align: center;
}
td {
    height: 50px;
    text-align: center;
    vertical-align: bottom;
}
</style>
<?php if(isset($paymentStatus) && $paymentStatus == "0") { ?>
<table>
    <tr>
        <td colspan="2">Your payment has been successful.</td>
    </tr>
    <tr>
        <td>Status:</td>
        <td><?php echo $paymentStatusStr ?></td>
    </tr>
    <tr>
        <td>Payment ID:</td>
        <td><?php echo $paymentID ?></td>
    </tr>
    <tr>
        <td>Date of Payment:</td>
        <td><?php echo $tras_date ?></td>
    </tr>
    <tr>
        <td>Transaction ID:</td>
        <td><?php echo $transID ?></td>
    </tr>
    <tr>
        <td>Amount:</td>
        <td><?php echo $tras_amount ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <div style="text-align: center; font-size: 30px;">
                <?php echo $this->Form->create('Temp', array('id' => 'Continue_Form', 'url' => Router::url( '/candidates/index', true ))); ?>
                <?php echo $this->Form->submit('Continue', array('div' => false, 'id' => 'continue_bt' )); ?>
                <?php echo $this->Form->end(); ?>
            </div>
        </td>
    </tr>
</table>
<?php } else { ?>
<table>
    <tr>
        <td>Your payment failed. Please try again or contact Support.</td>
    </tr>
    <tr>
        <td><?php echo isset($error_mesg) ? $error_mesg : ""; ?></td>
    </tr>
    <tr>
        <td>
            <div style="text-align: center; font-size: 30px;">
                <a href="<?php echo Router::url( '/payments/submitfee', true ) ?>"> To Retry Click Here</a>
            </div>
        </td>
    </tr>
</table>
<?php } ?>