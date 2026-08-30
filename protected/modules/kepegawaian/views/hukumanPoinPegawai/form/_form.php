<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'poinpegawai_tgl', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php

            $model->poinpegawai_tgl = MyFormatter::formatDateTimeForUser($model->poinpegawai_tgl);
            echo CHtml::hiddenField('tempTgl', $model->poinpegawai_tgl, array('readonly' => true));
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'poinpegawai_tgl',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'onchange' => 'resetTgl(this);', 'readonly' => true, 'class' => 'span3 dtPicker3',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'poinpegawai_alasan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'poinpegawai_alasan', array('placeholder' => 'Alasan', 'class' => 'form-control autogrow span4')) ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <?php echo $form->hiddenField($model, 'pegpembuat_id', array('readonly' => true, 'class' => 'form-control', 'placeholder' => '' . $model->getAttributeLabel('boo_pegdilapor_id'),)); ?>
    <div class="form-group">
        <?php echo CHtml::label("Pencatat <span class='required'>*</span>", 'peg_dilapornama', array('class' => 'control-label col-sm-3')) ?>
        <div class="col-sm-5">
            <?php echo $form->textField($model, 'pegpembuat_nama', array('readonly' => true, 'class' => 'form-control required', 'placeholder' => '' . $model->getAttributeLabel('boo_pegdilapor_id'),)); ?>
        </div>
    </div>
</div>


<div class="clear"></div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Hukuman Poin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo $this->renderPartial($this->path_view . 'table/_tableItems', array('model' => $model, 'form' => $form, 'det' => $det), true); ?>
    </div>
</div>