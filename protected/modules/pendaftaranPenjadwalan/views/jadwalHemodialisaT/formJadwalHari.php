<?php 

$namaHari = MyFormatter::getDayUser($hari[$i]);
$tglsaatHari = date("Y-m-d");
for($d=0; $d<=6; $d++){
	$getDateHari = mktime (0,0,0, date("m"), date("d")+$d,date("Y"));
	if($namaHari ==  MyFormatter::getDayName(date('Y-m-d', $getDateHari))){
		$tglsaatHari = date('Y-m-d', $getDateHari);
	}
}

$shifM = ShiftM::model()->findByAttributes(array('shift_id'=>$shift[$j]));
?>
<div class="col-sm-6"style="margin-left:30px;">
<?php
if($totalShift == 3){
	echo '<table class="table tableJadwal col-sm-6" id="tabelForm_'.$i.'">';
}else{
	echo '<table class="table tableJadwal col-sm-6" id="tabelForm_'.$i.'">';
}
?>
	<thead>
        <tr>
            <th><?php echo MyFormatter::getDayUser($hari[$i])." / Shift ".$shifM->shift_nama; ?></th>
        </tr>
    </thead>
    <tbody>
		<tr>
			<td>
                                <b>Hari / Tanggal : 
				<?php
//					echo MyFormatter::getDayUser($hari[$i]).' / <div style="display:inline-block;margin-bottom:-7px;" class="input-append required"><input id="tanggalHemodialisa_'.$i.'_'.$j.'" style="float:left" type="text" name="jadwalHemo[jadwal]['.$i.']['.$j.'][jadwalhemodialisa_tgl]" class="span2 timePickerTest hasDatepicker" value="'.$tglsaatHari.'"><span class="add-on"><i class="entypo-calendar"></i></span></div>';
					echo MyFormatter::getDayUser($hari[$i]).' / <div style="display: none;" class="input-append required"><input id="tanggalHemodialisa_'.$i.'_'.$j.'" style="float:left" type="text" name="jadwalHemo[jadwal]['.$i.'][shift]['.$j.'][jadwalhemodialisa_tgl]" class="span2 timePickerTest hasDatepicker" value="'.$tglsaatHari.'" readonly></div>';
                                        echo $tglsaatHari;
				?>
                                </b> 
			</td>
		</tr>
        <?php
		$no = 0;
		foreach($modRuangan as $x=>$poli){            
            echo "<tr><td><div class='errorTable'></div>";
			echo CHtml::checkBox("jadwalHemo[jadwal][$i][shift][$j][ruangan_id][$no][cek]", true, array('title'=>'Uncheck jika data tidak akan dimasukan ke database'));
            echo CHtml::hiddenField("jadwalHemo[jadwal][$i][shift][$j][ruangan_id][$no][ruangan_id]",$poli->ruangan_id);
            echo CHtml::hiddenField("jadwalHemo[jadwal][$i][shift][$j][jadwalhemodialisa_hari]",MyFormatter::getDayUser($hari[$i]));
			echo CHtml::hiddenField("jadwalHemo[jadwal][$i][shift][$j][jadwalhemodialisa_shift]",$shift[$j]);
            echo ' '.CHtml::label($poli->ruangan_nama, "jadwalPoli_".$i."_".$j."_".$x).' ';
            echo CHtml::link('<i class="icon icon-plus"></i>', 'javascript:void(0)', array('onclick'=>"insertInputJadwal(".$i.", ".$j.", ".$no.", ".$poli->ruangan_id.",this)", 'title'=>'Tambah Pasien'));
            echo "<div id='div_".$i."_".$j."_".$no."'>";
            $input = '';
//            if (count((array)$modJadwal) > 0){
//                $ruangans = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$poli->ruangan_id)), 'ruangan_id', 'kamarruangan_nobed');
//                foreach ($modJadwal as $key => $value) {
//                    $input .= '<ul class="div_'.$i.'_'.$key.' classInline">';
////                    $input .= '<select style="display:inline-block;" name="jadwalDokter[jadwal]['.$i.'][dokter]['.$poli->ruangan_id.'][dokter]['.$key.'][pegawai_id]" id="jadwalDokter_'.$i.'_'.$poli->ruangan_id.'_'.$key.'" type="text" class="inputDokter span2"></select>';
//                    $input .= '<li class="jenis_kel"></li>';
//                    $input .= '<li class="umur"></li>';
//					$input .= '<li>'.CHtml::dropDownList('jadwalHemo[jadwal]['.$i.']['.$j.'][hemodialisa]['.$poli->ruangan_id.'][hemodialisa]['.$key.'][ruangan_id]', $value->ruangan_id, $ruangans, array('class'=>"inputDokter span2", 'id'=>"jadwalHemo_'.$i.'_'.$j.'_'.$poli->ruangan_id.'_'.$key.'", 'style'=>'display:inline-block;')).
//                            CHtml::hiddenField('jadwalHemo[jadwal]['.$i.']['.$j.'][hemodialisa]['.$poli->ruangan_id.'][hemodialisa]['.$key.'][kamarruangan_nobed]', $value->kamarruangan_nobed).
//                            '</li>';
//                    $input .= '<li><a href="javascript:void(0)" onclick="removeThis(this)"><i class="icon icon-minus"></i></a></li>';
//                    $input .= '</ul>';
//                }
//            }
            echo $input."</div>";
            echo "</td></tr>";
			$no++;
        }
        ?>
    </tbody>
</table>
</div>