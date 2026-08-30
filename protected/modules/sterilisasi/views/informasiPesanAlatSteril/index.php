<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Peralatan Steril</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pemesanan Alat Steril' => array('index'),
        );
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
            });
            $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('informasipenerimaanalatsteril-grid', {
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
                <?php $this->renderPartial('_search', array(
                    'modPesanAlatSteril' => $modPesanAlatSteril, 'format' => $format
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Peralatan Steril</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipenerimaanalatsteril-grid',
                    'dataProvider' => $modPesanAlatSteril->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right; width:30px;'),
                        ),
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
                            'header' => 'Pegawai Memesan',
                            'type' => 'raw',
                            'value' => 'isset($data->pegawaiMemesan->nama_pegawai)? $data->pegawaiMemesan->nama_pegawai : ""',
                        ),
                        array(
                            'header' => 'Pegawai Mengetahui',
                            'type' => 'raw',
                            'value' => 'isset($data->pegawaiMengetahui->nama_pegawai)? $data->pegawaiMengetahui->nama_pegawai : ""',
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Detail", array("pesanperlinensteril_id"=>$data->pesanperlinensteril_id,"frame"=>true)), array("target"=>"frameDetail","rel"=>"tooltip", "title"=>"Klik untuk detail", "onclick"=>"$(\'#dialogDetail\').dialog(\'open\');"))',
                        ),
                        array(
                            'header' => 'Kirim',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<button class=\'btn btn-success\'><i class=\'entypo-check\'></i> Proses</button>",  Yii::app()->controller->createUrl("/sterilisasi/PengirimanPesanAlatSterilT/index",array("id"=>$data->pesanperlinensteril_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Linen","disabled"=>true));',
                            'htmlOptions' => array('style' => 'text-align: center; width:100px')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Rencana Anggaran Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameDetail' style="overflow:auto; width:100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>