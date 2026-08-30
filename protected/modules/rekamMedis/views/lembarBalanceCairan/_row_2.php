<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient" style="border: 1px solid #378d7c;">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    Cairan Masuk
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Infus", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairanmasuk_infus', array('disabled' => false, 'class' => 'span4 integer cairanmasuk_infus', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> cc </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Transfusi", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairanmasuk_transfusi', array('disabled' => false, 'class' => 'span4 integer cairanmasuk_transfusi', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> cc </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Oral", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairanmasuk_oral', array('disabled' => false, 'class' => 'span4 integer cairanmasuk_oral', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> cc </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>    
    $(document).ready(function () {
        <?php if(isset($_GET['jenis'])){ ?>
            <?php if($_GET['jenis'] == 'lihat'){ ?>
            $("input, select, textarea").attr("disabled",true); 
            <?php } ?>
        <?php } ?>
    });
</script>