<div class="col-sm-6">  
    
    <?= $form->dropDownListRow($model,'pasienkirimkeunitlain_id', $model->dropListPermintaan,['class'=>'pasienkirimkeunitlain_id span4','onchange'=>'loadPermintaan();','empty'=>'-- Pilih --']) ?>
    
    <div class='control-group'>
        <label class="control-label ">Tanggal</label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_asesmenpraanestesi',
                    'mode' => 'datetime',
                    'options' => array(
                        'minDate'=>'d',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(

                        'class' => 'span4',
                        'readonly'=>true
                    ),
                ));
            ?>
        </div>
    </div>        
</div>

<div class="col-sm-6 hide">    
   <div class="control-group ">
        <label class="control-label">Dokter Bedah</label>
        <div class="controls">
            <?php
                echo $form->hiddenField($model, 'dokterbedah_id',['class'=>'dokterbedah_id']);
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'dokterbedah_nama',
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                         }',
                        'select' => 'js:function( event, ui ) { 
                                setPetugasRuangan(ui.item, this,"bedah")
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik nama dokter bedah",
                        'class' => 'span3 dokterbedah_nama',
                        'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($model, 'dokterbedah_id').'").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugasRuangan', 'jsFunction'=>'setDialog("bedah","dialogPetugasRuangan");refreshGridPetugasRuangan("bedah");'),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group ">
        <label class="control-label">Dokter Anestesi</label>
        <div class="controls">
            <?php
                echo $form->hiddenField($model, 'dokteranestesi_id',['class'=>'dokteranestesi_id']);
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'dokteranestesi_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                modul_id: '.Params::MODUL_ID_ANESTESI.'
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                         }',
                        'select' => 'js:function( event, ui ) { 
                                setPetugasRuangan(ui.item, this,"anestesi")
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik nama dokter anestesi",
                        'class' => 'span3 dokteranestesi_nama',
                        'onblur'=>'if(this.value==""){$("#'.CHtml::activeId($model, 'dokteranestesi_id').'").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPetugasRuangan', 'jsFunction'=>'setDialog("anestesi","dialogPetugasRuangan");refreshGridPetugasRuangan("anestesi");'),
                ));
            ?>
        </div>
    </div>
</div>

<div class='clear'></div>
<hr/>