<?php
    $i = 99;
?>
<tr>
    <td class="no_urut">1</td>
    <td id="input_field">
        <?php
            $this->widget('MyDateTimePicker',
                array(
                    'model'=>$modUraian,
                    'attribute'=>"[$i]tglmorbiditas",
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                        'value'=>date("Y-m-d H:i:s"),
                        'class'=>'dtPicker2',
                        'onkeypress'=>"return $(this).focusNextInputField(event)"
                    ),
                )
            );
            echo $form->hiddenField($modUraian,"[$i]pasienmorbiditas_id");
            echo $form->hiddenField($modUraian,"[$i]diagnosa_id", array("class"=>"row_diagnosa_x_id"));
            echo $form->hiddenField($modUraian,"[$i]kasusdiagnosa");
            echo "Keterangan Diagnosa"."<br>";
            echo $form->textArea($modUraian, "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3));
                                
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]kelompokdiagnosa_id", CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
            ));
            echo $form->error($modUraian, "[$i]kelompokdiagnosa_id");
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]pegawai_id", CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
            ));
        ?>
    </td>
    <td>
      <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'name'=>"PPDiagnosaM[$i][diagnosa_kode]",
                    'sourceUrl'=> $this->createUrl('getDiagnosaM&param=kode'),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 4,
                        'focus'=> 'js:function( event, ui ){
                            return false;
                        }',
                        'select'=>'js:function( event, ui ){
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>'Kode Diagnosis',
                        'aria-haspopup'=>"true",
                        'aria-autocomplete'=>'list',
                        'role'=>'textbox',
                        'autocomplete'=>'off',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span2 ui-autocomplete-input'
                    )
                )
            );
            echo chtml::hiddenField('diagnosaicdix_kode_temp');
        ?>
    </td>
    <td>
      <?php
            echo CHtml::textField("PPDiagnosaM[$i][diagnosa_nama]","",
                array('readonly'=>true,'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")
            );
        ?>
    </td>
    <td>
      <?php
            echo CHtml::textField("PPDiagnosaM[$i][diagnosa_namalainnya]","",
                array('readonly'=>true,'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")
            );
        ?>        
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]statusdiagnosapasien", LookupM::getItems('statusdiagnosapasien'),
                array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 required'
            ));
        ?>
    </td>
    <td hidden>
        <?php //echo $form->textField($modUraian, "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3)); ?>
    </td>
    <td style="text-align: center">
        <?php
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosa(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>