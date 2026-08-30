<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset class="box">
    <legend class="rim">Data Pengeluaran</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modBuktiKeluar,'nokaskeluar', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'KUTandabuktikeluarT[nokaskeluar]',
                                            'value'=>$modBuktiKeluar->nokaskeluar,
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.$this->createUrl('infoBayarSupplier').'",
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
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val(ui.item.value);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) {
                                                       isiInfoBayarSupplier(ui.item);
                                                        return false;
                                                    }',
                                            ),
                                        )
                            ); 
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modBuktiKeluar,'tglkaskeluar',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'tahun',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'carabayarkeluar',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'melalubank',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'denganrekening',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modBuktiKeluar,'atasnamarekening',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'namapenerima',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textAreaRow($modBuktiKeluar,'alamatpenerima',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'untukpembayaran',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <?php echo $form->textFieldRow($modBuktiKeluar,'jmlkaskeluar',array('readonly'=>true,'class'=>'integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modBuktiKeluar,'biayaadministrasi',array('readonly'=>true,'class'=>'integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modBuktiKeluar,'keterangan_pengeluaran',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBayarSupplier,'tglbayarkesupplier',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBayarSupplier,'totaltagihan',array('readonly'=>true,'class'=>'integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modBayarSupplier,'jmldibayarkan',array('readonly'=>true,'class'=>'integer span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </table>
</fieldset>

<script type="text/javascript">
function isiInfoBayarSupplier(data)
{
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'tglkaskeluar');?>').val(data.tglkaskeluar);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'tahun');?>').val(data.tahun);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar');?>').val(data.carabayarkeluar);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank');?>').val(data.melalubank);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening');?>').val(data.denganrekening);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening');?>').val(data.atasnamarekening);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'namapenerima');?>').val(data.namapenerima);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'alamatpenerima');?>').val(data.alamatpenerima);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran');?>').val(data.untukpembayaran);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar');?>').val(data.jmlkaskeluar);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi');?>').val(data.biayaadministrasi);
    $('#<?php echo CHtml::activeId($modBuktiKeluar, 'jmldibayarkan');?>').val(data.jmldibayarkan);
    
    $('#<?php echo CHtml::activeId($modBayarSupplier, 'tglbayarkesupplier');?>').val(data.tglbayarkesupplier);
    $('#<?php echo CHtml::activeId($modBayarSupplier, 'totaltagihan');?>').val(data.totaltagihan);
    $('#<?php echo CHtml::activeId($modBayarSupplier, 'jmldibayarkan');?>').val(data.jmldibayarkan);
    $('#<?php echo CHtml::activeId($modBatalBayar, 'tandabuktikeluar_id');?>').val(data.tandabuktikeluar_id);
    $('#<?php echo CHtml::activeId($modBatalBayar, 'bayarkesupplier_id');?>').val(data.bayarkesupplier_id);
    
    $('.currency').each(function(){this.value = formatNumber(this.value)})
}

function cekLogin()
{
    $.post('<?php echo $this->createUrl('CekLogin',array('task'=>'Retur'));?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
            $('#KUBatalBayarSupplierT_user_name_otoritasi').val(data.username);
            $('#KUBatalBayarSupplierT_user_id_otorisasi').val(data.userid);
            $('#loginDialog').dialog('close');
        }else{
            myAlert(data.status);
        }
    }, 'json');
}

function cekOtorisasi()
{
    if($('#KUBatalBayarSupplierT_user_name_otoritasi').val() == '' || $('#KUBatalBayarSupplierT_user_id_otorisasi').val() == ''){
        $('#loginDialog').dialog('open');
        return false;
    } 
    
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    return true;
}
</script>
