<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>
	
<style>
    
    .tab4 > tbody > tr > td,
    .tab4 > tbody > tr > th {
        border: 1px solid black;
    }
    
</style>

<table class="table noborder tab2">
	<tr>
		<td style="text-align: center;"><h4>SKALA NYERI FLACCS</h4></td>
	</tr>
</table>

<table class="table tab4 border" style="color: #333;">
	<tr>
		<th style="text-align:center;">KATEGORI</th>
		<th style="text-align:center;" colspan="3">PARAMETER</th>
	</tr>
	<tr>
		<th></th>
		<th style="text-align:center;">0</th>
		<th style="text-align:center;">1</th>
		<th style="text-align:center;">2</th>
	</tr>
	<?php
    $total_skor = 0;
		foreach ($dataFlaCcs as $det){
	?>
		<tr>
			<td><b><?php echo $det['kategori']; ?></b></td>
			<td>
				<?php 
					foreach ($det[0] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">';
                        echo $modFlaCcs->ispilih ? $ceklis : $unceklis;
                        
                        $total_skor += $modFlaCcs->ispilih ? 0 : 0;
                        
                        // echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						//'onclick' => "pilihNyeriFlaCcsIni(this)"));
						// echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span  style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
						echo '</label><br>';
					}
				?>
			</td>
			<td>
				<?php 
					foreach ($det[1] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">';
                        echo $modFlaCcs->ispilih ? $ceklis : $unceklis;
                        $total_skor += $modFlaCcs->ispilih ? 1 : 0;
                        //echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						//'onclick' => "pilihNyeriFlaCcsIni(this)"));
						// echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span  style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
						echo '</label><br>';
					}
				?>
			</td>
			<td>
				<?php 
					foreach ($det[2] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo '<label class="checkbox inline" id="skalanyeriflaccs_id_'.$var0["id"].'">';
                        echo $modFlaCcs->ispilih ? $ceklis : $unceklis;
                        $total_skor += $modFlaCcs->ispilih ? 2 : 0;
                        // echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						// 'onclick' => "pilihNyeriFlaCcsIni(this)"));
						// echo $form->hiddenField($modFlaCcs,'[]skalanyeriflaccs_id');
						echo '<span style="color:#333;font-size:12px;">'.$var0['keterangan'].'</span>';
						echo '</label><br>';
					}
				?>
			</td>
		</tr>
	<?php
		}

	?>
        <tr>
            <td colspan="4" style="text-align: center;">
                <b>SKOR</b>
            </td>
            
        </tr>
		<tr>
			<td colspan="4" style="text-align: center;">
				<span class="<?php echo $total_skor == 0 ? "borderradiusno" : ""; ?>"><b>0</b> : Tidak nyeri</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo in_array($total_skor, array(1,2,3))  ? "borderradiusno" : ""; ?>"><b>1-3</b> : Nyeri ringan</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo in_array($total_skor, array(4,5,6)) ? "borderradiusno" : ""; ?>"><b>4-6</b> : Nyeri sedang</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo in_array($total_skor, array(7,8,9,10)) ? "borderradiusno" : ""; ?>"><b>7-10</b> : Nyeri hebat</span> &nbsp; &nbsp; &nbsp; &nbsp;
			</td>
		</tr>
</table>
