<style>
    .labelsp {
        margin-right: 20px;
    }
    .print_headers {
        font-size: 15px;
        color: #010101;
        padding: 3px;
        font-family: Verdana, Geneva, sans-serif;
    }

    .print_value {
        font-size: 15px;
        font-weight: bold;
        color: black;
        padding: 3px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .ACADEMIC {
        display: none;
    }
    .HOSTEL {
        display: none;
    }
</style>
<h1>Application Fee Status</h1>
<?php if(isset($status)) {
        foreach($status as $fee) { ?>
            <br/><br/>
            <table>
               <tr>
                    <td>Batch</td>
                    <td><?php echo $fee['batch']; ?></td>
                </tr>
                <tr>
                    <td>Registration No.</td>
                    <td><?php echo $fee['registration_no']; ?></td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td><?php echo $fee['semester_id']; ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $fee['name']; ?></td>
                </tr>
                <tr>
                    <td>Fee Type</td>
                    <td><?php echo $fee['fee_type']; ?></td>
                </tr>
                <tr>
                    <td>Fee Status</td>
                    <td><?php echo $fee['fee_status']; ?></td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td><?php echo $fee['amount_paid']; ?></td>
                </tr>
                <tr>
                    <td>Late Fee Applicable</td>
                    <td><?php echo $fee['latefee_applicable']; ?></td>
                </tr>
                <tr>
                    <td>Late Fee Amount</td>
                    <td><?php echo $fee['latefee_amount']; ?></td>
                </tr>
                <tr>
                    <td>Payment Date Created</td>
                    <td><?php echo $fee['payment_date_created']; ?></td>
                </tr>
                <tr>
                    <td>Payment ID</td>
                    <td><?php echo $fee['payment_id']; ?></td>
                </tr>
            </table>
<?php }} ?>