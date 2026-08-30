<br/>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Form Persiapan Ekstubasi Pasien</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            
            <?= $form->textFieldRow($model, 'nama_pasien', ['readonly'=>true]) ?>
            
            <?= $form->hiddenField($model, 'diagnosa_id',['class'=>'required']) ?>
            <?= $form->textFieldRow($model, 'diagnosa_nama', ['readonly'=>true,'class'=>'required']) ?>
            
            <div class="control-group">
                <label class="control-label">Hari/Tanggal Pemantauan</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_tindakan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="contol-group">
                <label class="control-label">Dokter Jaga</label>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'dokterjaga_id', ['class'=>'dokterjaga_id']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'dokterjaga_nama',                            
                            'sourceUrl' => $this->createUrl('/actionAutoComplete/dropPetugasRuangan',['kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, 'ruangan_id'=>[46, 23, 20, 26] ]),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {                                   
                                    $(this).val(ui.item.namaLengkap);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    setPetugas(ui.item,this,"dokter-jaga");
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onblur' => 'if(this.value == ""){$(".dokterjaga_id").val("");}',
                                'readonly' => false,
                                'placeholder' => 'Nama dokter jaga',                                
                                'class' => 'dokterjaga_nama span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction' => 'setDialog("dialogPetugas","dokter-jaga");refreshGridPetugas("dokter-jaga");'), 
                        ));
                    ?>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
            <?= $form->hiddenField($model, 'dpjp_id',['class'=>'required']) ?>
            <?= $form->textFieldRow($model, 'dpjp_nama', ['readonly'=>true, 'class'=>'required']) ?>
            
            <div class="control-group">
                <?= $form->labelEx($model, 'dokteranestesi_id', ['class'=>'control-label']) ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'dokteranestesi_id', ['class'=>'dokteranestesi_id required']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'dokteranestesi_nama',                            
                            'sourceUrl' => $this->createUrl('/actionAutoComplete/dropPetugasRuangan',['kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, 'ruangan_id'=>[46, 23, 20, 26] ]),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {                                   
                                    $(this).val(ui.item.namaLengkap);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    setPetugas(ui.item,this,"dokter-anestesi");
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onblur' => 'if(this.value == ""){$(".dokteranestesi_id").val("");}',
                                'readonly' => false,
                                'placeholder' => 'Ketik Dr. Anestesi',                                
                                'class' => 'dokteranestesi_nama span3 required',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction' => 'setDialog("dialogPetugas","dokter-anestesi");refreshGridPetugas("dokter-anestesi");'), 
                        ));
                    ?>
                </div>
            </div>
            
            <div class="contol-group">
                <?= $form->labelEx($model, 'perawatjaga_id', ['class'=>'control-label']) ?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'perawatjaga_id', ['class'=>'perawatjaga_id required']);
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'perawatjaga_nama',                            
                            'sourceUrl' => $this->createUrl('/actionAutoComplete/dropPetugasRuangan',['ruangan_id'=>[46, 23, 20, 26] ]),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {                                   
                                    $(this).val(ui.item.namaLengkap);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    setPetugas(ui.item,this,"perawat-jaga");
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onblur' => 'if(this.value == ""){$(".perawatjaga_id").val("");}',
                                'readonly' => false,
                                'placeholder' => 'Ketik Perawat Jaga',                                
                                'class' => 'perawatjaga_nama span3 required',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction' => 'setDialog("dialogPetugas","perawat-jaga");refreshGridPetugas("perawat-jaga");'), 
                        ));
                    ?>
                </div>
            </div>
            
        </div>                
    </div>
</div>