<?php
$this->breadcrumbs=array(
	'Saruangan Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tindakan Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
              //  (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tindakan Ruangan', 'icon'=>'file', 'url'=>yii::app()->createAbsoluteUrl('rawatJalan/ruanganM/createDaftarTindakan'))) :  '' ;
       
$this->menu=$arrMenu;

   $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
   $module = Yii::app()->controller->module->id;
Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saruangan-m-grid', {
		data: $(this).serialize()
	});        
	return false;
});
$('.filters #RINRuanganM_ruangan_nama').focus();
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!--search-form-->

<legend class="rim">Tabel Tindakan Ruangan</legend>
<?php 
//Filter Grid
$model = new RINRuanganM('searchInformasi');
$model->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['RINRuanganM'])){
    $model->attributes = $_GET['RINRuanganM'];
    $model->ruangan_nama = $_GET['RINRuanganM']['ruangan_nama'];
    $model->kategoritindakan_nama = $_GET['RINRuanganM']['kategoritindakan_nama'];
    $model->daftartindakan_kode = $_GET['RINRuanganM']['daftartindakan_kode'];
    $model->daftartindakan_nama = $_GET['RINRuanganM']['daftartindakan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saruangan-m-grid',
	'dataProvider'=>$model->searchInformasi(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'header'=>'Nama Ruangan',
                        'name'=>'ruangan_nama',
                        'value'=>'(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "")',
                        'filter'=>  CHtml::activeTextField($model,'ruangan_nama'),
              ),
		array(
                        'header'=>'Kategori Tindakan',
                        'name'=>'kategoritindakan_nama',
                        'value'=>'(isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama) ? $data->daftartindakan->kategoritindakan->kategoritindakan_nama : "")',
                        'filter'=>  CHtml::activeTextField($model,'kategoritindakan_nama'),
              ),
		array(
                        'header'=>'Kode Tindakan',
                        'name'=>'daftartindakan_kode',
                        'value'=>'(isset($data->daftartindakan->daftartindakan_kode) ? $data->daftartindakan->daftartindakan_kode : "")',
                        'filter'=>  CHtml::activeTextField($model,'daftartindakan_kode'),
              ),
		array(
                        'header'=>'Uraian Tindakan',
                        'name'=>'daftartindakan_nama',
                        'value'=>'(isset($data->daftartindakan->daftartindakan_nama) ? $data->daftartindakan->daftartindakan_nama : "")',
                        'filter'=>  CHtml::activeTextField($model,'daftartindakan_nama'),
              ),
              array(
                        'header'=>'Tarif',
                        'name'=>'harga_tariftindakan',
                        'value'=>'(isset($data->daftartindakan->daftartindakan->harga_tariftindakan) ? number_format($data->daftartindakan->daftartindakan->harga_tariftindakan) : "Tidak di set")',
                        'filter'=>true,
              ),
//              array(
//                        'header'=>'Tarif',
//                        'name'=>'daftartindakan_nama',
//                        'value'=>'$data->daftartindakan->daftartindakan_nama',
//                        'filter'=>false,
//              ),
//             array(
//                        'name'=>'instalasi_id',
//                        'filter'=>  CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
//                        'value'=>'$data->instalasi->instalasi_nama',
//                ),
//	'ruangan_nama',
//		'ruangan_lokasi',
//                 array(
//                     'header'=>'Kasus Penyakit',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kasusPenyakit\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                     'filter'=>(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>'.Yii::t('mds','Create'), Yii::app()->createUrl($module.'/'.$controller.'/createJenisKasusPenyakit') ) : '',
//                ),
//                array(
//                     'header'=>'Kelas Pelayanan',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kelasPelayanan\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                     'filter'=>(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>'.Yii::t('mds','Create'), Yii::app()->createUrl($module.'/'.$controller.'/createKelasRuangan') ) : '',
//                ), 
//                array(
//                     'header'=>'Daftar Tindakan',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_daftarTindakan\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                     //'filter'=>(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>'.Yii::t('mds','Create'), Yii::app()->createUrl($module.'/'.$controller.'/createDaftarTindakan') ) : '',
//
//                ),
//                array(
//                     'header'=>'Pegawai',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_ruanganPegawai\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                     'filter'=>(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>'.Yii::t('mds','Create'), Yii::app()->createUrl($module.'/'.$controller.'/createPegawaiRuangan') ) : '',
//                ),  
//                 array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->ruangan_aktif',
//                ), 
                array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(                            
                            'view'=>array(
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->ruangan_id"))',
                                'options'=>array('rel'=>'tooltip','title'=>'Lihat Tindakan Ruangan'),
                            ),
                        ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                                        'update' => array (
                                                'label'=>"<i class='icon-update'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->ruangan_id"))',
//                                                'visible'=>'($data->dtd_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                'options'=>array('rel'=>'tooltip','title'=>'Ubah Tindakan Ruangan'),
                                        ),
                        )
		),
                array(
                        'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                            'remove' => array
                            (
                                'label'=>"<i class='icon-form-silang'></i>",
                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->ruangan_id"))',
                                'visible'=>'($data->ruangan_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE) ? true: false)',
                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                            ),
                      
                        'delete'=> array(
                                     'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                     'options'=>array('rel'=>'tooltip','title'=>'Hapus Tindakan Ruangan'),
                                     ),
                         ),
                    ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
 
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Tindakan Ruangan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/rawatInap/ruanganM/createDaftarTindakan',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
            $content = $this->renderPartial('../tips/master2',array(),true);
            $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
          //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>