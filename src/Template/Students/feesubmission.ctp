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
<h1>Application Form</h1>
<?php //debug($student);
    echo $this->Form->create($student);
    echo $this->Form->control("id", ['type' => 'hidden']);
    echo $this->Form->control("tokenid", [ 'type' => 'hidden' , 'value' => $token]);
    echo $this->Form->control("user_id", ['type' => 'hidden']); ?>
<table width="100%">
    <tr>
        <td width="30%" class="print_headers"></td>
        <td width="20%" class="print_value"></td>
        <td width="30%" class="print_value"></td>
        <td width="20%" class="print_value"></td>
    </tr>
    <tr>
        <td class="print_headers">Name</td>
        <td colspan="3" class="print_value"><?php echo $student['name']; ?></td>
    </tr>
    <tr>
        <td class="print_headers">Registration No.</td>
        <td colspan="3" class="print_value"><?php echo $student['registration_no_cupb']; ?></td>
    </tr>
    <tr>
        <td class="print_headers">Batch</td>
        <td colspan="3" class="print_value"><?php echo (isset($student['batch'])) ? $student['batch'] : "Batch not found" ?></td>
    </tr>
    <tr>
        <td class="print_headers">Semester</td>
        <td colspan="3" class="print_value"><?php echo (isset($student['semester'])) ? $student['semester']['name'] : "Semester not found" ?></td>
    </tr>
    <tr>
        <td class="print_headers">Category</td>
        <td colspan="3" class="print_value"><?php echo (isset($student['category'])) ? $student['category']['name'] : "Category not found" ?></td>
    </tr>
    <?php if(is_array($student['fees'])) {
            $options = []; $count = 0;
            foreach ($student['fees'] as $fee) {
                if(empty($fee['category_id']) || $fee['category_id'] == $student['category_id']) {
                    //$options[$count++] = ['name' => $fee['fee_type'], 'value' => $fee['fee_type'], 'class' => 'print_value'];
                    $options[$fee['fee_type']] = $fee['fee_type'];
                }
            }
            //debug($options);
        }
    ?>
    <tr>
        <td class="print_headers">Select Fee Type</td>
        <td colspan="3" class="print_value"><?php echo $this->Form->control('fee_type', [
            'label' => false, 
            'maxlength'=>'100', 
            'empty' => ['select' => 'Select'],  
            'options' => $options,
            'type' => 'select' ,
            'id' => "select_fee_type"]); ?></td>
    </tr>
    <?php if(is_array($student['fees'])) {
                foreach ($student['fees'] as $fee) {
                    $fee_amount = 0; $late_fee = 0; $total = 0;
                    if(empty($fee['category_id']) || $student['category']['id'] == $fee['category_id']) {
                    $fee_amount = $fee_amount + intval($fee['amount']);
            ?>
        <tr class="<?php echo $fee['fee_type']; ?>">
            <td class="print_headers">Amount (Rs.)</td>
            <td class="print_value"><?php echo $fee['amount']; ?></td>
            <td class="print_headers">Fee Type</td>
            <td class="print_value"><?php echo $fee['fee_type']; ?></td>
        </tr>
        <?php if($latefee == true) { 
                $late_fee = intval($fee['late_fee_per_day']) * ($no_of_days);
                $fee_amount = $fee_amount + $late_fee;
            ?>
           <tr class="<?php echo $fee['fee_type'] . "_late"; ?>">
                <td class="print_headers">Late Fee Amount (Rs.)</td>
                <td colspan="3" class="print_value"><?php echo $late_fee ?></td>
           </tr> 
        <?php } ?>
        <tr class="<?php echo $fee['fee_type']. "_total"; ?>">
            <td class="print_headers">Total Payable Fee(Rs.)</td>
            <td colspan="3" class="print_value"><?php echo $fee_amount; ?></td>
        </tr>
        <?php } ?>
        <?php } } ?>
    <tr>
        <td class="print_headers">Remarks</td>
        <td colspan="3" class="print_value"><?php echo $this->Form->control('remarks', ['label' => false, 'maxlength'=>'50']); ?></td>
    </tr>
    <!--
    <tr>
        <td colspan="4" class="print_value">Note: For the printing of receipt slip (may be later), kindly enter the following details. Please note down these details for later use.</td>
    </tr>
    <tr>
        <td class="print_headers">Name</td>
        <td colspan="3" class="print_value"><?php echo $this->Form->control('slip_name', ['label' => false, 'maxlength'=>'50']); ?></td>
    </tr>
    <tr>
        <td class="print_headers">Date of Birth</td>
        <td colspan="3" class="print_value"><?php echo $this->Form->control('slip_date_of_birth', ['label' => false, 'maxlength'=>'50']); ?></td>
    </tr>
    <tr>
        <td class="print_headers">Mobile No.</td>
        <td colspan="3" class="print_value"><?php echo $this->Form->control('slip_mobile_no', ['label' => false, 'maxlength'=>'50']); ?></td>
    </tr>-->
    <tr>
        <td colspan="4" align="center"><?php echo $this->Form->button(__('Submit')); ?></td>
	<!--<td><?php echo $this->Html->link(
		    'Next',
		    '/preferences/add',
		    ['class' => 'button btn btn-success']
	    ); ?>
	</td>-->
    </tr>
</table>


<?php echo $this->Form->end();  ?>

<script type="text/javascript">
    $(document).ready(function() {
        $(".ACADEMIC td").hide();
        $(".HOSTEL td").hide();
        $(".ACADEMIC_late td").hide();
        $(".HOSTEL_late td").hide();
        $(".ACADEMIC_total td").hide();
        $(".HOSTEL_total td").hide();

        $('#select_fee_type').change(function () {
            var val = $(this).val();
            if (val == 'ACADEMIC') {
                $('.ACADEMIC td').show();
                $('.ACADEMIC').show();
                $('.ACADEMIC_late td').show();
                $('.ACADEMIC_late').show();
                $('.ACADEMIC_total td').show();
                $('.ACADEMIC_total').show();
                $('.HOSTEL td').hide();
                $('.HOSTEL_late td').hide();
                $('.HOSTEL_total td').hide();
            } else if(val == 'HOSTEL'){
                $('.HOSTEL td').show();
                $('.HOSTEL').show();
                $('.HOSTEL_late td').show();
                $('.HOSTEL_late').show();
                $('.HOSTEL_total td').show();
                $('.HOSTEL_total').show();
                $('.ACADEMIC td').hide();
                $('.ACADEMIC_late td').hide();
                $('.ACADEMIC_total td').hide();
            }
            else {
                $('.HOSTEL td').hide();
                $('.ACADEMIC td').hide();
                $('.HOSTEL_late td').hide();
                $('.ACADEMIC_late td').hide();
                $('.HOSTEL_total td').hide();
                $('.ACADEMIC_total td').hide();
            }
        });

        $('#select_fee_type').change();
    });
 $('#id_fee_type').on('change',function(){
        if( $(this).val() !== "select"){
            $("#otherType").show()
        }
        else{
            $("#otherType").hide()
        }
    });
</script>