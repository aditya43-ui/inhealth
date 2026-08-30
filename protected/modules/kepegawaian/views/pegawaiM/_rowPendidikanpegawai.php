<?php 
$i = (isset($i) ? $i : '' );
?>
                <tr>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']nourut_pend',array('onkeypress'=>"return $(this).focusNextInputField(event)",'value'=>'','style'=>'width:30px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($modPendidikanpegawai,'['.$i.']pendidikan_id',CHtml::listData($modPendidikanpegawai->getPendidikanItems(),'pendidikan_id','pendidikan_nama'),array('empty'=>'-- Pilih --','style'=>'width:60px;')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']namasek_univ',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','value'=>'')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPendidikanpegawai,'['.$i.']almtsek_univ',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:100px;',)); ?>
                        </td>
                        <td>
                          <?php /* $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPendidikanpegawai,
                                                'attribute'=>'['.$i.']tglmasuk',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker1 hasDatepicker',
                                                                      'value'=>'',
                                                                      //'id'=>'tglmasuk_row',
                                                    ),
                        )); */ ?>
                            <div class="input-append">
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']tglmasuk',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'dtPicker1','id'=>'date-tglmasuk','readonly'=>true)); ?>
                                <span class="add-on">
                                    <i class="entypo-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']lamapendidikan_bln',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','value'=>'','style'=>'width:20px;')).' bulan'; ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']no_ijazah_sert',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','value'=>'')); ?>
                        </td>
                        <td>
                          <?php /* $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPendidikanpegawai,
                                                'attribute'=>'['.$i.']tgl_ijazah_sert',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker1 hasDatepicker',
                                                                      'value'=>'',
//                                                                      'id'=>'tgl_ijazah_sert',
                                                    ),
                        )); */ ?> 
                            <div class="input-append">
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']tgl_ijazah_sert',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'dtPicker1','id'=>'date-tgl_ijazah_sert','readonly'=>true)); ?>
                                <span class="add-on">
                                    <i class="entypo-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']ttd_ijazah_sert',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1','value'=>'')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']nilailulus',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px;','value'=>'')); ?>
                            <?php echo ' / '; ?>
                            <?php echo $form->textField($modPendidikanpegawai,'['.$i.']gradelulus',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px;','value'=>'')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPendidikanpegawai,'['.$i.']keteranganpend',array('onkeypress'=>"",'style'=>'width:50px;','class'=>'keterangan','value'=>'')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahPendidikanpegawai(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusPendidikanpegawai(this);return false;','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>