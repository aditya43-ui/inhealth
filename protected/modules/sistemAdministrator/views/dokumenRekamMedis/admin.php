<div class="white-container">
    <legend class="rim2">Pengaturan <b>Dokumen Rekam Medis</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadokrekammedis Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sadokrekammedis-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class="block-tabel">
        <h6>Tabel <b>Dokumen Rekam Medis</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sadokrekammedis-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                            'name'=>'dokrekammedis_id',
                            'value'=>'$data->dokrekammedis_id',
                    ),
                    array(
                            'name'=>'warnadokrm_id',
                            'value'=>'$data->warnadok->warnadokrm_namawarna',
                            'filter'=>CHtml::listData($model->getWarnaItems(), 'warnadokrm_id', 'warnadokrm_namawarna'),
                    ),
                    array(
                            'name'=>'subrak_id',
                            'value'=>'isset($data->subrak->subrak_nama)? $data->subrak->subrak_nama : "-"',
                            'filter'=>CHtml::listData($model->getSubrakItems(), 'subrak_id', 'subrak_nama'), 
                    ),
                    array(
                            'name'=>'lokasirak_id',
                            'value'=>'isset($data->lokasirak->lokasirak_nama)? $data->lokasirak->lokasirak_nama : "-"',
                            'filter'=>CHtml::listData($model->getLokasirakItems(), 'lokasirak_id', 'lokasirak_nama'), 
                    ),
                    'nodokumenrm',
                    array(
                            'name'=>'namapasien',
                            'value'=>'isset($data->pasien->namadepan)? $data->pasien->namadepan ." ".$data->pasien->nama_pasien : $data->pasien->nama_pasien',
                            'filter'=>false,
                    ),
                    /*
                    'tglrekammedis',
                    'tglmasukrak',
                    'statusrekammedis',
                    'tglkeluarakhir',
                    'tglmasukakhir',
                    'nomortertier',
                    'nomorsekunder',
                    'nomorprimer',
                    'warnanorm_i',
                    'warnanorm_ii',
                    'tgl_in_aktif',
                    'tglpemusnahan',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan',
                    */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array(),
                             ),
                    ),
    //	RND-5857	link update hanya ada pada modul rekam medis - informasi -	dokumen rekam medis 				
    //		array(
    //			'header'=>Yii::t('zii','Update'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //			'template'=>'{update}',
    //			'buttons'=>array(
    //				'update' => array(),
    //			 ),
    //		),

                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(			
                                    'remove' => array (
                                                    'label'=>"<i class='icon-form-silang'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->dokrekammedis_id))',
                                                    'click'=>'function(){nonActive(this);return false;}',
                                    ),
                                    'delete'=> array(
                                              'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete", array("dokrekammedis_id"=>"$data->dokrekammedis_id","pasien_id"=>"$data->pasien_id"))',
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus' ),

                                    ),
                            )
                    ),		
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Dokumen Rekam Medis',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('sistemAdministrator.views.tips.admin',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sadokrekammedis-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
</div>
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sadokrekammedis-m-grid');
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