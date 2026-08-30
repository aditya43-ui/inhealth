<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Pendaftaran Pasien Rehabilitasi <b>Medis Dari Luar</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pendaftaran_t_form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->errorSummary($modPasien); ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php
                if (Yii::app()->user->getState('issmsgateway')) {
                    //$this->renderPartial($this->path_view . '_formSms', array('form' => $form, 'modSmsgateway' => $modSmsgateway));
                }
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data Pasien Baru
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-pasien">
                <div class="row-fluid">
                    <?php $this->renderPartial('_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien)); ?>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'is_adapjpasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-pjpasien',
                            'content' => array(
                                'content-pjpasien' => array(
                                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan penanggung jawab pasien')) . '<b> Penanggung Jawab Pasien</b>',
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
                </div>
                </fieldset>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data <b>Kunjungan</b></div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien)); ?>
                                <?php echo $this->renderPartial($this->path_view . '_formPenunjang', array('form' => $form, 'model' => $model, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'dataTindakans' => $dataTindakans,)); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-rujukan',
                                    'content' => array(
                                        'content-rujukan' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan rujukan')) . '<b> Rujukan</b>',
                                            'isi' => $this->renderPartial($this->path_view . '_formRujukan', array(
                                                'form' => $form,
                                                'model' => $model,
                                                'modRujukan' => $modRujukan,
                                            ), true),
                                            'active' => $model->is_pasienrujukan,
                                        ),
                                    ),
                                ));
                                ?>
                                <?php echo $form->hiddenField($modPasienMasukPenunjang, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-karcis',
                                    'content' => array(
                                        'content-karcis' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk memilih karcis')) . '<b> Karcis Rehabilitasi Medis</b>',
                                            'isi' => '<div id="content-karcis-html">'
                                                . $this->renderPartial($this->path_view . '_formKarcis', array(
                                                    'form' => $form,
                                                    'model' => $model,
                                                    'modKarcis' => $modKarcis,
                                                ), true)
                                                . '</div>',
                                            'active' => $modPasienMasukPenunjang->is_adakarcis,
                                        ),
                                    ),
                                ));
                                ?>
                                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-asuransi',
                                    'content' => array(
                                        'content-asuransi' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Tampilkan Asuransi')) . '<b> Asuransi</b>',
                                            'isi' => $this->renderPartial($this->path_view . '_formAsuransi', array(
                                                'form' => $form,
                                                'modPasien' => $modPasien,
                                                'model' => $model,
                                                'modAsuransiPasien' => $modAsuransiPasien
                                            ), true),
                                            'active' => false,
                                        ),
                                    ),
                                )); ?>
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-riwayatpasien',
                                    'content' => array(
                                        'content-riwayatpasien' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat kunjungan pasien')) . '<b> Riwayat Kunjungan Pasien</b>',
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
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        //                    if($model->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();', 'disabled' => (isset($_GET['sukses'])) ? true : false)); //jika tanpa verifikasi >> formSubmit(this,event)
                        //                    }else{
                        //                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                        //                    }
                        ?>
                        <?php
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'return refreshForm(this);'
                        ));
                        ?>
                        <?php
                        if ($model->isNewRecord) {
                            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;')) . '&nbsp;';
                            echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true)) . '&nbsp;';
                            echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => TRUE)) . '&nbsp;';
                        } else {
                            echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus('$model->pendaftaran_id');return false", 'disabled' => FALSE)) . '&nbsp;';
                            echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$model->pasien_id');return false", 'disabled' => FALSE)) . '&nbsp;';
                            echo CHtml::link(Yii::t('mds', '{icon} Print Label', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printLabel();return false", 'disabled' => FALSE)) . '&nbsp;';
                        }
                        ?>
                        <?php
                        $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranRehabilitasiMedis', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_tablePendaftaranTerakhir', array()); ?>
    </div>
    <?php
    //====== dialog box pilih pemeriksaan ====
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialog-pilihpemeriksaan',
        'options' => array(
            'title' => 'Pilih Pemeriksaan Rehabilitasi Medis',
            'autoOpen' => false,
            'width' => 840,
            'height' => 450,
            'modal' => true,
            'resizable' => false,
        ),
    ));
    ?>
    <?php echo $this->renderPartial($this->path_view . '_formCariPemeriksaan', array('modPemeriksaanRm' => $modPemeriksaanRm)); ?>
    <div class="dialog-content"></div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <?php
    // Dialog buat nambah data propinsi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialog-verifikasi',
        'options' => array(
            'title' => 'Verifikasi Pendaftaran',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 960,
            'minHeight' => 480,
            'resizable' => false,
        ),
    ));
    echo '<div class="dialog-content"></div>';
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#pendaftaran_t_form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
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
            'height' => 400,
            'resizable' => false,
        ),
    ));
    $modCariAsuransiPasien = new RMAsuransipasienM('searchDialog');
    $modCariAsuransiPasien->unsetAttributes();
    if (isset($_GET['RMAsuransipasienM'])) {
        $modCariAsuransiPasien->attributes = $_GET['RMAsuransipasienM'];
        isset($_GET['RMAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['RMAsuransipasienM']['pasien_id'] : '';
        isset($_GET['RMAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['RMAsuransipasienM']['penjamin_id'] : '';
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'asuransi-m-grid',
        'dataProvider' => $modCariAsuransiPasien->searchDialog(),
        'filter' => $modCariAsuransiPasien,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
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
                'htmlOptions' => array('style' => 'text-align:right;'),
            ),
            'namaperusahaan',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    $this->endWidget();
    ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modAsuransiPasien' => $modAsuransiPasien)); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            cekDisabled('form');
            $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
            });
            $(document).on('click keyup select change', function() {
                cekDisabled('form');
            });
        });
    </script>