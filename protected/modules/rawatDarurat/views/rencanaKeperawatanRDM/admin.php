<div class="white-container">
    <legend class="rim2">Master Asuhan <b>Keperawatan - Rencana Keperawatan</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <div class="biru">
        <div class="white">
            <?php
            $this->breadcrumbs=array(
                    'Sarencana Keperawatan Ms'=>array('index'),
                    'Manage',
            );

//            $arrMenu = array();
//                            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rencana Keperawatan  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RDRencanaKeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
//                            // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Rencana Keperawatan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//
//            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('sarencana-keperawatan-m-grid', {
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
            <div class="block-tabel">
                <!--<h6>Tabel <b>Rencana Keperawatan</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'sarencana-keperawatan-m-grid',
                    'dataProvider'=>$model->searchData(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            ////'rencanakeperawatan_id',
                            array(
								'name'=>'rencanakeperawatan_id',
								'value'=>'$data->rencanakeperawatan_id',
								'filter'=>false,
                            ),
                             array(
								'name'=>'diagnosakeperawatan_id',
								'filter'=>  CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'),
								'value'=>'$data->diagnosakeperawatan->diagnosakeperawatan_kode',
                            ),
                            'rencana_kode',
                            'rencana_intervensi',
                            'rencana_rasionalisasi',

                            array(
								'header'=>'Kolaborasi Intervensi',
								'class'=>'CCheckBoxColumn',     
								'selectableRows'=>0,
								'id'=>'rows',
								'checked'=>'$data->iskolaborasiintervensi',
                            ),
                            array(
								'header'=>Yii::t('zii','View'),
								'class'=>'bootstrap.widgets.BootButtonColumn',
								'template'=>'{view}',
								'buttons'=>array(
									'view' => array (
												  'options'=>array('title'=>'Lihat Rencana Keperawatan'),
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
												  'options'=>array('title'=>'Ubah Rencana Keperawatan'),
												),
								 ),
                            ),
                            array(
								'header'=>Yii::t('zii','Delete'),
								'class'=>'bootstrap.widgets.BootButtonColumn',
								'template'=>'{remove} {delete}',
								'buttons'=>array(
									'remove' => array (
											'label'=>"<i class='icon-form-sampah'></i>",
											'options'=>array('title'=>'Menonaktifkan Rencana Keperawatan'),
											'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->rencanakeperawatan_id"))',
											'visible'=>'($data->iskolaborasiintervensi && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
											'click'=>'function(){ removeTemporary(this); return false;}',
									),
									'delete'=> array(
											'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
											'options'=>array('title'=>'Hapus Rencana Keperawatan'),
									),
								)
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
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Rencana Keperawatan',array('{icon}'=>'<i class="icon-plus icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
                                array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'create','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sarencana-keperawatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sarencana-keperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
function removeTemporary(obj){
    var url = $(obj).attr('href');
    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
        if (r){
             $.ajax({
                type:'GET',
                url:url,
                data: {},
                dataType: "json",
                success:function(data){
                    if(data.status == 'proses_form'){
                        $.fn.yiiGridView.update('sarencana-keperawatan-m-grid');
                    }else{
                        myAlert('Data gagal dinonaktifkan!.')
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
       }
   });
}
$(document).ready(function(){
    $('input[name="RDRencanaKeperawatanM[rencana_kode]"]').focus();
})
</script>
