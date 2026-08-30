<?php
    $i = (isset($i) ? $i : '');
?>
<tr>
                        
                           
                            <?php //echo $form->hiddenField($model,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                        <td style="padding-right: 0;">
                            
                            <?php echo $form->textField($model,'['.$i.']nourutkel',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, '['.$i.']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'['.$i.']hubkeluarga',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']susunankel_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, '['.$i.']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']susunankel_tempatlahir',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>                 
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'['.$i.']susunankel_tanggallahir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker1',
                                                    ),
                        )); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model,'['.$i.']pekerjaan_nama',CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_nama', 'pekerjaan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model,'['.$i.']pendidikan_nama',CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_nama', 'pendidikan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$i.']susunankel_tanggalpernikahan',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>'yy-mm-dd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,
                                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                          'class'=>'dtPicker1',
                                                        ),
                            )); ?> 
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']susunankel_tempatpernikahan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$i.']susunankeluarga_nip',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>