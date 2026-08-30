
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
                 
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                    
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <fieldset>
                        <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>No. Penyimpanan</td>
                                <td>:</td>
                                <td><?php echo $modPenyimpananLinen->nopenyimpananlinen; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Penyimpanan</td>
                                <td>:</td>
                                <td><?php echo isset($modPenyimpananLinen->tglpenyimpananlinen) ? MyFormatter::formatDateTimeForUser($modPenyimpananLinen->tglpenyimpananlinen) : ""; ?></td>
                            </tr>
                            <tr>
                                <td>Pegawai Mengetahui</td>
                                <td>:</td>
                                <td><?php echo (isset($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : ""); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?php echo $modPenyimpananLinen->keterangan_penyimpanan; ?></td>
                            </tr>
                        </table><br>
                        <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Lokasi Penyimpanan</th>
                                    <th>Sub Rak</th>
                                    <th>No. Pencucian/ Perawatan</th>
                                    <th>Kode Linen</th>
                                    <th>Nama Linen</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modPenyimpananLinenDetail) > 0) {
                                    foreach ($modPenyimpananLinenDetail AS $i => $modDetail) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo (!empty($modDetail->lokasipenyimpanan_id) ? $modDetail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                                            <td><?php echo (!empty($modDetail->rakpenyimpanan_id) ? $modDetail->rakpenyimpanan->rakpenyimpanan_nama : ""); ?></td>
                                            <td>
                                                <?php
                                                echo (!empty($modDetail->pencucianlinen_id) ? $modDetail->pencucianlinen->nopencucianlinen : "");
                                                echo (!empty($modDetail->perawatanlinen_id) ? $modDetail->perawatanlinen->noperawatan : "");
                                                ?>
                                            </td>
                                            <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->kodelinen : ""); ?></td>
                                            <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->namalinen : ""); ?></td>
                                            <td><?php echo $modDetail->keterangan_penyimpaanlinen; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </fieldset>
                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="50%" align="center">
                                Pegawai Menyetujui,
                                <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananLinen->petugas->NamaLengkap) ? $modPenyimpananLinen->petugas->NamaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
                            </td>
                            <td width="50%" align="center">
                                <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
                                Pegawai Mengetahui,
                                <div style="margin-top:50px;"></div><?php echo (isset($modPenyimpananLinen->pegmengetahui->NamaLengkap) ? $modPenyimpananLinen->pegmengetahui->NamaLengkap : ""); ?>
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
