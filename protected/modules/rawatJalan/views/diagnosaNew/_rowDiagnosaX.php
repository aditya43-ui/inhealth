<?php
    if (count((array)$model) > 0) {
        $i = 0;
        $no = $jumlahtr + 1;
        $x = 1;
        
        // echo '<pre>';print_r($model);die;
        foreach ($model as $i => $val) {
            // if ($val['ruangan_id']==Yii::app()->user->getState('ruangan_id')){
            // if ($val['ruangan_id'] == (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modPendaftaran->ruangan_id)) {

    ?>
            <tr>
                <td class="no_urut"><?php echo $no; ?></td>
                <td>
                    <?php
                    $this->widget(
                        'MyDateTimePicker',
                        array(
                            'name' => "PPPasienMorbiditasT[$no][tglmorbiditas]",
                            'value' => $val->tglmorbiditas,
                            'mode' => 'datetime',
                            'options' => array(
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => 'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        )
                    );
                    echo CHtml::activeHiddenField($model[$i], "[$no]pasienmorbiditas_id");
                    echo CHtml::activeHiddenField($model[$i], "[$no]diagnosa_id", array("class" => "row_diagnosa_x_id"));
                    echo CHtml::activeHiddenField($model[$i], "[$no]create_ruangan");
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
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'onchange' => 'cekKelDianosa(this);'
                        )
                    );
                   
                    ?>
                </td>
                <td>
                    <?php
                    // $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=> $model[$i]->pendaftaran_id));
                    // if(!empty($penunjang)) {
                    //     $model[$i]->pegawai_id = $penunjang->pegawai;
                    // }
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]pegawai_id",
                        CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 pegawai_id_load',
                            'readonly' => false
                        )
                    );
                   
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]ppds_id",
                        CHtml::listData(PpdsM::model()->findAll(), "ppds_id", "ppds_nama"),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => false, 'empty' => '--- Pilih ---'
                        )
                    );
                   
                    ?>
                </td>
                <td>
                    <?php
                    $this->widget(
                        'MyJuiAutoComplete',
                        array(
                            'name' => "PPDiagnosaM[$no][diagnosa_kode]",
                            'sourceUrl' => $this->createUrl('getDiagnosaM&param=kode'),
                            'value' => $model[$i]->diagnosa->diagnosa_kode,
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ){
                                    if (id_diagnosax[ui.item.diagnosa_kode] == undefined){
                                        $(this).val( ui.item.diagnosa_kode);
                                        $(this).parents("tr").find(\'input[name$="[diagnosa_id]"]\').val(ui.item.diagnosa_id);
                                        $(this).parents("tr").find(\'input[name$="[diagnosa_nama]"]\').val(ui.item.diagnosa_nama);
                                        $(this).parents("tr").find(\'input[name$="[diagnosa_namalainnya]"]\').val(ui.item.diagnosa_namalainnya);
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
                                'class' => 'span2 ui-autocomplete-input'
                            )
                        )
                    );
                    echo "Dasar Diagnosa (<span class='required'>*</span>)"."<br>";
                    echo CHtml::activeTextArea($model[$i], "[$no]ket_diagnosa", array('class' => 'span4 custom-only required', 'maxlength' => 200, 'rows' => 3));

                    ?>
                </td>
                <td>
                    <?php
                    $this->widget(
                        'MyJuiAutoComplete',
                        array(
                            'name' => "PPDiagnosaM[$no][diagnosa_nama]",
                            'sourceUrl' => $this->createUrl('getDiagnosaM&param=nama'),
                            'value' => $model[$i]->diagnosa->diagnosa_nama,
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
                            'name' => "PPDiagnosaM[$no][diagnosa_namalainnya]",
                            'sourceUrl' => $this->createUrl('getDiagnosaM&param=lainnya'),
                            'value' => $model[$i]->diagnosa->diagnosa_namalainnya,
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
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]kasusdiagnosa",
                        CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type" => "kasusdiagnosa")), "lookup_value", "lookup_name"),
                        array(
                            'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekKelDianosa(this);'
                        )
                    );
                 
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::activeDropDownList(
                        $model[$i],
                        "[$no]statusdiagnosapasien",
                        LookupM::getItems('statusdiagnosapasien')
                    );
                    
                    ?>
                </td>

                <td style="text-align: center">
                    <?php
                        echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#", array("onclick" => "hapusDiagnosa(this);return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menghapus Diagnosis"));
                    ?>
                </td>
            </tr>
            <script>
                $(document).ready(function() {
                    var ppds = jQuery('#<?php echo CHtml::activeId($model[$i], "[$no]ppds_id") ?>');
                    jQuery(ppds).multiselect({
                        includeSelectAllOption: false,
                        buttonClass: "form-control",
                        maxHeight: 300,
                        buttonWidth: '182px',
                        enableCaseInsensitiveFiltering: true
                    }).hide();

                });
            </script>
    <?php
            $i++;
            $no++;
        }
    }
    ?>
              