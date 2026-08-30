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
            echo $form->hiddenField($modUraian,"[$i]diagnosaicdix_id");
			echo $form->hiddenField($modUraian,"[$i]pasienicd9cm_id");
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
            if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REHABMEDIS){
                echo $form->dropDownList($modUraian,"[$i]pegawai_id", CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK)), "pegawai_id", "nama_pegawai"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
                ));
            }else{
                echo $form->dropDownList($modUraian,"[$i]pegawai_id", CHtml::listData(PPPegawaiM::model()->findAll(), "pegawai_id", "nama_pegawai"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','onchange'=>'cekKelDianosa(this);'
                ));
            }
        ?>
    </td>
    <td>
        <span  class="diagnosaicdix_kode"></span>
        <?php
            echo chtml::hiddenField('diagnosaicdix_kode_temp');
        ?>
    </td>
    <td class="diagnosaicdix_nama">
    </td>
    <td class="diagnosaicdix_namalainnya">       
    </td>
    <td style="text-align: center">
        <?php
            echo CHtml::link("<i class=icon-remove-sign></i><br>Hapus", "#",array("onclick"=>"hapusDiagnosaix(this);return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Diagnosa"));
        ?>
    </td>
</tr>