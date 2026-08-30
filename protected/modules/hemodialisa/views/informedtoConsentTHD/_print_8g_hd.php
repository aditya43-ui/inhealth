<?php
$titik = new CustomFunction;
echo $this->renderPartial('application.views.headerReport.headerDefault',['data'=>$data,'pemprov_logo'=>true]); 


function cek_lis($st){
    $icon = '<span  style="font-family:FontAwesome;" ></span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf00c;</span>';
    }
    return $icon;
}

$tgl = (!empty($model->waktu))?MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->waktu)), 'long'):null;
$jam = (!empty($model->waktu))?date('H:i:s', strtotime($model->waktu)):null;

?>
<style>     
    table.prinout{    
        border-collapse: collapse;
        table-layout: auto !important;
        margin-bottom: 10px;
    }
    
    table.prinout td, table.prinout th {
        padding: 2px 10px 2px 10px;        
    }
    
    .prinout{        
        font-size: 19px !important;
    }
    
    .green{
        background: #afdc7e;
        box-shadow:  inset -200px -200px 0px 200px rgba(175, 220, 126);
    }
</style>

    <table class='w100 prinout grid'>
        <tr class="green">
            <td class="green" colspan="4">
                Diisi oleh Dokter
            </td>
        </tr>
        <tr>
            <td width='6%' align='center'>NO.</td>
            <td width='25%' align='center'>JENIS INFORMASI</td>
            <td align='center'>ISI INFORMASI</td>
            <td width='15%' align='center'>TANDAI</td>
        </tr>
        <tr>
            <td align='center'>1.</td>
            <td>Diagnosis (diagnosis kerja, diagnosis banding)</td>
            <td>Penyakit Ginjal Tahap Akhir</td>
            <td align='center'>
                <?= cek_lis($model->diagnosis) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>2.</td>
            <td>Dasar Diagnosis</td>
            <td>Riwayat penyakit, pemeriksaan fisik, pemeriksaan penunjang</td>
            <td align='center'>
                <?= cek_lis($model->dasar_diagnosis) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>3.</td>
            <td>Tindakan Kedokteran</td>
            <td>Hemodialisis reguler</td>
            <td align='center'>
                <?= cek_lis($model->tindakan_kedokteran) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>4.</td>
            <td>Indikasi Tindakan</td>
            <td>Gangguan elektrolit, produk sampah ginjal dalam kadar toksik, sindroma kelebihan cairan</td>
            <td align='center'>
                <?= cek_lis($model->indikasi_tindakan) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>5.</td>
            <td>Tata Cara</td>
            <td>Pembuluh darah arteri dan vena dihubungkan dengan mesin hemodialisis yang mengalirkan darah, lalu sampah dan cairan berlebih dipindahkan dari tubuh dan darah kembali ke tubuh</td>
            <td align='center'>
                <?= cek_lis($model->tata_cara) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>6.</td>
            <td>Tujuan</td>
            <td>Mengatur keseimbangan elektrolit, keseimbangan cairan danmembersihkan tubuh dari sampah ginjal</td>
            <td align='center'>
                <?= cek_lis($model->tujuan) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>7.</td>
            <td>Risiko / Komplikasi yang mungkin</td>
            <td>Perdarahan, pembengkakan dan infeksi di tempat penusukan, mual-mungkinmuntah, kontaminasi sistem air yang digunakan hemodialisis,kram otot, penurunan tekanan darah, gejala ketidak seimbangan,irama jantung tidak teratur, reaksi cairan dialisat, kematian</td>
            <td align='center'>
                <?= cek_lis($model->risiko) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>8.</td>
            <td>Prognosis</td>
            <td>Baik</td>
            <td align='center'>
                <?= cek_lis($model->prognosis) ?>
            </td>
        </tr>
        <tr>
            <td align='center'>9.</td>
            <td>Alternatif dan Resikonya</td>
            <td><?= $model->alternatif_risiko_isi_informasi ?></td>
            <td align='center'>
                <?= cek_lis($model->alternatif_risiko) ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Dengan ini menyatakan bahwa saya telah menerangkan hal-hal diatas secara benar dan jujur dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.<br/>
                Tanggal : <?= $titik->defaulttitik(20, $tgl) ?> Jam : <?= $titik->defaulttitik(20, $jam) ?>
            </td>
            <td align='center' height="100px">
                Tanda tangan<font style='font-size:12px;'><br/>Prof. /dr. /<br/>Spesialis</font>
                <br/>
                <br/>
                <br/>
                <br/>
                <?= !empty($model->dokteri->namaLengkap)?$model->dokteri->namaLengkap:''; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Dengan ini menyatakan bahwa saya telah menerima informasi terkait transfusi sebagaimana di atas yang saya beri tanda / paraf dikolom kanannya, dan telah memahaminya.<br/>
                Tanggal : <?= $titik->defaulttitik(20, $tgl) ?> Jam : <?= $titik->defaulttitik(20, $jam) ?>
            </td>
            <td align='center' height="100px">Tanda tangan<font style='font-size:12px;'><br/>Pasien / Wali</font></td>
        </tr>
    </table>

 <?php
   // echo '<div style=" page-break-after:always;"></div>';
 ?>