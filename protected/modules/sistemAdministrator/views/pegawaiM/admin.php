<div class="white-container">
    <legend class="rim2">Pengaturan <b>Pegawai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapegawai Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pegawai', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pegawai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAPegawaiM_nomorindukpegawai').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapegawai-m-grid', {
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
        <h6>Tabel <b>Pegawai</b></h6>
        <?php 
        $cekedarray = array(
                                                'remove' => array (
                                                        'label'=>"<i class='icon-form-silang'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->pegawai_id"))',
                                                        //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                        'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                )
                );
        $uncekedarray = array(
                                                'remove' => array (
                                                        'label'=>"test",
                                                        'options'=>array('title'=>Yii::t('mds','Unremove Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/unremoveTemporary",array("id"=>"$data->pegawai_id"))',
                                                        //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                                        'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                )
                );
        $rd = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif'=>'true',
            ), array(
                'order'=>'ruangan_nama',
            )), 'ruangan_id', 'ruangan_nama');
            $rd['V'] = 'Tidak diset';
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'sapegawai-m-grid',
                'dataProvider'=>$model->searchSA(),
                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        ////'pegawai_id',
                        array(
                                'name'=>'pegawai_id',
                                'value'=>'$data->pegawai_id',
                                'filter'=>false,
                        ),
                array(
                                'header'=>'Nama Lengkap',
                                'name'=>'nama_pegawai',
                                'value'=>'$data->namalengkap',
                                // 'filter'=>false,
                        ),
                        // 'namalengkap',
                        'nomorindukpegawai',
                        'no_kartupegawainegerisipil',
                        array(
                             'name'=>'ruangan',
                             'type'=>'raw',
                             'value'=>'$this->grid->getOwner()->renderPartial(\'_ruanganPegawai\',array(\'pegawai_id\'=>$data->pegawai_id),true)',
                             'filter'=>  CHtml::activeDropDownList($model, 'ruangan_id', $rd, array('empty'=>'-- Pilih --')),
                        ),
        //        	array(
        //                        'header'=>'Aktif',
        //                        'class'=>'CCheckBoxColumn',     
        //                        'selectableRows'=>0,
        //                        'id'=>'rows',
        //                        'checked'=>'$data->pegawai_aktif',
        //                ), 
        //            array(
        //                        'header'=>'aktif',
        //			'class'=>'bootstrap.widgets.BootButtonColumn',
        //                        'template'=>'{remove} {delete} {unremove}',
        //                        'buttons'=>'($data->pegawai_aktif)? "$cekedarray" : "$uncekedarray"',
        //                ),
                    array(
                            'header' => 'Status',
                            'value'=>'($data->pegawai_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
        /*                array(
                            'header'=>'Aktif',
        //                    'class'=>'CCheckBoxColumn',
        //                    'selectableRows'=>,
        ////                    'value'=>'$data->pegawai_aktif',
        //                    'checked'=>'$data->pegawai_aktif',
                                'value'=>'CHtml::checkBox("SAPegawaiM[pegawai_id][]", $data->pegawai_aktif, array("value"=>$data->pegawai_id,"id"=>"checkbox_".$data->pegawai_id,"class"=>"inputFormTabel span2","onclick"=>"rubahChekbox($data->pegawai_id);"))',
                                'type'=>'raw',  
        //                        'value'=>'CHtml::checkBox("SAPegawaiM[pegawai_id][]",$data->pegawai_aktif)',
        //                        'value'=>'CHtml::checkBox("pegawai_aktif",$data->pegawai_aktif)',
                        ), 
         */

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
                                'header'=>Yii::t('zii','Delete'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{remove} {delete}',
                                'buttons'=>array(

                                        'remove' => array (
                                                        'label'=>"<i class='icon-form-silang'></i>",
                                                        'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>$data->pegawai_id))',
                                                        'click'=>'function(){removeTemporary(this);return false;}',
                                        ),
                                        'delete'=> array(),
                                )
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
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Pegawai', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $urlAktif = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/UnremoveTemporary');
    $urlNonAktif = Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/RemoveTemporary');

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sapegawai-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
var checkbox = $('#checkbox').val();
function rubahChekbox(id){
   idpegawai = $('#checkbox').val();
   if($('#checkbox_'+id).is(':checked')){
    pesan = confirm('Apakah Anda akan mengaktifkan data ini?');
    if(pesan){
         jQuery.ajax({'url':'<?php echo $urlAktif; ?>',
                 'data':{id:id},
                 'type':'get',
                 'dataType':'json',
                 'success':function(data) {
//                   myAlert('Data berhasil di rubah');   
//                    location.reload(true);

                 } ,
                 'cache':false}); 
    }else{
        location.reload();
    }
//    myAlert(6);
   }else{
    pesan = confirm('Apakah Anda akan menonaktifkan data ini?');
    if(pesan){
         jQuery.ajax({'url':'<?php echo $urlNonAktif; ?>',
                 'data':{id:id},
                 'type':'get',
                 'dataType':'json',
                 'success':function(data) {
//                        location.reload(true);
                 } ,
                 'cache':false}); 
    }else{
        location.reload();
    }
//        myAlert(5);
   }
}
function removeTemporary(obj){
	myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
		function(r){
			if(r){ 
				$.ajax({
					type:'GET',
					url:obj.href,
					data: {},//
					dataType: "json",
					success:function(data){
						$.fn.yiiGridView.update('sapegawai-m-grid');
						if(data.sukses > 0){

						}else{
							myAlert('Data gagal dinonaktifkan!');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
				});
			}
		}
	);
	return false;
}
</script>