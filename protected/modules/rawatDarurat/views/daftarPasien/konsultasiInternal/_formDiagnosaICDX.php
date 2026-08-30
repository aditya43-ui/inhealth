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
                        'value'=>MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s")),
                        'class'=>'dtPicker2',
                        'onkeypress'=>"return $(this).focusNextInputField(event)"
                    ),
                )
            );
            echo $form->hiddenField($modUraian,"[$i]pasienmorbiditas_id");
            echo $form->hiddenField($modUraian,"[$i]diagnosa_id", array('class'=>'inp_diagnosa_id'));
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]kelompokdiagnosa_id", CHtml::listData(KelompokdiagnosaM::model()->findAll("kelompokdiagnosa_aktif = TRUE"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
            ));
            echo $form->error($modUraian, "[$i]kelompokdiagnosa_id");
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]kasusdiagnosa", CHtml::listData(LookupM::model()->findAllByAttributes(array("lookup_type"=>"kasusdiagnosa")), "lookup_value","lookup_name"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
            ));
        ?>
    </td>
    <td>
        <?php
            echo $form->dropDownList($modUraian,"[$i]pegawai_id", CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ), array('order' => 'nama_pegawai')), "pegawai_id", "namaLengkap"),
                array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2 required pgdiagnosa', 'empty' => '-- Pilih --'
            ));
        ?>
    </td>
    <td>
        <span id="<?php echo "PPDiagnosaM_".$i."_diagnosa_kode"; ?>" class="diagnosa_kode"></span>
        <?php echo chtml::hiddenField('diagnosaicdix_kode_temp'); ?>
    </td>
    <td id="<?php echo "PPDiagnosaM_".$i."_diagnosa_nama"; ?>" class="diagnosa_nama">
    </td>
    <td id="<?php echo "PPDiagnosaM_".$i."_diagnosa_namalainnya"; ?>"  class="diagnosa_namalainnya">      
    </td>
    <td style="text-align: center">
        <?php
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosa(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>