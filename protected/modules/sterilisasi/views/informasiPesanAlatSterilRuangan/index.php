<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Peralatan Sterilisasi',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pemesanan Peralatan Sterilisasi</b>
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
            $('#pemesananperalatansteril-info-search').submit(function(){
                $('#informasipemesananperalatansteril-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasipemesananperalatansteril-grid', {
                        data: $(this).serialize()
                });
                return false;
            });
        "); ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Peralatan Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipemesananperalatansteril-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Pemesanan',
                            'type' => 'raw',
                            'value' => '$data->pesanperlinensteril_no',
                        ),
                        array(
                            'header' => 'Tanggal Pemesanan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->pesanperlinensteril_tgl)',
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
                            'value' => '$data->pesanperlinensteril_ket',
                        ),
                        array(
                            'header' => 'Pegawai Pemesanan',
                            'name' => 'pegawaimemesan_nama',
                            'type' => 'raw',
                            'value' => '$data->pegawaiMemesan->NamaLengkap',
                        ),
                        array(
                            'header' => 'Pegawai Menyetujui',
                            'name' => 'pegawaimengetahui_nama',
                            'type' => 'raw',
                            'value' => '$data->pegawaiMengetahui->NamaLengkap',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPesanAlatSterilRuangan/detail",array("pesanperlinensteril_id"=>$data->pesanperlinensteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemesanan Peralatan Steril", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPemesanan",array("id"=>$data->pesanperlinensteril_id))',
                                    'click' => 'function(){batalPemesanan(this);return false;}',
                                    //								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemesanan Sterilisasi',
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