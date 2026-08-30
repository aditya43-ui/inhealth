<div class="col-sm-6">
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'tgl_distribusi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_distribusi',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    // 'maxDate' => 'd',
                    'onClose' => 'js:function(){hitungShift();}',
                ),
                'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tgl_distribusi'); ?>
        </div>
    </div>
    <div class="control-group ">
    <?php echo $form->labelEx($model, 'shift_distribusi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo $form->textField($model, 'shift_distribusi', array(
        'readonly'=>true, 
        'class'=>'span3',
        'onblur'=>'return false;',
        )); ?>
        </div>
    </div>
    
</div>
<div class="col-sm-6">
    <div class="control-group">
    <?php echo CHtml::label("Petugas Distribusi Pelayanan Donor<span class='required'>*</span>", 'petugasdistribusi_id', array(
        'class'=>'control-label',
    )); ?>
        <div class="controls">
        <?php   
            if (!empty($model->petugasdistribusi_id)) {
                $peg = PegawaiM::model()->findByPk($model->petugasdistribusi_id);
                $model->petugasdistribusi_nama = $peg->nama_pegawai;
            } else {
                $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $model->petugasdistribusi_id = $peg->pegawai_id;
                $model->petugasdistribusi_nama = $peg->namaLengkap;
            }    
                
            echo $form->hiddenField($model, 'petugasdistribusi_id', array(
                'class'=>'petugasdistribusi_id required',
            ));
                                
            echo $form->textField($model, 'petugasdistribusi_nama', array(
                'class'=>'required span3', 'readonly' => true
            ));
        ?>
            
        </div>
    </div>
    
    <div class="control-group">
    <?php echo CHtml::label("Koordinator Pelayanan Donor<span class='required'>*</span>", 'petugaskoordinator_id', array(
        'class'=>'control-label',
    )); ?>
        <div class="controls">
        <?php
            echo $form->hiddenField($model, 'petugaskoordinator_id', array(
                'class'=>'petugaskoordinator_id required',
            ));
                
            $petugaskoordinator_nama = "";
                
            // --- kondisi jika ada data-nya
            if (!empty($model->petugaskoordinator_id)) {
                $peg = PegawaiM::model()->findByPk($model->petugaskoordinator_id);
                $petugaskoordinator_nama = $peg->nama_pegawai;
            }    
                
                
                
            // --- end
                
            $this->widget('MyJuiAutoComplete', array(
                    'name'=>'petugaskoordinator_nama',
                    'value'=>$petugaskoordinator_nama,
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('autocompleteKoordinator').'",
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
                                $(this).val(ui.item.nama_pegawai);
                                $(this).parents(".controls").find(".petugaskoordinator_id").val(ui.item.value);
                                $("#petugasdistribusi_nama").blur();
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'disabled'=>false,
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 petugaskoordinator_nama required',
                        'onblur' => 'if(this.value==""){$(".petugaskoordinator_id").val("")}',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKoordinator'),
                ));
        ?>
            
        </div>
    </div>
    
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'ketrangan_distribusi', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'ketrangan_distribusi', array(
            'readonly'=>false, 
            'class'=>'span3 keterangan',
            'onblur'=>'return false;',
            )); ?>
        </div>
    </div>
</div>
<div class="clear"></div>