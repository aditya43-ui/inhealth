<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Pengaturan Klasifikasi Sub Sub kelas</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Subkelas'=>array('index'),
	'Manage',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','Manage').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Create').' Asal Rujukan', 'icon'=>'file', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('klasifikasisubsubkelas-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none;background:none;">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
    <!--<h6>Tabel <b>Asal Rujukan</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'klasifikasisubsubkelas-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                 array(
                    'header' => 'No',
                    'value' => '$row+1',
                    ),
                array(
                        'name'=>'klasifikasisubkelas_id',
                        'value'=>'(isset($data->klasifikasisubkelas)? $data->klasifikasisubkelas->klasifikasisubkelas_nama : "")'
                        // function($data){
                        //     return $data->domain ? $data->domain->domain_nama : '';
                        // },
                        // 'filter'=>CHtml::activeDropdownList($model, 'terminologi', LookupM::getItems('idnterminologi'),array('empty'=>'---Pilih---')),
                ),
                'klasifikasisubsubkelas_kode',
                'klasifikasisubsubkelas_nama',
                array(
                    'header'=>'Status',
                    'value'=>'($data->klasifikasisubsubkelas_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:left;'),
                ),
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
                    'update'=>array(
                        'options'=>array('rel'=>'tooltip','title'=>'Ubah Klasifikasi Sub Sub Kelas'),
                    ),
                ),
            ),
		// array(
        //     'header'=>Yii::t('zii','View'),
		// 	'class'=>'bootstrap.widgets.BootButtonColumn',
        //                 'template'=>'{view}'
        //                 // ),
		// ),
		// array(
        //                 'header'=>Yii::t('zii','Update'),
		// 	'class'=>'bootstrap.widgets.BootButtonColumn',
        //                 'template'=>'{update}',
        //                 'buttons'=>array(
        //                     'update'=>array(
        //                         'options'=>array('rel'=>'tooltip','title'=>'Ubah Subkelas'),
        //                     ),
        //                 ),
		// ),
                 array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->klasifikasisubsubkelas_aktif)?CHtml::link("<i class=\'entypo-cancel\'></i> ","javascript:removeTemporary($data->klasifikasisubsubkelas_id)",array("id"=>"$data->klasifikasisubsubkelas_id","rel"=>"tooltip","title"=>"Menonaktifkan Subkelas"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->klasifikasisubsubkelas_id)",array("id"=>"$data->klasifikasisubsubkelas_id","rel"=>"tooltip","title"=>"Hapus Subkelas")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->klasifikasisubsubkelas_id, 1)",array("id"=>"$data->klasifikasisubsubkelas_id","rel"=>"tooltip","title"=>"Mengaktifkan Subkelas"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->klasifikasisubsubkelas_id)",array("id"=>"$data->klasifikasisubsubkelas_id","rel"=>"tooltip","title"=>"Hapus Subkelas"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
	),
	'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			$("table").find("input[type=text]").each(function(){
				cekForm(this);
			})            
		 }',
    )); ?>
<!--</div>-->
<?php 
echo CHtml::link(Yii::t('mds', '{icon} Tambah Klasifikasi Sub Sub Kelas', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#klasifikasisubsubkelas-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#klasifikasisubsubkelas-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('klasifikasisubsubkelas-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
	   });
    }
    
    function addTemporary(id, add){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id, add:add},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('klasifikasisubsubkelas-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
	   });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('klasifikasisubsubkelas-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
    // $('.filters #SAAsalRujukanM_asalrujukan_nama').focus();
</script>
	</div>
	</div>
</div>
</div>