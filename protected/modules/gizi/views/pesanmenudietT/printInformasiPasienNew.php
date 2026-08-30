<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    // echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 14));
}


$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
?>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header" align="">
                    <center>
                        <h3>PEMERINTAH PROVINSI JAWA TIMUR<br>RUMAH SAKIT UMUM DAERAH Dr. SAIFUL ANWAR MALANG</h3>
                        <br><br>
                        LAPORAN SURAT PERMINTAAN MAKAN PASIEN
                    </center>
                </div><br>
            </td>
        </tr>
        <tr>
            <td>
                <div align="left">
                    <?php 
                        $tgl_awal =  MyFormatter::formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
                        $tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);

                        $tgl_awal = date('d-m-Y', strtotime($tgl_awal));
                        $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir));

                        $tgl = $tgl_awal == $tgl_akhir ? $tgl_awal : $tgl_awal . " s/d " . $tgl_akhir;
                        $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;

                        echo 'TANGGAL: ' . $tgl . '<br>';
                        echo 'RUANGAN: ' . $ruangan . '<br>';

                        $mod = $model->searchInformasiMenuPasienPrintModel();

                        echo 'JUMLAH PASIEN: ' . count($mod);

                    ?>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">



                    <table class="table table-striped table-condensed" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No.</th>
                                <th style="text-align: center;">No. Bed</th>
                                <th style="text-align: center;">Nama Pasien</th>
                                <th style="text-align: center;">No. RM</th>
                                <th style="text-align: center;">No. Billing</th>
                                <th style="text-align: center;">Tgl. Lahir</th>
                                <th style="text-align: center;">Kelas</th>
                                <th style="text-align: center;">Diet</th>
                                <th style="text-align: center;">Keterangan</th>
                                <th style="text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($mod)):?>
                            <?php foreach($mod as $i => $md):?>
                            <tr>
                                <?php $pendaftaran = !empty($md->pendaftaran_id) ? PendaftaranT::model()->findByPk($md->pendaftaran_id) : null;?>
                                <?php $pasienadmisi = !empty($md->pasienadmisi_id) ? PasienadmisiT::model()->findByPk($md->pasienadmisi_id) : null;?>
                                <?php $kamarruangan = isset($pasienadmisi->kamarruangan_id) ? KamarruanganM::model()->findByPk($pasienadmisi->kamarruangan_id) : null;?>

                                <?php $menudiet = MenuDietM::model()->findByPk($md->menudiet_id); ?>
                                <td style="text-align: right;"><?= ($i + 1) ?></td>
                                <td style="text-align: right;">
                                    <?= !empty($kamarruangan) ? $kamarruangan->kamarruangan_nobed : '' ?></td>
                                <td><?= $md->nama_pasien ?></td>
                                <td><?= $md->no_rekam_medik ?></td>
                                <td><?= $pendaftaran->no_pendaftaran ?></td>
                                <td><?= MyFormatter::formatDateTimeForUser($md->tanggal_lahir) ?></td>
                                <td><?= $pendaftaran->kelaspelayanan->kelaspelayanan_nama ?></td>
                                <td><?= $md->jenisdiet->jenisdiet_nama ?? '' ?></td>
                                <td></td>
                                <td></td>

                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>


            </td>
        </tr>
    </tbody>
</table>