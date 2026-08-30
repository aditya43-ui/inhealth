<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'ripasienapachescore-t-grid', 
    'dataProvider'=>$modApacheScore->searchDetailHasil($pendaftaran_id),
    //'filter'=>$modApacheScore,
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'pasienapachescore_id',
//        array( 
//                        'name'=>'pasienapachescore_id', 
//                        'value'=>'$data->pasienapachescore_id', 
//                        'filter'=>false, 
//                ),
//        'pasien_id',
//        'apachescore_id',
//        'pasienadmisi_id',
//        'ruangan_id',
//        'pegawai_id',
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        'apachescore.varfisiologik_nama',
        'point_nama',
        'point_nilai',
        'point_score',
        /*
        'pendaftaran_id',
        'tglscoring',
        'gagalginjalakut',
        'point_nama',
        'point_nilai',
        'point_score',
        'paramedis_id',
        'catatanapachescore',
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
//                                                'label'=>"<i class='icon-form-silang'></i>", 
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')), 
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pasienapachescore_id"))', 
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