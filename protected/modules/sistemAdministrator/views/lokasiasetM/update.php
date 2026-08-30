<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Lokasi Aset</b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Lokasi Aset'=>array('index'),
            $model->lokasi_id=>array('view','id'=>$model->lokasi_id),
            'Ubah',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Update').'  Lokasi Aset ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasiasetM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SALokasiasetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' SALokasiasetM', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lokasi_id))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Lokasi Aset', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php // STANDARD 1 FORM echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model,'garis_latitude'=>$garis_latitude,'garis_longitude'=>$garis_longitude)); ?>
</div>
</div>
<?php
//========= Dialog buat cari data instalasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogInstalasi',
    'options'=>array(
        'title'=>'Instalasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modinstalasi = new SAInstalasiM('search');
$modinstalasi->unsetAttributes();
if(isset($_GET['SAInstalasiM']))
    $modinstalasi->attributes = $_GET['SAInstalasiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modinstalasi->search(),
	'filter'=>$modinstalasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectInstalasi",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namainstalasi').'\").val(\'$data->instalasi_nama\');
                                    $(\'#dialogInstalasi\').dialog(\'close\');return false;"))',
                ),
                'instalasi_nama',
		'instalasi_singkatan',
                'instalasi_lokasi',
                
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
        
<?php
//========= Dialog buat cari data ruangan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Ruangan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modRuangan = new SARuanganM('search');
$modRuangan->unsetAttributes();
if(isset($_GET['SARuanganM']))
    $modRuangan->attributes = $_GET['SARuanganM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saruangan-m-grid',
	'dataProvider'=>$modRuangan->search(),
	'filter'=>$modRuangan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRuangan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namabagian').'\").val(\'$data->ruangan_nama\');
                                    $(\'#dialogRuangan\').dialog(\'close\');return false;"))',
                ),
                'ruangan_nama',
		'ruangan_jenispelayanan',
                'ruangan_lokasi',
                
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>