<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'species_name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'species_name', array('class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'test_name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'test_name', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Panel/Card Name', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'panel_nama', LookupM::getItems('gram'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'showAST();')); ?>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Generate AST
     * @returns {undefined}
     */
    function showAST() {
        var panel = $("#IdastT_panel_nama").val();
        var id = <?php echo !empty($model->idast_id) ? $model->idast_id : 0 ?>;
        if(panel == ''){
            $("#AST").html("");
        }else{
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('generateAST'); ?>',
                data: {panel: panel, id: id},
                dataType: "json",
                success: function (data) {
                    if (data.sukses == 1) {
                        $("#AST").html(data.html);
                    } else {
                        myAlert(data.pesan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
</script>