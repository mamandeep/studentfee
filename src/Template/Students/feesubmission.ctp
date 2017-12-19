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
                $fee_amount_academic = 0; $late_fee_academic = 0; $total_academic = 0;
            ?>
     <tr class="ACADEMIC">
            <td></td>
            <td colspan="3">
                <table width="100%" border="1px solid black" style="border-collapse: collapse;">
                    <th>
                        <tr>
                            <td class="print_headers">Fee Type</td>
                            <td class="print_value">Amount (Rs.)</td>
                        </tr>
                    </th>
                    <tbody>
                        <tr>
                            <td class="print_headers">Degree Convocation Fee</td>
                            <td class="print_value"><?php echo $student['degree_convo_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Alumni Association Life</td>
                            <td class="print_value"><?php echo $student['alumni_association_life']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Security Deposit Refundable</td>
                            <td class="print_value"><?php echo $student['security_deposit_refundable']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Admission Fee</td>
                            <td class="print_value"><?php echo $student['admission_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Identity Card Fee</td>
                            <td class="print_value"><?php echo $student['identity_card']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Medical Fee</td>
                            <td class="print_value"><?php echo $student['medical_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Literary Cultural Fee</td>
                            <td class="print_value"><?php echo $student['literary_cultural_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Students Union Fund</td>
                            <td class="print_value"><?php echo $student['students_union_fund']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Tuition Fee</td>
                            <td class="print_value"><?php echo $student['tuition_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Laboratory Fee</td>
                            <td class="print_value"><?php echo $student['laboratory_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Library e-Lib Fee</td>
                            <td class="print_value"><?php echo $student['library_e_lib_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Computer Internet Fee</td>
                            <td class="print_value"><?php echo $student['computer_internet_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Examination Fee</td>
                            <td class="print_value"><?php echo $student['examination_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Marksheet Fee</td>
                            <td class="print_value"><?php echo $student['marksheet_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Sports Fee</td>
                            <td class="print_value"><?php echo $student['sports_fee']; ?></td>
                        </tr>
                        <tr>
                            <td class="print_headers">Students Welfare Fund</td>
                            <td class="print_value"><?php echo $student['students_welfare_fund']; ?></td>
                        </tr>
        <?php $fee_amount_academic =        $student['degree_convo_fee'] +
                                            $student['alumni_association_life'] +
                                            $student['security_deposit_refundable'] +
                                            $student['admission_fee'] +
                                            $student['identity_card'] +
                                            $student['medical_fee'] +
                                            $student['literary_cultural_fee'] +
                                            $student['students_union_fund'] +
                                            $student['tuition_fee'] +
                                            $student['laboratory_fee'] +
                                            $student['library_e_lib_fee'] +
                                            $student['computer_internet_fee'] +
                                            $student['examination_fee'] +
                                            $student['marksheet_fee'] +
                                            $student['sports_fee'] +
                                            $student['students_welfare_fund'];
                if($latefee == true) { 
                    $late_fee_academic = intval($student['late_fee_per_day']) * ($no_of_days);
                    $fee_amount_academic = $fee_amount_academic + $late_fee_academic;
            ?>
           <tr>
                <td class="print_headers">Late Fee Amount (Rs.)</td>
                <td class="print_value"><?php echo (intval($student['late_fee_per_day']) * ($no_of_days)); ?></td>
           </tr> 
        <?php } ?>
          <tr>
            <td class="print_headers">Total Payable Fee(Rs.)</td>
            <td class="print_value"><?php echo $fee_amount_academic; ?></td>
        </tr>
        </tbody>
            </table>
        </td>
        </tr>
        <tr class="HOSTEL">
            <td></td>
            <td colspan="3">
                <table width="100%" border="1px solid black" style="border-collapse: collapse;">
                    <th>
                        <tr>
                            <td class="print_headers">Fee Type</td>
                            <td class="print_value">Amount (Rs.)</td>
                        </tr>
                    </th>
                    <tbody>
                        <tr>
                            <td class="print_headers">Hostel Fee</td>
                            <td class="print_value"><?php echo $student['hostel_fee']; ?></td>
                        </tr>
                   </tbody>
                </table>
            </td>
        </tr>
                <?php } ?>
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
        $(".ACADEMIC").hide();
        $(".ACADEMIC td").hide();
        $(".HOSTEL").hide();
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
                $(".HOSTEL").hide();
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
                $(".ACADEMIC").hide();
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