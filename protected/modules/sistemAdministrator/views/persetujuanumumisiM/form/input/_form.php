<?php

$inputan = $inputan ?? new PersetujuanumuminputanM;
$idx = $idx ?? "ii";

?>
<div class="input_base" data-input-index="<?php echo $idx; ?>" style="border: 1px solid black; padding: 5px;">

    <?php echo CHtml::htmlButton('-', array('class'=>'btn btn-danger', 'onclick'=>"$(this).parents('.input_base').remove();", 
        'style'=>'float: right;')); ?>
    
    <div class="control-group">
        <label class="control-label">Tipe Input <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::activeRadioButtonList($inputan, '['.$idx.']tipeinput', array(
                'checkbox'=>'Checkbox',
                'radiobutton'=>'Radio Button',
                'dropdown'=>'Dropdown List',
                'textfield'=>'Textfield',
                'textarea'=>'Text Area',
            ), array(
                'template'=>'<div style="display: inline-block;">{input}{label}</div>',
                'uncheckValue'=>null,
                'onclick'=>'pilihTipeInput(this);'
            )); ?>
        </div>
    </div>

    <div class="input_detail">
        <?php
        
        if (!$inputan->isNewRecord) {
            echo match($inputan->tipeinput) {
                'checkbox' => $this->renderPartial('form/input/_checkbox', array('inputan'=>$inputan, 'idx'=>$idx), true),
                'radiobutton' => $this->renderPartial('form/input/_radio', array('inputan'=>$inputan, 'idx'=>$idx), true),
                'dropdown' => $this->renderPartial('form/input/_dropdown', array('inputan'=>$inputan, 'idx'=>$idx), true),
                'textfield' => $this->renderPartial('form/input/_textfield', array('inputan'=>$inputan, 'idx'=>$idx), true),
                'textarea' => $this->renderPartial('form/input/_textarea', array('inputan'=>$inputan, 'idx'=>$idx), true),
            };
        }
        
        ?>
        <?php //echo $this->renderPartial('form/input/_checkbox', array('inputan'=>$inputan, 'idx'=>$idx), true); ?>
        <?php //echo $this->renderPartial('form/input/_radio', array('inputan'=>$inputan, 'idx'=>$idx), true); ?>
        <?php //echo $this->renderPartial('form/input/_textfield', array('inputan'=>$inputan, 'idx'=>$idx), true); ?>
        <?php //echo $this->renderPartial('form/input/_textarea', array('inputan'=>$inputan, 'idx'=>$idx), true); ?>
        <?php //echo $this->renderPartial('form/input/_dropdown', array('inputan'=>$inputan, 'idx'=>$idx), true); ?>
    </div>
    
    
</div>


