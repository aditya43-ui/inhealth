<?php $linkHalaman = CustomFunction::getUrlByMenuID(64); ?>
<?php
$this->breadcrumbs = array(
    'Pendaftaran Rawat Inap dari RJ/RD',
); ?>
<style>
    .footsty {
        font-weight: 100;
    }

    .pesan_bpjs {
        color: #B94A49 !important;
        background-color: #FFF086 !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-user"></i> Pendaftaran <b>Rawat Inap dari RJ / RD</b>
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
            'htmlOptions' => array('class' => 'form_pendaftaran', 'onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            $log = BpjslogR::model()->findByAttributes(array(
                'pendaftaran_id' => $_GET['id']), array(
                    'order' => 'bpjslog_id desc'
                )
            );
            $modPasienadmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $_GET['id']));
            if(!empty($modPasienadmisi)){
                if($modPasienAdmisi->carabayar_id != Params::CARABAYAR_ID_BPJS){
                    Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
                }else{
                    if (!empty($log) && $log->code != 200) {
                        Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan <br>" . '<span class = "pesan_bpjs">BPJS Error ' . $log->code . ': ' . $log->pesan . "</span>");
                        // $this->flashBpjs($model->pendaftaran_id);
                    } else {
                        Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
                    }
                }
            }
            // $this->flashBpjs($model->pendaftaran_id);
        }
        if (!empty($model->pendaftaran_id)) {
            $this->flashBpjs($model->pendaftaran_id);
        }
        ?>
        <?php if (!isset($_GET['sukses'])) : ?>
            <?php $autoopen = Yii::app()->user->getState('isantrian');
            ?>
            <div class="row">
                <?php if ($autoopen) { ?>
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-bullhorn"></i> Panggil Antrian <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group">
                                    <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>
                                        <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->modelantrian_id, CHtml::listData(ModelantrianM::model()->findAll(' modelantrian_id = 12 '), 'modelantrian_id', 'modelantrian_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setNamaLoket(this.value); setFormAntrian("reset");')) ?>
                                        <?php echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        di <i class="diLoketAjax">
                                            <?php echo CHtml::dropDownList('namaLoket', $modAntrian->namaLoket, CHtml::listData($modAntrian->getNamaLoketAntrian(12), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");')) ?></i>
                                        &nbsp;
                                        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'bth-lihatantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-primary', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!--<div class="col-sm-6">
                    <div class =" control-group">
                        <div id = "loading" style = "width:50px;height:50px;"></div>
                <?php //echo CHtml::button("Pendaftaran Sidik Jari",array('id'=>'pendaftaranFP','onclick' => 'setPendaftaranFP();', 'class'=>'btn btn-primary', 'style' => 'background:#ff0909;border:1px solid #ff0909;')); 
                ?>
                <?php //echo CHtml::button("Verifikasi Sidik Jari",array('id'=>'verifikasiFP','onclick' => 'setVerifikasiFP();', 'class'=>'btn btn-primary', 'style' => 'background:#142ffb;border:1px solid #142ffb;')); 
                ?>
                <?php //echo CHtml::button("Batal",array('id'=>'batalVerifFP','onclick' => 'batalVerifikasiFP();', 'class'=>'btn btn-primary'));  
                ?>                
                        <div id = "pesanVerifikasi"></div>
                    </div>
                </div>-->
            </div>
        <?php endif; ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <div class="">
            <div class="col-sm-6">
                <?php /*
            if(Yii::app()->user->getState('issmsgateway')){
               $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
            } */
                ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pasien Baru</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial('_formPasienRJRD', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
                </div>
                <div class="row" style="margin-top: 17px;">
                    <div class="col-sm-6">
                        <?php
                        $model->is_adapjpasien = 1;
                        echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3 is_adapjpasien', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pjpasien',
                            //'slide' => true,
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
                                    'isi' => $this->renderPartial($this->path_view_rj . '_formPegawai', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modPegawai' => $modPegawai,
                                    ), true),
                                    'active' => !empty($modPasien->pegawai_id) ? true : false,
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
        <div class="panel panel-success" id="form-pasien">
        <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Admisi Ruangan
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php echo $this->renderPartial('_formAdmisi', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
                    <div class="col-sm-6">
                        <?php //echo $form->hiddenField($model, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); 
                        ?>
                        <?php //$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        //     'id' => 'form-karcis',
                        //     'content' => array(
                        //         'content-karcis' => array(
                        //             'header' => '<b>Karcis</b>',
                        //             'isi' => '<div id="content-karcis-html">'
                        //                 . $this->renderPartial($this->path_view . '_formKarcis', array(
                        //                     'form' => $form,
                        //                     'model' => $model,
                        //                     'modTindakan' => $modTindakan,
                        //                     'modKarcisV' => $modKarcisV
                        //                 ), true)
                        //                 . '</div>',
                        //             'active' => $model->is_adakarcis,
                        //         ),
                        //     ),
                        // )); 
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
                                    'isi' => $this->renderPartial($this->path_view_rj . '_formRujukan', array(
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
                                    'header' => 'Asuransi Baru',
                                    'isi' => $this->renderPartial($this->path_view . '_formAsuransi', array(
                                        'form' => $form,
                                        'model' => $modPasienAdmisi,
                                        'modPasien' => $modPasien,
                                        'modAsuransiPasien' => $modAsuransiPasien,
                                        'statusMenu' => 'rawatinap',
                                        'readdata' => true
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
                                        'model' => $modPasienAdmisi,
                                        'modPasien' => $modPasien,
                                        'modRujukanBpjs' => $modRujukanBpjs,
                                        'modAsuransiPasien' => $modAsuransiPasienBpjs,
                                        'modAsuransiPasienNon' => $modAsuransiPasien,
                                        'modSep' => $modSep,
                                        'statusMenu' => 'rawatinap',
                                        'readdata' => true
                                    ), true),
                                    'active' => $model->is_bpjs,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? '' : 'display:none')),
                        )); ?>
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
                                        'pelayanan' => 'RI', //untuk penentu briging
                                    ), true),
                                    'active' => (!empty($modSepInhealthT->sep_id)) ? true : false,
                                ),
                            ),
                            'htmlOptions' => array('style' => (!empty($modSepInhealthT->sep_id) ? '' : 'display:none')),
                        ));
                        ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-paketbmhp',
                            'content' => array(
                                'content-paketbmhp' => array(
                                    // 'header' => CHtml::htmlButton("<i class='icon-plus icon-white'></i>", array('class' => 'btn btn-dark btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat kunjungan pasien')) . '<b>Riwayat Kunjungan Pasien</b>',
                                    'header' => '<b>Paket Medis</b>',
                                    'isi' => $this->renderPartial($this->path_view . 'paket/_formPaketBMHP', array(
                                        'form' => $form,
                                        'modPasien' => $modPasien,
                                    ), true),
                                    'active' => false,
                                ),
                            ),
                        ));
                        ?>
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
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'title' => 'Simpan', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
                ); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'title' => 'Simpan', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
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
                // echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label Gelang', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else {
                //                        echo CHtml::link(Yii::t('mds', '{icon} Print Label Gelang', array('{icon}'=>'<i class="entypo-print"></i>')), Yii::app()->controller->createUrl("labelGelang",array("pendaftaran_id"=>$model->pendaftaran_id)),
                //                            array("id"=>$model->no_pendaftaran,
                //                            'class' => 'btn btn-info',
                //                            "rel"=>"tooltip",
                //                            "title"=>"Klik untuk melihat label gelang pasien",
                //                            "target"=>"frameLabelGelang",
                //                            "onclick"=>"$('#dialogLabelGelang').dialog('open');"
                //                            )).'&nbsp;';   
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
                                        'onclick' => "printLabelGelangRawatInap(1);",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk print gelang pasien dewasa",
                                    )
                                ),
                                array(
                                    'label' => 'Anak',
                                    'icon' => 'icon-ok',
                                    'url' => "javascript:void(0);",
                                    'itemOptions' => array(
                                        'onclick' => "printLabelGelangRawatInap(0);",
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
                    'htmlOptions' => array(
                        'style' => 'margin-top: 2px; margin-right: 5px;',
                        'class' => 'btn-info',
                    ),
                ));
                if (isset($modSep->sep_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printSEP();return false", 'disabled' => FALSE));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Belum memiliki No. SEP!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            }
            echo " ";
            // if ($model->isNewRecord || $model->statuspasien != Params::STATUSPASIEN_BARU) {
            //     echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)); //formSubmit(this,event)
            //     echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent Keuangan', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
            // } else {
            //     echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            //     echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent Keuangan', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsentKeuangan(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            // }
            echo " ";

            if ($model->isNewRecord) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Tata Tertib Pengunjung & Pendamping', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Tata Tertib Pengunjung & Pendamping', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogTataTertibPengunjung(' . $model->pendaftaran_id . ');'));
            }
            echo " ";
            ?>
            <?php
            $content = $this->renderPartial($this->path_view_ri . 'tips/tipsPendaftaranRawatInap', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            if ($model->isNewRecord) {

                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Akad Ijarah',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>true));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Formulir Penetapan DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>true));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Casemix Penuh',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'disabled'=>true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Identitas', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Kepala Les', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                // echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranTagihanKarcis/index", array("instalasi_id"=>$model->instalasi_id,"pendaftaran_id"=>$model->pendaftaran_id, "frame" => true, 'pelayanan' => "RJ")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Akad Ijarah',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setAkad('.$model->pasienadmisi_id.');'));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Formulir Penetapan DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setFormulirPenetapan('.$model->pasienadmisi_id.');'));
                echo CHtml::htmlButton(Yii::t('mds','{icon} Casemix Penuh',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'printRM1()'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Casemix Identitas ', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printCasemixIdentitas(' . $model->pendaftaran_id . ')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Kepala Les ', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printKepalaLes(' . $model->pendaftaran_id . ')'));
                // echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$model->pendaftaran_id.');'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabel();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');', 'disabled' => FALSE));
            }
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view_ri . '_tablePendaftaranTerakhir', array()); ?>
        <?php $this->renderPartial($this->path_view . '_generalConsent', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('modAntrian' => $modAntrian, 'model' => $model)); ?>
        <?php $this->renderPartial($this->path_view . '.vaksinasi._dialogVaksinasi', array()); ?>
        <?php $this->renderPartial($this->path_view_ri . '_tataTerbitPengunjung', array()); ?>
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
                                                $(\".asuransipasien_id_bpjs\").val($data->asuransipasien_id);
                                                $(\".nopeserta_bpjs\").val(\"$data->nopeserta\");
                                                $(\".nokartuasuransi_bpjs\").val(\"$data->nokartuasuransi\");
                                                $(\".namapemilikasuransi_bpjs\").val(\"$data->namapemilikasuransi\");
                                                $(\".jenispeserta_id_bpjs\").val(\"$data->jenispeserta_id\");
                                                $(\".nomorpokokperusahaan_bpjs\").val(\"$data->nomorpokokperusahaan\");
                                                $(\".namaperusahaan_bpjs\").val(\"$data->namaperusahaan\");
                                                $(\".kelastanggunganasuransi_id_bpjs\").val(\"$data->kelastanggunganasuransi_id\");
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
        <?php //$this->renderPartial($this->path_view_rj . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'statusMenu' => 'rawatInap', 'modPasienAdmisi' => $modPasienAdmisi)); 
        ?>
        <?php $this->renderPartial($this->path_view_ri . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPasienAdmisi' => $modPasienAdmisi, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi, 'modPasienAdmisi' => $modPasienAdmisi, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai, 'modSep' => $modSep, 'modRujukanBpjs' => $modRujukanBpjs)); ?>
    </div>
</div>

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

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAkadIjarah',
    'options' => array(
        'title' => 'Buat Akad Ijarah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe id="frameAkadIjarah" name='frameAkahIjarah' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogFormulirPenetapan',
    'options' => array(
        'title' => 'Formulir Penetapan DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe id="frameFormulirPenetapan" name='frameFormulirPenetapan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- dialog antrian -->
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
        'width' => 550,
        'height' => 240,
        'resizable' => false,
        'position' => array(
            'my' => 'right top',
            'at' => 'right-30px top+215px',
            'of' => 'body',
        ),
    ),
));
?>
<div class="dialog-content">
    <?php echo $this->renderPartial($this->path_view_lab . '_formPanggilAntrian', array('modAntrian' => $modAntrian)); ?>
</div>
<div style="text-align: center;">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-backward"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("prev");', 'style' => 'font-size: 12px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-forward"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("next");', 'style' => 'font-size:12px; margin-right: 8px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="glyphicon glyphicon-refresh"></i>')), array('title' => 'Klik untuk mengulang antrian', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-default', 'onclick' => 'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}', 'style' => 'font-size: 12px;')); ?>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil / Daftar', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="glyphicon glyphicon-volume-up"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn btn-danger', 'onclick' => 'if(requiredCheck(this)){panggilAntrian();}', 'style' => 'width: 165px; font-size: 12px; margin-top: 5px;')); ?>
</div>
<!--<div style="text-align: center;">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-backward"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("prev");', 'style' => 'font-size:16px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-forward"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("next");', 'style' => 'font-size:16px;')); ?>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="glyphicon glyphicon-volume-up"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn btn-danger', 'onclick' => 'if(requiredCheck(this)){ panggilAntrian();}', 'style' => 'font-size:14px;')); ?>
</div>-->
<?php $this->endWidget(); ?>