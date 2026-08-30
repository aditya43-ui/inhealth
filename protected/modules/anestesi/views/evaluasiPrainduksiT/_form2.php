<div class="row-fluid" style="margin-bottom: -5px">
    <div class="control-group">
        <label class="control-label">
        <p> <b> PREMEDIKASI </b></p>
        </label>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="control-group ">
            <?php echo CHtml::label("Agen 1.", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'premedikasi_agen1', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("2.", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'premedikasi_agen2', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("3.", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'premedikasi_agen3', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("4.", ' ', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'premedikasi_agen4', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php
            echo CHtml::label("Tanggal / Jam", "tglevaluasi_praanestesi", array(
                'class' => 'control-label required'
            ));
            ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglevaluasi_praanestesi',
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
        <div class="control-group ">
            <?php echo CHtml::activelabel($model, 'Diberikan Oleh', array('class' => 'control-label'))?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'pegawai_pramedikasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo CHtml::activelabel($model, 'Nama Dokter / Perawat', array('class' => 'control-label'))?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'pegawai2_pramedikasi_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id'=> Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 100));
                ?>
            </div>
        </div>
    </div>
</div>