<?php
$this->breadcrumbs=array(
	'Detectability Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('detectability-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title"> Pengaturan <b> Detectability </b> </div>
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
		'id'=>'detectability-m-grid',
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
                            'header' => 'Bobot',
                            'name' => 'detectability_bobot',
                            'value' => function($data){
                                if(!empty($data->detectability_bobot)){
                                    return $data->detectability_bobot;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'detectability_bobot',array('class' => 'span3'))
                        ),
                        array(
                            'header' => 'Deskripisi',
                            'name' => 'detectability_deskripsi',
                            'value' => function($data){
                                if(!empty($data->detectability_deskripsi)){
                                    return $data->detectability_deskripsi;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'detectability_deskripsi',array('class' => 'span3'))
                        ),
                        array(
                            'header' => 'Kemungkinan Deteksi',
                            'name' => 'detectability_kemungkinan',
                            'value' => function($data){
                                if(!empty($data->detectability_kemungkinan)){
                                    return $data->detectability_kemungkinan;
                                }else{
                                    return '-';
                                }
                            },
                            'filter' => Chtml::activeTextField($model,'detectability_kemungkinan',array('class' => 'span3'))
                        ),
                        array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->detectability_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                                    if($data->detectability_aktif == true){
                                      return CHtml::link("<i class='glyphicon glyphicon-remove'></i> ","javascript:removeTemporary($data->detectability_id)",array("id"=>"$data->detectability_id","data-placement"=>"left","rel"=>"tooltip","title"=>"Menonaktifkan Detectability")).' '.CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->detectability_id)",array("id"=>"$data->detectability_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Hapus Detectability"));  
                                    }else{
                                      return CHtml::link("<i class='glyphicon glyphicon-check'></i> ","javascript:aktifkan($data->detectability_id)",array("class"=>'hover',"id"=>"$data->detectability_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Mengaktifkan Detectability")).' '.CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->detectability_id)",array("id"=>"$data->detectability_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Hapus Detectability"));
                                    }
                            },
                                            ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
</div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Detectability',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
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
    window.open("${urlPrint}/"+$('#detectability-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('detectability-m-grid');
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
                                $.fn.yiiGridView.update('detectability-m-grid');
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
                                $.fn.yiiGridView.update('detectability-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
</script>