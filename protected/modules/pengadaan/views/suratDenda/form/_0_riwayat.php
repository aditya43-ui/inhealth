
        <?php $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView',array(
		'id'=>'riwayat-intensivis-grid',
		'dataProvider'=>$model->searchRiwayat(),                
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',                
		'template'=>"{items}",		
		'columns'=>array(
                    array(
                        'header' => 'No',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header'=>'Nomor Transaksi',
                        'value'=>function ($data){ 
                            echo CHtml::link($data->suratdenda_nomor, Yii::app()->createUrl("pengadaan/suratDenda/Detail&suratperjanjiankerja_id=".$_GET['suratperjanjiankerja_id']."&suratdenda_id=".$data->suratdenda_id),array("rel"=>"tooltip","title"=>"Klik untuk Rincian","target"=>"iframe", "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");", ));
                        },
                        'type'=>'raw',
                        //'htmlOptions'=>array('style'=>'text-align:center; vertical-align: middle'),
                    ),
                    'nomor_dokumen',
                    array(
                        'header' => 'Tanggal Surat',
                        'name' => 'suratdenda_tanggal',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->suratdenda_tanggal)'
                    ),
                    array(
                        'header' => 'Nama Pekerjaan',
                        'name' => 'namapekerjaan',
                    ),
                    'supplier_nama',
                    'nama_lengkap',
                    array(
                        'header' => 'Ubah',
                        'type'=>'raw',
                        'value' => function($data){
                            return CHtml::link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('ubah')."'></i></span>",$this->createUrl('index',array('suratperjanjiankerja_id'=>$data->suratperjanjiankerja_id,'suratdenda_id'=>$data->suratdenda_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengubah data'));
                        },
                        'htmlOptions' => array(
                            'style' =>'text-align:center;'
                        )
                    ),
                    array(
                        'header' => 'Cetak',
                        'type'=>'raw',
                        'value' => function($data){
                            return CHtml::link('<span style="font-size:15px;"><i class="entypo-print"></i></span>', '#', array('title' => 'Cetak Dokumen', 'rel' => 'tooltip', 'onclick' => "window.open('" . $this->createUrl('print', array('id' => $data->suratdenda_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                        },
                        'htmlOptions' => array(
                            'style' =>'text-align:center;'
                        )
                    )
		),
		'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});                
            }',
	)); ?>
    
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>