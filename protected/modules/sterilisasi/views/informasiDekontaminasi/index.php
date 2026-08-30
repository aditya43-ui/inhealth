<?php $linkHalaman = CustomFunction::getUrlByMenuID(3031); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Dekontaminasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Dekontaminasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">-->
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#dekontaminasisinfo-search').submit(function(){
	$('#informasidekontaminasi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasidekontaminasi-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Dekontaminasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasidekontaminasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No. Dekontaminasi',
                            'type' => 'raw',
                            'value' => '$data->dekontaminasi_no',
                        ),
                        array(
                            'header' => 'Tanggal Dekontaminasi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->dekontaminasi_tgl)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Pegutas Dekontaminasi',
                            'name' => 'pegpetugas_nama',
                            'type' => 'raw',
                            'value' => '$data->pegpetugas->NamaLengkap',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiDekontaminasi/detail",array("dekontaminasi_id"=>$data->dekontaminasi_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Dekontaminasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        ),
                        array(
                            'header' => 'Pembersihan',
                            'type' => 'raw',
                            'value' => '!empty($data->cekPembersihan($data->dekontaminasi_id)) ? $data->cekPembersihan($data->dekontaminasi_id) : CHtml::link("<i class=\'icon-pencil\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/PembersihanPeralatanSteril/index",array("dekontaminasi_id"=>$data->dekontaminasi_id)));', 'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Dekontaminasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="overflow:auto; width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>