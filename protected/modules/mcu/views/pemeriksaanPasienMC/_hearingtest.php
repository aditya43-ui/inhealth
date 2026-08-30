<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<?php //$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    // 'id'=>'treadmill-t-grid', 
    // 'dataProvider'=>$modHearingtestSearch->searchDetailHearingtest($modPendaftaran->pendaftaran_id), 
	// 'template'=>"{summary}\n{items}\n{pager}", 
	// 'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    // 'columns'=>array( 
    //     array(
    //         'header'=>'Tanggal Hearing Test',
    //         'value'=>'MyFormatter::formatDateTimeForUser($data->tglhearingtest)',
    //     ),
	// 	'catatan_hearingtest',
	// 	'keterangan_hearingtest',
	// 	'namapemeriksa_hearingtest'
    // ), 
    //     'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
//)); ?> 

<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 48px;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (count((array)$modHearingtest)>0){
foreach ($modHearingtest as $i => $loop){
?>
    <tr>
        <td>I</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            RIWAYAT PEKERJAAN</td>
    </tr>
    <tr>
        <td style="width:20%">Nama Perusahaan</td>
        <td style="width:25%">: <?php echo isset($loop->nmperusahaan_rwt)?$loop->nmperusahaan_rwt:" - "; ?></td>
        <td style="width:20%">Lama Bekerja / Satuan Lama (thn/bln/hr)</td>
        <td style="width:30%">: <?php echo isset($loop->lamabekerja)?$loop->lamabekerja:" - "; ?> / <?php echo isset($loop->satuan_lamakrj)?$loop->satuan_lamakrj:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Jenis Pekerjaan</td>
        <td style="width:25%">: <?php echo isset($loop->jnspekerjaan_rwt)?$loop->jnspekerjaan_rwt:" - "; ?></td>
        <td style="width:20%">Terpapar/Kontak dengan Bising</td>
        <td style="width:30%">: <?php echo isset($loop->kontakdgnbising)?$loop->kontakdgnbising:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Hobby Menembak/Musik</td>
        <td style="width:25%">: <?php echo isset($loop->hobtembak_musik)?$loop->hobtembak_musik:" - "; ?></td>
        <td style="width:20%">Alat proteksi telinga yang pernah dikenakan</td>
        <td style="width:30%">: <?php echo isset($loop->altproteksi_telinga)?$loop->altproteksi_telinga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Ket Kerja Lingkungan</td>
        <td style="width:25%">: <?php echo isset($loop->ket_kerja_lingkungan)?$loop->ket_kerja_lingkungan:" - "; ?></td>
        <td style="width:20%">Paparan bahan kimia di lingkungan kerja </td>
        <td style="width:30%">: <?php echo isset($loop->bahankimia_lk)?$loop->bahankimia_lk:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Kelainan Pendengaran di kalangan keluarga </td>
        <td style="width:25%">: <?php echo isset($loop->kelainanpend_kal_kel)?$loop->kelainanpend_kal_kel:" - "; ?></td>
        <td style="width:20%"></td>
        <td style="width:30%"></td>
    </tr>
    <tr>
        <td>II</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            KELUHAN-KELUHAN LAINNYA</td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">Apakah ada gangguan Pembicaraan antara perorangan</td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->gangguan_antarperorangan)?$loop->gangguan_antarperorangan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">Apakah ada gangguan Pendengaran di lingkungan yang gaduh/berisik</td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->gangguan_lingkgaduh)?$loop->gangguan_lingkgaduh:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">Apakah telinganya sering mendenging</td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->telinga_mendenging)?$loop->telinga_mendenging:" - "; ?></td>
    </tr>
    <tr>
        <td>III</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            PEMERIKSAAN TELINGA</td>
    </tr>
    <tr>
        <td style="width:20%">Telinga Kanan : Membran Tympani</td>
        <td style="width:25%">: <?php echo isset($loop->tkn_membrantympani)?$loop->tkn_membrantympani:" - "; ?></td>
        <td style="width:20%">Infeksi Lubang Telinga</td>
        <td style="width:30%">: <?php echo isset($loop->tkn_influbtelinga)?$loop->tkn_influbtelinga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Serumen</td>
        <td style="width:25%">: <?php echo isset($loop->tkn_serumen)?$loop->tkn_serumen:" - "; ?></td>
        <td style="width:20%">Telinga Kiri : Membran Tympani</td>
        <td style="width:30%">: <?php echo isset($loop->tkr_membrantympani)?$loop->tkr_membrantympani:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%">Infeksi Lubang Telinga</td>
        <td style="width:25%">: <?php echo isset($loop->tkr_influbtelinga)?$loop->tkr_influbtelinga:" - "; ?></td>
        <td style="width:20%">Serumen</td>
        <td style="width:30%">: <?php echo isset($loop->tkr_serumen)?$loop->tkr_serumen:" - "; ?></td>
    </tr>
    <tr>
        <td>IV</td>
        <td align="center" valign="middle" colspan="6" style="font-weight:bold">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            KESIMPULAN HASIL AUDIOGRAM</td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">1. Penurunan kemampuan pendenganran untuk komunikasi akibat terpapar kebisingan derajat</td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->penuruankempendengaran)?$loop->penuruankempendengaran:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="4">2. Penurunan kemampuan pendenganran pada frekuensi</td>
    </tr>
    <tr>
        <td style="width:20%" colspan="1">- Kanan</td>
        <td style="width:20%" colspan="3">
            <table>
            <thead>
                <th>
                    <td>Freq</td>
                    <td>500</td>
                    <td>1K</td>
                    <td>2K</td>
                    <td>3K</td>
                    <td>4K</td>
                    <td>6K</td>
                    <td>8K</td>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>Db</td>
                    <td><?php echo isset($loop->tkn_500)?$loop->tkn_500:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_1k)?$loop->tkn_1k:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_2k)?$loop->tkn_2k:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_3k)?$loop->tkn_3k:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_4k)?$loop->tkn_4k:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_6k)?$loop->tkn_6k:" - "; ?></td>
                    <td><?php echo isset($loop->tkn_8k)?$loop->tkn_8k:" - "; ?></td>
                </tr>
            </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width:20%" colspan="1">- Kiri</td>
        <td style="width:20%" colspan="3"> 
        <table>
            <thead>
                <th>
                    <td>Freq</td>
                    <td>500</td>
                    <td>1K</td>
                    <td>2K</td>
                    <td>3K</td>
                    <td>4K</td>
                    <td>6K</td>
                    <td>8K</td>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>Db</td>
                    <td><?php echo isset($loop->tkr_500)?$loop->tkn_500:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_1k)?$loop->tkr_1k:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_2k)?$loop->tkr_2k:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_3k)?$loop->tkr_3k:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_4k)?$loop->tkr_4k:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_6k)?$loop->tkr_6k:" - "; ?></td>
                    <td><?php echo isset($loop->tkr_8k)?$loop->tkr_8k:" - "; ?></td>
                </tr>
            </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">3. Penurunan kemampuan pendengaran akibat : Pertambahan usia/Presbyacusis </td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->penurunan_presbyacusis)?$loop->penurunan_presbyacusis:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="3">4. Penurunan kemampuan pendengaran akibat : Penyakit infeksi dan lainnya </td>
        <td style="width:20%" colspan="1"> <?php echo isset($loop->penurunan_infdanlain)?$loop->penurunan_infdanlain:" - "; ?></td>
    </tr>
    <tr><td colspan="6" style="text-align:center;">KESIMPULAN</td></tr>
    <tr>
        <td style="width:20%" colspan="1">Catatan</td>
        <td style="width:20%" colspan="3"> <?php echo isset($loop->catatan_hearingtest)?$loop->catatan_hearingtest:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="1">Keterangan</td>
        <td style="width:20%" colspan="3"> <?php echo isset($loop->keterangan_hearingtest)?$loop->keterangan_hearingtest:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:20%" colspan="1">Pemeriksa</td>
        <td style="width:20%" colspan="3"> <?php echo isset($loop->namapemeriksa_hearingtest)?$loop->namapemeriksa_hearingtest:" - "; ?></td>
    </tr>
    <tr><td colspan="6" style="text-align:center;"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan treadmill</td>
    </tr> 
<?php } ?>
</table> 