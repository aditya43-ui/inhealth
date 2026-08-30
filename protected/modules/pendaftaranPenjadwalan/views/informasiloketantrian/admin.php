<div class="white-container">
    <?php
    //$this->breadcrumbs=array(
    //	'Ppinformasiloketantrians'=>array('index'),
    //	'Manage',
    //);
    //
    //$arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPInformasiloketantrian ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPInformasiloketantrian', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPInformasiloketantrian', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                
    //$this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('ppinformasiloketantrian-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    //$this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
    ?>
    <legend class="rim2">Informasi Loket <b>Antrian Pasien</b></legend>
    <div class="block-tabel">
        <h6>Tabel Loket <b>Antrian Pasien</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'ppinformasiloketantrian-grid',
            'dataProvider' => $model->searchTable(),
            //	'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                //		'loket_nama',
                array(
                    'header' => 'Nama Loket',
                    'value' => '$data->loket_nama',
                ),
                //		'loket_fungsi',
                //		'antrian_id',
                //		'noantrian',
                array(
                    'header' => 'No. Antrian',
                    'value' => '$data->noantrian',
                ),
                array(
                    'name' => 'tglantrian',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglantrian)',
                ),
                array(
                    'header' => 'Status Pasien',
                    'value' => '$data->statuspasien',
                ),
                //		'statuspasien',
                'no_pendaftaran',
                /*
                            'panggil_flaq',
                            ////'pendaftaran_id',
                            array(
                                    'name'=>'pendaftaran_id',
                                    'value'=>'$data->pendaftaran_id',
                                    'filter'=>false,
                            ),

                            */
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <div class="search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model, 'format' => $format
        )); ?>
    </div>

    <?php

    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    //        $this->widget('UserTips',array('type'=>'admin'));
    //        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    //        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    //
    //$js = <<< JSCRIPT
    //function print(caraPrint)
    //{
    //    window.open("${urlPrint}/"+$('#ppinformasiloketantrian-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //}
    //JSCRIPT;
    //Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>