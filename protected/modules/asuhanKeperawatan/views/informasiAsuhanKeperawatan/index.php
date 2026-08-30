<?php $linkHalaman = CustomFunction::getUrlByMenuID(2597); ?>
<div class="panel panel-gradient">
    <?php
    $this->breadcrumbs = array(
        'Informasi Asuhan Keperawatan',
    );
    Yii::app()->clientScript->registerScript('search', "
$('#asuhankeperawatan-info-search').submit(function(){
	$('#informasiasuhankeperawatan-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
    ?>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Asuhan Keperawatan</b>
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
                <fieldset class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model, 'format' => $format
                    )); ?>
                </fieldset>
                <!--search-form-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Asuhan Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiasuhankeperawatan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Asuhan Keperawatan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglaskep)',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'No. Kamar/<br>No. Bed',
                            'type' => 'raw',
                            'value' => '$data->kamarruangan_nokamar."/<br>".$data->kamarruangan_nobed',
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'name' => 'no_pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'name' => 'jeniskelamin',
                            'type' => 'raw',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'header' => 'Umur',
                            'name' => 'umur',
                            'type' => 'raw',
                            'value' => '$data->umur',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("detail",array("asuhankeperawatan_id"=>$data->asuhankeperawatan_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Asuhan Keperawatan", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        //========= Dialog untuk Melihat detail Pemakaian Barang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Detail Asuhan Keperawatan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
    </div>
</div>