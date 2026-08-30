<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tabelverifikasi-search',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('tabelVerifikasi', "
$('#tabelverifikasi-search').submit(function(){
	$.fn.yiiGridView.update('pencarianverifikasi-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Verifikasi Tagihan</b>
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
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Verifikasi", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 50)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
                            <?php echo $form->textFieldRow($model, 'nama_pemakai', array('placeholder' => 'Verifikator', 'class' => 'span4', 'maxlength' => 20)); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $tips = array(
                        '0' => 'simpan',
                        '1' => 'ulang',
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Verifikasi Tagihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianverifikasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{pager}{summary}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglverifikasi',
                            'type' => 'raw',
                            'value' => function ($data) use ($format) {
                                return $format->formatDateTimeForUser($data->tglverifikasi);
                            }
                        ),
                        array(
                            'name' => 'noverifikasi',
                            'type' => 'raw',
                            'value' => function ($data) use ($format) {
                                return CHtml::link(
                                    '<u>' . $data->noverifikasi . '</u>',
                                    Yii::app()->controller->createUrl('detail', array('id' => $data->verifikasitagihan_id)),
                                    array(
                                        'target' => 'iframeDetail',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Detail Verifikasi Tagihan',
                                        'onclick' => '$("#dialogDetail").dialog("open");'
                                    )
                                );
                            }
                        ),
                        'noverifikasi',
                        array(
                            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => function ($data) use ($format) {
                                return $format->formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran;
                            }
                            //'$data->tgl_pendaftaran."<br>".$data->no_pendaftaran',
                        ),
                        'nama_pasien',
                        array(
                            'header' => 'Jenis Penjamin/</br>Penjamin',
                            'type' => 'raw',
                            'value' => '$data->carabayar_nama."<br>".$data->penjamin_nama',
                        ),
                        'nama_pemakai',
                        'keteranganverifikasi',
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Pembayaran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1124,
        'height' => 510,
        'resizable' => true,
    ),
));
?>
<iframe src="" id="iframeDetail" name="iframeDetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>