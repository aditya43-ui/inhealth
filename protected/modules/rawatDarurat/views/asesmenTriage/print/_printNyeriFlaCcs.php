<?php
/**
* - digunakan untuk melakukan inputan data asesmen triase
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
	
<table class="table noborder paddingtext">
	<tr>
		<td style="text-align: center;"><h4>SKALA NYERI FLACCS</h4></td>
	</tr>
</table>

<table class="table border paddingtext" style="color: #333;">
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
		foreach ($dataFlaCcs as $det){
	?>
		<tr>
			<td><b><?php echo $det['kategori']; ?></b></td>
			<td>
				<?php 
					foreach ($det[0] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						'onclick' => "pilihNyeriFlaCcsIni(this)"));
						
						echo '<label> '.$var0['keterangan'].'</label>';
						echo '<br>';
					}
				?>
			</td>
			<td>
				<?php 
					foreach ($det[1] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						'onclick' => "pilihNyeriFlaCcsIni(this)"));						
						echo '<label> '.$var0['keterangan'].'</label>';
						echo '<br>';
					}
				?>
			</td>
			<td>
				<?php 
					foreach ($det[2] as $var0){											
						$modFlaCcs->ispilih = $var0['value'];
						echo $form->CheckBox($modFlaCcs,'['.$var0["id"].']ispilih', array('value'=>$var0['id'],
						'onclick' => "pilihNyeriFlaCcsIni(this)"));						
						echo '<label> '.$var0['keterangan'].'</label>';
						echo '<br>';
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
				<span class="<?php echo $ii1 ?>" id="skalanyerirange_0" min="0" max="0"><b>0</b> : Tidak nyeri</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo $ii2 ?>" id="skalanyerirange_1_3"  min="1" max="3"><b>1-3</b> : Nyeri ringan</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo $ii3 ?>" id="skalanyerirange_4_6"  min="4" max="6"><b>4-6</b> : Nyeri sedang</span> &nbsp; &nbsp; &nbsp; &nbsp;
				<span class="<?php echo $ii4 ?>" id="skalanyerirange_7_10"  min="7" max="10"><b>7-10</b> : Nyeri hebat</span> &nbsp; &nbsp; &nbsp; &nbsp;
			</td>
		</tr>
</table>
		