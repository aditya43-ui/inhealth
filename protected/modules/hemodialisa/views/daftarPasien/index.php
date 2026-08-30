<?php $linkHalaman = CustomFunction::getUrlByMenuID(2847); ?>
<?php
$this->breadcrumbs = array(
    'Daftar Pasien Hemodialisa',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul  = $this->module->name;
$control = $this->id;
Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Daftar Pasien <b>Hemodialisa</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
            'htmlOptions' => array(),
        )); ?>
        <iframe id="suarapanggilan" src="" style="display: none;"></iframe>
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
                            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Pendaftaran')); ?>
                        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 8, 'placeholder' => 'No. Rekam Medik')); ?>
                        <div class="control-group">
                            <?php echo Chtml::label("NIK", 'no_identitas_pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Dokter", 'pegawai_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData($model->getDokter(Yii::app()->user->id), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4 form-control2')); ?>
                            </div>
                        </div>
                        <?php /*
                        <div class="control-group">
                            <?php $model->tgl_awall = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awall, 'yyyy-MM-dd'), 'medium', null); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis') . " Tanggal Lahir", 'tanggal_lahir', array('class' => 'control-label')) ?>
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
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
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
                                        'readonly' => true, 'class' => 'span2 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        */ ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --')); ?>
                        <?php // echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled'));
                        ?>
                        
                        <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                'ajax' => array('type'=>'POST',
                                        'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                        'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                ),
                        )); ?>
                        <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>       
                        <div class="control-group">
                            <?php echo CHtml::label("Kelas Pelayanan",'kelaspelayanan_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php 
                                    // echo $form->dropDownList($model, 'kelaspelayanan_id' , CHtml::listData($model->getKelasPelayananRuangan(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
                                    //                             'empty' => '-- Pilih --',
                                    //                             'ajax'=>array(
                                    //                                     'type'=>'POST',
                                    //                                     'data'=>array(
                                    //                                             'kelaspelayanan_id'=>'js:this.value',
                                    //                                             'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
                                    //                                             ),
                                    //                                     'url'=>$this->createUrl('/ActionDynamic/GetKamarRuanganByKelas',array('encode'=>false,'namaModel'=>get_class($model))),
                                    //                                     'update'=>'#'.CHtml::activeId($model, 'kamarruangan_id'),
                                    //                                     )
                                    //                             ))
                                ?>
                            </div>
                        </div>  
                        <div class="control-group">
                            <?php echo CHtml::label("Kamar Ruangan",'kamarruangan_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php  echo $form->dropDownList($model,'kamarruangan_id', array(),array('empty'=>'-- Pilih --','placeholder'=>'Ketik Nama Pasien','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                            </div>
                        </div> 
                    </div>
                </div>
                    
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <b><i class="entypo-credit-card"></i> Tabel <b>Pasien Hemodialisa</b></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel overflow-x">
                    <?php echo $this->renderPartial('_tablePasien', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
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

?>

<?php

//========= end pasienpulang_t dialog =============================

 $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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
        <iframe name='frameRincian' width="100%" height="90%"></iframe>
        <?php $this->endWidget(); 
        
    // Dialog untuk pasienpulang_t =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogPasienPulang',
        'options'=>array(
            'title'=>'Tindak Lanjut Pasien Hemodialisa',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1000,
            'minHeight'=>600,
            'resizable'=>false,
        ),
    ));?>
    <iframe src="" name="iframePasienPulang" width="100%" height="900">
    </iframe>
    <?php

    $this->endWidget();
    //========= end pasienpulang_t dialog =============================

    // Dialog untuk Batal Rawat Inap =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBatalRawatInap',
        'options'=>array(
            'title'=>'Pembatalan Rawat Inap/ Pulang Pasien Gawat Darurat',
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

    $this->endWidget();
    //========= end ubah status periksa dialog =============================
    ?>


    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'loginDialog',
        'options'=>array(
            'title'=>'Login',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>400,
            'height'=>250,
            'resizable'=>false,
        ),
    ));?>
    <div class="alert alert-block alert-error" id="alertDiv" style="display : none;">
        Kesalahan dalam Pengisian Usename atau Password
    </div>
    <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
        <div class="control-group ">
            <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('username', '', array()); ?>
            </div>
        </div>

        <div class="control-group ">
            <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::passwordField('password', '', array()); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>
        </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>


    <!--dialog untuk menampilkan alaasan pembatalan pasien rawat inap-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogAlasan',
        'options'=>array(
            'title'=>'Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1000,
            'height'=>900,
            'resizable'=>false,
        ),
    ));
    ?>
    <div id="divFormDataPasien"></div>


    <?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formAlasan')); ?>
    <table>
        <tr>
            <td><?php echo CHtml::label('Alasan','Alasan', array('class'=>'')) ?></td>
            <td>
                <?php echo CHtml::textArea('Alasan', '', array()); ?>
                <?php echo CHtml::hiddenField('idOtoritas', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('namaOtoritas', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('idPasienPulang', '', array('readonly'=>TRUE)); ?>
                <?php echo CHtml::hiddenField('pendaftaran_id', '', array('readonly'=>TRUE)); ?>

            </td>
        </tr>
    </table>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'simpanAlasan();return false;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batal();return false;')); ?>    </div> 
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget();?>
    <!--akhir dari dialog alasan pasien dibatalkan rewat inap-->

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'konfirmasiDialog',
        'options'=>array(
            'title'=>'Konfirmasi',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>400,
            'height'=>190,
            'resizable'=>false,
        ),
    ));?>
    <div align="center">
        User Tidak Memiliki Akses Untuk Proses Ini,<br/>
        Yakin Akan Melakukan Ke Proses Selanjutnya ?
    </div>
    <div class="form-actions" align="center">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Yes',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"$('#loginDialog').dialog('open');$('#konfirmasiDialog').dialog('close');")); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} No',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>"$('#konfirmasiDialog').dialog('close');")); ?>    </div> 

    <?php $this->endWidget();?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'konfirmasiAdmisi',
        'options'=>array(
            'title'=>'Konfirmasi',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>420,
            'height'=>200,
            'resizable'=>false,
        ),
    ));?>
    <div align="center">
        Pasien sudah di rawat di ruangan <div id="ruanganPasien"></div>
        Anda tidak bisa melakukan pembatalan disini,<br/>
        Silakan hubungi petugas Rawat Inap yang bersangkutan ?
    </div>
    <div id=""></div>
    <div class="form-actions" align="center">
           <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Yes',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>"$('#konfirmasiAdmisi').dialog('close');")); ?>  </div> 

    <?php $this->endWidget();?>
    <?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTindakLanjut',
        'options' => array(
            'title' => 'Tindak Lanjut Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                            data: $('#daftarPasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe name='frameTindakLanjut' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
<?php
$urlSession = Yii::app()->createUrl('ActionAjaxRIHD/buatSessionPendaftaranPasien');
$urlSessionUbahStatus = Yii::app()->createUrl('ActionAjaxRIHD/buatSessionUbahStatus ');
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
            preventDefault();
        }
    });
}
JS;
Yii::app()->clientScript->registerScript('jsPendaftaran',$jscript, CClientScript::POS_BEGIN);
?>
<?php
    //======================= Edit Dokter Periksa ======================= 
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editDokterPeriksa',
            'options'=>array(
                'title'=>'Ganti Dokter Periksa',
                'autoOpen'=>false,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranDP','',array('readonly'=>true));
    echo '<div class="divForFormEditDokterPeriksa"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php 
// Dialog untuk Melihat riwayat alergi obat pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAlergiObat',
    'options' => array(
        'title' => 'Riwayat Alergi Obat Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
		'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameAlergiObat' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'DialogBatalperiksa',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Batal Tindakan - <span id="titleNamaPasienBatal"></span>',
		'autoOpen'=>false,
//		'show'=>'blind',
//		'hide'=>'explode',
		'zIndex'=>1002,
		'minWidth'=>500,
		'minHeight'=>100,
		'resizable'=>false,
		'modal'=>true,    
		 ),
	));
$this->renderPartial('_formBatalPeriksaDialog');                    

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogStatusDokumen',
        'options' => array(
            'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 400,
            'resizable' => true,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe name='frameStatusDokumen' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
    
    <?php 
    // Dialog untuk Melihat riwayat alergi obat pasien =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogJadwalHD',
        'options' => array(
            'title' => 'Jadwal Hemodialisa',
            'autoOpen' => false,
            'modal' => true,
            'width' => 950,
            'height' => 550,
            'resizable' => true,
//            'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
//                            data: $('#daftarPasien-form').serialize()
//                        }); }",
        ),
    ));
    ?>
    <iframe name='frameJadwalHD' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
	
	<?php 
	// Dialog untuk rubah kamar ruangan =========================
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
		'id' => 'dialogKamarRuangan',
		'options' => array(
			'title' => 'Ubah Kamar Ruangan Pasien',
			'autoOpen' => false,
			'modal' => true,
			'width' => 950,
			'height' => 600,
			'resizable' => true,
			'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
							data: $('#daftarPasien-form').serialize()
						}); }",
		),
	));
	?>
	<iframe name='frameKamarRuangan' width="100%" height="100%"></iframe>
	<?php $this->endWidget(); ?>

<?php $this->renderPartial('_jsFunctions',array('model'=>$model)); ?>
