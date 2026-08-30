<?php
Yii::app()->clientScript->registerScript('search', "
    $('#searchriwayatDewasa').submit(function(){
        $.fn.yiiGridView.update('riwayatdewasa-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$modRiwayat = new PengkajianresikojatuhT();
$modRiwayat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
$modRiwayat->skalajatuh_jenis = 'dewasa_morsefallscale';
$modRiwayat->tgl_awal_kaji = $modRiwayat->tgl_awal_daftar = date('Y-m-d');
$modRiwayat->tgl_akhir_kaji = $modRiwayat->tgl_akhir_daftar = date('Y-m-d');
if (isset($_GET['PengkajianresikojatuhT'])) {
    $modRiwayat->attributes = $_GET['PengkajianresikojatuhT'];

    $modRiwayat->tgl_awal_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_awal_kaji']);
    $modRiwayat->tgl_akhir_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_akhir_kaji']);
    
    if (isset($_GET['PengkajianresikojatuhT']['is_ceklis']) && $_GET['PengkajianresikojatuhT']['is_ceklis'] == 1) {
        $modRiwayat->is_ceklis = $_GET['PengkajianresikojatuhT']['is_ceklis'];
        $modRiwayat->tgl_awal_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_awal_daftar']);
        $modRiwayat->tgl_akhir_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_akhir_daftar']);
    }
}
?>
<form class="form-horizontal" id="searchriwayatDewasa">
    <div class="panel panel-success panel-shadow" style="width: 80%;">
        <div class="panel-heading">
            <div class="panel-title"><strong>Pencarian</strong></div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Tanggal Pengkajian", '', array('class' => 'control-label', 'style' => 'width: 150px')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeHiddenField($modRiwayat, 'pendaftaran_id'); ?>
                            <?php echo CHtml::activeHiddenField($modRiwayat, 'skalajatuh_jenis'); ?>
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modRiwayat->tgl_awal_kaji)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modRiwayat->tgl_akhir_kaji)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($modRiwayat->tgl_awal_kaji)) ?> - <?php echo date('d M Y', strtotime($modRiwayat->tgl_akhir_kaji)) ?></span>
                                <?php echo CHtml::activeHiddenField($modRiwayat, 'tgl_awal_kaji', array('class' => 'start')) ?>
                                <?php echo CHtml::activeHiddenField($modRiwayat, 'tgl_akhir_kaji', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label(CHtml::activeCheckBox($modRiwayat, 'is_ceklis') . ' ' . "Tanggal Pendaftaran", '', array('class' => 'control-label', 'style' => 'width: 150px')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($modRiwayat->tgl_awal_daftar)) ?>" data-end-date="<?php echo date('d M Y', strtotime($modRiwayat->tgl_akhir_daftar)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($modRiwayat->tgl_awal_daftar)) ?> - <?php echo date('d M Y', strtotime($modRiwayat->tgl_akhir_daftar)) ?></span>
                                <?php echo CHtml::activeHiddenField($modRiwayat, 'tgl_awal_daftar', array('class' => 'start')) ?>
                                <?php echo CHtml::activeHiddenField($modRiwayat, 'tgl_akhir_daftar', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Instalasi", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeDropDownList($modRiwayat, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true order by instalasi_nama asc'), 'instalasi_id', 'instalasi_nama'), array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-Pilih-',
                                'class' => 'span3',
                                'onchange' => 'changeInstalasi()'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Ruangan", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeDropDownList($modRiwayat, 'ruangan_id', array(), array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 riwayat_ruangan_id',
                                'multiple' => 'multiple',
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            </div>
        </div>
    </div>
</form>
<br />
<div style="overflow: auto;">
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'riwayatdewasa-t-grid',
        'dataProvider' => $modRiwayat->searchRiwayatPengkajian(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Tanggal Pendaftaran/ <br /> No. Pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)."/ <br/>".$data->pendaftaran->no_pendaftaran'
            ),
            array(
                'header' => 'Instalasi/ <br /> Ruangan',
                'type' => 'raw',
                'value' => '(!empty($data->ruangan)? (!empty($data->ruangan->instalasi) ? $data->ruangan->instalasi->instalasi_nama : "") :"")."/ <br/>". (!empty($data->ruangan)?  $data->ruangan->ruangan_nama : "")'
            ),
            array(
                'header' => 'Petugas Pengisi',
                'type' => 'raw',
                'value' => '$data->petugas->namaLengkap'
            ),
            array(
                'header' => 'Tanggal/ Jam Pengakajian Resiko Jatuh',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_pengkajian) ."/ <br/>". $data->jam_pengkajian'
            ),
            array(
                'header' => 'Waktu Dilakukan Pengkajian <i class="' . MyIcon::getIcons('info2') . ' txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Keterangan Waktu Pengkajian : <br/> IA = saat asesmen pertama kali <br/> WT = saat transfer antar ruangan <br/> CC = saat terjadi perubahan kondisi pasien <br/> ES = saat pergantian shift (pagi)" data-html="true"></i>',
                'type' => 'raw',
                'value' => '$data->waktupengkajian_resikojatuh'
            ),
            array(
                'header' => 'Skor Jatuh',
                'type' => 'raw',
                'value' => '$data->totalskor .": ".$data->keteranganskor_resikojatuh'
            ),
            array(
                'header' => 'Waktu Intervensi Pencegahan',
                'type' => 'raw',
                'value' => function ($data) {
                    $intervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id' => $data->pengkajianresikojatuh_id));
                    $html = "";
                    if (!empty($intervensi)) {
                        $html = MyFormatter::formatDateTimeForUser($intervensi->tgl_intervensi) . " " . $intervensi->jam_intervensi;
                    }
                    return $html;
                }
            ),
            array(
                'header' => 'Evaluasi',
                'type' => 'raw',
                'value' => function ($data) {
                    $intervensi = IntervensicegahjatuhpasienT::model()->findByAttributes(array('pengkajianresikojatuh_id' => $data->pengkajianresikojatuh_id));
                    $html = "";
                    if (!empty($intervensi)) {
                        $html = (($intervensi->evaluasi_pencegahanjatuh != null) ? (($intervensi->evaluasi_pencegahanjatuh == 1) ? "Ya" : "Tidak") : "");
                    }
                    return $html;
                }
            ),
            array(
                'header' => 'Detail Pengkajian',
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::link("<icon class='icon-form-verifikasi'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/detailResikoJatuh', array("pengkajianresikojatuh_id" => $data->pengkajianresikojatuh_id, 'type' => 'dewasa', "frame" => true)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Melihat Detail Pengkajian", "onclick" => "$('#dialogDetail').dialog('open');"));;
                },
                'htmlOptions' => array('style' => 'text-align: center;'),
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                        return CHtml::link('<i class="icon-form-ubah"></i>', Yii::app()->controller->createUrl('indexDewasa', array(
                            'pendaftaran_id' => $data->pendaftaran_id,
                            'pengkajianresikojatuh_id' => $data->pengkajianresikojatuh_id,
                            'type' => (!empty($_GET['type']) ? $_GET['type'] : null),
                            'frame' => (!empty($_GET['frame']) ? $_GET['frame'] : null),
                        )));
                    } else {
                        return "";
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                        return CHtml::link('<i class="icon-form-sampah" style="font-size:14pt"></i>', '#', array(
                            'onclick' => 'hapusRiwayat(' . $data->pengkajianresikojatuh_id . '); return false'
                        ));
                    } else {
                        return "";
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
</div>
<br />
<div style="float:right;">
    <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type' => 'primary',
        'buttons' => array(
            array('label' => 'Cetak Pengkajian Resiko Jatuh', 'icon' => MyIcon::getIcons('cetak'), 'url' => 'javascript:void(0)', 'htmlOptions' => array('onclick' => 'printRiwayat(' . $modPendaftaran->pendaftaran_id . ',"PRINT")')),
            array('label' => '', 'items' => array(
                array('label' => 'PDF', 'icon' => MyIcon::getIcons('pdf'), 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(' . $modPendaftaran->pendaftaran_id . ',"PDF")')),
            )),
        ),
    )); ?>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengkajian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false
    ),
));
?>
<iframe name='frameDetail' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<script>
    function changeInstalasi() {
        if ($('#<?php echo CHtml::activeId($modRiwayat, 'instalasi_id') ?>').val() != '') {
            var ru = $(".riwayat_ruangan_id");
            ru.addClass('animation-loading');
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganBySingleSelect') ?>',
                dataType: "json",
                data: {
                    instalasi_id: $('#<?php echo CHtml::activeId($modRiwayat, 'instalasi_id') ?>').val()
                },
                success: function(data) {
                    if (data.sukses != '1') {
                        ru.addClass('animation-loading');
                    } else {
                        ru.html(data.ruangan);
                        ru.multiselect('rebuild');
                        ru.removeClass('animation-loading');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {
                    id: id
                }, function(data) {
                    if (data.sukses === 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayatdewasa-t-grid', {
                            data: {
                                "PengkajianresikojatuhT[pendaftaran_id]": '<?php echo $modRiwayat->pendaftaran_id; ?>',
                                "PengkajianresikojatuhT[skalajatuh_jenis]": 'dewasa_morsefallscale'
                            }
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    $(document).ready(function() {
        jQuery(".riwayat_ruangan_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>