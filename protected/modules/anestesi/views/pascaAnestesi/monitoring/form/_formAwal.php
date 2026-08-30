
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Diagnosis Pasca Anastesi</label>
        <div class="controls">
            <?php                 
                echo CHtml::activeHiddenField($model,'pendaftaran_id',array('readonly'=>true,));
                echo CHtml::activeHiddenField($model,'pasienanastesi_id',array('readonly'=>true,));
                echo CHtml::activeHiddenField($model,'pasien_id',array('readonly'=>true,));
                
                echo CHtml::activeHiddenField($model,'diagnosa_id',array('readonly'=>true,));
                
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'diagnosa_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/diagnosa') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                                                                 
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setDiagnosa(ui.item);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogDiagnosa','jsFunction'=>"setDialog('diagnosa',this);"),
                    'htmlOptions'=>array(                    
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'diagnosa_id').'").val("")}',
                        'class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Diagnosa'),
                ));            
            ?>
        </div>                
    </div>
    
    <div class="control-group">
        <label class="control-label">Monitoring Oleh</label>
        <div class="controls">
            <?php                 
                echo CHtml::activeHiddenField($model,'monitoringpeg_id',array('readonly'=>true,));
                
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute' => 'monitoringpeg_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,                                           
                                    ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                                },
                                success: function (data) {
                                    response(data);
                                }
                        })
                     }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            setPetugas(ui.item);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog('pegawai',this);"),
                    'htmlOptions'=>array(                    
                        'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'monitoringpeg_id').'").val("")}',
                        'class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Nama Petugas'),
                ));            
            ?>
        </div>                
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Jam Masuk</label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jam_masuk',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Jam Keluar</label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jam_keluar',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
</div>
        