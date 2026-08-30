

<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$template = "{items}";
if (isset($caraPrint)){
	$template = "{items}";
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
	
	if($caraPrint=='EXCEL')
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');  
		
		 $table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
	
	if ($caraPrint=='PDF') {
		$table = 'ext.bootstrap.widgets.BootGridViewPDFNonRp';
	}

	$itemCssClass='table border';
}

$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

$prov = $model->search();
$prov->pagination = false;

$totalUpahLembur = 0;
foreach ($prov->data as $dataModRealisasi){
    $totalUpahLembur += ($dataModRealisasi->upah_lembur_jam1 + $dataModRealisasi->upah_lembur_jam2 + $dataModRealisasi->upah_lembur_jam3);
}

$this->widget($table,array(
    'id'=>'laporanrealisasilembur-v-grid',
    'dataProvider'=>$prov,
    'itemsCssClass'=>$itemCssClass,
    'enableSorting'=>false,	
    'template'=>$template,   
    'mergeHeaders'=>array(
                            array(
                                    'name'=>'<p style="margin: 0; text-align: center;">Upah Lembur</p>',
                                    'start'=>'13',
                                    'end'=>'15',
                            ),
                    ),
    'columns'=>array(        
        array(
			'header' => 'No.',
			'value' => '$row+1'
		),
		array(
                        'header'=>'No/Tanggal Realisasi',
						'type' => 'raw',
                        'value'=>'$data->norealisasi."/<br> ".MyFormatter::formatDateTimeForUser($data->tglrealisasi)',
                    ),
					array(
						'header' => 'Nama Pegawai',
						'value' => function($data){
							if (!empty($data->nama_pegawai)){
								$peg = PegawaiM::model()->find(" LOWER(nama_pegawai) = '".trim(strtolower($data->nama_pegawai))."' ");
								
								if (!empty($peg)){
									return $peg->namaLengkap;
								}else{
									return '-';
								}								
							}else{
								return '-';
							}
						}
					),
					'alasanlembur',
					array(
						'header' => 'Pemberi Tugas',
						'value' => '$data->namaLengkapPemberi'
					),
					array(
						'header' => 'Menyetujui',
						'value' => '$data->namaLengkapMenyetujui',
					),
                    
					array(
						'header' => 'Instalasi',
                        'value' => function($data) {
                            $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
                            return empty($ruangan->instalasi) ? "-" : $ruangan->instalasi->instalasi_nama;
                        },
						'footer' => '<b>Total</b>',
						'footerHtmlOptions'=>array('style' => 'text-align:right;', 'colspan'=>9)
					),
                    
					'create_ruangan_nama',
                    array(
                        'header' => 'Jenis Lembur',
                        'type' => 'raw',
                        'value' => '$data->jenislembur'
                    ),
                     array(
                        'header' => 'Total Jam Lembur',
                        'name'=>'total_jam',
                         'value'=>'number_format($data->total_jam)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(total_jam)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                    array(
                        'header' => 'Jam Normal',
                        'name'=>'total_jam_normal',
                        'value'=>'number_format($data->total_jam_normal)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(total_jam_normal)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                 array(
                        'header' => 'Upah Sejam Lembur Hari Kerja',
                        'name'=>'upahsejamlembur',
                                     'value'=>'number_format($data->upahsejamlembur)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(upahsejamlembur)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                 array(
                        'header' => 'Upah Bulanan',
                        'name'=>'upah_bulanan',
                                     'value'=>'number_format($data->upah_bulanan)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(upah_bulanan)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                 array(
                        'header' => 'Jam ke 1',
                        'name'=>'upah_lembur_jam1',
                        'value'=>'number_format($data->upah_lembur_jam1)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(upah_lembur_jam1)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                array(
                        'header' => 'Jam ke 2',
                        'name'=>'upah_lembur_jam2',
                                     'value'=>'number_format($data->upah_lembur_jam2)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(upah_lembur_jam2)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                array(
                        'header' => 'Jam ke 3',
                        'name'=>'upah_lembur_jam3',
                                     'value'=>'number_format($data->upah_lembur_jam3)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(upah_lembur_jam3)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
//                                 array(
//                        'header' => 'Upah Lembur',
//                    'value' => 'number_format(($data->upah_lembur_jam1 + $data->upah_lembur_jam2 + $data->upah_lembur_jam3))',
//                        'htmlOptions'=>array(
//                            'style'=>'text-align: right;'
//                        ),
//                        'footer'=>number_format($totalUpahLembur),
//                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
//                    ),
                                 array(
                        'header' => 'Total',
                        'name'=>'total_nilai_lembur',
                                     'value'=>'number_format($data->total_nilai_lembur)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>'sum(total_nilai_lembur)',
                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                    ),
                                 array(
                        'header' => 'Alasan Lembur',
                        'type' => 'raw',
                        'value' => '$data->alasanlembur'
                    ),
                    
    ),
));

?>