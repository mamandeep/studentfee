<style>
    .labelsp {
        margin-right: 20px;
    }
</style>
<div class="form-container">
<h1>Cancellation of Seat and Refund of Fee</h1>
<?php
    echo $this->Form->create($cancelseat);
    echo $this->Form->input('id', ['type' => 'hidden']);
    echo $this->Form->input('fee_id', ['type' => 'hidden', 'value' => $userData['fee_id']]);
    ?>
<label>Applicant ID CUCET: <?php echo $userData['applicant_id'];?></label>
<table>
    <tr>
        <td>Name</td>
        <td><?php echo $userData['c_name']; ?></td>
    </tr>
    <tr>
        <td>Father's  Name</td>
        <td><?php echo $userData['f_name']; ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?php echo $this->Form->control('address', ['label' => false, 'maxlength' => '255']); ?></td>
    </tr>
    <tr>
        <td>Mobile Number</td>
        <td><?php echo $userData['mobile']; ?></td>
    </tr>
    <tr>
        <td>Email ID</td>
        <td><?php echo $userData['email']; ?></td>
    </tr>
    <tr>
        <td>Email ID</td>
        <td><?php echo $userData['email']; ?></td>
    </tr>
    <tr>
        <td>Fee payment ID</td>
        <td><?php echo $userData['bank_payment_id']; ?></td>
    </tr>
    <tr>
        <td>Fee payment date</td>
        <td><?php echo $userData['fee_submit_date']; ?></td>
    </tr>
    <tr>
        <td>Seat Alloted (Course Name)</td>
        <td><?php echo $userData['p_name']; ?></td>
    </tr>
    <tr>
        <td>Seat Alloted (Category)</td>
        <td><?php echo $userData['category']; ?></td>
    </tr>
    <tr>
        <td>Amount of Fee Deposited</td>
        <td><?php echo $userData['amount']; ?></td>
    </tr>
</table>
<label>It is requested that my seat may be cancelled and refund of the fee be sent in the following Account detail: </label>
<table>
    <tr>
        <td>Account Holder Name</td>
        <td><?php echo $this->Form->control('ac_owner_name', ['label' => false, 'maxlength' => '100']); ?></td>
    </tr>
    <tr>
        <td>Bank Account Number</td>
        <td><?php echo $this->Form->control('ac_number', ['label' => false, 'maxlength' => '100']); ?></td>
    </tr>
    <tr>
        <td>Name of the Bank</td>
        <td><?php echo $this->Form->control('bank_name', ['label' => false, 'maxlength' => '255']); ?></td>
    </tr>
    <tr>
        <td>IFS Code (IFSC)</td>
        <td><?php echo $this->Form->control('ifs_code', ['label' => false, 'maxlength' => '50']); ?></td>
    </tr>
    <tr>
        <td>Branch Address</td>
        <td><?php echo $this->Form->control('branch_address', ['label' => false, 'maxlength' => '255']); ?></td>
    </tr>
</table>
<div>
<label style="text-decoration: underline;">Undertaking by the Candidate</label>
<br/>
<label style="font-style: italic;">
I hereby certify that, I opt to cancel my seat and request to refund the fee as per the UGC guidelines given in the University Prospectus.
</label>
</div>
<?php echo $this->Form->button(__('Submit Request')); 
      echo $this->Form->end();  ?>
</div>

<script>
    $(document).ready(function(){
      var date_input=$('input[name="dob"]'); //our date input has the name "date"
      var container=$('.form-container form').length>0 ? $('.form-container form').parent() : "body";
      var options={
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
