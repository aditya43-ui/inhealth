<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'lkrujukankeluar-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
            <?php echo $form->textFieldRow(
                $model,
                'rumahsakitrujukan',
                array(
                    'class' => 'span3 form-control',
                    'maxlength' => 50,
                    'placeholder' => 'Asal Rujukan',
                )
            ); ?>
            <?php echo $form->textAreaRow(
                $model,
                'alamatrsrujukan',
                array(
                    'rows' => 3,
                    'cols' => 20,
                    'class' => 'span3 form-control',
                    'placeholder' => 'Alamat',
                )
            ); ?>
    </div>
    <div class="col-sm-6">
            <?php echo $form->textFieldRow(
                $model,
                'telp_fax',
                array(
                    'class' => ' form-control',
                    'maxlength' => 50,
                    'placeholder' => 'Telepon Fax',
                )
            ); ?>

            <div class="control-group">
                <?php echo CHtml::label("", 'rujukankeluar_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'rujukankeluar_aktif', array('checked' => 'checked', 'id' => 'rujukankeluar_aktif')); ?> <label for="rujukankeluar_aktif">Aktif</label>
                </div>
            </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array(
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'title' => 'Cari',
        )
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'class' => 'btn btn-default',
            'type' => 'reset',
            'title' => 'Ulang',
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<hr>