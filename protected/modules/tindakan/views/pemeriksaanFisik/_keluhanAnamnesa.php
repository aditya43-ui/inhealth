<div class="control-group">
    <?php echo $form->labelEx($model, 'keluhanutama', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'keluhanutama', 'toolbar' => 'mini', 'height' => '200px')) ?>
        <?php
        /*
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $model,
            'attribute' => 'keluhanutama',
            'data' => empty($model->keluhanutama) ? array() : (is_array($model->keluhanutama) ? $model->keluhanutama : explode(',', $model->keluhanutama)),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                'json_url' => $this->createUrl('/rawatJalan/anamnesa/MasterKeluhan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
        ));
        */
        ?>
        <?php echo $form->error($model, 'keluhanutama'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'keluhantambahan', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo $form->textArea($model, 'keluhantambahan', array('placeholder' => 'Keluhan Tambahan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php
        /*
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $model,
            'attribute' => 'keluhantambahan',
            'data' => empty($model->keluhantambahan) ? array() : (is_array($model->keluhantambahan) ? $model->keluhantambahan : explode(',', $model->keluhantambahan)),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                'json_url' => $this->createUrl('/rawatJalan/anamnesa/MasterKeluhan'),
                'addontab' => true,
                'maxitems' => 10,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
            ),
        ));
        */
        ?>
        <?php echo $form->error($model, 'keluhantambahan'); ?>
    </div>
</div>