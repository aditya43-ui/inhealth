
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

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  


if (empty($model->jenissurat_id)) {
    $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
                'jenisinformasi_aktif'=>true
            ), array(
                'order'=>'jenisinformasi_urutan'
            )), 'jenisinformasi_id', 'jenisinformasi_nama');

} else {
    $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
                'jenissurat_id'=>$model->jenissurat_id,
                'jenisinformasi_aktif'=>true
            ), array(
                'order'=>'jenisinformasi_urutan'
            )), 'jenisinformasi_id', 'jenisinformasi_nama');
}


$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'name'=>'isiinformasi_id',
            'filter'=>false,
        ),
        array(
            'header'=>'Jenis Surat',
            'type'=>'raw',
            'value'=>function($data) {
                return empty($data->jenisinformasi->jenissurat) ? "-" : $data->jenisinformasi->jenissurat->jenissurat_nama;
            },
            'filter'=>CHtml::activeDropDownList($model, 'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif = true order by jenissurat_nama asc'), 'jenissurat_id', 'jenissurat_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Jenis Informasi',
            'type'=>'raw',
            'name'=>'jenisinformasi_id',
            'value'=>'$data->jenisinformasi->jenisinformasi_nama',
            'filter'=>CHtml::activeDropDownList($model, 'jenisinformasi_id', $list, array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Isi Informasi',
            'type'=>'raw',
            'value'=>function($data) {
                $jenis = JenisinformasiM::model()->findByPk($data->jenisinformasi_id);

                if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
                    return CHtml::checkBox("a", "", array('disabled'=>true))."<label>".$data->isiinformasi_nama."</label>";
                } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
                    return $data->isiinformasi_nama;
                } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
                    return CHtml::textArea("a", "", array('readonly'=>true));
                } 
            }
        ),
        array(
            'name'=>'isiinformasi_aktif',
            'value'=>'$data->isiinformasi_aktif ? "Aktif" : "Tidak Aktif"',
            'filter'=>false,
        ),
	),
)); 
?>