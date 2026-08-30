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
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']namaperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 required')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']bidangperusahaan',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modPengalamankerja,'['.$i.']jabatanterahkir',array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPengalamankerja,
                                                    'attribute'=>'['.$i.']tglmasuk',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'showOn' => false,
                                                        // 'maxDate' => 'd',
                                                        'onkeyup'=>"js:function(){setLamaKerja(this);}",
                                                        'onSelect'=>'js:function(){setLamaKerja(this);}',
                                                        'yearRange'=> "-150:+0",
                                                    ),
                                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onblur'=>'setLamaKerja(this);'
                                                    ),
                            )); ?>
                        </td>
                        <td>
                            <?php
                            $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPengalamankerja,
                                                    'attribute'=>'['.$i.']tglkeluar',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'showOn' => false,
                                                        'onkeyup'=>"js:function(){setLamaKerja(this);}",
                                                        'onSelect'=>'js:function(){setLamaKerja(this);}',
                                                        // 'maxDate' => 'd',
                                                        'yearRange'=> "-150:+0",
                                                    ),
                                                    'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'onblur'=>'setLamaKerja(this);'
                                                    ),
                            )); ?>
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