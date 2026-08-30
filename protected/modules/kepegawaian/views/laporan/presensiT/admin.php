<?php
$this->breadcrumbs = array(
    'Kppresensi Ts' => array('index'),
    'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Presensi ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPresensiT', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Presensi', 'icon' => 'file', 'url' => array('create'))) :  '';

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kppresensi-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
<div class="cari-lanjut search-form">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div>
<!--search-form-->

<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kppresensi-t-grid',
    'dataProvider' => $model->search(),
    //	'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'presensi_id',
        //		array(
        //                        'name'=>'presensi_id',
        //                        'value'=>'$data->presensi_id',
        //                        'filter'=>false,
        //                ),
        'no_fingerprint',
        'pegawai.nomorindukpegawai',
        'pegawai.nama_pegawai',
        'statusscan.statusscan_nama',

        'tglpresensi',
        'statuskehadiran.statuskehadiran_nama',
        'verifikasi',
        //		'pegawai_id',


        /*
		
		'keterangan',
		'jamkerjamasuk',
		'jamkerjapulang',
		'terlambat_mnt',
		'pulangawal_mnt',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
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
        //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->presensi_id"))',
        //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
        //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
        //                                        ),
        //                                        'delete'=> array(
        //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
        //                                        ),
        //                        )
        //		),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php

echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'EXCEL\')'));
$this->widget('UserTips', array('type' => 'admin'));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
function printDetail(caraPrint)
{
    window.open("${urlPrint}/"+$('#kppresensi-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<?php Yii::app()->clientScript->registerScript('onheadfungsi', '
    function updateTable(){
        $.fn.yiiGridView.update("kppresensi-t-grid", {
                    data: $(".search-form form").serialize()
            });
    }
    
    function setAuto(){
        if ($("#atur").is(":checked")){
            atur = $("#atur").val();
        }else{
            atur = 0;
        }
        $.post("' . Yii::app()->createUrl('actionAjax/turnAutoRefresh') . '",{atur:atur},function(data){
        });
    }
    
    function beat(){
        $.post("' . Yii::app()->createUrl('kepegawaian/presensiT/ambilData') . '",{},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
', CClientScript::POS_HEAD); ?>

<?php Yii::app()->clientScript->registerScript('onreadypresensi', "   
    setInterval(function() {
        beat();
    }, 3000);
", CClientScript::POS_READY); ?>