<div class="col-sm-6">
    <?php     
        echo $form->textFieldRow($model,'suratdenda_nomor',array('readonly' => true, 'class' => 'span3'));      
        echo $form->textFieldRow($model,'nomor_dokumen',array('readonly' => true, 'class' => 'span3'));        
    ?>
</div>

<div class="col-sm-6">   
    <div class="control-group">
        <label class="control-label">Tanggal Surat</label>
        <div class="controls">
            <?php 
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'suratdenda_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'termin_ke', array('class'=>'span1','readonly'=>true)); ?>
        </div>
        <label class="control-label" style="width: 35px !important">Dari</label>
        <div class="controls">
            <?php echo $form->textField($model, 'total_termin', array('class'=>'span1','readonly'=>true)); ?>
        </div>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'terminke', array('class'=>'span1','readonly'=>true)); ?>
            <?php echo $form->hiddenField($model, 'termin_persen', array('class'=>'span1','readonly'=>true)); ?>
        </div>
    </div>
</div>

<div class="clear"></div>
<hr>

<div class="col-sm-6">
    <?php
        echo $form->textFieldRow($model,'tanggal_awal',array('readonly' => true, 'class' => 'span3'));         
        echo $form->textFieldRow($model,'tanggal_akhir',array('readonly' => true, 'class' => 'span3'));         
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'ketuapphp_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'ketuapphp_id', array('readonly' => true, 'class' => 'span4'));

            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'ketuapphp_nama',
                'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/ActionAutoComplete/GetPegawaiPPHPdanPjPHP') . '",
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
                            $("#' . Chtml::activeId($model, 'ketuapphp_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'ketuapphp_nama') . '").val(ui.item.nama_pegawai);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'class' => 'span3',
                    'placeholder' => 'Ketik Ketua PPHP/PJPHP',
                    'onblur' => 'if(this.value==""){$("#'.CHtml::activeId($model, 'ketuapphp_id').'").val("");}'
                ),
                'tombolDialog' => array('idDialog' => 'dialogPetugas','jsFunction'=>'setDialog("ketuapphp","dialogPetugas");'),
            ));
            ?>
        </div>
    </div>        
</div>

<div class="col-sm-6">
    <?php
        echo $form->hiddenField($model,'supplier_id',array('readonly'=>true));
        echo $form->textFieldRow($model,'supplier_nama',array('readonly' => true, 'class' => 'span3'));         
        echo $form->textAreaRow($model,'supplier_alamat',array('readonly' => true, 'class' => 'span3'));         
    ?>
</div>

<div class="clear"></div>