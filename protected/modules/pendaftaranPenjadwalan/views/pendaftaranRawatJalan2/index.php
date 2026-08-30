<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran <b>Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <?php if (!isset($_GET['id'])) : ?>
            <?php $autoopen = Yii::app()->user->getState('isantrian');
            ?>
            <div class="row">

                <?php if ($autoopen) { ?>
                    <div class="span12">
                        <?php echo $this->renderPartial($this->path_view . '_formAntrianPendaftaran', array('form' => $form, 'model' => $model, 'modAntrian' => $modAntrian)); ?>
                    </div>
                <?php } ?>
            </div>
        <?php endif; ?>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien Baru</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab,)); ?>
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
                    <?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
                        ));
                        ?>

                        <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
                        ));
                        ?>
                        <?php
                        if (Yii::app()->user->getState('issmsgateway')) {
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
                        }
                        ?>

                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asuransi',
                            'content' => array(
                                'content-asuransi' => array(
                                    'header' => '<b>Asuransi Baru</b>'
                                        . CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini pull-center', 'onclick' => 'setAsuransiBaru("badak");', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk input asuransi baru')) . '</span></b>',
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
                                    ), true),
                                    'active' => (!empty($modSep->sep_id)) ? true : false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (!empty($model->is_bpjs) ? '' : 'display:none')),
                        ));
                        ?>
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

                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
                        ));
                        ?>

                    </div>

                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'if (!cekJamPoli()) return false; setVerifikasi();', 'onkeypress' => 'if (!cekJamPoli()) return false; setVerifikasi();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                (!empty($model->antrian_id)) ? $this->createUrl($this->id . '/index', array('antrian_id' => $model->antrian_id)) : $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
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
                echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$model->pasien_id');return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabel();return false", 'disabled' => FALSE));

                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($modSep->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }

                if (Yii::app()->user->getState('bridging_inhealth') == TRUE) {
                    if (!empty($modSepInhealthT->sep_id) && isset($modSepInhealthT->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SJP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSJPInhealth(3, " . $modSepInhealthT->sep_id . ");return false", 'disabled' => FALSE));
                    }
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
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            if (isset($model->pendaftaran_id)) {
                if (Yii::app()->user->getState('is_finger_pasien')) {
                    if (empty($model->pasien->nofingerprint)) {
                        echo CHtml::htmlButton("Pendaftaran Sidik Jari", array('id' => 'regisFP', 'onclick' => "setRegisFP('" . $model->pasien->no_rekam_medik . "');", 'class' => 'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;'));
                        echo "<label>";
                        echo '<div id = "regisLoading" style = "width:50px;height:50px;"></div>';
                        echo '<div id = "pesanRegis"></div>';
                        echo "</label>";
                    }
                }
            }
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial('_tablePendaftaranTerakhir', array()); ?>

        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-proses-sep',
            'options' => array(
                'title' => 'Proses SEP',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo '<iframe id="iframeProsesSEP"  name="iframeProsesSEP" width="100%" height="550">
    </iframe>';
        ?>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-proses-sjp',
            'options' => array(
                'title' => 'Proses SJP',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));
        echo '<iframe id="iframeProsesSJP"  name="iframeProsesSJP" width="100%" height="550">
    </iframe>';
        ?>
        <?php $this->endWidget(); ?>
        <?php
        $autoopen = Yii::app()->user->getState('isantrian');
        if (!empty($model->pendaftaran_id)) {
            $autoopen = false;
        }
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-panggilantrian',
            'options' => array(
                'title' => 'No. Antrian',
                'autoOpen' => false,
                'width' => 190,
                'height' => 170,
                'resizable' => false,
                'position' => array(
                    'my' => 'right top',
                    'at' => 'right-50px top+215px',
                    'of' => 'body',
                ),
            ),
        ));
        ?>
        <div class="dialog-content">
            <?php echo $this->renderPartial($this->path_view . '_formPanggilAntrian', array('modAntrian' => $modAntrian)); ?>
        </div>

        <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-backward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("prev");')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-forward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("next");')); ?>
            <br>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'if(requiredCheck(this)){ panggilAntrian();}')); ?>
        </div>
        <?php $this->endWidget(); ?>

        <?php
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
//                                                getAsuransiNoKartu(\'$data->nopeserta\');
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
        'id' => 'dialogAsuransiInhealth',
        'options' => array(
            'title' => 'Pencarian Asuransi Pasien Inhealth',
            'autoOpen' => false,
            'modal' => true,
            'width' => 960,
            'height' => 480,
            'resizable' => false,
        ),
    ));
    $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM('search');
    $modAsuransiPasienInhealth->unsetAttributes();
    if (isset($_GET['PPAsuransipasieninhealthM'])) {
        $modAsuransiPasienInhealth->attributes = $_GET['PPAsuransipasieninhealthM'];
        isset($_GET['PPAsuransipasieninhealthM']['pasien_id']) ? $modAsuransiPasienInhealth->pasien_id = $_GET['PPAsuransipasieninhealthM']['pasien_id'] : '';
        isset($_GET['PPAsuransipasieninhealthM']['penjamin_id']) ? $modAsuransiPasienInhealth->penjamin_id = $_GET['PPAsuransipasieninhealthM']['penjamin_id'] : '';
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'asuransiinhealth-m-grid',
        'dataProvider' => $modAsuransiPasienInhealth->searchDialog(),
        'filter' => $modAsuransiPasienInhealth,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'asuransipasien_id') . '\").val($data->asuransipasien_id);
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nopeserta') . '\").val(\"$data->nopeserta\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nokartuasuransi') . '\").val(\"$data->nokartuasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'namapemilikasuransi') . '\").val(\"$data->namapemilikasuransi\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'jenispeserta_id') . '\").val(\"$data->jenispeserta_id\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'nomorpokokperusahaan') . '\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'namaperusahaan') . '\").val(\"$data->namaperusahaan\");
                                                $(\"#' . CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id') . '\").val(\"$data->kelastanggunganasuransi_id\");
//                                                getAsuransiNoKartu(\'$data->nopeserta\');
                                                setAsuransiLama()
                                                $(\"#dialogAsuransiInhealth\").dialog(\"close\");
                                            "))',
            ),
            'nokartuasuransi',
            'nopeserta',
            array(
                'header' => 'Nama Pemilik Asuransi',
                'value' => '$data->namapemilikasuransi',
                'filter' => CHtml::activeHiddenField($modAsuransiPasienInhealth, 'pasien_id', array('readonly' => true)) . "" . CHtml::activeHiddenField($modAsuransiPasienInhealth, 'penjamin_id', array('readonly' => true)) . "" . CHtml::activeTextField($modAsuransiPasienInhealth, 'namapemilikasuransi', array()),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            'namaperusahaan',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    $this->endWidget();
    ?>
    <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'ruangan' => $ruangan, 'jnspelayanan' => "RJ")); ?>
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
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this, validasiPasienPenjamin);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form', validasiPasienPenjamin);
        });
        cekDisabled('form', validasiPasienPenjamin);
    });

    function validasiPasienPenjamin() {

        // Validasi input bpjs
        if (($("#PPSepT_nosep").val().trim() == "" || $("#PPSepT_nosep").is(":disabled")) &&
            $("#PPPendaftaranT_carabayar_id").val() == <?php echo Params::CARABAYAR_ID_BPJS; ?>)) {
        return false;
    }

    // Validasi input inhealth
    if (($("#PPSepInhealthT_nosep").val().trim() == "" || $("#PPSepInhealthT_nosep").is(":disabled")) &&
        $("#PPPendaftaranT_penjamin_id").val() == <?php echo Params::PENJAMIN_ID_INHEALTH; ?>) {
        return false;
    }

    return true;
    }
</script>