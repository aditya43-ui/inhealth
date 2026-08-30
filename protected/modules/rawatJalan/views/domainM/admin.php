<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Pengaturan Domain</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Domain'=>array('index'),
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
	$.fn.yiiGridView.update('domain-m-grid', {
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
	'id'=>'domain-m-grid',
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
                        'name'=>'terminologi',
                        'value'=>'$data->terminologi',
                        'filter'=>CHtml::activeDropdownList($model, 'terminologi', LookupM::getItems('idnterminologi'),array('empty'=>'---Pilih---')),
                ),
                'domain_kode',
                'domain_kelas',
                'domain_nama',
                array(
                    'header'=>'Status',
                    'value'=>'($data->domain_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                        'options'=>array('rel'=>'tooltip','title'=>'Ubah Domain'),
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
        //                         'options'=>array('rel'=>'tooltip','title'=>'Ubah Domain'),
        //                     ),
        //                 ),
		// ),
                 array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->domain_aktif)?CHtml::link("<i class=\'entypo-cancel\'></i> ","javascript:removeTemporary($data->domain_id)",array("id"=>"$data->domain_id","rel"=>"tooltip","title"=>"Menonaktifkan Domain"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->domain_id)",array("id"=>"$data->domain_id","rel"=>"tooltip","title"=>"Hapus Domain")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->domain_id, 1)",array("id"=>"$data->domain_id","rel"=>"tooltip","title"=>"Mengaktifkan Domain"))." ".CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->domain_id)",array("id"=>"$data->domain_id","rel"=>"tooltip","title"=>"Hapus Domain"));',
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
echo CHtml::link(Yii::t('mds', '{icon} Tambah Domain', array('{icon}'=>'<i class="entypo-plus"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
    $("#domain-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#domain-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('domain-m-grid');
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
                                $.fn.yiiGridView.update('domain-m-grid');
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
                                $.fn.yiiGridView.update('domain-m-grid');
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