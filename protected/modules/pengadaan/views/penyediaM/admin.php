<?php
$this->breadcrumbs=array(
	'Penyedia Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('penyedia-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Pengaturan <b> Penyedia</b> </div>
        </div>
        <div class="panel-body">
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<div class="block-tabel">
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'penyedia-m-grid',
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
                'penyedia_kode',
		'penyedia_nama',
		'penyedia_namalain',
		'penyedia_alamat',
		'penyedia_direktur',
		'penyedia_cp',
		'penyedia_telepon',
                'penyedia_email',
                array(
                        'header' => '<center>Aktif</center>',
                        'value' => '($data->penyedia_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions' => array('style' => 'text-align:center;'),
                    ),
                array(
                    'header' => 'Verifikasi',
                    'type' => 'raw',
                    'value' => function($data) {
                        if ($data->penyedia_statusverifikasi == Params::STATUS_PERSIAPAN_DIAJUKAN) {
                            return CHtml::link("<button class ='btn btn-sm btn-blue' style='padding-left: 15px; padding-right: 15px'> <b> Verifikasi </b> </button>", Yii::app()->createUrl('pengadaan/penyediaM/verifikasi&id=' . $data->penyedia_id), array(
                                        'class' => 'hover',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk Melakukan Verifikasi"));
                        } else {
                            if (!empty($data->penyedia_statusverifikasi)) {
                                if ($data->penyedia_statusverifikasi == Params::STATUS_TERIMAOA_DISETUJUI) {
                                    return "<button class ='btn btn-sm btn-success' style='padding-left: 15px; padding-right: 15px'> <b> Terverifikasi </b> </button>";
                                } else {
                                    return "<button class ='btn btn-sm btn-red' style='padding-left: 15px; padding-right: 15px'> <b> Ditolak </b> </button>";
                                }
                            }
                                
                        }
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center',
                    ),
                    'headerHtmlOptions' => array(
                        'style' => 'text-align: center',
                    ),
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
                            'value'=>function($data){
                                if($data->penyedia_aktif == true){
                                  echo CHtml::link("<i class='icon-form-silang'></i> ","javascript:removeTemporary($data->penyedia_id)",array("id"=>"$data->penyedia_id","rel"=>"tooltip","title"=>"Menonaktifkan Penyedia")).' '.CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->penyedia_id)",array("id"=>"$data->penyedia_id","rel"=>"tooltip","title"=>"Hapus Penyedia"));  
                                }else{
                                  echo CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->penyedia_id)",array("id"=>"$data->penyedia_id","rel"=>"tooltip","title"=>"Hapus Penyedia"));
                                }
                            },
                        ),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
        </div>
        </div>
    </div>
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Penyedia',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-danger'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penyedia-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('penyedia-m-grid');
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
                                $.fn.yiiGridView.update('penyedia-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
</script>