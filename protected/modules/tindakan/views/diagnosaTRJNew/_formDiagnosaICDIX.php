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
            echo $form->hiddenField($modUraian,"[$i]diagnosaicdix_id", array("class"=>"row_diagnosa_ix_id"));
			echo $form->hiddenField($modUraian,"[$i]pasienicd9cm_id");
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]kelompokdiagnosa_id", CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
            ));
            echo $form->error($modUraian, "[$i]kelompokdiagnosa_id");
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]pegawai_id", DokterV::model()->getDropDokterByRuangan(),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
            ));
        ?>
    </td>
    <td>
      <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'name'=>"DiagnosaicdixM[$i][diagnosaicdix_kode]",
                    'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=kode'),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 4,
                        'focus'=> 'js:function( event, ui ){
                            if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                $(this).val( ui.item.diagnosaicdix_kode);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
                            }else{
                                myAlert("Diagnosa sudah terdaftar, silakan cek kembali!");
                            }
                            return false;
                        }',
                        'select'=>'js:function( event, ui ){
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>'Kode Diagnosa',
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
            $this->widget('MyJuiAutoComplete',
                array(
                    'name'=>"DiagnosaicdixM[$i][diagnosaicdix_nama]",
                    'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=nama'),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 3,
                        'focus'=> 'js:function( event, ui ){
                            return false;
                        }',
                        'select'=>'js:function( event, ui ){
                            if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                $(this).val( ui.item.diagnosaicdix_nama);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
                            }else{
                                myAlert("Diagnosa sudah terdaftar, silakan cek kembali!");
                            }
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>'Nama Diagnosa',
                        'aria-haspopup'=>"true",
                        'aria-autocomplete'=>'list',
                        'role'=>'textbox',
                        'autocomplete'=>'off',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span2 ui-autocomplete-input'
                    )
                )
            );
        ?>
    </td>
    <td>
      <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'name'=>"DiagnosaicdixM[$i][diagnosaicdix_namalainnya]",
                    'sourceUrl'=> $this->createUrl('getDiagnosaixM&param=lainnya'),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 3,
                        'focus'=> 'js:function( event, ui ){
                            return false;
                        }',
                        'select'=>'js:function( event, ui ){
                            if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                $(this).val( ui.item.diagnosaicdix_namalainnya);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                            }else{
                                myAlert("Diagnosa sudah terdaftar, silakan cek kembali!");
                            }
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'placeholder'=>'Nama Lainnya Diagnosa',
                        'aria-haspopup'=>"true",
                        'aria-autocomplete'=>'list',
                        'role'=>'textbox',
                        'autocomplete'=>'off',
                        'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span2 ui-autocomplete-input'
                    )
                )
            );
        ?>        
    </td>
    <td style="text-align: center">
        <?php
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosaix(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>