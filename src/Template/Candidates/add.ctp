<style>
    .labelsp {
        margin-right: 20px;
    }
</style>
<h1>Application Form</h1>
<?php
    echo $this->Form->create($candidate);
    echo $this->Form->control("id", ['type' => 'hidden']); 
    echo $this->Form->control("user_id", ['type' => 'hidden']); ?>
<table width="100%">
    <tr>
        <td width="25%" colspan="1" class="form-label">Name of the Candidate (full name as mentioned on your certificates)</td>
        <td colspan="3"><?php echo $this->Form->control('name', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td colspan="1" class="form-label">Father's Name</td>
        <td colspan="3"><?php echo $this->Form->control('f_name', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Date of Birth (DD/MM/YYYY)</td>
        <td width="25%"><?php echo $this->Form->control('dob', ['label' => false, 'placeholder' => 'DD/MM/YYYY', 'maxlength'=>'20']); ?></td>
        <td width="25%" class="form-label">CUCET Roll No. (8 digit)</td>
        <td width="25%"><?php echo $this->Form->control('cucet_roll_no', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Category</td>
        <td><?php echo $this->Form->control("category_id", ['label' => false, 'empty' => ['select' => 'Select'],  'options' => $categories, 'type' => 'select' , 'id' => "id_category_id", 'maxlength'=>'100']); ?></td>
        <td class="form-label">Person with Disability</td>
        <td><?php echo $this->Form->control('pwd', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_pwd", 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Ward of Defense Personnel</td>
        <td><?php echo $this->Form->control('ward_of_def', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_wardofdef", 'maxlength'=>'100']); ?></td>
        <td class="form-label">Kashmiri Migrant</td>
        <td><?php echo $this->Form->control('kashmiri_mig', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_wardofdef", 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">State of Domicile</td>
        <td><?php echo $this->Form->control("state_id", ['label' => false, 'empty' => ['select' => 'Select'],  'options' => $states, 'type' => 'select' , 'id' => "id_state_id", 'maxlength'=>'100']); ?></td>
        <td class="form-label">Aadhar Number (xxxx xxxx xxxx)</td>
        <td><?php echo $this->Form->control('aadhar_no', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
	<tr>
        <td colspan="1" class="form-label">Hostel Accomodation required?</td>
        <td colspan="3"><?php echo $this->Form->control('hostel_acco', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_hostelacco", 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td colspan="4"><label>Details of Qualifying Examination: </label></td>
    </tr>
    <tr>
        <td class="form-label">Degree</td>
        <td><?php echo $this->Form->control('qualif_degree', [
            'label' => false, 
            'maxlength'=>'100', 
            'empty' => ['select' => 'Select'],  
            'options' => ['B.A.' => 'B.A.',
                          'B.Com.' => 'B.Com.',
                          'B.Pharm.' => 'B.Pharm.',
                          'B.Sc.' => 'B.Sc.',
                          'B.Tech./B.E.' => 'B.Tech./B.E.',
                          'BBA' => 'BBA',
                          'LL.B.' => 'LL.B.',
                          'Other' => 'Other'
                         ], 
            'type' => 'select' , 'id' => "id_qualif_degree" ]); ?></td>
        <td class="form-label">Major Subjects</td>
        <td><?php echo $this->Form->control('qualif_maj_subjects', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Result Declared</td>
        <td><?php echo $this->Form->control('qualif_result_declared', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_result_dec"]); ?></td>
        <td class="form-label">Marks Obtained</td>
        <td><?php echo $this->Form->control('qualif_marks_obtained', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td colspan="1" class="form-label">Total Marks</td>
        <td colspan="3"><?php echo $this->Form->control('qualif_total_marks', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td colspan="3"><label>If you are a candidate for M.Tech./M.Pharm. and have valid GATE/GPAT, select 'Yes' and fill the details, otherwise select 'No'.</label></td>
        <td colspan="1"><?php echo $this->Form->control('valid_gate_gpat', ['label' => false, 'empty' => ['select' => 'Select'],  'options' => ['yes' => 'Yes', 'no' => 'No'], 'type' => 'select' , 'id' => "id_validggp", 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Examination</td>
        <td><?php echo $this->Form->control('ggp_exam', ['label' => false, 'maxlength'=>'100', 'empty' => ['select' => 'Select'],  'options' => ['GATE' => 'GATE', 'GPAT' => 'GPAT'], 'type' => 'select' , 'id' => "id_ggpexam" ]); ?></td>
        <td class="form-label">Roll Number</td>
        <td><?php echo $this->Form->control('ggp_roll_no', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td class="form-label">Year of Passing (YYYY)</td>
        <td><?php echo $this->Form->control('ggp_year_passing', ['label' => false, 'maxlength'=>'100']); ?></td>
        <td class="form-label">Marks Obtained/Rank</td>
        <td><?php echo $this->Form->control('ggp_marksobtained_rank', ['label' => false, 'maxlength'=>'100']); ?></td>
    </tr>
    <tr>
        <td colspan="4"><label>Declaration: </label>
                    <ol>
                        <li>I declare that the above information is true and correct to the best of my knowledge. If found incorrect at any time, my candidature can be cancelled.</li>
                        <li>I undertake that i will abide by the rules and regulations of Central University of Punjab, Bathinda.</li>
                        <li>I understand that my admission is subject to fulfilling the eligibility criteria, which I have read carefully, and I will be fully responsible for any choices made by me during the counselling and admission process. My candidature can be cancelled any time, in case i am found not eligible at any moment.</li>
                    </ol>
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center"><?php echo $this->Form->button(__('Save')); ?></td>
	<td><?php echo $this->Html->link(
		    'Next',
		    '/preferences/add',
		    ['class' => 'button btn btn-success']
	    ); ?>
	</td>
    </tr>
</table>


<?php echo $this->Form->end();  ?>

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
      
      $('select[name=valid_gate_gpat]').change(function(){
          if($(this).val() == "no") {
              $('select[name=ggp_exam]').attr('disabled', true);
              $('input[name=ggp_roll_no]').attr('disabled', true);
              $('input[name=ggp_year_passing]').attr('disabled', true);
              $('input[name=ggp_marksobtained_rank]').attr('disabled', true);
          }
          else if($(this).val() == "yes") {
              $('select[name=ggp_exam]').attr('disabled', false);
              $('input[name=ggp_roll_no]').attr('disabled', false);
              $('input[name=ggp_year_passing]').attr('disabled', false);
              $('input[name=ggp_marksobtained_rank]').attr('disabled', false);
          }
          else {
              
          }
      });
      
      $('select[name=valid_gate_gpat]').change();
    })
</script>
