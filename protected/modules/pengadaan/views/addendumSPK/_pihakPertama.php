<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pihak Pertama</b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_putusanpenggunaanggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_putusanpenggunaanggaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglputusanpenggunaanggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglputusanpenggunaanggaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'namapembuatkomitmen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pejabatpembuatkomitmen_id', array(
                    'readonly'=>true, 
                    'class'=>'span3 pejabatpembuatkomitmen_id',
                    'onblur'=>'return false;',
                    )); ?>
                    <?php 
                                $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'namapembuatkomitmen',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompletePegawaiPPK').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
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
                                            $(this).val(ui.item.label);
                                            $(this).parents(".controls").find(".pejabatpembuatkomitmen_id").val(ui.item.value);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array(
                                    'disabled'=>false,
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'class'=>'span3 namapembuatkomitmen',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPPK'),
                            ));
                    
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'noindukpegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'noindukpegawai', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'jabatan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jabatan', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'alamat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'alamat', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
