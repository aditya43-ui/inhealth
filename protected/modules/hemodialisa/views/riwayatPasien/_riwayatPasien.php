
<?php $modPendaftaran = new HDPendaftaranT; ?>
       <?php $this->widget('bootstrap.widgets.BootPager', array(
                'pages' => $pages,    
                'header'=>'<div class="pagination" id="pagin">',
                'footer'=>'</div>',
       )); ?>      
       <table class="items table table-striped table-bordered table-condensed" >
        <thead>
            <tr>
                <th rowspan="2">Tgl. Kunjungan/<br/>No.Pendaftaran</th>
                <th colspan ="2"><center>Anamnesis</center></th>  
                <th colspan ="4"><center>Pemeriksaan Fisik</center></th>  
                <th colspan ="2"><center>Pemeriksaan Penunjang</center></th>  
                <th valign='middle' rowspan="2"><center>Konsul Poliklinik</center></th>  
                <th colspan ="3"><center>Pelayanan</center></th>  
                <th valign='middle' rowspan="2"><center>Diagnosis</center></th>  
                <th valign='middle' rowspan="2"><center>Operasi</center></th>  
                <th valign='middle' rowspan="2"><center>Dokter Pemeriksa</center></th>  
                <th valign='middle' rowspan="2"><center>Dirujuk Keluar</center></th>  
            </tr>
            <tr>
                <th><center>Keluhan Utama</center></th>  
                <th><center>Riwayat Penyakit</center></th>  
                <th><center>TD</center></th>  
                <th><center>DN</center></th>  
                <th><center>ST</center></th>  
                <th><center>TB/BB</center></th>  
                <th><center>Ke penunjang</center></th>  
                <th><center>Hasil</center></th>  
                <th><center>Tindakan</center></th>  
                <th><center>Terapi</center></th>  
                <th><center>Pemakaian Bahan</center></th>  
                
            </tr>
            
        </thead>
        <tbody>
            <?php foreach($modKunjungan as $modKunjungan) { ?>
            <tr>
                <td><?php echo $modKunjungan->no_pendaftaran; ?><br/><?php echo $modKunjungan->tgl_pendaftaran; ?></td>
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
                    <?php } ?><br/>
                <?php 
                    echo $modKunjungan->pemeriksaanfisik->beratbadan_kg; 
                ?></td>
                <td><ul><?php $this->renderPartial('/riwayatPasien/_kepenunjang', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></ul></td>
                <td>
                    <ul>   
                        <?php 
                            $modMasukPenunjang = PasienMasukPenunjangT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id'=>$modKunjungan->pendaftaran_id));
                            $jumlah = count($modMasukPenunjang);
                            $result = "";
                            foreach($modMasukPenunjang as $row){
                                $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));
                                if($modHasilLab) //cek jika sudah ada hasil lab
                                    $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("riwayatPasien/detailHasilLab",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."";
                                else //jika radiologi
                                    $result .= "".CHtml::link("<i class='icon-list-alt'></i> ",Yii::app()->controller->createUrl("riwayatPasien/detailHasilRad",array("pendaftaran_id"=>$modKunjungan->pendaftaran_id, "pasien_id"=>$modKunjungan->pasien_id,"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"pesan","rel"=>"tooltip","title"=>"Klik untuk Detail Hasil Pemeriksaan '".$row->ruangan->ruangan_nama."'", "onclick"=>"window.parent.$('#dialogDetailHasilLab').dialog('open');"))."";
                            }                        
                            echo $result; 
                        ?>
                    </ul>
                </td>
                <td><?php $this->renderPartial('/riwayatPasien/_konsulpoli', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id)); ?></td>
                <td><?php //$this->renderPartial('/riwayatPasien/_tindakan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                <center>    <?php //if (count($modKunjungan->tindakanpelayanan->daftartindakan_id) != 0){
                    echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailTindakan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Tindakan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Tindakan")); 
                    
                    //        }?></center>
                </td>
                <td><?php //$this->renderPartial('/riwayatPasien/_terapi', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                      <center>  <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailTerapi",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Detail Pelayanan Obat dan Alat Kesehatan")) ?>
                      </center>
                      </td>
                <td><?php //$this->renderPartial('/riwayatPasien/_pemakaianBahan', array('pendaftaran_id'=>$modKunjungan->pendaftaran_id, 'pasien_id'=>$modKunjungan->pasien_id)); ?>
                  <center>  <?php echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl("riwayatPasien/detailPemakaianBahan",
                            array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Terapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Data Detail Pemakaian Bahan")) ?>
                </center>
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

   
