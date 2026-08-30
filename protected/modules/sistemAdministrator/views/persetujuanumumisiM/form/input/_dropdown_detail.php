<?php

$detail = $detail ?? new PersetujuanumuminputandetM;
$idx2 = $idx2 ?? "iiii";

?>
<div class="control-group">
    <label class="control-label">
        List Dropdown <span class="required">*</span>
    </label>
    <div class="controls">
        <?php echo CHtml::activeTextField($detail, '['.$idx.'][detail]['.$idx2.']label_inputan'); ?><br/>
    </div>
</div>
