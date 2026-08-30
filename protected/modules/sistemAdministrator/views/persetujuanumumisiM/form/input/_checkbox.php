<div class="input_base_detail">
    <div class="control-group">
        <label class="control-label">
            Kalimat Sebelum Checkbox
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($inputan, '['.$idx.']kalimatsebelum_inputan'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            Jumlah Checkbox  <span class="required">*</span>
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextField($inputan, '['.$idx.']inputan_jumlah', array('class'=>'span1 numbers-only', 'onblur'=>'setInputanDetailCheckBox(this);')); ?>
            <div class="checkbox_gen_subinput">
                <?php
                    if (!$inputan->isNewRecord) {
                        $details = PersetujuanumuminputandetM::model()->findAllByAttributes(array(
                            'persetujuanumuminputan_id'=>$inputan->persetujuanumuminputan_id,
                        ), array(
                            'order'=>'urutan asc',
                        ));

                        foreach ($details as $idx2 => $detail) {
                            echo $this->renderPartial('form/input/_checkbox_detail', array(
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
            Kalimat Setelah Checkbox
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($inputan, '['.$idx.']kalimatsetelah_inputan'); ?>
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
    <div class="control-group">
        <label class="control-label">
            &nbsp;
        </label>
        <div class="controls input_subinput">
            <?php echo CHtml::activeCheckBox($inputan, '['.$idx.']isada_subinputan', array('onclick'=>'setCeklisSubInput(this);', 'class'=>'isada_subinputan')); ?> <label>Memiliki Sub Inputan (menampilkan Text Area)</label>
            <div class="control-group">
                <label class="control-label">
                    Jumlah Text Area
                </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($inputan, '['.$idx.']subinputan_jumlah', array('class'=>'span1 numbers-only subinputan_jumlah')); ?>
                </div>
            </div>
        </div>
    </div>
</div>