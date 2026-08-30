<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Periode Manajemen Resiko ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
               <?php echo $form->dropDownList($model,'perioderiskregister_id',  CHtml::listData($model->getPeriodeResikoItems(), 'perioderiskregister_id', 'nama_perioderiskregister'), 
                           array('empty'=>'-- Pilih --','class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)", 
                                 )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan / Unit Kerja ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
              <?php echo $form->dropDownList($model,'ruangan_id', $model->getRuanganUnitKerjaItems(), array('class'=>'span3 required','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko ', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class'=>'span3 required','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Tipe Manajemen Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'tiperesiko_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('disabled' => true, 'class'=>'span3','empty'=>'-- Pilih --')); ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sub Tipe Manajemen Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'subtiperesiko_id',Chtml::listData(SubtiperesikoM::model()->findAllByAttributes(array('subtiperesiko_aktif'=>true)),'subtiperesiko_id','subtiperesiko_nama'),array('disabled' => true, 'class'=>'span3','empty'=>'-- Pilih --')); ?>

            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Dekripsi Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'deskripsiresiko',array('class'=>'span3')); ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Penyebab Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'penyebabresiko',array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Existing Control', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'existing_control',array('class'=>'span3')); ?>
            </div>
        </div>
    </div>
</div>