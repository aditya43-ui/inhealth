<?php $linkHalaman = CustomFunction::getUrlByMenuID(3008); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penyimpanan Sterilisasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penyimpanan Sterilisasi</b>
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
            $('#penyimpanansterils-info-search').submit(function(){
                $('#informasipenyimpanansteril-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasipenyimpanansteril-grid', {
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
                    <i class="entypo-credit-card"></i> Tabel <b>Penyimpanan Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipenyimpanansteril-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No. Penyimpanan Sterilisasi',
                            'type' => 'raw',
                            'value' => '$data->penyimpanansteril_no',
                        ),
                        array(
                            'header' => 'Tanggal Penyimpanan Sterilisasi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->penyimpanansteril_tgl)',
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
                            'header' => 'Petugas Penyimpanan Sterilisasi',
                            'name' => 'pegpenyimpanan_nama',
                            'type' => 'raw',
                            'value' => '$data->pegpenyimpanan->NamaLengkap',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPenyimpanan/detail",array("id"=>$data->penyimpanansteril_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penyimpanan Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        ),
                        array(
                            'header' => 'Pengiriman',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $cr = new CDbCriteria;
                                $cr->join = 'left join kirimperlinensterildet_t k on k.penyimpanansterildet_id = t.penyimpanansterildet_id';
                                $cr->compare('t.penyimpanansteril_id', $data->penyimpanansteril_id);
                                $cr->select = 't.penyimpanansterildet_id';
                                $cr->addCondition('k.penyimpanansterildet_id is null');
                                $det = PenyimpanansterildetT::model()->find($cr);
                                if (empty($det)) {
                                    return "SUDAH DIKIRIM";
                                }
                                return CHtml::link('<i class="icon-pencil"></i>',  Yii::app()->controller->createUrl("/sterilisasi/PengirimanPeralatanSterilT/Index", array("penyimpanansteril_id" => $data->penyimpanansteril_id)));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                        )
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
        'title' => 'Detail Penyimpanan Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" style="overflow: auto;"  name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>