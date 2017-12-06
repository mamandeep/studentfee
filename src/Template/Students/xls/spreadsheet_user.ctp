<?php
//require_once(APP . 'Vendor' . DS . 'phpexcel' . DS . 'PHPExcel.php');
require_once(ROOT . DS . 'vendor' . DS  . 'phpexcel' . DS . 'PHPExcel.php');

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("creator name");

//HEADER
$i=1;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'S.No.');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, 'Name of the Student');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, 'Registration No.');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, 'Department');
$objPHPExcel->getActiveSheet()->mergeCells('E1:X1');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, 'Academic Fee');
$objPHPExcel->getActiveSheet()->mergeCells('Y1:AB1');
$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, 'Hostel Fee');
$i++;
$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, 'Degee & Convocation Fee');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, 'Alumni Association Life Membership Fee');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, 'Security Deposit (Refundable)');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, 'Admission Fee');
$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, 'Identity Card Fee');
$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, 'Medical Fee');
$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, 'Literary and Cultural Fee');
$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, 'Students Union Fund');
$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, 'Tuition Fee');
$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, 'Laboratory Fee');
$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, 'Library and e-Library Fee');
$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, 'Computer and Internet Fee');
$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, 'Examination Fee');
$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, 'Marks Sheet Fee');
$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, 'Sports Fee');
$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, 'Students Welfare Fund');
$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, 'Individual students acd fee total');
$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, 'Date of submission');
$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, 'Transaction ID');
$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, 'Fine');
$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, 'Individual students Hostel fee total');
$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, 'Date of submission');
$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, 'Transaction ID');
$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, 'Fine');


//DATA
//$i++;
//$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $seatsSummary->id);
//$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $seatsSummary->name);


//if u have a collection of users just loop
//DATA
foreach($seatsSummary as $summary) {
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $i-2);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $summary['name']);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $summary['registration_no_cupb']);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $summary['programme_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $summary['degree_convo_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $summary['alumni_association_life']);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $summary['security_deposit_refundable']);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $summary['admission_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $summary['identity_card']);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $summary['medical_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $summary['literary_cultural_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $summary['students_union_fund']);
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $summary['tuition_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $summary['laboratory_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $summary['library_e_lib_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $summary['computer_internet_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $summary['examination_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $summary['marksheet_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $summary['sports_fee']);
    $objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $summary['students_welfare_fund']);
    $objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $summary['ACADEMIC_FEE'] - (($summary['ACADEMIC_FEE_LATE_FEE_APPLICABLE'] == 1) ? $summary['ACADEMIC_FEE_LATE_FEE_AMOUNT'] : 0 ));
    $objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $summary['ACADEMIC_FEE_DATE_DISPLAY']);
    $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $summary['ACADEMIC_FEE_ID']);
    $objPHPExcel->getActiveSheet()->setCellValue('X'.$i, ($summary['ACADEMIC_FEE_LATE_FEE_APPLICABLE'] == 1) ? $summary['ACADEMIC_FEE_LATE_FEE_AMOUNT'] : 0);
    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, $summary['HOSTEL_FEE'] - (($summary['HOSTEL_FEE_LATE_FEE_APPLICABLE'] == 1) ? $summary['HOSTEL_FEE_LATE_FEE_AMOUNT'] : 0 ));
    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, $summary['HOSTEL_FEE_DATE_DISPLAY']);
    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, $summary['HOSTEL_FEE_ID']);
    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$i, ($summary['HOSTEL_FEE_LATE_FEE_APPLICABLE'] == 1) ? $summary['HOSTEL_FEE_LATE_FEE_AMOUNT'] : 0);
}


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('User Data');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//call the function in the controller with $output_type = F and $file with complete path to the file, to generate the file in the server for example attach to email
if (isset($output_type) && $output_type == 'F') {
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($file);
 } else {
    // Redirect output to a client's web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$file.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}

?>