<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient" style="border: 1px solid #378d7c;">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    Cairan Keluar
                </div>
            </div>
            <div class="panel-body">
                <hr>
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Urine", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairankeluar_urine', array('disabled' => false, 'class' => 'span4 integer cairankeluar_urine', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("BAB", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairankeluar_bab', array('disabled' => false, 'class' => 'span4 integer cairankeluar_bab', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Drain", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairankeluar_drain', array('disabled' => false, 'class' => 'span4 integer cairankeluar_drain', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Muntah", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairankeluar_muntah', array('disabled' => false, 'class' => 'span4 integer cairankeluar_muntah', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Lain - Lain", ' ', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modBalance, 'cairankeluar_lainnya', array('disabled' => false, 'class' => 'span4 integer cairankeluar_lainnya', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label></label>
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