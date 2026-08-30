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
    
    $subsidiasuransi_tindakan   = 0;
    $subsidirumahsakit_tindakan = 0;
    $iurbiaya_tindakan = 0;
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
        $namaperujuk        = $dataPendaftar->namaperujuk;
        $tglrenkontrol      = $dataPendaftar->tglrenkontrol;
        $tgl_pendaftaran    = $dataPendaftar->tgl_pendaftaran;

        $tarif_satuan[$key] = $dataPendaftar->tarif_satuan;
        $qty_tindakan[$key] = $dataPendaftar->qty_tindakan;
        $kelastindakan_nama[$key]   = $dataPendaftar->kelastindakan_nama;
        $subtotal[$key]     = $tarif_satuan[$key]*$qty_tindakan[$key];
        $daftartindakan_nama[$key]  = $dataPendaftar->daftartindakan_nama;
        $ruangantindakan_nama[$key] = $dataPendaftar->ruangantindakan_nama;
        $tgl_tindakan[$key] = $dataPendaftar->tgl_tindakan;
        $dokter_tindakan[$key]      = $dataPendaftar->DokterTindakan;

        $subsidiasuransi_tindakan   += $dataPendaftar->subsidiasuransi_tindakan;
        $subsidirumahsakit_tindakan += $dataPendaftar->subsisidirumahsakit_tindakan;
        $iurbiaya_tindakan += $dataPendaftar->iurbiaya_tindakan;

        $a++;
    }

    $tgl_renkontrol = $format->formatDateTimeId($tglrenkontrol);
    $tgl_daftar = $format->formatDateTimeId($tgl_pendaftaran);
?>

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="20%">No. RM / Reg</td>
        <td width="30%"> :
            <?php echo CHtml::encode($no_rekam_medik); ?> / 
            <?php echo CHtml::encode($no_pendaftaran); ?>           
        </td>
        <td width="20%">Jenis Penjamin / Penjamin </td>
        <td>:
            <?php
                echo CHtml::encode($carabayarPenjamin);
            ?>        
        </td>
    </tr>
    <tr>
        <td>Nama Pasien </td>
        <td>: <?php echo CHtml::encode($nama_pendaftaran); ?></td>
        <td>Tgl. Pendaftaran</td>
        <td>: <?php echo CHtml::encode($tgl_daftar); ?></td>
    </tr>
    <tr>
        <td>Umur / Jenis Kelamin </td>
        <td>: <?php echo CHtml::encode($umur).' / '.CHtml::encode($jeniskelamin); ?>
        </td>
        <td>Nama PJP </td>
        <td>: <?php echo CHtml::encode($nama_pj); ?>
        </td>
    </tr>
    <tr>
        <td>Alamat Pasien </td>
        <td>:
            <?php echo CHtml::encode($alamat); ?>
        </td>
        <td>Alamat PJP </td>
        <td>: <?php
                echo CHtml::encode($alamat_pjp);
            ?>
        </td>
    </tr>
    <tr>
        <td>Unit Pelayanan </td>
        <td>: <?php echo CHtml::encode($instalasi_nama); ?>
        </td>
        <td>Kasus Penyakit </td>
        <td>: <?php
               echo CHtml::encode($kasus_penyakit);
            ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa </td>
        <td>: <?php echo CHtml::encode($dokter_pemeriksa); ?></td>
        <td>Nama Perujuk </td>
        <td>: <?php echo CHtml::encode($namaperujuk); ?></td>
    </tr>
    <tr>
        <td>Kelas Pelayanan </td>
        <td>: <?php echo CHtml::encode($kelaspelayanan); ?></td>
        <td>Tgl. Rencana Kontrol </td>
        <td>: <?php echo CHtml::encode($tglrenkontrol); ?></td>
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
            $total_biaya = 0;
            $total = 0;
            $sub_total = 0;
            $tampilAdminFarmasi = true;
            $tempAdminFarmasi = 0;
            $subsidiAsuransi = $subsidiasuransi_tindakan;
            $subsidiRumahSakit = $subsidirumahsakit_tindakan;
            $iurBiaya = $iurbiaya_tindakan;                    

            foreach ($modRincian as $index => $data) {
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
        ?>
    </tbody>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td colspan='2'><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></td>
        <td colspan='3' align='right'>Total Biaya :</td>
        <td align='right'><?php echo number_format($total,0,'',','); ?></td>
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
        <td colspan='2'><?php echo $data['nama_pegawai']; ?></td>
        <td colspan='3' align='right'>Tanggungan Pasien :</td>
        <td align='right'>
            <?php 
//                $kembalian = ($total_biaya - $subsidiAsuransi - $subsidiRumahSakit);
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
</table>

<script type="text/javascript">

    function insertCetakan()
    {
        var params = {pendaftaran_id:'<?php $pendaftaran_id; ?>'};
        
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