<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'luluskomponendarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kantong Darah</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Nomor Barcode", 'no_kantongdarah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modKantong, 'nomorbarcode', array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Nomor Kantong Darah')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Jenis Kantong Darah", 'nama_jenis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="controls">
                                <?php echo $form->hiddenField($modKantong, 'nomorbarcode', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'kantongdarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'jeniskantongdarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponendarah_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->textField($modKantong, 'nama_jenis', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'skriningimltd_id', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponen_ffp', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponen_tc', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponen_wb', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponen_prc', array('class' => 'span3', 'readonly' => true)); ?>
                                <?php echo $form->hiddenField($modKantong, 'komponen_pcr', array('class' => 'span3', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Tgl. Penerimaan Kantong", 'tglpencatatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modKantong,
                                'attribute' => 'tglpencatatan',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    // 'maxDate' => 'd',
                                    //
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'disabled' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modKantong, 'gol_darah', array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Nomor Kantong Darah')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Rhesus", 'rhesus', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modKantong, 'rhesus', array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Nomor Kantong Darah')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Ruangan Asal", 'ruangandaftar_nama', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modKantong, 'ruangandaftar_nama', array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Ruangan Asal')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Hasil / Kesimpulan <b>Pengujian Sebelumnya</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Skrining IMLTD", 'nomorbarcode', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'hasilskrining', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Konfirmasi Gol. Darah", 'hasil_uji', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'hasil_uji', array('readonly' => true, 'class' => 'span3')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Komponen Darah", 'singkatan_komp', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modKantong, 'singkatan_komp', array('readonly' => true, 'class' => 'span1')) ?>
                        /
                        <?php echo $form->textField($modKantong, 'hasilkomponen', array('readonly' => true, 'class' => 'span2')) ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Pelulusan <b>Produksi Komponen </b>
                </div>
            </div>

            <div class="panel-body">
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="control-group">
                    <?php echo CHtml::label("Keterangan ", 'keteranganpelulusan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'keteranganpelulusan', array('readonly' => true, 'class' => 'span3', 'placeholder' => 'Keterangan Pelulusan Komponen Darah')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Mutu", 'statuspelulusan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'statuspelulusan', array('class' => 'span2', 'disabled' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        if ($model->statuspelulusan == "TIDAK LULUS") {
                            echo $form->textField($model, 'alasantidaklulus', array('disabled' => true, 'onkeyup' => "return $(this).focusNextInputField(event)"));
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br> <br>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pelulusan", 'tglpelulusan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpelulusan',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'disabled' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:204px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Koordinator Mutu", 'koordinatormutu_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $criteria = new CDbCriteria();
                        $criteria->addCondition("ruangan_id=" . Yii::app()->user->getState('ruangan_id'));
                        echo $form->dropDownList($model, 'koordinatormutu_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'), array('disabled' => true, 'empty' => '-- Pilih --'))
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br> <br>
                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instansi Transfusi Darah", 'kepalainstalasi_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $criteria = new CDbCriteria();
                        $criteria->addCondition("ruangan_id=" . Yii::app()->user->getState('ruangan_id'));
                        echo $form->dropDownList($model, 'kepalainstalasi_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'), array('disabled' => true, 'empty' => '-- Pilih --'))
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <script>
        function setSkrining(obj) {
            var L = $("#InfokantongdarahV_skriningimltd_id").val();
            var k = $("#InfokantongdarahV_singkatan_komp").val();
            var A = $('#InfokantongdarahV_skriningimltd_id').val();
            var antihiv = $('#InfokantongdarahV_antihiv').val();
            var antihvc = $('#InfokantongdarahV_antihvc').val();
            var hbsag = $('#InfokantongdarahV_hbsag').val();
            var sifilis = $('#InfokantongdarahV_sifilis').val();
            var ffp = $("#InfokantongdarahV_komponen_ffp").val();
            var tc = $("#InfokantongdarahV_komponen_tc").val();
            var wb = $("#InfokantongdarahV_komponen_wb").val();
            var pcr = $("#InfokantongdarahV_komponen_pcr").val();
            var prc = $("#InfokantongdarahV_komponen_prc").val();
            var status = $("#LuluskomponendarahT_statuspelulusan").val();
            var total = " ";
            if (antihiv == true || antihvc == true || hbsag == true || sifilis == true) {
                total = "reaktif";
                $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val("Reaktif").attr('readonly', true);
            } else {
                total = "non reaktif";
                if (L != "") {
                    $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val("Non Reaktif").attr('readonly', true);
                } else {
                    $("#<?php echo CHtml::activeId($modKantong, 'hasilskrining') ?>").val(" ").attr('readonly', true);
                }
            }
            if (k == "FFP") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(ffp).attr('readonly', true);
            } else if (k == "TC") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(tc).attr('readonly', true);
            } else if (k == "PRC") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(prc).attr('readonly', true);
            } else if (k == "WB") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(wb).attr('readonly', true);
            } else if (k == "PCR") {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(pcr).attr('readonly', true);
            } else {
                $("#<?php echo CHtml::activeId($modKantong, 'hasilkomponen') ?>").val(" ").attr('readonly', true);
            }
        }

        $(document).ready(function() {
            setSkrining();
        });
    </script>