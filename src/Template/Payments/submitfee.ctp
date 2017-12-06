<style>
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
<?php if(isset($submitFeeOpen) && $submitFeeOpen === true) { ?>
<div style="font-size: 16px; font-weight: bold;">Fee submission (Note: Please submit one fee at a time and take a print out/screen-shot of the details after successful submission)</div>
<?php //debug($studentdata); debug($feePaid);
$acadFeeSubmitted = false; 
$hostelFeeSubmitted = false;

if(isset($feePaid)) { 
    foreach($feePaid as $fee) { 
    if($fee['fee_type'] == "academic") { $acadFeeSubmitted = true; ?>
<div>You have submitted the Academic Fee.</div>
<?php }
    if($fee['fee_type'] == "hostel") { $hostelFeeSubmitted = true; ?>
    <div>You have submitted the Hostel Fee.</div>
<?php
}}} ?>
<table>
<tr><td></td><td></td><td></td></tr>
<tr>
<td></td>
<td>
<?php
    //debug($programme);
    if($acadFeeSubmitted === false) {
        echo $this->Form->create('academic', ['id' => 'academic']);
        echo $this->Form->control("tokenid", [ 'type' => 'hidden' , 'value' => $token]);
        echo $this->Form->control("academicfee", [ 'type' => 'hidden' , 'value' => 1]);
        echo $this->Form->button(__('Submit Academic Fee'));
        echo $this->Form->end();
    }
     ?>
</td>
<td></td>
</tr>
<tr><td></td><td></td><td></td></tr>
<tr>
<td></td>
<td>
<?php
    //debug($programme);
    if($hostelFeeSubmitted === false && ($studentdata['hostel_fee'] !== 0 || !is_null($studentdata['hostel_fee'])) ) {
        echo $this->Form->create('hostel', ['id' => 'hostel']);
        echo $this->Form->control("tokenid", [ 'type' => 'hidden' , 'value' => $token]);
        echo $this->Form->control("hostelfee", [ 'type' => 'hidden' , 'value' => 1]);
        echo $this->Form->button(__('Submit Hostel Fee'));
        echo $this->Form->end(); 
    }
 ?>
</td>
<td></td>
</tr>
</table>
<script>
    $(document).ready(function() {
            $('#programme_id').on('change', function() {
                 $(this).closest('form').trigger('submit');
            });

            //$('#programme_id').change();
        });
</script>
<?php } else { ?>
<div>Submit Fee is closed at this time.</div>
<?php } ?>