<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'jenispesanmenu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPesan, 'nopesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeTextField($modPesan, 'nopesanmenu', array('readonly' => true))
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPesan, 'tglpesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPesan->tglpesanmenu = MyFormatter::formatDateTimeForUser($modPesan->tglpesanmenu);
                echo CHtml::activeTextField($modPesan, 'tglpesanmenu', array('readonly' => true))
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPesan, 'jenispesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeTextField($modPesan, 'jenispesanmenu', array('readonly' => true,))
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPesan, 'ruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo CHtml::activeTextField($modPesan, 'ruangan_id', array('readonly' => true, 'value' =>  RuanganM::model()->findByPK($modPesan->ruangan_id)->ruangan_nama))
                ?>
            </div>
        </div>
    </div>
</div>