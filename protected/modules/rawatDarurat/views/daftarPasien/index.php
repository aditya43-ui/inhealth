<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$this->breadcrumbs = array(
    'Daftar Pasien'
);
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul  = $this->module->name;
$control = $this->id;
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
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
<style>
    td>.small-container {
        width: 100%;
        min-height: 60px;
    }

    td>.small-container {
        margin-top: 10px;
    }
</style>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Daftar Pasien <b>Rawat Darurat</b>
        </div>
    </div>
    <div class="panel-body">
        <!-- <div align="right" style="margin-bottom: 20px;">
            <?php
            //  echo CHtml::link(
            //     Yii::t('mds', '{icon} Tambah Pasien IGD', array('{icon}' => '<i class="fa fa-plus"></i>')),
            //     Yii::app()->createUrl($this->module->id . '/daftarPasien/index'),
            //     array(
            //         'title' => 'Tambah Pasien IGD',
            //         'class' => 'btn btn-danger',
            //         // 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            //         "onclick" => "tambahTriage(null);$('#tambahTriage').dialog('open');return false;"
            //     )
            // ); 
            ?>
        </div> -->
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
            'htmlOptions' => array(),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Masuk", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY"
                                    data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>"
                                    data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> -
                                        <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $item = LookupM::getItems('statusperiksa');
                        unset($item['BATAL PERIKSA']);
                        echo $form->dropDownListRow($model, 'statusperiksa', $item, array('class' => 'span4', 'empty' => '-- Pilih --'));
                        ?>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $prefix = array(
                                    0 => Params::PREFIX_RAWAT_DARURAT,
                                );
                                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                                ?>
                                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Rekam Medik')); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>

                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                        <!--									<div class="control-group">		
                                    <?php // echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis')." Tanggal Lahir",'tanggal_lahir', array('class' => 'control-label')) 
                                    ?>
                                    <div class="controls">
                                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awall)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhirl)) ?>">
                                            <i class="entypo-calendar"></i>
                                            <span ><?php // echo date('d M Y', strtotime($model->tgl_awall)) 
                                                    ?> - <?php echo date('d M Y', strtotime($model->tgl_akhirl)) ?></span>
                                            <?php // echo $form->hiddenField($model,'tgl_awall', array('class' => 'start')) 
                                            ?>
                                            <?php // echo $form->hiddenField($model,'tgl_akhirl', array('class' => 'end')) 
                                            ?>
                                        </div>
                                    </div>
								</div>-->
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . "<label for='RDInfoKunjunganRDV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awall',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2 dtPicker3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php $model->tgl_akhirl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhirl, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhirl',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2 dtPicker3',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Tindak Lanjut", 'carakeluar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'carakeluar', Chtml::listData(CarakeluarM::model()->findAll("carakeluar_aktif = TRUE ORDER BY carakeluar_nama ASC"), 'carakeluar_nama', 'carakeluar_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->dropDownListRow(
                                $model,
                                'pegawai_id',
                                CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                    'instalasi_id' => Params::INSTALASI_ID_RD,
                                    'pegawai_aktif' => true,
                                ), array(
                                    'order' => 'nama_pegawai asc'
                                )), 'pegawai_id', 'namaLengkap'),
                                array('empty' => '-- Pilih --', 'class' => 'span3')
                            );
                            ?>
                            <?php
                            $carabayar = CarabayarM::model()->findAll(array(
                                'condition' => 'carabayar_aktif = true',
                                'order' => 'carabayar_nama ASC',
                            ));
                            foreach ($carabayar as $idx => $item) {
                                $penjamins = PenjaminpasienM::model()->findByAttributes(
                                    array(
                                        'carabayar_id' => $item->carabayar_id,
                                        'penjamin_aktif' => true,
                                    ),
                                    array('order' => 'penjamin_nama ASC')
                                );
                                if (empty($penjamins)) unset($carabayar[$idx]);
                            }
                            $penjamin = PenjaminpasienM::model()->findAll(array(
                                'condition' => 'penjamin_aktif = true',
                                'order' => 'penjamin_nama',
                            ));
                            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                                'empty' => '-- Pilih --',
                                'class' => 'span3',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                                ),
                            ));
                            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
                            ?>
                        </div>
                    </div>
                </div>
                <!--fieldset class="box"-->
                <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'no.pendaftaran')); 
                ?>
                <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'alias/nama panggilan')); 
                ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan',)
                    );
                    echo CHtml::hiddenField('pendaftaran_id');
                    echo CHtml::hiddenField('pasien_id');
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/daftarPasien/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Darurat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php echo $this->renderPartial('_tablePasien', array('model' => $model)); ?>
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
                <!--/div-->
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
            </div>
        </div>
    </div>
</div>
<?php
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if (!empty($profil->logo_rumahsakit)) {
    $profrs = Params::urlProfilRSDirectory() . $profil->logo_rumahsakit;
} else {
    $profrs = Params::urlProfilRSDirectory() . "thumb.png";
}
?>
<footer class="main footsty"
    style="padding-bottom:10px;color:#fff;border-bottom-right-radius:10px;border-bottom-left-radius:10px;">
    <center style="color:white">
        <div class="row">
            <div class="col-md-2 bgtemafooterleft" style="">
            </div>
            <div class="col-md-8" align="center">
                <a href="" target="blank" style="color:white">
                    <div
                        style="width:50px;height:50px;margin-bottom:10px;position:relative;border-radius:5px;background-color:white;">
                        <!-- <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ims-login.png" alt=""
                            style="position: absolute;top: 50%;left: 50%;  transform: translate(-50%, -50%);height:15px" /> -->
                    </div>
                    <?php echo $profil->nama_rumahsakit; ?> </strong>&copy; <?php echo date('Y') ?><br>
                </a>
                <a href="" target="blank" style="color:white"></a>, All Rights Reserved
            </div>
            <div class="col-md-2 bgtemafooterright" style="">
            </div>
        </div>
    </center>
</footer>
</div>

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
//========= end pasienpulang_t dialog =============================
// Dialog untuk Batal Rawat Inap =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatalRawatInap',
    'options' => array(
        'title' => 'Pembatalan Tindak Lanjut Rawat Inap / Pulang Pasien Rawat Darurat',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeBatalRawatInap" width="100%" height="400"></iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
<?php
// Dialog untuk pasienpulang_t =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasienPulang',
    'options' => array(
        'title' => 'Tindak Lanjut Pasien Rawat Darurat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
)); ?>
<iframe src="" id="iframePasienPulang" name="iframePasienPulang" width="100%" height="900"></iframe>
<?php
$this->endWidget();
//========= end pasienpulang_t dialog =============================
// Dialog untuk Batal Rawat Inap =========================
/*
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalRawatInap',
        'options'=>array(
            'title'=>'Pembatalan Rawat Inap/ Pulang Pasien Rawat Darurat',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'resizable'=>false,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
<iframe src="" name="iframeBatalRawatInap" width="100%" height="900">
</iframe>
<?php
    $this->endWidget(); */
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
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;')
    ); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<!--dialog untuk menampilkan alaasan pembatalan pasien rawat inap-->
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
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batal();return false;')
    ); ?> </div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<!--akhir dari dialog alasan pasien dibatalkan rewat inap-->
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe name='frameTindakLanjut' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    let daftarId = '';

    const refreshTable = () => {
        $.fn.yiiGridView.update("daftarPasien-grid", {
            data: $("#daftarPasien-form").serialize()
        });
    }

    const setDaftarId = (id) => {
        daftarId = id;

        $.fn.yiiGridView.update("draft-asesmen-triage-grid", {
            data: {
                'DraftasesmentriaseT[default]': ''
            }
        });
    }

    const setPasien = (data) => {
        const asesmenId = data.asesmentriase_id;

        if (asesmenId != '') {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setAsesmenTriage'); ?>',
                data: {
                    asesmenId,
                    daftarId
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == "1") {
                        Notiflix.Report.Success("Perhatian!", "Asesmen Triage berhasil di set", "ok");

                        daftarId = '';
                        refreshTable();

                        $("#dialogDraft").dialog("close");
                    } else {
                        Notiflix.Report.Failure("Perhatian!", "Asesmen Triage gagal di set", "ok");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {

        }
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
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasienPulang-form').serialize()
        });
    }

    function cekHakAkses(pendaftaran_id) {
        //       $('#dialogAlasan #idPasienPulang').val(idPasienPulang);
        //       $('#dialogAlasan #pendaftaran_id').val(pendaftaran_id);
        //       $('#pasien_id').val(pasien_id);
        //       $('#pendaftaran_id').val(pendaftaran_id);
        //    $('#konfirmasiDialog').dialog('open');
        $.post('<?php echo Yii::app()->createUrl('rawatDarurat/ActionAjax/CekHakAkses'); ?>', {
            pendaftaran_id: pendaftaran_id,
            idUser: '<?php echo Yii::app()->user->id; ?>',
            useName: '<?php echo Yii::app()->user->name; ?>'
        }, function(data) {
            //        console.log(data);
            var cekAdmisi = data.pendaftaran.pasienadmisi_id;
            if (cekAdmisi) {
                $('#konfirmasiAdmisi').dialog('open');
                $('#konfirmasiAdmisi #ruanganPasien').html(data.ruanganPasien);
            } else {
                $('#konfirmasiDialog').dialog('open');
                if (data.cekAkses == true) {
                    $('#dialogAlasan').dialog('open');
                    $('#dialogAlasan #idOtoritas').val(data.userid);
                    $('#dialogAlasan #namaOtoritas').val(data.username);
                } else {
                    $('#konfirmasiDialog').dialog('open');
                }
            }
            $('#dialogAlasan #idPasienPulang').val(data.pendaftaran.pasienpulang_id);
            $('#dialogAlasan #pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
            $('#pasien_id').val(data.pendaftaran.pasien_id);
            $('#pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
        }, 'json');
    }

    function cekLogin() {
        pasien_id = $('#pasien_id').val();
        pendaftaran_id = $('#pendaftaran_id').val();
        $.post('<?php echo Yii::app()->createUrl('ActionAjax/CekLoginPembatalRawatInap'); ?>', $('#formLogin').serialize(),
            function(data) {
                if (data.error != '')
                    $('#' + data.cssError).addClass('error');
                if (data.status == 'success') {
                    $.post('<?php echo Yii::app()->createUrl('rawatDarurat/ActionAjax/dataPasien'); ?>', {
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
            $.post('<?php echo Yii::app()->createUrl('rawatDarurat/daftarPasien/BatalRawatInap'); ?>', $('#formAlasan')
                .serialize(),
                function(data) {
                    //            if(data.error != '')
                    //                myAlert(data.error);
                    //            $('#'+data.cssError).addClass('error');
                    if (data.status == 'success') {
                        batal();
                        myAlert('Data Berhasil Disimpan');
                    } else {
                        myAlert(data.status);
                    }
                }, 'json');
        }
    }

    function cekStatus(status) {
        var status = status;
        myAlert("Pasien " + status + " Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
    }

    function cekVerifikasiTindakLanjut(obj, id) {
        $.post('<?php echo $this->createUrl('verifikasiTindakLanjut') ?>', {
            id: id
        }, function(data) {
            if (data.ok == 1) {
                $("#iframePasienPulang").prop('src',
                    '<?php echo Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang"); ?>&pendaftaran_id=' +
                    id +
                    "&dialog=1");
                $("#dialogPasienPulang").dialog('open');
            } else {
                if (data.is_confirm == 1) {
                    myConfirm(data.msg, "Peringatan", function(r) {
                        if (r) {
                            $("#iframePasienPulang").prop('src',
                                '<?php echo Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang"); ?>&pendaftaran_id=' +
                                id +
                                "&dialog=1");
                            $("#dialogPasienPulang").dialog('open');
                        }
                    });
                } else if (data.is_notif == 1) {
                    $("#isiPerhatian").html(data.msg);
                    $("#dialogPerhatian").dialog('open');
                } else {
                    myAlert(data.msg);
                }
            }
        }, 'json');
    }

    function addPasienPulang(pendaftaran_id, pasien_id) {
        $('#pendaftaran_id').val(pendaftaran_id);
        $('#pasien_id').val(pasien_id);
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('ActionAjaxRIRD/addPasienPulang'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);
                    jQuery('.dtPicker2-5').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogPasienPulang').dialog('close') \",1000);
                }
            } ",
        ))
        ?>;
        return false;
    }
</script>
<script>
    function cekResponPasien() {
        $.post('<?php echo $this->createUrl('cekResponTime'); ?>', $("#daftarPasien-form").serialize(), function(data) {
            if (data.total > 0) {
                alert(data.msg);
            }
        }, 'json');
    }

    $(document).ready(function() {
        cekResponPasien();
    });
</script>
<script>
    function ubahStatusPeriksa() {
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('ActionAjaxRIRD/ubahStatusPeriksaRD'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $('#dialogUbahStatus div.divForForm form').submit(ubahStatusPeriksa);
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                }
                else
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
            } ",
        ))
        ?>;
        return false;
    }
</script>
<script type="text/javascript">
    // document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#RDInfoKunjunganRDV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RDInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
    $('document').ready(function() {
        $('#daftarPasien-grid button').each(function() {
            $('#orange').removeAttr('class');
            $('#red').removeAttr('class');
            $('#green').removeAttr('class');
            $('#blue').removeAttr('class');
            $('#orange').attr('class', 'btn btn-danger-blue');
            $('#red').attr('class', 'btn btn-danger-red');
            $('#green').attr('class', 'btn btn-danger');
            $('#blue').attr('class', 'btn btn-danger-yellow');
        });
    });

    function setStatus(obj, status, idpendaftaran) {
        var status = status;
        var idpendaftaran = idpendaftaran;
        myConfirm("Yakin Akan Merubah Status Periksa Pasien?", "Perhatian!", function(r) {
            if (r) {
                //            myAlert(status);
                //            myAlert(idpendaftaran);
                $.post('<?php echo Yii::app()->createUrl('ActionAjaxRIRD/UbahStatusPeriksaPasien'); ?>', {
                    status: status,
                    idpendaftaran: idpendaftaran
                }, function(data) {
                    if (data.status == 'proses_form') {
                        $('#dialogUbahStatusPasien div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                        setTimeout("$('#dialogUbahStatus').dialog('close')", 1000);
                    } else {
                        $('#alertDiv').show();
                    }
                }, 'json');
            } else {
                // preventDefault();
            }
        });
    }

    const genExtTgl = () => {
        $(".tglext").datetimepicker(
                jQuery.extend({
                        showMonthAfterYear: false
                    },
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy',
                        'maxDate': 'd',
                        'timeText': 'Waktu',
                        'hourText': 'Jam',
                        'minuteText': 'Menit',
                        'secondText': 'Detik',
                        'showSecond': true,
                        'timeOnlyTitle': 'Pilih   Waktu',
                        'timeFormat': 'hh:mm:ss',
                        'changeYear': true,
                        'changeMonth': true,
                        'showAnim': 'fold'
                    }
                )
            )
            .parents('.input-append')
            .find(".add-on").click(function() {
                $(this).parents('.input-append').find('.tglext').focus();
            });
    }

    function tambahTriage(pendaftaran_id, obj) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('tambahAsesmenTriage') ?>',
            'data': $(obj).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.form == 'tambah') {
                    $('#tambahTriage div.divForFormTambahTriage').html(data.div);
                    genExtTgl();
                } else if (data.form == 'simpan') {
                    $('#tambahTriage div.divForFormTambahTriage').html(data.div);
                    Notiflix.Report.Success("Perhatian!", "Data berhasil disimpan", "OK");
                    setTimeout("$('#tambahTriage').dialog('close') ", 500);
                } else if (data.form == 'gagal') {
                    Notiflix.Report.Failure("Perhatian!", "Data gagal disimpan" + data.pesan, "OK");
                }
            },
            'cache': false
        });
        return false;
    }

    function tambahTriagePasien(pendaftaran_id, notriage_pasien_id) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        $('#temp_idTriage_pasien').val(notriage_pasien_id);

        console.log(pendaftaran_id);
        console.log(notriage_pasien_id);
        // jQuery.ajax({'url':'<?php echo $this->createUrl('TambahTriagePasien') ?>',
        //     'data':$(this).serialize(),
        //     'type':'post',
        //     'dataType':'json',
        //     'success':function(data){
        //         if (data.status == 'create_form') {
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien').html(data.div);
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien form').submit(tambahTriagePasien);
        //         }else{
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien').html(data.div);
        //             $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                     data: $('form').serialize()
        //             });
        //             setTimeout("$('#tambahTriagePasien').dialog('close') ",500);
        //             // location.reload();
        //         }
        //     },
        //     'cache':false
        // });
        // return false; 
    }
</script>
<?php
$urlSession = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionPendaftaranPasien');
$urlSessionUbahStatus = Yii::app()->createUrl('ActionAjaxRIRD/buatSessionUbahStatus ');
$jscript = <<< JS
function buatSession(pendaftaran_id,pasien_id)
{
    $.post("${urlSession}", { pendaftaran_id: pendaftaran_id,pasien_id: pasien_id },
        function(data){
            'sukses';
    }, "json");
}
function buatSessionUbahStatus(pendaftaran_id)
{
    myConfirm("Yakin Akan Merubah Status Periksa Pasien?","Perhatian!",function(r) {
        if (r){
            $.post("${urlSessionUbahStatus}", {pendaftaran_id: pendaftaran_id },
                function(data){
                    'sukses';
            }, "json");
        }
        else{
            // preventDefault();
        }
    });
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<?php
//======================= Edit Dokter Periksa ======================= 
// $this->beginWidget(
//     'zii.widgets.jui.CJuiDialog',
//     array(
//         'id' => 'editDokterPeriksa',
//         'options' => array(
//             'title' => 'Persetujuan Alih Leader',
//             'autoOpen' => false,
//             'minWidth' => 500,
//             'modal' => true,
//             'height' => 550,
//         ),
//     )
// );
?>
<!-- <iframe name="iframeUbahDokter" style="width: 100%; height: 98%;"></iframe> -->
<?php

// $modDokter = new RDUbahdokterR;
// $modUbahDokter = new RDUbahdokterR;

//$this->renderPartial('_formUbahDokterPeriksa', array('modDokter'=>$modDokter,'modUbahDokter' => $modUbahDokter,'model'=>$model));
// $this->endWidget();
?>
<?php
//======================= Tambah Triage ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'tambahTriage',
        'options' => array(
            'title' => 'Tambah Asesmen Pasien',
            'autoOpen' => false,
            'minWidth' => 1100,
            'modal' => true,
        ),
    )
);

echo '<div class="hide">';
$this->widget('MyDateTimePicker', array(
    'name' => 'pemicu',
    'mode' => 'datetime',
    'options' => array(
        'dateFormat' => Params::DATE_FORMAT,
        'maxDate' => 'd',
    ),
    'htmlOptions' => array('readonly' => true),
));
echo '</div>';

echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo '<div class="divForFormTambahTriage"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//======================= Tambah Triage Pasien ======================= 
// $this->beginWidget(
//     'zii.widgets.jui.CJuiDialog',
//     array(
//         'id' => 'tambahTriagePasien',
//         'options' => array(
//             'title' => 'Pilih No Triage Pasien',
//             'autoOpen' => false,
//             'minWidth' => 500,
//             'modal' => true,
//         ),
//     )
// );
// echo CHtml::hiddenField('temp_idPendaftaranDP_pasien', '', array('readonly' => true));
// echo CHtml::hiddenField('temp_idTriage_pasien', '', array('readonly' => true));
// echo '<div class="divForFormTambahTriagePasien"></div>';
// $this->endWidget('zii.widgets.jui.CJuiDialog');
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

// Dialog untuk ubah respon time =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogResponTime',
    'options' => array(
        'title' => 'Ubah Status Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));

?>
<iframe src="" name="frameResponTime" width="100%" height="450"></iframe>
<?php
$this->endWidget();
?>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa_rd',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal_rd"></span>',
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
//===============================Akhir Dialog Batal Periksa================================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDraft',
    'options' => array(
        'title' => 'Daftar List Asesmen Triage',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'height' => 520,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('grid/_daftarDraft');

$this->endWidget('zii.widgets.jui.CJuiDialog');



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
<div id="isiPerhatian" style="padding: 5px;"></div>
<?php
$this->endWidget();

?>
<script>
    ubahSummaryEnd = function(obj) {
        var grid_id = $(obj).parent().parent().attr("id");
        //console.log(grid_id);
        console.log($('#RDInfoKunjunganRDV_items, #daftarPasien-form :input').serialize());
        $.fn.yiiGridView.update(grid_id, {
            data: $('#RDInfoKunjunganRDV_items, #daftarPasien-form :input').serialize()
        });
        return false;
    }
</script>

<?php
// dialog meninggal
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMeninggal',
    'options' => array(
        'title' => 'Surat Meninggal',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe name="iframeDialogMeninggal" frameborder="0" width="100%" height="98%"></iframe>
<?php
$this->endWidget();
?>