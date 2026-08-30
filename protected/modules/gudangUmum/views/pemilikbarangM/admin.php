<?php $this->renderPartial('_tabMenu',array()); ?>
<?php
$this->breadcrumbs=array(
	'Sapemilikbarang Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pemilik Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPemilikbarangM', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pemilik Barang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#SAPemilikbarangM_pemilikbarang_kode').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemilikbarang-m-grid', {
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
<legend class="rim">Tabel Pemilik Barang</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sapemilikbarang-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                        'name'=>'pemilikbarang_id',
                        'value'=>'$data->pemilikbarang_id',
                        'filter'=>false,
                ),
		array(
                    'name'=>'pemilikbarang_kode',
                    'value'=>'$data->pemilikbarang_kode',
                    'filter'=>CHtml::activeTextField($model, 'pemilikbarang_kode'),
                ),
		'pemilikbarang_nama',
		'pemilikbarang_namalainnya',
                 array(
                    'header' => 'Status',
                    'value'=>'($data->pemilikbarang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//		array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->pemilikbarang_aktif',
//                ),
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                        'view'=>array(
                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Pemilik Barang'),
                        ),
                    ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                'options'=>array('rel'=>'tooltip','title'=>'Ubah Pemilik Barang'),
                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                            ),
                         ),
		),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->pemilikbarang_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Menonaktifkan Pemilik Barang"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Hapus Pemilik Barang")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pemilikbarang_id)",array("id"=>"$data->pemilikbarang_id","rel"=>"tooltip","title"=>"Hapus Pemilik Barang"));',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
	),
       'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
)); ?>

<?php 
echo CHtml::link(Yii::t('mds', '{icon} Tambah Pemilik Barang', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/gudangUmum/pemilikbarangM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
$content = $this->renderPartial('../tips/master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sapemilikbarang-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemilikbarang-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapemilikbarang-m-grid');
                            }else{
                                myAlert('Data gagal dinonaktifkan!')
                            }
                },"json");
           }
        });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapemilikbarang-m-grid');
                            }else{
                                myAlert('Data gagal dihapus!')
                            }
                },"json");
           }
       });
    }
    $('.filters #SAPemilikbarangM_pemilikbarang_kode').focus();
</script>