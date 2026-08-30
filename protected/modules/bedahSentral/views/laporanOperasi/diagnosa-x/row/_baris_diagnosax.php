<?php
$i = !empty($i)?$i:0;
?>
<tr class="baris">
    <td><label class="nomor"><?= $i+1 ?></label></td>
    <td>
        <?php 
            echo CHtml::activeHiddenField($model, '['.$i.']pasienmorbiditas_id',['class'=>'det_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']diagnosa_id',['class'=>'diagnosa_id']);
            echo CHtml::activeHiddenField($model, '['.$i.']kasusdiagnosa',['class'=>'kasusdiagnosa']);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => "[".$i."]tglmorbiditas",
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'class' => 'dtPicker3 required',
                    'style' => 'width:140px;',
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
        ?>
    </td>
    <td>
        <?php
        echo CHtml::activeTextField($model, "[".$i."]keterangan", array(
            'class' => 'span4 ket-diagnosa required',
        ));
        ?>
    </td>
    <td>
        <?php
        echo CHtml::activeDropDownList($model, "[".$i."]kelompokdiagnosa_id", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosaX(this);'
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
                                        'sourceUrl' => $this->createUrl('/rekamMedis/resumeMedis/getPegawai'),
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ){
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ){
                                                $(this).parents("tr").find(".pegawai_id").val(ui.item.pegawai_id);
                                                $(this).parents("tr").find(".pegawai_nama").val(ui.item.namaLengkap);
                                                alert(ui.item.label);
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
                                                        }else if( $(this).parents("tr").find(".pegawai_id").val() == ""){
                                                            window.parent.myAlert("Pilih dokter sesuai daftar","Perhatian!");
                                                            $(this).val("");
                                                        }',
                                        )
                                    )
                                );
                                echo CHtml::activeHiddenField($model,'['.$i.']pegawai_id',['class'=>'pegawai_id required']);
                                ?>
    </td>
    <td>
        <?php
            $this->widget(
                'MyJuiAutoComplete',
                    array(
                        'model'=>$model,
                        'attribute' => "[".$i."]diagnosa_kode",
                        'sourceUrl' => $this->createUrl('/actionAutoComplete/diagnosa&param=kode'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ){                            
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ){
                                    pilihDiagnosaX(ui.item, this);
                                    return false;
                                }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Kode Diagnosa',
                            'aria-haspopup' => "true",
                            'aria-autocomplete' => 'list',
                            'role' => 'textbox',
                            'autocomplete' => 'off',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span2 ui-autocomplete-input diagnosa_kode'
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
                        'model'=>$model,
                        'attribute' => "[".$i."]diagnosa_nama",
                        'sourceUrl' => $this->createUrl('/actionAutoComplete/diagnosa&param=nama'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ){                            
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ){
                                    pilihDiagnosaX(ui.item, this);
                                    return false;
                                }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Diagnosa Nama',
                            'aria-haspopup' => "true",
                            'aria-autocomplete' => 'list',
                            'role' => 'textbox',
                            'autocomplete' => 'off',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span2 ui-autocomplete-input diagnosa_nama'
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
                        'model'=>$model,
                        'attribute' => "[".$i."]diagnosa_namalainnya",
                        'sourceUrl' => $this->createUrl('/actionAutoComplete/diagnosa&param=nama'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ){                            
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ){
                                    pilihDiagnosaX(ui.item, this);
                                    return false;
                                }',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Diagnosa Nama',
                            'aria-haspopup' => "true",
                            'aria-autocomplete' => 'list',
                            'role' => 'textbox',
                            'autocomplete' => 'off',
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span2 ui-autocomplete-input diagnosa_namalainnya'
                        )
                    )
                );
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeDropDownList($model,"[".$i."]statusdiagnosapasien", LookupM::getItems('statusdiagnosapasien'),
                array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>' required span2 statusdiagnosapasien'
            ));
        ?>
    </td>
    <td style="text-align: center" class="el-aksi">
        <?php
        echo CHtml::link("<i class=icon-form-silang></i><br>Hapus", "javascript:;", array("onclick" => "set_action(this,'hapus');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>