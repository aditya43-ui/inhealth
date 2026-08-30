<?php
    $i = (isset($i) ? $i : '');
?>
<tr>
                        
                            <?php //echo $form->hiddenField($model,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($model,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                            <td style="padding-right: 0;">

                                <?php echo $form->textField($model,'['.$i.']nourutperj',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'value'=>$i,'readonly'=>true,'style'=>'width:20px;')); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model,'['.$i.']tujuandinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$i.']tugasdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$i.']descdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$i.']alamattujuan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($model,'['.$i.']propinsi_nama',CHtml::listData(PropinsiM::model()->findAll('propinsi_aktif = true'), 'propinsi_nama', 'propinsi_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'onChange'=>'getKabupaten(this)')); ?>
                                <?php //echo $form->textField($model,'['.$x.']propinsi_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($model,'['.$i.']kotakabupaten_nama',CHtml::listData(KabupatenM::model()->findAll('kabupaten_aktif = true'), 'kabupaten_nama', 'kabupaten_nama'),array('class'=>'span3 kabupaten', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                                <?php //echo $form->textField($model,'['.$x.']kotakabupaten_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$i.']tglmulaidinas',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'showOn' => false,
                                                        // 'maxDate' => 'd',
                                                        'yearRange'=> "-150:+0",
                                                    ),
                                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            </td>
                            <td>
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$i.']sampaidengan',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'showOn' => false,
                                                        // 'maxDate' => 'd',
                                                        'yearRange'=> "-150:+0",
                                                    ),
                                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model,'['.$i.']negaratujuan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                            </td>
                            <?php echo $form->hiddenField($model,'['.$i.']create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$i.']update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$i.']create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$i.']update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$i.']create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </tr>