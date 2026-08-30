<!--div class="white-container"-->

    <?php
	Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

    $no_urut = 1;
    $class='';
	
	
    ?>
<style>
	body{
		padding:10px;
	}
	
	h5{
		line-height: 5px !important;
	}
	
	h6{
		line-height: 5px !important;
	}
	
	.boldmerah{
		color:#d80000;
		font-weight:bold;
	}
	
</style>
	<?php 
	
		foreach ($data as $dt1){
	?>
		<h6 style="color:#b75858"><?php echo $dt1['jenispemeriksaanlab_nama']; ?></h6>
		<table class="table border paddingtext2">			
			<tr bgcolor="#e5e5e5">
				<th width="25%">Nama Pemeriksaan</th>
				<th width="25%">Detail Pemeriksaan</th>
				<th width="25%" style="text-align:center;">Hasil</th>
				<th width="25%" style="text-align:center;">Normal</th>
			</tr>
			<?php 
				foreach ($dt1['pemeriksaanlab'] as $dt2){ 					
					
					$a = 1;
					$i =1;
					$b = 1;
					foreach ($dt2['kelompokdet'] as $dt3){
						if (count((array)$dt3['nilairujukan']) > 1){
							
			?>
						<tr>
						
							<td style="border-bottom:white 1px solid !important;">
								<?php 									
										if ($i == 1){
											echo $dt2['pemeriksaanlab_nama'];
										}										
								
								?>
							</td>													
							<td colspan="3">
								<?php echo $dt3['kelompokdet'].' :'; ?>
							</td>							
						</tr>
			<?php
						}
						$j = 1;
						foreach ($dt3['nilairujukan'] as $dt4){	
							if (count((array)$dt2['kelompokdet']) == $b){
								if (count((array)$dt3['nilairujukan']) > 1){
									if (count((array)$dt3['nilairujukan']) == $j){										
										$border = 'border-bottom:1px solid #000 !important;';										
									}else{										
										$border = 'border-bottom:1px solid #fff !important;';
									}									
								}else{
									$border = 'border-bottom:1px solid #000 !important;';
								}
							}else{
								$border = 'border-bottom:1px solid #fff !important;';
							}
				?>
						<tr>
						
							<td style="<?php echo $border ; ?>">
								<?php 									
										if ($i == 1){
											
											echo $dt2['pemeriksaanlab_nama'];
										}	else{											
											
										}							
								
								?>
							</td>													
							<td>								
								<?php 
								if (count((array)$dt3['nilairujukan']) > 1){
									echo '<ul><li>'.$dt4['namapemeriksaandet'].'</li><ul>'; 
								}else{
									echo $dt4['namapemeriksaandet']; 
								}
								?>
							</td>
							<td style="text-align:center;">
								<?php 
									$spanclass='';
									$ubahData = '';
									
									if (trim($dt4['nilairujukan']) != '-'){
										
										if ($dt4['nilairujukan'] != ''){
											if ( ($dt4['nilaimin'] != 0 || $dt4['nilaimax'] != 0) ){

												$hasil = str_replace('.','',$dt4['hasilpemeriksaan']);

												$hasil = str_replace(',','.',$hasil);
															//var_dump($hasil);							
												if (($hasil < $dt4['nilaimin']) || ($hasil > $dt4['nilaimax'])){											
													$spanclass='boldmerah';
												}else{

												}
											}else{
												$cekNilai = Params::hasilDetLabTextNumber(strtolower($dt4['namapemeriksaandet'])); 
												if (!empty($cekNilai)){
													if($cekNilai == 2){																								
														$nilaiRujuk = $dt4['nilairujukan'];
														$nilaiPecah1 = explode('/',$nilaiRujuk);

														$nilai1= array();
														foreach($nilaiPecah1 as $idx => $p){
															$nilaiPecah2 = explode('-',$p);

															$nilai1[$idx] = array(
																'min' => isset($nilaiPecah2[0])?trim($nilaiPecah2[0]):null,
																'max' => isset($nilaiPecah2[1])?trim($nilaiPecah2[1]):null
															);
														}

														$hsl = $dt4['hasilpemeriksaan'];
														$pecah1 = explode('/',$dt4['hasilpemeriksaan']);

														$nilai2= array();
														foreach($pecah1 as $idx => $p){
															 $nilai2[$idx] = $p;
														}																								

														$g=0;																				
														foreach ($nilai1 as $idx => $sh){
															if (isset($nilai2[$idx])){
																$hasil = str_replace('.','',$nilai2[$idx]);

																$hasil = str_replace(',','.',$hasil);

																if (count((array)$nilai1)>0){
																	if ($g > 0){																																																																										
																		$ubahData .= '/';																														
																	}
																}

																if ( ($hasil < $sh['min']) || ($hasil > $sh['max']) ){
																	$spanclass='ubah';
																	$ubahData .= '<span class="boldmerah">'.$hasil.'</span>';
																}else{
																	$ubahData .= '<span class="">'.$hasil.'</span>';
																}

																$g++;
															}
														}
													}
												}else{
													if (strtolower(trim($dt4['hasilpemeriksaan'])) != strtolower(trim($dt4['nilairujukan']))){
														$spanclass='boldmerah';
													}
												}
											}
										}
									}
																		
								
								
									echo "<span class='".$spanclass."'>";
									if ($spanclass=='ubah'){										
										echo $ubahData;
									}else{
										echo $dt4['hasilpemeriksaan']; 
									}
									echo "</span>"
								?>
							</td>
							<td style="text-align:center;">
								<?php echo $dt4['nilairujukan']; ?>
							</td>
						</tr>
			
						
			<?php		
						$i++;
						$j++;
						}						
						
						$b++;
					}
					
				} ?>
		</table>	
	<?php
		}
	?>

<?php /*
    <table width="100%" border="1" class='<?php echo $class; ?>'>
        <thead>
            <th>NO.</th>
            <th width="30%">DETAIL PEMERIKSAAN</th>
            <th>HASIL PEMERIKSAAN</th>
            <th>NILAI RUJUKAN</th>
            <th>SATUAN</th>
            <th>METODE</th>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetailHasilPemeriksaans) > 0){
                foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
                    $trpemeriksaan = false;
                    if($i == 0){
                        echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                    }else if(($i) < count((array)$modDetailHasilPemeriksaans)){
                        if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
                            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                            //$no_urut--;
                        }
                    }
            ?>   
                <tr>
                    <td>
                        <?php echo $no_urut; ?>
                    </td>
                    <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
                    <td style="text-align: center;"><?php echo $modDetail->hasilpemeriksaan; ?></td>
                    <!--Karena <sup> jadi tidak superscript >> <td><?php // echo htmlentities($modDetail->NilaiRujukan, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></td>-->
                    <td style="text-align: center;"><?php echo $modDetail->NilaiRujukan; ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanSatuan; ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanMetode; ?></td>
                </tr>
            <?php 
                    $no_urut++;
                }
            }
            ?>
        </tbody>
    </table>
 * 
 */ ?>
		<table width="100%" class="paddingtext2">
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
                <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>                
                <?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
                </div>
                </div>
            </td>
        </tr>
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
                <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>                
                <?php echo $modHasilPemeriksaan->kesimpulan; ?>
                </div>
                </div><br>
            </td>
        </tr>
    </table>
    

