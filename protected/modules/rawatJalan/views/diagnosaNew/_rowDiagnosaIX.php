<?php
    if (count((array)$model) > 0) {
        $no = $jumlahtr + 1;
        foreach ($model as $i => $val) {
           
    ?>
            <tr>
                <td class="no_urut"><?php echo $no; ?></td>
                <td>
                    <?php
                    
                    $this->widget(
                        'MyDateTimePicker',
                        array(
                            'name' => "Pasienicd9cmT[$no][tglmorbiditas]",
                            'value' => $val->tglmorbiditas,
                            'mode' => 'datetime',
                            'options' => array(
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => 'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        )
                    );
                    

                    echo CHtml::activeHiddenField($model[$i], "[$no]pasienmorbiditas_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]diagnosaicdix_id", array("class" => "row_diagnosa_ix_id"));
                    echo CHtml::activeHiddenField($model[$i], "[$no]pegawai_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]kelompokdiagnosa_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]pasienicd9cm_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]create_ruangan_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]create_loginpemakai_id");
                    ?>
                </td>
                <td>
                    <?php
                    $condition = '';
                    if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RD) {
                        $condition = 'and kelompokdiagnosa_id != 4';
                    }
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]kelompokdiagnosa_id",
                        CHtml::listData(PPKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE " . $condition), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                        )
                    );
                    echo Chtml::error($model[$i], "[$no]kelompokdiagnosa_id");
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]pegawai_id",
                        DokterV::model()->getDropDokterByRuangan(Yii::app()->user->getState('ruangan_id')),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                        )
                    );
                    echo CHtml::error($model[$i], "[$no]pegawai_id");
                    ?>
                </td>
                <td>
                    <?php
                    $this->widget(
                        'MyJuiAutoComplete',
                        array(
                            'name' => "DiagnosaicdixM[$no][diagnosaicdix_kode]",
                            'sourceUrl' => $this->createUrl('getDiagnosaixM&param=kode'),
                            'value' => $model[$i]->diagnosatindakan->diagnosaicdix_kode,
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ){
                                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                        $(this).val( ui.item.diagnosaicdix_kode);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
                                    }else{
                                        myAlert("Diagnosis telah terdaftar, silakan cek kembali!");
                                    }
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Kode Diagnosis',
                                'aria-haspopup' => "true",
                                'aria-autocomplete' => 'list',
                                'role' => 'textbox',
                                'autocomplete' => 'off',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span2 ui-autocomplete-input',
                                
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
                            'name' => "DiagnosaicdixM[$no][diagnosaicdix_nama]",
                            'sourceUrl' => $this->createUrl('getDiagnosaixM&param=nama'),
                            'value' => $model[$i]->diagnosatindakan->diagnosaicdix_nama,
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ){
                                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                        $(this).val( ui.item.diagnosaicdix_nama);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_namalainnya]"]\').val(ui.item.diagnosaicdix_namalainnya);
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
                                'class' => 'span2 ui-autocomplete-input',
                            )
                        )
                    );

                    echo "Dasar Tindakan (<span class='required'>*</span>)"."<br>";
                    echo $form->textArea($model, "[$no]keterangan", array('class' => 'span4 custom-only required', 'maxlength' => 200, 'rows' => 3));
                    ?>
                </td>
                <td>
                    <?php
                    $this->widget(
                        'MyJuiAutoComplete',
                        array(
                            'name' => "DiagnosaicdixM[$no][diagnosaicdix_namalainnya]",
                            'sourceUrl' => $this->createUrl('getDiagnosaixM&param=lainnya'),
                            'value' => $model[$i]->diagnosatindakan->diagnosaicdix_namalainnya,
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ){
                                    if (id_diagnosax[ui.item.diagnosaicdix_kode] == undefined){
                                        $(this).val( ui.item.diagnosaicdix_namalainnya);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_id]"]\').val(ui.item.diagnosaicdix_id);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_kode]"]\').val(ui.item.diagnosaicdix_kode);
                                        $(this).parents("tr").find(\'input[name$="[diagnosaicdix_nama]"]\').val(ui.item.diagnosaicdix_nama);
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
                                'class' => 'span2 ui-autocomplete-input',
                            )
                        )
                    );
                    ?>
                </td>
                <td style="text-align: center">
                    <?php
                        echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "javascript:void(0);", array("onclick" => "hapusDiagnosaix(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
                    ?>
                </td>
            </tr>
        <?php
        }
    }
    ?>