<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $data = $model->searchKunjungan();
    $template = "{summary}\n{items}\n{pager}";
?>
<?php $this->widget($table,array(
	'id'=>'tableKunjungan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'name' => 'pegawai_id',
                'value' => 'PegawaiM::model()->findByPk($data->pegawai_id)->nama_pegawai',
            ),
            array(
                'name' => 'ruangan_id',
                'value' => 'RuanganM::model()->findByPk($data->ruangan_id)->ruangan_nama',
            ),
            'tglperiksa',
            'catatan'
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php Yii::app()->clientScript->registerScript('detail_data_pasien',"
    $('#detail_kunjungna_pasien').hide();
    $('#cex_kunjunganpasien').change(function(){
        $('#detail_kunjungna_pasien').slideToggle(500);
    });
");
?>
