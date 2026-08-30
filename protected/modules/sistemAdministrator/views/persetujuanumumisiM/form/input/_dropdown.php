<div class="input_base_detail">
    <div class="control-group">
        <label class="control-label">
            Kalimat Sebelum Dropdown
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextArea($inputan, '['.$idx.']kalimatsebelum_inputan'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">
            Jumlah List Dropdown <span class="required">*</span>
        </label>
        <div class="controls">
            <?php echo CHtml::activeTextField($inputan, '['.$idx.']inputan_jumlah', array('class'=>'span1 numbers-only', 'onblur'=>'setInputanDetailDropdown(this);')); ?>
            <div class="dropdown_gen_subinput">
                <?php
                    if (!$inputan->isNewRecord) {
                        $details = PersetujuanumuminputandetM::model()->findAllByAttributes(array(
                            'persetujuanumuminputan_id'=>$inputan->persetujuanumuminputan_id,
                        ), array(
                            'order'=>'urutan asc',
                        ));

                        foreach ($details as $idx2 => $detail) {
                            echo $this->renderPartial('form/input/_dropdown_detail', array(
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
            Kalimat Setelah Dropdown
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