<?php 
    $i = (isset($i) ? $i : '' );
    $no = '';
?>
                      <tr>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']pengalamankerja_nourut',array('style'=>'width:20px;','value'=>$no)) ?>
                            <?php echo $form->hiddenField($modPengalamankerja,'['.$i.']pengalamankerja_id'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']namaperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']bidangperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']jabatanterahkir',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                        </td>
                        <td>
                            <div class="input-append">
                              <?php echo $form->textField($modPengalamankerja,'['.$i.']tglmasuk',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'dtPicker1','id'=>'date-tglmasuk','readonly'=>true)); ?>
                                <span class="add-on">
                                    <i class="entypo-calendar"></i>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="input-append">
                              <?php echo $form->textField($modPengalamankerja,'['.$i.']tglkeluar',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'dtPicker1','id'=>'date-tglkeluar','readonly'=>true)); ?>
                                <span class="add-on">
                                    <i class="entypo-calendar"></i>
                                </span>
                            </div> 
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']lama_tahun',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px',)).' thn'; ?>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']lama_bulan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:20px',)).' bln'; ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPengalamankerja,'['.$i.']alasanberhenti',array('onkeypress'=>"(this)",'style'=>'width:50px;')); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($modPengalamankerja,'['.$i.']keterangan',array('onkeypress'=>"(this)",'style'=>'width:50px;','class'=>'keterangan')); ?>
                        </td>
                        <td style="width:50px;">
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahPengalamankerja(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusPengalamankerja(this);return false','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>