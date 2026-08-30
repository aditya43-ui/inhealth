<style>
	.conten td{
		padding-bottom: 5px;
	}
</style>
<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
//if(!empty($_GET['pendaftaran_id'])){
//    $pendaftaran_id = $_GET["pendaftaran_id"];
//    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
//    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
//	$modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
//    
//}else{
//    $model->tglsurat = date('Y-m-d');
//}

//if(!empty($_GET['suratketerangan_id'])){
//    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
//}
?>
<?php // $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
		/*font-style: oblique;*/
		font-weight: bold;
    }
	.allcontent{
		/*font-style: oblique;*/
		font-weight: bold;
                font-size: 10pt;
	}
	
	table td{
		/*font-style: oblique;*/
		font-weight: bold;
	}
        .table-indent{
            border: 1px solid rgb(148, 148, 148);
        }
        .datapasien{
            color: black;
        }
</style>

<div class="allcontent">
<table style="width:100%;">
    <tr>
        <td style="width:50%; border-bottom: 3px solid #000;">
            <table style="width:100%;">
                <tr>
                    <td width="150">
                        <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 80px; width:80px;" class='image_report'/>
                    </td>
                    <td align="center">
                        <div>
                            <B><span FACE="Liberation Serif" SIZE=5 color="black"><?php echo $data->nama_rumahsakit ?></span></B>
                        </div>
                        <div>
                            <span FACE="Liberation Serif" color="black"><?php echo $data->alamatlokasi_rumahsakit ?></span>
                        </div>
                        <div>
                            <span FACE="Liberation Serif" color="black">Telp./Fax. <?php echo $data->no_telp_profilrs ?> / <?php echo $data->no_faksimili ?></span>
                        </div>
                    </td>
                    <td width="150">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="width:20%;">
            &nbsp;
        </td>
        <td style="width:30%;">
            <table style="width:100%;" class="table-indent">
                <tr>
                    <td style="width: 150px">Nama Lengkap</td>
                    <td style="width: 5px">: </td>
                    <td>
                        <?php echo $modPasien->nama_pasien; ?>
                    </td>
                </tr>
                 <tr>
                    <td style="width: 150px">Tgl. Lahir</td>
                    <td style="width: 5px">: </td>
                    <td>
                        <?php echo $format->formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                    </td>
                </tr>
                 <tr>
                    <td style="width: 150px">No. RM</td>
                    <td style="width: 5px">: </td>
                    <td>
                         <?php echo $modPasien->no_rekam_medik; ?>
                    </td>
                </tr>
            </table> 
        </td>
    </tr>
    
</table>
<br><br>
<div class="datapasien">
<table style="width:100%;">
     <tr>
        <td style="width:90%;" colspan="3" ALIGN=CENTER VALIGN=MIDDLE>
           <span FACE="Liberation Serif" color="black" SIZE=4>INDENTIFIKASI BAYI</span>
        </td>
        <td style="width:10%;" colspan="3" ALIGN=RIGHT VALIGN=MIDDLE>
           <span FACE="Liberation Serif" color="black" SIZE=4>RM 05 K</span>
        </td>
    </tr>
</table>
<table style="width:100%;" border="1">
    <tr>
        <td>
            Diisi Oleh Keperawatan
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;">
                <tr>
                    <td style="width:100px;">
                       Nama Bayi
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td style="width: 600px">
                        <?php echo $model->namabayi; ?>
                    </td>
                    <td style="width:100px;">
                       Jenis Kelamin
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                       <?php echo $model->jeniskelamin; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:100px;">
                       Nama Ibu
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                        <?php echo $modPasien->nama_pasien; ?>
                    </td>
                    <td style="width:100px;">
                       No. RM Ibu
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                        <?php echo $modPasien->no_rekam_medik; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:100px;">
                       Nama Ayah
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                        .................
                    </td>
                </tr>
                <tr>
                    <td style="width:100px;">
                       Bayi Lahir
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                        <?php
                            $jkHD = '';
                            $jkMT = '';
                            if (!empty($modPersalinan->keadaanlahir)){
                                if ($modPersalinan->keadaanlahir == "Lahir Hidup"){
                                    $jkMT = 'line-words';
                                }else{
                                    $jkHD = 'line-words';
                                }
                            }
                        ?>
                        <span class='<?php echo $jkHD ?>'>Hidup</span>
                            /
                        <span class='<?php echo $jkMT ?>'>Mati</span>
                        &nbsp&nbsp;
                        Tanggal &nbsp;: &nbsp;  <?php echo $format->formatDateTimeForUser(date('d-M-Y', strtotime($model->tgllahirbayi))); ?>
                    </td>
                    <td style="width:30px;">
                       Jam
                    </td>
                    <td style="width:5px;">
                       : 
                    </td>
                    <td>
                        <?php echo $model->jamlahir; ?>
                    </td>
                     
                </tr>
            </table>
             <br>
        </td>
    </tr>
    <tr>
        <td align="center">
             <div>
                <B><span SIZE=2 color="black">TANDA TANGAN DAN NAMA TERANG</span></B>
                <br>
                <B><span SIZE=2 color="black">Pemberi Peneng / Gelang Bayi (No. RM dan Nama Bayi)</span></B>
                <br><br><br><br><br><br>
                <span SIZE=2 color="black">............................................</span>
            </div>
             <br>
        </td>
    </tr>
    <tr>
        <td align="center">
            Diisi Oleh Kamar Bersalin
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;">
                <tr>
                    <td style="width:30%; border-right: 1px solid #000" align="center">
                       IBU
                    </td> 
                    <td align="center">
                        BAYI
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;">
                <tr>
                    <td style="width:30%; border-right: 1px solid #000" align="center">
                        <table style="width:100%; text-align: center">
                            <tr>
                                <td>
                                    <B><span SIZE=2 color="black">Cap Ibu Jari Tangan Kanan</span></B>
                                    <br><br><br><br><br><br><br><br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td> 
                    <td style="width:70%;" align="center">
                       <table style="width:100%; text-align: center">
                            <tr>
                                <td style="width:50%; border-right: 1px solid #000">
                                    <B><span SIZE=2 color="black">Cap Telapak Kaki Kiri</span></B>
                                    <br><br><br><br><br><br><br><br><br><br><br>
                                </td>
                                <td style="width:50%;">
                                    <B><span SIZE=2 color="black">Cap Telapak Kaki Kanan</span></B>
                                     <br><br><br><br><br><br><br><br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td> 
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
             <div>
                <B><span SIZE=2 color="black">TANDA TANGAN DAN NAMA TERANG</span></B>
                <br>
                <B><span SIZE=2 color="black">Penentu Jenis Kelamin Bayi (Dokter / Bidan / Perawat)</span></B>
                <br><br><br><br><br><br>
                <span SIZE=2 color="black">............................................</span>
            </div>
             <br>
        </td>
    </tr>
    <tr>
        <td>
             <br>
            <table style="width:100%;">
                <tr>
                    <td>
                        <table style="width:100%;">
                            <tr>
                                <td>
                                    <div style="width: 80%; float: left">Sewaktu Pulang</div><div>Tanggal : <?php echo date('d M Y'); ?></div> 
                        Saya menyatakan bahwa pada saat saya pulang telah menerima bayi saya, memeriksanya dan meyakinkan bahwa bayi<br>
                        tersebut adalah betul- betul anak saya.<br>
                         Saya mengecek nomor dan nama pada peneng / gelang / pengenalnya adalah ................................<br>
                         dan berisi keterangan pengenal yang sesuai.
                         <br><br><br><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%;">
                             <tr>
                    <td style="width: 50%" align="center">
                        <!--<div style="padding-left: 50px">-->
                        Tanda Tangan dan Nama Terang <br>
                        Saksi : Bidan / Perawat
                         <br> <br> <br> <br> <br> <br> <br>
                         ............................................
                         <!--</div>-->
                    </td>
                    <td style="width: 50%" align="center">
                        <!--<div style="padding-left: 50px">-->
                        Tanda Tangan dan Nama Terang <br>
                        Ibu
                         <br> <br> <br> <br> <br> <br> <br>
                         ............................................
                         <!--</div>-->
                    </td>
                </tr>
                        </table>
                    </td>
                </tr>
                    
            </table>
        </td>
    </tr>
</table>
    </div>
   </div>