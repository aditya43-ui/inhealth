<div class="panel-body">
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'catatan_dipulangkan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Dipulangkan</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'catatan_igd', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>IGD</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'catatan_meninggal', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column cek-meninggal','onclick'=>'cekMeninggal(this);')) ?> <label>Meninggal</label>
                </div>
                <div class="controls">
                     <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'waktu_meninggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => 'span3 waktu_meninggal',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                    ?>   
                </div>
            </div>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'catatan_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'cekCatatan()')) ?> <label>Lainnya</label>&nbsp;                    
                </div>
                <div class="controls">
                    <?= $form->textField($model, 'ket_catatan_lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            
        </div>
    </div>
</div>