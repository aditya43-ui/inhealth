<style>
    .info{
        font-size: 11px;
        font-family: tahoma;
    }
    
    .grid{
        border-collapse: collapse;
        font-size: 11px;
        font-family: tahoma;
        border:1px solid #000;
    }
    .grid td,th{
        padding: 5px;
    }    
</style>
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judul'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
        $border = 0; 
    }else{
        $border = 1; 
    }
}
?>

<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan)); ?>
<?php
    $a = 0;
    $subsidiasuransi_tindakan = 0;
    $subsidirumahsakit_tindakan  = 0;
    $iurbiaya_tindakan   = 0;
    $data['uang_cicilan'] = 0;
    $jumlahuangmuka = 0;
    $pendaftaran_id = (isset($pendaftaran_id) ? $pendaftaran_id : $modPendaftaran->pendaftaran_id);
    $format = new MyFormatter();
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $pendaftaran_id     = $dataPendaftar->pendaftaran_id;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $nama_pendaftaran   = $dataPendaftar->NamaPasienPendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $umur               = substr($dataPendaftar->umur,0,7);
        $alamat             = $dataPendaftar->AlamatPasienPendaftar;
        $instalasi_nama     = $dataPendaftar->instalasi_nama;
        $dokter_pemeriksa   = $dataPendaftar->DokterPemeriksa;
        $kelaspelayanan     = $dataPendaftar->kelaspelayanan_nama;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $nama_pj            = $dataPendaftar->nama_pj;
        $alamat_pjp         = $dataPendaftar->alamat_pj;
        $kasus_penyakit     = $dataPendaftar->jeniskasuspenyakit_nama;
        $caramasuk_nama     = $dataPendaftar->caramasuk_nama;
        $carakeluar         = $dataPendaftar->carakeluar; 
        $kondisi            = $dataPendaftar->kondisipulang;
        $tglrenkontrol      = $dataPendaftar->tglrenkontrol;
        $tgl_pendaftaran    = $dataPendaftar->tgl_pendaftaran; 
        $tgl_pulang         = $dataPendaftar->tglpasienpulang; 
        $lamarawat          = $dataPendaftar->lamarawat;
        $ruangan_akhir      = $dataPendaftar->ruanganakhir_nama;
        $jumlahuangmuka     = $dataPendaftar->jumlahuangmuka;

        $tarif_satuan[$key] = $dataPendaftar->tarif_satuan;
        $qty_tindakan[$key] = $dataPendaftar->qty_tindakan;
        $kelastindakan_nama[$key]   = $dataPendaftar->kelastindakan_nama;
        $subtotal[$key]     = $tarif_satuan[$key]*$qty_tindakan[$key];
        $daftartindakan_nama[$key]  = $dataPendaftar->daftartindakan_nama;
        $ruangantindakan_nama[$key] = $dataPendaftar->ruangantindakan_nama;
        $tgl_tindakan[$key] = $dataPendaftar->tgl_tindakan;
        $dokter_tindakan[$key]      = null;

        $subsidiasuransi_tindakan   += $dataPendaftar->subsidiasuransi_tindakan;
        $subsidirumahsakit_tindakan += $dataPendaftar->subsisidirumahsakit_tindakan;
        $iurbiaya_tindakan += $dataPendaftar->iurbiaya_tindakan;
        $a++;
    }

    $tgl_renkontrol = (isset($tglrenkontrol) ? $format->formatDateTimeId($tglrenkontrol) : null);
    $tgl_daftar = (isset($tgl_pendaftaran) ? $format->formatDateTimeId($tgl_pendaftaran) : null);
    $tgl_pulang = (isset($tgl_pulang) ? $format->formatDateTimeId($tgl_pulang) : null);
?>

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td width="50%">
            <label class='control-label'>
                No. RM / No. Pend :
          </label>
                <?php echo CHtml::encode((isset($no_rekam_medik) ? $no_rekam_medik : $modPasien->no_rekam_medik)); ?> / 
                <?php echo CHtml::encode((isset($no_pendaftaran) ? $no_pendaftaran : $modPendaftaran->no_pendaftaran)); ?>
        </td>
        <Td width="2%"></td>
        <td width="48%">
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
                Tanggal Daftar / Tanggal Admisi:
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
                <?php echo CHtml::encode((isset($nama_pj) ? $nama_pj : (isset($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : ""))); ?>
        </td>
    </tr>
    <tr>
        <td>   
            <label class='control-label'>
                Alamat Pasien:
          </label>
                <?php echo CHtml::encode((isset($alamat) ? $alamat : $modPasien->alamat_pasien )); ?>
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Alamat PJP :
          </label>
            <?php
                echo CHtml::encode((isset($alamat_pjp) ? $alamat_pjp : (isset($modPendaftaran->penanggungJawab->alamat_pj) ? $modPendaftaran->penanggungJawab->alamat_pj : "")));
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Unit Pelayanan :</label>
            <?php echo CHtml::encode((isset($instalasi_nama) ? $instalasi_nama : $modPendaftaran->instalasi->instalasi_nama)); ?>
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Cara Masuk :
          </label>
            <?php
               echo CHtml::encode((isset($caramasuk_nama) ? $caramasuk_nama : $modPasienAdmisi->caramasuk->caramasuk_nama));
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Dokter Pemeriksa :</label>
            <?php echo CHtml::encode((isset($dokter_pemeriksa) ? $dokter_pemeriksa : $modPasienAdmisi->pegawai->pegawai_nama )); ?>                        
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Cara Keluar / Kondisi :
          </label>
            <?php
                echo CHtml::encode((isset($carakeluar) ? $carakeluar : "")).' / '.CHtml::encode((isset($kondisi) ? $kondisi : "" )); 
                ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Kelas Pelayanan :</label>
            <?php
                echo CHtml::encode((isset($kelaspelayanan) ? $kelaspelayanan : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama ));
            ?>                      
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Tanggal Pulang :
          </label>
            <?php
                echo CHtml::encode((isset($tgl_pulang) ? $tgl_pulang : $modPasienAdmisi->tglpulang ));
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'>Kasus Penyakit :</label>
            <?php
               echo CHtml::encode((isset($kasus_penyakit) ? $kasus_penyakit : $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama));
            ?>                     
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Lama Rawat :
          </label>
            <?php
                echo CHtml::encode((isset($lamarawat) ? $lamarawat : "")).' hari';
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label class='control-label'></label>
        </td>
        <Td></td>
        <td>   
            <label class='control-label'>
                Ruangan Terakhir :
          </label>
            <?php
                echo CHtml::encode((isset($ruangan_akhir) ? $ruangan_akhir : $modPasienAdmisi->ruangan->ruangan_nama ));
            ?>
        </td>
    </tr>
</table>      
<br>
<div align="center" style="text-align: center;">
    <p style="margin: 0; text-align: center;"><?php echo strtoupper($data['judulPrint']); ?></p>
</div>
    
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid">
    <thead>
        <tr>
            <th width="15%">Ruangan / Unit</th>
            <th align="center">Uraian</th>
            <th width="15%">Kelas</th>
            <th width="15%" align="right">Harga (Rp)</th>
            <th width="15%" align="center">Banyak</th>
            <th width="12%" align="right">Total (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php
                    $cols = '';
                    $jumlahuangmuka = 0;
                    $total_biaya = 0;
                    $sub_total = 0;
                    $total = 0;
                    $tampilAdminFarmasi = true;
                    $tempAdminFarmasi = 0;
                    $subsidiAsuransi = $subsidiasuransi_tindakan;
                    $subsidiRumahSakit = $subsidirumahsakit_tindakan; 
                    $iurBiaya = $iurbiaya_tindakan; 
                    $group_ruangan[0] = '';
                    foreach ($modRincian as $index => $data) {
                        $group_ruangan[] = (isset($ruangantindakan_nama[$index]) ? $ruangantindakan_nama[$index] : '');
                        $group = $index;
                        if($group_ruangan[$group]!=$ruangantindakan_nama[$index])
                        {
                            $group_ruangan[$index] = $ruangantindakan_nama[$index];
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
                            <td>".$daftartindakan_nama[$index]."<br>(".$dokter_tindakan[$index].")</td>
                            <td>".$kelastindakan_nama[$index]."</td>
                            <td><div class='pull-right'>".number_format($tarif_satuan[$index])."</div></td>
                            <td class='tengah'>".$qty_tindakan[$index]."</td>
                            <td><div class='pull-right'>".number_format($subtotal[$index])."</div></td>    
                        </tr>";
                        $index_subtotal = $index;
                        if($ruangantindakan_nama[$index]!=$ruangantindakan_nama[$index_subtotal])
                        {
                            $sub_total += $subtotal[$index];
                            echo"
                            <tr>
                                <td colspan=5>Grand Sub Total</td>
                                <td><div class='pull-right'>".number_format($sub_total)."</div></td>
                            </tr>
                            ";
                            $sub_total = 0;
                        }else{
                            $sub_total += $subtotal[$index];
                        }

                        $total += $subtotal[$index];
                    }
                    // yg for untuk sementara di comment dulu karena code nya kurang di pahami
//                    for ($i=0; $i < $a ; $i++) { 
//                        $key = $i;
//                        $group = $key - 1;
//
//                        if($group_ruangan[$group]!=$ruangantindakan_nama[$key])
//                        {
//                            $group_ruangan[$key] = $ruangantindakan_nama[$key];
//                            echo"
//                            <tr>
//                                <td colspan=6><b>".$ruangantindakan_nama[$key]."</b></td>
//                            </tr>";
//
//                        }else{
//                            $group_ruangan[$key] = $group_ruangan[$group];
//                        }
//                        echo "
//                        <tr>
//                            <td>".$format->formatDateTimeId($tgl_tindakan[$key])."</td>
//                            <td>".$daftartindakan_nama[$key]."<br>(".$dokter_tindakan[$key].")</td>
//                            <td>".$kelastindakan_nama[$key]."</td>
//                            <td><div class='pull-right'>".number_format($tarif_satuan[$key])."</div></td>
//                            <td>".$qty_tindakan[$key]."</td>
//                            <td><div class='pull-right'>".number_format($subtotal[$key])."</div></td>    
//                        </tr>";
//                        $index_subtotal = $key + 1;
//                        if($ruangantindakan_nama[$key]!=$ruangantindakan_nama[$index_subtotal])
//                        {
//                            $sub_total += $subtotal[$key];
//                            echo"
//                            <tr>
//                                <td colspan=5>Grand Sub Total</td>
//                                <td><div class='pull-right'>".number_format($sub_total)."</div></td>
//                            </tr>
//                            ";
//                            $sub_total = 0;
//                        }else{
//                            $sub_total += $subtotal[$key];
//                        }
//
//                        $total += $subtotal[$key];
//                    }

                ?>
    </tbody>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td colspan='2'><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></td>
        <td colspan='3' align='right'>Total Biaya :</td>
        <td align='right'><?php echo number_format($total,0,'','.'); ?></td>
    </tr>
    <tr>
        <td colspan='2'>Petugas</td>
        <td colspan='3' align='right'>Tanggungan Asuransi :</td>
        <td align='right'><?php echo number_format($subsidiAsuransi,0,'','.'); ?></td>
    </tr>
    <tr>
        <td colspan='2'></td>
        <td colspan='3' align='right'>Tanggungan Rumah Sakit :</td>
        <td align='right'><?php echo number_format($subsidiRumahSakit,0,'','.'); ?></td>
    </tr>
    <tr>
        <td colspan='2'></td>
        <td colspan='3' align='right'>Tanggungan Pasien :</td>
        <td align='right'>
            <?php                 
                $kembalian = ($total_biaya - $subsidiAsuransi - $subsidiRumahSakit);
//                if($data['uang_cicilan'] > 0){
//                    if($data['uang_cicilan'] < $total_biaya)
//                    {
//                        $kembalian = $kembalian - $data['uang_cicilan'];
//                    }                                            
//                }
                echo number_format($iurBiaya,0,'','.');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan='2'><?php echo $data['nama_pegawai']; ?></td>
        <td colspan='3' align='right'>Uang Muka Pasien :</td>
        <td align='right'><?php echo number_format($jumlahuangmuka,0,'','.'); ?></td>
    </tr>
</table>

<script type="text/javascript">

    function insertCetakan()
    {
        var params = {pendaftaran_id:'<?php echo $pendaftaran_id ?>'};
        
        $.post("<?php echo Yii::app()->createUrl('ActionAjax/updateJumlahCetakan');?>", {id:params},
            function(data)
            {
                if(data.status == 'not')
                {
                    console.log('insert cetakan data error');
                }else{
                    $('#cetakan_jum').text('Cetakan Ke ' + data.jumlah);
                }
            }, "json"
        );
    }
    insertCetakan();

</script>