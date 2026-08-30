<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Nama Pemeriksaan</label>
        <div class="controls">
            <?= CHtml::textField('namaPemeriksaan', $model->listpaketpemeriksaan, ['readonly'=>true]) ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pemeriksaan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php                        
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_pemeriksaan',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo Chtml::label('Keperluan MCU <span class="required">*</span>', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jeniskeperluanmcu', LookupM::getItems('jeniskeperluanmcu'), array('empty' => '-- Pilih --', 'class' => 'required span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
</div>

<div class="clear"></div>

<hr/>