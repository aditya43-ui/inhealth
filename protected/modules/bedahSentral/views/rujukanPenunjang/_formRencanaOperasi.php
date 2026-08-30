<fieldset>
    <legend class="rim">
        Rencana Operasi
    </legend>
    <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                    <?php echo $form->labelEx($modRencanaOperasi,'tglrencanaoperasi', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modRencanaOperasi,
                                                    'attribute'=>'tglrencanaoperasi',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); ?>
                            <?php echo $form->error($modRencanaOperasi, 'tglrencanaoperasi'); ?>
                    </div>
                    </div>

                    <?php echo $form->textFieldRow($modRencanaOperasi,'norencanaoperasi',array('readonly'=>true)) ?>
                    <?php echo CHtml::hiddenField('kelaspelayanan_id',$modPasienKirimKeunitLain->kelaspelayanan_id,array()); ?>
                    
                    <?php echo $form->dropDownListRow($modPasienKirimKeunitLain,'kelaspelayanan_id', CHtml::listData(BSKelaspelayananM::getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>"getIdKelasPelayanan(this);inputKelasPelayanan();",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetKelasKamarRuangan',array('encode'=>false,'namaModel'=>'PendaftaranT')), 
                                                    'update'=>'#'.CHtml::activeId($modRencanaOperasi,'kamarruangan_id').''  //selector to update
                                                ),)); ?>
                    <?php echo $form->hiddenField($modPasienKirimKeunitLain,'kelaspelayanan_id',array('readonly'=>TRUE,'value'=>$modPasienKirimKeunitLain->kelaspelayanan_id, 'id'=>'idkelaspelayanan'));?>
                    <?php echo $form->dropDownListRow($modRencanaOperasi,'kamarruangan_id', CHtml::listData($modRencanaOperasi->getKamarKosongItems($modPendaftaran->kelaspelayanan_id), 'kamarruangan_id', 'KamarDanTempatTidur'), 
                                                   array('empty'=>'-- Pilih --',
                                                                'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokter Pelaksana','dokter',array('class'=>"control-label")) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modRencanaOperasi,'dokterpelaksana1_id', CHtml::listData($modPendaftaran->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pelaksana 1* --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                            <?php echo $form->dropDownList($modRencanaOperasi,'dokterpelaksana2_id', CHtml::listData($modPendaftaran->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pelaksana 2 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                            <?php echo $form->error($modRencanaOperasi, 'dokterpelaksana1_id'); ?>
                        </div>
                    </div>
                </td>
                <td>
                  <?php echo $form->dropDownListRow($modRencanaOperasi,'dokteranastesi_id', CHtml::listData($modPendaftaran->getDokterItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($modRencanaOperasi,'perawat_id', CHtml::listData($modPendaftaran->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->dropDownListRow($modRencanaOperasi,'statusoperasi', LookupM::getItems('statusoperasi'),  
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                            )); ?>   
                    <?php echo $form->textAreaRow($modRencanaOperasi,'keterangan_rencana',array('class'=>'span3')) ?>                    
                    
                </td>
            </tr>

        </table>
    
    <br>
        
        
       
</fieldset>
<script type="text/javascript">
    function getIdKelasPelayanan(obj)
    {
        var idKelasPelayanan = obj.value;
        document.getElementById('idkelaspelayanan').value = idKelasPelayanan;
        document.getElementById('kelaspelayanan_id').value = idKelasPelayanan;
    }
</script>