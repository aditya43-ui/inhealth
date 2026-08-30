<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Obat Alkes Masuk',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
        $('#divSearch-form form').submit(function(){
            $.fn.yiiGridView.update('pemesananobatalkesmasuk-m-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemesanan Obat Alkes Masuk</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format, 'instalasiPemesanans' => $instalasiPemesanans, 'ruanganPemesanans' => $ruanganPemesanans)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Obat Alkes Masuk</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pemesananobatalkesmasuk-m-grid',
                    'dataProvider' => $model->searchInformasiPemesananMasuk(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'replaceUrl' => true,
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglpemesanan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemesanan)',
                        ),
                        'nopemesanan',
                        'ruanganpemesan_nama',
                        'ruangantujuan_nama',
                        'statuspesan',
                        array(
                            'name' => 'pegawaipemesan_id',
                            'type' => 'raw',
                            'value' => '$data->PegawaiPemesanLengkap',
                        ),
                        array(
                            'name' => 'pegawaimengetahui_id',
                            'type' => 'raw',
                            'value' => '$data->PegawaiMengetahuiLengkap',
                        ),
                        array(
                            'header' => 'Keterangan Pemesanan',
                            'name' => 'keterangan_pesan',
                        ),
                        array(
                            'header' => 'Mutasi',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: left;'),
                            'value' => function ($data) {
                                if ($data->statuspengiriman == Params::STATUS_PENGIRIMANOA_READY) {
                                    return 'Sudah Dimutasi';
                                } else {
                                    return (!empty($data->mutasioaruangan_id) ? "SUDAH DIMUTASI" : (empty($data->terimamutasi_id) ? CHtml::Link(
                                        "<i class=\"icon-form-mutasi\"></i>",
                                        $this->getUrlMutasi() . "&pesanobatalkes_id=" . $data->pesanobatalkes_id,
                                        array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mutasi obat alkes",
                                        )
                                    ) : "SUDAH DITERIMA"));
                                }
                            }
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: left;'),
                            'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>","' . $this->getUrlPrint() . '&pesanobatalkes_id=$data->pesanobatalkes_id&frame=true",
                                        array("class"=>"", 
                                            "target"=>"pemesananmasuk",
                                            "onclick"=>"$(\"#dialogPemesananMasuk\").dialog(\"open\");",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk melihat rincian pemesanan obat alkes masuk",
                                        )
                                    )',
                        ),
                        array(
                            'header' => 'Status Pengiriman',
                            'name' => 'statuspengiriman',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (null !== Params::getColorStPengiriman($data->statuspengiriman)) {
                                    if ($data->statuspengiriman != Params::STATUS_PENGIRIMANOA_READY) {
                                        return CHtml::link($data->statuspengiriman . '<i class="' . MyIcon::getIcons('ubah') . '"></i>', 'javascript:;', array('onclick' => 'ubahStatus(\'' . Params::getChangeStPengiriman($data->statuspengiriman) . '\',' . $data->pesanobatalkes_id . ');jQuery(\'#dialogChangeSt\').dialog(\'open\');', 'class' => Params::getColorStPengiriman($data->statuspengiriman) . ' btn-icon', "data-toggle" => "tooltip", "data-placement" => "top", "title" => "", "data-original-title" => "Klik, jika Anda ingin merubah status menjadi <b>" . Params::getChangeStPengiriman($data->statuspengiriman) . "</b> ", "data-html" => true));
                                    } else {
                                        return CHtml::link($data->statuspengiriman, 'javascript:;', array('class' => Params::getColorStPengiriman($data->statuspengiriman) . ' nohover'));
                                    }
                                } else {
                                    return '-';
                                }
                            }
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPemesananMasuk',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rincian Pemesanan Obat Alkes Masuk',
        'autoOpen' => false,
        'minWidth' => 900,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pemesananmasuk" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================
?>
<?php echo $this->renderPartial($this->path_view . 'js/_jsFunctionsInfo', array(), true); ?>