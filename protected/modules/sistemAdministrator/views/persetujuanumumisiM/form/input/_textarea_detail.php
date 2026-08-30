<?php

$detail = $detail ?? new PersetujuanumuminputandetM;
$idx2 = $idx2 ?? "iiii";

?>
<div style="border: 1px solid black; margin-bottom: 5px; margin-top: 5px; padding: 5px;">
    
<div class="control-group">
    <label class="control-label">
        Kalimat Sebelum Textarea
    </label>
    <div class="controls">
        <?php echo CHtml::activeTextArea($detail, '['.$idx.'][detail]['.$idx2.']informasisebelum_inputan'); ?><br/>
    </div>
</div>
<div class="control-group">
    <label class="control-label">
        Kalimat Sesudah Textarea
    </label>
    <div class="controls">
        <?php echo CHtml::activeTextArea($detail, '['.$idx.'][detail]['.$idx2.']informasisesudah_inputan'); ?><br/>
    </div>
</div>
</div>