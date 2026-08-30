
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
                                <td>No. Perawatan</td>
                                <td>:</td>
                                <td><?php echo $modPerawatan->noperawatan; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Perawatan</td>
                                <td>:</td>
                                <td><?php echo isset($modPerawatan->tglperawatanlinen) ? MyFormatter::formatDateTimeForUser($modPerawatan->tglperawatanlinen) : ""; ?></td>
                            </tr>
                            <tr>
                                <td>Pegawai Mengetahui</td>
                                <td>:</td>
                                <td><?php echo (isset($modPerawatan->pegmengetahui->NamaLengkap) ? $modPerawatan->pegmengetahui->NamaLengkap : ""); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?php echo $modPerawatan->keterangan_perawatan; ?></td>
                            </tr>
                        </table><br>
                        <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ruangan Asal</th>
                                    <th>No. Penerimaan</th>
                                    <th>Kode Linen</th>
                                    <th>Nama Linen</th>
                                    <th>Keterangan</th>
                                    <th>Status Perawatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count((array)$modPerawatanDetail) > 0) {
                                    foreach ($modPerawatanDetail AS $i => $modDetail) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i + 1; ?></td>
                                            <td><?php echo (!empty($modDetail->ruangan_id) ? $modDetail->ruangan->ruangan_nama : ""); ?></td>
                                            <td><?php echo (!empty($modDetail->penerimaanlinen_id) ? $modDetail->penerimaanlinen->nopenerimaanlinen : ""); ?></td>
                                            <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->kodelinen : ""); ?></td>
                                            <td><?php echo (!empty($modDetail->linen_id) ? $modDetail->linen->namalinen : ""); ?></td>
                                            <td><?php echo $modDetail->keteranganperawatan; ?></td>
                                            <td><?php echo $modDetail->statusperawatanlinen; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php if ($modPerawatan->iskirimkeluar != true) { ?>
                            <span><b><p style="margin: 0; text-align: center;">Data Bahan Perawatan</p></b></span>
                            <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Bahan</th>
                                        <th>Jumlah Bahan</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count((array)$modPerawatanBahan) > 0) {
                                        foreach ($modPerawatanBahan AS $i => $modBahan) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo (!empty($modBahan->bahanperawatan_id) ? $modBahan->bahanperawatan->bahanperawatan_nama : ""); ?></td>
                                                <td><?php echo (!empty($modBahan->jmlbahanpemakaian) ? $modBahan->jmlbahanpemakaian : ""); ?></td>
                                                <td><?php echo (!empty($modBahan->satuanpemakaian) ? $modBahan->satuanpemakaian : ""); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </fieldset>
                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="50%" align="center">
                                Pegawai Menyetujui,
                                <div style="margin-top:50px;"></div><?php echo (isset($modPerawatan->pegperawatan->NamaLengkap) ? $modPerawatan->pegperawatan->NamaLengkap : ""); ?>
                            </td>
                            <td width="50%" align="center">
                                <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
                                Pegawai Mengetahui,
                                <div style="margin-top:50px;"></div><?php echo (isset($modPerawatan->pegmengetahui->NamaLengkap) ? $modPerawatan->pegmengetahui->NamaLengkap : ""); ?>
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
