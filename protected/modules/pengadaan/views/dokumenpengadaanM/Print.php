
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>'12'));  

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        'dokumenpengadaan_jenistransaksi',
                        array(
                            'header' => 'Jenis Pengadaan',
                            'value' => '!empty($data->jenispengadaan_id) ? $data->jenispengadaan->jenispengadaan_nama : " - "',
                        ),
                        array(
                            'header' => 'Metode Pengadaan',
                            'value' => function($data){
                                $modMetode = MetodepengadaanM::model()->findByAttributes(array('metodepengadaan_id' => $data->metodepengadaan_id));
                                if (!empty($modMetode->metodepengadaan_id)) {
                                    echo $modMetode->metodepengadaan_nama; 
                                } else {
                                    echo "-";
                                }
                            }
                        ),
                        'dokumenpengadaan_nama',
                        'dokumenpengadaan_namalain',
                        'dokumenpengadaan_deskripsi',
                        array(
                            'header' => '<center>Wajib</center>',
                            'value' => '($data->dokumenpengadaan_wajib == 1 ) ? "Wajib" : "Tidak Wajib"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Format',
                            'value' => function($data){
                                $pdf = " ";
                                $img = " ";
                                $zip = " ";
                                $rar = " ";
                                $excel = " ";
                                $word = " ";
                                if ($data->file_zip == true) {
                                    $zip = "ZIP,";
                                }
                                if ($data->file_image == true) {
                                    $img = "Gambar,";
                                } 
                                if ($data->file_pdf == true) {
                                    $pdf = "PDF,";
                                }
                                
                                if ($data->file_excel == true) {
                                    $excel = "Excel,";
                                }
                                if ($data->file_word == true) {
                                    $word = "Word,";
                                }
                                
                                if ($data->file_rar == true) {
                                    $rar = "RAR";
                                }

                                return $zip." ".$img." ".$pdf." ".$excel." ".$word." ".$rar;
                            }
                        ),
                        array(
                            'header' => '<center>Aktif</center>',
                            'value' => '($data->dokumenpengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
 
	),
)); 
?>