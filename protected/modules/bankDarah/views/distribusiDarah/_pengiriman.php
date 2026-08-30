<div class="col-sm-6">
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'nomor_pengiriman', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_pengiriman', array(
                'readonly'=>true, 
                'class'=>'span3',
                'onblur'=>'return false;',
                )); ?>
            </div>
    </div>
    <div class="control-group">
    <?php echo $form->labelEx($model, 'no_kantongdarah', array(
        'class'=>'control-label',
        'label'=>'No. Kantong Darah'
    )); ?>
        <div class="controls">
        <?php
            $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_kantongdarah',
                    'value'=>"",
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompleteKantongDarah').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           id: listIDTabel(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                     'options'=>array(
                           'showAnim'=>'fold',
                           'minLength' => 3,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                pilihKantongDarah(ui.item.value);
                                $(this).val("");
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'disabled'=>false,
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3',
                        'onblur'=>'cekKantongDarah(this.value, this);',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKantongDarah'),
                ));
        ?>
            
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group ">
        <?php echo CHtml::label("Instalasi","instalasi_nama", array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            
            echo CHtml::textField("instalasi_nama", Yii::app()->user->getState('instalasi_nama'), array(
            'readonly'=>true, 
            'class'=>'span3',
            'onblur'=>'return false;',
            )); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label("Ruangan","ruangan_nama", array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField("ruangan_nama", Yii::app()->user->getState('ruangan_nama'), array(
            'readonly'=>true, 
            'class'=>'span3',
            'onblur'=>'return false;',
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>