<?php
$this->breadcrumbs = array(
    'Pendaftaran Rawat Inap (Bayi Baru Lahir)',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Pendaftaran <b>Rawat Inap (Bayi Baru Lahir)</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);','class'=>'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
        ));
        ?>
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
            <div class="row">
                <?php if ($autoopen) { ?>
                    <!--<div class="col-sm-6">
                        <div class="control-group">
                    <?php //echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));
                    ?>
                            <div class="controls">
                    <?php //echo $form->hiddenField($model,'antrian_id',array('readonly'=>true));
                    ?>
                    <?php //echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id,CHtml::listData($modAntrian->getLokets(null, true), 'loket_id', 'loket_nama'),array('class'=>'span2','empty'=>'-- Pilih --','onchange'=>'setFormAntrian("reset");$("#dialog-panggilantrian").dialog("open");') )
                    ?>
                    <?php //echo CHtml::textField('noantrian',$modAntrian->noantrian,array('readonly'=>true,'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
                    ?>
                    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('id'=>'bth-lihatantrian','title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn btn-primary', 'onclick'=>'$("#dialog-panggilantrian").dialog("open");'));  
                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                    <?php /*
                      if(Yii::app()->user->getState('issmsgateway')){
                      $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway));
                      } */
                    ?>
                    </div>-->
                <?php } ?>
            </div>
        <?php endif; ?>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pasien Baru</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial($this->path_view_bayi . '_formPasienBayi', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
                    <br>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3 is_adapjpasien', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
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
                        ));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pegawai',
                            'content' => array(
                                'content-pegawai' => array(
                                    'header' => '<b>Pegawai Penanggung Jawab</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formPegawai', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modPegawai' => $modPegawai,
                                    ), true),
                                    'active' => !empty($modPasien->pegawai_id) ? true : false,
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
                    <i class="glyphicon glyphicon-home"></i> Admisi Ruangan
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $this->renderPartial($this->path_view_ri . '_formAdmisi', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
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
                    </div>
                    <div class="col-sm-6">
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
                        <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asuransi',
                            'content' => array(
                                'content-asuransi' => array(
                                    'header' => '<b>Asuransi Baru</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransi', array(
                                        'form' => $form,
                                        'model' => $modPasienAdmisi,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasien' => $modAsuransiPasien,
                                        'statusMenu' => 'rawatinap'
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
                                        'model' => $modPasienAdmisi,
                                        'modPasien' => $modPasien,
                                        'modRujukanBpjs' => $modRujukanBpjs,
                                        'modAsuransiPasien' => $modAsuransiPasienBpjs,
                                        'modSep' => $modSep,
                                        'statusMenu' => 'rawatinap',
                                        'modAsuransiPasienNon' => $modAsuransiPasien,
                                    ), true),
                                    'active' => $model->is_bpjs,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? '' : 'display:none')),
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
                    <!--<div class="row">-->
                    <!--<div class="col-sm-4"><legend class="rim">Admisi Ruangan</legend></div>-->
                    <!--<div class="col-sm-4"> &nbsp; </div>-->
                    <!--<div class="col-sm-4"><legend class="rim">Rujukan</legend></div>-->
                    <!--</div>-->
                    <!--<div class="row box">-->
                    <?php // echo $this->renderPartial('_formAdmisi', array('form'=>$form,'model'=>$model, 'modPasien'=>$modPasien, 'modPasienAdmisi'=>$modPasienAdmisi, 'modRujukan'=>$modRujukan, 'modRujukanBpjs'=>$modRujukanBpjs, 'modAsuransiPasien'=>$modAsuransiPasien, 'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs, 'modSep'=>$modSep,'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,'modPegawai'=>$modPegawai)); 
                    ?>
                    <!--<div class="col-sm-4">-->
                    <?php // echo $form->hiddenField($model,'is_adakarcis', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>

                </div>
            </div>
        </div>
        <!--fieldset class=""-->
        <!--legend class="rim">Admisi Ruangan</legend-->

        <!--</fieldset>-->

        <div class="form-actions">
            <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                );
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
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

                echo CHtml::link(Yii::t('mds', '{icon} Print Label Gelang', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));

                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
                echo CHtml::link(Yii::t('mds', '{icon} Print Label RM', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'labelrm btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabel();return false", 'disabled' => FALSE));
                echo " ";
                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type' => 'primary',
                    'buttons' => array(
                        array(
                            'label' => 'Print Label Gelang',
                            'icon' => 'entypo-print',
                            'url' => "javascript:void(0);",
                            'htmlOptions' =>
                            array(
                                'onclick' => 'javascript:void(0);',
                                'class' => 'btn-info',
                            )
                        ),
                        array(
                            'label' => '',
                            'items' => array(
                                array(
                                    'label' => 'Dewasa',
                                    'icon' => 'icon-ok',
                                    'url' => "javascript:void(0);",
                                    'itemOptions' => array(
                                        'onclick' => "printLabelGelangBayiLahir(1);",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk print gelang pasien dewasa",
                                    )
                                ),
                                array(
                                    'label' => 'Anak',
                                    'icon' => 'icon-ok',
                                    'url' => "javascript:void(0);",
                                    'itemOptions' => array(
                                        'onclick' => "printLabelGelangBayiLahir(0);",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk print gelang pasien anak",
                                    )
                                ),
                            ),
                            'htmlOptions' =>
                            array(
                                'class' => 'btn-info',
                            )
                        ),
                    ),
                
                ));

                if (isset($modSep->sep_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
                echo CHtml::link(Yii::t('mds', '{icon} Print Label RM', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabelRM();return false", 'disabled' => FALSE));
            }

            // echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));

            if ($model->isNewRecord || $model->statuspasien != Params::STATUSPASIEN_BARU) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            }
            echo " ";

            if($model->isNewRecord){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Tata Tertib Pengunjung & Pendamping',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>true)).'&nbsp;';
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Tata Tertib Pengunjung & Pendamping',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setDialogTataTertibPengunjung('.$model->pendaftaran_id.');')).'&nbsp;';
            }
            echo " ";
            ?>

            <?php
            $content = $this->renderPartial('tips/tipsPendaftaranRawatInap', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            if ($model->isNewRecord) {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                // echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranTagihanKarcis/index", array("instalasi_id"=>$model->instalasi_id,"pendaftaran_id"=>$model->pendaftaran_id, "frame" => true, 'pelayanan' => "RJ")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                // echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$model->pendaftaran_id.');'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));
            }
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <hr>
        <?php $this->renderPartial('_tablePendaftaranTerakhir', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._generalConsent', array()); ?>
        <?php $this->renderPartial($this->path_view_ri.'_tataTerbitPengunjung', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
        <?php
        $autoopen = Yii::app()->user->getState('isantrian');
        if (!empty($model->pendaftaran_id)) {
            $autoopen = false;
        }
        $autoopen = false;
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

        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasienAdmisi' => $modPasienAdmisi, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'statusMenu' => 'rawatInap')); ?>
        <?php $this->renderPartial($this->path_view_ri . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
        <?php $this->renderPartial($this->path_view_bayi . '_jsFunctions', array('model' => $model, 'modPasienAdmisi' => $modPasienAdmisi, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'statusMenu' => 'rawatInap')); ?>
        <?php echo $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
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