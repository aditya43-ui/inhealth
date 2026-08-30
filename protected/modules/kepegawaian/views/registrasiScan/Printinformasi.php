
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchInformasiprint();
 
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchInformasi();
         $template = "{summary}\n{items}\n{pager}";
    }
    
    $this->widget($table,array(
	'id'=>'kppengangkatanpns-t-grid',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'No. Finger Print',
                    'name'=>'nofingerprint',
                     'type'=>'raw',
                    'value'=>'CHtml::link($data->nofingerprint,"", array("class"=>"poping","data-title"=>Yii::t("mds","Tips"), "data-content"=>CHtml::textField("test"), "rel"=>"popover"))',
//                     'value'=>'CHtml::link($data->nofingerprint, Yii::app()->createUrl($this->grid->owner->module->id.\'/\'.$this->grid->owner->id.\'/finger&id=\'.$data->pegawai_id), array(\'onclick\'=>\'setFinger(this);return false;\', \'class\'=>\'parentFinger\'))',
                ),
		array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'name'=>'nama_pegawai',
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Jenis Kelamin',
                    'name'=>'jeniskelamin',
                    'value'=>'$data->jeniskelamin',
                ),
//		        array(
//                        'header'=>'Jabatan',
//                        'name'=>'jabatan_id',
//                        'filter'=>  CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),
//                        'value'=>'$data->jabatan_nama',
//                    ),
//                array(
//                    'visible'=>true,
//                    'class'=>'bootstrap.widgets.BootButtonGroup',
//                    'htmlOptions'=>array('style'=>'width: 50px'),
//                ),
		/*
		'pangkat',
		'pendidikan',
		'keterangan',
		'pimpinannama',
		*/
//		array(
//                        'header'=>Yii::t('zii','View'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{view}',
//		),
//		array(
//                        'header'=>Yii::t('zii','Update'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{update}',
//                        'buttons'=>array(
//                            'update' => array (
//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                        ),
//                         ),
//		),
//		array(
//                        'header'=>Yii::t('zii','Delete'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pegawai_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>