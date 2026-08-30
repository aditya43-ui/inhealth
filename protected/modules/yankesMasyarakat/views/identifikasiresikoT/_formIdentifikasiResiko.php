<div class="row-fluid">

    <div class="col-md-6">
       
        <div class="control-group">
            <?php echo CHtml::label('Sumber Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'sumber_resiko', LookupM::getItems("sumber_riskregister"), array('class'=>'span3 required','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Tipe Manajemen Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
              <?php echo $form->dropDownList($model,'tiperesiko_id', CHtml::listData($model->getTipeResikoItems(), 'tiperesiko_id', 'tiperesiko_nama'), array('class'=>'span3 required',
                  'ajax' => array('type' => 'POST',
                        'dataType'=> "json",
                        'url' => $this->createUrl('/actionDynamic/GetSubTipe', array('encode' => false, 'namaModel' => get_class($model))),
                        'success' => 'function(data){$("#' . CHtml::activeId($model, "subtiperesiko_id") . '").html(data.drop);}',
                    ),
                  'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sub Tipe Manajemen Resiko', '', array('class' => 'control-label ')) ?>
            <div class="controls">
              <?php echo $form->dropDownList($model,'subtiperesiko_id', CHtml::listData(SubtiperesikoM::model()->findAll('subtiperesiko_aktif = TRUE order by subtiperesiko_nama'), 'subtiperesiko_id', 'subtiperesiko_nama'), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Deskripsi Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'deskripsiresiko',array('class'=>'span3 required')); ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <label class="control-label"> Dampak Risiko <span class="required">*</span> </label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'dampakrisiko', LookupM::getItems('dampakrisiko'), array('class' => 'span3 required', 'empty' => '-- Pilih --'))?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penyebab <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'penyebabresiko',array('class'=>'span3 required')); ?>
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