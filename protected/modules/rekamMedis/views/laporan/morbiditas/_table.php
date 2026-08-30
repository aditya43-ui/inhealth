<?php 
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "\n{items}";
} else{
    $data = $model->searchTable2();
  
  $template = "{summary}\n{items}\n{pager}";
}
?>
<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Golongan Umur</p>',
                'start'=>2, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Jenis Kelamin</p>',
                'start'=>10, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'header'=>$controller === 'LaporanDiagnosaPasien'?'Nama Pasien': 'Nama Diagnosa',
                'value'=>function($data) use ($controller){
                    return  $controller === 'LaporanDiagnosaPasien'?$data->nama_pasien : $data->diagnosa_nama;
                },
                // 'htmlOptions' => array('style'=>'text-align:center;')
            ),          
            array(                
                'name' => 'umur_0_28hr',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_28hr_1thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_1_4thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_5_14thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_15_24thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_25_44thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_45_64thn',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(                
                'name' => 'umur_65',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(
                'header' => 'Laki - Laki',
                'name' => 'lakilaki',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(
                'name' => 'perempuan',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(
                'header' => 'Jumlah Kasus Baru',
                'value' => '$data->kasusbaru',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            array(
                'header'=>'Jumlah Kunjungan',
                'value'=>'$data->jumlahkunjungan',
                'htmlOptions' => array('style'=>'text-align:center;')
            ),
            /*

            'diagnosa_id',
            'diagnosa_kode',
            
            'diagnosa_namalainnya',
            'diagnosa_nourut',
            'golonganumur_id',
            , */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>