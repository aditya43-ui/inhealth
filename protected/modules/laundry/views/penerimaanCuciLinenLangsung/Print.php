
<style>

    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
        border-spacing: 0;
        padding: 0;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    if ($caraPrint != 'EXCEL') {
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                    }
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table class="">
                        <tr>
                            <td width="20%">Tanggal Penerimaan Linen</td>
                            <td width="1%">:</td>
                            <td><?php echo isset($modPenerimaanLinen->tglpenerimaanlinen) ? $format->formatDateTimeId($modPenerimaanLinen->tglpenerimaanlinen) : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>No. Penerimaan Linen</td>
                            <td>:</td>
                            <td><?php echo isset($modPenerimaanLinen->nopenerimaanlinen) ? $modPenerimaanLinen->nopenerimaanlinen : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Ruangan</td>
                            <td>:</td>
                            <td><?php echo isset($modPenerimaanLinen->ruangan->ruangan_nama) ? $modPenerimaanLinen->ruangan->ruangan_nama : "-"; ?></td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><?php echo isset($modPenerimaanLinen->keterangan_penerimaanlinen) ? $modPenerimaanLinen->keterangan_penerimaanlinen : "-"; ?></td>
                        </tr>
                    </table><br><br>

                    <table  class="table border">
                        <thead>
                            <tr>
                                <th>Nama Linen</th>
                                <th>Jenis Perawatan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPenerimaanLinenDetail as $i => $modLinen) {
                                ?>
                                <tr>
                                    <td><?php echo $modLinen->linen->namalinen; ?></td>
                                    <td><?php echo $modLinen->jenisperawatanlinen; ?></td>
                                    <td><?php echo $modLinen->keterangan_penerimaanlinen; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="35%" align="center">
                                <div>Menerima<br></div>
                                <div style="margin-top:60px;"><?php echo isset($modPenerimaanLinen->pegawaiMenerima->nama_pegawai) ? $modPenerimaanLinen->pegawaiMenerima->nama_pegawai : "-"; ?></div>
                            </td>
                            <td width="35%" align="center">
                                <div>Mengetahui</div>
                                <div style="margin-top:60px;"><?php echo isset($modPenerimaanLinen->pegawaiMengetahui->nama_pegawai) ? $modPenerimaanLinen->pegawaiMengetahui->nama_pegawai : "-"; ?></div>
                                <div></div>
                            </td>
                        </tr>
                    </table>

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
<div class="">
</div>
<div class="footer">

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   
