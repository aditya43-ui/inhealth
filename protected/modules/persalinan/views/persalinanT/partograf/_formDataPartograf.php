<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - digunakan untuk menginut data partograf
 * RSST-1603
 */
?>
<p>&nbsp;</p>
<div class="panel panel-dark">
    <span class="group-title">
        <i class="glyphicon glyphicon-file"></i> Data <b>Partograf</b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Tanggal Periksa <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglperiksa',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMATV2,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Tanggal Periksa', 'readonly' => true, 'class' => ' span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'gravida', array('class' => 'numbers-only')) ?>
                <?php echo $form->textFieldRow($model, 'para', array('class' => 'numbers-only')) ?>
                <?php echo $form->textFieldRow($model, 'abortus', array('class' => 'numbers-only')) ?>

                <div id="aturspan">
                    <div class="control-group">
                        <label class="control-label">Tinggi Badan</label>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tinggibadan', array('class' => 'numbers-only')) ?>
                        </div>
                        <div class="controls">
                            <label> cm</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Berat Badan</label>
                        <div class="controls">
                            <?php echo $form->textField($model, 'beratbadan', array('class' => 'numbers-only')) ?>
                        </div>
                        <div class="controls">
                            <label> kg</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Tinggi Fundus</label>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tinggifundus', array('class' => 'numbers-only')) ?>
                        </div>
                        <div class="controls">
                            <label> cm</label>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Ukuran Panggul</label>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_ukuran', array('uncheckValue' => null, 'value' => 'N')) ?>
                    </div>
                    <div class="controls">
                        <label>N</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_ukuran', array('uncheckValue' => null, 'value' => 'PSR')) ?>
                    </div>
                    <div class="controls">
                        <label>PSR</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_ukuran', array('uncheckValue' => null, 'value' => 'PSA')) ?>
                    </div>
                    <div class="controls">
                        <label>PSA</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Posisi Pengukuran Panggul</label>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_posisipengukuran', array('uncheckValue' => null, 'value' => 'BAP')) ?>
                    </div>
                    <div class="controls">
                        <label>BAP</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_posisipengukuran', array('uncheckValue' => null, 'value' => 'BTP')) ?>
                    </div>
                    <div class="controls">
                        <label>BTP</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'panggul_posisipengukuran', array('uncheckValue' => null, 'value' => 'PBP')) ?>
                    </div>
                    <div class="controls">
                        <label>PBP</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Perhatian Khusus</label>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'perhatiankhusus'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class=""><b>Usia Kehamilan Menurut :</b></label>
                    <div class="controls">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Usia Kehamilan</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'usiakehamilan', array('placeholder' => 'Usia kehamilan menurut : satuan minggu', 'class' => 'numbers-only')); ?>
                    </div>
                    <div class="controls">
                        <label> mg</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Haid Terakhir</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'perkiraan_usiahamil_byhaid', array('placeholder' => 'usia kehamilan menurut : haid terakhir', 'class' => 'numbers-only')) ?>
                    </div>
                    <div class="controls">
                        <label> mg</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tinggi Fundus</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'perkiraan_usiahamil_byfundus', array('placeholder' => 'usia kehamilan menurut : tinggi fundus', 'class' => 'numbers-only')) ?>
                    </div>
                    <div class="controls">
                        <label> mg</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USG</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'perkiraan_usiahamil_byusg', array('placeholder' => 'usia kehamilan menurut : USG', 'class' => 'numbers-only')) ?>
                    </div>
                    <div class="controls">
                        <label> mg</label>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label"><b>Selaput Ketuban Pecah</b></label>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'is_selaputketubanpecah', array('uncheckValue' => null, 'value' => true)); ?>
                    </div>
                    <div class="controls">
                        <label>Sudah</label>
                    </div>
                    <div class="controls">
                        <?php echo $form->radioButton($model, 'is_selaputketubanpecah', array('uncheckValue' => null, 'value' => false)); ?>
                    </div>
                    <div class="controls">
                        <label>Belum</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'selaputketubanpecah_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'showAnim'=>"",
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Tanggal', 'readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'selaputketubanpecah_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'showAnim'=>"",
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Jam', 'readonly' => true, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class=""><b>Perkiraan Kelahiran</b></label>
                    <div class="controls">

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Lahir</label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'perkiraanlahir_tgl',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                //                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Tanggal Lahir', 'readonly' => false, 'class' => ' ', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berat Janin</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'beratjanin', array('class' => 'numbers-only')) ?>
                    </div>
                    <div class="controls">
                        <label> gram</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>