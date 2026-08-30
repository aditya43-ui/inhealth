<?php
$this->breadcrumbs = array(
    'Daftar Pasien'
); ?>
<?php 
if(!empty($model->getAsalPoli())){
?>
<style>
    .table-striped > tbody > tr:nth-child(2n+1) > td{
        background-color: #F0E68C !important;
    }
</style>
<?php 
}else{} ?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rawat Jalan</b>
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
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
                    'htmlOptions' => array(),
                ));
                ?>
                <fieldset class="">
                    <?php $this->renderPartial('_search', array('model' => $model, 'form' => $form)); ?>
                </fieldset>
                <iframe id="suarapanggilan" src="" name="suarapenggilan" style="display: none;"></iframe>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'search-button')
                    );
                    ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array(
                            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiRJ', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Jalan <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian terakhir', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();', 'style' => 'font-size:10px;')); ?></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $modul  = $this->module->name;
                $control = $this->id;
                $urlTindakLanjut = Yii::app()->createUrl('actionAjax/pasienRujukRI');
                Yii::app()->clientScript->registerScript('search', "
							$(document).ready(function(){
								$('#caripasien-form').submit(function(){
									$('#daftarpasien-v-grid').addClass('animation-loading');
                                    $('#search-button').prop('disabled', true);
									$.fn.yiiGridView.update('daftarpasien-v-grid', {
										data: $(this).serialize(),
                                        complete: function(){
                                            $('#search-button').prop('disabled', false);
                                        }
									});
									return false;
								});
							});         
							");
                ?>
                <?php
                $js = <<< JS
							$('#cekRiwayatPasien').change(function(){
									$('#divRiwayatPasien').slideToggle(500);
							});        
JS;
                Yii::app()->clientScript->registerScript('JSriwayatPasien', $js, CClientScript::POS_READY);
                ?>
                <div class="block-tabel">
                    <?php echo $this->renderPartial('_tablePasien', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>
<?php $this->endWidget(); ?>
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
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRencanaKontrol',
    'options' => array(
        'title' => 'Rencana Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 900,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe src="" name="iframeRencanaKontrol" width="100%" height="400"></iframe>
<?php
$this->endWidget();
//========= end rencana kontrol dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalRawatInap',
    'options' => array(
        'title' => 'Pembatalan Rawat Inap Rawat Jalan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 800,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe src="" name="iframeBatalRawatInap" width="100%" height="400"></iframe>
<?php
$this->endWidget();
?>
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatus',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Rincian Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatusPasien',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'InfoPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe name='frameInfoPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAlasan',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 900,
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
    ); ?> </div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'konfirmasiDialog',
    'options' => array(
        'title' => 'Konfirmasi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
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
    ); ?> </div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'konfirmasiAdmisi',
    'options' => array(
        'title' => 'Konfirmasi',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 420,
        'height' => 200,
        'resizable' => false,
    ),
)); ?>
<div style="text-align: center;">
    Pasien sudah di rawat di ruangan <div id="ruanganPasien"></div>
    Anda tidak bisa melakukan pembatalan disini,<br>
    Silakan hubungi petugas Rawat Inap yang bersangkutan ?
</div>
<div id=""></div>
<div class="form-actions" align="center">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Yes', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => "$('#konfirmasiAdmisi').dialog('close');")
    ); ?> </div>
<?php $this->endWidget(); ?>
<?php
$urlSessionUbahStatus = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionUbahStatus ');
$jscript = <<< JS
function buatSessionUbahStatus(pendaftaran_id)
{
        myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
            if(r){
                 $.post("${urlSessionUbahStatus}", {pendaftaran_id: pendaftaran_id },
                    function(data){
                        'sukses';
                }, "json");
            }else{
            }
        });
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<?php
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
<?php
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'EditRiwayatDPJP',
        'options' => array(
            'title' => 'DPJP',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 600,
            'height' => 600,
            'modal' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                data: $('#caripasien-form').serialize()
            }); }",
        ),
    )
);
?>
<iframe name='iframeUbahDokter' width="100%" height="100%" id="iframeUbahDokter"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatusPasien',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div class="divForForm"></div>';
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakLanjut',
    'options' => array(
        'title' => 'Tindak Lanjut Rawat Inap',
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
<iframe id="frameTindakLanjut" name='frameTindakLanjut' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

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
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlergiObat',
    'options' => array(
        'title' => 'Riwayat Alergi Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe name='frameAlergiObat' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<?php
//=============================== Ganti Data Pasien Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editPoliklinik',
        'options' => array(
            'title' => 'Ganti Data Ruangan Poliklinik Pasien',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 500,
            'height' => 300,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    )
);
echo CHtml::hiddenField('temp_pendaftaran_id', '', array('readonly' => true));
echo '<iframe name="frameEditPoliklinik" style="width:100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!--/div-->
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
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
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa_rj',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal_rj"></span>',
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
$this->renderPartial($this->path_view . '_formBatalPeriksaDialog');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================
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
<?php $this->endWidget(); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'tindakanInternal',
    'options' => array(
        'title' => 'Pemeriksaan Tindakan',
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
<iframe name='iframeTindakanInternal' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>


<script>
    ubahSummaryEnd = function(obj) {
        var grid_id = $(obj).parent().parent().attr("id");
        //console.log(grid_id);
        //console.log($('#RJInfokunjunganrjV_items, #daftarPasien-form :input').serialize());
        $.fn.yiiGridView.update(grid_id, {
            data: $('#RJInfokunjunganrjV_items, #caripasien-form :input').serialize()
        });
        return false;
    }
    
    
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianTagihanSementara',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Rincian Tagihan Sementara</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#caripasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>