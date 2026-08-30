<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-ambulance"></i> Pemesanan Ambulans <b>Pasien Rumah Sakit</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pemesanan Ambulans Pasien RS',
        );
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        if ($sukses > 0) {
            Yii::app()->user->setFlash('success', "Transaksi Pesan Ambulans " . $modPemesanan->pesanambulans_no . " Berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pesanambulans-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''
            ),
            'focus' => '#' . CHtml::activeId($modPemesanan, 'norekammedis'),
        )); ?>
        <?php echo $form->errorSummary($modPemesanan); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemesanan Ambulans</span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?>
                </div>
            </div>
            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo CHtml::activeHiddenField($modPemesanan, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::activeHiddenField($modPemesanan, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->hiddenField($modPemesanan, 'norekammedis', array('class' => 'span3', 'onchange' => 'clearDataPasien();', 'maxlength' => 100)); ?>
                        <?php echo $form->hiddenField($modPemesanan, 'namapasien', array('class' => 'span3 reqPasien', 'onchange' => 'clearDataPasien();', 'maxlength' => 100)); ?>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'Tanggal Pemesanan Ambulans', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $modPemesanan->tglpemesananambulans = MyFormatter::formatDateTimeForUser($modPemesanan->tglpemesananambulans); ?>
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPemesanan,
                                    'attribute' => 'tglpemesananambulans',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker2-5'),
                                ));
                                ?>
                                <?php $modPemesanan->tglpemesananambulans = MyFormatter::formatDateTimeForDb($modPemesanan->tglpemesananambulans); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'no_pesan_ambulans <span class="required">*</span>', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'pesanambulans_no', array('readonly' => true, 'class' => 'span3 reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'title' => 'Otomatis dibuat setelah simpan', 'rel' => 'tooltip')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'tempat tujuan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'tempattujuan', array('class' => 'span3', 'placeholder' => 'Tempat Tujuan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'kelurahan_nama', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'kelurahan_nama', array('class' => 'span3', 'placeholder' => 'Nama Kelurahan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'alamat tujuan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modPemesanan, 'alamattujuan', array('class' => 'span3', 'placeholder' => 'Alamat Tujuan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <?php //echo $form->textFieldRow($modPemesanan,'rt_rw',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemesanan, 'rt', array('class' => 'control-label inline')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'rt', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RT')); ?> /
                                <?php echo $form->textField($modPemesanan, 'rw', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbers-only', 'maxlength' => 3, 'placeholder' => 'RW')); ?>
                                <?php echo $form->error($modPemesanan, 'rt'); ?>
                                <?php echo $form->error($modPemesanan, 'rw'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'No. Handphone', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'nomobile', array('class' => 'span3 numbers-only', 'placeholder' => 'No. Handphone', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'no telepon', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modPemesanan, 'notelepon', array('class' => 'span3 numbers-only', 'placeholder' => 'No. Telepon', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'Tanggal Pemakaian Ambulans', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPemesanan,
                                    'attribute' => 'tglpemakaianambulans',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //'minDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => false, 'class' => 'span3 dtPicker2-5',
                                        'placeholder' => 'Pilih Tanggal Pemakaian',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'untuk keperluan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modPemesanan, 'untukkeperluan', array('class' => 'span3', 'placeholder' => 'Keperluan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php // echo CHtml::activeLabel($modPemesanan, 'keterangan pesan', array('class' => 'control-label')); 
                            ?>
                            <?php echo CHtml::Label('Keterangan Pesan (Emergency / Non Emergency)', 'Keterangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modPemesanan, 'keteranganpesan', array('class' => 'span3', 'placeholder' => 'Keterangan Pesan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::activeLabel($modPemesanan, 'Ruangan <span class="required">*</span>', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo CHtml::dropDownList(
                                    'instalasi',
                                    $modPemesanan->instalasi_id,
                                    CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                                    array(
                                        'empty' => '-- Instalasi --', 'class' => 'reqPasien',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' =>  CController::createUrl('dynamicRuangan'),
                                            'update' => '#AMPesanambulansT_ruangan_id',
                                        ), 'class' => 'span3'
                                    )
                                ); ?><br>
                                <?php echo CHtml::activeDropDownList($modPemesanan, 'ruangan_id', (!empty($modPemesanan->instalasi_id) ? CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $modPemesanan->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama') : array()), array('empty' => '-- Ruangan --', 'class' => 'span3 reqPasien')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $disabled = false;
            if (isset($_GET['sukses'])) {
                $disabled = true;
            }
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('Index'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('ambulans.views.tips.transaksi_ambulans', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPemesanan' => $modPemesanan)); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    $('#resetbtn').click(function() {
        window.location = '<?php echo $this->createUrl('index'); ?>';
    });

    function clearDataPasien() {
        $("#<?php echo CHtml::activeId($modPemesanan, 'pasien_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modPemesanan, 'norekammedis') ?>").val('');
        $("#<?php echo CHtml::activeId($modPemesanan, 'pendaftaran_id') ?>").val('');
    }
</script>
<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));
$modPasien = new AMPasienM('searchPasien');
$modPasien->unsetAttributes();
if (isset($_GET['PasienM'])) {
    $modPasien->attributes = $_GET['PasienM'];
}
echo "<legend class=rim> Tabel Data Pasien</legend>";
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchPasien(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#AMPesanambulansT_norekammedis\").val(\"$data->no_rekam_medik\");
                                                          $(\"#AMPesanambulansT_namapasien\").val(\"$data->nama_pasien\");
                                                          $(\"#AMPesanambulansT_alamattujuan\").val(\"$data->alamat_pasien\");
                                                          $(\"#AMPesanambulansT_nomobile\").val(\"$data->no_mobile_pasien\");
                                                          $(\"#AMPesanambulansT_notelepon\").val(\"$data->no_telepon_pasien\");
                                                          $(\"#AMPesanambulansT_pasien_id\").val(\"$data->pasien_id\");
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end obatAlkes dialog =============================
?>
<script>
    function cekValidasi() {
        var kosong = '';
        var reqPasien = $("#pesanambulans-t-form").find(".reqPasien[value=" + kosong + "]");
        var pasienKosong = reqPasien.length;
        if (pasienKosong != 0) {
            myAlert('Harap Isi Semua Bagian Yang Bertanda * pada Data Transaksi Pesan Ambulans');
            return false;
        } else {
            return true;
        }
        return false;
    }
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($modPemesanan->pesanambulans_t)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_AMBULANS ?>,
                judulnotifikasi: 'Pemesanan Ambulans',
                isinotifikasi: 'Telah dilakukan pemesanan ambulans atas nama <?php echo $modPemesanan->pasien->nama_pasien ?> dengan <?php echo $modPemesanan->pasien->no_rekam_medik ?> pada <?php echo $modPemesanan->tglpemesananambulans ?> untuk pemakaian pada <?php echo $modPemesanan->tglpemakaianambulans ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
        //                cekDisabled($('#pesanambulans-t-form'));
    });
</script>