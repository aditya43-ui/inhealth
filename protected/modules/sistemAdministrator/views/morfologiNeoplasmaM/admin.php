<?php //$this->renderPartial('_tabMenu',array()); ?>
<?php
$this->breadcrumbs=array(
	'Rmmorfologi Neoplasma Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Morfologi Neoplasma ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
               // array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAMorfologineoplasmaM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Morfologi Neoplasma', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#RMMorfologiNeoplasmaM_morfologineoplasma_nama').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rmmorfologi-neoplasma-m-grid', {
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

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rmmorfologi-neoplasma-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'morfologineoplasma_id',
		array(
                        'name'=>'morfologineoplasma_id',
                        'value'=>'$data->morfologineoplasma_id',
                        'filter'=>false,
                ),
		'morfologineoplasma_nama',
		'morfologineoplasma_namalainnya',
		
            array(
                    'header' => 'Status',
                    'value'=>'($data->morfologineoplasma_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//            array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->morfologineoplasma_aktif',
//                ),
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
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                         ),
		),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->morfologineoplasma_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->morfologineoplasma_id)",array("id"=>"$data->morfologineoplasma_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->morfologineoplasma_id)",array("id"=>"$data->morfologineoplasma_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->morfologineoplasma_id)",array("id"=>"$data->morfologineoplasma_id","rel"=>"tooltip","title"=>"Hapus"));',
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
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

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Morfologi Neoplasma', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('morfologiNeoplasmaM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
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
    $("#rmmorfologi-neoplasma-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rmmorfologi-neoplasma-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        var answer = confirm('Yakin akan menonaktifkan data ini untuk sementara?');
            if (answer){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmmorfologi-neoplasma-m-grid');
                            }else{
                                myAlert('Data gagal dinonaktifkan!')
                            }
                },"json");
           }
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        var answer = confirm('Yakin Akan Menghapus Data ini?');
            if (answer){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmmorfologi-neoplasma-m-grid');
                            }else{
                                myAlert('Data gagal dihapus!')
                            }
                },"json");
           }
    }
</script>