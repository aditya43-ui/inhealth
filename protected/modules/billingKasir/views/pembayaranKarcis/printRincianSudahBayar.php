<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>

<?php
    $a = 0;
    $tgl_pendaftaran = null;
    $no_rekam_medik = null;
    $no_pendaftaran = null;
    $carabayarPenjamin = null;
    $nama_pendaftaran = null;
    $umur = null;
    $jeniskelamin = null;
    $nama_pj = null;
    $alamat = null;
    $alamat_pjp = null;
    $instalasi_nama = null;
    $kasus_penyakit = null;
    $dokter_pemeriksa = null;
    $namaperujuk = null;
    $kelaspelayanan = null;
    $tglrenkontrol = null;    
    $subsidiasuransi_tindakan  = 0;
    $subsidirumahsakit_tindakan  = 0;
    $iurbiaya_tindakan  = 0;
    $total  = 0;
    $pendaftaran_id  = null;
    
    $format = new MyFormatter();
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $pendaftaran_id     = $dataPendaftar->pendaftaran_id;
        $nama_pendaftaran   = $dataPendaftar->NamaPasienPendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $umur               = substr($dataPendaftar->umur,0,7);
        $alamat             = $dataPendaftar->AlamatPasienPendaftar;
        $instalasi_nama     = $dataPendaftar->instalasi_nama;
        $dokter_pemeriksa   = $dataPendaftar->DokterPemeriksa;
        $kelaspelayanan     = $dataPendaftar->kelaspelayanan_nama;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $nama_pj            = (isset($dataPendaftar->nama_pj) ? $dataPendaftar->nama_pj : "-");
        $alamat_pjp         = (isset($dataPendaftar->alamat_pj) ? $dataPendaftar->alamat_pj : "-");
        $kasus_penyakit     = $dataPendaftar->jeniskasuspenyakit_nama;
        $namaperujuk        = (isset($dataPendaftar->namaperujuk) ? $dataPendaftar->namaperujuk : "-"); //RincianbelumbayarrawatinapV.namaperujuk tidak didefinisikan
//        $tglrenkontrol      = $dataPendaftar->tglrenkontrol;
        $tgl_pendaftaran    = $dataPendaftar->tgl_pendaftaran;

        $tarif_satuan[$key] = $dataPendaftar->tarif_satuan;
        $qty_tindakan[$key] = $dataPendaftar->qty_tindakan;
        $kelastindakan_nama[$key]   = (isset($dataPendaftar->kelastindakan_nama)?$dataPendaftar->kelastindakan_nama : "-");
//        $kelastindakan_nama[$key]   = null;
        $subtotal[$key]     = $tarif_satuan[$key]*$qty_tindakan[$key];
        $daftartindakan_nama[$key]  = $dataPendaftar->daftartindakan_nama;
        $ruangantindakan_nama[$key] = (isset($dataPendaftar->ruangantindakan_nama)?$dataPendaftar->ruangantindakan_nama : "-");
//        $ruangantindakan_nama[$key] = null;
        $tgl_tindakan[$key] = $dataPendaftar->tgl_tindakan;
        $dokter_tindakan[$key]      = $dataPendaftar->DokterTindakan;

        $subsidiasuransi_tindakan   += $dataPendaftar->subsidiasuransi_tindakan;
        $subsidirumahsakit_tindakan += $dataPendaftar->subsisidirumahsakit_tindakan;
        $iurbiaya_tindakan += $dataPendaftar->iurbiaya_tindakan;
        $a++;
    }

    $tgl_daftar = $format->formatDateTimeId($tgl_pendaftaran);
?>

<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <label class='control-label'>
                            No. RM / No. Pend :
                      </label>
                            <?php echo CHtml::encode((isset($no_rekam_medik) ? $no_rekam_medik : $modPasien->no_rekam_medik)); ?> / 
                            <?php echo CHtml::encode((isset($no_pendaftaran) ? $no_pendaftaran : $modPendaftaran->no_pendaftaran)); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Jenis Penjamin / Penjamin :
                      </label>
                        <?php
                            echo CHtml::encode((isset($carabayarPenjamin) ? $carabayarPenjamin : $modPendaftaran->carabayar->carabayar_nama." / ".$modPendaftaran->penjamin->penjamin_nama));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Nama Pasien :
                      </label>
                        <?php echo CHtml::encode((isset($nama_pendaftaran) ? $nama_pendaftaran : $modPasien->nama_pasien)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Tgl. Pendaftaran:
                      </label>
                        <?php
                            echo CHtml::encode((isset($tgl_daftar) ? $tgl_daftar : $modPendaftaran->tgl_pendaftaran));   
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Umur / Jenis Kelamin :
                      </label>
                            <?php echo CHtml::encode((isset($umur) ? $umur : $modPendaftaran->umur)).' / '.CHtml::encode((isset($jeniskelamin) ? $jeniskelamin : $modPasien->jeniskelamin)); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama PJP :
                      </label>
                            <?php echo CHtml::encode((isset($nama_pj) ? $nama_pj : '')); ?>
                    </td>
                </tr>
                <tr>
                    <td>   
                        <label class='control-label'>
                            Alamat Pasien:
                      </label>
                            <?php echo CHtml::encode((isset($alamat) ? $alamat : isset($modPasien->alamat_pasien)?$modPasien->alamat_pasien:'' )); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                      </label>
                        <?php
                            echo CHtml::encode((isset($alamat_pjp) ? $alamat_pjp : ''));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Unit Pelayanan :</label>
                        <?php echo CHtml::encode((isset($instalasi_nama) ? $instalasi_nama : isset($modPendaftaran->instalasi->instalasi_nama)?$modPendaftaran->instalasi->instalasi_nama:'')); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Kasus Penyakit :
                      </label>
                        <?php
                           echo CHtml::encode((isset($kasus_penyakit) ? $kasus_penyakit : $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Dokter Pemeriksa :</label>
                        <?php echo CHtml::encode((isset($dokter_pemeriksa) ? $dokter_pemeriksa : $modPendaftaran->pegawai->pegawai_nama )); ?>                        
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama Perujuk :
                      </label>
                        <?php
                            echo CHtml::encode((isset($namaperujuk) ? $namaperujuk : (isset($modPendaftaran->rujukan->nama_perujuk) ? $modPendaftaran->rujukan->nama_perujuk : "")));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Kelas Pelayanan:</label>
                        <?php
                            echo CHtml::encode((isset($kelaspelayanan) ? $kelaspelayanan : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama ));
                        ?>                      
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Tgl. Rencana Kontrol :
                      </label>
                        <?php
                            echo CHtml::encode((isset($tglrenkontrol) ? $tglrenkontrol : $modPendaftaran->tglrenkontrol ));
                        ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <div align="center" style="border-bottom: 1px solid #000000;padding: 10px;margin-bottom: 15px;">
                <?php echo strtoupper($data['judulLaporan']);?>
            </div>
            <?php
                $totalbiayaadminfarmasi = 0;
                $row = array();
            ?>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Uraian</th>
                        <th>Kelas</th>
                        <th class="tengah">Harga (Rp)</th>
                        <th class="tengah">Banyak</th>
                        <th class="tengah">Total (Rp)</th>
                    </tr>
                </thead>
                <?php
                    $cols = '';
                    $total_biaya = 0;
                    $sub_total = 0;
                    $tampilAdminFarmasi = true;
                    $tempAdminFarmasi = 0;
                    $subsidiAsuransi = $subsidiasuransi_tindakan;
                    $subsidiRumahSakit = $subsidirumahsakit_tindakan;
                    $iurBiaya = $iurbiaya_tindakan;                    
                    
                    foreach ($modRincian as $index => $rincian) {
                        $group_ruangan[] = (isset($ruangantindakan_nama[$index]) ? $ruangantindakan_nama[$index] : '');
                        $group = $index;
                        if($group_ruangan[$group]!=$ruangantindakan_nama[$index])
                        {
                            $group_ruangan[$index] = $ruangantindakan_nama[$index+1];
                            echo"
                            <tr>
                                <td colspan=6><b>".$ruangantindakan_nama[$index]."</b></td>
                            </tr>";

                        }else{
                            $group_ruangan[$index] = $group_ruangan[$group];
                        }
                        echo "
                        <tr>
                            <td>".$format->formatDateTimeId($tgl_tindakan[$index])."</td>
                            <td>".$daftartindakan_nama[$key]."<br>(".$dokter_tindakan[$index].")</td>
                            <td>".$kelastindakan_nama[$key]."</td>
                            <td><div class='pull-right'>".number_format($tarif_satuan[$index],0,',','.')."</div></td>
                            <td class='tengah'>".$qty_tindakan[$index]."</td>
                            <td><div class='pull-right'>".number_format($subtotal[$index],0,',','.')."</div></td>    
                        </tr>";
                        $index_subtotal = $index;
                        if($ruangantindakan_nama[$index]!=$ruangantindakan_nama[$index_subtotal])
                        {
                            $sub_total += $subtotal[$index];
                            echo"
                            <tr>
                                <td colspan=5>Grand Sub Total</td>
                                <td><div class='pull-right'>".number_format($sub_total,0,',','.')."</div></td>
                            </tr>
                            ";
                            $sub_total = 0;
                        }else{
                            $sub_total += $subtotal[$index];
                        }

                        $total += $subtotal[$index];
                    }
                ?>
                 <tfoot>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Total Biaya</div></td>
                        <td style="text-align:right;"><?php echo number_format($total,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Asuransi</div></td>
                        <td style="text-align:right;"><?php echo number_format($subsidiAsuransi,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Tanggungan Rumah Sakit</div></td>
                        <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit,0,',','.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Pemakaian Uang Muka</div></td>
                        <td style="text-align:right;"><?php echo number_format((isset($modPemakaianuangmuka->pemakaian_uang_muka)?$modPemakaianuangmuka->pemakaian_uang_muka:0),0,',','.');?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Jumlah Pembayaran</div></td>
                        <td style="text-align:right;"><?php echo number_format($modPembayaran->totalbayartindakan,0,',','.');?></td>
                    </tr>
                    <tr>
                        <td colspan="5"><div class='pull-right'>Sisa Pembayaran</div></td>
                        <td style="text-align:right;"><?php echo number_format($modPembayaran->totalsisatagihan,0,',','.');?></td>
                    </tr>
                </tfoot>
                
            </table>
        </td>
    </tr>
</table>
