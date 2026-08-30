<?php
/**
* - digunakan untuk melakukan inputan data asesmen nyeri anak kurang 3 tahun
*
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*/
?>

<table class="table border" style="color: #333;" id="master_falsccs">
    <thead>
    <tr>
        <th colspan="5" style="text-align:center;">SKALA FLACSS UNTUK ANAK < 3 TAHUN</th>
    </tr>
	<tr>
            <th style="text-align:center;vertical-align: middle;" rowspan="2">KRITERIA</th>
		<th style="text-align:center;" colspan="3">SKOR</th>
                <th style="text-align:center;vertical-align: middle;" rowspan="2">NILAI</th>
	</tr>
	<tr>
		<th style="text-align:center;">0</th>
		<th style="text-align:center;">1</th>
		<th style="text-align:center;">2</th>
	</tr>
    </thead>
    <tbody>
	<?php
                $sk = 0;
		foreach ($dataFlaCcs as $det){
	?>
		<tr>
			<td><b><?php echo $det['kategori']; ?></b></td>
                        <td style="<?php echo !empty($det[0]['id'])?'border:4px solid #333 !important;':'' ?>" class="hover params-nilai0 borderflaccs" onclick="getSkorFla('<?php echo $det['kategori_id']; ?>',0,this)">
				<?php
					foreach ($det[0] as $var0){
						//$modFlaCcs->ispilih = $var0['value'];
						//echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">'.$form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						//'onclick' => "pilihNyeriFlaCcsIni(this)"));
						//echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span  style="color:#333;font-size:12px;">'.(isset($var0['keterangan'])?$var0['keterangan']:"").'</span>';
						//echo '</label><br>';
					}
				?>
			</td>
			<td style="<?php echo !empty($det[1]['id'])?'border:4px solid #333 !important;':'' ?>" class="hover params-nilai1 borderflaccs" onclick="getSkorFla('<?php echo $det['kategori_id'] ?>',1,this)">
				<?php
					foreach ($det[1] as $var0){
						//$modFlaCcs->ispilih = $var0['value'];
						//echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">'.$form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						//'onclick' => "pilihNyeriFlaCcsIni(this)"));
						//echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span  style="color:#333;font-size:12px;">'.(isset($var0['keterangan'])?$var0['keterangan']:"").'</span>';
						//echo '</label><br>';
					}
				?>
			</td>
			<td style="<?php echo !empty($det[2]['id'])?'border:4px solid #333 !important;':'' ?>" class="hover params-nilai2 borderflaccs" onclick="getSkorFla('<?php echo $det['kategori_id'] ?>',2,this)">
				<?php
					foreach ($det[2] as $var0){
						//$modFlaCcs->ispilih = $var0['value'];
						//echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">'.$form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						//'onclick' => "pilihNyeriFlaCcsIni(this)"));
						//echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span style="color:#333;font-size:12px;">'.(isset($var0['keterangan'])?$var0['keterangan']:"").'</span>';
						//echo '</label><br>';
					}
				?>
			</td>
                        <td style="text-align:right;">
                            <?php
                                $modNyeriAnakDet->asesmentnyerianakdet_id = $det['val_anak_id'];
                                $modNyeriAnakDet->kat_skalanyeri_id = $det['val_kat_id'];
                                $modNyeriAnakDet->skalanyeriflaccs_param = $det['val_params'];
                                $modNyeriAnakDet->skalanyeriflaccs_nilai = $det['val_nilai'];

                                echo $form->hiddenField($modNyeriAnakDet,'['.$sk.']asesmentnyerianakdet_id',array('readonly' => true, 'class'=>'nyerianak_id field'));
                                echo $form->hiddenField($modNyeriAnakDet,'['.$sk.']kat_skalanyeri_id',array('readonly' => true, 'class'=>'kategoriid field'));
                                echo $form->hiddenField($modNyeriAnakDet,'['.$sk.']skalanyeriflaccs_param',array('class'=>'params field','readonly' => true));
                                echo $form->hiddenField($modNyeriAnakDet,'['.$sk.']skalanyeriflaccs_nilai',array('class'=>'nilai field','readonly' => true));

                            ?>
                            <b><span class="labelname" id="skor_<?php echo $det['kategori_id']; ?>"><?php echo $modNyeriAnakDet->skalanyeriflaccs_nilai; ?></span></b>
                        </td>
		</tr>
	<?php
                $sk++;
		}

	?>
    </tbody>
    <tfoot>
		<tr>
			<td colspan="4" style="text-align: center;">
				<b>TOTAL SKOR </b>
			</td>
                        <td style="text-align: right;">
                            <b><span class="labelname"  id="totalskor"><?php echo $model->scoreanak; ?></span></b>
                            <?php echo $form->hiddenField($model,'scoreanak',array('readonly'=>true,'class'=>' field'))  ?>
                            <?php echo $form->hiddenField($model,'keterangananak',array('readonly'=>true,'class'=>' field'))  ?>
                        </td>
		</tr>
                <tr>
			<td colspan="5">
                            <table class="table noborder">
                                <tr>
                                    <td colspan="3">
                                        <b>Keterangan</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="33%">
                                        <span id="skalanyerirange_0" min="0" max="0"><b>0</b> : Tidak nyeri</span>
                                    </td>
                                    <td width="33%">
                                        <span id="skalanyerirange_1_3"  min="1" max="3"><b>1-3</b> : Nyeri ringan</span>
                                    </td>
                                    <td width="33%">

                                    </td>
                                </tr>
                                 <tr>
                                    <td width="33%">
                                        <span id="skalanyerirange_4_6"  min="4" max="6"><b>4-6</b> : Nyeri sedang</span>
                                    </td>
                                    <td width="33%">
                                        <span id="skalanyerirange_7_10"  min="7" max="10"><b>7-10</b> : Nyeri hebat</span>
                                    </td>
                                    <td width="33%">

                                    </td>
                                </tr>
                            </table>
			</td>

		</tr>
    </tfoot>
</table>

<?php /*
<table id="tampung-flaccs" hidden>
    <tbody>
        <?php
            if (!empty($getFlaCcs)){
                $i = 0;
                foreach ($getFlaCcs as $set){
                    echo $this->renderPartial($this->path_view.'form._formGetNyeriFlaCcs',array('modFlaCcs'=>$set,'form'=>$form,'i'=>$i));
                    $i++;
                }
            }
        ?>
    </tbody>
</table>
 *
 */ ?>
