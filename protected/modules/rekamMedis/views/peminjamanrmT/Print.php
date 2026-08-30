
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'rkpeminjamanrm-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
    )); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rkdokumenpasienrmlama-v-grid',
    'dataProvider'=>$model->searchPeminjaman(),
    //'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        //'warnadokrm_id',
        
        //'warnadokrm_kodewarna',
        //'lokasirak_id',
        
        'lokasirak_nama',
        //'nodokumenrm',
        'subrak_nama',
        'warnadokrm_namawarna',
        'no_rekam_medik',
        'pendaftaran.tgl_pendaftaran',
        'no_pendaftaran',
        'nama_pasien',
        'tanggal_lahir',
        'jeniskelamin',
        'alamat_pasien',
        'instalasi_nama',
        'ruangan_nama',
        /*
        'tglrekammedis',
        'pasien_id',
        'no_rekam_medik',
        'tgl_rekam_medik',
        'nama_bin',
        'tempat_lahir',
        'tglmasukrak',
        'statusrekammedis',
        'nomortertier',
        'nomorsekunder',
        'nomorprimer',
        'warnanorm_i',
        'warnanorm_ii',
        'tglkeluarakhir',
        'tglmasukakhir',
        'dokrekammedis_id',
        'ruangan_id',
        'ruangan_nama',
        
        'instalasi_id',
        
        ////'pendaftaran_id',
        array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
        */
//        array(
//                        'header'=>Yii::t('zii','View'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{view}',
//        ),
//        array(
//                        'header'=>Yii::t('zii','Update'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{update}',
//                        'buttons'=>array(
//                            'update' => array (
//                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                        ),
//                         ),
//        ),
//        array(
//                        'header'=>Yii::t('zii','Delete'),
//            'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pendaftaran_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                        ),
//                        )
//        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php $this->endWidget(); ?>