<style>

    .jawab_konsul {
        background-color:yellow !important;
    }
</style>

<?php
$this->breadcrumbs = array(
    'Informasi Rawat Intensif'
);
?>
<!--<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Rawat Intensif</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Rawat Intensif</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarPasien-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php echo $this->renderPartial('_formPencarian', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Intensif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tablePasien', ['model' => $model]) ?>
            </div>
        </div>
        <?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>
        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogRincian',
            'options' => array(
                'title' => 'Rincian Tagihan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget(); ?>
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
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogRincianSudahBayar',
            'options' => array(
                'title' => 'Rincian Pasien Sudah Bayar',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameRincianSudahBayar' style="width: 100%; height: 98%;"></iframe>
        <?php $this->endWidget(); ?>
        <div style='display:none'>
            <?php $this->widget('MyDateTimePicker', array(
                //      'model'=>$modMasukKamar,
                'name' => 'jammasukkamar',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::TIME_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'span3 dtPicker3',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                ),
            )); ?>
        </div>
    </div>
</div>
<?php
// Dialog untuk notif penunjang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPertahian',
    'options' => array(
        'title' => 'Perhatian!',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 400,
        'height' => 300,
        'resizable' => true,
    ),
));
?>
<div id="isiPerhatian" style="padding: 5px;"></div>
<?php
$this->endWidget();
?>
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
<?php
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasienPulang',
    'options' => array(
        'title' => 'Pasien Pulang',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMasukKamar',
    'options' => array(
        'title' => 'Masuk Kamar Rawat Intensif',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end masukkamar_t dialog =============================
?>
<?php
// Dialog untuk pindahkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPindahKamar',
    'options' => array(
        'title' => 'Pindah Kamar Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 700,
        'height' => 550,
        'resizable' => true,
    ),
));
?>
<iframe src="" id="iframePindahKamar" name="iframePindahKamar" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk batal Rawat Intensif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalRawatInap',
    'options' => array(
        'title' => 'Pembatalan Pasien Rawat Intensif',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeBatalRawatInap" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk pindahkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogTindakLanjut',
    'options' => array(
        'title' => 'Transaksi Pasien Pulang',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 450,
        'resizable' => true,
        'close' => "js:function(){ 
                        $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); 
                        $('#iframeTindakLanjut').prop('src', 'about:blank');
                    }",
    ),
));
?>
<iframe src="" name="iframeTindakLanjut" id="iframeTindakLanjut" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<?php
// Dialog untuk rencana pulang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRencanaPulang',
    'options' => array(
        'title' => 'Rencana Pulang',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 600,
        'height' => 600,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRencanaPulang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end rencanapulang dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 250,
        'resizable' => false,
    ),
)); ?>
<div class="alert alert-block alert-error" id="alertDiv" style="display : none;">
    Kesalahan dalam Pengisian Usename atau Password
</div>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
<div class="control-group">
    <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array()); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array()); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;')
    ); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php
// $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//     'id' => 'dialogAlasan',
//     'options' => array(
//         'title' => 'Data Pasien',
//         'autoOpen' => false,
//         'modal' => true,
//         'width' => 1000,
//         'height' => 250,
//         'resizable' => false,
//     ),
// ));
?>
<!-- <div id="divFormDataPasien"></div>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formAlasan')); ?>
<table>
    <tr>
        <td><?php echo CHtml::label('Alasan', 'Alasan', array('class' => '')) ?></td>
        <td>
            <?php echo CHtml::textArea('Alasan', '', array()); ?>
            <?php echo CHtml::hiddenField('idOtoritas', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('namaOtoritas', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('idPasienPulang', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('pasienadmisi_id', '', array('readonly' => TRUE)); ?>
        </td>
    </tr>
</table> -->
<!-- <div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'simpanAlasan();return false;')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;')
    ); ?>
</div> -->


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailPPDS',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">PPDS</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>





<?php //echo CHtml::endForm(); ?>
<?php //$this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'konfirmasiDialog',
    'options' => array(
        'title' => 'Konfirmasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<div style="text-align: center;">
    User Tidak Memiliki Akses untuk Proses Ini,<br>
    Yakin Akan Melakukan Ke Proses Selanjutnya ?
</div>
<div class="form-actions" align="center">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Yes', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => "$('#loginDialog').dialog('open');$('#konfirmasiDialog').dialog('close');")
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} No', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => "$('#konfirmasiDialog').dialog('close');")
    ); ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAlasan',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 250,
        'resizable' => false,
    ),
));
?>
<div id="divFormDataPasien"></div>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formAlasan')); ?>
<table>
    <tr>
        <td><?php echo CHtml::label('Alasan', 'Alasan', array('class' => '')) ?></td>
        <td>
            <?php echo CHtml::textArea('Alasan', '', array()); ?>
            <?php echo CHtml::hiddenField('idOtoritas', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('namaOtoritas', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('idPasienPulang', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('pasienadmisi_id', '', array('readonly' => TRUE)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'simpanAlasan();return false;')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;')
    ); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasiPJA',
    'options' => array(
        'title' => 'Validasi PJA',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 200,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<form id="formVerifikasiPJA" class="form-horizontal" style="padding: 10px;">
    <div class="row-fluid">
        <div class="col-sm-12">
            <div class="control-group">
                <label class="control-label">Petugas Validasi</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('verifikasi[pendaftaran_id]', null, array('class'=>'verifikasi_pendaftaran_id')); ?>
                    <?php echo CHtml::hiddenField('verifikasi[userapprovaltindaklanjut_id]', Yii::app()->user->getState('pegawai_id')); ?>
                    <?php echo CHtml::textField('verifikasi[userapprovaltindaklanjut_nama]', Yii::app()->user->getState('nama_pegawai'), array(
                        'class'=>'span3', 'readonly'=>true,
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Validasi</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'verifikasi[tanggal_approvaltindaklanjut]',
                        'value' => MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat'=>Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'class'=>'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                    ?>
                </div>
            </div>
            
        </div>
        <div class="form-action">
            <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
                'class'=>'btn btn-danger', 'onclick'=>'verifikasiPJASimpan();',
            )); ?>
        </div>
    </div>
</form>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function verifikasiPJADialog(pendaftaran_id) {
        $("#formVerifikasiPJA .verifikasi_pendaftaran_id").val(pendaftaran_id);

        $("#dialogVerifikasiPJA").dialog("open");
    }

    function verifikasiPJASimpan() {
        $.post('<?php echo $this->createUrl('/rawatInap/pasienRawatInap/verifikasiPJA'); ?>', $("#formVerifikasiPJA").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogVerifikasiPJA").dialog("close");
                myAlert(data.msg);
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }

    function batalPJA(pendaftaran_id, no_pendaftaran) {
        myConfirm("Anda yakin untuk membatalkan validasi PJA ini ?", no_pendaftaran, function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('/rawatInap/pasienRawatInap/batalPJA'); ?>', {
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    
    function verifikasiPasienKabur(id) {
        $("#judul_pulang").html("Melarikan Diri");
        $("#iframeTindakLanjut").prop("src", "<?php echo Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienPI'); ?>&pendaftaran_id=" + id + "&melarikandiri=1");
        $("#dialogTindakLanjut").dialog("open");
    }

    function cekVerifikasiMeninggal(pendaftaran_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatInap/PasienRawatInap/VerifikasiRencanaPulang'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    if (data.verifikasinull != '') {
                        myAlert(data.pesan);
                    } else {
                        verifikasiPasienMeninggal(pendaftaran_id);
                    }
                } else {
                    if (data.isalert == 1) {
                        myAlert(data.pesan);
                    } else if (data.isnotif == 1) {
                        $("#isiPerhatian").html(data.pesan);
                        $("#dialogPertahian").dialog('open');
                    } else {
                        verifikasiPasienMeninggal(pendaftaran_id);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiPasienMeninggal(id) {
        $("#judul_pulang").html("Meninggal");
        $("#iframeTindakLanjut").prop("src", "<?php echo Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienPI'); ?>&pendaftaran_id=" + id + "&meninggal=1");
        $("#dialogTindakLanjut").dialog("open");
    }

    function batal() {
        $('#loginDialog').dialog('close');
        $('#loginDialog #username').val('');
        $('#loginDialog #password').val('');
        $('#alertDiv').hide();
        $('#pasien_id').val('');
        $('#pendaftaran_id').val('');
        $('#dialogAlasan').dialog('close');
        $('#dialogAlasan #idOtoritas').val('');
        $('#dialogAlasan #namaOtoritas').val('');
        $('#dialogAlasan #idPasienPulang').val('');
        $('#dialogAlasan #pendaftaran_id').val('');
        $('#dialogAlasan #pasienadmisi_id').val('');
        $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#daftarPasienPulang-form').serialize()
        });
    }

    function cekHakAkses(pendaftaran_id) {
        //       $('#dialogAlasan #idPasienPulang').val(idPasienPulang);
        //       $('#dialogAlasan #pendaftaran_id').val(pendaftaran_id);
        //       $('#pasien_id').val(pasien_id);
        //       $('#pendaftaran_id').val(pendaftaran_id);
        $('#konfirmasiDialog').dialog('open');
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/CekHakAkses'); ?>', {
            pendaftaran_id: pendaftaran_id,
            idUser: '<?php echo Yii::app()->user->id; ?>',
            useName: '<?php echo Yii::app()->user->name; ?>'
        }, function(data) {
            if (data.cekAkses == true) {
                $('#dialogAlasan').dialog('open');
                $('#dialogAlasan #idOtoritas').val(data.userid);
                $('#dialogAlasan #namaOtoritas').val(data.username);
            } else {
                $('#konfirmasiDialog').dialog('open');
            }
            $('#dialogAlasan #idPasienPulang').val(data.pendaftaran.pasienpulang_id);
            $('#dialogAlasan #pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
            $('#pasien_id').val(data.pendaftaran.pasien_id);
            $('#pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
            $('#dialogAlasan #pasienadmisi_id').val(data.pendaftaran.pasienadmisi_id);
        }, 'json');
    }

    function cekLogin() {
        pasien_id = $('#pasien_id').val();
        pendaftaran_id = $('#pendaftaran_id').val();
        $.post('<?php echo Yii::app()->createUrl('ActionAjax/CekLoginPembatalRawatInap'); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/dataPasien'); ?>', {
                    pasien_id: pasien_id,
                    pendaftaran_id: pendaftaran_id
                }, function(dataPasien) {
                    $('#divFormDataPasien').html(dataPasien.form);
                }, 'json');
                $('#dialogAlasan').dialog('open');
                $('#dialogAlasan #idOtoritas').val(data.userid);
                $('#dialogAlasan #namaOtoritas').val(data.username);
                $('#loginDialog').dialog('close');
            } else {
                $('#alertDiv').show();
            }
        }, 'json');
    }

    function simpanAlasan() {
        alasan = $('#dialogAlasan #Alasan').val();
        if (alasan == '') {
            window.parent.myAlert('Anda Belum Mengisi Alasan Pembatalan');
        } else {
            $.post('<?php echo Yii::app()->createUrl('perawatanIntensif/pasienRawatIntensif/BatalRawatInap'); ?>', $('#formAlasan').serialize(), function(data) {
                //            if(data.error != '')
                //                window.parent.myAlert(data.error);
                //            $('#'+data.cssError).addClass('error');
                if (data.status == 'success') {
                    batal();
                    window.parent.myAlert('Data Berhasil Disimpan');
                    location.reload();
                } else {
                    window.parent.myAlert(data.status);
                }
            }, 'json');
        }
    }
</script>
<script>
    function addMasukKamar() {
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('perawatanIntensif/pasienRawatIntensif/addMasukKamarPI'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
//                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
//                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy hh:mm:ss','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
//                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
//                    
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {
                   'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogMasukKamar').dialog('close') \",1000);
                }
            } ",
        ))
        ?>;
        return false;
    }

    function ubahKasusPenyakit(obj, pendaftaran_id, pasienadmisi_id, jeniskasuspenyakit_id) {
        var pendaftaran_id = pendaftaran_id;
        var pasienadmisi_id = pasienadmisi_id;
        var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                pasienadmisi_id: pasienadmisi_id,
                jeniskasuspenyakit_id: jeniskasuspenyakit_id
            },
            dataType: "json",
            success: function(data) {
                $(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
                $(obj).parents('td').find('.kasus_penyakit').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    function saveKasusPenyakit(obj, pendaftaran_id, pasienadmisi_id) {
        var jeniskasuspenyakit_id = $(obj).val();
        var pendaftaran_id = pendaftaran_id;
        var pasienadmisi_id = pasienadmisi_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                pasienadmisi_id: pasienadmisi_id,
                jeniskasuspenyakit_id: jeniskasuspenyakit_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan == 'berhasil') {
                    window.parent.myAlert('Data Kasus Penyakit berhasil di ubah');
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                } else {
                    window.parent.myAlert('Data Kasus Penyakit gagal di ubah');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    function ubahDokterPeriksa(pendaftaran_id, pasienadmisi_id) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        $('#temp_idPasienadmisiDP').val(pasienadmisi_id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahDokterPeriksa') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                } else {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('form').serialize()
                    });
                    setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }

    function ubahDokterPeriksa2(pendaftaran_id, pasienadmisi_id) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        $('#temp_idPasienadmisiDP').val(pasienadmisi_id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahDokterPeriksa2') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form2') {
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa2').html(data.div);
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa2 form').submit(ubahDokterPeriksa2);
                } else {
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa2').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('form').serialize()
                    });
                    setTimeout("$('#editDokterPeriksa2').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }

    function verifikasiTagihanPasien(pendaftaran_id, pasienadmisi_id) {
        alert(pendaftaran_id + '-' + pasienadmisi_id);
    }

    function verifikasiRencanaPulang(pendaftaran_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatInap/pasienRawatInap/VerifikasiRencanaPulang'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    if (data.verifikasinull != '') {
                        myAlert(data.pesan);
                    } else {
                        $("#dialogRencanaPulang").dialog("open");
                    }
                } else {
                    if (data.isalert == 1) {
                        myAlert(data.pesan);
                    } else if (data.isnotif == 1) {
                        $("#isiHtml").html(data.pesan);
                        $("#dialogPerhatian").dialog('open');
                    } else {
                        myConfirm(data.pesan, "Perhatian!", function(r) {
                            if (r) {
                                $("#dialogRencanaPulang").dialog("open");
                            }
                        });
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiPulangPasien(pendaftaran_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    if (data.verifikasinull != '') {
                        window.parent.myAlert(data.pesan);
                    } else {
                        $("#dialogTindakLanjut").dialog("open");
                    }
                } else {
                    myConfirm(data.pesan, "Perhatian!", function(r) {
                        if (r) {
                            $("#dialogTindakLanjut").dialog("open");
                            if (data.statusbayar == 'ada') {
                                alert('Sisa tagihan pasien ini belum dibayarkan');
                            }
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    function validasiDialogPindahKamar(id, time) {
        var url = '<?php echo  $this->createUrl('PindahKamarPasienPI') ?>';
        var url_lengkap = url + "&pendaftaran_id=" + id;
        
        var jam = <?php 
        $waktu = Yii::app()->user->getState('waktutampilalert_akomodasisdhterhitung');
        echo empty($waktu) ? 3 : $waktu;
        
        ?>;
        var d = new Date();
        var sekarang = Math.ceil(d.getTime()/1000);
        
        if ((sekarang - time) < (jam * 3600)) {
            myAlert("Lama rawat pasien kurang dari " + jam + " Jam dan Akomodasi Rawat Inap sudah masuk tagihan. Apakah akan melanjutkan pemindahan pasien ? Jika Ya dan Akomodasi tidak akan dimasukkan ke tagihan, silahkan hapus terlebih dahulu Akomodasi di Tabulasi Tindakan", "Peringatan", function() {
                $("#iframePindahKamar").attr("src", url_lengkap);
                $("#dialogPindahKamar").dialog("open");
            });
        } else {
            $("#iframePindahKamar").attr("src", url_lengkap);
            $("#dialogPindahKamar").dialog("open");
        }
    }



    function cekKonsulJawab() {
        $("#daftarPasien-grid tbody tr").each(function() {
            if ($(this).find(".ada_jawab").length != 0) {
                $(this).find(".ada_jawab").parents("button").addClass("jawab_konsul");
            }
        });
    }

    $(document).ready(function() {
        cekKonsulJawab();
    });
</script>
<?php
$urlSessionMasukKamar = Yii::app()->createUrl('perawatanIntensif/pasienRawatIntensif/buatSessionMasukKamar ');
$jscript = <<< JS
function buatSessionMasukKamar(masukkamar_id,kelaspelayanan_id, pendaftaran_id)
{
    $.post("${urlSessionMasukKamar}", { masukkamar_id: masukkamar_id,kelaspelayanan_id: kelaspelayanan_id,pendaftaran_id: pendaftaran_id },
        function(data){
            'sukses';
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<?php
$url = Yii::app()->createUrl('ActionAjaxPIRD/batalPindahKamar');
$mds = Yii::t('mds', 'Anda yakin akan membatalkan pindah kamar?');
$jscript = <<< JS
function batalPindahKamar(idPindahKamar,idMasukKamar)
{
    if(confirm("${mds}"))
    {
        $.post("${url}", { idPindahKamar: idPindahKamar, idMasukKamar: idMasukKamar },
            function(data){
                if(data.status == 'true')
                {
                    $('#dialogSuksesBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
                else
                {
                    $('#dialogGagalBatalPindah').dialog('open');
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    $('#dialogBatalPindah div.divForForm').html(data.div);
                    setTimeout("$('#dialogSuksesBatalPindah').dialog('close') ",1000);
                }
        }, "json");
    }
}
JS;
Yii::app()->clientScript->registerScript('jsBatalPindah', $jscript, CClientScript::POS_BEGIN);
?>
<?php
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa',
        'options' => array(
            'title' => 'Ganti Dokter Periksa',
            'autoOpen' => false,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo CHtml::hiddenField('temp_idPasienadmisiDP', '', array('readonly' => true));
echo '<div class="divForFormEditDokterPeriksa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//======================= Edit Dokter DPJP ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa2',
        'options' => array(
            'title' => 'Ganti DPJP',
            'autoOpen' => false,
            'minWidth' => 500,
            'height' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo CHtml::hiddenField('temp_idPasienadmisiDP', '', array('readonly' => true));
echo '<div class="divForFormEditDokterPeriksa2"></div>';
// ============== Table List DPJP ===========================
$format = new MyFormatter();
$modDPJP = new PegawaiV('search');
$modDPJP->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchDokterDPJP(),
    'filter' => $modDPJP,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setDokterAdmisi('" . $data->namaLengkap . "'," . $data->pegawai_id . "); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
// ============== End Table List DPJP ===========================                
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlergiObat',
    'options' => array(
        'title' => 'Riwayat Alergi Obat Pasien',
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
<iframe name='frameAlergiObat' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLabelGelang',
    'options' => array(
        'title' => 'Label Gelang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 280,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameLabelGelang' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        //		'show'=>'blind',
        //		'hide'=>'explode',
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
<?php
// Dialog untuk tindak lanjut pasien ke PI=========================
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
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
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
// Dialog untuk notif penunjang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPerhatian',
    'options' => array(
        'title' => 'Perhatian!',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 400,
        'height' => 300,
        'resizable' => true,
    ),
));
?>
<div id="isiHtml" style="padding: 5px;"></div>
<?php
$this->endWidget();

?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKalkulator',
    'options' => array(
        'title' => 'Kalkulator Infus',
        'autoOpen' => false,
        'modal' => true,
        'width' => 740,
        'height' => 580,
        'resizable' => true,
        //        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
        //                        data: $('#daftarPasien-form').serialize()
        //                    }); }",
    ),
));
?>
<iframe name='frameKalkulator' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'konsultasiInternal',
    'options' => array(
        'title' => 'Konsultasi Internal',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1090,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#caripasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeKonsulInternal' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget();


?>

<?php echo $this->renderPartial('_jsFunctions', array('model' => $model)); ?>