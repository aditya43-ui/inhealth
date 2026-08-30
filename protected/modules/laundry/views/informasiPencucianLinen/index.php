<?php $linkHalaman = CustomFunction::getUrlByMenuID(2539); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pencucian Linen',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#pencucianlinen-info-search').submit(function(){
	$('#informasipencucianlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipencucianlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pencucian Linen</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pencucian Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipencucianlinen-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No. Pencucian',
                            'type' => 'raw',
                            'value' => '$data->nopencucianlinen',
                        ),
                        array(
                            'header' => 'Tanggal Pencucian',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpencucianlinen)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            //					'value'=>'$data->ruangan->instalasi->instalasi_nama',
                            'value' => '$data->getRuanganIns($data->pencucianlinen_id, "instalasi")',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            //					'value'=>'$data->ruangan->ruangan_nama',
                            'value' => '$data->getRuanganIns($data->pencucianlinen_id, "ruangan")',
                        ),
                        array(
                            'name' => 'keterangan_perawatan',
                            'type' => 'raw',
                            'value' => '$data->keterangan_pencucianlinen',
                        ),
                        array(
                            'header' => 'Cuci Ulang',
                            'type' => 'raw',
                            'value' => '$data->getCuciUlang($data->pencucianlinen_id, $data->is_cuciulang)',
                            // 'value' => function($data){
                            //     if($data->is_cuciulang === false){
                            //         echo 'false';
                            //       }else if($data->is_cuciulang === true){
                            //         echo "true";
                            //       }else if(is_null($data->is_cuciulang)){
                            //         echo "null";
                            //       }
                            //     // $data->getCuciUlang($data->pencucianlinen_id,$data->is_cuciulang);
                            // }
                        ),
                        array(
                            'header' => 'Lihat Detail/ Status',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPencucianLinen/detail",array("id"=>$data->pencucianlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pencucian Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'name' => 'Penyimpanan Linen',
                            'type' => 'raw',
                            'value' => '(isset($data->penyimpananlinendet_id)?"Sudah Disimpan":CHtml::Link("<i class=\'icon-simpanlinen\'></i>",Yii::app()->controller->createUrl("/laundry/PenyimpananLinen/Index",array("pencucianlinen_id"=>$data->pencucianlinen_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Penyimpanan Linen")))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pencucian Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>