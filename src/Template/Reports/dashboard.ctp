<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

table {
    table-layout: fixed;
    width=2000px;
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
<div style="font-size: 16px; font-weight: bold; text-align: center;">Welcome to Admin Panel for CUPB Fee Submissions - 2017</div>
<div style="text-align: center;">Summary of Received Fees 2017 as on <?php date_default_timezone_set('Asia/Kolkata'); echo date('d-m-Y H:i'); ?></div>
<div style="text-align: right;"><span style="text-align: right"><?php echo $this->Html->link(
            'Download Excel',
            '/students/xls/3'
      ); ?></span></div>
<div style="width:100%;overflow: scroll; border:10px solid crimson; height:300px;;">
<table boder="2px solid black" style="border-collapse: collapse;">
<tr>
<th rowspan="2">S.No.</th>
<th rowspan="2">Name of the Student</th>
<th rowspan="2">Registration No.</th>
<th rowspan="2">Department Name</th>
<th colspan="20">Academic Fee</th>
<th colspan="4">Hostel Fee</th>
</tr>
<tr>
    <th>Degree & Convocation Fee</th>
    <th>Alumni Association Life Membership Fee</th>
    <th>Security Deposit (Refundable)</th>
    <th>Admission Fee</th>
    <th>Identity Card Fee</th>
    <th>Medical Fee</th>
    <th>Literary and Cultural Fee</th>
    <th>Students Union Fund</th>
    <th>Tuition Fee</th>
    <th>Laboratory Fee</th>
    <th>Library and e-Library Fee</th>
    <th>Computer and Internet Fee</th>
    <th>Examination Fee</th>
    <th>Marks Sheet Fee</th>
    <th>Sports Fee</th>
    <th>Students Welfare Fund</th>
    <th>Individual students Academic fee total</th>
    <th>Date of submission</th>
    <th>Transaction ID</th>
    <th>Fine</th>
    <th>Individual students Hostel fee total</th>
    <th>Date of submission</th>
    <th>Transaction ID</th>
    <th>Fine</th>
</tr>
<?php $count = 1; foreach($summary as $programme) { ?>
<tr>
    <td><?= $count++ ?></td>
    <td><?= $programme['name'] ?></td>
    <td><?= $programme['registration_no_cupb'] ?></td>
    <td><?= $programme['programme_name'] ?></td>
    <td><?= $programme['degree_convo_fee'] ?></td>
    <td><?= $programme['alumni_association_life'] ?></td>
    <td><?= $programme['security_deposit_refundable'] ?></td>
    <td><?= $programme['admission_fee'] ?></td>
    <td><?= $programme['identity_card'] ?></td>
    <td><?= $programme['medical_fee'] ?></td>
    <td><?= $programme['literary_cultural_fee'] ?></td>
    <td><?= $programme['students_union_fund'] ?></td>
    <td><?= $programme['tuition_fee'] ?></td>
    <td><?= $programme['laboratory_fee'] ?></td>
    <td><?= $programme['library_e_lib_fee'] ?></td>
    <td><?= $programme['computer_internet_fee'] ?></td>
    <td><?= $programme['examination_fee'] ?></td>
    <td><?= $programme['marksheet_fee'] ?></td>
    <td><?= $programme['sports_fee'] ?></td>
    <td><?= $programme['students_welfare_fund'] ?></td>
    <td><?= $programme['ACADEMIC_FEE'] - (($programme['ACADEMIC_FEE_LATE_FEE_APPLICABLE'] == 1) ? $programme['ACADEMIC_FEE_LATE_FEE_AMOUNT'] : 0 ) ?></td>
    <td><?= $programme['ACADEMIC_FEE_DATE_DISPLAY'] ?></td>
    <td><?= $programme['ACADEMIC_FEE_ID'] ?></td>
    <td><?= (($programme['ACADEMIC_FEE_LATE_FEE_APPLICABLE'] == 1) ? $programme['ACADEMIC_FEE_LATE_FEE_AMOUNT'] : 0 ) ?></td>
    <td><?= $programme['HOSTEL_FEE'] - (($programme['HOSTEL_FEE_LATE_FEE_APPLICABLE'] == 1) ? $programme['HOSTEL_FEE_LATE_FEE_AMOUNT'] : 0 ) ?></td>
    <td><?= $programme['HOSTEL_FEE_DATE_DISPLAY'] ?></td>
    <td><?= $programme['HOSTEL_FEE_ID'] ?></td>
    <td><?= (($programme['HOSTEL_FEE_LATE_FEE_APPLICABLE'] == 1) ? $programme['HOSTEL_FEE_LATE_FEE_AMOUNT'] : 0 ) ?></td>
</tr>
<?php } ?>
</table>
</div>