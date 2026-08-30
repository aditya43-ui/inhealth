<?php 
$tgl = Yii::app()->dateFormatter->formatDateTime($startTimeStamp + $i * 86400,'full',null);
$jadwaldokter_tgl = date('Y-m-d',$startTimeStamp + $i * 86400);
$tglExplode = explode(",",$tgl);
$jadwaldokter_hari = (isset($tglExplode[0])) ? $tglExplode[0] : "";
?>

<table class="table-bordered tableJadwal" style="width:47%;margin:4px;float: left;" id="tabelForm_<?php echo $i; ?>" >
    <thead>
        <tr>
            <th><?php echo $tgl; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        //echo CHtml::checkBoxList("inputPoli[$i]", CHtml::listData($poliklinik, 'ruangan_id', 'ruangan_id'), CHtml::listData($poliklinik, 'ruangan_id', 'ruangan_nama'), array('uncheckValue'=>''));
        foreach($poliklinik as $j=>$poli){
            $modJadwal = JadwaldokterM::model()->findAllByAttributes(array('jadwaldokter_tgl'=>$jadwaldokter_tgl, 'ruangan_id'=>$poli->ruangan_id));
            
            echo "<tr><td style=\"padding-left: 5px; padding-right: 5px;\"><div class='errorTable'></div>";
            echo CHtml::checkBox("jadwalDokter[jadwal][$i][dokter][$poli->ruangan_id][cek]", true);
            echo CHtml::hiddenField("jadwalDokter[jadwal][$i][dokter][$poli->ruangan_id][ruangan_id]",$poli->ruangan_id);
            echo CHtml::hiddenField("jadwalDokter[jadwal][$i][jadwaldokter_tgl]",$jadwaldokter_tgl);
            echo CHtml::hiddenField("jadwalDokter[jadwal][$i][jadwaldokter_hari]",$jadwaldokter_hari);
            echo ' '.CHtml::label($poli->ruangan_nama, "jadwalPoli_".$i."_".$j).' ';
            echo CHtml::link('<i class="icon icon-plus"></i>', 'javascript:void(0)', array('onclick'=>"insertInputDokter(".$i.", ".$poli->ruangan_id.",this)"));
            echo "<div id='div_".$i."_".$poli->ruangan_id."'>";
            $input = '';
            if (count($modJadwal) > 0){
                $dokter = CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>$poli->ruangan_id)), 'pegawai_id', 'namaLengkap');
                foreach ($modJadwal as $key => $value) {
					
					$input .= '<table width="100%" class="div_'.$i.'_'.$key.' classInline" style="margin-bottom: 10px;>';
					$input .= '<tr><td colspan="6">';
					$input .= CHtml::dropDownList('jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]', $value->pegawai_id, $dokter, array('class'=>"inputDokter span3", 'id'=>"jadwalDokter_'.$i.'_'.$poli->ruangan_id.'_'.$key.'", 'style'=>'display:inline-block;')).
                            CHtml::hiddenField('jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwaldokter_id]', $value->jadwaldokter_id);
					$input .= '</td></tr>';
					$input .= '<tr>';
                    $input .= '<td><div style="display:inline-block;margin-bottom:-7px;" class="input-append required"><input style="float:left" type="text" name="jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwaldokter_mulai]" class="span2 timePickerTest" value="'.$value->jadwaldokter_mulai.'"><span class="add-on"><i class="icon-time"></i></span></div></td>';
                    $input .= '<td>s/d</td>';
                    $input .= '<td><div style="display:inline-block;margin-bottom:-7px;" class="input-append required"><input style="float:left" type="text" name="jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwaldokter_tutup]" class="span2 timePickerTest" value="'.$value->jadwaldokter_tutup.'"><span class="add-on"><i class="icon-time"></i></span></div></td>';
                    $input .= '<td>max</td>';
                    $input .= '<td><input style="display:inline-block;" type="text" name="jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][maximumantrian]" class="span1 numbersOnly" value="'.$value->maximumantrian.'"></td>';
                    $input .= '<td><a href="javascript:void(0)" onclick="removeThis(this)"><i class="icon icon-minus"></i></a></td>';
					$input .= '</tr>';
					$input .= '</table><hr/>';
					
					/*
                    $input .= '<ul class="div_'.$i.'_'.$key.' classInline"><li>'.CHtml::dropDownList('jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]', $value->pegawai_id, $dokter, array('class'=>"inputDokter span3", 'id'=>"jadwalDokter_'.$i.'_'.$poli->ruangan_id.'_'.$key.'", 'style'=>'display:inline-block;')).
                            CHtml::hiddenField('jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][jadwaldokter_id]', $value->jadwaldokter_id).
                            '</li>';
					 * 
					 */
//                    $input .= '<select style="display:inline-block;" name="jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]" id="jadwalDokter_'.$i.'_'.$poli->ruangan_id.'_'.$key.'" type="text" class="inputDokter span2" ></select>';
                    //$input .= '</ul>';
                }
            }
            echo $input."</div>";
            echo "</td></tr>";
        }
        ?>
    </tbody>
</table>