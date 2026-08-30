<?php $linkHalaman = CustomFunction::getUrlByMenuID(132); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penjualan Resep Rumah Sakit',
);
$linkHalaman = CustomFunction::getUrlByMenuID(132);
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(132); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penjualan Resep Rumah Sakit</b>
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
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'search',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($modInfoPenjualan, 'no_rekam_medik'),
                    'method' => 'get',
                ));
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class='control-label'>
                                <?php echo CHtml::activeCheckBox($modInfoPenjualan, 'is_tgl', array('onClick' => 'cekTanggal()', 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal resep')); ?>
                                Tgl. Penjualan</label>
                            <?php //echo CHtml::label("Tgl. Penjualan", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY"
                                    data-start-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?>"
                                    data-end-date="<?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_awal)) ?> -
                                        <?php echo date('d F Y', strtotime($modInfoPenjualan->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modInfoPenjualan, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Resep', 'no_resep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoPenjualan, 'noresep', array('placeholder' => 'No. Resep', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modInfoPenjualan, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->textFieldRow($modInfoPenjualan, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nama ASC',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins)) unset($carabayar[$idx]);
                        }
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        echo $form->dropDownListRow($modInfoPenjualan, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modInfoPenjualan))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modInfoPenjualan, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->dropDownListRow($modInfoPenjualan, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        $criInstalsai = new CDbCriteria();
                        $criInstalsai->addCondition('instalasi_aktif = true');
                        $criInstalsai->addInCondition('instalasi_id', [2, 3, 4, 8, 14, 18, 20, 38, 70, 73, 79, 83, 85, 101]);
                        $criInstalsai->order = 'instalasi_nama asc';
                        $instalasi = InstalasiM::model()->findAll($criInstalsai);
                        $criRuangan = new CDbCriteria();
                        $criRuangan->join = "JOIN instalasi_m on instalasi_m.instalasi_id = t.instalasi_id ";
                        $criRuangan->addCondition('instalasi_m.instalasi_aktif = true and instalasi_m.ispelayanan = true');
                        $criRuangan->addCondition('t.ruangan_aktif = true');
                        $criRuangan->order = "t.ruangan_nama asc, instalasi_m.instalasi_nama asc";
                        $ruangan =  RuanganM::model()->findAll($criRuangan);
                        //										$instalasi = InstalasiM::model()->findAllByAttributes(array(
                        //											'instalasi_id' => array(2,3,4),
                        //										));
                        //										$ruangan = RuanganM::model()->findAllByAttributes(array(
                        //											'instalasi_id' => array(2,3,4),
                        //											'ruangan_aktif' => true,
                        //										), array(
                        //											'order'=>'instalasi_id, ruangan_nama',
                        //										));
                        echo $form->dropDownListRow($modInfoPenjualan, 'instalasipendaftaran_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/GetRuangDaftarDariInsDaftar', array('encode' => false, 'namaModel' => get_class($modInfoPenjualan))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modInfoPenjualan, "ruanganpendaftaran_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modInfoPenjualan, 'ruanganpendaftaran_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <?php echo $form->dropDownListRow($modInfoPenjualan, 'pegawai_id', CHtml::listData(
                            DokterV::model()->findAll(array(
                                'order' => 'nama_pegawai'
                            )),
                            'pegawai_id',
                            'namaLengkap'
                        ), array(
                            'empty' => '-- Pilih--', 'class' => 'span4',
                        ));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Status Periksa', 'statusperiksa', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modInfoPenjualan, 'statusperiksa', Params::statusPeriksa(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
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
                        array('title' => 'Reset', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiPenjualanResep', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penjualan Resep Rumah Sakit</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->clientScript->registerScript('cariPasien', "
                            $('form').submit(function(){
                                    $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                                            data: $(this).serialize()
                                    });
                                    return false;
                            });
                            ");
                    $this->renderPartial('_table', ['modInfoPenjualan' => $modInfoPenjualan]);
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogEtiket',
    'options' => array(
        'title' => 'Etiket',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameEtiket' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk menampilkan riwayat reseptur=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogResepturPenjualan',
    'options' => array(
        'title' => 'Resep Dokter',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 1100,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeResepturPenjualan" style="width: 100%; height: 98%;"></iframe> <iframe src=""
    name="iframeResepturPenjualan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog reseptur riwayat =============================
?>
<?php
// Dialog buat lihat riwayat obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayatObat',
    'options' => array(
        'title' => 'Riwayat Obat',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="frameRiwayatObat" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat riwayat obat =============================
?>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailPenjualan',
    'options' => array(
        'title' => 'Detail Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePasienResep" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>
<?php
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturPenjualan',
    'options' => array(
        'title' => 'Retur Penjualan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $('#search').serialize()
                    }); }",
        'before'
    ),
));
?>
<iframe src="" name="iframeReturPenjualan" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat Retur Penjualan Dialog =============================
?>
<?php
// Dialog buat lihat Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReturStok',
    'options' => array(
        'title' => 'Retur Stok',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $('#search').serialize()
                    }); }",
        'before'
    ),
));
?>
<iframe src="" name="iframeReturStok" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat Retur Penjualan Dialog =============================
?>
<?php
// Dialog buat lihat Detail Retur Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRetur',
    'options' => array(
        'title' => 'Detail Retur Stok',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
        'before'
    ),
));
?>
<iframe src="" name="iframeDetailRetur" width="100%" height="550"></iframe>
<?php
$this->endWidget();
//========= end lihat Detail Retur Penjualan Dialog =============================
?>
<?php
// Dialog untuk ambil Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAmbilObat',
    'options' => array(
        'title' => 'Penyerahan Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasipenjualanresep-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="iframeAmbilObat" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end ambil Obat =============================
?>
<script type="text/javascript">
function printRetur(returresep_id, penjualanresep_id, caraPrint) {
    window.open(
        "<?php echo Yii::app()->createAbsoluteUrl($this->module->id . '/informasiPenjualanResep/PrintStrukRetur') ?>&returresep_id=" +
        returresep_id + "&penjualanresep_id=" + penjualanresep_id + "&caraPrint=" + caraPrint, "",
        'location=_new, width=900px');
}
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'logindialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'minHeight' => 100,
        'resizable' => true,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'loginform')); ?>
<div class="control-group">
    <?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array('placeholder' => 'Nama Pemakai', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo CHtml::hiddenField('penjualanresep_id', '', array()); ?>
        <?php echo CHtml::hiddenField('untukaction', '', array()); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array('placeholder' => 'Password', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'submitLogin();return false;', 'onkeypress' => 'submitLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#logindialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 520,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>


<?php $this->renderPartial($this->path_view . '_jsFunctionsIndex'); ?>
<!--/div-->
<script>
function printEtiket(penjualanresep_id, racikan) {
    window.open('<?php echo $this->createUrl('penjualanDariReseptur/printEtiket'); ?>&racikan=' + (racikan ? 1 : 0) +
        '&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin',
        'left=100,top=100,width=1000,height=640');
}

function setStatusObat(obj, status, penjualanresep_id) {

    console.log(status);

    var is_siap = '-';


    if (status == 'SEDANG DIKONSULTASIKAN') {

        window.parent.myConfirm('Apakah obat akan dipersiapkan?', 'Perhatian!', function(r) {
            if (r) {
                is_siap = 'y';
            } else {
                is_siap = 'n';
            }

            $.post('<?php echo $this->createUrl('ubahStatusObatKonsul'); ?>', {
                status: status,
                is_siap: is_siap,
                penjualanresep_id: penjualanresep_id
            }, function(data) {
                if (data.pesan == 'ok') {
                    window.location.reload()
                    $.fn.yiiGridView.update(
                        'informasipenjualanresep-grid');
                }
            }, 'json');
        });

    } else {

        window.parent.myConfirm('Apakah obat perlu dikonsultasikan?', 'Perhatian!', function(r) {
            if (r) {

                $.post('<?php echo $this->createUrl('ubahStatusObatKonsul'); ?>', {
                    status: status,
                    is_siap: is_siap,
                    penjualanresep_id: penjualanresep_id
                }, function(data) {
                    if (data.pesan == 'ok') {
                        window.location.reload()
                        $.fn.yiiGridView.update('informasipenjualanresep-grid');
                    }
                }, 'json');

            } else {

                setTimeout(() => {
                    window.parent.myConfirm('Apakah obat akan dipersiapkan?', 'Perhatian!', function(
                        r) {
                        if (r) {
                            $.post('<?php echo $this->createUrl('ubahStatusObat'); ?>', {
                                status: status,
                                is_siap: is_siap,
                                penjualanresep_id: penjualanresep_id
                            }, function(data) {
                                if (data.pesan == 'ok') {
                                    window.location.reload()
                                    $.fn.yiiGridView.update(
                                        'informasipenjualanresep-grid');
                                }
                            }, 'json');
                        }
                    });
                }, 500);

            }

        });

    }


    return false;
}
/**
 * memanggil antrian ke farmasi apotek
 * @param {type} penjualanresep_id
 * @returns {undefined} */
function panggilAntrian(penjualanresep_id, antrianfarmasi_id) {
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('PanggilAntrian'); ?>',
        data: {
            penjualanresep_id: penjualanresep_id
        },
        dataType: "json",
        success: function(data) {
            if (data.pesan !== "") {
                myAlert(data.pesan);
            }
            if (data.smspasien == 0) {
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                }; // 16
                insert_notifikasi(params);
            }
            <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
            console.log("Panggil");
            socket.emit('send', {
                conversationID: 'antrian',
                panggil: 5,
                antrian_id: antrianfarmasi_id
            });
            <?php } ?>
            $.fn.yiiGridView.update('informasipenjualanresep-grid');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}
</script>