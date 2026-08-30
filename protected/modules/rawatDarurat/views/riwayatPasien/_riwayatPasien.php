
<?php $modPendaftaran = new RDPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
                <th colspan ="2"><p style="margin: 0; text-align: center;">Anamnesis</p></th>  
                <th colspan ="4"><p style="margin: 0; text-align: center;">Pemeriksaan Fisik</p></th>  
                <th colspan ="2"><p style="margin: 0; text-align: center;">Pemeriksaan Penunjang</p></th>  
                <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Konsul Poliklinik</p></th>  
                <th colspan ="3"><p style="margin: 0; text-align: center;">Pelayanan</p></th>  
                <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Diagnosis</p></th>  
                <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Operasi</p></th>  
                <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Dokter Pemeriksa</p></th>  
                <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Dirujuk Keluar</p></th>  
            </tr>
            <tr>
                <th><p style="margin: 0; text-align: center;">Keluhan Utama</p></th>  
                <th><p style="margin: 0; text-align: center;">Riwayat Penyakit</p></th>  
                <th><p style="margin: 0; text-align: center;">TD</p></th>  
                <th><p style="margin: 0; text-align: center;">DN</p></th>  
                <th><p style="margin: 0; text-align: center;">ST</p></th>  
                <th><p style="margin: 0; text-align: center;">TB/BB</p></th>  
                <th><p style="margin: 0; text-align: center;">Ke penunjang</p></th>  
                <th><p style="margin: 0; text-align: center;">Hasil</p></th>  
                <th><p style="margin: 0; text-align: center;">Tindakan</p></th>  
                <th><p style="margin: 0; text-align: center;">Terapi</p></th>  
                <th><p style="margin: 0; text-align: center;">Pemakaian Bahan</p></th>  
                
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
                <td><?php echo $modKunjungan->anamnesa->keluhanutama; ?></td>
                <td><?php echo $modKunjungan->anamnesa->riwayatpenyakitterdahulu; ?></td>
                <td><?php echo $modKunjungan->pemeriksaanfisik->tekanandarah; ?></td>
                <td><?php echo $modKunjungan->pemeriksaanfisik->detaknadi; ?></td>
                <td><?php echo $modKunjungan->pemeriksaanfisik->suhutubuh; ?></td>
                <td>
                <?php 
                    echo $modKunjungan->pemeriksaanfisik->tinggibadan_cm; 
                ?>
                    <?php if((empty($modKunjungan->pemeriksaanfisik->tinggibadan_cm))&&(empty($modKunjungan->pemeriksaanfisik->beratbadan_kg))){
                        
                    } else { ;?>/
                    <?php } ?><br>
                <?php 
                    echo $modKunjungan->pemeriksaanfisik->beratbadan_kg; 
                ?></td>
                <td><ul><?php $this->renderPartial('/riwayatPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
                <td>
                    <ul>   
                        <?php 
                            $modMasukPenunjang = PasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$modKunjungan->pendaftaran_id));
                            $jumlah = count((array)$modMasukPenunjang);
                            $result = "";
                            foreach($modMasukPenunjang as $row){
                                $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
                                if($modHasilLab) //cek jika sudah ada hasil lab
                                    $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("riwayatPasien/detailHasilLab",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                                else //jika radiologi
                                    $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("riwayatPasien/detailHasilRad",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"));
                            }                        
                            echo $result; 
                        ?>
                    </ul>
                </td>
                <td><?php $this->renderPartial('/riwayatPasien/_konsulpoli', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php //$this->renderPartial('/riwayatPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                <p style="margin: 0; text-align: center;">    <?php //if (count((array)$modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailTindakan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Tindakan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Tindakan")); 
                    
                    //        }?></p>
                </td>
                <td><?php //$this->renderPartial('/riwayatPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                      <p style="margin: 0; text-align: center;">  <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailTerapi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Obat dan Alat Kesehatan")) ?>
                      </p>
                      </td>
                <td><?php //$this->renderPartial('/riwayatPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                  <p style="margin: 0; text-align: center;">  <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailPemakaianBahan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Data Detail Pemakaian Bahan")) ?>
                </p>
                </td>
                <td><?php $this->renderPartial('/riwayatPasien/_diagnosa', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php $this->renderPartial('/riwayatPasien/_operasi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
                <td><?php echo $modKunjungan->pegawai->nama_pegawai; ?></td>
                <td><?php $this->renderPartial('/riwayatPasien/_rujukKeluar', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?></td>
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
                <td></td>
            </tr></tfoot>
    </table>

   
