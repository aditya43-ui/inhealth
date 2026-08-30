<style>
    .tr_isadmin {
        background-color: #FAFAD2 !important;
        color: #111010;
    }

    .tr_isadmin:hover {
        background-color: #FAFAD2 !important;
        color: #111010;
    }
</style>

<?php $linkHalaman = CustomFunction::getUrlByMenuID(1168); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rawat Jalan',
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
        $('#search-button').prop('disabled', true);
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize(),
                complete: function(){
                    $('#search-button').prop('disabled', false);
                }
        });
        return false;
});
");
?>
<?php
$ruangan_id = Yii::app()->user->getState('ruangan_id');
$link = explode("/", $_GET['r']);
if ($link[0] == 'rekamMedis') {
    $anamnesa_link = 'pemeriksaanFisikAnamnesaRK';
} else {
    $anamnesa_link = 'pemeriksaanFisikAnamnesaRJ';
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Rawat Jalan</b>
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
                $form = $this->beginWidget(
                    'ext.bootstrap.widgets.BootActiveForm',
                    array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                        'type' => 'horizontal',
                        'id' => 'formCari',
                        'focus' => '#' . CHtml::activeId($modPPInfoKunjunganRJV, 'no_rekam_medik'),
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'onKeyPress' => 'return disableKeyPress(event)',
                            'class' => 'search-form'
                        ),
                    )
                );
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php /*
                $modPPInfoKunjunganRJV->tgl_awal  = $format->formatDateTimeForUser($modPPInfoKunjunganRJV->tgl_awal);
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPPInfoKunjunganRJV,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$modPPInfoKunjunganRJV,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                               'maxDate'=>'d',
                                               'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                            'class'=>'dtPicker2',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div> 
                </div>
                <?php $modPPInfoKunjunganRJV->tgl_akhir = $format->formatDateTimeForUser($modPPInfoKunjunganRJV->tgl_akhir); ?>
                <div class="control-group">
                    <?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$modPPInfoKunjunganRJV,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                               'maxDate'=>'d',
                                               'dateFormat'=>Params::DATE_FORMAT,
                                           ),
                                            'htmlOptions'=>array('readonly'=>true,
                                            'class'=>'dtPicker2',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                       ));
                        ?>
                    </div> 
                </div>
				 * 
				 */ ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPPInfoKunjunganRJV->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPPInfoKunjunganRJV->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modPPInfoKunjunganRJV->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPPInfoKunjunganRJV->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modPPInfoKunjunganRJV, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modPPInfoKunjunganRJV, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modPPInfoKunjunganRJV, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Rekam Medik')); ?>
                        <?php echo $form->textFieldRow($modPPInfoKunjunganRJV, 'nama_pasien', array('class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                        <?php echo $form->textAreaRow($modPPInfoKunjunganRJV, 'alamat_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'Alamat Pasien')); ?>
                        <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV, 'status_konfirmasi', CustomFunction::getStatusKonfirmasi(), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                        <?php echo $form->textFieldRow($modPPInfoKunjunganRJV, 'no_identitas_pasien', array('class' => 'span4 custom-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'rows' => 3, 'placeholder' => 'NIK')); ?>
                        <div class="control-group">
                            <?php $modPPInfoKunjunganRJV->tgl_awall = date('d M Y', strtotime($modPPInfoKunjunganRJV->tgl_awall)); ?>
                            <?php echo CHtml::label(CHtml::activeCheckBox($modPPInfoKunjunganRJV, 'ceklis') . " <label for='PPInfoKunjunganRJV_ceklis'>Tanggal Lahir</label>", 'tanggal_lahir', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPPInfoKunjunganRJV,
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
                            <?php $modPPInfoKunjunganRJV->tgl_akhirl = date('d M Y', strtotime($modPPInfoKunjunganRJV->tgl_akhirl)); ?>
                            <?php echo CHtml::label('Sampai Dengan', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPPInfoKunjunganRJV,
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
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => Params::INSTALASI_ID_RJ,
                            'ruangan_aktif' => true,
                        ), array(
                            'order' => 'ruangan_nama asc'
                        )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')); ?>
                        <?php echo $form->dropDownListRow(
                            $modPPInfoKunjunganRJV,
                            'pegawai_id',
                            CHtml::listData(DokterV::model()->findAllByAttributes(array(
                                'instalasi_id' => Params::INSTALASI_ID_RJ,
                                'pegawai_aktif' => true,
                            ), array(
                                'order' => 'nama_pegawai asc'
                            )), 'pegawai_id', 'namaLengkap'),
                            array('empty' => '-- Pilih --')
                        ); ?>
                        <?php echo $form->dropDownListRow(
                            $modPPInfoKunjunganRJV,
                            'statusperiksa',
                            Params::statusPeriksaInfoKunjunganRJ(),
                            array('empty' => '-- Pilih --')
                        ); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Petugas Loket', 'create_loginpemakai_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $cp = new CDbCriteria;
                                $cp->join = 'join pegawairuangan_v p on p.pegawai_id = t.pegawai_id';
                                $cp->compare('p.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                                $cp->order = 't.nama_pemakai';
                                $p = LoginpemakaiK::model()->findAll($cp);
                                $arr = array();
                                foreach ($p as $item) {
                                    if (!empty($item->pegawai_id)) {
                                        $arr[$item->loginpemakai_id] = $item->pegawai->nama_pegawai;
                                    }
                                }
                                // var_dump($arr); die;
                                echo $form->dropDownList($modPPInfoKunjunganRJV, 'create_loginpemakai_id', $arr, array('empty' => '-- Pilih --')); ?>
                            </div>
                        </div>
                        <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV, 'asalrujukan_id', CHtml::listData(
                            AsalrujukanM::model()->findAll(array(
                                'condition' => 'asalrujukan_aktif = true',
                                'order' => 'asalrujukan_nama'
                            )),
                            'asalrujukan_id',
                            'asalrujukan_nama'
                        ), array(
                            'empty' => '-- Pilih --',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/GetRujukanDari', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganRJV))),
                                'update' => '#' . CHtml::activeId($modPPInfoKunjunganRJV, 'rujukandari_id'),
                            )
                        )); ?>
                        <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV, 'rujukandari_id', array(), array('empty' => '-- Pilih --')); ?>
                        <?php /* echo $form->dropDownListRow($modPPInfoKunjunganRJV,'propinsi_id', CHtml::listData($modPPInfoKunjunganRJV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                      array('empty'=>'-- Pilih --',
                                            'ajax'=>array('type'=>'POST',
                                                          'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRJV))),
                                                          'update'=>'#PPInfoKunjunganRJV_kabupaten_id'),
                                          'onkeypress'=>"return $(this).focusNextInputField(event)"
                                          )); */
                        ?>
                        <?php /* echo $form->dropDownListRow($modPPInfoKunjunganRJV,'kabupaten_id',array(),
                                   array('empty'=>'-- Pilih --',
                                         'ajax'=>array('type'=>'POST',
                                                       'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRJV))),
                                                       'update'=>'#PPInfoKunjunganRJV_kecamatan_id'),
                                                       'onkeypress'=>"return $(this).focusNextInputField(event)"
                                     ));
                ?>
                <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV,'kecamatan_id',array(),
                                   array('empty'=>'-- Pilih --',
                                         'ajax'=>array('type'=>'POST',
                                                       'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganRJV))),
                                                       'update'=>'#PPInfoKunjunganRJV_kelurahan_id'),
                                                       'onkeypress'=>"return $(this).focusNextInputField(event)"
                                       ));
                ?>
                <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV,'kelurahan_id',array(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                 */ ?>
                        <?php echo $form->dropDownListRow($modPPInfoKunjunganRJV, 'carabayar_id', CHtml::listData($modPPInfoKunjunganRJV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'PPInfoKunjunganRJV')),
                                'update' => '#PPInfoKunjunganRJV_penjamin_id'  //selector to update
                            ),
                        )); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modPPInfoKunjunganRJV, 'penjamin_id', CHtml::listData($modPPInfoKunjunganRJV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array(
                            'class' => 'btn btn-danger',
                            'type' => 'submit',
                            'title' => 'Cari',
                            'id' => 'search-button'
                        )
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-default',
                            'title' => 'Ulang',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRJ', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Jalan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                    $this->renderPartial($this->path_view . '_table', ['modPPInfoKunjunganRJV' => $modPPInfoKunjunganRJV]);
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogFisikAnamnesa',
        'options' => array(
            'title' => 'PemeriksaanFisik&Anamnesa',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 1024,
            'height' => 610,
            'resizable' => true,
        ),
    ));
    ?>
    <iframe src="" name="iframePemeriksaanFisik" style="width: 100%; height: 98%;"></iframe>
    </iframe>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogResume',
        'options' => array(
            'title' => 'Resume Medis',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 1124,
            'height' => 610,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>
    <iframe id="iframeResume" name="iframeResume" style="width: 100%; height: 98%;"></iframe>
    </iframe>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogVerifikasiDiagnosa',
        'options' => array(
            'title' => 'Verifikasi Diagnosa',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 1124,
            'height' => 610,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>
    <iframe id="iframeVerifikasiDiagnosa" name="iframeVerifikasiDiagnosa" style="width: 100%; height: 98%;"></iframe>
    </iframe>
    <?php $this->endWidget(); ?>
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
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogChecklistBerkas',
        'options' => array(
            'title' => 'Checklist Kelengkapan Berkas',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 1124,
            'height' => 700,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>

    <iframe id="iframeChecklistBerkas" name="iframeChecklistBerkas" style="width: 100%; height: 98%;"></iframe>

    <?php $this->endWidget(); ?>


    <script type="text/javascript">
        // here is the magic
        function disableLink() {
            var status = null;
            $("#PPInfoKunjungan-v tbody").find('tr > td[class="rajal"]').each(
                function() {
                    status = $(this).parent().find('td[class="status"]');
                    var xxx = $(this).find('a');
                    if (status.text() == 'SUDAH PULANG') {
                        $(this).text($.trim(xxx.text()));
                        $(this).find('a').remove();
                    }
                }
            );
        }
        disableLink();

        function ubahCaraBayar(namaPasien) {
            $('#titleNamaPasienCaraBayar').html(namaPasien);
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/ubahCaraBayar') ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                        $('#carabayardialog div.divForFormUbahCaraBayar form').submit(ubahCaraBayar);
                    } else {
                        $('#carabayardialog div.divForFormUbahCaraBayar').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#carabayardialog').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function listCaraBayar(idCaraBayar) {
            $('#carabayardialog #tempCaraBayarId').val(idCaraBayar);
            return false;
        }

        function setIdPendaftaran(pendaftaran_id, noPendaftaran) {
            $('#carabayardialog #tempPendaftaranId').val(pendaftaran_id);
            $('#carabayardialog #tempNoPendaftaran').val(noPendaftaran);
        }

        function ubahJenisKelamin(norm) {
            $('#temp_norekammedik').val(norm);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahJenisKelamin') ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                        $('#editJenisKelamin div.divForFormEditJenisKelamin form').submit(ubahJenisKelamin);
                    } else {
                        $('#editJenisKelamin div.divForFormEditJenisKelamin').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editJenisKelamin').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function ubahPasien(norm) {
            $('#temp_norekammedik').val(norm);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahPasienAjax', array('menu' => 'RJ')) ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editPasien div.divForFormEditPasien').html(data.div);
                        $('#editPasien div.divForFormEditPasien form').submit(ubahPasien);
                    } else {
                        $('#editReditPasienM div.divForFormEditPasien').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editPasien').dialog('close') ", 1000);
                    }
                },
                'cache': false
            });
            return false;
        }

        function ubahKelompokPenyakit(pendaftaran_id) {
            $('#temp_idPendaftaran').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRD/ubahKelompokPenyakit', array('menu' => 'RJ')) ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editKelPenyakit div.divForFormEditKelPenyakit').html(data.div);
                        $('#editKelPenyakit div.divForFormEditKelPenyakit form').submit(ubahKelompokPenyakit);
                    } else {
                        $('#editKelPenyakit div.divForFormEditKelPenyakit').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editKelPenyakit').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function ubahDokterPeriksa(pendaftaran_id) {
            $('#temp_idPendaftaranDP').val(pendaftaran_id);
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
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function ubahKeterangan(pendaftaran_id) {
            $('#temp_idPendaftaranKet').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahKeteranganPendaftaran') ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                        $('#editKeterangan div.divForFormEditKeterangan form').submit(ubahKeterangan);
                    } else {
                        $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editKeterangan').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }
    </script>
    <?php
    //========================================= Jenis Penjamin dialog =============================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'carabayardialog',
        'options' => array(
            'title' => 'Ganti Jenis Penjamin dan Penjamin <span id="titleNamaPasienCaraBayar"></span>',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 470,
            'height' => 480,
            'modal' => true,
            'resizable' => false,
            'close' => 'js:function() {$.fn.yiiGridView.update("PPInfoKunjungan-v")}'
            //'hide'=>explode,
        ),
    ));
    echo '<iframe id="iframeUbahCaraBayar"  name="iframeUbahCaraBayar" style="width: 100%; height: 98%;"></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //========================================================= end cara bayar dialog =========

    //========================================= Ubah Perujuk Dialog =============================//
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'DialogPerujuk',
        'options' => array(
            'title' => 'Ubah Data Perujuk',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 550,
            'height' => 500,
            'modal' => true,
            'resizable' => false,
            'close' => 'js:function() {$.fn.yiiGridView.update("PPInfoKunjungan-v")}'
            //'hide'=>explode,
        ),
    ));
    echo '<iframe id="iframeUbahPerujuk"  name="iframeUbahPerujuk" style="width: 100%; height: 98%;"></iframe>';
    // $this->renderPartial($this->path_view . '_formRujukan');
    ?>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    //========================================================= end cara bayar dialog ============//

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
            'resizable' => false,
            'modal' => true,
        ),
    ));
    $this->renderPartial($this->path_view . '_formBatalPeriksaDialog');
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Batal Periksa================================

    //=============================== Ganti Poli Dialog =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'ganti_poli',
        'options' => array(
            'title' => 'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
            'autoOpen' => false,
            'zIndex' => 1002,
            'minWidth' => 400,
            'modal' => true,
        ),
    ));
    ?>
    <div id="form-ubahruangan">
        <table style=" border-spacing: 10px;
    border-collapse: separate;">
            <tr>
                <td>Poliklinik</td>
                <td>:</td>
                <td>
                    <?php echo CHtml::dropDownList('ruangan_sebelumnya', '', array(), array('disabled' => true)); ?>
                    <?php echo CHtml::hiddenField('ruangan_awal', '', array('readonly' => true)); ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Kasus Penyakit</td>
                <td>:</td>
                <td>
                    <?php echo CHtml::dropDownList('jeniskasuspenyakit_sebelumnya', '', array(), array('disabled' => true)); ?>
                    <?php echo CHtml::hiddenField('jeniskasuspenyakit_awal', '', array('readonly' => true)); ?>
                </td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td>
                    <?php echo CHtml::dropDownList('pegawai_sebelumnya', '', array(), array('disabled' => true)); ?>
                    <?php echo CHtml::hiddenField('pegawai_awal', '', array('readonly' => true)); ?>
                </td>
            </tr>
            <tr>
                <td>Alasan Perubahan <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo CHtml::textArea('alasanperubahan', '', array('placeholder' => 'Alasan Perubahan',)); ?></td>
            </tr>
            <tr>
                <td>Menjadi Poliklinik</td>
                <td>:</td>
                <td><?php echo CHtml::dropDownList(
                        'ruangan_id_ganti',
                        'ruangan_id_ganti',
                        array(),
                        array('empty' => '-- Pilih --', 'onChange' => 'getKasusPenyakit();listKarcis(this.value);')
                    ); ?></td>
            </tr>
            <tr>
                <td>Menjadi Jenis Kasus Penyakit</td>
                <td>:</td>
                <td><?php echo CHtml::dropDownList(
                        'jeniskasuspenyakit_id_ganti',
                        'jeniskasuspenyakit_id_ganti',
                        array(),
                        array('empty' => '-- Pilih --')
                    ); ?></td>
            </tr>
            <tr>
                <td>Menjadi Dokter</td>
                <td>:</td>
                <td><?php echo CHtml::dropDownList(
                        'pegawai_id_ganti',
                        'pegawai_id_ganti',
                        array(),
                        array('empty' => '-- Pilih --')
                    ); ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <fieldset id="fieldsetKarcis" class="">
                        <?php echo CHtml::checkBox(
                            'is_ubahkarcis',
                            $modPPInfoKunjunganRJV->adaKarcis,
                            array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'setValue();')
                        ) ?>
                        Ubah Karcis
                        <?php echo $this->renderPartial(
                            $this->path_view . '_formKarcis',
                            array('modPPInfoKunjunganRJV' => $modPPInfoKunjunganRJV)
                        ); ?>
                    </fieldset>
                </td>
            </tr>
        </table>
        <?php
        echo CHtml::hiddenField('pendaftaran_id');
        echo CHtml::hiddenField('pasien_id');
        echo CHtml::hiddenField('instalasi_id');
        echo CHtml::hiddenField('pegawai_id');
        echo CHtml::hiddenField('kelaspelayanan_id');
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanUbahRuangan();')
        );
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printKarcis();return false')
        );
        // echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-cancel"></i>')),
        //                                                 array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#ganti_poli\').dialog(\'close\');'));
        ?>
    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog');
    //================================ end Ganti Ruangan Dialog =================================
    //======================================================JAVA SCRIPT===================================================                          
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    //$urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaran/lembarPoliRJ',array('pendaftaran_id'=>''));
    //$urlPrintKartuPasien = Yii::app()->createUrl($module.'/pendaftaran/print/kartuPasien',array('pendaftaran_id'=>''));
    $urlPrintKartu = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKartuPasien', array('pasien_id' => ''));
    $urlPrintKarcisStruk = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKarcis', array('pendaftaran_id' => ''));
    $urlPrintLembarPoli = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus', array('pendaftaran_id' => ''));
    $urlPrintLabel = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printLabel', array('pendaftaran_id' => ''));
    $urlPrintStiker = Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/printStiker', array('pendaftaran_id' => ''));
    $urlPrintKlaim = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printKlaim', array('pendaftaran_id' => ''));
    $urlPrintCasemix = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printCasemix', array('pendaftaran_id' => ''));
    $urlPrintCasemixIdentitas = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printCasemixIdentitas', array('id' => ''));
    $urlPrintKepalaLes = Yii::app()->createUrl('pendaftaranPenjadwalan/InfoKunjunganRJ/printKepalaLes',array('pendaftaran_id' => ''));
    $urlListDokterRuangan = $this->createUrl('listDokterRuangan');
    $urlGetRuangan = $this->createUrl('GetRuanganPasien');
    $urlPrintKarcis = $this->createUrl('PrintKarcis');
    $urlListKarcis = Yii::app()->createUrl('pendaftaranPenjadwalan/InfoKunjunganRJ/listKarcis');
    $statusPeriksaBatalPeriksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
    $karcis = Yii::app()->user->getState('karcisbarulama');
    $karcis = ($karcis) ? true : 0;
    $js = <<< JSCRIPT
//=======================================Awal Print Lembar Poli==========================================================
function print(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');    
}
//========================================Akhir Print Lembar Poli========================================================
function printKartu(pasien_id)
{
   window.open('${urlPrintKartu}'+pasien_id,'printwin','left=100,top=100,width=400,height=400');    
}
function printStruk(pendaftaran_id)
{
   window.open('${urlPrintKarcisStruk}'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=700');    
}
function printStatus(pendaftaran_id)
{
   window.open('${urlPrintLembarPoli}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}   
function printLabel(pendaftaran_id)
{
   window.open('${urlPrintLabel}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
} 

function printStiker(pendaftaran_id)
{
   window.open('${urlPrintStiker}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
} 


function printCasemix(pendaftaran_id)
{
   window.open('${urlPrintCasemix}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
} 

function printCasemixIden(pendaftaran_id)
{
   window.open('${urlPrintCasemixIdentitas}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
}
function printKepalaLes(pendaftaran_id) {
    window.open('${urlPrintKepalaLes}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600'); 
}

function printKlaim(pendaftaran_id)
{
   window.open('${urlPrintKlaim}'+pendaftaran_id,'printwin','left=100,top=100,width=700,height=600');    
} 
//========================================Awal Ganti Ruangan=============================================================
function gantiPoli(pendaftaran_id,ruangan_id,instalasi_id,pasien_id,namaPasien,jeniskasuspenyakit_id,pegawai_id,kelaspelayanan_id)
    {
        $('#titleNamaPasien').html(namaPasien);
           $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id,
           jeniskasuspenyakit_id:jeniskasuspenyakit_id,pegawai_id:pegawai_id,kelaspelayanan_id:kelaspelayanan_id},
           function(data){
            $('#ganti_poli').dialog('open');
            $('#ganti_poli #ruangan_awal').val(ruangan_id);
            $('#ganti_poli #jeniskasuspenyakit_awal').val(jeniskasuspenyakit_id);
            $('#ganti_poli #pegawai_awal').val(pegawai_id);
            $('#ganti_poli #ruangan_sebelumnya').html(data.dropDown);
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #jeniskasuspenyakit_sebelumnya').html(data.jenisKasusPenyakit);
            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);
            $('#ganti_poli #pegawai_sebelumnya').html(data.dokter);
            $('#ganti_poli #pegawai_id_ganti').html(data.dokter);
            $('#ganti_poli #pendaftaran_id').val(pendaftaran_id);
            $('#ganti_poli #pasien_id').val(pasien_id);
            $('#ganti_poli #instalasi_id').val(instalasi_id);
            $('#ganti_poli #pegawai_id').val(pegawai_id);
            $('#ganti_poli #kelaspelayanan_id').val(kelaspelayanan_id);
        }, "json");
    }
	function printKarcis()
	{
		var pendaftaran_id= $('#ganti_poli #pendaftaran_id').val();
		window.open('${urlPrintKarcis}&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=400,height=400');
	}
//========================================Akhir Ganti Ruangan===========================================================
JSCRIPT;
    Yii::app()->clientScript->registerScript('javascript', $js, CClientScript::POS_HEAD);
    $js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
    Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
    ?>
    <script type="text/javascript">
        function ubahKelasPelayanan(pendaftaran_id) {
            $('#temp_idPendaftaranKP').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahKelasPelayanan', array('menu' => 'RJ')) ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                        $('#editKelasPelayanan div.divForFormEditKelasPelayanan form').submit(ubahKelasPelayanan);
                    } else {
                        $('#editKelasPelayanan div.divForFormEditKelasPelayanan').html(data.div);
                        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editKelasPelayanan').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }
    </script>
    <?php
    // Dialog untuk Batal Rawat Inap =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogBatalRawatInap',
        'options' => array(
            'title' => 'Pembatalan Tindak Lanjut Rawat Inap',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 800,
            'height' => 400,
            'resizable' => false,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
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
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editJenisKelamin',
            'options' => array(
                'title' => 'Ganti Data Jenis Kelamin',
                'autoOpen' => false,
                'zIndex' => 1002,
                'minWidth' => 500,
                'modal' => true,
                'close' => 'js:function(){
                    $.fn.yiiGridView.update(\'PPInfoKunjungan-v\')
                }',
            ),
        )
    );
    echo CHtml::hiddenField('temp_norekammedik', '', array('readonly' => true));
    echo '<div class="divForFormEditJenisKelamin"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editKelPenyakit',
            'options' => array(
                'title' => 'Ganti Data Kelompok Penyakit',
                'autoOpen' => false,
                'zIndex' => 1002,
                'minWidth' => 500,
                'modal' => true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaran', '', array('readonly' => true));
    echo '<div class="divForFormEditKelPenyakit"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    //=============================== Ganti Data Pasien Dialog =======================================
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editPasien',
            'options' => array(
                'title' => 'Ganti Data Pasien',
                'autoOpen' => false,
                'zIndex' => 1002,
                'width' => 1000,
                'height' => 560,
                'resizable' => true,
                'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                            data: $('#formCari').serialize()
                        }); }",
            ),
        )
    );
    echo CHtml::hiddenField('temp_norekammedik', '', array('readonly' => true));
    echo '<iframe name="frameEditPasien" style="width: 100%; height: 98%;"></iframe>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
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
    //=============================== Ganti Data Keterangan pendaftaran =======================================
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editKeterangan',
            'options' => array(
                'title' => 'Ubah keterangan Pendaftaran',
                'autoOpen' => false,
                'minWidth' => 500,
                'modal' => true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranKet', '', array('readonly' => true));
    echo '<div class="divForFormEditKeterangan"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    //=============================== Ganti Data Jenis Kelamin Dialog =======================================
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
    ?>
    <?php
    // Dialog untuk rencana kontrol =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogRencanaKontrol',
        'options' => array(
            'title' => 'Rencana Kontrol',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 900,
            'height' => 500,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
        ),
    ));
    ?>
    <iframe src="" name="iframeRencanaKontrol" width="100%" height="520"></iframe>

    <?php
    $this->endWidget();
    ?>
    <?php
    //=============================== Ganti Data Kelas Pelayanan Dialog =======================================
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'editKelasPelayanan',
            'options' => array(
                'title' => 'Ganti Kelas Pelayanan',
                'autoOpen' => false,
                'zIndex' => 1002,
                'minWidth' => 500,
                'modal' => true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranKP', '', array('readonly' => true));
    echo '<div class="divForFormEditKelasPelayanan"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <!-- Penambahan untuk dialog pemeriksaan pasien -->
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
    <!-- End Penambahan untuk dialog untuk pemeriksaan pasien -->
    <?php
    $urlSessionUbahStatus = $this->createUrl('buatSessionUbahStatus ');
    $jscript = <<< JS
function buatSessionUbahStatus(pendaftaran_id)
{
//     myConfirm("Yakin Akan Merubah Status Periksa Pasien?","Perhatian!",function(r) {
        // if (r){
            $.post("${urlSessionUbahStatus}", {pendaftaran_id: pendaftaran_id },
                function(data){
                    'sukses';
            }, "json");
            ubahStatusPeriksa();
        // }
//    });
}
JS;
    Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
    ?>
    <script>
        function ubahStatusPeriksa() {
            <?php
            echo CHtml::ajax(array(
                'url' => Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/ubahStatusPeriksaRJ'),
                'data' => "js:$(this).serialize()",
                'type' => 'post',
                'dataType' => 'json',
                'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogUbahStatus').dialog('open');
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $('#dialogUbahStatus div.divForForm form').submit(ubahStatusPeriksa);
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    return false;
                }
                else
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('PPInfoKunjungan-v');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
            } ",
            ))
            ?>;
            return false;
        }

        $(document).ready(function() {
            var penj = jQuery('#<?php echo CHtml::activeId($modPPInfoKunjunganRJV, 'penjamin_id') ?>');

            jQuery(penj).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
            }).hide();
        });
    </script>
    <!--UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI-->
    <?php
    $js = <<< JSCRIPT
function getKasusPenyakit(){
    ruangan_id = $('#ruangan_id_ganti').val();
    pendaftaran_id = $('#pendaftaran_id').val();
    pasien_id = $('#pasien_id').val();
    instalasi_id = $('#instalasi_id').val();
    pegawai_id = $('#pegawai_id').val();
    jeniskasuspenyakit_id = '';  
   $.post("${urlGetRuangan}", { pendaftaran_id: pendaftaran_id, ruangan_id: ruangan_id, instalasi_id:instalasi_id, pasien_id:pasien_id,
   jeniskasuspenyakit_id:jeniskasuspenyakit_id,pegawai_id:pegawai_id},
   function(data){
            $('#ganti_poli').dialog('open');            
            $('#ganti_poli #ruangan_id_ganti').html(data.dropDown);
            $('#ganti_poli #jeniskasuspenyakit_id_ganti').html(data.jenisKasusPenyakit);   
            $('#ganti_poli #pegawai_id_ganti').html(data.dokter);
    }, "json");
}
function listKarcis(obj)
{
     kelasPelayanan=$('#ganti_poli #kelaspelayanan_id').val();
     ruangan=$('#ganti_poli #ruangan_id_ganti').val();
     pendaftaran_id=$('#ganti_poli #pendaftaran_id').val();
     if(kelasPelayanan!='' && ruangan!=''){
            $('#tblFormKarcis tbody').remove();
             $.post("${urlListKarcis}", { kelasPelayanan: kelasPelayanan, ruangan:ruangan, pendaftaran_id:pendaftaran_id},
                function(data){
                    $('#tblFormKarcis').append(data.form);
                    if (${karcis}){
                        if (jQuery.isNumeric(data.karcis.karcis_id)){
                            tdKarcis = $('#tblFormKarcis tbody tr').find("td a[data-karcis='"+data.karcis.karcis_id+"']");
                            changeBackground(tdKarcis, data.karcis.daftartindakan_id, data.karcis.harga_tariftindakan, data.karcis.karcis_id);
                        }else{
                            $('#TindakanpelayananT_idTindakan').val('');  
                            $('#TindakanpelayananT_tarifSatuan').val('');   
                            $('#TindakanpelayananT_idKarcis').val('');  
                        }
                    }
             }, "json");
     }      
}
function changeBackground(obj,idTindakan,tarifSatuan,idKarcis)
{
        banyakRow=$('#tblFormKarcis tr').length;
        for(i=1; i<=banyakRow; i++){
            $('#tblFormKarcis tr').css("background-color", "#FFFFFF");          
        } 
        $(obj).parent().parent().css("backgroundColor", "#00FF00");     
        $('#TindakanpelayananT_idTindakan').val(idTindakan);  
        $('#TindakanpelayananT_tarifSatuan').val(tarifSatuan);   
        $('#TindakanpelayananT_idKarcis').val(idKarcis);  
}   
function setValue(){
$('#karcisTindakan').change(function(){
    if ($(this).is(':checked')){
            $(this).val(1);
    }else{
            $(this).val(0);
    }
});
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('getKasusPenyakit', $js, CClientScript::POS_HEAD);
    ?>
    <!--UNTUK PERUBAHAN JENIS KASUS PENYAKIT DI UBAH POLI-->
    <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
</div>