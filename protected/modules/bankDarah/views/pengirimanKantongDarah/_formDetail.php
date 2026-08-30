<?php $spasi1 ='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; ?>


<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pengiriman','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modKirimKantong,'no_kirimkantong',array('class'=>'span3','readonly'=>true)); ?>
                <?php //echo $form->hiddenField($modKirimKantong,'kantongdarah_id',array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Coolbox','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php                                                        
                    echo $form->dropDownList($modKirimKantong,'coolboxdarah_id', $modKirimKantong->getDropDownCoolBoxHariIni(),array('class'=>'span3')); 
                ?>
            </div>
        </div>
        <div class="control-group ">
            <label class='control-label'>No. Kantong Utama <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::hiddenField('jeniskantongdarah_id'); ?>
                <?php echo CHtml::hiddenField('komponendarah_id'); ?>
                <?php echo CHtml::hiddenField('kantongdarah_id'); ?>
                <?php echo CHtml::hiddenField('nomorbarcode_utama'); ?>
                
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'nomorbarcode',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                                url: "'.$this->createUrl('AutoCompleteGetKantong').'",
                                dataType: "json",
                                data: {
                                    term: request.term,    
                                    coolboxdarah_id: $("#'.CHtml::activeId($modKirimKantong, 'coolboxdarah_id').'").val()
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                         'options'=>array(
                            'showAnim'=>'fold',
                            'minLength' => 3,
                            'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                            'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                cekSudahAda(ui.item.nomorbarcode_utama,this);
                                return false;
                            }',
                        ),
                        'htmlOptions'=>array(
                            'placeholder' => 'Ketik No. Kantong Utama',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",                            
                            'onblur'=>"cekSudahAda(this.value,this)"
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKantongDarah', 'jsFunction' => 'refreshDialog();setCeklisKantong();$("#dialogKantongDarah").dialog("open");'),
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Asal','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modKirimKantong,'ruangankirim_nama',array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Tujuan<span class="required">*</span>','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modKirimKantong,'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll(" instalasi_id = '".Params::INSTALASI_ID_BANK_DARAH."' AND ruangan_aktif = TRUE ORDER BY ruangan_nama ASC "),'ruangan_id','ruangan_nama'),array('class'=>'span3')); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->renderPartial($this->path_view . '_dialogKantongDarah');
?>
