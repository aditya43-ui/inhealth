<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$this->breadcrumbs = array(
    'Informasi Pasien Bedah Sentral',
);

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('cariwew', "
    $('#daftarPasiens-form').submit(function(){
        $('#daftarpasien-v-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Pasien Bedah Sentral</b>
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
                //CHtml::link($text, $url, $htmlOptions)
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'daftarPasiens-form',
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label for="namaPasien" class="control-label">
                                <?php // echo CHtml::activecheckBox($modPasienMasukPenunjang, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal'));
                                ?>
                                Tanggal Masuk
                            </label>
                            <div class="controls">
                                <?php
                                $format = new MyFormatter;
                                $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal);
                                $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label(' Sampai Dengan', ' s/d', array('class' => 'control-label')) ?>

                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>

                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modPasienMasukPenunjang, 'ceklis', array('id' => 'tanggal_lahir')) . " Tanggal Lahir", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $modPasienMasukPenunjang->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPasienMasukPenunjang->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPasienMasukPenunjang,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nourut',
                        ));
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        $dokter = DokterV::model()->findAll(array(
                            'condition' => 'pegawai_aktif = true and ruangan_id = ' . Yii::app()->user->getState('ruangan_id'),
                            'order' => 'nama_pegawai',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins))
                                unset($carabayar[$idx]);
                        }

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                            'ruangan_aktif' => 'true'
                        ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'pegawai_id', CHtml::listData($dokter, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4'));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasienMasukPenunjang))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modPasienMasukPenunjang, "penjamin_id") . '").html(data); }',
                            ),
                        ));

                        echo $form->dropDownListRow($modPasienMasukPenunjang, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Status Periksa", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'statuspendaftaran', LookupM::getItems('statusperiksa'), array('class' => 'span4', 'empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    );
                    ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>

                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Bedah Sentral</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial('_tablePasien', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);

echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<!--<iframe id="suarapanggilan" src="#" style="display: none;"></iframe>-->
<iframe id="suarapanggilan" src=""></iframe>

<script type="text/javascript">
//document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style","display:none;");
//document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal() {

    var checklist = $('#BSMasukPenunjangV_ceklis');
    var pilih = checklist.attr('checked');
    if (pilih) {
        document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:block;");
        document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:block;");
    } else {
        document.getElementById('BSMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
        document.getElementById('BSMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
    }
}

function batalPeriksa(idPenunjang) {
    myConfirm("Apakah Anda yakin akan membatalkan pemeriksaan Operasi Bedah pasien ini?", "Perhatian!", function(r) {
        if (r) {
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalPeriksa') ?>', {
                    idPenunjang: idPenunjang
                },
                function(data) {
                    if (data.status == 'ok' && data.pesan != 'exist') {
                        window.location =
                            "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
                    } else {
                        if (data.pesan == 'exist' && data.status == 'ok') {
                            if (data.smspasien == 0) {
                                var params = [];
                                params = {
                                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                                    isinotifikasi: 'Pasien ' + data.nama_pasien +
                                        ' tidak memiliki nomor mobile'
                                }; // 16
                                insert_notifikasi(params);
                            }
                            $('#dialogKonfirm div.divForForm').html(data.keterangan);
                            $('#dialogKonfirm').dialog('open');
                            $('#daftarpasien-v-grid').addClass('animation-loading');
                            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                data: $(this).serialize()
                            });
                        }
                    }
                }, 'json'
            );

        }
    });
}

function ambilAntrianTerakhir() {
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
        dataType: "json",
        success: function(data) {
            if (data.pesan == "") {
                panggilAntrian(data.pasienmasukpenunjang_id);
                setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
            } else {
                myAlert(data.pesan);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

/**
 * memanggil antrian ke poliklinik
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pasienmasukpenunjang_id) {
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('Panggil'); ?>',
        data: {
            pasienmasukpenunjang_id: pasienmasukpenunjang_id
        },
        dataType: "json",
        success: function(data) {
            if (data.pesan !== "") {
                myAlert(data.pesan);
            }
            <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
            socket.emit('send', {
                conversationID: 'antrian',
                panggil: 1,
                antrian_id: pasienmasukpenunjang_id
            });
            <?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}


/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id) {
    $("#suarapanggilan").attr("src",
        "<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian=" +
        kodeantrian + "&noantrian=" + noantrian + "&ruangan_id=" + ruangan_id);
}


/**
 *
 * @param {type} pendaftaran_id
 * @param {type} statusperiksa
 * @param {type} namaPasien
 * @returns {undefined}
 */
function dialogBatalPeriksa(pendaftaran_id, penunjang_id, namaPasien) {
    $('#titleNamaPasienBatal').html(namaPasien);
    $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
    $('#DialogBatalperiksa #penunjang_id').val(penunjang_id);
    $('#DialogBatalperiksa').dialog('open');
}

function ubahPeriksaKarenaBatal() {
    var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
    var penunjang_id = $('#DialogBatalperiksa #penunjang_id').val();
    var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
    var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

    $('#DialogBatalperiksa #keterangan_batal').attr('class', '');
    if (keterangan_batal == '') {
        myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
        $('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('BatalPeriksa'); ?>',
        data: {
            pendaftaran_id: pendaftaran_id,
            tglbatal: tglbatal,
            keterangan_batal: keterangan_batal,
            idPenunjang: penunjang_id
        }, //
        dataType: "json",
        success: function(data) {
            if (data.status == 'ok' && data.pesan != 'exist') {
                window.location =
                    "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
            } else {
                if (data.pesan == 'exist' && data.status == 'ok') {
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
                    $('#DialogBatalperiksa').dialog('close');
                    $('#dialogKonfirm div.divForForm').html(data.keterangan);
                    $('#dialogKonfirm').dialog('open');
                    $('#daftarpasien-v-grid').addClass('animation-loading');
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                    });
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

}
$(document).ready(function() {
    $("#suarapanggilan").attr('style', 'display: none');
});
</script>

<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogStatusDokumen',
    'options' => array(
        'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $('#daftarPasien-form').serialize()
                }); }",
    ),
));
?>
<iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget();
// end ============== 
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogRincianTagihan',
        'options' => array(
            'title' => 'Rincian Tagihan',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1001,
            'minWidth' => 1024,
            'height' => 510,
            'resizable' => true,
        ),
    ));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
    $this->endWidget();
?>

<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKonfirm',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 500,
        'height' => 200,
        'resizable' => false,
    ),
));

echo '<div class="divForForm"></div>';

$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

echo '<iframe name="frameRiwayat" style="width:100%; height: 98%;"></iframe>';

$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
//=============================== Ganti Data Pasien Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'selesaiOperasi',
        'options' => array(
            'title' => 'Selesai Operasi Pasien',
            'autoOpen' => false,
            'width' => 480,
            'height' => 320,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    )
);

//    echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
echo '<iframe name="frameSelesaiOperasi" style="width:100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
// Dialog untuk mengisi form time out =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTimeOut',
    'options' => array(
        'title' => 'Transaksi Time Out',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 950,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameTimeOut' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>


<?php
// Dialog untuk mengisi form sign out =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSignOut',
    'options' => array(
        'title' => 'Transaksi Sign Out',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameSignOut' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>

<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'height' => 320,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!--Dialog untuk mengetahui-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogApproveMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                }); }",
    ),
));
?>
<iframe name='frameApproveMengetahui' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--ialog untuk persetujuan-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPersetujuan',
    'options' => array(
        'title' => 'Detail Persetujuan & Penolakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        //        'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                        data: $(this).serialize()
        //                }); }",
    ),
));
?>
<iframe name='framePersetujuan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--ialog untuk penolakan-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenolakan',
    'options' => array(
        'title' => 'Penolakan Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        //        'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                        data: $(this).serialize()
        //                }); }",
    ),
));
?>
<iframe name='framePenolakan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => '',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

echo '<iframe name="detailDialog" style="width:100%; height: 98%;"></iframe>';

$this->endWidget();
//========= end masukkamar_t dialog =============================
?>

<?php
// Dialog untuk mengisi form sign in =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSignIn',
    'options' => array(
        'title' => 'Transaksi Sign In',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 700,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
			data: $('#daftarPasien-form').serialize()
		}); }",
    ),
));
?>
<iframe name='frameSignIn' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>

<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLaporanAnestesiLokal',
    'options' => array(
        'title' => 'Laporan Tindakan Bedah & Prosedur Infasif dengan Anestesi Lokal',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameLaporanAnestesiLokal' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>

<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasiRuangPulih',
    'options' => array(
        'title' => 'Verifikasi Keluar Ruang Pulih',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameVerifikasiRuangPulih' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>

<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLaporanOperasi',
    'options' => array(
        'title' => 'Laporan Operasi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameLaporanOperasi' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>

<?php
// Dialog untuk menampilkan laporan catatan anestesi lokal =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMonitoringTransfusi',
    'options' => array(
        'title' => 'Monitoring Transfusi Darah',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe name='frameMonitoringTransfusi' style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
// end ==============
?>