<?php
    $i = !empty($i)?$i:99;
?>
<tr class="baris">
    <td class="no_urut">1</td>
    <td id="input_field">
        <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => "[$i]tglpasienicd9cm",
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker2 required',
                    'style' => 'width:140px;',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
                    )
            );
            echo CHtml::activeHiddenField($model,"[$i]pasienicd9cm_id",['class'=>'det_id']);
            echo CHtml::activeHiddenField($model,"[$i]diagnosaicdix_id", array("class"=>"row_diagnosa_ix_id"));			
        ?>
    </td>
    <td>
        <?php echo $form->textField($model, "[$i]keterangan", array(
                                    'class' => 'span4 required'));
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeDropDownList($model,"[$i]kelompokdiagnosa_id", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
            ));
        ?>
    </td>
    <td>
        <?php
           $this->widget(
                'MyJuiAutoComplete',
                array(
                    'model' => $model,
                    'attribute' => '['.$i.']pegawai_nama',
                    'sourceUrl' => $this->createUrl('/actionAutoComplete/getPegawai'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                        'select' => 'js:function( event, ui ){
                            pilihPegawaiIx(ui.item, this);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Dokter',
                        'aria-haspopup' => "true",
                        'aria-autocomplete' => 'list',
                        'role' => 'textbox',
                        'autocomplete' => 'off',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'required span2 ui-autocomplete-input pegawai_nama',
                        'onblur' => 'if (this.value == ""){
                            $(this).parents("tr").find(".pegawai_id").val("");
                        }',
                    )
                )
            );
           echo CHtml::activeHiddenField($model,'['.$i.']pegawai_id',['class'=>'pegawai_id required']);
        ?>
    </td>
    <td>
        <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'model'=>$model,
                    'attribute'=>"[$i]diagnosaicdix_kode",
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
        ?>
    </td>
    <td>
        <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'model'=>$model,
                    'attribute'=>"[$i]diagnosaicdix_nama",
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
                    'model'=>$model,
                    'attribute'=>"[$i]diagnosaicdix_namalainnya",
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
            echo CHtml::link("<i class=icon-form-silang></i><br>Hapus", "javascript:;",array("onclick"=>"set_action(this,'hapus');return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>