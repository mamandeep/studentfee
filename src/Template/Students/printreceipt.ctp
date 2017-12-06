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

    td {

        /* css-3 */
        white-space: -o-pre-wrap; 
        word-wrap: break-word;
        white-space: pre-wrap; 
        white-space: -moz-pre-wrap; 
        white-space: -pre-wrap; 
        padding: 5px;

    }

    table { 
        table-layout: fixed;
        width: 100%;
        page-break-inside: avoid;
    }
    /*@page {
        size: A4;
    }
    h1 {
        page-break-before: always;
    }
    h1, h2, h3, h4, h5 {
      page-break-after: avoid;
    }
    @media print {
        font-family: Arial, Helvetica, sans-serif;
    }*/
</style>
<?php
    echo $this->Form->create($semester);
    echo $this->Form->control("sid", ['label' => 'Select Semester:',  'options' => $semesters, 'empty' => ['select' => 'Select'], 'type' => 'select' , 'id' => "semester_id", 'maxlength' => '20']); 
    echo $this->Form->end(); ?>
<h1>Receipt (of Selected Semester)</h1>
<?php if(isset($fee) && !empty($fee)) { ?>
            <table border="2px solid black" style="border-collapse: collapse;">
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
<?php } else if(isset($selected_sem_id) && $selected_sem_id != 0) { ?>
<h1>Receipt record not found.</h1>
<?php } ?>
<script>
$(document).ready(function(){
    $('#semester_id').on('change', function() {
         $(this).closest('form').trigger('submit');
    });
});
</script>