
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Diagnosis Medis</label>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($model, 'diagnosa_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosa_nama',
                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
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
                                                $(this).val(ui.item.diagnosa_nama);
                                                return false;
                                            }',
                        'select' => 'js:function( event, ui ) {
                                                $("#MonitoringPreHdT_diagnosa_id").val(ui.item.diagnosa_id);
                                                return false;
                                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Nama Diagnosa',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                        'onblur' => 'if(this.value === "") $("#MonitoringPreHdT_diagnosa_id").val("");'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nomor_mesin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_mesin', array('class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'gol_darah', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'gol_darah', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div> 

        <div class="control-group">
            <label class="control-label">Kendala Komunikasi</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kendala_komunikasi_tidakada', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_ada') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kendala_komunikasi_ada', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_tidakada') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_keterangan') . '").attr("readonly",false);
                        }else{
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'kendala_komunikasi_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Ada</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($model, 'kendala_komunikasi_keterangan', array('class' => 'span3', 'placeholder' => 'Jelaskan', 'readonly' => true)); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Kondisi Saat ini</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kondisi_saat_ini_tenang', array()); ?> <label>Tenang</label>
            </div>    
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kondisi_saat_ini_gelisah', array()); ?> <label>Gelisah</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kondisi_saat_ini_takut_tindakan', array()); ?> <label>Takut terhadap tindakan</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kondisi_saat_ini_marah', array()); ?> <label>Marah</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'kondisi_saat_ini_tersinggung', array()); ?> <label>Mudah Tersinggung</label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'hemodialisis_ke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'hemodialisis_ke', array('class' => 'span3 numbers-only')); ?>
            </div>
        </div> 
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dialiser', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'dialiser', array('class' => 'span3')); ?>
            </div>
        </div> 

        <div class="control-group">
            <label class="control-label">Riwayat Alergi Obat</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alergi_obat_tidak', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'alergi_obat_ya') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'alergi_obat_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'alergi_obat_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Tidak</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'alergi_obat_ya', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'alergi_obat_tidak') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'alergi_obat_keterangan') . '").attr("readonly",false);
                        }else{
                            $("#' . CHtml::activeId($model, 'alergi_obat_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'alergi_obat_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Ya</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($model, 'alergi_obat_keterangan', array('class' => 'span3', 'placeholder' => 'Jelaskan', 'readonly' => true)); ?>
            </div>
        </div>
       
        <div class="control-group">
            <label class="control-label">HbsAg</label>            
            <div class="controls">
                <?= $form->radioButton($model,'hbsag_ya',['id'=>'hbsag_ya','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hbsag_ya">Reaktif</label></div>
            <div class="controls">
                <?= $form->radioButton($model,'hbsag_tidak',['id'=>'hbsag_tidak','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hbsag_tidak">Non Reaktif</label></div>
        </div>

        <div class="control-group">
            <label class="control-label">Anti HIV</label>            
            <div class="controls">
                <?= $form->radioButton($model,'hiv_ya',['id'=>'hiv_ya','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hiv_ya">Ya</label></div>
            <div class="controls">&nbsp;&nbsp;&nbsp;</div>
            <div class="controls">
                <?= $form->radioButton($model,'hiv_tidak',['id'=>'hiv_tidak','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hiv_tidak">Tidak</label></div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Anti HCV</label>            
            <div class="controls">
                <?= $form->radioButton($model,'hcv_ya',['id'=>'hcv_ya','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hcv_ya">Ya</label></div>
            <div class="controls">&nbsp;&nbsp;&nbsp;</div>
            <div class="controls">
                <?= $form->radioButton($model,'hcv_tidak',['id'=>'hcv_tidak','onclick'=>'salah_satu(this);']) ?> 
            </div>            
            <div class="controls"><label for="hcv_tidak">Tidak</label></div>
        </div>
    </div>
</div>
