<div class="white-container">
    <legend class="rim2">Pendaftaran Bank Darah <b>Dari Luar</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'lkpendaftaran-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
        'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modPasien); ?>
    <div class="row">
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
            <?php
            if (Yii::app()->user->getState('issmsgateway')) {
                //                   $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
            }
            ?>
        </div>
    </div>
    <fieldset class="box" id="form-pasien">
        <legend class="rim">Data Pasien Baru
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial('_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
            <div class="col-sm-4">
                <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
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
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Kunjungan</legend>
        <div class="row">
            <div class="col-sm-4">
                <?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modPegawai' => $modPegawai)); ?>
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
            <div class="col-sm-4">
                <!--PENTING! : ANTARA LAB KLINIS / PATOLOGI ANATOMI HARUS ADA YANG DIPILIH, BISA SALAH SATU ATAU KEDUANYA-->
                <?php $i = 0; //index form pasien masuk penunjang 
                ?>
                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pemeriksaan-' . $i,
                    'content' => array(
                        'content-lab-' . $i => array(
                            'header' => '<b>Pemeriksaan Bank Darah</b>',
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

                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-karcis-' . $i,
                    'content' => array(
                        'content-karcis-' . $i => array(
                            'header' => '<b>Karcis Bank</b>',
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

                <?php // echo $form->hiddenField($modPasienMasukPenunjangs[$i],'['.$i.']is_adasample', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
                ?>
                <?php // $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                //                        'id'=>'form-pengambilan-sample-'.$i,
                //                        'content'=>array(
                //                            'content-pengambilan-sample-'.$i=>array(
                //                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan sampel bank darah')).'<b>Sampel Lab Klinik</b>',
                //                                'isi'=>$this->renderPartial($this->path_view.'_formPengambilanSample',array(
                //                                        'form'=>$form,
                //                                        'model'=>$model,
                //                                        'i'=>$i,
                //                                        'modPengambilanSample'=>$modPengambilanSample,
                //                                        ),true),
                //                                'active'=>$modPasienMasukPenunjangs[$i]->is_adasample,
                //                            ),   
                //                        ),
                //                )); 
                ?>

            </div>
            <!--
            <div class="col-sm-4">
                <?php $i = 1; //index form pasien masuk penunjang 
                ?>
                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pemeriksaan-' . $i,
                    'content' => array(
                        'content-lab-' . $i => array(
                            'header' => '<b>Pemeriksaan Lab Patologi Anatomi</b>',
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
                
                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-karcis-' . $i,
                    'content' => array(
                        'content-karcis-' . $i => array(
                            'header' => '<b>Karcis Lab Patologi Anatomi</b>',
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

                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adasample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pengambilan-sample-' . $i,
                    'content' => array(
                        'content-pengambilan-sample-' . $i => array(
                            'header' => '<b>Sampel Lab Patologi Anatomi</b>',
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
            </div>-->
        </div>

        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')
                ); //jika tanpa verifikasi >> formSubmit(this,event)
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
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus('$model->pendaftaran_id');return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            if ($model->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusLabel('$model->pendaftaran_id');return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranBankDarah', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_tablePendaftaranTerakhir', array()); ?>
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
    // Dialog buat nambah data provinsi =========================
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
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#lkpendaftaran-t-form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
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
    $modCariAsuransiPasien = new BDAsuransipasienM('searchDialog');
    $modCariAsuransiPasien->unsetAttributes();
    if (isset($_GET['BDAsuransipasienM'])) {
        $modCariAsuransiPasien->attributes = $_GET['BDAsuransipasienM'];
        isset($_GET['BDAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['BDAsuransipasienM']['pasien_id'] : '';
        isset($_GET['BDAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['BDAsuransipasienM']['penjamin_id'] : '';
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
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs, 'modTindakan' => $modTindakan, 'modAsuransiPasien' => $modAsuransiPasien, 'modPegawai' => $modPegawai)); ?>
    <?php echo $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
</div>