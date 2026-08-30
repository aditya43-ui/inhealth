<?php $linkHalaman = CustomFunction::getUrlByMenuID(29); ?>
<?php $linkBedTriage = CustomFunction::getUrlByMenuID(4283); ?>
<style>
    .panel .panel-title label {
        font-size: inherit;
        color: inherit;
    }

    .panel .panel-title input {
        margin-left: 10px !important;
    }

    .pesan_bpjs {
        color: #B94A49 !important;
        background-color: #FFF086 !important;
    }
    .floating-button {
        position: fixed;
        bottom: 50px;
        right: 50px;
        background-color: #006838;
        border: 1px solid white;
        color: white;
        padding: 8px 10px;
        border-radius: 100px;
        cursor: pointer;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .floating-button:hover {
        background-color: #006838;
    }
</style>

<span class="floating-button" <?= isset($_GET['is_triage']) && $_GET['is_triage'] == 1 ? '' : 'hidden' ?>>
    <i class="fas fa-external-link-alt"></i>
    <a href="<?= !empty($linkBedTriage) ? $linkBedTriage : '#'; ?>" class="btn btn-secondary hide" target="_self">
         Ke Halaman Informasi Bed Triage
    </a>
</span>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Pendaftaran <b>Rawat Darurat</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($modPasien->pasien_id)) {
            $this->breadcrumbs = array(
                'Informasi Pencarian Pasien' => Yii::app()->request->getUrlReferrer(),
                'Pendaftaran Rawat Darurat',
            );
        } else {
            $this->breadcrumbs = array(
                'Pendaftaran Rawat Darurat'
            );
        }
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('class' => 'form_pendaftaran', 'onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            $log = BpjslogR::model()->findByAttributes(array(
                'pendaftaran_id' => $_GET['id'],
            ));
            if (!empty($log) && $log->code != 200) {
                Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan <br>" . '<span class = "pesan_bpjs">BPJS Error ' . $log->code . ': ' . $log->pesan . "</span>");
                // $this->flashBpjs($model->pendaftaran_id);
            } else {
                Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
            }

            // $this->flashBpjs($model->pendaftaran_id);
        }
        if (!empty($model->pendaftaran_id)) {
            $this->flashBpjs($model->pendaftaran_id);
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php /*
            if(Yii::app()->user->getState('issmsgateway')){
               $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
            }
            */ ?>
            </div>
        </div>
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
                        'id' => 'pasienbaru'
                    )) . "<label for='pasienbaru'>Pasien Baru</label> ";
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 0,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmlama',
                        'id' => 'pasienlama'
                    )) . "<label for='pasienlama'>Pasien Lama</label> ";
                    ?>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'rd' => true)); ?>
                    <div class="clear" style="margin-bottom: 17px;"></div>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3 is_adapjpasien', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        // echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); 
                        ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pjpasien',
                            'content' => array(
                                'content-pjpasien' => array(
                                    'header' => '<b>Penanggung Jawab Pasien</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formPenanggungJawabPasien', array(
                                        'form' => $form,
                                        'modPenanggungJawab' => $modPenanggungJawab,
                                    ), true),
                                    'active' => true,
                                ),
                            ),
                        )); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pegawai',
                            'content' => array(
                                'content-pegawai' => array(
                                    'header' => '<b>Pegawai Penanggung Jawab</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formPegawai', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modPegawai' => $modPegawaiPJ,
                                    ), true),
                                    'active' => !empty($modPenanggungJawab->pegawai_id) ? true : false,
                                ),
                            ),
                        )); ?>
                    </div>
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
                                    'isi' => $this->renderPartial($this->path_view . 'vaksinasi._formVaksinasi', array(
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
                    <i class="glyphicon glyphicon-user"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat._formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
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
                                    'isi' => $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat._formKecelakaan', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modKecelakaan' => $modKecelakaan,
                                    ), true),
                                    'active' => false,
                                ),
                            ),
                        )); ?>
                    </div>
                    <div class="col-sm-6">
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
                        ));
                        ?>
                        <?php echo $form->hiddenField($model, 'is_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asuransi-igd',
                            'content' => array(
                                'content-asuransi-igd' => array(
                                    // 'header' => CHtml::htmlButton("<i class='icon-plus icon-white'></i>", array('class' => 'btn btn-dark btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Tampilkan Asuransi')) . '<b><span class="judulasuransi">Asuransi Baru</span> </b> &nbsp &nbsp <span class="refreshasuransi" style="display:none;">'
                                    // . CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini pull-center', 'onclick' => 'setAsuransiBaru("badak");', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk input asuransi baru')) . '</span>',
                                    'header' => '<b>BPJS IGD</b>',
                                    'isi' => $this->renderPartial($this->path_viewRD . '_formSEP_new', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasien' => $modAsuransiPasien,
                                        'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
                                        'modSep' => $modSep,
                                        'modRujukanBpjs' => $modRujukanBpjs,
                                    ), true),
                                    'active' => false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? 'display:none' : '')),
                        ));
                        ?>
                        <?php
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                            'id' => 'dialogSuplesi',
                            'options' => array(
                                'title' => 'Pencarian Suplesi Jasa Raharja',
                                'autoOpen' => false,
                                'modal' => true,
                                'width' => 600,
                                'height' => 480,
                                'resizable' => false,
                            ),
                        ));
                        echo $this->renderPartial('_pencarianSuplesi');
                        $this->endWidget();
                        ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-inhealth',
                            'content' => array(
                                'content-inhealth' => array(
                                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Tampilkan Asuransi',)) . '<b> Mandiri Inhealth ',
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
                                    'header' => '<b>Riwayat Kunjungan Pasien</b>',
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
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();', 'title' => 'Simpan')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'title' => 'Simpan', 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);',
                    'title' => 'Ulang'
                )
            ); ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Struk Kunjungan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
                echo CHtml::link(Yii::t('mds', '{icon} Print Gelang Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                //                        echo CHtml::link(Yii::t('mds', '{icon} Print Label RM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'labelrm btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
            } else {
                //echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Struk Kunjungan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusRD();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabelRD();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Gelang Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printGelangPasien();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Stiker', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStiker();return false", 'disabled' => FALSE));
                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($modSep->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                }
                //                        echo CHtml::link(Yii::t('mds', '{icon} Print Label RM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printLabelRM();return false",'disabled'=>FALSE  )).'&nbsp;'; 
            }
            if (Yii::app()->user->getState('bridging_inhealth') == TRUE) {
                if (!empty($modSepInhealthT->sep_id) && isset($modSepInhealthT->sep_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak SJP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSJPInhealth(3, " . $modSepInhealthT->sep_id . ");return false", 'disabled' => FALSE)) . '&nbsp;';
                }
            }
            if (Yii::app()->user->getState('bridging_inhealth') == TRUE) {
                if (!empty($model->penjamin_id) && $model->penjamin_id == Params::PENJAMIN_ID_INHEALTH) {
                    echo CHtml::link(Yii::t('mds', '{icon} Proses SJP', array('{icon}' => '<i class="icon-ok icon-white"></i>')), $this->createUrl("pendaftaranRawatJalan/prosesSJP", array("pendaftaran_id" => $model->pendaftaran_id, "pasien_id" => $modPasien->pasien_id, "frame" => true, 'pelayanan' => "RJ")), array(
                        'rel' => 'tooltip', 'title' => 'Klik untuk Proses SJP!', 'class' => 'btn btn-info',
                        "class" => "btn btn-primary", "onclick" => "$('#dialog-proses-sjp').dialog('open');loadFormProsesSJP(this);return false;"
                    )) . "&nbsp;";
                }
            }
            // echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));
            if ($model->isNewRecord || $model->statuspasien != Params::STATUSPASIEN_BARU) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            }
            echo " ";
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            if ($model->isNewRecord) {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                // echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Stiker', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Penuh', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Identitas', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Kepala Les', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
            } else {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranTagihanKarcis/index", array("instalasi_id" => $model->instalasi_id, "pendaftaran_id" => $model->pendaftaran_id, "frame" => true, 'pelayanan' => "RJ")), array("target" => "iframePembayaran", 'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                // echo CHtml::htmlButton(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setSuratPeryataan(' . $model->pendaftaran_id . ');'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Penuh', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printRM1()'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Identitas ', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printCasemixIdentitas(' . $model->pendaftaran_id . ')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Kepala Les ', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printKepalaLes(' . $model->pendaftaran_id . ')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));
            }
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat._tablePendaftaranTerakhir', array('modPasienTerakhir' => $modPasienTerakhir)); ?>
        <?php $this->renderPartial($this->path_view . '_generalConsent', array()); ?>
        <?php $this->renderPartial($this->path_view . '.vaksinasi._dialogVaksinasi', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogBayarKarcis',
            'options' => array(
                'title' => 'Pembayaran Tagihan Pasien',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 1000,
                'zIndex' => 1001,
                'height' => 500,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
        <?php
        $this->endWidget();
        ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDpjpMelayaniIGD',
            'options' => array(
                'title' => 'Pencarian Dokter DPJP yang Melayani IGD ',
                'autoOpen' => false,
                'modal' => true,
                'width' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo $this->renderPartial($this->path_viewRD . '_pencarianDpjpMelayani');
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
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this);$("#pppendaftaran-t-form").submit();')); ?>
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
                // 'diagnosa_nama',
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
        $modCariAsuransiPasien = new PPAsuransipasienM('searchDialog');
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
                                                $(\".asuransipasien_id  \").val($data->asuransipasien_id);
                                                $(\".nopeserta  \").val(\"$data->nopeserta\");
                                                $(\".nokartuasuransi  \").val(\"$data->nokartuasuransi\");
                                                $(\".namapemilikasuransi  \").val(\"$data->namapemilikasuransi\");
                                                $(\".kelastanggunganasuransi_id  \").val(\"$data->kelastanggunganasuransi_id\");
                                                $(\".nomorpokokperusahaan  \").val(\"$data->nomorpokokperusahaan\");
                                                $(\".namaperusahaan  \").val(\"$data->namaperusahaan\");
                                                $(\".nominal_tanggungan  \").val($data->nominal_tanggungan);
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

        $modCariDokter = new PPDokterV('searchDialog');
        $modCariDokter->unsetAttributes();
        if (isset($_GET['PPDokterV'])) {
            $modCariDokter->attributes = $_GET['PPDokterV'];
            isset($_GET['PPDokterV']['ruangan_id']) ? $modCariDokter->ruangan_id = $_GET['PPDokterV']['ruangan_id'] : '';
            $modCariDokter->gelarbelakang_nama = 'Sp.EM';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'dokter-v-grid',
            'dataProvider' => $modCariDokter->searchDialog(),
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
                ),
                array(
                    'header' => 'Gelar Belakang',
                    'value' => '$data->gelarbelakang_nama',
                    'filter' => false,
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modAntrian' => $modAntrian, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat._jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modSep' => $modSep)); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-hak-pasien',
    'options' => array(
        'title' => 'Hak & Kewajiban Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 580,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_hakPasien', array(
    'model' => $model,
));
$this->endWidget();
?>
<?php /*
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDpjp',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',\
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 480,
        'resizable' => false,
    ),
));
echo $this->renderPartial($this->path_view . '_pencarianDpjp');
$this->endWidget(); */
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
echo $this->renderPartial($this->path_view . '_pencarianDpjp');
$this->endWidget();
?>
<script>
    $('.floating-button').on('mouseover', function(){
        $(this).find('a').removeClass('hide');
    });
    $('.floating-button').on('mouseout', function(){
        $(this).find('a').addClass('hide');
    });

    function printKepalaLes(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/InfoKunjunganRD/printKepalaLes'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>