<?php

$detail = $detail ?? new PersetujuanumuminputandetM;
$idx2 = $idx2 ?? "iiii";

?>

<div class="control-group">
    <label class="control-label">
        Label Radio Button <span class="required">*</span>
    </label>
    <div class="controls">
        <?php echo CHtml::activeTextArea($detail, '['.$idx.'][detail]['.$idx2.']label_inputan'); ?><br/>
    </div>
</div>
<div class="control-group">
    <label class="control-label">&nbsp;</label>
    <div class="controls">
        <?php echo CHtml::activeCheckBox($detail, '['.$idx.'][detail]['.$idx2.']ismemilikisubinputan'); ?> <label>Memiliki Inputan Textfield</label>
    </div>
</div>