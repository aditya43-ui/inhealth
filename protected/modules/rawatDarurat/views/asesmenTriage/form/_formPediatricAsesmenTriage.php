<div class="row">
    <div class="col-sm-8">
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'appereance', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textArea($modAsesTriase, 'appereance', array('class' => 'autogrow'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'workofbreathing', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textArea($modAsesTriase, 'workofbreathing', array('class' => 'autogrow'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'crculation', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textArea($modAsesTriase, 'crculation', array('class' => 'autogrow'));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4" style="text-align: center;">
        <img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/data/images/pediatic.png' ?>"/>
    </div>
</div>