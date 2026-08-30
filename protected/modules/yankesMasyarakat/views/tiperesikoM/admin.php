<?php
$this->breadcrumbs=array(
	'Tipe Resiko Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tiperesiko-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Pengaturan <b> Tipe Risiko </b> </div>
        </div>
        <div class="panel-body">
            

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
	</div>
	<div class="block-tabel">
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'tiperesiko-m-grid',
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
                            'header' => 'Nama',
                            'name' => 'tiperesiko_nama',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_nama)){
                                    return $data->tiperesiko_nama;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'tiperesiko_nama',array('class' => 'span3'))
                        ),
                        array(
                            'header' => 'Nama Lain',
                            'name' => 'tiperesiko_namalain',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_namalain)){
                                    return $data->tiperesiko_namalain;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'tiperesiko_namalain',array('class' => 'span3'))
                        ),
                        array(
                            'header' => 'Kode',
                            'name' => 'tiperesiko_kode',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_kode)){
                                    return $data->tiperesiko_kode;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'tiperesiko_kode',array('class' => 'span3'))
                        ),
                        array(
                            'header' => 'Keterangan',
                            'name' => 'tiperesiko_keterangan',
                            'value' => function($data){
                                if(!empty($data->tiperesiko_keterangan)){
                                    return $data->tiperesiko_keterangan;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'tiperesiko_keterangan',array('class' => 'span3'))
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->tiperesiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                        ),
			array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array(),
                             ),
			),
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			array(
                            'header'=>'Hapus',
                            'type'=>'raw',
                            'value' => function($data){
                                    if($data->tiperesiko_aktif == true){
                                      return CHtml::link("<i class='glyphicon glyphicon-remove'></i> ","javascript:removeTemporary($data->tiperesiko_id)",array("id"=>"$data->tiperesiko_id","data-placement"=>"left","rel"=>"tooltip","title"=>"Menonaktifkan Tipe Risiko")).' '.CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->tiperesiko_id)",array("id"=>"$data->tiperesiko_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Hapus Tipe Risiko"));  
                                    }else{
                                      return CHtml::link("<i class='glyphicon glyphicon-check'></i> ","javascript:aktifkan($data->tiperesiko_id)",array("class"=>'hover',"id"=>"$data->tiperesiko_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Mengaktifkan Tipe Risiko")).' '.CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->tiperesiko_id)",array("id"=>"$data->tiperesiko_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Hapus Tipe Risiko"));
                                    }
                            },
                                            ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Tipe Risiko',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial($this->path_tips . 'master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#tiperesiko-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
    </div>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('tiperesiko-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
        });
    }
    
    function aktifkan(id){
        var url = '<?php echo $url."/aktifkan"; ?>';
        myConfirm('Yakin akan mengaktifkan data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('tiperesiko-m-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
                            }
                },"json");
           }
        });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('tiperesiko-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
</script>