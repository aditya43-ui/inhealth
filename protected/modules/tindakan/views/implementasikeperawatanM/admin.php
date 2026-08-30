<?php //$this->renderPartial('_tabMenu',array()); ?>
<?php
$this->breadcrumbs=array(
	'Saimplementasikeperawatan Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Implementasi Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Implementasi Keperawatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saimplementasikeperawatan-m-grid', {
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
    <!--<h6>Tabel <b>Implementasi Keperawatan</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saimplementasikeperawatan-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'implementasikeperawatan_id',
		array(
                        'name'=>'implementasikeperawatan_id',
                        'value'=>'$data->implementasikeperawatan_id',
                        'filter'=>false,
                ),
		array(
                        'name'=>'diagnosakeperawatan_id',
                        'filter'=>  CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'),
                        'value'=>'$data->diagnosakeperawatan->diagnosakeperawatan_kode',
                ),
		array(
                        'name'=>'rencanakeperawatan_id',
                        'filter'=>  CHtml::listData($model->RencanaKeperawatanItems, 'rencanakeperawatan_id', 'rencana_kode'),
                        'value'=>'$data->rencanakeperawatan->rencana_kode',
                ),
		'implementasikeperawatan_kode',
		'implementasi_nama',
		
                array(
                        'header'=>'Kolaborasi implementasi',
                        'class'=>'CCheckBoxColumn',     
                        'selectableRows'=>0,
                        'id'=>'rows',
                        'checked'=>'$data->iskolaborasiimplementasi',
                ),
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                         'buttons'=>array(
                            'view' => array(
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Implementasi Keperawatan' ),
                                        ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Implementasi Keperawatan' ),
                                        ),
                         ),
		),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->iskolaborasiimplementasi)? CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->implementasikeperawatan_id)",array("id"=>"$data->implementasikeperawatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Implementasi Keperawatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->implementasikeperawatan_id)",array("id"=>"$data->implementasikeperawatan_id","rel"=>"tooltip","title"=>"Hapus Implementasi Keperawatan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->implementasikeperawatan_id)",array("id"=>"$data->implementasikeperawatan_id","rel"=>"tooltip","title"=>"Hapus Implementasi Keperawatan"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width: 100px;'),
                ),
//		array(
//                        'header'=>Yii::t('zii','Delete'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{remove} {delete}',
//                        'buttons'=>array(
//                                        'remove' => array (
//                                                'label'=>"<i class='icon-form-silang'></i>",
//                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->implementasikeperawatan_id"))',
//                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
//                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Menonaktifkan Implementasi Keperawatan' ),
//                                        ),
//                                        'delete'=> array(
//                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
//                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Implementasi Keperawatan' ),
//                                        ),
//                        )
//		),
	),
       'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
    )); ?>
</div>
<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Implementasi Keperawatan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('implementasikeperawatanM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
         $content = $this->renderPartial('../tips/master',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#saimplementasikeperawatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saimplementasikeperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('saimplementasikeperawatan-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('saimplementasikeperawatan-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Rencana Keperawatan atau Master Implementasi Keperawatan.');
                            }
                },"json");
           }
        });
    }

    $(document).ready(function(){
        $('input[name="RJImplementasikeperawatanM[implementasikeperawatan_kode]"]').focus();
    });
</script>