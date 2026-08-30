<?php $linkHalaman = CustomFunction::getUrlByMenuID(2968); ?>
<style>
    .error {
        background: #b94a48 1px solid !important;
        color: #b94a48;
    }

    .panel .panel-title label {
        font-size: inherit;
        color: inherit;
    }

    .checklists {
        display: flex;
        flex-flow: row wrap;
    }

    .checklists .col-sm-4 {
        flex: 0 0 33.33%;
    }

    .checklists .col-sm-4>* {
        width: 100%;
        margin-bottom: 5px;
        padding: 15px !important;
        background: #6cccb9 !important;
        color: #fff;
        cursor: pointer !important;
        border-radius: 4px;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Pendaftaran Pasien MCU',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Pendaftaran Pasien <b>Medical Check Up</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'class' => 'form_pendaftaran'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#' . CHtml::activeId($modPasien, 'jenisidentitas'),
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
        <!--<div class="control-group">
        <?php // echo CHtml::label('No. Antrian', 'noantrian', array('class' => 'control-label')); 
        ?>
                <div class="controls">
        <?php // echo $form->hiddenField($model, 'antrian_id', array('readonly' => true)); 
        ?>
        <?php // echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id, CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange' => 'setFormAntrian("reset");')) 
        ?>
        <?php // echo CHtml::textField('noantrian', $modAntrian->noantrian, array('readonly' => true, 'class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('id' => 'btn-panggilantrian', 'title' => 'Klik untuk menampilkan form antrian', 'rel' => 'tooltip', 'class' => 'btn btn-primary', 'onclick' => '$("#dialog-panggilantrian").dialog("open");')); 
        ?>
                </div>
            </div>-->
        <div class="clear"></div>
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
                    </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    echo $form->hiddenField($modPasien, 'pegawai_id', array('class' => ''));
                    $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab));
                    ?>
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
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial($this->path_view_mcu . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modPegawai' => $modPegawai, 'modSep' => $modSep)); ?>
                        <?php echo $form->hiddenField($model, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-karcis',
                        'content' => array(
                            'content-karcis' => array(
                                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan karcis')) . '<b>Karcis</b>',
                                'isi' => $this->renderPartial($this->path_view_mcu . '_formKarcis', array(
                                    'form' => $form,
                                    'model' => $model,
                                    'modTindakan' => $modTindakan,
                                    'modTindakanKarcis' => $modTindakanKarcis,
                                    'dataTindakans' => $dataTindakans,
                                        ), true),
                                'active' => $model->is_adakarcis,
                            ),
                        ),
                    ));*/
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-asuransi',
                            'content' => array(
                                'content-asuransi' => array(
                                    'header' => '<b>Asuransi baru</b>',
                                    'isi' => $this->renderPartial($this->path_view_mcu . '_formAsuransi', array(
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
                                    'isi' => $this->renderPartial($this->path_view_mcu . '_formAsuransiBpjs', array(
                                        'form' => $form,
                                        'model' => $model,
                                        'modPasien' => $modPasien,
                                        'modRujukanBpjs' => $modRujukanBpjs,
                                        'modAsuransiPasien' => $modAsuransiPasienBpjs,
                                        'modSep' => $modSep,
                                    ), true),
                                    'active' => $model->is_bpjs,
                                ),
                            ),
                            'htmlOptions' => array('style' => (($model->is_bpjs) ? '' : 'display:none')),
                        )); ?>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'form-riwayatpasien',
                            'content' => array(
                                'content-riwayatpasien' => array(
                                    'header' => '<b>Riwayat Kunjungan Pasien</b>',
                                    'isi' => $this->renderPartial($this->path_view_mcu . '_tableRiwayatPasien', array(
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
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Paket <b>Medical Check Up</b>
                </div>
            </div>
            <div class="panel-body">
                <div id='content-pemeriksaan-mcu-paket'>
                    <?php
                    $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaan', array(
                        'modPaketPelayanan' => $modPaketPelayanan,
                    ));
                    ?>
                    <div class="row">
                        <div class='checklists'></div>
                    </div>
                </div>
            </div>
        </div>
        <table id="tabel-paketmcu">
            <tbody>
            </tbody>
        </table>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-time"></i> Rencana Periksa
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <div class="checkbox inline">
                                <label for="PermintaanmcuT_pernahmcu"><b>Pernah ke MCU</b></label>
                                <?php
                                echo CHtml::activeCheckBox($modPemeriksaanMcu, 'pernahmcu', array());
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanMcu, 'tglrencanaperiksa', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $modPemeriksaanMcu->tglrencanaperiksa = (!empty($modPemeriksaanMcu->tglrencanaperiksa) ? date("d/m/Y H:i:s", strtotime($modPemeriksaanMcu->tglrencanaperiksa)) : null);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modPemeriksaanMcu,
                                    'attribute' => 'tglrencanaperiksa',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        //                                    'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                                ));
                                ?>
                                <?php echo $form->error($modPemeriksaanMcu, 'tglrencanaperiksa'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php //echo $form->textAreaRow($modPemeriksaanMcu, 'keteranganpermintaan', array('placeholder' => 'Keterangan Permintaan', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanMcu, 'keteranganpermintaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php //echo $modPemeriksaanMcu->keteranganpermintaan; 
                                ?>
                                <?php
                                //LNG-2729
                                echo $form->textarea($modPemeriksaanMcu, 'keteranganpermintaan', array('row' => 3, 'class' => 'span4', 'placeholder' => 'Keterangan Permintaan'))
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-briefcase"></i> Tabel <b>Pemeriksaan MCU</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="form-tindakanpemeriksaan">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Nominal Tarif</th>
                        <th>Total Tarif</th>
                        <!--<th>&nbsp;</th>-->
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;"><label>Grand Total</label></th>
                            <th style="text-align:right;"><?php echo CHtml::textField('totalMcu', '', array('readonly' => true, 'readonly' => true, 'class' => 'span1 integer-decimal', 'style' => 'width:96px;text-align:right')); ?></th>
                            <!--<th>&nbsp;</th>-->
                        </tr>
                    </tfoot>
                </table>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pilih Pemeriksaan Di Luar Paket', array('{icon}' => '<i class="icon-check icon-white"></i>')), '#', array(
                    'class' => 'btn btn-primary',
                    'onclick' => '$("#dialogPemeriksaan").dialog("open");updateChecklistTindakanMcuDiluarPaket();return false;'
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-pasien">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan MCU - Di Luar Paket</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="form-tindakanpemeriksaan-diluar-paket">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nama Pemeriksaan</th>
                        <th>Ruangan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Nominal Tarif</th>
                        <th>Total Tarif</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right;"><label>Grand Total</label></th>
                            <th style="text-align:right;"><?php echo CHtml::textField('totalDiluarMcu', '', array('readonly' => true, 'readonly' => true, 'class' => 'span1 integer-decimal', 'style' => 'width:96px;text-align:right')); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
            ?>
            <?php
            //                if ($model->isNewRecord) {
            if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PENDAFTARAN){
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi2();', 'onkeypress' => 'setVerifikasi2();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
            }else{
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
            } //formSubmit(this,event)
            //                }else if (isset($_GET['pendaftaran_id'])) {
            //					echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')); //formSubmit(this,event)
            //                }else {
            //                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            //                }
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
                //                    echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    //echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    //echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else if (isset($_GET['pendaftaran_id'])) {
                //                    echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                if (Yii::app()->user->getState('isbridging')) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Fitur Bridging tidak aktif!', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }
            } else {
                //                    echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKarcis();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$model->pasien_id');return false", 'disabled' => FALSE));
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
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Hak & Kewajiban Pasien', array('{icon}' => '<i class="entypo-user"></i>')), array('id' => 'btn_hak_pasien', 'rel' => 'tooltip', 'class' => 'btn btn-info'));
            if ($model->isNewRecord || $model->statuspasien != Params::STATUSPASIEN_BARU) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true)); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} General Consent', array('{icon}' => '<i class="entypo-user"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'setDialogGeneralConsent(' . $model->pendaftaran_id . ');')); //formSubmit(this,event)
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view_mcu . 'tips/tipsPendaftaranRawatJalan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_MCU){
            //     if ($model->isNewRecord) {
            //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            //     } else {
            //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/pembayaranTagihanKarcis/index", array("instalasi_id"=>$model->instalasi_id,"pendaftaran_id"=>$model->pendaftaran_id, "frame" => true, 'pelayanan' => "RJ")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
            //     }
            // }
            
            // if ($model->isNewRecord) {
            //     echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            // } else {
            //     echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$model->pendaftaran_id.');'));
            // }
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <hr>
        <?php $this->renderPartial($this->path_view_mcu . '_tablePendaftaranTerakhir', array('model' => $model)); ?>
        <?php $this->renderPartial($this->path_view . '_generalConsent', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.vaksinasi._dialogVaksinasi', array()); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
    </div>
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
        <?php echo $this->renderPartial($this->path_view_mcu . '_formPanggilAntrian', array('modAntrian' => $modAntrian)); ?>
    </div>
    <div style="text-align: center;">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-backward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian sebelumnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("prev");', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-forward icon-white"></i>')), array('title' => 'Klik untuk menampilkan antrian berikutnya', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-danger', 'onclick' => 'setFormAntrian("next");', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
        <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); 
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('title' => 'Klik untuk mengulang antrian', 'rel' => 'tooltip', 'class' => 'btn btn-mini btn-danger', 'onclick' => 'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}', 'style' => 'font-size:10px; width:24px; height:24px;')); ?>
        <br>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Panggil / Daftar', array('{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian ini', 'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'if(requiredCheck(this)){ panggilAntrian();}', 'style' => 'font-size:10px; width:128px; height:24px;')); ?>
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
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this);$("#content-pemeriksaan-mcu-diluar-paket").html("");$("#pppendaftaran-t-form").submit();')); ?>
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
    $modDiagnosa = new MCDiagnosaM('search');
    $modDiagnosa->unsetAttributes();
    if (isset($_GET['MCDiagnosaM'])) {
        $modDiagnosa->attributes = $_GET['MCDiagnosaM'];
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
    $modCariAsuransiPasien = new MCAsuransipasienM('search');
    $modCariAsuransiPasien->unsetAttributes();
    if (isset($_GET['MCAsuransipasienM'])) {
        $modCariAsuransiPasien->attributes = $_GET['MCAsuransipasienM'];
        isset($_GET['MCAsuransipasienM']['pasien_id']) ? $modCariAsuransiPasien->pasien_id = $_GET['MCAsuransipasienM']['pasien_id'] : '';
        isset($_GET['MCAsuransipasienM']['penjamin_id']) ? $modCariAsuransiPasien->penjamin_id = $_GET['MCAsuransipasienM']['penjamin_id'] : '';
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
    $modCariAsuransiPasienBpjs = new MCAsuransipasienbpjsM('search');
    $modCariAsuransiPasienBpjs->unsetAttributes();
    if (isset($_GET['MCAsuransipasienbpjsM'])) {
        $modCariAsuransiPasienBpjs->attributes = $_GET['MCAsuransipasienbpjsM'];
        isset($_GET['MCAsuransipasienbpjsM']['pasien_id']) ? $modCariAsuransiPasienBpjs->pasien_id = $_GET['MCAsuransipasienbpjsM']['pasien_id'] : '';
        isset($_GET['MCAsuransipasienbpjsM']['penjamin_id']) ? $modCariAsuransiPasienBpjs->penjamin_id = $_GET['MCAsuransipasienbpjsM']['penjamin_id'] : '';
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
        'id' => 'dialogPemeriksaan',
        'options' => array(
            'title' => 'Pemeriksaan di Luar Paket',
            'autoOpen' => false,
            'modal' => true,
            'width' => 960,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <div id='content-pemeriksaan-mcu-diluar-paket'>
        <div class="col-sm-12">
            <?php
            $this->renderPartial($this->path_view_mcu . '_formCariPemeriksaanDiluarPaket', array(
                'modPaketPelayanan' => $modPaketPelayanan,
            ));
            ?>
            <div class='checklists-mcu-diluar-paket'></div>
        </div>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>
<?php echo $this->renderPartial($this->path_view_mcu . '_jsFunctions', array('model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modRujukanBpjs' => $modRujukanBpjs, 'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs, 'modSep' => $modSep, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modPermintaanMcu' => $modPermintaanMcu, 'modPemeriksaanMcu' => $modPemeriksaanMcu, 'modAsuransiPasien' => $modAsuransiPasien, 'modPegawai' => $modPegawai, 'modTindakan' => $modTindakan, 'modPenanggungJawab' => $modPenanggungJawab)); ?>
<?php echo $this->renderPartial($this->path_view_mcu . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctionsAntrian', array('model' => $model, 'modPasien' => $modPasien, 'modPenanggungJawab' => $modPenanggungJawab, 'modRujukan' => $modRujukan, 'modAntrian' => $modAntrian)); ?>
<script>
    $(document).ready(function() {
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>
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