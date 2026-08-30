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
                                            if (!empty($var0)){
                                                echo '<span  style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
                                            }
					}
				?>
			</td>
			<td style="<?php echo !empty($det[1]['id'])?'border:4px solid #333 !important;':'' ?>" class="hover params-nilai1 borderflaccs" onclick="getSkorFla('<?php echo $det['kategori_id'] ?>',1,this)">
				<?php
					foreach ($det[1] as $var0){
                                            if (!empty($var0)){
                                                echo '<span  style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
                                            }
					}
				?>
			</td>
			<td style="<?php echo !empty($det[2]['id'])?'border:4px solid #333 !important;':'' ?>" class="hover params-nilai2 borderflaccs" onclick="getSkorFla('<?php echo $det['kategori_id'] ?>',2,this)">
				<?php
					foreach ($det[2] as $var0){
                                            if (!empty($var0)){
                                                echo '<span style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
                                            }
					}
				?>
			</td>
                        <td style="text-align:right;">
                            <?php
                                $modNyeriDet = new RJSkrinningnyerianakdetT();
                                $modNyeriDet->skrinningnyerianakdet_id = (isset($det['val_anak_id'])?$det['val_anak_id']:null);
                                $modNyeriDet->kat_skalanyeri_id = (isset($det['val_kat_id'])?$det['val_kat_id']:null);
                                $modNyeriDet->skalanyeriflaccs_param = (isset($det['val_params'])?$det['val_params']:null);
                                $modNyeriDet->skalanyeriflaccs_nilai = (isset($det['val_nilai'])?$det['val_nilai']:null);

                                echo $form->hiddenField($modNyeriDet,'['.$sk.']skrinningnyerianakdet_id',array('readonly' => true, 'class'=>'nyerianak_id field'));
                                echo $form->hiddenField($modNyeriDet,'['.$sk.']kat_skalanyeri_id',array('readonly' => true, 'class'=>'kategoriid field'));
                                echo $form->hiddenField($modNyeriDet,'['.$sk.']skalanyeriflaccs_param',array('class'=>'params field','readonly' => true));
                                echo $form->hiddenField($modNyeriDet,'['.$sk.']skalanyeriflaccs_nilai',array('class'=>'nilai field','readonly' => true));

                            ?>
                            <strong><span class="labelname" id="skor_<?php echo $det['kategori_id']; ?>"><?php echo $modNyeriDet->skalanyeriflaccs_nilai; ?></span></strong>
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
				<strong>TOTAL SKOR </strong>
			</td>
                        <td style="text-align: right;">
                            <strong><span class="labelname"  id="totalskor"><?php echo $model->score_skalanyeri; ?></span></strong>
                            <?php echo $form->hiddenField($model,'score_skalanyeri_anak',array('readonly'=>true,'class'=>' field'))  ?>
                            <?php echo $form->hiddenField($model,'keteranganskala_nyeri_anak',array('readonly'=>true,'class'=>' field'))  ?>
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
                                        <span id="skalanyerirange_0" min="0" max="0"><strong>0</strong> : Tidak nyeri</span>
                                    </td>
                                    <td width="33%">
                                        <span id="skalanyerirange_1_3"  min="1" max="3"><strong>1-3</strong> : Nyeri ringan</span>
                                    </td>
                                    <td width="33%">

                                    </td>
                                </tr>
                                 <tr>
                                    <td width="33%">
                                        <span id="skalanyerirange_4_6"  min="4" max="6"><strong>4-6</strong> : Nyeri sedang</span>
                                    </td>
                                    <td width="33%">
                                        <span id="skalanyerirange_7_10"  min="7" max="10"><strong>7-10</strong> : Nyeri hebat</span>
                                    </td>
                                    <td width="33%">

                                    </td>
                                </tr>
                            </table>
			</td>

		</tr>
    </tfoot>
</table>
