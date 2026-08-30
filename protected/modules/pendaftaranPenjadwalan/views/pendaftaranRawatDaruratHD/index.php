<?php
$this->breadcrumbs = array(
    'Pendaftaran Hemodialisa',
);
?>
<style>
    .panel .panel-title label {
        font-size: inherit;
        color: inherit;
    }

    .panel .panel-title input {
        margin-left: 10px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Pendaftaran <b>Hemodialisa</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'class' => 'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
        }
        if (!empty($model->pendaftaran_id)) {
            $this->flashBpjs($model->pendaftaran_id);
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <?php $autoopen = Yii::app()->user->getState('isantrian'); ?>
        <?php if (!isset($_GET['id'])) : ?>
            <?php $autoopen = Yii::app()->user->getState('isantrian');
            ?>
            <div class="row">
                <?php
                if (!isset($_GET['sukses'])) {
                    if (Yii::app()->user->getState('is_finger_pasien')) {
                ?>
                        <!--<div class="span12">
                                <div class ="control-group">
                                    <div class="controls">
                                        <label>
                                            <div id = "loading"></div>
                                                <?php if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN) {
                                                    echo CHtml::button("Pendaftaran Sidik Jari", array('id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;'));
                                                } ?>
                                                <?php echo CHtml::button("Verifikasi Sidik Jari", array('id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-primary', 'style' => 'background:#142ffb;border:1px solid #142ffb;')); ?>
                                                <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class'=>'btn btn-primary'));  
                                                ?>                
                                            <div id = "pesanVerifikasi"></div>
                                      </label>
                                    </div>
                                </div>
                            </div>-->
                <?php
                    }
                }
                ?>
                <?php if ($autoopen) { ?>
                    <div class="span12">
                        <?php // echo $this->renderPartial($this->path_view . '_formAntrianPendaftaran', array('form' => $form, 'model' => $model, 'modAntrian' => $modAntrian)); 
                        ?>
                    </div>
                    <!--<div class="col-sm-6">
                                    <div class="control-group">
                                    <?php // echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));
                                    ?>
                                        <div class="controls">
                                        <?php // echo $form->hiddenField($model,'antrian_id',array('readonly'=>true));
                                        ?>
                                        <?php // echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id,CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'setFormAntrian("reset");$("#dialog-panggilantrian").dialog("open");') )
                                        ?>
                                        <?php // echo CHtml::textField('noantrian',$modAntrian->noantrian,array('readonly'=>true,'class'=>'span2 form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
                                        ?>
                                        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('id'=>'bth-lihatantrian','title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'$("#dialog-panggilantrian").dialog("open");'));  
                                        ?>
                                        </div>
                                    </div>
                                </div>-->
                <?php } ?>
            </div>
        <?php endif; ?>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data
                    <?php
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 1,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmbaru',
                        'id' => 'pasienbaru',
                    )) . "<label for='pasienbaru'>Pasien Baru</label> ";
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 0,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmlama',
                        'id' => 'pasienlama',
                    )) . "<label for='pasienlama'>Pasien Lama</label> ";
                    ?>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_viewRD2 . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab,)); ?>
                    <!--<div class="clear"></div>
                <div class="col-sm-6">
                    <?php
                    //                        $model->is_adapjpasien = 0;
                    //                        echo $form->hiddenField($model,'is_adapjpasien', array('readonly'=>true,'class'=>'span3 is_adapjpasien','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                    <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-pjpasien',
                        'content'=>array(
                                'content-pjpasien'=>array(
                                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan penanggung jawab pasien')).'<b>Penanggung Jawab Pasien</b>',
                                        'isi'=>$this->renderPartial($this->path_view.'_formPenanggungJawabPasien',array(
                                                        'form'=>$form,
                                                        'modPenanggungJawab'=>$modPenanggungJawab,
                                                        ),true),
                                        'active'=>false,
                                ),   
                        ),
                    ));*/ ?>
                </div>
                <div class="col-sm-6">
                    <?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-pegawai',
                        'content'=>array(
                        'content-pegawai'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan data pegawai')).'<b>Pegawai Penanggung Jawab</b>'.'&nbsp'
                                                .CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>',array('class'=>'btn btn-danger btn-mini pull-center','onclick'=>'resetFormPegawai();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk membersihkan field pegawai penanggung jawab')).'</span>',
                                'isi'=>$this->renderPartial($this->path_view.'_formPegawai',array(
                                                'form'=>$form,
                                                'model'=>$model,
                                                'modPasien' => $modPasien,
                                                'modPegawai' => $modPegawai,
                                                ),true),
                                'active'=>!empty($modPasien->pegawai_id) ? true : false,
                                ),   
                        ),
                    ));*/ ?>
                </div>-->
                    <div class="clear"></div>
                    <div class="col-sm-12">
                        <?php echo $form->hiddenField($model, 'is_vaksinasi', array('readonly' => true, 'class' => 'span3 is_vaksinasi', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-vaksinasi',
                            'content' => array(
                                'content-vaksinasi' => array(
                                    // 'header' => CHtml::htmlButton("<i class='icon-plus icon-white'></i>", array('class' => 'btn btn-dark btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan data pegawai')) . '<b>Pegawai Penanggung Jawab</b>' . '&nbsp'
                                    // . CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini pull-center', 'onclick' => 'resetFormPegawai();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk membersihkan field pegawai penanggung jawab')) . '</span>',
                                    'header' => '<b>Riwayat Vaksinasi/Imunisasi</b>' . '&nbsp',
                                    // . CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini pull-center', 'onclick' => 'resetFormPegawai();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk membersihkan field pegawai penanggung jawab')) . '</span>',
                                    'isi' => $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.vaksinasi._formVaksinasi', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                    ), true),
                                    'active' => $model->is_vaksinasi == 1,
                                ),
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial('_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'modJadwalHD'=>$modJadwalHD)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-karcis',
                            'content' => array(
                                'content-karcis' => array(
                                    'header' => '<b>Karcis</b>',
                                    'isi' => '<div id="content-karcis-html">'
                                        . $this->renderPartial($this->path_view . '_formKarcis', array(
                                            'form' => $form,
                                            'model' => $model,
                                            'modTindakan' => $modTindakan,
                                            'modKarcisV' => $modKarcisV
                                        ), true)
                                        . '</div>',
                                    'active' => $model->is_adakarcis,
                                ),
                            ),
                        )); ?>
                        <?php echo $form->hiddenField($model, 'is_pasienkecelakaan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-kecelakaan',
                            'content' => array(
                                'content-kecelakaan' => array(
                                    'header' => '<b>Kecelakaan</b>',
                                    'isi' => $this->renderPartial('_formKecelakaan', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modKecelakaan' => $modKecelakaan,
                                    ), true),
                                    'active' => false,
                                ),
                            ),
                        )); ?>
                        <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-rujukan',
                            'content' => array(
                                'content-rujukan' => array(
                                    'header' => '<b>Rujukan</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formRujukan', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modRujukan' => $modRujukan,
                                    ), true),
                                    'active' => $model->is_pasienrujukan,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? 'display:none' : '')),
                        )); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asuransi',
                            'content' => array(
                                'content-asuransi' => array(
                                    'header' => '<b>Asuransi Baru</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransi', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasien' => $modAsuransiPasien,
                                    ), true),
                                    'active' => false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? 'display:none' : '')),
                        )); ?>
                        <?php echo $form->hiddenField($model, 'is_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-bpjs',
                            'content' => array(
                                'content-bpjs' => array(
                                    'header' => '<b>BPJS</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransiBpjs', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modRujukanBpjs' => $modRujukanBpjs,
                                        'modAsuransiPasien' => $modAsuransiPasienBpjs,
                                        'modSep' => $modSep,
                                        'pelayanan' => 'RJ', //untuk penentu briging
                                        'pendaftaranHD' => 'pendaftaranHD',
                                        'modAsuransiPasienNon' => $modAsuransiPasien,
                                    ), true),
                                    'active' => (!empty($modSep->sep_id)) ? true : false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (!empty($model->is_bpjs) ? '' : 'display:none')),
                        )); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-inhealth',
                            'content' => array(
                                'content-inhealth' => array(
                                    'header' => '<b>Mandiri Inhealth</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransiInhealth', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modRujukanInhealth' => $modRujukanInhealth,
                                        'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
                                        'modSepInhealthT' => $modSepInhealthT,
                                        'pelayanan' => 'RJ', //untuk penentu briging
                                    ), true),
                                    'active' => (!empty($modSepInhealthT->sep_id)) ? true : false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (!empty($modSepInhealthT->sep_id) ? '' : 'display:none')),
                        ));
                        ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asubadak',
                            'content' => array(
                                'content-asubadak' => array(
                                    'header' => '<b>Asuransi PT. Badak LNG</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransiBadak', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
                                    ), true),
                                    'active' => $model->is_asubadak,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_asubadak) ? '' : 'display:none')),
                        ));
                        ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asudepartemen',
                            'content' => array(
                                'content-asudepartemen' => array(
                                    'header' => '<b>Asuransi Departemen</b>',
                                    'isi' =>
                                    $this->renderPartial($this->path_view . '_formAsuransiDepartemen', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
                                    ), true),
                                    'active' => $model->is_asudepartemen,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_asudepartemen) ? '' : 'display:none')),
                        ));
                        ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asupekerja',
                            'content' => array(
                                'content-asupekerja' => array(
                                    'header' => '<b>Asuransi Pekerja PT. Badak LNG</b>',
                                    'isi' =>
                                    $this->renderPartial($this->path_view . '_formAsuransiPekerja', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
                                        'modPegawai' => $modPegawai,
                                    ), true),
                                    'active' => $model->is_asupekerja,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_asupekerja) ? '' : 'display:none')),
                        ));
                        ?>
                        <?php if (Yii::app()->user->getState('issmsgateway')) {
                            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                'id' => 'form-smsgateway',
                                'content' => array(
                                    'content-smsgateway' => array(
                                        'header' => '<b>Kirim SMS</b>',
                                        'isi' => $this->renderPartial($this->path_view . '_formSms', array('form' => $form, 'modSmsgateway' => $modSmsgateway), true),
                                        'active' => true,
                                    ),
                                ),
                            ));
                        } ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-riwayatpasien',
                            'content' => array(
                                'content-riwayatpasien' => array(
                                    'header' => '<b>Riwayat Kunjungan Pasien <span id="kunjungan_ke"></span></b>',
                                    'isi' => $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
                                        'form' => $form,
                                        'modPasien' => $modPasien,
                                    ), true),
                                    'active' => true,
                                ),
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                (!empty($model->antrian_id)) ? $this->createUrl($this->id . '/index', array('antrian_id' => $model->antrian_id)) : $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else {
                //                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Fitur Bridging tidak aktif!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusRD();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabel();return false", 'disabled' => FALSE));
                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($modSep->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
                if (Yii::app()->user->getState('isbridging')) {
                    if (!isset($modSep->sep_id)) {
                        if (isset($model->carabayar_id) && $model->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                            echo CHtml::link(Yii::t('mds', '{icon} Proses SEP', array('{icon}' => '<i class="entypo-check"></i>')), $this->createUrl("pendaftaranRawatJalan/prosesSEP", array("pendaftaran_id" => $model->pendaftaran_id, "pasien_id" => $modPasien->pasien_id, "frame" => true, 'pelayanan' => "RJ")), array(
                                'rel' => 'tooltip', 'title' => 'Klik untuk Proses SEP!', 'class' => 'btn btn-info',
                                "class" => "btn btn-primary", "onclick" => "$('#dialog-proses-sep').dialog('open');loadFormProsesSEP(this);return false;"
                            ));
                        }
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Proses SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array(
                        'rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info',
                        'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'
                    ));
                }
                if (Yii::app()->user->getState('bridging_inhealth') == TRUE) {
                    if (!empty($model->penjamin_id) && $model->penjamin_id == Params::PENJAMIN_ID_INHEALTH) {
                        echo CHtml::link(Yii::t('mds', '{icon} Proses SJP', array('{icon}' => '<i class="entypo-check"></i>')), $this->createUrl("pendaftaranRawatJalan/prosesSJP", array("pendaftaran_id" => $model->pendaftaran_id, "pasien_id" => $modPasien->pasien_id, "frame" => true, 'pelayanan' => "RJ")), array(
                            'rel' => 'tooltip', 'title' => 'Klik untuk Proses SJP!', 'class' => 'btn btn-info',
                            "class" => "btn btn-primary", "onclick" => "$('#dialog-proses-sjp').dialog('open');loadFormProsesSJP(this);return false;"
                        ));
                    }
                }
            }
            ?>
            <?php
            if (isset($model->pendaftaran_id)) {
                if (Yii::app()->user->getState('is_finger_pasien')) {
                    if (empty($model->pasien->nofingerprint)) {
                        echo CHtml::htmlButton("Pendaftaran Sidik Jari", array('id' => 'regisFP', 'onclick' => "setRegisFP('" . $model->pasien->no_rekam_medik . "');", 'class' => 'btn btn-primary'));
                        echo "<label>";
                        echo '<div id = "regisLoading" style = "width:50px;height:50px;"></div>';
                        echo '<div id = "pesanRegis"></div>';
                        echo "</label>";
                    }
                }
            }

            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Surat Persetujuan Umum ', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            
            } else {
                echo CHtml::link("<i class='entypo-print'></i> Surat Persetujuan Umum", Yii::app()->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatDaruratHD/suratPersetujuanUmum&pendaftaran_id=' . $model->pendaftaran_id), array(
                    'class' => 'btn btn-info',
                    "rel" => "tooltip",
                    "data-placement" => "left",
                    "target" => "iframeSuratUmum",
                    "onclick" => "$('#dialogSuratUmum').dialog('open');",
                    "title" => "Klik untuk Menambahkan Surat Persetujuan Umum"));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
         
        </div>
        <?php $this->endWidget(); ?>
        <hr>
        <?php $this->renderPartial('_tablePendaftaranTerakhir', array('modPasienTerakhir' => $modPasienTerakhir)); ?>
        <?php /*
    $autoopen = Yii::app()->user->getState('isantrian');
    if(!empty($model->pendaftaran_id)){
        $autoopen = false;
    }
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-panggilantrian',
        'options'=>array(
            'title'=>'No. Antrian',
            'autoOpen'=>false,
            'width'=>180,
            'resizable'=>false,
            'position'=>array("right",140),
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php echo $this->renderPartial($this->path_view.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
    </div>
    <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk menampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk menampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
        <br>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil',array('id'=>'btn-panggilantrian','{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}')); ?>
    </div>
    <?php $this->endWidget(); */ ?>
        <?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogSuratUmum',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Persetujuan Umum',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 650,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ location.reload() }",
    ),
));
?>
<iframe src="" name="iframeSuratUmum" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
?>
    
    <?php
// ===========================Dialog Details Rencana Umum Pengadaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailUmum',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Persetujuan Umum',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 650,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ location.reload() }",
    ),
));
?>
<iframe src="" name="iframeDetailUmum" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Rencana Umum Pengadaan================================
?>
    
    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'         => 'dialog-proses-sep',
            'options'     => array(
                'title'         => 'Proses SEP',
                'autoOpen'     => false,
                'modal'         => true,
                'minWidth'     => 960,
                'minHeight'     => 480,
                'resizable'     => false,
            ),
        ));
        echo '<iframe id="iframeProsesSEP"  name="iframeProsesSEP" width="100%" height="550">
    </iframe>';
        ?>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDiagnosaBpjs',
            'options' => array(
                'title' => 'Pencarian Diagnosa Rujukan BPJS',
                'autoOpen' => false,
                'modal' => true,
                'width' => 700,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_view . '_pencarianDiagnosa');
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogSuplesi',
            'options' => array(
                'title' => 'Pencarian Suplesi Jasa Raharja',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_view . '_pencarianSuplesi');
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDpjp',
            'options' => array(
                'title' => 'Pencarian Dokter DPJP',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_view . '_pencarianDpjp');
        $this->endWidget();
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogDpjpMelayani',
            'options' => array(
                'title' => 'Pencarian Dokter DPJP yang Melayani',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_view . '_pencarianDpjpMelayani');
        $this->endWidget();
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogNoRujukan',
            'options' => array(
                'title' => 'Pencarian Rujukan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_view . '_pencarianRujukan');
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogNoRujukanKhusus',
            'options' => array(
                'title' => 'Pencarian Rujukan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial('_pencarianRujukanKhusus');
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-proses-sjp',
            'options' => array(
                'title' => 'Proses SJP',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'minHeight' => 480,
                'resizable' => false,
            ),
        ));
        echo '<iframe id="iframeProsesSJP"  name="iframeProsesSJP" width="100%" height="550" >
        </iframe>';
        $this->endWidget();
        ?>

        <?php
        // Dialog untuk menambah data provinsi =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-verifikasi',
            'options' => array(
                'title' => 'Verifikasi Pendaftaran',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo '<div class="dialog-content"></div>';
        ?>
        <div class="col-sm-12 clear">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#pppendaftaran-t-form").submit();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDiagnosa',
            'options' => array(
                'title' => 'Pencarian Diagnosa Rujukan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modDiagnosa = new PPDiagnosaM('search');
        $modDiagnosa->unsetAttributes();
        if (isset($_GET['PPDiagnosaM'])) {
            $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'diagnosa-m-grid',
            'dataProvider' => $modDiagnosa->search(),
            'filter' => $modDiagnosa,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
                                                if($(\"#content-bpjs\").hasClass(\"in\")){
                                                    setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }else{
                                                    setDiagnosa(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }
                                                $(\"#dialogDiagnosa\").dialog(\"close\");
                                            "))',
                ),
                'diagnosa_kode',
                //'diagnosa_nama',
                array(
                    'header' => 'Nama',
                    'name' => 'diagnosa_namalainnya',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogAsuransi',
            'options' => array(
                'title' => 'Pencarian Asuransi Pasien',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariAsuransiPasien = new PPAsuransipasienM('search');
        $modCariAsuransiPasien->unsetAttributes();
        if (isset($_GET['PPAsuransipasienM'])) {
            $modCariAsuransiPasien->attributes = $_GET['PPAsuransipasienM'];
            isset($_GET['PPAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['PPAsuransipasienM']['pasien_id'] : '';
            isset($_GET['PPAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['PPAsuransipasienM']['penjamin_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'asuransi-m-grid',
            'dataProvider' => $modCariAsuransiPasien->searchDialog(),
            'filter' => $modCariAsuransiPasien,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') . '\").val(formatNumber(\"$data->nominal_tanggungan\"));
                                                                                            setAsuransiLama()
                                                $(\"#dialogAsuransi\").dialog(\"close\");
                                            "))',
                ),
                'nokartuasuransi',
                'nopeserta',
                array(
                    'header' => 'Nama Pemilik Asuransi',
                    'value' => '$data->namapemilikasuransi',
                    'filter' => CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi', array()),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'namaperusahaan',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogAsuransiBpjs',
            'options' => array(
                'title' => 'Pencarian Asuransi Pasien BPJS',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariAsuransiPasienBpjs = new PPAsuransipasienbpjsM('search');
        $modCariAsuransiPasienBpjs->unsetAttributes();
        if (isset($_GET['PPAsuransipasienbpjsM'])) {
            $modCariAsuransiPasienBpjs->attributes = $_GET['PPAsuransipasienbpjsM'];
            isset($_GET['PPAsuransipasienbpjsM']['pasien_id']) ? $modCariAsuransiPasienBpjs->pasien_id = $_GET['PPAsuransipasienbpjsM']['pasien_id'] : '';
            isset($_GET['PPAsuransipasienbpjsM']['penjamin_id']) ? $modCariAsuransiPasienBpjs->penjamin_id = $_GET['PPAsuransipasienbpjsM']['penjamin_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'asuransibpjs-m-grid',
            'dataProvider' => $modCariAsuransiPasienBpjs->searchDialog(),
            'filter' => $modCariAsuransiPasienBpjs,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
                                                getAsuransiNoKartu(\'$data->nopeserta\');
                                                setAsuransiLama()
                                                $(\"#dialogAsuransiBpjs\").dialog(\"close\");
                                            "))',
                ),
                'nokartuasuransi',
                'nopeserta',
                array(
                    'header' => 'Nama Pemilik Asuransi',
                    'value' => '$data->namapemilikasuransi',
                    'filter' => CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariAsuransiPasienBpjs, 'namapemilikasuransi', array()),
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'namaperusahaan',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDokter',
            'options' => array(
                'title' => 'Pencarian Dokter',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariDokter = new PegawaiV('searchDokterDPJP');
        $modCariDokter->unsetAttributes();
        if (isset($_GET['PegawaiV'])) {
            $modCariDokter->attributes = $_GET['PegawaiV'];
            isset($_GET['PegawaiV']['ruangan_id']) ? $modCariDokter->ruangan_id = $_GET['PegawaiV']['ruangan_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'dokter-v-grid',
            'dataProvider' => $modCariDokter->searchDokterDPJP(),
            'filter' => $modCariDokter,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectDokter",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val($data->pegawai_id);
                                                $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");                                            
                                                setAntrianDokter();
                                                $(\"#dialogDokter\").dialog(\"close\");
                                            "))',
                ),
                'gelardepan',
                array(
                    'header' => 'Nama Pegawai',
                    'value' => '$data->nama_pegawai',
                    'filter' => CHtml::activeHiddenField($modCariDokter, 'ruangan_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariDokter, 'nama_pegawai', array()),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                ),
                'gelarbelakang_nama',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogPpjp',
            'options' => array(
                'title' => 'Pencarian PPJP',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        $modCariDokter = new PegawaiV('searchPPJP');
        $modCariDokter->unsetAttributes();
        if (isset($_GET['PegawaiV'])) {
            $modCariDokter->attributes = $_GET['PegawaiV'];
            isset($_GET['PegawaiV']['ruangan_id']) ? $modCariDokter->ruangan_id = $_GET['PegawaiV']['ruangan_id'] : '';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'dokterPpjp-v-grid',
            'dataProvider' => $modCariDokter->searchPPJP(),
            'filter' => $modCariDokter,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectDokter",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($model, 'ppjp_id') . '\").val($data->pegawai_id);
                                                $(\"#' . CHtml::activeId($model, 'nama_ppjp') . '\").val(\"$data->NamaLengkap\");                                            
                                                $(\"#dialogPpjp\").dialog(\"close\");
                                            "))',
                ),
                'gelardepan',
                array(
                    'header' => 'Nama Pegawai',
                    'value' => '$data->nama_pegawai',
                    'filter' => CHtml::activeHiddenField($modCariDokter, 'ruangan_id', array('readonly' => true)) . "" . CHtml::activeTextField($modCariDokter, 'nama_pegawai', array()),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                ),
                'gelarbelakang_nama',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php $this->renderPartial('_jsFunctionsMain', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'statusMenu' => 'rawatInap', 'jnspelayanan' => "RJ")); ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
        <?php
        if (Yii::app()->user->getState('is_finger_pasien')) {
            echo $this->renderPartial('pendaftaranPenjadwalan.views.daftarSidikJariPasien._jsFunctionsFinger', array('modPasien' => $modPasien, 'modul_akses' => 'pendaftaran'));
        }
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        // setValidasiCekDisabled($('#pppendaftaran-t-form'));
    });
</script>
