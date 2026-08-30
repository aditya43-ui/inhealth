<?php 
$tgl = Yii::app()->dateFormatter->formatDateTime($startTimeStamp + $i * 86400,'full',null);
$tglExplode = explode(",",$tgl);
$jadwal_hari = (isset($tglExplode[0])) ? $tglExplode[0] : "";
?>

<table class="table-bordered tableJadwal" style="width:47%;margin:4px;float: left;" id="tabelForm_<?php echo $i; ?>" >
    <thead>
    </thead>
    <tbody>
        <?php
            
            echo "<tr><td style=\"padding-left: 5px; padding-right: 5px;\"><div class='errorTable'></div>";
            echo CHtml::hiddenField("jadwalSlot[jadwal][$i][jadwal_hari]",$jadwal_hari);
            $input = '';
            if (count($modJadwal) > 0){
                $dokter = CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>$poli->ruangan_id)), 'pegawai_id', 'namaLengkap');
                foreach ($modJadwal as $key => $value) {
					
					$input .= '<table width="100%" class="div_'.$i.'_'.$key.' classInline" style="margin-bottom: 10px;>';
					$input .= '<tr><td colspan="6">';
                            CHtml::hiddenField('jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][slotbed_id]', $value->slotbed_id);
					$input .= '</td></tr>';
					$input .= '<tr>';
                    $input .= '<td><div style="display:inline-block;margin-bottom:-7px;" class="input-append required"><input style="float:left" type="text" name="jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwal_mulai]" class="span2 timePickerTest" value="'.$value->jadwal_mulai.'"><span class="add-on"><i class="icon-time"></i></span></div></td>';
                    $input .= '<td>s/d</td>';
                    $input .= '<td><div style="display:inline-block;margin-bottom:-7px;" class="input-append required"><input style="float:left" type="text" name="jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwal_tutup]" class="span2 timePickerTest" value="'.$value->jadwal_tutup.'"><span class="add-on"><i class="icon-time"></i></span></div></td>';
                    $input .= '<td>max</td>';
                    $input .= '<td><input style="display:inline-block;" type="text" name="jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][maximumantrian]" class="span1 numbersOnly" value="'.$value->maximumantrian.'"></td>';
                    $input .= '<td><a href="javascript:void(0)" onclick="removeThis(this)"><i class="icon icon-minus"></i></a></td>';
					$input .= '</tr>';
					$input .= '</table><hr/>';
					
					/*
                    $input .= '<ul class="div_'.$i.'_'.$key.' classInline"><li>'.CHtml::dropDownList('jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]', $value->pegawai_id, $dokter, array('class'=>"inputDokter span3", 'id'=>"jadwalSlot_'.$i.'_'.$poli->ruangan_id.'_'.$key.'", 'style'=>'display:inline-block;')).
                            CHtml::hiddenField('jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][slotbed_id]', $value->slotbed_id).
                            '</li>';
					 * 
					 */
//                    $input .= '<select style="display:inline-block;" name="jadwalSlot[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]" id="jadwalSlot_'.$i.'_'.$poli->ruangan_id.'_'.$key.'" type="text" class="inputDokter span2" ></select>';
                    //$input .= '</ul>';
                }
            }
            echo $input."</div>";
            echo "</td></tr>";
        ?>
    </tbody>
</table>