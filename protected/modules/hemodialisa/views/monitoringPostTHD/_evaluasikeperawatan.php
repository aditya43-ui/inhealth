<div class="panel-body">
    <div class="row-fluid">
        <div class="span12">
            
            <?= $this->renderPartial($this->path_view . 'form/_keluhan',['model'=>$model, 'form'=>$form], true) ?>
            
            <div class="control-group">
                <label class="control-label">Pemeriksaan Fisik</label>
                <div class="controls"></div>
            </div>
            <di v class="control-group">
                <label class="control-label">Berat Badan</label>
                <div class="controls">
                    <?= $form->textField($model, 'berat_badan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 integer')); ?> <label>Kg</label>
                </div>
                <div class="controls">
                <?php echo $form->checkBox($model, 'tidaktimbang', array()); ?>
                <label for="HDMonitoringPostHdT_tidaktimbang">Pasien tidak timbang </label>
            </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?= $form->textField($model, 'tensi_sistolik', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 integer')); ?> / <?= $form->textField($model, 'tensi_diastolik', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 integer')); ?> <label>mmHg</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?= $form->textField($model, 'nadi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 integer')); ?> <label>x/mnt</label> &nbsp;
                    <?php echo $form->checkBox($model, 'nadi_reguler', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Reguler</label>
                    <?php echo $form->checkBox($model, 'nadi_irreguler', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column')) ?> <label>Irreguler</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Respirasi</label>
                <div class="controls">
                    <?= $form->textField($model, 'respirasi', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 integer')); ?> <label>x/mnt</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?= $form->textField($model, 'suhu', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 float')); ?> <label>&#8451;</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Lain-lain</label>
                <div class="controls">
                    <?= $form->textArea($model, 'lainnya', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'style' => 'width: 241px; height: 101px;')); ?>
                </div>
            </div>
        </div>
    </div>
</div>