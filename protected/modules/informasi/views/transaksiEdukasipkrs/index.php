<?php $linkHalaman = CustomFunction::getUrlByMenuID(3191); ?>
<?php
/**
 * Pembuatan Transaksi Edukasi
 * menambah kolom topikedukasi
 * isseu RSST-1660, RSST-2588,RSST-3414
 * 
 * @author          Yusuf Putra A <yusufinova@gmail.com>, M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version         2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Edukasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = null;
        if (isset($_GET['sukses'])) {
            $sukses = $_GET['sukses'];
        }
        if ($sukses > 0)
            Yii::app()->user->setFlash('success', "Transaksi Edukasi Berhasil Disimpan!");
        ?>
        <?php
        $this->breadcrumbs = array(
            'Transaksi Edukasi',
        );
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'inputPengaduan-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#',
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this)',
            ),
        ));
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="control-group col-md-12">
                    <div class="col-md-2">
                        <label class="control-label">Tanggal Edukasi</label>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php $model->tgledukasi = MyFormatter::formatDateTimeForUser($model->tgledukasi); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgledukasi',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('placeholder' => 'Tanggal Edukasi', 'readonly' => true, 'class' => 'dtPicker3 span3'),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class=' col-md-2'>
                        <?php echo CHtml::label("Instalasi<span class='required'>*</span>", CHtml::activeId($model, 'instalasi_id'), array('class' => 'control-label required')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiEd(), 'instalasi_id', 'instalasi_nama'), array(
                                'empty' => '-- Pilih --',
                                'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                                    'update' => '#' . CHtml::activeId($model, 'ruangan_id')
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class=' col-md-2'>
                        <?php echo CHtml::label("Ruangan<span class='required'>*</span>", CHtml::activeId($model, 'instalasi_id'), array('class' => 'control-label required')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php
                            $criIns = new CDbCriteria();
                            $criIns->addCondition(" ruangan_aktif = TRUE ");
                            $criIns->order = " ruangan_nama ASC ";
                            $dropIns = CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id)), 'ruangan_id', 'ruangan_nama');
                            echo $form->dropDownList($model, 'ruangan_id', $dropIns, array(
                                'empty' => '-- Pilih --', 'class' => 'span3 required',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-md-2">
                        <?php echo CHtml::label("Topik Edukasi <span class='required'>*</span>", '', array('class' => 'control-label')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'topikedukasi', LookupM::getItemsUrutan('topikedukasi_pkrs'), array('style' => 'width:170px;', 'class' => 'form-control span3 required ', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-md-2">
                        <?php echo CHtml::label("Judul Edukasi ", '', array('class' => 'control-label')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php echo $form->textArea($model, 'juduledukasi', array('placeholder' => 'Judul Edukasi', 'rows' => 5, 'cols' => 50, 'class' => 'span12', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="checkbox-bentukedukasi">
                    <div class="col-md-2">
                        <label class="control-label">Bentuk Edukasi</label>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->radioButton($model, 'bentukedukasi_individu', array('id' => 'rbentukedukasi_individu', 'class' => 'no-wrapper', 'uncheckValue' => false)); ?> <label for="rbentukedukasi_individu">Individu</label>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->radioButton($model, 'bentukedukasi_kelompokkecil', array('id' => 'rbentukedukasi_kelompokkecil', 'class' => 'no-wrapper', 'uncheckValue' => false)); ?> <label for="rbentukedukasi_kelompokkecil">Kelompok Kecil (2-10 Orang)</label>
                        </div>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->radioButton($model, 'bentukedukasi_kelompoksedang', array('id' => 'rbentukedukasi_kelompoksedang', 'class' => 'no-wrapper', 'uncheckValue' => false)); ?> <label for="rbentukedukasi_kelompoksedang">Kelompok Sedang (11-20)</label>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->radioButton($model, 'bentukedukasi_kelompokbesar', array('id' => 'rbentukedukasi_kelompokbesar', 'class' => 'no-wrapper', 'uncheckValue' => false)); ?> <label for="rbentukedukasi_kelompokbesar">Kelompok Besar (>20)</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-md-2">
                        <label class="control-label">Metode Edukasi</label>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'metode_ceramah', array('id' => 'rmetode_ceramah', 'onclick' => 'setMetode(this);')); ?> <label for="rmetode_ceramah">Ceramah</label> <br>
                            <?php echo $form->textField($model, 'metode_ceramah_nilai', array('class' => 'numbers-only span2 metode_nilai')); ?>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'metode_demontrsasi', array('id' => 'rmetode_demontrsasi', 'onclick' => 'setDemo(this);')); ?> <label for="rmetode_demontrsasi">Demonstrasi</label> <br>
                            <?php echo $form->textField($model, 'metode_demonstrasi_nilai', array('class' => 'numbers-only span2 metode_nilai')); ?>
                        </div>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'metode_diskusi', array('id' => 'rmetode_diskusi', 'onclick' => 'setDiskusi(this);')); ?> <label for="rmetode_diskusi">Diskusi Kelompok</label> <br>
                            <?php echo $form->textField($model, 'metode_diskusi_nilai', array('class' => 'numbers-only span2 metode_nilai')); ?>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'metode_wawancara', array('id' => 'rmetode_wawancara', 'onclick' => 'setWawancara(this);')); ?> <label for="rmetode_wawancara">Tatap Muka</label> <br>
                            <?php echo $form->textField($model, 'metode_wawancara_nilai', array('class' => 'numbers-only span2 metode_nilai')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-md-2">
                        <label class="control-label">Alat/AVA</label>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'sarana_leaflet', array('id' => 'rsarana_leaflet',)); ?> <label for="rsarana_leaflet">Leaflet</label>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'sarana_poster', array('id' => 'rsarana_poster',)); ?> <label for="rsarana_poster">Poster</label>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'sarana_microphone', array('id' => 'rsarana_microphone',)); ?> <label for="rsarana_microphone">Microphone</label>
                        </div>
                        <div class="controls col-md-12">
                            <div col-md-2>
                            </div>
                            <div col-md-6>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col-md-5">
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'sarana_ohp', array('id' => 'rsarana_ohp',)); ?> <label for="rsarana_ohp">OHP</label>
                        </div>
                        <div class="controls col-md-12">
                            <?php echo $form->checkBox($model, 'sarana_lcd', array('id' => 'rsarana_lcd',)); ?> <label for="rsarana_lcd">LCD</label>
                        </div>
                        <div class="controls col-md-12">
                            <div col-md-12>
                                <?php echo $form->checkBox($model, 'sarana_lainnya', array('id' => 'rsarana_lainnya', 'onclick' => 'cekKebutuhanLain();')); ?> <label for="rsarana_lainnya">Lainnya</label>
                                <?php echo $form->textField($model, 'saraba_lainntaket', array('placeholder' => 'Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'kp_namapelapor',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
                ?>
                <?php //echo $form->textFieldRow($model,'kp_noidentitasn_pelapor',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
                ?>
                <?php //echo $form->textFieldRow($model,'kp_alamat_pelapor',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); 
                ?>
                <?php //echo $form->textFieldRow($model,'kp_hp_pelapor',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="col-md-2">
                        <label class="control-label">Edukator</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-md-2">
                        <label class="control-label">Peserta</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Dokter", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'dokterpenyuluh', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Paramedis", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'paramedispenyuluh', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Lainnya", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'penyuluhlainnya', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Pasien", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'jml_pasien', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Keluarga Pasien", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'jml_keluargapasien', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Laki-laki", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'jml_lakilaki', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-label col-md-2">
                                <?php echo CHtml::label("Perempuan", '', array('class' => 'control-label')) ?>
                            </div>
                            <div class="control-group col-md-3">
                                <div class="controls">
                                    <?php echo $form->textField($model, 'jml_perempuan', array('placeholder' => '0', 'class' => 'span3  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => false)); ?>
                                </div>
                            </div>
                            <div class="col-md-3" align="right">Orang
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="control-label col-md-2">
                        <?php echo CHtml::label("Upload File", '', array('class' => 'control-label')) ?>
                    </div>
                    <div class="control-group col-md-3 upload">
                        <div class="panel-body">
                            <table id="tabel-detail" class="table remove-table-hover">
                                <tbody>
                                    <?php
                                        echo $this->renderPartial($this->path_view.'_row_det',['form' => $form], true);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="control-label col-md-2">
                        <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php
                            if (!empty($model->file_lampiran)) {
                                echo $model->file_lampiran;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="control-label col-md-2">
                        <?php echo CHtml::label("Pertanyaan", '', array('class' => 'control-label')) ?>
                    </div>
                    <div class="control-group col-md-10">
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'pertanyaan', 'toolbar' => 'mini', 'height' => '300px')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='form-actions'>
            <?php
            $disableSave = false;
            if (isset($_GET['sukses'])) {
                $disableSave = true;
            }
            ?>
            <?php
            if (@$_GET['sukses'] == 1) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'button',
                    'disabled' => true,
                    'title' => 'Simpan',
                    'onclick' => "return false",
                    'style' => 'cursor:not-allowed;'
                ));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('Index') . '";}); return false;'
                ));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
                    'class' => 'btn btn-danger', 'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'id' => 'btn_simpan',
                ));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('Index') . '";}); return false;'
                ));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    //    digunakan untuk cancel image
    var inputElement = document.getElementById("INEdukasipkrsT_file_lampiran");
    var cancelButton = document.getElementById("pseudoCancel");
    var numFiles = 0;
    inputElement.onclick = function(event) {
        var target = event.target || event.srcElement;
        if (target.value.length == 0) {
            cancelButton.onclick();
        } else {
            numFiles = target.files.length;
        }
    }
    cancelButton.onclick = function(event) {
        $("#pseudoCancel").hide();
    }

    function cekKebutuhanLain() {
        var pen = $("#rsarana_lainnya").is(":checked");
        if (pen == true) {
            $("#<?php echo CHtml::activeId($model, 'saraba_lainntaket') ?>").removeAttr('readonly');
        } else {
            $("#<?php echo CHtml::activeId($model, 'saraba_lainntaket') ?>").val('').attr('readonly', true);
        }
    }

    function setMetode(obj) {
        var ada = $('#rmetode_ceramah');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'metode_ceramah_nilai') ?>").prop('disabled', false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'metode_ceramah_nilai') ?>").val('').prop('disabled', true);
        }
    }

    function setDemo(obj) {
        var ada = $('#rmetode_demontrsasi');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'metode_demonstrasi_nilai') ?>").prop('disabled', false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'metode_demonstrasi_nilai') ?>").val('').prop('disabled', true);
        }
    }

    function setWawancara(obj) {
        var wawancara = $("#rmetode_wawancara").is(":checked");
        if (wawancara == true) {
            $("#<?php echo CHtml::activeId($model, 'metode_wawancara_nilai') ?>").prop('disabled', false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'metode_wawancara_nilai') ?>").val('').prop('disabled', true);
        }
    }

    function setDiskusi(obj) {
        var diskusi = $("#rmetode_diskusi").is(":checked");
        if (diskusi == true) {
            $("#<?php echo CHtml::activeId($model, 'metode_diskusi_nilai') ?>").prop('disabled', false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'metode_diskusi_nilai') ?>").val('').attr('disabled', true);
        }
    }
    $(document).ready(function() {
        $(':radio').mousedown(function(e) {
            var $self = $(this);
            if ($self.is(':checked')) {
                var uncheck = function() {
                    setTimeout(function() {
                        $self.removeAttr('checked');
                    }, 0);
                };
                var unbind = function() {
                    $self.unbind('mouseup', up);
                };
                var up = function() {
                    uncheck();
                    unbind();
                };
                $self.bind('mouseup', up);
                $self.one('mouseout', unbind);
            }
        });
        $("#<?php echo CHtml::activeId($model, 'saraba_lainntaket') ?>").removeAttr('readonly');
        setDiskusi();
        setWawancara();
        setDemo();
        setMetode();
        $("#checkbox-bentukedukasi").find('input:radio').click(function() {
            $("#checkbox-bentukedukasi").find('input:radio').each(function() {
                $(this).prop("checked", false);
            });
            $(this).prop("checked", true);
        });
    });
    document.getElementById("INEdukasipkrsT_file_lampiran").onchange = function() {
        console.log(this.files[0]);
        if (this.files[0]) {
            $("#pseudoCancel").show();
        }

        form_body.each(function(){             
            if (row > 0){
                $(this).find('label.no-label').html('');
            }
            $(this).find(".nomor").html(row+1);
            $(this).attr("row-data",row);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                if (typeof $(this).attr("name") !== 'undefined'){
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");

                    if(old_name_arr.length == 3){
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                        $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                    }
                }
            });

            $(this).find('.btn-tambah').removeClass('hide');
            $(this).find('.btn-hapus').removeClass('hide');
            if (row == 0) {
                if (count == 1){                
                    $(this).find('.btn-hapus').addClass('hide');                    
                }else{
                    $(this).find('.btn-tambah').addClass('hide');
                }
            }else{                
                if (count != (row+1)){
                    $(this).find('.btn-tambah').addClass('hide');  
                }
            }

            row++;
        });

    }
</script>