<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php
            echo CHtml::label("Makan Terakhir", "makanterakhir", array(
                'class' => 'control-label required'
            ));
            ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'makanterakhir',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php
            echo CHtml::label("Minum Terakhir", "minumterakhir", array(
                'class' => 'control-label required'
            ));
            ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'minumterakhir',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid" style="margin-bottom: -5px">
    <div class="control-group">
        <label class="control-label">
        <p> <b> VITAL SIGN </b></p>
        </label>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="control-group">
            <?php echo CHtml::label("TD", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tekanandarah_sistolik', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")).' / '.
                           $form->textField($model, 'tekanandarah_diastolik', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")).' mmHg'; ?>
            </div>
            <?php echo CHtml::label("HR", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'denyutjantung', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")).' x/menit'; ?>
            </div>
            <?php echo CHtml::label("t", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'suhu', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
            <?php echo CHtml::label("SpO2", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'spo2', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")).' x/menit'; ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Masalah Saat Induksi <span style='color:transparent'>Induksi</span>", ' ', array('class'=>'control-label')); ?>
            <div class="controls" style="padding-top: 8px">
                <?php echo CHtml::activeRadioButtonList($model, 'masalahsaatinduksi_ada', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setInduksi();')); ?>       
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(" ", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'masalahsaatinduksi_ada_keterangan', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Perubahan Rencana Anestesi", ' ', array('class'=>'control-label')); ?>
            <div class="controls" style="padding-top: 8px">
                <?php echo CHtml::activeRadioButtonList($model, 'perubahanrencanaanestesi_ada', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setPerubahan();')); ?>       
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(" ", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'perubahanrencanaanestesi_ada_keterangan', array('class' => 'span3', 'placeholder' => 'Sebutkan Jika Ada', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::activelabel($model, 'Nama Dokter', array('class' => 'control-label'))?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'pegawai1_evaluasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::activelabel($model, 'Nama Dokter / Perawat', array('class' => 'control-label'))?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'pegawai2_evaluasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
    </div>
</div>