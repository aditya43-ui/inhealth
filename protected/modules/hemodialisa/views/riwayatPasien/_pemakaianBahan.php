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
    'id'=>'rjobatalkes-pasien-t-grid', 
    'dataProvider'=>$modPemakaianBahan->searchDetailPemakaianBahan($modPendaftaran->pendaftaran_id), 
    //'filter'=>$model, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'obatalkespasien_id',
        array( 
                        'name'=>'No', 
                        'value'=>'$data->obatalkespasien_id', 
                        'filter'=>false, 
                ),
        'tglpelayanan',
        'obatalkes.jenisobatalkes.jenisobatalkes_nama',
        'obatalkes.obatalkes_nama',
        'qty_oa',
        
//        'penjamin_id',
//        'carabayar_id',
//        'daftartindakan_id',
//        'sumberdana_id',
//        'pasienmasukpenunjang_id',
        /*
        'pasienanastesi_id',
        'pasien_id',
        'satuankecil_id',
        'ruangan_id',
        'tindakanpelayanan_id',
        'tipepaket_id',
        'obatalkes_id',
        'penjualanresep_id',
        'pegawai_id',
        'racikan_id',
        'pendaftaran_id',
        'kelaspelayanan_id',
        'oasudahbayar_id',
        'shift_id',
        'pasienadmisi_id',
        'tglpelayanan',
        'r',
        'rke',
        'permintaan_oa',
        'jmlkemasan_oa',
        'kekuatan_oa',
        'satuankekuatan_oa',
        'qty_oa',
        'hargasatuan_oa',
        'signa_oa',
        'harganetto_oa',
        'hargajual_oa',
        'etiket',
        'jmlexposerad',
        'kontrasrad',
        'biayaservice',
        'biayakonseling',
        'jasadokterresep',
        'biayakemasan',
        'biayaadministrasi',
        'tarifcyto',
        'discount',
        'subsidiasuransi',
        'subsidipemerintah',
        'subsidirs',
        'iurbiaya',
        'oa',
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
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->obatalkespasien_id"))', 
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

