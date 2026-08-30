<?php
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
?>
<style>
    #font tr th {
        font-size: 12pt !important;
        font-family: Arial, Helvetica, sans-serif;
        /* padding: 5px; */
        /* margin-left: 10px;
        margin-right: 10px; */

    }

    #font2 {
        border: 1px solid black;
    }

    #font2 tr td p {
        font-size: 20px !important;
        text-align: justify;
        line-height: 2;
    }
    #font3 tr td p {
        font-size: 20px !important;
        text-align: justify;
        line-height: 1;
    }

    #font2 tr th {
        font-size: 20px !important;
    }

    #font2 tr td {
        font-size: 20px !important;
        font-family: Arial, Helvetica, sans-serif;
    }

    #font3 tr th {
        font-size: 20px !important;
    }

    .line {
        border: 1px solid black;
        margin-right: 15px;
        padding: 30px;
    }

    .line2 {
        border: 1px solid black;
        padding: 30px;
        margin-top: 10px;
    }

    .line2 p {
        font-size: 16px;
    }
        table{
            width: 100%;
        }
        .title td{
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            background: #309C5C;
        }
        .sub-judul {
            font-weight: bold;
        }

</style>
<!-- 
    <div class="grid-container">
        <div class="grid-item">
            TESSS 1
        </div>
        <div class="grid-item">
            KEDUAAA
        </div>
    </div> -->

 
<table style="width: 100%; border: none;" class="line no-border">
    <thead>
        <tr>
            <td>
                <div class="header"><br><br><br><br><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultReport', array());
                    ?></div>
            </td>
        </tr>
    </thead>
 
    <tbody>
      
        <table>
        <h2 align="center"><?php echo $judulLaporan; ?> </h2>
        <br><br><br>
        <tr>
                <td>No. Foto</td>
                <td>: <?php echo $model->hasilperiksa->hasildet->no_foto ?? ""; ?>
                <td>Tanggal Daftar</td>
                <td>: <?php 
                echo date('d-m-Y', strtotime($model->pendaftaran->tgl_pendaftaran)); 
                ?></td>
            </tr>
          
            <tr>
                <td>Nama Pasien</td>
                <td>: <?php   $pasien = strtolower($model->pasien->nama_pasien);
                echo ucwords($pasien); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:  <?php if($model->pasien->jeniskelamin == "LAKI-LAKI"){
            echo "Laki-Laki (L)";
          }else{
            echo "Perempuan (P)";
          }?></td>
                <td>No. Register</td>
                <td>: <?php echo $model->pendaftaran->no_pendaftaran ;
           ?></td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:
                <?php $umur = explode(" ", $model->pendaftaran->umur); 
                    
                    echo $umur[0].' tahun '.$umur[2].' bulan '.$umur[4].' hari ';
                    ?></td>
                <td>Dokter</td>
                <td>: <?php echo !empty($model->pasienadmisi->kamarruangan->kamarruangan_id) ? $model->pasienadmisi->kamarruangan->kamarruangan_id : "-" ; ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: <?php 
               echo date('d-m-Y', strtotime($model->pasien->tanggal_lahir)); 
                ?>
                <td>Ruang</td>
                <td>:  <?php echo $model->pendaftaran->ruangan->ruangan_nama; ?></td>
            </tr>
            <tr>
                <td>Organ Diperiksa</td>
                <td>: <?php echo $model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama." ".$model->pemeriksaanrad->pemeriksaanrad_nama; ?> </td>
                <td></td>
                <td></td>
            </tr>
            <tr><td></td>
                <td></td>
                <td></td>
                <td></td></tr>
            <tr>
                <td>Jawaban</td>
                <td>: </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        
        
        <!-- <div class="span12">
<table class="table noborder"> -->
        <!-- <tr>
        <th style="text-align:right;" colspan="3">TANGGAL : <?php //echo MyFormatter::formatDateTimeForUser($model->tglpegambilanhasilrad) ?></th>
    </tr> -->
        <!-- <tr>
        <th width="20%">No. Rekam Medik</th>
        <th width="2%">:</th>
        <th><?php //echo $model->pasien->no_rekam_medik ?></th>
    </tr>
    <tr>
        <th>Tanggal lahir</th>
        <th>:</th>
        <th><?php //echo MyFormatter::formatDateTimeForUser($model->pasien->tanggal_lahir); ?></th>
    </tr>
    <tr>
        <th width="30%">Tgl. Pemeriksaan</th>
        <th width="2%">:</th>
        <th><?php
        //echo MyFormatter::formatDateTimeForUser($model->tglpemeriksaanrad) ?></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
    </tr>    
</table>
</div> -->
<br>
        <div class="col-sm-6">
                <h3 style="margin-left: 5px; margin-bottom: 10px;">Foto <?php echo $model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama." ".$model->pemeriksaanrad->pemeriksaanrad_nama; ?></h3>
                <p style="margin-bottom:30px;">
                <?php echo !empty($model->pemeriksaanrad->jenispemeriksaanrad_id)?$model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama:'' ?>
                <?php echo !empty($model->pemeriksaanrad_id)?$model->pemeriksaanrad->pemeriksaanrad_nama:'' ?>, tampak :
                </p> 
                <p><?php echo trim($model->hasilexpertise) ?></p>
                <b><p>Kesimpulan:</p></b>
                <p>
                <?php echo trim($model->kesimpulan_hasilrad) ?>
                </p>
               
                </p>
        </div>
        <!-- <table class="table noborder" id="font2">
            <br>
            <tr>
                <td>
                    <h2 style="margin-left: 5px; margin-top: 60px; margin-bottom: 60px;">Teman sejawat yang terhormat,</h2> 
                </td>
                <td></td>
           </tr>
            <tr>
                <td width="20%">Pada Pemeriksaan
                    <?php echo !empty($model->pemeriksaanrad->jenispemeriksaanrad_id)?$model->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama:'' ?>
                    <?php echo !empty($model->pemeriksaanrad_id)?$model->pemeriksaanrad->pemeriksaanrad_nama:'' ?>, tampak :
                </td>
            </tr>
            <tr>
                <td>
                    <div class="hasilexp">
                        <p><?php echo trim($model->hasilexpertise) ?></p>
                    </div>
                </td>
                <td></td>

            </tr>
   
            <tr>
                <td style="line-height: 10px;">
                    <?php echo trim($model->kesimpulan_hasilrad) ?>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td width="70%"></td>
                <td nowrap>
                    <?php $date = date('Y-m-d'); ?>
                    <?php $kota = strtolower($data->kabupaten->kabupaten_nama);
                    echo ucwords($kota) ;?>,
                    <?php echo ucwords($format->formatDateTimeForUser($date)); ?><br>

                </td>

            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th width="70%"></th>
                <th style="text-align:center;"><?php 
                // $peg = PasienmasukpenunjangT::model()->findByPk($model->pasienmasukpenunjang_id);
                // $pegawai = PegawaiM::model()->findByPk($peg->pegawai_id);
                // echo $pegawai->namaLengkap;?></th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th style="text-align:center;">
                    <?php 
				//echo !empty($model->pasienmasukpenunjang->pegawai_id)?$model->pasienmasukpenunjang->pegawai->namaLengkap:'-'; 				
			?>
                </th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th style="text-align:center;">
                    <?php 				
				//echo "NIP. ".(!empty($model->pasienmasukpenunjang->pegawai_id)?$model->pasienmasukpenunjang->pegawai->nomorindukpegawai:'-');
			?>
                </th>
            </tr>
        </table> -->

        </div>
        </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<!-- <div class="footer">

    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div> -->
<?php
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>

<!--<script>
    window.print(); 
</script>-->