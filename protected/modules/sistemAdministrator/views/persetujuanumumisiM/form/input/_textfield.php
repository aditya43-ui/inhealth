<div class="input_base_detail">
    <div class="control-group">
        <label class="control-label">
            Jumlah Textfield <span class="required">*</span>
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextField($inputan, '['.$idx.']inputan_jumlah', array('class'=>'span1 numbers-only', 'onblur'=>'setInputanDetailTextfield(this);')); ?>
            <div class="textfield_gen_subinput">
                <?php
                    if (!$inputan->isNewRecord) {
                        $details = PersetujuanumuminputandetM::model()->findAllByAttributes(array(
                            'persetujuanumuminputan_id'=>$inputan->persetujuanumuminputan_id,
                        ), array(
                            'order'=>'urutan asc',
                        ));

                        foreach ($details as $idx2 => $detail) {
                            echo $this->renderPartial('form/input/_textfield_detail', array(
                                'inputan'=>$inputan, 'detail'=>$detail, 'idx'=>$idx, 'idx2'=>$idx2,
                            ), true);
                        }
                    }
                ?>
                
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            Urutan <span class="required">*</span>
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextField($inputan, '['.$idx.']inputan_urutan', array('class'=>'numbers-only span1')); ?>
        </div>
    </div>
    
</div>