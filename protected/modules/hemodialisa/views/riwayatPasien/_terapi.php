<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjpenjualanresep-t-grid', 
    'dataProvider'=>$modDetailTerapi->searchDetailTerapi($modPendaftaran->pendaftaran_id), 
    'filter'=>$model, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'penjualanresep_id',
//        array( 
//                'name'=>'No', 
//                'value'=>'$data->penjualanresep_id', 
//                'filter'=>false, 
//        ),
        array(
            'header'=>'Ruangan',
            'value'=>'$data->ruangan->ruangan_nama'
        ),
        'tglpenjualan',
//        'detailresep.obatalkes_id',
        array(
            'header'=>'Obat Alkes',
            'type'=>'raw',
//            'value'=>'$this->grid->getOwner()->renderPartial(\'/riwayatPasien/_terapi_obatalkes_column\',array(\'data\'=>$data),true)',
            'value'=>'$this->grid->getOwner()->renderPartial(\'/riwayatPasien/_terapi_obatalkes_column\',array(\'data\'=>$data->getObatTerapi($data->penjualanresep_id)),true)',
        ),
//        'reseptur_id',
//        'pasienadmisi_id',
//        'penjamin_id',
//        'carabayar_id',
//        'pendaftaran_id',
        /*
        'ruangan_id',
        'pegawai_id',
        'kelaspelayanan_id',
        'pasien_id',
        'tglpenjualan',
        'jenispenjualan',
        'tglresep',
        'noresep',
        'totharganetto',
        'totalhargajual',
        'totaltarifservice',
        'biayaadministrasi',
        'biayakonseling',
        'pembulatanharga',
        'jasadokterresep',
        'instalasiasal_nama',
        'ruanganasal_nama',
        'discount',
        'subsidiasuransi',
        'subsidipemerintah',
        'subsidirs',
        'iurbiaya',
        'lamapelayanan',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
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
//                                                'label'=>"<i class='icon-remove'></i>", 
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')), 
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->penjualanresep_id"))', 
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