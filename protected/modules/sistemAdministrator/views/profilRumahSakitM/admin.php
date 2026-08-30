<div class="white-container">
    <legend class="rim2">Pengaturan <b>Profile Rumah Sakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Saprofil Rumah Sakit Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Profile Rumah Sakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Profile Rumah Sakit', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Profile Rumah Sakit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('saprofil-rumah-sakit-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class='block-tabel'>
        <h6>Tabel Profile <b>Rumah Sakit</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'saprofil-rumah-sakit-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'profilrs_id',
                    array(
                            'header'=>'ID',
                            'value'=>'$data->profilrs_id',
                    ),
                    'nama_rumahsakit',
                    'alamatlokasi_rumahsakit',
                    'website',
                    'email',
                    'no_telp_profilrs',
                /*
                    'tahunprofilrs',
                    'kodejenisrs_profilrs',
                    'jenisrs_profilrs',
                    'statusrsswasta',
                    'namakepemilikanrs',

                    'kodestatuskepemilikanrs',
                    'statuskepemilikanrs',
                    'pentahapanakreditasrs',
                    'statusakreditasrs',
                    'nokode_rumahsakit',
                    'nama_rumahsakit',
                    'kelas_rumahsakit',
                    'namadirektur_rumahsakit',
                    'alamatlokasi_rumahsakit',
                    'nomor_suratizin',
                    'tgl_suratizin',
                    'oleh_suratizin',
                    'sifat_suratizin',
                    'masaberlakutahun_suratizin',
                    'motto',
                    'visi',
                    'no_faksimili',
                    'logo_rumahsakit',
                    'path_logorumahsakit',
                    'npwp',
                    'tahun_diresmikan',
                    'nama_kepemilikanrs',
                    'status_kepemilikanrs',
                    'khususuntukswasta',
                    'website',
                    'email',
                    'no_telp_profilrs',
                    * 

                    array(
                            'header'=>Yii::t('zii','Print'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{print}',
                            'buttons'=>array(
                                'print' => array
                                (
                                    'label'=>"<i class='entypo-print'></i>",
                                    'visible'=>'((Yii::app()->user->checkAccess("Admin")) ? true: false)',
                                    'click'=>'function(){dialog_print(\'$data->profilrs_id\');}',
                                ),
                             ),
                        ),
                  */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                            'update' => array(
                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                             ),
                                            ),
                    ),
    //            array(
    //                      'header'=>'Hapus',
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                      'template'=>'{remove}{delete}',
    //                      'buttons'=>array(
    //                      'remove' => array
    //                        (
    //                            'label'=>"<i class='icon-form-silang'></i>",
    //                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
    //                             'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->propinsi_id"))',
    //                             'visible'=>'($data->propinsi_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                            'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
    //                        ),
    //                      'delete' => array
    //                        (
    //                             'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
    //                        ),
    //                                                              

                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                            'delete'=> array(
    //                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                'visible'=>'($data->profilrs_id!='.Params::getDefaultProfilRS().' && Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)) ? TRUE : FALSE',   
                                         ),
                             ),
                        ),
            ),
           'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
    <?php 
    //=========================Dialog Print=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'print_rs',
        'options'=>array(
            'title'=>'Pilih Cara Print',
            'autoOpen'=>false,
            'width'=>300,
            'height'=>100,
            'modal'=>'true',
            'hide'=>'explode',
            'resizelable'=>false,
        ),
    ));
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRS(\'PDF\')'))."&nbsp&nbsp" :  '' ;
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRS(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printRS(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
                echo CHtml::textField('profilrs_id');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //=========================Akhir Dialog Print===================================

                echo CHtml::link(Yii::t('mds', '{icon} Tambah Profile Rumah Sakit', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
                echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
            $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//

$js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#sajenis-profilrumahsakit-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
    function dialog_print(obj)
    {
                myAlert(obj);
        $('#print_rs').dialog('open'); 
    }    
    function print(obj)
    {
        window.open("${urlPrint}/"+$('#sajenis-profilrumahsakit-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
    
    function printRS(obj)
    {
        window.open("${urlPrint}/"+$('#sajenis-profilrumahsakit-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>