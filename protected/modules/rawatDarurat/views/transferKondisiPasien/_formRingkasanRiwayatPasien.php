<div class="row">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php  echo $form->labelEx($model, 'jamringkas_riwayatpasien', array('class' => 'control-label')) ?>
            <div class="controls">
                  <?php 
                  $this->widget('MyDateTimePicker',array(		                                        
                    'model'=>$model,	
                      'attribute'=>'jamringkas_riwayatpasien',
                        'mode'=>'time',

                        'options'=> array(
                                'showOn' => false,	
                        ),
                        'htmlOptions'=>array(
                    'readonly'=>TRUE,
                    'class'=>'span2',
                    'placeholder'=>'00:00:00',
                    'onkeyup'=>"return $(this).focusNextInputField(event),",
                        ),
                      ));
                  ?>
            </div>
        </div>
        <div class="control-group ">
            <?php  echo CHtml::label('<strong>Anamnesis</strong>', '', array('class' => 'control-label')) ?>
            <label class="control-label"></label>
            <div class="controls">
                
            </div>
        </div>
        <div class="control-group ">
            <?php  echo $form->labelEx($model, 'dokter_keluhanutama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'dokter_keluhanutama', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group ">
             <?php  echo CHtml::label('Riwayat Penyakit', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'riwayatpenyakitterdahulu', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php  echo CHtml::label('Riwayat Alergi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'riwayatalergi', array('class' => 'span3','readonly'=>true, 'style'=>'width:300px; height:100px')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php  echo $form->labelEx($model, 'dokter_keadaanumum', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'dokter_keadaanumum', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php  echo CHtml::label('Pemeriksaan Tanda Vital', '', array('class' => 'control-label')) ?>
            <label class="control-label"></label>
            <div class="controls">
                
            </div>
        </div>
        <div class="control-group">
            <?php  echo CHtml::label('Tensi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ttvdokter_td_systolic', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> / 
                <?php echo $form->textField($model, 'ttvdokter_td_diastolic', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> mmHg
            </div>
        </div>
        <div class="control-group ">
            <?php  echo CHtml::label('Suhu', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ttvdokter_suhutubuh', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> &#176 Celcius
            </div>
        </div>
        <div class="control-group ">
            <?php  echo CHtml::label('Nadi', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ttvdokter_nadi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> x/menit 
            </div>
        </div>
    </div>
</div>