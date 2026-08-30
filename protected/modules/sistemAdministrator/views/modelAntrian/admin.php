<?php
$this->breadcrumbs=array(
	'Model Antrian'=>array('admin'),
	'Pengaturan',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saloket-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pengaturan <b>Model Antrian</b>
        </div>
    </div>
    <div class="panel-body">
	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<hr/>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Tabel <b>Model Antrian</b>
                </div>
            </div>
            <div class="panel-body">
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'saloket-m-grid',
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
			'modelantrian_kode',
                        'modelantrian_nama',
                        'modelantrian_layanan',
                        'modelantrian_singkatan',
                        array(
                            'header' => 'Lokasi Karcis Antrian',
                            'name' => 'lokasi_karcisantrian_id',
                            'value' => '!empty($data->lokasi_karcisantrian_id)?$data->lokasiKarcisAntrian->lokasi_karcisantrian_nama:""',
                            'filter' => CHtml::activeDropDownList($model, 'lokasi_karcisantrian_id', CHtml::listData(LokasiKarcisantrianM::model()->findAll(" lokasi_karcisantrian_aktif = TRUE ORDER BY lokasi_karcisantrian_nama ASC "), 'lokasi_karcisantrian_id', 'lokasi_karcisantrian_nama'),array('empty'=>'-- Pilih --'))
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->modelantrian_aktif)?"Aktif":"Tidak Aktif"'
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
						//	'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
//			array(
//				'header'=>Yii::t('zii','Delete'),
//				'class'=>'bootstrap.widgets.BootButtonColumn',
//				'template'=>'{remove}{delete}',
//				'buttons'=>array(
//					'remove' => array (
//							'label'=>"<i class='glyphicon glyphicon-remove'></i>",
//							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
//							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->modelantrian_id))',
//							'click'=>'function(){nonActive(this);return false;}',
//							//'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',                                                        
//					),					 					 
//					'delete'=> array(
//                                            array (
//                                                    'options'=>array('title'=>'Hapus model antrian'),
//                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>$data->modelantrian_id))',
//                                                    'click'=>'function(){deleteModel(this);return false;}',
//                                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',                                                        
//                                                ),		
//					),
//				)
//			),
                    array(
                        'header' => 'Hapus',
                        'type' => 'raw',
                        'value' => '($data->modelantrian_aktif)?CHtml::link("<i class=\'glyphicon glyphicon-remove\'></i> ","javascript:removeTemporary($data->modelantrian_id)",array("id"=>"$data->modelantrian_id","rel"=>"tooltip","title"=>"Menonaktifkan model antrian"))." ".CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->modelantrian_id)",array("id"=>"$data->modelantrian_id","rel"=>"tooltip","title"=>"Hapus model antrian")):CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->modelantrian_id)",array("id"=>"$data->modelantrian_id","rel"=>"tooltip","title"=>"Hapus model antrian"));',
                        'htmlOptions' => array('style' => 'text-align: center; width:80px'),
                    ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
    </div>
        </div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Model Antrian',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial($this->path_tips.'master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint= $this->createUrl('print');
        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saloket-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div></div>
<script type="text/javascript">	
	function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('saloket-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Apakah Anda yakin ingin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.sukses == 1) {
                                $.fn.yiiGridView.update('saloket-m-grid');
                                toastr.success('Data berhasil dihapus','Perhatian!');
                            } else {
                                toastr.error('Data Gagal di Hapus'+data.pesan,"Perhatian!");
                            }
                        }, "json");
            }
        });
    }
</script>
