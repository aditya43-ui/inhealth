
<?php $modPendaftaran = new GZPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th rowspan="2">Tanggal Kunjungan/<br>No. Pendaftaran</th>
                <th rowspan ="2">Anamnesis Diet</th>  
                <th colspan ="9">Pemeriksaan Fisik</th>  
                <th rowspan ="2">Konsultasi Gizi</th>  
                <th rowspan ="2">Pemeriksaan Fisik Perawatan</th>  
                <th rowspan ="2">Anamnesis Perawatan</th>  
                <th colspan ="2">Pemeriksaan Penunjang</th>  
                <th rowspan ="2">Diagnosis</th>  
            </tr>
            <tr>
                <th>Tekanan Darah</th>  
                <th>Detak Nadi</th>  
                <th>Suhu Tubuh</th>  
                <th>Tinggi Badan / Berat Badan</th>  
                <th>Lila <br> (Untuk Pasien Hamil)</th>  
                <th>Lingkar Pinggang <br> (Untuk Pasien <br> Obgyn)</th>  
                <th>LIngkar Pinggul <br> (Untuk Pasien <br> Obesitas)</th>  
                <th>Tebal Lema <br> (Untuk Pasien <br> Obesitas)</th>  
                <th>Tinggi Lutut <br> (Untuk Pasien <br> Usia Lanjut / Bongkok)</th>  
                <th>Ke Penunjang</th>  
                <th>Hasil</th>  
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br><?php echo MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran); ?></td>
                <td style="text-align: center; width: 60px;"><?php //if (count((array)$modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-form-pakaibahan'></i> ",  Yii::app()->controller->createUrl("daftarPasien/DetailAnamnesaDiet",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialogAnamnesa","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesa Diet", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailAnamnesa').text(text);window.parent.$('#dialogDetailAnamnesa').dialog('open');", "dialog-text"=>"Detail Anamnesa Diet")); 
                    
                //}?>
                </td>
                <td><?php //if (isset($modKunjungan->pemeriksaanfisik)){ 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->tekanandarah : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->detaknadi : ""); ?></td>
                <td><?php echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->suhutubuh : ""); ?></td>
                <td>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->tinggibadan_cm : ""); 
                ?>
                    <?php if((empty($modKunjungan->pemeriksaanfisik->tinggibadan_cm))&&(empty($modKunjungan->pemeriksaanfisik->beratbadan_kg))){
                        
                    } else { ;?>
                    <?php } ?><br>
                <?php 
                    echo (isset($modKunjungan->pemeriksaanfisik) ? $modKunjungan->pemeriksaanfisik->beratbadan_kg : ""); 
                ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->Lila) ? $modKunjungan->pemeriksaanfisik->Lila." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->LingkarPinggang) ? $modKunjungan->pemeriksaanfisik->LingkarPinggang." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->LingkarPinggul) ? $modKunjungan->pemeriksaanfisik->LingkarPinggul." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->TebalLemak) ? $modKunjungan->pemeriksaanfisik->TebalLemak." cm" : ""); ?></td>
                <td><?php echo (!empty($modKunjungan->pemeriksaanfisik->TinggiLutut) ? $modKunjungan->pemeriksaanfisik->TinggiLutut." cm" : ""); 
                //} ?></td>
                <td style="text-align: center; width: 60px;"><?php if (count((array)$modKunjungan->tindakanpelayanan) > 0){
                    echo CHtml::link("<i class='icon-form-poliklinik'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailKonsulGizi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialogGizi","rel"=>"tooltip","title"=>"Klik untuk Detail Konsultasi Gizi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailGizi').text(text);window.parent.$('#dialogDetailGizi').dialog('open');", "dialog-text"=>"Detail Pelayanan Konsultasi Gizi")); 
                    
                }?>
                </td>
				<td style="text-align: center; width: 60px;">
					<?php
						echo CHtml::link("<i class='icon-form-periksa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailPeriksaFisik",
										array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"dialogPeriksaFisik","rel"=>"tooltip","title"=>"Klik untuk Detail Periksa Fisik", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogPeriksaFisik').text(text);window.parent.$('#dialogPeriksaFisik').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Periksa Fisik"));
						?>
					
				</td>
				<td style="text-align: center; width: 60px;">
					<?php
                    echo CHtml::link("<i class='icon-form-anamnesa'></i> ",  Yii::app()->controller->createUrl("daftarPasien/detailAnamnesa",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailAnamnesisPerawatan","rel"=>"tooltip","title"=>"Klik untuk Detail Anamnesis", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-detailAnamnesisPerawatan').text(text);window.parent.$('#detailAnamnesisPerawatan').dialog('open');", "dialog-text"=>"Riwayat Pelayanan/Anamnesis")); 
                    
                    ?>
					
				</td>
				<td><ul><?php $this->renderPartial('/_periksaDataPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
				<td style="text-align: center; width: 60px;"><ul style="margin: 0;">
                    <?php 
                        $modMasukPenunjang = GZPasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$modKunjungan->pendaftaran_id));
                        $jumlah = count((array)$modMasukPenunjang);
                        $result = "";
                        foreach($modMasukPenunjang as $row){
                            $modHasilLab = GZHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
                            $modHasilRad = HasilpemeriksaanradT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));

                            if($modHasilLab){ //cek jika sudah ada hasil lab
                                $result .= "".CHtml::link("<i class='icon-form-detail'></i> ",Yii::app()->controller->createUrl("daftarPasien/detailHasilLab",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                            }
                            elseif($modHasilRad){ //jika radiologi
                                $result .= "".CHtml::link("<i class='icon-form-detail'></i> ",Yii::app()->controller->createUrl("daftarPasien/detailHasilRad",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                            }else{
                                $result .= "";
                            }
                        }                        
                        echo $result;
                    ?></ul>
				</td>
				<td><?php $this->renderPartial('/_periksaDataPasien/_diagnosa', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot><tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr></tfoot>
    </table>

   
