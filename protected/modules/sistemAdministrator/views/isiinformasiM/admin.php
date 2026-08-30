<?php
$this->breadcrumbs=array(
	'Isiinformasi Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('isiinformasi-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Isi Informasi</b></div>
    </div>
    <div class="panel-body">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial($this->path_view.'_search',array(
        'model'=>$model,
    )); 
    
    
    ?>
    </div><!-- search-form -->
    <br/>
    <br/>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel Isi Informasi</div>
        </div>
        <div class="panel-body">
            <?php 

            if (empty($model->jenissurat_id)) {
                $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
                            'jenisinformasi_aktif'=>true
                        ), array(
                            'order'=>'jenisinformasi_urutan'
                        )), 'jenisinformasi_id', 'jenisinformasi_nama');

            } else {
                $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
                            'jenissurat_id'=>$model->jenissurat_id,
                            'jenisinformasi_aktif'=>true
                        ), array(
                            'order'=>'jenisinformasi_urutan'
                        )), 'jenisinformasi_id', 'jenisinformasi_nama');
            }

            $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'isiinformasi-m-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'name'=>'isiinformasi_id',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Jenis Surat',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return empty($data->jenisinformasi->jenissurat) ? "-" : $data->jenisinformasi->jenissurat->jenissurat_nama;
                        },
                        'filter'=>CHtml::activeDropDownList($model, 'jenissurat_id', CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif = true order by jenissurat_nama asc'), 'jenissurat_id', 'jenissurat_nama'), array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header'=>'Jenis Informasi',
                        'type'=>'raw',
                        'name'=>'jenisinformasi_id',
                        'value'=>'$data->jenisinformasi->jenisinformasi_nama',
                        'filter'=>CHtml::activeDropDownList($model, 'jenisinformasi_id', $list, array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header'=>'Isi Informasi',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $jenis = JenisinformasiM::model()->findByPk($data->jenisinformasi_id);
                            
                            if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_CHECKBOX) {
                                return CHtml::checkBox("a", "", array('disabled'=>true))."<label>".$data->isiinformasi_nama."</label>";
                            } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_PENJELASANTETAP) {
                                return $data->isiinformasi_nama;
                            } else if ($jenis->tipeinput_isiinformasi == Params::TIPEINPUT_ISIINFORMASI_DIINPUTOLEHUSER) {
                                return CHtml::textArea("a", "", array('readonly'=>true));
                            } 
                        }
                    ),
                    array(
                        'name'=>'isiinformasi_aktif',
                        'value'=>'$data->isiinformasi_aktif ? "Aktif" : "Tidak Aktif"',
                        'filter'=>false,
                    ),
                            /*
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view' => array(),
                         ),
                    ),
                             * 
                             */
                    array(
                        'header'=>Yii::t('zii','Update'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array(
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                            ),
                         ),
                    ),
                    array(
                                    'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{delete}',
                                ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>

        </div>
    </div>
<?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Isi Informasi',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $this->widget('UserTips',array('content'=>''));
    $urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#isiinformasi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>

    </div>
</div>
    
<script type="text/javascript">	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('isiinformasi-m-grid');
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