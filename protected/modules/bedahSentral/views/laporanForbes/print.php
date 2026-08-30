<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

$model1 = LaporanforbesbedahsentralV::model()->findAll($model->searchLaporanCrit());

?>
<div style="margin: 20px; font-size: 14px;">
<center>
    <b>FORBES BEDAH RSUD DR. SAIFUL ANWAR MALANG</b><br>
    <b><?php echo strtoupper($this->hari_ini() . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')))?></b><br><br>
</div>
</center>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>NO.</th>
            <th>TANGGAL RENCANA OPERASI</th>
            <th>OK</th>
            <th>JAM</th>
            <th>NAMA/JK/UMUR</th>
            <th>REGISTER</th>
            <th>RUANG</th>
            <th>DIAGNOSIS</th>
            <th>RENCANA TINDAKAN</th>
            <th>SMF</th>
            <th>KELAS PELAYANAN</th>
            <th>DPJP</th>
            <th>RESIDEN</th>
            <th>ANESTESI</th>
            <th>LAMA OP</th>
            <th>KETERANGAN</th>
        </tr>
    </thead>
    <tbody class="tab_pramedikasi">
        <?php

        $i = 0;
        if(!empty($model1)) {
            foreach($model1 as $i => $md) {

                $i++;

                $jam_mulai = $md->jam_mulai;
                $jam = null;

                if(!empty($jam_mulai)) {

                    $jam = $jam_mulai;
                }
                $kamarruangan = isset($md->kamarruangan_nobed) ? $md->kamarruangan_nobed : "";

                echo '<tr>';
                echo "<td>$i</td>";
                echo "<td>" . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($md->tglrencanaoperasi))) . "</td>";
                echo "<td>$kamarruangan</td>";
                echo "<td>$jam</td>";
                echo "<td>$md->nama_pasien/$md->jeniskelamin/$md->umur</td>";
                echo "<td>$md->no_rekam_medik</td>";
                echo "<td>$md->ruanganasal_nama</td>";
                echo "<td>$md->diagnosa_nama</td>";
                echo "<td>$md->operasi_nama</td>";
                echo "<td>$md->jeniskasuspenyakit_nama</td>";
                echo "<td>$md->kelaspelayanan_nama</td>";
                echo "<td>$md->dpjp_nama</td>";
                echo "<td>$md->residen</td>";
                echo "<td>$md->jenisanestesi</td>";
                echo "<td>$md->lama_op</td>";
                echo "<td>$md->keterangan_rencana</td>";
                echo '</tr>';
            }
        }
        // $list = PremedikasiprainduksiT::model()->findAllByAttributes(array(
        //     'asesmenprainduksi_id'=>$model->asesmenprainduksi_id,
        // ));

        // foreach ($list as $item) {
        //     echo $this->renderPartial($this->path_view."_rowPremedikasi", array(
        //         'form'=>$form,
        //         'modForm'=>$item
        //     ), true);
        // }

        ?>
    </tbody>
</table>
<br>
<div style="margin: 20px; font-size: 14px;">
<center>
    <b>Mengetahui Chief Ok,</b><br><br><br><br><br>
    <b><?php echo PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->namaLengkap ?></b>
</div>
</center>
