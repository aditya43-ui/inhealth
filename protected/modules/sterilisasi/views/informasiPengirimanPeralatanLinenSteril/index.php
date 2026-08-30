<?php $linkHalaman = CustomFunction::getUrlByMenuID(3009); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengiriman Peralatan dan Linen Steril</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#pengirimanperalatanlinen-info-search').submit(function(){
	$('#informasipengirimanperalatanlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipengirimanperalatanlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <?php
        $this->breadcrumbs = array(
            'Informasi Pengiriman Peralatan Linen Steril',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pengiriman Peralatan dan Linen Steril</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipengirimanperalatanlinen-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Pengiriman',
                            'type' => 'raw',
                            'value' => '$data->kirimperlinensteril_no',
                        ),
                        array(
                            'header' => 'Tanggal Pengiriman',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->kirimperlinensteril_tgl)',
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
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->kirimperlinensteril_ket',
                        ),
                        array(
                            'header' => 'Pegawai Pengirim',
                            'name' => 'pegawaimengirim_nama',
                            'type' => 'raw',
                            'value' => '$data->pegawaiMengirim->NamaLengkap',
                        ),
                        array(
                            'header' => 'Status',
                            'name' => 'isterimaperlinensteril',
                            'type' => 'raw',
                            'value' => '($data->isterimaperlinensteril==1)? "Sudah Diterima" : "Belum Diterima"',
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => ($model->isterimaperlinensteril == 0) ? '{remove}' : '{sudah}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPengiriman",array("id"=>$data->kirimperlinensteril_id))',
                                    'click' => 'function(){batalPengiriman(this);return false;}',
                                    //								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
                                ),
                                'sudah' => array(
                                    'label' => "Sudah Diterima",
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPengirimanPeralatanLinenSteril/detail",array("id"=>$data->kirimperlinensteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array()); ?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" style="overflow: auto;" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>