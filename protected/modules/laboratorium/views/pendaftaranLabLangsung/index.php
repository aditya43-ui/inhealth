<?php
$this->breadcrumbs = array(
    'Pendaftaran Laboratorium Dari Luar',
); ?>

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
            <i class="glyphicon glyphicon-user"></i>
            Pendaftaran Laboratorium <b>Dari Luar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lkpendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'class' => 'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>

        <?php if (!isset($_GET['id'])) : ?>
            <?php $autoopen = Yii::app()->user->getState('isantrian');
            ?>

            <div class="row">
                <?php if ($autoopen) { ?>
                    <div class="col-sm-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="glyphicon glyphicon-bullhorn"></i> Panggil Antrian
                                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="control-group">
                                    <?php echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); ?>
                                        <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->modelantrian_id, CHtml::listData($modAntrian->getModelAntriansPendaftaranByCode('L'), 'modelantrian_id', 'modelantrian_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setNamaLoket(this.value); setFormAntrian("reset");')) ?>
                                        <?php echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'style' => 'width:50px;', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                        di <i class="diLoketAjax"> <?php echo CHtml::dropDownList('namaLoket', $modAntrian->namaLoket, CHtml::listData($modAntrian->getNamaLoketAntrian($modAntrian->modelantrian_id), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");')) ?></i>
                                        &nbsp; <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'bth-lihatantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-primary', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); ?>
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
        <div class="panel panel-success" id="form-pasien" style="margin-top: 17px;">
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
                    echo CHtml::radioButton('rb_rm', false, array(
                        'value' => 2,
                        'name' => 'otomatis',
                        'uncheckValue' => null,
                        'onchange' => 'switchOtomatis(this)',
                        'class' => 'rb_rm rmbaru rmbarubm',
                        'id' => 'pasienbm',
                    )) . "<label for='pasienbm'>Pasien Bukan Manusia</label> ";
                    ?>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    // $bm = '_formPasienBM';
                    // $m = '_formPasien';
                    echo $form->hiddenField($modPasien, 'is_bukanmanusia', array('readonly' => true, 'class' => 'span3 is_bukanmanusia', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                    // if($modPasien->is_bukanmanusia == 1)
                    // {
                    //     $lnk = '_formPasienBM';
                    // }else{
                    //     $lnk = '_formPasien';
                    // }
                    ?>
                    <?php $this->renderPartial('_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPegawaiPJ' => $modPegawaiPJ)); ?>
                    
                    <?php //$this->renderPartial($lnk, array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPegawaiPJ' => $modPegawaiPJ)); ?>
                    <div class="col-sm-6 form_m">
                        <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3 is_adapjpasien', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php //echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
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
                    <div class="clear"></div>
                    <div class="col-sm-12 form_m">
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
                    <i class="glyphicon glyphicon-user"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
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
                        )); ?>

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

                        <!--PENTING! : ANTARA LAB KLINIS / PATOLOGI ANATOMI HARUS ADA YANG DIPILIH, BISA SALAH SATU ATAU KEDUANYA-->
                        <?php $i = 0; //index form pasien masuk penunjang 
                        ?>
                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pemeriksaan-' . $i,
                            'content' => array(
                                'content-lab-' . $i => array(
                                    'header' => '<b>Pemeriksaan Lab Klinik</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formPenunjang', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'i' => $i,
                                        'modPasienMasukPenunjang' => $modPasienMasukPenunjangs[$i],
                                        'dataTindakans' => $dataTindakans,
                                    ), true),
                                    'active' => $modPasienMasukPenunjangs[$i]->is_pilihpenunjang,
                                ),
                            ),
                        )); ?>

                        <div class="form_m">
                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-karcis-' . $i,
                            'content' => array(
                                'content-karcis-' . $i => array(
                                    'header' => '<b>Karcis Lab Klinik</b>',
                                    'isi' => '<div id="content-karcis-html">'
                                        . $this->renderPartial($this->path_view . '_formKarcis', array(
                                            'form' => $form,
                                            'model' => $model,
                                            'i' => $i,
                                            'modKarcis' => $modKarcis[$i],
                                        ), true)
                                        . '</div>',
                                    'active' => $modPasienMasukPenunjangs[$i]->is_adakarcis,
                                ),
                            ),
                        )); ?>
                        </div>
                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adasample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pengambilan-sample-' . $i,
                            'content' => array(
                                'content-pengambilan-sample-' . $i => array(
                                    'header' => '<b>Sampel Lab Klinik</b>',
                                    'isi' => $this->renderPartial($this->path_view . '_formPengambilanSample', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'i' => $i,
                                        'modPengambilanSample' => $modPengambilanSample,
                                    ), true),
                                    'active' => $modPasienMasukPenunjangs[$i]->is_adasample,
                                ),
                            ),
                        )); ?>
                        <?php $i = 1; //index form pasien masuk penunjang 
                        ?>
                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        /* RSPMC-696 $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'form-pemeriksaan-'.$i,
                            'content'=>array(
                                'content-lab-'.$i=>array(
                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk memilih laboratorium Patologi Anatomi')).'<b>Pemeriksaan Lab Patologi Anatomi</b>',
                                    'isi'=>$this->renderPartial($this->path_view.'_formPenunjang', array(
                                            'form'=>$form,
                                            'model'=>$model,
                                            'i'=>$i,
                                            'modPasienMasukPenunjang'=>$modPasienMasukPenunjangs[$i],
                                            'dataTindakans'=>$dataTindakans,
                                            ),true),
                                    'active'=>$modPasienMasukPenunjangs[$i]->is_pilihpenunjang,
                                ),
                            ),
                    )); */ ?>

                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php /* RSPMC-696 $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'form-karcis-'.$i,
                            'content'=>array(
                                'content-karcis-'.$i=>array(
                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk memilih karcis')).'<b>Karcis Lab Patologi Anatomi</b>',
                                    'isi'=>'<div id="content-karcis-html">'
                                            .$this->renderPartial($this->path_view.'_formKarcis',array(
                                                    'form'=>$form,
                                                    'model'=>$model,
                                                    'i'=>$i,
                                                    'modKarcis'=>$modKarcis[$i],
                                                    ),true)
                                            .'</div>',
                                    'active'=>$modPasienMasukPenunjangs[$i]->is_adakarcis,
                                ),
                            ),
                    )); */ ?>

                        <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adasample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php /* RSPMC-696 $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'form-pengambilan-sample-'.$i,
                            'content'=>array(
                                'content-pengambilan-sample-'.$i=>array(
                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan sampel laboratorium')).'<b>Sampel Lab Patologi Anatomi</b>',
                                    'isi'=>$this->renderPartial($this->path_view.'_formPengambilanSample',array(
                                            'form'=>$form,
                                            'model'=>$model,
                                            'i'=>$i,
                                            'modPengambilanSample'=>$modPengambilanSample,
                                            ),true),
                                    'active'=>$modPasienMasukPenunjangs[$i]->is_adasample,
                                ),
                            ),
                    )); */ ?>
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
            <?php
            if ($model->isNewRecord) {
                if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN){
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi2();', 'onkeypress' => 'setVerifikasi2();')); //jika tanpa verifikasi >> formSubmit(this,event)
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')); //jika tanpa verifikasi >> formSubmit(this,event)
                }
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
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
            );
            ?>
             <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus('$model->pendaftaran_id');return false", 'disabled' => FALSE));
            }
            ?>
            
            <?php
            

            echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));

            if ($model->isNewRecord || $model->statuspasien != Params::STATUSPASIEN_BARU) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranLaboratorium', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            if ($model->isNewRecord) {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                // echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianPenunjangBelumBayar();return false", 'disabled' => true));
            } else {
                // echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/PembayaranTagihanPasienPenunjang/index", array("instalasi_id"=>$model->instalasi_id,"pendaftaran_id"=>$model->pendaftaran_id, "frame" => true, 'pelayanan' => "LB")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
                // echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$model->pendaftaran_id.');'));
                echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianPenunjangBelumBayar();return false", 'disabled' => FALSE));
            }
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <hr>
        <?php $this->renderPartial($this->path_view . '_tablePendaftaranTerakhir', array()); ?>
        <?php $this->renderPartial($this->path_view . '_generalConsent', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
    </div>
</div>

<script>
    function printRincianPenunjangBelumBayar()
    {
        // var instalasi_id = $("#instalasi_id").val();
        var pendaftaran_id = "<?= isset($_GET['id']) ? $_GET['id'] : 0 ?>";
        //if(instalasi_id && pendaftaran_id){
            window.open("<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranLaboratoriumPP/PrintRincianBelumBayar') ?>&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');
        //}else{
        //    myAlert("Silakan cari data kunjungan terlabih dahulu!");
        //}
    }
</script>
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
        'width' => 200,
        'height' => 180,
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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-backward"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("prev");', 'style' => 'font-size: 12px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-forward"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn btn-default', 'onclick' => 'setFormAntrian("next");', 'style' => 'font-size:12px; margin-right: 8px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="glyphicon glyphicon-refresh"></i>')), array('title' => 'Klik untuk mengulang antrian', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-default', 'onclick' => 'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}', 'style' => 'font-size: 12px;')); ?>
            <br>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil / Daftar', array('id' => 'btn-panggilantrian', '{icon}' => '<i class="glyphicon glyphicon-volume-up"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn btn-danger', 'onclick' => 'if(requiredCheck(this)){panggilAntrian();}', 'style' => 'width: 165px; font-size: 12px; margin-top: 5px;')); ?>
</div>
<?php $this->endWidget(); ?>

<?php
//====== dialog box pilih pemeriksaan klinik ====
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-pilihpemeriksaan',
    'options' => array(
        'title' => 'Pilih Pemeriksaan',
        'autoOpen' => false,
        'width' => 840,
        'height' => 450,
        'modal' => true,
        'resizable' => false,
    ),
)); ?>
<?php echo $this->renderPartial($this->path_view . '_formCariPemeriksaan', array('modPemeriksaanLab' => $modPemeriksaanLab)); ?>
<div class="dialog-content"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

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
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#lkpendaftaran-t-form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

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
$modCariAsuransiPasien = new LBAsuransipasienM('search');
$modCariAsuransiPasien->unsetAttributes();
if (isset($_GET['LBAsuransipasienM'])) {
    $modCariAsuransiPasien->attributes = $_GET['LBAsuransipasienM'];
    isset($_GET['LBAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['LBAsuransipasienM']['pasien_id'] : '';
    isset($_GET['LBAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['LBAsuransipasienM']['penjamin_id'] : '';
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
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs, 'modTindakan' => $modTindakan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-hak-pasien',
    'options' => array(
        'title' => 'Hak Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 580,
        'resizable' => false,
    ),
));

echo $this->renderPartial($this->path_viewPPRJ . '_hakPasien', array(
    'model' => $model,
), true);

$this->endWidget();
?>




<?php

    /** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLab',
    'options' => array(
        'title' => 'Daftar Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'width' => 800,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modTarif = new LBTariftindakanM('search');
$modTarif->unsetAttributes();
$modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
if (isset($_GET['LBTariftindakanM'])) {
    $modTarif->attributes = $_GET['LBTariftindakanM'];
    $modTarif->kategoritindakan_nama = $_GET['LBTariftindakanM']['kategoritindakan_nama'] ?? "";
    $modTarif->daftartindakan_kode = $_GET['LBTariftindakanM']['daftartindakan_kode'] ?? "";
    $modTarif->daftartindakan_nama = $_GET['LBTariftindakanM']['daftartindakan_nama'] ?? "";
    $modTarif->pemeriksaanlab_nama = $_GET['LBTariftindakanM']['pemeriksaanlab_nama'] ?? "";
    $modTarif->paket = $_GET['LBTariftindakanM']['paket'] ?? "";
}

if ($modTarif->paket == "paket") {

    $modTarif->unsetAttributes();
    if (isset($_GET['LBTariftindakanM'])) {
        $modTarif->attributes = $_GET['LBTariftindakanM'];
        $modTarif->tipepaket_nama = $_GET['LBTariftindakanM']['tipepaket_nama'] ?? "";
        $modTarif->paket = $_GET['LBTariftindakanM']['paket'];
    }


    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->searchPaket(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialogPaket(".$data->tipepaket_id."); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Nama Paket',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'tipepaket_nama', array('class' => 'span3')),
                'value' => '$data->tipepaket_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    

} else {

    $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->search2(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                // 'filter' => CHtml::dropDownList('LBTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    
                    echo CHtml::hiddenField('daftartindakan_kode', $data->daftartindakan->daftartindakan_kode, array('class' => 'span3 daftartindakan_kode'));
                    echo CHtml::hiddenField('pemeriksaanlab_id', $data->pemeriksaanlab_id, array('class' => 'span3 pemeriksaanlab_id_dialog'));
                    echo CHtml::hiddenField('pemeriksaanlab_nama', $data->pemeriksaanlab_nama, array('class' => 'span3 pemeriksaanlab_nama'));
                    echo CHtml::hiddenField('jenispemeriksaanlab_nama', $data->jenispemeriksaanlab_nama, array('class' => 'span3 jenispemeriksaanlab_nama'));
                    echo CHtml::hiddenField('daftartindakan_id', $data->daftartindakan_id, array('class' => 'span3 daftartindakan_id'));
                    echo CHtml::hiddenField('jenistarif_id', $data->jenistarif_id, array('class' => 'span3 jenistarif_id'));
                    echo CHtml::hiddenField('harga_tariftindakan', $data->harga_tariftindakan, array('class' => 'span3 harga_tariftindakan'));
                    echo CHtml::hiddenField('kelaspelayanan_id', $data->kelaspelayanan_id, array('class' => 'span3 kelaspelayanan_id_dialog'));
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniNew(this); $('#dialogLab').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Kategori Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'kategoritindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->kategoritindakan->kategoritindakan_nama',
            ),
            array(
                'header' => 'Kode Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_kode', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_kode',
            ),
            array(
                'header' => 'Nama Pemeriksaan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'pemeriksaanlab_nama', array('class' => 'span3')),
                'value' => '$data->pemeriksaanlab_nama',
            ),
            array(
                'header' => 'Uraian Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_nama',
            ),
            array(
                'header' => 'Kelas Pelayanan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::dropDownList('LBTariftindakanM[kelaspelayanan_id]', $modTarif->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif IS TRUE"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')),
                'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

}


$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>
<!-- End -->