<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pengaturan Jenis <b>Tindakan Rehabilitasi Medis</b>
        </div>
    </div>
    <div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Rmjenis Tindakanrm Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Tindakan ', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#rmjenis-tindakanrm-m-search').submit(function(){
	$.fn.yiiGridView.update('rmjenis-tindakanrm-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form cari-lanjut2" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<hr/>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Jenis <b>Tindakan Rehabilitasi Medis</b></div>
    </div>
    <div class="panel-body">
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rmjenis-tindakanrm-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'jenistindakanrm_id',
		// array(
  //                       'name'=>'jenistindakanrm_id',
  //                       'value'=>'$data->jenistindakanrm_id',
  //                       'filter'=>false,
  //               ),
		'jenistindakanrm_nama',
		'jenistindakanrm_namalainnya',
        array(
			'header'=>'<center>Status</center>',
			'value'=>'($data->jenistindakanrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
			'htmlOptions'=>array('style'=>'text-align:center;'),
        ),
		array(
			'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{view}',
			 'buttons'=>array(
				'view'=>array(
					'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Jenis Tindakan' ),
				),
			),
		),
		array(
			'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{update}',
			'buttons'=>array(
				'update' => array (
					
					'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Jenis Tindakan' ),
				),
			 ),
		),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->jenistindakanrm_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->jenistindakanrm_id)",array("id"=>"$data->jenistindakanrm_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Tindakan"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->jenistindakanrm_id)",array("id"=>"$data->jenistindakanrm_id","rel"=>"tooltip","title"=>"Hapus Jenis Tindakan")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->jenistindakanrm_id)",array("id"=>"$data->jenistindakanrm_id","rel"=>"tooltip","title"=>"Hapus Jenis Tindakan"));',
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),

        ),
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
)); ?>
</div>
</div>
<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Tindakan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
		$content = $this->renderPartial('sistemAdministrator.views.tips.master',array(),true);
		$this->widget('UserTips',array('type'=>'admin','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         
        function cekForm(obj)
{
    $("#rmjenis-tindakanrm-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rmjenis-tindakanrm-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                    function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmjenis-tindakanrm-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmjenis-tindakanrm-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Tindakan.');
                            }
                },"json");
            }
        }); 
    }

$(document).ready(function(){
    $('input[name="RMJenisTindakanrmM[jenistindakanrm_nama]"]').focus();
})

</script>
</div>
    </div>
    