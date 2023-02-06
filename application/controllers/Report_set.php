<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_set extends CI_Controller
{

	public function __construct()
	{
		parent::__construct(TRUE);
		$this->load->helper('tgl_indo');
		$users = $this->session->userdata('email');
        $user = $this->db->get_where('karyawan', ['email' => $users])->row_array();
		if ($user['role_id'] !== '1' && $user['role_id'] !== '5') {
            redirect('admin');
        } elseif ($user['role_id'] < '1') {
            redirect('auth/blocked');
        } elseif($user['role_id'] > '6'){
          redirect('auth/blocked');
        }

        if (!$users) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
             Silahkan masuk terlebih dahulu!
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
         </div>');
            redirect('auth/admin');
        }
		$this->load->model(['Student_model', 'Period_model', 'Bulan_model', 'Bebas_model', 'Bebas_pay_model', 'Kredit_model', 'Debit_model']);
	
	}

	public function report()
	{
		// Apply Filter
		// Get $_GET variable
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		// Date start
		if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
			$params['date_start'] = $q['ds'];
		}

		// Date end
		if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
			$params['date_end'] = $q['de'];
		}

		$params['status'] = 1;

		$data['web'] =  $this->db->get('website')->row_array();
		$user = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
		
		$data['bulan'] = $this->Bulan_model->get($params);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_pay_model->get($params);
		$data['kredit'] = $this->Kredit_model->get($params);
		$data['debit'] = $this->Debit_model->get($params);

		$this->load->library("PHPExcel");
		$objXLS   = new PHPExcel();
		$objSheet = $objXLS->setActiveSheetIndex(0);
		$cell     = 6;
		$no       = 1;

		$objSheet->setCellValue('A1', 'LAPORAN KEUANGAN');
		$objSheet->setCellValue('A2', $data['web']['nama']);
		$objSheet->setCellValue('A3', 'Tanggal Laporan: ' . pretty_date($q['ds'], 'd F Y', false) . ' s/d ' . pretty_date($q['de'], 'd F Y', false));
		$objSheet->setCellValue('A4', 'Tanggal Unduh: ' . pretty_date(date('Y-m-d h:i:s'), 'd F Y, H:i', false));
		$objSheet->setCellValue('C4', 'Pengunduh: ' . $user['nama']);


		$objSheet->setCellValue('A5', 'NO');
		$objSheet->setCellValue('B5', 'PEMBAYARAN');
		$objSheet->setCellValue('C5', 'NAMA SISWA');
		$objSheet->setCellValue('D5', 'PENDIDIKAN');
		$objSheet->setCellValue('E5', 'KELAS');
		$objSheet->setCellValue('F5', 'TANGGAL');
		$objSheet->setCellValue('G5', 'PENERIMAAN');
		$objSheet->setCellValue('H5', 'PENGELUARAN');
		$objSheet->setCellValue('I5', 'KETERANGAN');


		foreach ($data['bulan'] as $row) {
			if(!empty($row['majors_name'])){
				$majors = ' - ' . $row['majors_name'];
			}else{
				$majors = '';
			}
			$objSheet->setCellValue('A' . $cell, $no);
			$objSheet->setCellValueExplicit('B' . $cell, $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'] . ' - ' . '(' . $row['month_name'] . ')', PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('C' . $cell, $row['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('D' . $cell, $row['pend_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('E' . $cell, $row['class_name'] . $majors, PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('F' . $cell, pretty_date($row['bulan_date_pay'], 'm/d/Y', FALSE));
			$objSheet->setCellValue('G' . $cell, $row['bulan_bill']);
			$objSheet->setCellValue('H' . $cell, '-');
			$objSheet->setCellValueExplicit('I' . $cell, $row['bulan_pay_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
			$cell++;
			$no++;
		}

		foreach ($data['free'] as $row) {
			if(!empty($row['majors_name'])){
				$majors = ' - ' . $row['majors_name'];
			}else{
				$majors = '';
			}
			$objSheet->setCellValue('A' . $cell, $no);
			$objSheet->setCellValueExplicit('B' . $cell, $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('C' . $cell, $row['nama'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('D' . $cell, $row['pend_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('E' . $cell, $row['class_name'] . $majors, PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValue('F' . $cell, pretty_date($row['bebas_pay_input_date'], 'm/d/Y', FALSE));
			$objSheet->setCellValue('G' . $cell, $row['bebas_pay_bill']);
			$objSheet->setCellValue('H' . $cell, '-');
			$objSheet->setCellValueExplicit('I' . $cell, $row['bebas_pay_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
			$cell++;
			$no++;
		}

		foreach ($data['kredit'] as $row) {

			$objSheet->setCellValue('A' . $cell, $no);
			$objSheet->setCellValue('B' . $cell, 'Pengeluaran');
			$objSheet->setCellValue('C' . $cell, '-');
			$objSheet->setCellValue('D' . $cell, '-');
			$objSheet->setCellValue('E' . $cell, '-');
			$objSheet->setCellValue('F' . $cell, pretty_date($row['kredit_date'], 'm/d/Y', FALSE));
			$objSheet->setCellValue('G' . $cell, '');
			$objSheet->setCellValue('H' . $cell, $row['kredit_value']);
			$objSheet->setCellValueExplicit('I' . $cell, $row['kredit_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
			$cell++;
			$no++;
		}

		foreach ($data['debit'] as $row) {

			$objSheet->setCellValue('A' . $cell, $no);
			$objSheet->setCellValue('B' . $cell, 'Pemasukan');
			$objSheet->setCellValue('C' . $cell, '-');
			$objSheet->setCellValue('D' . $cell, '-');
			$objSheet->setCellValue('E' . $cell, '-');
			$objSheet->setCellValue('F' . $cell, pretty_date($row['debit_date'], 'm/d/Y', FALSE));
			$objSheet->setCellValue('G' . $cell, $row['debit_value']);
			$objSheet->setCellValue('H' . $cell, '');
			$objSheet->setCellValueExplicit('I' . $cell, $row['debit_desc'], PHPExcel_Cell_DataType::TYPE_STRING);
			$cell++;
			$no++;
		}

		$objXLS->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objXLS->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$objXLS->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objXLS->getActiveSheet()->getColumnDimension('H')->setWidth(100);

		foreach (range('D', 'G') as $alphabet) {
			$objXLS->getActiveSheet()->getColumnDimension($alphabet)->setWidth(20);
		}

		$objXLS->getActiveSheet()->getColumnDimension('N')->setWidth(20);

		$font = array('font' => array('bold' => true, 'color' => array(
			'rgb'  => 'FFFFFF'
		)));
		$objXLS->getActiveSheet()
			->getStyle('A5:H5')
			->applyFromArray($font);

		$objXLS->getActiveSheet()
			->getStyle('A5:H5')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('000');
		$objXLS->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="LAPORAN_KEUANGAN_' . date('dmY') . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		exit();
	}

	public function report_print()
	{
		$this->load->library('Pdf');
	    $data['user'] = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
    	$data['web'] =  $this->db->get('website')->row_array();
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();

		// Date start
		if (isset($q['ds']) && !empty($q['ds']) && $q['ds'] != '') {
			$params['date_start'] = $q['ds'];
		}

		// Date end
		if (isset($q['de']) && !empty($q['de']) && $q['de'] != '') {
			$params['date_end'] = $q['de'];
		}

		$params['status'] = 1;

		$data['web'] =  $this->db->get('website')->row_array();
		$user = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();
		
		$data['bulan'] = $this->Bulan_model->get($params);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_pay_model->get($params);
		$data['kredit'] = $this->Kredit_model->get($params);
		$data['debit'] = $this->Debit_model->get($params);

		 
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = 'LAPORAN_KEUANGAN' . '_' . date('Y-m-d') . '.pdf';
		$this->pdf->load_view('laporan/report_all', $data, true);
	}

	// Rekapituliasi
	public function report_bill_detail()
	{
		$q = $this->input->get(NULL, TRUE);

		$data['q'] = $q;

		$params = array();
		$param = array();
		$stu = array();
		$free = array();

		if (isset($q['p']) && !empty($q['p']) && $q['p'] != '') {
			$params['period_id'] = $q['p'];
			$param['period_id'] = $q['p'];
			$stu['period_id'] = $q['p'];
			$free['period_id'] = $q['p'];
		}
		
		if (isset($q['pd']) && !empty($q['pd']) && $q['pd'] != '') {
            $params['id_pend'] = $q['pd'];
			$param['id_pend'] = $q['pd'];
			$stu['id_pend'] = $q['pd'];
			$free['id_pend'] = $q['pd'];

            $pendkkn = $this->db->get_where('data_pendidikan', ['id' => $q['pd']])->row_array();
        }

		if (isset($q['c']) && !empty($q['c']) && $q['c'] != '') {
			$params['class_id'] = $q['c'];
			$param['class_id'] = $q['c'];
			$stu['class_id'] = $q['c'];
			$free['class_id'] = $q['c'];
		}

		if (isset($q['k']) && !empty($q['k']) && $q['k'] != '') {
			$params['majors_id'] = $q['k'];
			$param['majors_id'] = $q['k'];
			$stu['majors_id'] = $q['k'];
			$free['majors_id'] = $q['k'];
		}


		$param['paymentt'] = TRUE;
		$params['grup'] = TRUE;
		$stu['group'] = TRUE;

		$data['web'] =  $this->db->get('website')->row_array();
		$user = $this->db->get_where('karyawan', ['email' => $this->session->userdata('email')])->row_array();

		$data['period'] = $this->Period_model->get($params);
		$data['class'] = $this->Student_model->get_class($stu);
		$data['majors'] = $this->Student_model->get_majors($stu);
		$data['student'] = $this->Bulan_model->get($stu);
		$data['bulan'] = $this->Bulan_model->get($free);
		$data['month'] = $this->Bulan_model->get($params);
		$data['py'] = $this->Bulan_model->get($param);
		$data['bebas'] = $this->Bebas_model->get($params);
		$data['free'] = $this->Bebas_model->get($free);

		$this->load->library("PHPExcel");
		$objXLS   = new PHPExcel();
		$objSheet = $objXLS->setActiveSheetIndex(0);
		$cell     = 7;
		$no       = 1;
		$font = array('font' => array('bold' => true, 'color' => array(
			'rgb'  => 'FFFFFF'
		)));

		$objXLS->setActiveSheetIndex(0);
		$styleArray = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array(
							'rgb'  => 'FFFFFF'
						),
					),
				),
			),
		);
		$borderStyle = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb'  => '111111'
					),
				),
			),
		);


		$objSheet->setCellValue('A1', 'REKAPITULASI PEMBAYARAN SISWA');
		$objSheet->setCellValue('A2', $data['web']['nama']);

		foreach ($data['period'] as $period) {
			$year = $period['period_start'] . '/' . $period['period_end'];
			$periode = ($q['p'] == $period['id']) ? $year : '';
			$objSheet->setCellValue('A3', 'Periode Laporan: ' . $periode);
		}
		$objSheet->setCellValue('A4', 'Tanggal Unduh: ' . pretty_date(date('Y-m-d h:i:s'), 'd F Y, H:i', false));
		$objSheet->setCellValue('C4', 'Pengunduh: ' . $user['nama']);


		$objSheet->mergeCells('A5:A6');
		$objSheet->setCellValue('A5', 'NO');
		$objSheet->mergeCells('B5:B6');
		$objSheet->setCellValue('B5', 'KELAS');
		$objSheet->mergeCells('C5:C6');
		$objSheet->setCellValue('C5', 'NAMA SISWA');
		$objXLS->getActiveSheet()->getStyle('A5:C5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000');
		$objXLS->getActiveSheet()->getStyle('A5:C5')->applyFromArray($font);
		$objSheet->getStyle('A5:C5')->applyFromArray($styleArray);
		$objSheet->getStyle('A6:C6')->applyFromArray($styleArray);

		// Judul Pembayaran Bulanan
		$objSheet->mergeCells('D5:' . getCell(count($data['month']) + 3) . '5');
		foreach ($data['py'] as $row) {
			$objSheet->setCellValue('D5', $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end']);
			$objXLS->getActiveSheet()->getStyle('D5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000');
			$objXLS->getActiveSheet()->getStyle('D5')->applyFromArray($font);
			$objSheet->getStyle('D5:' . getCell(count($data['month']) + 3) . '5')->applyFromArray($styleArray);
		}

		$i = 0;
		foreach ($data['bebas'] as $key) {
			$objSheet->mergeCells(getCell(count($data['month']) + 4 + $i) . '5:' . getCell(count($data['month']) + 4 + $i) . '6');
			$objSheet->getStyle(getCell(count($data['month']) + 4 + $i) . '5:' . getCell(count($data['month']) + 4 + $i) . '6')->applyFromArray($styleArray);
			$i++;
		}

		$j = 0;
		foreach ($data['bebas'] as $row) {
			$objSheet->setCellValue(getCell(count($data['month']) + 4 + $j) . '5', $row['pos_name'] . ' - T.P ' . $row['period_start'] . '/' . $row['period_end']);
			$objXLS->getActiveSheet()->getStyle(getCell(count($data['month']) + 4 + $j) . '5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000');
			$objXLS->getActiveSheet()->getStyle(getCell(count($data['month']) + 4 + $j) . '5')->applyFromArray($font);
			$objSheet->getStyle(getCell(count($data['month']) + 4 + $j) . '5')->applyFromArray($styleArray);
			$j++;
		}

		$alpha = 4;
		foreach ($data['month'] as $key) {
			$objSheet->setCellValue(getCell($alpha) . '6', $key['month_name']);
			$objXLS->getActiveSheet()->getStyle(getCell($alpha) . '6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000');
			$objXLS->getActiveSheet()->getStyle(getCell($alpha) . '6')->applyFromArray($font);
			$objSheet->getStyle(getCell($alpha) . '6')->applyFromArray($styleArray);
			$alpha++;
		}



		foreach ($data['student'] as $row) {

			$objSheet->setCellValue('A' . $cell, $no);
			$objSheet->setCellValueExplicit('B' . $cell, ($pendkkn['majors'] == '1') ? $row['class_name'] . '-' . $row['majors_name'] : $row['class_name'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objSheet->setCellValueExplicit('C' . $cell, $row['nama'], PHPExcel_Cell_DataType::TYPE_STRING);


			$alphdata = 4;
			foreach ($data['bulan'] as $key) {
				if ($key['student_student_id'] == $row['student_student_id']) {
					$objSheet->setCellValue(getCell($alphdata) . $cell, ($key['bulan_status'] == 1) ? 'Lunas' : $key['bulan_bill']);
					$alphdata++;
				}
			}

			foreach ($data['free'] as $key) {
				if ($key['student_student_id'] == $row['student_student_id']) {
					$objSheet->setCellValue(getCell($alphdata) . $cell, ($key['bebas_bill'] == $key['bebas_total_pay']) ? 'Lunas' : $key['bebas_bill'] - $key['bebas_total_pay']);
					$alphdata++;
				}
			}

			$cell++;
			$no++;
		}


		$objXLS->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objXLS->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objXLS->getActiveSheet()->getColumnDimension('C')->setWidth(40);

		foreach (range('D', 'Z') as $alphabet) {
			$objXLS->getActiveSheet()->getColumnDimension($alphabet)->setWidth(20);
		}

		foreach ($data['class'] as $row) {
			if ($q['c'] == $row['id']) {
				$kelas = $row['nama'];
			} else {
				$kelas = 'PEMBAYARAN_SISWA';
			}
		}


		$objXLS->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$objXLS->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="REKAPITULASI_' . $kelas . '_' . date('dmY') . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		exit();
	}
}

/* End of file Report_set.php */
/* Location: ./application/modules/report/controllers/Report_set.php */