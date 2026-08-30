<?php
$this->breadcrumbs=array(
	'Saruangan Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tindakan Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tindakan Ruangan', 'icon'=>'file', 'url'=>yii::app()->createAbsoluteUrl('rawatJalan/ruanganM/createDaftarTindakan'))) :  '' ;
       
$this->menu=$arrMenu;

   $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
   $module = Yii::app()->controller->module->id;
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saruangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<legend class='rim'>Tabel Tindakan Ruangan</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saruangan-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'ruangan_id',
//		array(
//                        'name'=>'ruangan_id',
//                        'value'=>'$data->ruangan_id',
//                        'filter'=>false,
//              ),
		array(
                        'header'=>'Nama Ruangan',
                        'name'=>'ruangan_nama',
                        'value'=>'$data->ruangan->ruangan_nama',
              ),
		array(
                        'header'=>'Kategori Tindakan',
                        'name'=>'kategoritindakan_nama',
                        'value'=>'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
              ),
		array(
                        'header'=>'Kode Tindakan',
                        'name'=>'daftartindakan_kode',
                        'value'=>'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
              ),
		array(
                        'header'=>'Uraian Tindakan',
                        'name'=>'daftartindakan_nama',
                        'value'=>'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
              ),
              array(
                        'header'=>'Tarif',
                        'name'=>'harga_tariftindakan',
                        'value'=>'number_format(isset($data->daftartindakan->harga_tariftindakan)?$data->daftartindakan->harga_tariftindakan:0)',
                        'filter'=>true,
              ),
                array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                                'view' => array(
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->ruangan_id"))',
                                        'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Tindakan Ruangan' ),
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
                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Tindakan Ruangan' ),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->ruangan_id"))',
//                                                'visible'=>'($data->dtd_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
//                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                        ),
                        )
		),
                array(
                        'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                            // 'remove' => array
                            //     (
                            //         'label'=>"<i class='icon-remove'></i>",
                            //         'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Tindakan Ruangan' ),
                            //         'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->ruangan_id"))',
                            //         'visible'=>'($data->ruangan_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE) ? true: false)',
                            //         'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                            //     ),
                      
                        'delete'=> array(
                                    'label'=>"<i class='icon-remove'></i>",
                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Tindakan Ruangan' ),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->ruangan_id"))',
                                    // 'visible'=>'($data->ruangan_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE) ? true: false)',
                                     'click'=>'function(){ removeTemporary(this); return false;}',
                                    ),
                         ),
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
 
            echo CHtml::link(Yii::t('mds','{icon} Tambah Tindakan Ruangan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
                                    array('class' => 'btn btn-danger',));
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
            // echo CHtml::link(Yii::t('mds','{icon} Tambah Tindakan Ruangan',array('{icon}'=>'<i class="icon-file icon-white"></i>')), 
            //                         Yii::app()->createUrl($this->module->id.'/RuanganM/create'), 
            //                         array('class'=>'btn btn-success'));

            $content = $this->renderPartial('../tips/master2',array(),true);
            $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
          //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#saruangan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
function removeTemporary(obj){
    var url = $(obj).attr('href');
    myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
        if (r){
             $.ajax({
                type:'GET',
                url:url,
                data: {},
                dataType: "json",
                success:function(data){
                    if(data.status == 'proses_form'){
                        $.fn.yiiGridView.update('sadiagnosa-m-grid');
                    }else{
                        myAlert('Data Gagal di Nonaktifkan.')
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
       }
   });
}
$(document).ready(function(){
    $( "input[name='HDRuanganM[ruangan_nama]']" ).focus();
});
</script>