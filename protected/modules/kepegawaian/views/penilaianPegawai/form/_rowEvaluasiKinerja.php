<?php
/**
* - digunakan untuk mengenerate data master jenispenilaian, kompetensi dan indikator penilaian
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

<table class="table table-striped table-bordered table-condensed tablepenilaian" width="100%" id="">
<?php             
    $table = $generateTable;                
    $a = 1;
    $d = 0;
    foreach ($table as $dt){
?>                                    
        <tr>
            <th colspan="4" style="text-align: left;border:none;background: none;">
                <ol style="list-style-type: upper-alpha;padding: 0;margin: 0;" start="<?php echo $a; ?>">
                    <li><?php echo $dt['jenispenilaian'] ?></li>
                </ol>
            </th>
        </tr>                    

        <tr>
            <th>NO</th>
            <th>ASPEK PENILAIAN</th>
            <th width="10%">NILAI</th>
			<th width="15%">NAMA NILAI</th>
            <th>KETERANGAN</th>
        </tr>

                <?php 
                    $b = 1;
                    
                    foreach ($dt['kompetensi'] as $dt2)
                    {                                
                ?>
                        <tr>
                            <td>
                                <ol style="padding: 0;margin: 0;" start="<?php echo $b; ?>">
                                    <li>&nbsp;</li>
                                </ol>                                            
                            </td>
                            <td><?php echo $dt2['kompetensi_nama']; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            $c = 1;
                            foreach($dt2['indikator'] as $dt3)
                            {
                        ?>
                                <tr id="<?php echo $dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'].'-'.$c; ?>">
                                    <td></td>
                                    <td>
                                        <ol style="list-style-type: lower-alpha;padding: 0;margin: 0;" start="<?php echo $c; ?>">
                                            <li><?php echo $dt3['indikatorperilaku_nama']; ?></li>
                                        </ol>                                            
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo CHtml::activeTextField($modPenilaianPegawaiDet,'['.$d.']penilaianpegdet_socre',array('class'=>'numbers-only span1 required','readonly'=>FALSE,'style'=>'text-align:right;','onblur'=>'cekScore(this,\''.$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'].'\',\''.$dt['jenispenilaian_id'].'\')')); //.' <span class="pesan" style="font-weight: bold; font-style: italic; padding: 10px;"></span>'; ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']jenispenilaian_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$dt3['jenispenilaian_id'])); ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']kompetensi_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$dt3['kompetensi_id'])); ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']indikatorperilaku_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$dt3['indikatorperilaku_id'])); ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']bobotnilai_indikator',array('class'=>'span1','readonly'=>TRUE,'value'=>$dt3['bobotnilai_indikator'])); ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']kolomrating_id',array('class'=>'span1','readonly'=>TRUE));//,'value'=>$dt3['kolomrating_id'] ?>
                                        <?php echo CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$d.']point',array('class'=>'span1','readonly'=>TRUE)) ?>
                                    </td>
									<td>
										<span class="pesan" style="font-weight: bold; font-style: italic; padding: 10px;"></span>
									</td>
                                    <td>                                        
                                        <?php echo CHtml::activeTextArea($modPenilaianPegawaiDet,'['.$d.']keterangan',array('row'=>3,'col'=>6,'class'=>'autorow','readonly'=>false)); ?>
                                    </td>
                                </tr>
                        <?php
                            $c++;
                            $d++;
                            }
                        ?>
                            <tr>
                                <td colspan="2" style="text-align:right;"><b>Sub Jumlah</b></td>
                                <td style="text-align:center;"><?php echo CHtml::textField("subJumlah".$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?></td>
                                <td>&nbsp;</td>
								<td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right;"><b>Rata - Rata <?php echo $b ?></b></td>
                                <td style="text-align:center;"><?php echo CHtml::textField("rataRata".$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?></td>
                                <td>&nbsp;</td>
								<td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right;"><b>Nilai Aspek <?php echo $b ?></b></td>
                                <td style="text-align:center;">
                                    <?php echo CHtml::hiddenField("jmlBobotIndikator".$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'], '', array('readonly' => TRUE, 'class'=>'span1',)); ?>
                                    <?php echo CHtml::hiddenField("jmlBobotPenilaian".$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'], $dt['bobot_penilaian'], array('readonly' => TRUE, 'class'=>'span1',)); ?>
                                    <?php echo CHtml::textField("nilaiAspek".$dt['jenispenilaian_id'].'-'.$dt2['kompetensi_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?>
                                </td>
                                <td>&nbsp;</td>
								<td>&nbsp;</td>
                            </tr>
                <?php
                    $b++;
                    }
					
					if (count((array)$dt['kompetensi'])>1){ ?>                
						<tr>
							<td colspan="2" style="text-align:right;"><b>Total Jumlah</b></td>
							<td style="text-align:center;"><?php echo CHtml::textField("totalJumlah".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right;"><b> Total Rata - Rata</b></td>
							<td style="text-align:center;"><?php echo CHtml::textField("totalRataRata".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;')) ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
				<?php } ?>
<?php
    $a++;
    }
?>
</table>         

<?php
if(!empty($table)){
?>
<table>
	<tr>
		<th><u>Keterangan Nilai</u></th>
	</tr>	
	<?php 
		$j = 1;
		foreach ($ketNilai as $nl){ ?>	
	<tr>
		<td><?php echo $nl->kolomrating_namalevel; ?></td>
		<td> : &nbsp;&nbsp;</td>
		<td>
			<?php 
			if ($j == count((array)$ketNilai)){
				echo 'Kurang dari '.($nl->kolomrating_nilaiakhir+1);
				echo CHtml::hiddenField("ketNilai-".$j,'',array('min'=>$nl->kolomrating_nilaiawal, 'max'=>$nl->kolomrating_nilaiakhir, 'keterangan'=>$nl->kolomrating_namalevel));
			}else{
				echo $nl->kolomrating_nilaiawal; ?> - <?php echo $nl->kolomrating_nilaiakhir; 
				echo CHtml::hiddenField("ketNilai-".$j,'',array('min'=>$nl->kolomrating_nilaiawal, 'max'=>$nl->kolomrating_nilaiakhir, 'keterangan'=>$nl->kolomrating_namalevel));
			}
			?>
		</td>
	</tr>
	<?php 
		$j++;
	
		} ?>
</table>
<p>&nbsp;</p>
<h6>Total Nilai</h6>
<table class="table table-striped table-bordered table-condensed tabletotal" width="100%" id="">
	<tr>
		<th>NO</th>
		<th>Aspek Penilaian</th>
		<th style="text-align: center;" width="10%">Jumlah</th>
		<th style="text-align: center;" width="10%">Nama Nilai</th>
		<th>Keterangan</th>
	</tr>
	<?php 
		$no = 1;
		 foreach ($table as $jns){
	?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $jns['jenispenilaian']; echo CHtml::hiddenField("totalJenis",count((array)$table)); ?></td>
				<td style="text-align: center;"><?php echo CHtml::textField("totalKeseluruhan-".$jns['jenispenilaian_id'], '',array('readonly'=>true,'style'=>'text-align:right;')); ?></td>
				<td ><span class="stket-<?php echo $jns['jenispenilaian_id']  ?>"></span></td>
				<!--<td ><?php //echo CHtml::textArea("statusKet-".$jns['jenispenilaian_id'], '',array('readonly'=>true,'class'=>'autorow')); ?></td>-->
				<td><?php echo CHtml::activeTextArea($model, 'penilaianpegawai_keterangan['.($no-1).']',array('class' => 'autogrow')) ?></td>
			</tr>
	<?php
		$no++;
		 }
	?>	
	<tr>
		<td></td>
		<td style="text-align:right;">Total</td>
		<td><?php echo CHtml::activeTextField($model, 'jumlahpenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;')); ?></td>
		<td></td>
		<td></td>
	</tr>
        <tr style="display:none;">
		<td></td>
		<td style="text-align:right;">Rata - rata</td>
		<!--<td><?php //echo CHtml::textField("grandAverage",'',array('readonly'=>true, 'style' => 'text-align:right;')); ?></td>-->
		<td><?php echo CHtml::activeTextField($model, 'nilairatapenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;')); ?></td>
		<td ><span class="grandKet"></span></td>
		<td ><?php //echo CHtml::textArea("statusTotal", '',array('readonly'=>true,'class'=>'autorow')); ?></td>
	</tr>
</table>

<?php
}
?>
