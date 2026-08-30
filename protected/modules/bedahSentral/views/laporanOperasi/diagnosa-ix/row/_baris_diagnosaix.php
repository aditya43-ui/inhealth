<?php
$i = !empty($i)?$i:0;
?>
<tr class="baris">
    <td><label class="nomor"><?= $i+1 ?></label></td>
    <td id="input_field">
        <?php
        $this->widget(
            'MyDateTimePicker',
            array(
                'model' => $model,
                'attribute' => "[".$i."]tglpasienicd9cm",
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
        echo CHtml::activeHiddenField($model, "[".$i."]pasienmorbiditas_id");
        echo CHtml::activeHiddenField($model, "[".$i."]diagnosaicdix_id", array("class" => "diagnosaicdix_id"));
        echo CHtml::activeHiddenField($model, "[".$i."]pasienicd9cm_id",['class'=>'det_id']);
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($model, "[$i]keterangan", array(
                                    'class' => 'span4 ket-diagnosaix required',));
                                ?>
    </td>
    <td>
        <?php
        echo CHtml::activeDropDownList(
            $model,
            "[".$i."]kelompokdiagnosa_id",
            $dropKelompok,
            array(
                'onkeypress' => "return $(this).focusNextInputField(event)", 
                'class' => 'span2',
                'onchange' => 'cekKelDianosaIx(this)'
            )
        );
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
        $this->widget(
            'MyJuiAutoComplete',
            array(
                'model'=>$model,
                'attribute' => "[".$i."]diagnosaicdix_kode",
                'sourceUrl' => $this->createUrl('/actionAutoComplete/getDiagnosaixM&param=kode'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ){                            
                            return false;
                        }',
                    'select' => 'js:function( event, ui ){
                            pilihDiagnosaIx(ui.item, this);
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
                    'class' => 'span2 ui-autocomplete-input diagnosaicdix_kode'
                )
            )
        );
        echo chtml::hiddenField('diagnosaicdix_kode_temp');
        ?>
    </td>
    <td>
        <?php
        $this->widget(
            'MyJuiAutoComplete',
            array(
                'model'=>$model,
                'attribute' => "[".$i."]diagnosaicdix_nama",
                'sourceUrl' => $this->createUrl('/actionAutoComplete/getDiagnosaixM&param=nama'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                    'select' => 'js:function( event, ui ){
                            pilihDiagnosaIx(ui.item, this);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Diagnosa',
                    'aria-haspopup' => "true",
                    'aria-autocomplete' => 'list',
                    'role' => 'textbox',
                    'autocomplete' => 'off',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span2 ui-autocomplete-input diagnosaicdix_nama'
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
                'attribute' => "[".$i."]diagnosaicdix_namalainnya",
                'sourceUrl' => $this->createUrl('/actionAutoComplete/getDiagnosaixM&param=lainnya'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                    'select' => 'js:function( event, ui ){
                            pilihDiagnosaIx(ui.item, this);
                            return false;
                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Nama Lainnya Diagnosa',
                    'aria-haspopup' => "true",
                    'aria-autocomplete' => 'list',
                    'role' => 'textbox',
                    'autocomplete' => 'off',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span2 ui-autocomplete-input diagnosaicdix_namalainnya'
                )
            )
        );
        ?>
    </td>
    <td style="text-align: center" class="el-aksi">
        <?php
        echo CHtml::link("<i class=icon-form-silang></i><br>Hapus", "javascript:;", array("onclick" => "set_action(this,'hapus');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>