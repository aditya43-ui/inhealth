<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai form inputan lainnya seperti tangal pengujian, petugas tombol submit dan lainnya
*/
?>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Waktu Pengujian <span class="required">*</span></label>
        <div class="controls">
            <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpengujian',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 readonly', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'
                    ),
                ));
            ?>
        </div>
    </div>                
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Petugas <span class="required">*</span></label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model,'petugaspengujian_id',array('readonly'=>true));
                        echo $form->textField($model,'petugaspengujian_nama',array('readonly'=>true));

                        /*$this->widget('MyJuiAutoComplete', array(    
                           'model'=>$model,
                           'attribute' => 'petugaspengujian_nama',
                           'value' => '',
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('/actionAutoComplete/dropPetugasRuangan').'",
                                    dataType: "json",
                                        data: {
                                            term: request.term,
                                            ruangan_id: '.Yii::app()->user->getState('ruangan_id').',
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
                                            $(this).val( ui.item.label);
                                            return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                            setPetugas(ui.item.label,ui.item.pegawai_id);
                                            return false;
                                    }',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>false,
                                'placeholder'=>'Nama Petugas',                                
                                'class'=>' required',
                                'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugaspengujian_id') . '").val(""); ',
                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPetugas','idTombol'=>'tombolPengirim'),
                       ));*/
                   ?>
                </div>
            </div>
</div>

