<div class="panel panel-primary panel-success">
    <div class="panel-heading">
                        <div class="panel-title">Data Penerimaan Darah Kembali / Retur Darah</div>
                    </div> 
    <div class="panel-body">
        <div class="col-sm-6">
             <div class="control-group">
                <label class="control-label">Tanggal Penerimaan Darah Kembali<span class="required">*</span></label>
                <div class="controls">                    
                     <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_retur_darah',
                            'mode' => 'datetime',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 readonly required', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'
                            ),
                        ));
                    ?> 
                </div>                
            </div>
            <div class="control-group">
                <label class="control-label">Asal Darah<span class="required">*</span></label>
                <div class="controls">                    
                      
                </div>                
            </div>
            <div class="control-group">
                <table width="100%">
                    <tr>
                        <td width="22%"><?php echo $form->radioButton($model,'pilih1',array('uncheckValue'=> null,'onchange'=>'ubahPilih1();')); ?> <label>Ruangan</label></td>
                        <td width="10%"></td>
                        <td id="ruangan_tgl_penyerahan" hidden><?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'ruangan_tgl_penyerahan',
                            'mode' => 'datetime',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 readonly', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:150px;'
                            ),
                        ));
                    ?> </td>
                        <td id="ruangan_tgl_penyerahan_text"><?php echo $form->textField($model,'ruangan_tgl_penyerahan_text',array('class' => 'span2','readonly'=>true,'style'=>'margin-bottom:5px;')); ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->radioButton($model,'pilih2',array('uncheckValue'=> null,'onchange'=>'ubahPilih2();')); ?> <label>BDT</label></td>
                        <td width="10%"></td>
                        <td><?php echo $form->textField($model,'bdt_suhucoolbox',array('class' => 'span2 numbers-only','readonly'=>true)); ?>  <label><sup>O</sup>C</label></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->radioButton($model,'pilih3',array('uncheckValue'=> null,'onchange'=>'ubahPilih3();')); ?> <label>ITD</label></td>
                        <td width="10%"></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-sm-6">
             <div class="control-group">
                <label class="control-label">No Penerimaan Darah Kembali<span class="required">*</span></label>
                <div class="controls">                    
                     <?php echo $form->textField($model,'no_retur_darah',array('class' => 'span3','readonly'=>true)); ?> 
                </div>                
            </div>
            <div class="control-group">
                <label class="control-label">Keterangan</label>
                <div class="controls">                    
                     <?php echo $form->textArea($model,'keterangan',array('class' => 'span3 autogrow')); ?> 
                </div>                
            </div>
            <div class="control-group">
                <label class="control-label">Nama Petugas Penerima Darah Kembali<span class="required">*</span></label>
                <div class="controls">                    
                     <?php
                        echo $form->hiddenField($model,'petugas_penerima_id',array('readonly'=>true));
                        echo $form->textField($model,'petugas_penerima_nama',array('readonly'=>true,'class'=>'span3'));
                        /*$this->widget('MyJuiAutoComplete', array(    
                           'model'=>$model,
                           'attribute' => 'petugas_penerima_nama',
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
                                'class'=>'span3 required',
                                'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'petugas_penerima_id') . '").val(""); ',
                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPetugas','idTombol'=>'tombolPengirim'),
                       ));*/
                   ?>
                </div>                
            </div>
        </div>
    </div>
</div>

