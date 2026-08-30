<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
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
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran Penunjang
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
        }
        if (!empty($model->pendaftaran_id)) {
            $this->flashBpjs($model->pendaftaran_id);
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <div class="row" hidden>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>
                        <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id, CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setFormAntrian("reset");')) ?>
                        <?php echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'bth-lihatantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-primary', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class=" control-group">
                    <div id="loading" style="width:50px;height:50px;"></div>
                    <?php echo CHtml::button("Pendaftaran Sidik Jari", array('id' => 'pendaftaranFP', 'onclick' => 'setPendaftaranFP();', 'class' => 'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;')); ?>
                    <?php echo CHtml::button("Verifikasi Sidik Jari", array('id' => 'verifikasiFP', 'onclick' => 'setVerifikasiFP();', 'class' => 'btn btn-primary', 'style' => 'background:#142ffb;border:1px solid #142ffb;')); ?>
                    <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class'=>'btn btn-primary')); 
                    ?>
                    <div id="pesanVerifikasi"></div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien Baru</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
                    <br>
                </div>
                <?php
                $model->is_adapjpasien = 0;
                echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pjpasien',
                    'content' => array(
                        'content-pjpasien' => array(
                            'header' => '<b>Penanggung Jawab Pasien</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formPenanggungJawabPasien', array(
                                'form' => $form,
                                'modPenanggungJawab' => $modPenanggungJawab,
                            ), true),
                            'active' => false,
                        ),
                    ),
                )); ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="row">
                    <?php echo $this->renderPartial('_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
                    <div class="col-sm-6">
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
                                        'modAsuransiPasienNon' => $modAsuransiPasien,
                                    ), true),
                                    'active' => $model->is_bpjs,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? '' : 'display:none')),
                        )); ?>
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
                <div class="panel panel-default" id="form-pasien">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Ruangan Penunjang Tujuan
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            if (count((array)$modPasienMasukPenunjangs) > 0) {
                                echo '<div></div>';
                                foreach ($modPasienMasukPenunjangs as $i => $modPasienMasukPenunjang) {
                                    $modPasienMasukPenunjangs[$i]->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
                                    echo '<div class="col-sm-6">';
                                    echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                        'id' => 'form-masukpenunjang-' . $i,
                                        'content' => array(
                                            'content-masukpenunjang-' . $i => array(
                                                'header' => '<b>Kunjungan ' . $modPasienMasukPenunjang->ruangan->ruangan_nama . '</b>',
                                                'isi' => $this->renderPartial('_formPenunjang', array(
                                                    'form' => $form,
                                                    'model' => $model,
                                                    'i' => $i,
                                                    'modPasienMasukPenunjang' => $modPasienMasukPenunjangs[$i],
                                                ), true),
                                                'active' => $modPasienMasukPenunjangs[$i]->is_pilihpenunjang,
                                            ),
                                        ),
                                    ));
                                    if (in_array($modPasienMasukPenunjangs[$i]->ruangan_id, array(Params::RUANGAN_ID_FISIOTERAPI, Params::RUANGAN_ID_GIZI))) {
                                        echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                            'id' => 'form-karcis-' . $i,
                                            'content' => array(
                                                'content-karcis-' . $i => array(
                                                    'header' => '<b>Karcis ' . $modPasienMasukPenunjang->ruangan->ruangan_nama . '</b>',
                                                    'isi' => '<div id="content-karcis-html">'
                                                        . $this->renderPartial('_formKarcis', array(
                                                            'form' => $form,
                                                            'model' => $model,
                                                            'i' => $i,
                                                            'modKarcis' => $modKarcis[$i],
                                                        ), true)
                                                        . '</div>',
                                                    'active' => $modPasienMasukPenunjangs[$i]->is_adakarcis,
                                                ),
                                            ),
                                        ));
                                    }
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
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
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasiPenunjang();', 'onkeypress' => 'setVerifikasiPenunjang();')
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
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            if ($model->isNewRecord) {
                // echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien();return false", 'disabled' => FALSE));
                if (Yii::app()->user->getState('isbridging')) {
                    if (isset($modSep->sep_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    }
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            }
            
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$model->pendaftaran_id.');'));
            }
            ?>

            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            if (isset($model->pendaftaran_id)) {
                if (empty($model->pasien->nofingerprint)) {
                    echo CHtml::htmlButton("Pendaftaran Sidik Jari", array('id' => 'regisFP', 'onclick' => "setRegisFP('" . $model->pasien->no_rekam_medik . "');", 'class' => 'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;'));
                    echo '<div id = "regisLoading" style = "width:50px;height:50px;"></div>';
                    echo '<div id = "pesanRegis"></div>';
                }
            }
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial('_tablePendaftaranTerakhir', array()); ?>

        <?php
        $autoopen = Yii::app()->user->getState('isantrian');
        if (!empty($model->pendaftaran_id)) {
            $autoopen = false;
        }
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-panggilantrian',
            'options' => array(
                'title' => 'No. Antrian',
                'autoOpen' => $autoopen,
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
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-backward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("prev");', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-forward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("next");', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); 
            ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Klik untuk mengulang antrian', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-danger', 'onclick' => 'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
            <br>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil / Daftar', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'if(requiredCheck(this)){ panggilAntrian();}', 'style' => 'font-size:10px; width:128px; height:24px;')); ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
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
                'diagnosa_nama',
                'diagnosa_namalainnya',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
        ?>

        <?php  
        //====== dialog box pilih pemeriksaan klinik ====
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialog-pilihpemeriksaan',
            'options'=>array(
                'title'=>'Pilih Pemeriksaan',
                'autoOpen'=>false,
                'width'=>900,
                'height'=>450,
                'modal'=>true,
                'resizable'=>false,
            ),
        ));?>
        <?php echo $this->renderPartial('_formCariPemeriksaan', array('modPemeriksaanLab'=>$modPemeriksaanLab));?>
        <div class="dialog-content"></div>
        <?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
            
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
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,'modTindakan'=>$modTindakan)); ?>

    </div>
</div>