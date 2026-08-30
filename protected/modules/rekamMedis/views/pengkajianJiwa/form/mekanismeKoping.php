<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Mekanisme Koping</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'koping_adatif', array('class'=>'control-label')); ?>
                    <div class="controls coping_panel">
                        <?php echo $form->checkBoxList($model, 'koping_adatif', LookupM::getItemsUrutan('askepjiwa_kopingadatif'), array('class'=>'koping_check', 'uncheckValue'=>null)) ?>
                        <?php echo $form->textArea($model, 'koping_adatiflainnya', array('class'=>'span3 koping_adatiflainnya  koping_input', 'rows'=>4)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'koping_maladatif', array('class'=>'control-label')); ?>
                    <div class="controls coping_panel">
                        <?php echo $form->checkBoxList($model, 'koping_maladatif', LookupM::getItemsUrutan('askepjiwa_kopingmaladatif'), array('class'=>'koping_check', 'uncheckValue'=>null)) ?>
                        <?php echo $form->textArea($model, 'koping_malaadatiflainnya', array('class'=>'span3 koping_adatiflainnya  koping_input', 'rows'=>4)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    function sekCeklisKoping() {
        $(".coping_panel").each(function() {
            if ($(this).find(".koping_check[value='Lainnya']").is(":checked")) {
                $(this).find(".koping_input").attr("readonly", false);
            } else {
                $(this).find(".koping_input").attr("readonly", true).val("");
            }
        });
    }
    
    $(document).ready(function() {
        $(".coping_panel .koping_check").on("click", sekCeklisKoping);
        sekCeklisKoping();
    });
    
</script>