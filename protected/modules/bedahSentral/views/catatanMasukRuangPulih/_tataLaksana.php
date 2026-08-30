<div class="control-group">
    <label class="control-label">Penatalaksanaan Nyeri Pasca Bedah</label>
    <div class="controls">
        <div class="checkbox_panel">
            <div class="checkbox">
                <?php echo $form->checkBox($model, 'isdisposableinfuspump', array('class'=>'isdisposableinfuspump checkbox_ceklis', 'uncheckValue'=>0))
                    .$form->labelEx($model, 'isdisposableinfuspump'); ?>
            </div>
            <?php echo $form->textArea($model, 'disposableinfuspump_ket', array('class'=>'span3 checkbox_input', 'rows'=>3)); ?>
            <label>(Dalam 100ml Aqua Steril)</label>
        </div>
        <div class="checkbox_panel">
            <div class="checkbox">
                <?php echo $form->checkBox($model, 'ismelaluicathepidural', array('class'=>'ismelaluicathepidural checkbox_ceklis', 'uncheckValue'=>0))
                    .$form->labelEx($model, 'ismelaluicathepidural'); ?>
            </div>
            <?php echo $form->textArea($model, 'melaluicathepidural_ket', array('class'=>'span3 checkbox_input', 'rows'=>3)); ?>

        </div>
        <div class="checkbox_panel">
            <div class="checkbox">
                <?php echo $form->checkBox($model, 'istatalaksananyerilainnya', array('class'=>'isdisposableinfuspump checkbox_ceklis', 'uncheckValue'=>0))
                    .$form->labelEx($model, 'istatalaksananyerilainnya'); ?>
            </div>
            <?php echo $form->textArea($model, 'istatalaksananyerilainnya_ket', array('class'=>'span3 checkbox_input', 'rows'=>3)); ?>
        </div>
    </div>
</div>

<script>
    
    function cekCeklisInput() {
        $(".checkbox_panel").each(function() {
            var ok = $(this).find(".checkbox_ceklis:checked").length;
            
            if (ok != 0) {
                $(this).find(".checkbox_input").attr("readonly", false);
            } else {
                $(this).find(".checkbox_input").attr("readonly", true).val("");
            }
        });
    }
    
    $(document).ready(function() {
        $(".checkbox_panel .checkbox_ceklis").on('click', cekCeklisInput);
        cekCeklisInput();
    });
    
</script>