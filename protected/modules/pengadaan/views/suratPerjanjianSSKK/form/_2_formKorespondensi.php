<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label"><b>SATUAN KERJA PPK</b></label>
    </div>
   
    <div class="control-group">
        <label class="control-label">Nama</label>
        <div class="controls">
            <?php echo $form->textField($profilRS,'nama_rumahsakit',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Alamat</label>
        <div class="controls">
            <?php echo $form->textArea($profilRS,'alamatlokasi_rumahsakit',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Telepon</label>
        <div class="controls">
            <?php echo $form->textField($profilRS,'no_telp_profilrs',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Website</label>
        <div class="controls">
            <?php echo $form->textField($profilRS,'website',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Faksimili</label>
        <div class="controls">
            <?php echo $form->textField($profilRS,'no_faksimili',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>        
    
    <div class="control-group">
        <label class="control-label">Email</label>
        <div class="controls">
            <?php echo $form->textField($profilRS,'email',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    
    <?php
        echo $form->hiddenField($model,'pegppk_id',array('readonly'=>true));
        echo $form->textFieldRow($model,'pegppk_nama',array('class' => 'span3', 'readonly' => true));
    ?>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pegpengawas_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegpengawas_id', array('readonly' => true, 'class' => 'span4'));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pegpengawas_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/GetPegawai') . '",
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
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'pegpengawas_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'pegpengawas_nama') . '").val(ui.item.namaLengkap);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'hurufs-only span3',
                    'placeholder' => 'Ketik Pengawas Pekerjaan',
                    'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'pegpengawas_id').'").val("");}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction'=>'setDialog("pengawaspekerjaan","dialogPetugas");'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="col-sm-6">   
    <div class="control-group">
        <label class="control-label"><b>PENYEDIA</b></label>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nama Penyedia</label>
        <div class="controls">
            <?php echo $form->hiddenField($model,'supplier_id',array('readonly'=>true)); ?>
            <?php echo $form->textField($modSup,'supplier_nama',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>   
    
    <div class="control-group">
        <label class="control-label">Alamat</label>
        <div class="controls">
            <?php echo $form->textField($modSup,'supplier_alamat',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>  
    
    <div class="control-group">
        <label class="control-label">Telepon</label>
        <div class="controls">
            <?php echo $form->textField($modSup,'supplier_telp',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Website</label>
        <div class="controls">
            <?php echo $form->textField($modSup,'supplier_website',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Faksimili</label>
        <div class="controls">
            <?php echo $form->textField($modSup,'supplier_fax',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div> 
    
    <div class="control-group">
        <label class="control-label">Email</label>
        <div class="controls">
            <?php echo $form->textField($modSup,'supplier_email',array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div> 
    
    <?php
        echo $form->textFieldRow($model,'wakilpenyedia_nama',array('class' => 'span3'));
    ?>
</div>