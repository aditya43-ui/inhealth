<style>

    .jawab_konsul {
        background-color:yellow !important;
    }
</style>


<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Inap'
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $('#btn_simpan').prop('disabled', true);
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize(),
            complete: function(){
                $('#btn_simpan').prop('disabled', false);
            }
        });
        return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rawat Inap</b>
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
                <?php echo $this->renderPartial('_formPencarian', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Inap</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tablePasien', ['model' => $model]); ?>
            </div>

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

            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                'id' => 'dialogDetail',
                'options' => array(
                    'title' => 'Detail Riwayat Peminahaan Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'width' => 1000,
                    'height' => 550,
                    'resizable' => false
                ),
            ));
            ?>
            <iframe name='frameDetail' width="100%" height="98%"></iframe>
            <?php $this->endWidget(); ?>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogHakKewajiban',
                'options' => array(
                    'title' => 'Hak & Kewajiban Pasien',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 960,
                    'height' => 580,
                    'resizable' => false,
                ),
            ));
            ?>
            <iframe name="iframeHakKewajiban" style="width: 100%; height: 98%;"></iframe>
            </iframe>
            <?php
            $this->endWidget();
            ?>
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
                    'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
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


            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
            <div style='display:none'>
                <?php
                $this->widget('MyDateTimePicker', array(
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
                ));
                ?>
            </div>
            <?php
            // Dialog untuk Lihat Hasil =========================
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'dialogLihatHasil',
                'options' => array(
                    'title' => 'Hasil Pemeriksaan Laboratorium',
                    'autoOpen' => false,
                    'modal' => true,
                    'minWidth' => 980,
                    'height' => 450,
                    'resizable' => true,
                ),
            ));
            ?>
            <iframe src="" name="iframeLihatHasil" width="100%" height="500">
            </iframe>
            <?php
            $this->endWidget();
            //========= end Lihat Hasil =============================
            ?>
        </div>
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
<?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>
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
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSosialPasien',
    'options' => array(
        'title' => 'Riwayat Data Sosial Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 820,
        'height' => 600,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameSosialPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<!-- Pengantar Pasien -->
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPengantarPasien',
    'options' => array(
        'title' => 'Detail Pengantar Pasien',
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
<iframe name='framePengantarPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatDPJP',
    'options' => array(
        'title' => 'Riwayat Alih DPJP',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe id="frameRiwayatDPJP" name='frameRiwayatDPJP' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk masukkamar_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogMasukKamar',
    'options' => array(
        'title' => 'Masuk Kamar Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 600,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe src="" id="iframePindahKamar" name="iframePindahKamar" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk batal Rawat Inap =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalRawatInap',
    'options' => array(
        'title' => 'Pembatalan Pasien Rawat Inap',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
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
        'title' => 'Transaksi Pemulangan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 700,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe src="" name="iframeTindakLanjut" id="frametindaklanjut" style="width: 100%; height: 98%;"></iframe>
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
        'minWidth' => 900,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
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
));
?>
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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;'));
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;'));
    ?>
</div>
<?php echo CHtml::endForm(); ?>
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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-lock icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'simpanAlasan();return false;'));
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;'));
    ?> </div>
<?php echo CHtml::endForm(); ?>
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php
//bpjs ICARE
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFrameRiwayat',
    'options' => array(
        'title' => 'Riwayat Pelayanan BPJS-Kes (I-Care)',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe id="iframeRiwayatPelayanan" name="iframeRiwayatPelayanan" style="width: 100%; height: 98%;"></iframe>
</iframe>
<?php
$this->endWidget();
?>
<script type="text/javascript">
    function cekAkses(kelompokpegawai_id, pegawai_id){
        console.log('hello')
        if(kelompokpegawai_id == 1 || kelompokpegawai_id == 3){
            if(pegawai_id == <?= Yii::app()->user->getState('pegawai_id') ?>) {
                $("#EditRiwayatDPJP").dialog("open");
            } else {
                myAlert('Anda Tidak Dapat Mengubah Disposisi/Alih Leader (Hak Akses)');
                return false;    
            }
        } else {
            myAlert('Anda Tidak Dapat Mengubah Disposisi/Alih Leader (Hak Akses)');
            return false;
        }
    }

    var id_dokter = "";

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
            myAlert('Anda Belum Mengisi Alasan Pembatalan');
        } else {
            $.post('<?php echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap'); ?>', $('#formAlasan').serialize(), function(data) {
                //            if(data.error != '')
                //                myAlert(data.error);
                //            $('#'+data.cssError).addClass('error');
                if (data.status == 'success') {
                    batal();
                    myAlert('Data Berhasil Disimpan');
                    location.reload();
                } else {
                    myAlert(data.status);
                }
            }, 'json');
        }
    }
</script>
<script>

    $(function(){
        cekPersetujualAlihLeader();
    });

    function cekPersetujualAlihLeader() {
        $.post('<?php echo $this->createUrl('/rawatDarurat/daftarPasien/cekPersetujualAlihLeader'); ?>',{id:''}, function(data) {
            if (data.total > 0) {
                alert(data.msg);
            }
        }, 'json');
    }

    function approve(ubahdokter_id, kelompokpegawai_id) { 
        if(kelompokpegawai_id == 1 || kelompokpegawai_id == 3) {
            myConfirm('Yakin Ingin Menyetujui Alih DPJP?', 'Perhatian !', function(r) {
                if(r) {
                    $.post('<?php echo $this->createUrl('ApproveAlihDPJP'); ?>',{ubahdokter_id:ubahdokter_id}, function(data) {
                        if (data.sukses == 1) {
                            myAlert(data.msg);
                            cekPersetujualAlihLeader();
                            $.fn.yiiGridView.update("daftarPasien-grid", {
                                data: $("#daftarPasien-form").serialize()
                            });
                        }
                    }, 'json');
                }    
            });
        } else {
            myAlert('Anda Tidak Dapat Menyetujui Disposisi/Alih Leader (Hak Akses)');
            return false;
        }
    }


    function addMasukKamar() {
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('rawatInap/pasienRawatInap/addMasukKamarRI'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogMasukKamar div.divForForm').html(data.div);
                    $('#dialogMasukKamar div.divForForm form').submit(addMasukKamar);
                    jQuery('#MasukkamarT_tglmasukkamar').datepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    jQuery('#MasukkamarT_jammasukkamar').timepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {
                   'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    if (data.notif_akomodasi != '') {
                        toastr.success(data.notif_akomodasi);
                    }
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
                    myAlert('Data Kasus Penyakit berhasil di ubah');
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                } else {
                    myAlert('Data Kasus Penyakit gagal di ubah');
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
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa').html(data.div);
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                } else {
                    $('#editDokterPeriksa2 div.divForFormEditDokterPeriksa').html(data.div);
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
            url: '<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
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
                        $("#isiPerhatian").html(data.pesan);
                        $("#dialogPertahian").dialog('open');
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

    function verifikasiPasienKabur() {
        $("#judul_pulang").html("Melarikan Diri");
        $("#dialogTindakLanjut").dialog("open");
    }

    function verifikasiPasienMeninggal() {
        $("#judul_pulang").html("Meninggal");
        $("#dialogTindakLanjut").dialog("open");
    }

    function verifikasiPulangPasien(pendaftaran_id) {
        $("#judul_pulang").html("Pulang");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('VerifikasiRencanaPulang'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                status: 'pulang'
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    if (data.verifikasinull != '') {
                        myAlert(data.pesan);
                    } else {
                        $("#dialogTindakLanjut").dialog("open");
                    }
                } else {
                    myConfirm(data.pesan, "Perhatian!", function(r) {
                        if (r) {
                            $("#dialogTindakLanjut").dialog("open");
                            if (data.statusbayar == 'ada') {
                                // daftarPasien
                            };
                        }
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiKirimanRM(id, kirimrm) {
        myConfirm('Apakah Anda yakin akan menerima dokumen rekam medis pasien? ', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('terimaDokumen'); ?>', {
                    pendaftaran_id: id,
                    pengirimanrm_id: kirimrm
                }, function(data) {
                    if (data.status == 'proses_form') {
                        //$('#dialogStatusDokumen div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                        //setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
                    }
                }, 'json');
            } else {
                // preventDefault();
            }
        });
    }

    function batalRencanaPulang(id) {
        var pasienadmisi_id = id;
        myConfirm("Apakah Anda yakin ingin membatalkan rencana pulang ini?", "Perhatian !", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('BatalRencanaPulangPasienRI'); ?>',
                    data: {
                        pasienadmisi_id: pasienadmisi_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == 1) {
                            myAlert(data.pesan);
                            $.fn.yiiGridView.update('daftarPasien-grid', {
                                data: $('#daftarPasien-form').serialize()
                            });
                        } else {
                            myAlert(data.pesan);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                return false;
            }
        });
    }

    function validasiDialogPindahKamar(id, time) {
        var url = '<?php echo  $this->createUrl('/perawatanIntensif/pasienRawatIntensif/PindahKamarPasienPI') ?>';
        var url_lengkap = url + "&pendaftaran_id=" + id;

        var jam = <?php
                    $waktu = Yii::app()->user->getState('waktutampilalert_akomodasisdhterhitung');
                    echo empty($waktu) ? 3 : $waktu;

                    ?>;
        var d = new Date();
        var sekarang = Math.ceil(d.getTime() / 1000);

        // validasi pasien kurang dari 3 jam di hide
        // if ((sekarang - time) < (jam * 3600)) {
        //     myAlert("Lama rawat pasien kurang dari " + jam + " Jam dan Akomodasi Rawat Inap sudah masuk tagihan. Apakah akan melanjutkan pemindahan pasien ? Jika Ya dan Akomodasi tidak akan dimasukkan ke tagihan, silahkan hapus terlebih dahulu Akomodasi di Tabulasi Tindakan", "Peringatan", function() {
        //         $("#iframePindahKamar").attr("src", url_lengkap);
        //         $("#dialogPindahKamar").dialog("open");
        //     });
        // } else {
            $("#iframePindahKamar").attr("src", url_lengkap);
            $("#dialogPindahKamar").dialog("open");
        // }
    }

    function batalstatusperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Apakah Anda akan membatalkan status pemeriksaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/CancelPemeriksaanAjax') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            myAlert('Pembatalan pemeriksaan berhasil');
                            // window.location = "<?php //echo Yii::app()->createUrl('rawatInap/daftarPasien/index&status=1') 
                                                    ?>";
                            // $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            //     data: $(this).serialize()
                            // });
                            $.fn.yiiGridView.update('daftarPasien-grid', {
                                data: $('#daftarPasien-form').serialize()
                            });
                        } else {
                            if (data.status == 'gagal') {
                                myAlert('Pembatalan pemeriksaan gagal');
                            }
                        }
                    }, 'json'
                );
            }
        });
    }

    function cekVerifikasiMeninggal(pendaftaran_id, pasienadmisi_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatInap/PasienRawatInap/VerifikasiMeninggal'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                pasienadmisi_id:pasienadmisi_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    if (data.verifikasinull != '') {
                        myAlert(data.pesan);
                    } else {
                        verifikasiPasienMeninggal(pendaftaran_id, pasienadmisi_id);
                    }
                } else {
                    if (data.isalert == 1) {
                        myAlert(data.pesan);
                    } else if (data.isnotif == 1) {
                        $("#isiPerhatian").html(data.pesan);
                        $("#dialogPertahian").dialog('open');
                    } else {
                        verifikasiPasienMeninggal(pendaftaran_id, pasienadmisi_id);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiPasienMeninggal(id, pasienadmisi_id) {
        $("#judul_pulang").html("Meninggal");
        console.log('hello world')
        $("#frametindaklanjut").attr("src", "<?php echo Yii::app()->controller->createUrl('/perawatanIntensif/pasienRawatIntensif/TindakLanjutDariPasienPI'); ?>&pendaftaran_id=" + id + "&meninggal=1" + '&pasienadmisi_id=' + pasienadmisi_id);
        $("#dialogTindakLanjut").dialog("open");
    }

    function riwayatPelayanan(noka, kodedokter) {
        console.log(noka, kodedokter);
        $("#dialogFrameRiwayat").dialog('open')
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('/rawatJalan/daftarPasien/riwayatPelayananPasien'); ?>',
            data: {
                noka: noka,
                kodedokter: kodedokter,
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan != '') {
                    myAlert(data.pesan);
                }
                if (data.url != "" || data.url != null) {
                    // $("#dialogFrameRiwayat").dialog('open')
                    $('#iframeRiwayatPelayanan').attr('src', data.url);
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
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
$urlSessionMasukKamar = Yii::app()->createUrl('rawatInap/pasienRawatInap/buatSessionMasukKamar ');
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
$url = Yii::app()->createUrl('ActionAjaxRIRD/batalPindahKamar');
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

//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa',
        'options' => array(
            'title' => 'Pengalihan DPJP',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 530,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo '<div class="divForFormEditDokterPeriksa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPelayanan',
    'options' => array(
        'title' => 'Riwayat Pelayanan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false
    ),
));
?>
<iframe name='frameRiwayatPelayanan' width="100%" height="98%"></iframe>
<?php $this->endWidget(); ?>


<?php
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa2',
        'options' => array(
            'title' => 'Pengalihan DPJP',
            'autoOpen' => false,
            'minWidth' => 650,
            'height' => 530,
            'modal' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); }",
        ),
    )
);

?>
<iframe name="iframeEditDokterPeriksa2" style="width: 100%; height: 98%;"></iframe>

<?php            
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
        'width' => 640,
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
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'EditRiwayatDPJP',
        'options' => array(
            'title' => 'Alih DPJP',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 700,
            'height' => 700,
            'modal' => true,
            'close' => 'js:function(){
                $.fn.yiiGridView.update("daftarPasien-grid", {
                    data: $("#daftarPasien-form").serialize()
                });
                cekPersetujualAlihLeader();
            }'
        ),
    )
);
?>
<iframe name='iframeUbahDokter' width="100%" height="100%"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
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
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTolakAlihLeaderDanDispos',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Form Penolakan Alih DPJP</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 350,
        'resizable' => true,
        'close' => "js:function(){ 
            $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); 
            cekPersetujualAlihLeader();
        }",
    ),
));
?>
<iframe name='iframeAlihLeaderDanDispos' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPilihResep',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Pilih Resep</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 350,
        'resizable' => true,
        'close' => "js:function(){ 
            $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); 
            cekPersetujualAlihLeader();
        }",
    ),
));
?>
<iframe name='iframeDialogPilihResep' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>