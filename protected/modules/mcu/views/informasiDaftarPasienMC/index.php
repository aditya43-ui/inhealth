<?php $linkHalaman = CustomFunction::getUrlByMenuID(2937); ?>
<?php
/**
 * view utama ini digunakan untuk menampilkan menu informasi pasien MCU
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien MCU',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien MCU</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
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
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
    });         
    ");
        ?>
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
        <?php echo $this->renderPartial('_tablePasien', array('model' => $model)); ?>
    </div>
</div>
<iframe id="suarapanggilan" src="" style="display: none;"></iframe>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>
<?php
// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRencanaKontrol',
    'options' => array(
        'title' => 'Rencana Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 600,
        'height' => 300,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                        data: $('#caripasien-form').serialize()
                                }); }",
    ),
));
?>
<iframe src="" name="iframeRencanaKontrol" width="100%" height="300"></iframe>
<?php
$this->endWidget();
//========= end rencana kontrol dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalRawatInap',
    'options' => array(
        'title' => 'Pembatalan Rawat Inap Rawat Jalan',
        'autoOpen' => false,
        'modal' => true,
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
<?php $this->endWidget(); ?>
<?php
// Dialog untuk ambil Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAmbilHasil',
    'options' => array(
        'title' => 'Penyerahan Hasil MCU',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe src="" name="iframeAmbilHasil" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end ambil Hasil =============================
?>
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatus',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
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
//======================= Edit Dokter Periksa ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editPerawatPJP',
        'options' => array(
            'title' => 'Ganti Perawat Penanggung Jawab',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranPPJP', '', array('readonly' => true));
echo '<div class="divForFormEditPerawatPJP"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
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
<!--rincian paket/non paket MCU-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianPaket',
    'options' => array(
        'title' => 'Rincian Paket/Non Paket MCU',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincianPaket' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!--end-->
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatusPasien',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
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
//=============================== Ubah Dokter Periksa Dialog =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editDokterPeriksa',
        'options' => array(
            'title' => 'Ganti Dokter Periksa',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo '<div class="divForFormEditDokterPeriksa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Ubah Dokter Periksa Dialog =============================
?>
<?php
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbahStatusPasien',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
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
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameTindakLanjut' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>