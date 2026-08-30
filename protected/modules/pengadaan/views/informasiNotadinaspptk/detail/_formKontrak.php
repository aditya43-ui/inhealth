<div class="col-md-6">
    <div class="control-group">
        <label class="control-label"> Nomor Kontrak </label>
        <div class="controls">
            <?php echo $form->textField($model, 'kontrak_nomor', array('class' => 'span3 kontrak_nomor', 'readonly' => true)) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Tanggal Kontrak </label>
        <div class="controls">
            <?php echo $form->textField($model, 'kontrak_tanggal', array('class' => 'span3 kontrak_tanggal', 'readonly' => true)) ?>
        </div>
    </div>
    <?php if(!empty($model->termin)) : ?>
    <div class="control-group">
        <label class="control-label"> Termin </label>
        <div class="controls">
            <?php echo $form->textField($model, 'termin', array('class' => 'span3')); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="col-md-6">
    <div class="control-group">
        <label class="control-label"> Nama Penyedia</label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'span3 supplier_id', 'readonly' => true)) ?>
            <?php echo $form->textField($model, 'supplier_nama', array('class' => 'span3 supplier_nama', 'readonly' => true)) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Alamat </label>
        <div class="controls">
            <?php echo $form->textArea($model, 'supplier_alamat', array('class' => 'span3 supplier_alamat', 'readonly' => true)) ?>
        </div>
    </div>
</div>