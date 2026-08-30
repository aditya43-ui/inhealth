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
           // echo $form->hiddenField($modUraian,"[$i]kasusdiagnosa");
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
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true,'class'=>'span2'
            ));
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]ppds_id", CHtml::listData(PpdsM::model()->findAll(), "ppds_id", "ppds_nama"),
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
            echo "Keterangan Diagnosa"."<br>";
            echo $form->textArea($modUraian, "[$i]ket_diagnosa", array('class' => 'span4 custom-only', 'maxlength' => 200, 'rows' => 3));
       
        ?>
    </td>
    <td>
        <?php
        $this->widget(
            'MyJuiAutoComplete',
            array(
                'name' => "PPDiagnosaM[$i][diagnosa_nama]",
                'sourceUrl' => $this->createUrl('getDiagnosaM&param=nama'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ){
                        return false;
                    }',
                    'select' => 'js:function( event, ui ){
                        if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                            $(this).val( ui.item.diagnosa_nama);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
                        }else{
                            myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                        }
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Diagnosis',
                    'aria-haspopup' => "true",
                    'aria-autocomplete' => 'list',
                    'role' => 'textbox',
                    'autocomplete' => 'off',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span2 ui-autocomplete-input'
                )
            )
        );
        ?>
    </td>
    <td>
        <?php
        $this->widget(
            'MyJuiAutoComplete',
            array(
                'name' => "PPDiagnosaM[$i][diagnosa_namalainnya]",
                'sourceUrl' => $this->createUrl('getDiagnosaM&param=lainnya'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ){
                        return false;
                    }',
                    'select' => 'js:function( event, ui ){
                        if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                            $(this).val( ui.item.diagnosa_namalainnya);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_kode]"]\').val(ui.item.diagnosa_kode);
                            $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
                        }else{
                            myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                        }
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Lainnya Diagnosis',
                    'aria-haspopup' => "true",
                    'aria-autocomplete' => 'list',
                    'role' => 'textbox',
                    'autocomplete' => 'off',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span2 ui-autocomplete-input'
                )
            )
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
    <!-- <td>
      <?php
            // echo $form->dropDownList($modUraian,"[$i]kasusdiagnosa",CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"),array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
            // ));
        ?>      
    </td>
     -->
    <td style="text-align: center">
        <?php
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosa(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>