<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"> 
            <b> Data ID/AST</b> 
        </div>
        <span style="float:right; padding: 10px">
            <?php
            if(!empty($model2->idast_id)){
                echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'hapusPanel();return false;')); 
            }else{
                echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'hidePanel();return false;')); 
            }
            ?>
        </span>
    </div>
    <div class="panel-body">
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Identification</span></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Species Name</label>
                            <div class="controls">
                                <?php echo Chtml::activeTextField($model2, 'species_name', array('class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Test Name</label>
                            <div class="controls">
                                <?php echo Chtml::activeTextField($model2, 'test_name', array('class' => 'span3')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Panel/Card Name', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo Chtml::activeDropDownList($model2, 'panel_nama', LookupM::getItems('gram'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'showAST2();')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><span class='judul'>Antibiotic Susceptibility Test</span></div>
            </div>
            <div class="panel-body">
                <table id="AST2" width="80%" style="margin-left: 110px">

                </table>
                <br>
                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?php echo Chtml::activeTextArea($model2, 'keterangan', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * Generate AST
     * @returns {undefined}
     */
    function showAST2() {
        var panel = $("#MKIdastT_panel_nama").val();
        var id = <?php echo!empty($model2->idast_id) ? $model2->idast_id : 0 ?>;
        if(panel == ''){
            $("#AST2").html("");
        }else{
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('generateAST2'); ?>',
                data: {panel: panel, id: id},
                dataType: "json",
                success: function (data) {
                    if (data.sukses == 1) {
                        $("#AST2").html(data.html);
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