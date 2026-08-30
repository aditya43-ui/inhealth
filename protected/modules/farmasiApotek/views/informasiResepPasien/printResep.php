<style>
    table td {
        vertical-align: top;
    }
    .iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 3px;
		background: #ffffff;
		color: #000000;
		text-align: center;
		width:  15%;
		margin-left: 85%;
	} 
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
    }
</style>

<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'colspan'=>10)); 


 $style = 'margin-left:auto; margin-right:auto;';
    if (isset($caraPrint)){
        if ($caraPrint == "EXCEL")
            $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
    } else{
        $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
    }
    
?>
<?php

if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<table width="100%">
    <tbody>
        <tr>
            <td></td>
            <td align="right" width="50%"><font color="black" face="Liberation Serif">FR01R.19</font> </td>
        </tr>
    </tbody>
</table>
<table width="100%" border="1">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <br>
                <!-- <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br> -->
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b><br>
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font><br>
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
            <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <br>
                <font size="3" color="black" face="Liberation Serif">Nama Pasien : <?php echo $nama_pasien;?> <?php if($modPendaftaran->pasien->jeniskelamin == "Laki-Laki"){
                    echo "(L)";
                }else{
                    echo "(P)";
                } ?></font><br>
                <font size="3" color="black" face="Liberation Serif">TTL  : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font><br>
                <font size="3" color="black" face="Liberation Serif">No RM / No Reg : <?php echo $modPendaftaran->pasien->no_rekam_medik." / ".$modPendaftaran->no_pendaftaran;?></font>
            </td>
        </tr>
         <!-- <tr>
            <!-- <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif"><?php //echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>
            </td> -->
            <!-- <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <b><font size="3" color="black" face="Liberation Serif">Tgl. Lahir / Umur : <?php //echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)." / ". $modPendaftaran->umur;?></font></b><br>
            </td>
        </tr>
         <tr> -->
            <!-- <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif">Telp. <?php //echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php //echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td> -->
            <!-- <td valign="MIDDLE" align="LEFT" colspan=" 9">
                <b><font size="3" color="black" face="Liberation Serif">No RM : <?php //echo $modPendaftaran->pasien->no_rekam_medik;?></font></b><br>
            </td>
        </tr> -->
         <!-- <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><font color="black"><h3></h3></font></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>   -->
</tbody>
</table>

<?php

if (!empty($modPendaftaran)) {
    $nomor_pendaftaran = $modPendaftaran->no_pendaftaran;
    $nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $umur = $modPendaftaran->umur;
    $alamat = $modPendaftaran->pasien->alamat_pasien;

} else if (!empty($modPenjualan->pasienpegawai_id)) {
    $pegpas = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
    if (!empty($pegpas)) {
        $nomor_pendaftaran = "-";
        $nama_pasien = $pegpas->namaLengkap;
        $alamat = $pegpas->alamat_pegawai;
        $umur = CustomFunction::hitungUmur($pegpas->tgl_lahirpegawai, $modPenjualan->tglpenjualan);
    } else {
        $nomor_pendaftaran = "-";
        $nama_pasien = "-";
        $umur = "-";
        $alamat = "-";
    }
} else {
    $nomor_pendaftaran = "-";
    $nama_pasien = "-";
    $umur = "-";
    $alamat = "-";

}

?>
<table width="100%" border="1px solid black" cellspacing="">
    <tr>
        <th rowspan="12" width="50%"> Bismillahirrahmanirrahim<br><br>
            <?php foreach($kerangkaLooping as $i => $detail){ ?>
        <?php
            $criteriitem=new CDbCriteria;
            $criteriitem->addCondition("penjualanresep_id = ". $detail->penjualanresep_id);
            $criteriitem->addCondition("racikan_id = ". $detail->racikan_id);
            if($detail->rke == null){

            }else{
                $criteriitem->addCondition("rke = ". $detail->rke);
            }
            $items = ObatalkespasienT::model()->findAll($criteriitem);
        ?>
        <?php foreach($items as $ii => $item){ ?>
            <?php if($item->racikan_id == Params::RACIKAN_ID_NONRACIKAN){ ?>
                <table width="50%">
                    <tbody>
                        <tr>
                            <td width='20%'>R/ <?php //echo $detail->rke; ?></td>
                            <td width='100%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                            <td width='25%'>No </td>
                            <td width='25%'><?php echo CustomFunction::Romawi($item->qty_oa); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><?php echo $item->signa_oa; ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php }else{ ?>
                <table width="50%">
                    <tbody>
                        <tr>
                            <td width='10%'>R/ <?php //echo $detail->rke; ?></td>
                            <td width='50%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                            <td width='25%'> </td>
                            <td width='25%'></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php echo !empty($item->signa_reseptur) ? $item->signa_reseptur : "-"; ?></td>
                            <td><?php echo !empty($item->satuansediaan) ? $item->satuansediaan : "-"; ?></td>
                            <td><?php echo CustomFunction::Romawi($item->qty_oa); ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
        <?php } ?>
    <fieldset class='iter'>
        <legend>Iter <?php echo "0"; ?></legend>
        <legend></legend>
        <legend></legend>
        <legend></legend>
    </fieldset>
    <br/><br/>
    <?php } ?>
    <b><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <font size="2" color="black" face="Liberation Serif">"Dan apabila aku sakit, Dia-lah yang menyembuhkanku"</font></b><br>
        <font size="2" face="Liberation Serif">(QS. As-Syu'ara'26:80)</font>
    </th>
    <!-- <tr> -->
        <td colspan="4" align="left">Berat Badan :</td>
    </tr>
    <tr>
        <td colspan="4" align="left">Ruangan : <?php echo $modPenjualan->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Dokter. : <?php echo empty($modPenjualan->pegawai) ? "-" : $modPenjualan->pegawai->namaLengkap; ?> <br> Sip : <?php echo !empty($modPenjualan->pegawai->suratizinpraktek) ? $modPenjualan->pegawai->suratizinpraktek : "-"; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">Tgl. : <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center" >Riwayat Alergi Obat <br><br></td>
    </tr>
    <tr>
        <td width="13%">
            Penelaah Resep : 
        </td>
        <td colspan="4">
            <?php $look_data = LookupM::getItemsUrutan('penelaahresep');
            
            $coba = $modPenjualan->kiepenyerahan;
            $coba = CJSON::decode($coba);
            if(is_array($coba)){
                foreach ($look_data as $item):  ?>
                    <font class="<?php echo ((in_array(str_replace(' ', '', $item), $coba))?"fa fa-check-square-o":"fa fa-square-o"); ?>">
                        <?php echo $item?>
                    </font><br>
                <?php endforeach;
            }else{
                foreach ($look_data as $item):  ?>
                    <font class="fa fa-square-o">
                        <?php echo $item?>
                    </font><br>
                <?php endforeach;
            }
            // var_dump($coba);die;
             ?>
        </tr>
    </tr>
    <tr>
        <td>
            Penelaahan Obat : 
        </td>
       <td colspan="4">
       <?php 
       
    //    $look_data = LookupM::getItemsUrutan('penelaahobat');

       $look_data =  ['Benar Pasien' => 'Benar Pasien', 'Benar Obat' => 'Benar Obat', 'Benar Dosis' => 'Benar Dosis',
                            'Benar Rute' => 'Benar Rute', 'Benar Waktu' => 'Benar Waktu'];


        $coba = $modPenjualan->penelaahanobat;
        $coba = CJSON::decode($coba);
        if(is_array($coba)){
            foreach ($look_data as $item):  ?>
                <?php
                
                // echo '<pre>'; var_dump($item, $coba); die;

                ?>
                <font class="<?php echo ((in_array($item, $coba))?"fa fa-check-square-o":"fa fa-square-o"); ?>">
                    <?php echo $item; ?>
                </font><br>
            <?php endforeach; 
        }else{
            foreach ($look_data as $item):  ?>
                <font class="fa fa-square-o">
                    <?php echo $item; ?>
                </font><br>
            <?php endforeach; 
        }
        ?>
       </td>   
    </tr>
    <tr>
        <td width="13%">
            Penyerahan Obat + KIE : 
        </td>
        <td colspan="4">
            <?php 
            
            $look_data = LookupM::getItemsUrutan('penelaahresep');

            $look_data =  ['Nama dan Bentuk Obat' => 'Nama dan Bentuk Obat', 'Tujuan Penyerahan Obat' => 'Tujuan Penyerahan Obat',
                             'Dosis Obat' => 'Dosis Obat', 
                            'Cara Menyimpan Obat' => 'Cara Menyimpan Obat', 'Cara Menggunakan Obat' => 'Cara Menggunakan Obat', 'Efek Samping Obat' => 'Efek Samping Obat',
                            'Lama Penggunaan Obat' => 'Lama Penggunaan Obat', 'Langkah Jika Terjadi ESO' => 'Langkah Jika Terjadi ESO'];
            
            $coba = $modPenjualan->kiepenyerahan;
            $coba = CJSON::decode($coba);
            if(is_array($coba)){
                foreach ($look_data as $item):  ?>
                    <font class="<?php echo ((in_array($item, $coba))?"fa fa-check-square-o":"fa fa-square-o"); ?>">
                        <?php echo $item?>
                    </font><br>
                <?php endforeach;
            }else{
                foreach ($look_data as $item):  ?>
                    <font class="fa fa-square-o">
                        <?php echo $item?>
                    </font><br>
                <?php endforeach;
            }
            // var_dump($coba);die;
             ?>
        </tr>
    </tr>
    
    <tr>
        <td align="center">Hargai</td>
        <td align="center">Teknik</td>
        <td align="center">Kemas</td>
        <td align="center">Penyerahan</td>
    </tr>
    <tr>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->harga_id) ; echo !empty($data->nama_pegawai) ? $data->nama_pegawai : "" ; ?><br></td>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->teknik_id) ; echo !empty($data->nama_pegawai) ? $data->nama_pegawai : "" ; ?></td>
        <td align="center"><?php $data = PegawaiM::model()->findByPk($modPenjualan->kemas_id) ; echo !empty($data->nama_pegawai) ? $data->nama_pegawai : "" ; ?></td>
        <td align="center"><?php echo !empty($modPenjualan->namaygmenyerahkan) ? $modPenjualan->namaygmenyerahkan : ""; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">Menerima Obat Beserta Informasi</td>
        
    </tr>
    <tr>
        <td style="border: 1px solid;" colspan="4" align="left"><?php $url_photopasien = (!empty($modPenjualan->fotopenyerahanobat) ? $modPenjualan->fotopenyerahanobat : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
        <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;"><?php echo CHtml::image($modPenjualan->ttdpenyerahan, null, array('width' => 150)); ?></td>
        
    </tr>
</table>
<table width="100%" border="1px solid black">
    <tr>
        <td colspan="4" align="center">Perubahan Resep</td>
        <td width="25%" rowspan="2" align="center">Petugas Farmasi</td>
        <td width="25%" rowspan="2" align="center">Disetujui</td>
    </tr>
    <tr>
        <td align="center">Tertulis</td>
        <td align="center">Menjadi</td>
    </tr>
</table>
<table width="100%" border="1px solid black">
    <tr>
        <td><br><br></td>
        <td></td>
        <td><br></td>
        <td></td>
    </tr>
</table>
<!-- <table width="80%" <?php //echo $style; ?>>
    <tr>
        <td nowrap></td>
        <td></td>
        <td width="100%"><?php //echo $nomor_pendaftaran; ?></td>
        
        <td colspan="3">Berat Badan :</td>
        <!-- <td>:</td> -->
        <!-- <td nowrap> <?php //echo $modPenjualan->noresep; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td> <?php //echo $nama_pasien; ?></td>
        
        <td nowrap>Dokter</td>
        <td>:</td>
        <td nowrap> <?php //echo empty($modPenjualan->pegawai) ? "-" : $modPenjualan->pegawai->namaLengkap; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td> <?php //echo $umur; ?></td>
        
        <td>Tanggal Resep</td>
        <td>: </td>
        <td nowrap><?php //echo $modPenjualan->tglpenjualan; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td> <?php //echo $alamat; ?></td>
        
        <td>Ruangan</td>
        <td>:</td>
        <td nowrap> <?php //echo $modPenjualan->ruanganasal_nama; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Jenis Penjamin</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php //echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Penjamin</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php //echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
</table> -->
<br/><br/><br/><br/>

<style>
	.iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 3px;
		background: #ffffff;
		color: #000000;
		text-align: center;
		width:  15%;
		margin-left: 85%;
	} 
</style>
<!-- 
<table width="50%">
    <tr>
        <td width="50%">
        <?php //$url_photopasien = (!empty($modPenjualan->fotopenyerahanobat) ? $modPenjualan->fotopenyerahanobat : Params::urlAmbilObatDirectory() . "no_photo.jpeg"); ?>
        <img id="photo-preview" src="<?php //echo $url_photopasien ?>" style="width: 160px;"><br>
        </td>
        <td>Diserahkan Oleh:<br/><?php //echo $modPenjualan->namaygmenyerahkan; ?></td>
    </tr>
</table> -->