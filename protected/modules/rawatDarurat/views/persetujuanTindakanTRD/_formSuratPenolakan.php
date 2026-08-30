<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
    #radio-sesuai > label.radio{            
        width:80px;
        display:inline-block;
    }
</style>
	<h3><center>PENOLAKAN TINDAKAN MEDIS</center></h3>
    <br><br>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini:
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'nama_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required')); ?></td>
            </tr>
            <tr>
                <td>Umur <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'umur_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required')); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin<span class="required">*</span></td>
                <td>:</td>
                <td>
                    <?php 
//                        echo $form->textField($modSuratPersetujuan,'jeniskelamin_menyetujui', array('readonly'=>false,
//                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required')); 
                    ?>
                    <div class="control-group">
                        <div class="controls" id="radio-sesuai">                
                            <?php echo $form->radioButtonList($modSuratPersetujuan,'jeniskelamin_menyetujui', LookupM::getItems('jeniskelamin'),array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'required')); ?>                   
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Alamat <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'alamat_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required')); ?></td>
            </tr>
            <tr>
                <td>No. KTP <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'noktp_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'required')); ?></td>
            </tr>
        </table>
        <p align="justify">Dengan ini menyatakan sesungguhnya, bahwa saya telah menerima informasi yang diberikan oleh Dokter sebagaimana di atas dan telah memahaminya. Untuk saya akan memberikan </p>
		<h3><center>PENOLAKAN/PEMBATALAN</center></h3>
		<p align="justify">
			Untuk dilakukan tindakan medis berupa 
			<?php
				$style_tindakan = '';
				if(count($modTindakanAnestesi) > 0){
					$style_tindakan = 'style="margin-top:-25px;margin-left: 300px;"';
				}
			?>
			<div <?php echo $style_tindakan; ?>>
				<!--<ul>-->
					<?php
                    
                    
                    if (!empty($modSuratPersetujuan->suratpersetujuantm_id)) {
                        $tindakans = explode(":::", $modSuratPersetujuan->tindakanmedis);
                        
                        if (count($tindakans) == 0) {
                            echo "<ul><li>-</li></ul>";
                        } else {
                        
                            echo '<ul>';
                            $tindakan_cnt = 0;
                            foreach ($tindakans as $item) {
                                if (empty($item) || trim($item) == "") {
                                    continue;
                                }
                                echo '<li>'.$item.'</li>';
                                $tindakan_cnt++;
                            }
                            
                            if ($tindakan_cnt == 0) {
                                echo "<li>Tidak Ada</li>";
                            }
                            echo '</ul>';
                        }
                    } else {
                    
                        $tindakans = array();

                        if(count($modTindakanAnestesi) > 0){
                            foreach($modTindakanAnestesi AS $i=>$tindakan){ 

                                if (empty($tindakans[$tindakan->daftartindakan_id])) {
                                    $tindakans[$tindakan->daftartindakan_id] = 1;
                                } else {
                                    continue;
                                }

                                ?>
                                <!--<li><?php // echo (!empty($tindakan->daftartindakan_id) ? $tindakan->daftartindakan->daftartindakan_nama : ""); ?></li>-->
                                                            <?php
                                                            echo CHtml::checkbox('tindakan['.$tindakan['daftartindakan_id'].']', true, array('value'=>$tindakan->daftartindakan->daftartindakan_nama)).
                                                            $tindakan->daftartindakan->daftartindakan_nama.'<br/>';
                                                            ?>
                        <?php    }
                        }
                    }
					?>			
				<!--</ul>-->
			</div>
		</p>
        
        <p align="justify">
			Bedah/Operasi
			<?php echo CHtml::activeTextArea($modSuratPersetujuan, 'bedah_operasi'); ?>
        </p>
        <p align="justify">
			Transfusi Darah
			<?php echo CHtml::activeTextArea($modSuratPersetujuan, 'transfusi_darah'); ?>
        </p>
        
        
		<p align="justify">
			Dengan obat dan alat kesehatan
			<?php
				$style_obat = '';
				if(count($modObatAlkesAnestesi) > 0){
					$style_obat = 'style="margin-top:-25px;margin-left: 300px;"';
				}
			?>
			<div <?php echo $style_obat; ?>>
				<!--<ul>-->
					<?php
                    if (!empty($modSuratPersetujuan->suratpersetujuantm_id)) {
                        $oa = explode(":::", $modSuratPersetujuan->obatalkes);
                        
                        if (count($oa) == 0) {
                            echo "-";
                        } else {
                        
                            $tindakan_cnt = 0;
                            foreach ($oa as $item) {
                                if (empty($item) || trim($item) == "") {
                                    continue;
                                }
                                
                                echo CHtml::checkbox('obat['.$item.']', true, array('value'=>$item)).
                                $item.'<br/>';
                                
                                $tindakan_cnt++;
                            }
                            
                            if ($tindakan_cnt == 0) {
                                echo "Tidak Ada<br/>";
                            }
                        }
                        
                    } else {
                    
                    
                    
                    
					if(count($modObatAlkesAnestesi) > 0){
						foreach($modObatAlkesAnestesi AS $i=>$obat){ ?>
							<!--<li><?php // echo (!empty($obat->obatalkespasien_id) ? $obat->obatalkespasien->obatalkes->obatalkes_nama : ""); ?></li>-->
                                                        <?php
                                                        echo CHtml::checkbox('obat['.$obat['obatalkes_id'].']', true, array('value'=>$obat->obatalkes->obatalkes_nama)).
                                                        $obat->obatalkes->obatalkes_nama.'<br/>';
                                                        ?>
					<?php    }
					}
                    }
					?>			
				<!--</ul>-->
			</div>
		</p>
        <p align="justify">
           Terhadap <?php echo CHtml::activeDropDownList($modSuratPersetujuan,'tindakanterhadap', LookupM::getItems('tindakanterhadap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'style'=>'width:120px;', 'class'=>'required')); ?> , dengan
			<span class="required">*</span> <br>
			<table width="100%" style="width:500px;margin-left:80px;">
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>Umur/Jenis Kelamin</td>
					<td>:</td>
					<td>
						<?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : ""; ?> / <?php echo isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : ""; ?>
					</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>No. KTP</td>
					<td>:</td>
					<td>
						<?php 
							if($modPasien->jenisidentitas == 'KTP'){
								echo isset($modPasien->no_identitas_pasien) ? $modPasien->no_identitas_pasien : "-";
							}else{
								echo "-";
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Dirawat Di</td>
					<td>:</td>
					<td>
						<?php echo isset($modPraAnestesi->ruangan->ruangan_nama) ? $modPraAnestesi->ruangan->ruangan_nama : ""; ?> / <?php echo isset($modPraAnestesi->kamarruangan->KamarDanTempatTidurPasien) ? $modPraAnestesi->kamarruangan->KamarDanTempatTidurPasien : ""; ?>
					</td>
				</tr>
				<tr>
					<td>No. Rekam Medis</td>
					<td>:</td>
					<td>
						<?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : ""; ?>
					</td>
				</tr>
			</table>
        </p>
        <p align="justify">
           Yang tujuan, sifat dan perlunya tindakan medis tersebut diatas, serta resiko yang dapat ditimbulkannya telah cukup dijelaskan oleh dokter dan telah saya mengerti sepenuhnya.
        </p>
        <p align="justify">
           Demikian perenyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.
        </p>
	<br><br><br><br><br>
	<table width='100%'>
        <tr>
            <td width='35%'></td>
			<td width='35%'></td>
            <td align="center" width='30%'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr height='100px'>
            <td align="center" width='35%'>Dokter</td>
            <td>&nbsp;</td>
            <td align="center" width='30%'>Yang Membuat <span class="required">*</span></td>
        </tr>
        <tr>
            <td align="center" width='35%'><?php echo CHtml::activeDropDownList($modSuratPersetujuan,'dokter_id', CHtml::listData(DokterV::model()->findAll(), 'pegawai_id', 'nama_pegawai'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            <td>&nbsp;</td>
            <td align="center" width='30%'><?php echo CHtml::activeTextField($modSuratPersetujuan,'nama_yangmenyetujui',array('class'=>'span3 required')); ?></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='35%'>Saksi Rumah Sakit</td>
            <td align="center" width='35%'></td>
            <td align="center" width='30%'>Saksi Pasien</td>
        </tr>
		<tr>
            <td align="center" width='35%'><?php echo CHtml::activeDropDownList($modSuratPersetujuan,'pegawaisaksi1_id', CHtml::listData(PegawaiV::model()->findAll(), 'pegawai_id', 'nama_pegawai'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            <td align="center" width='35%'></td>
            <td align="center" width='35%'><?php echo CHtml::activeTextField($modSuratPersetujuan,'nama_saksi2',array('class'=>'span3')); ?></td>
        </tr>
    </table>