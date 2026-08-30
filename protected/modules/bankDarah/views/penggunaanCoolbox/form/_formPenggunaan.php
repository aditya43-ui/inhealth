<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Penggunaan Coolbox</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-6">
                <div class="control-group ">
                    <?php echo CHtml::label('No. Penggunaan Coolbox', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'no_penggunaan_coolbox', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_penggunaan_coolbox',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>                   
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Coolbox', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'coolboxdarah_id', CHtml::listData(CoolboxdarahM::model()->findAll(), 'coolboxdarah_id', 'coolboxdarah_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onClick'=>'cekData();')); ?>				 
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Lokasi Rekrutmen', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>				 
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah Ice Pack', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jumlah_icepack', array('class' => 'span3 numbers-only')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ukuran Coolbox', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'ukuran_coolbox', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis Kantong Yang Diisikan', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'jenis_kantong', array('class' => 'span3', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Standar Suhu', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'standar_suhu', array('class' => 'span3', 'readonly' => true)); ?> ℃
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>