<style>
    body {
        color: black;
    }

    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr td,
    .table tbody tr th {
        background-color: none;
    }

    .table {
        box-shadow: none;
    }

    .judulcontent {
        text-align: center;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent">
                        <h4><b><?php echo $judulRincian; ?></b></h4>
                    </div>
                    <table class='table' style="border: 0;">
                        <tr>
                            <td width="50%">
                                <table class='table' style="border: 0;">
                                    <tr>
                                        <td width="180px"> Tgl. Kas Keluar </td>
                                        <td>
                                            : <?php echo MyFormatter::formatDateTimeForUser($modBuktiKeluar->tglkaskeluar); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Tgl. Penyetoran</td>
                                        <td>
                                            : <?php echo $tglsetoran; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> No. Kas Keluar </td>
                                        <td>
                                            : <?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> No. Penyetoran </td>
                                        <td>
                                            : <?php echo CHtml::encode($modBuktiKeluar->no_setorpajakpembelian); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Cara Pembayaran </td>
                                        <td>
                                            : <?php echo $modBuktiKeluar->carabayarkeluar; ?>
                                        </td>
                                    </tr>
                                    <?php if ($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER) { ?>
                                        <tr>
                                            <td> Nama Bank Penerima </td>
                                            <td>
                                                : <?php echo (isset($modBuktiKeluar->bank_id) ? BankM::model()->findByPk($modBuktiKeluar->bank_id)->namabank : ""); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> No Rekening Penerima </td>
                                            <td>
                                                : <?php echo $modBuktiKeluar->denganrekening; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> No Struk Bukti Transfer </td>
                                            <td>
                                                : <?php echo $modBuktiKeluar->nobukti_transfer; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td> Nama Penerima </td>
                                        <td>
                                            : <?php echo $modBuktiKeluar->namapenerima; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Alamat Penerima </td>
                                        <td>
                                            : <?php echo $modBuktiKeluar->alamatpenerima; ?>
                                        </td>
                                    </tr>
                                    <?php if ($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TUNAI) { ?>
                                        <tr>
                                            <td> Keterangan </td>
                                            <td>
                                                : <?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td width="50%">
                                <table class='table' style="border: 0;">
                                    <?php
                                    $widthjenis = 'width="150px"';
                                    if ($modBuktiKeluar->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER) {
                                        $widthjenis = '';
                                    ?>
                                        <tr>
                                            <td width="150px"> Keterangan </td>
                                            <td>
                                                : <?php echo $modBuktiKeluar->untukpembayaran; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td <?php echo $widthjenis; ?>> Jenis Pajak </td>
                                        <td>
                                            : <?php echo $pajak_nama; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td> Total Utang </td>
                                        <td>
                                            : Rp<?php echo (!empty($totalhutang) ? MyFormatter::formatNumberForPrint($totalhutang, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Setoran </td>
                                        <td>
                                            : Rp<?php echo (!empty($jmlpembayaran) ? MyFormatter::formatNumberForPrint($jmlpembayaran, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Biaya Meterai </td>
                                        <td>
                                            : Rp<?php echo (!empty($modBuktiKeluar->biaya_materai) ? MyFormatter::formatNumberForPrint($modBuktiKeluar->biaya_materai, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Jumlah Kas Keluar </td>
                                        <td>
                                            : Rp<?php echo (!empty($modBuktiKeluar->jmlkaskeluar) ? MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Total Sisa Utang </td>
                                        <td>
                                            : Rp<?php echo (!empty($totalsisahutang) ? MyFormatter::formatNumberForPrint($totalsisahutang, 2) : "-"); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <p style="text-align: center;">RINCIAN HUTANG
                    <p style="margin: 0; text-align: center;">
                    <div style="border: 1px solid black; width: 80%;"></div>
                    </p>
                    </p>
                    <br>
                    <table width="85%" style='margin-left:auto; margin-right:auto;' class="border">
                        <thead class="border">
                            <th>No.</th>
                            <th>Tgl. Pembayaran / <br> No. Pembayaran</th>
                            <th>Tgl. Pendaftaran / <br> No. Pendaftaran</th>
                            <th>No. Rekam Medik</th>
                            <th>Nama Pasien</th>
                            <th>Instalasi</th>
                            <th>Ruangan</th>
                            <!--<th>Bayar Ke -</th>-->
                            <th>Jenis Pajak</th>
                            <th>Total Utang Pajak</th>
                            <th>Jumlah Yang Disetorkan</th>
                            <th>Sisa Utang</th>
                            <th>Keterangan</th>
                        </thead>
                        <?php
                        foreach ($model as $i => $modData) {
                            $listData = KUPembayaranppnkeluaranV::model()->findByAttributes(array('obatalkespasien_id' => $modData->obatalkespasien_id));

                        ?>
                            <tr class="border">
                                <td><?php echo ($i + 1) . "."; ?></td>
                                <td><span><?php echo MyFormatter::formatDateTimeForUser($listData->tglpembayaran) . "<br>" . $listData->nopembayaran; ?></span></td>
                                <td><span><?php echo MyFormatter::formatDateTimeForUser($listData->tgl_pendaftaran) . "<br>" . $listData->no_pendaftaran; ?></span></td>
                                <td><span><?php echo $listData->no_rekam_medik; ?></span></td>
                                <td><span><?php echo $listData->nama_pasien; ?></span></td>
                                <td><span><?php echo $listData->instalasi_nama; ?></span></td>
                                <td><span><?php echo $listData->ruangan_nama; ?></span></td>
                                <!--<td style="text-align: center"><?php //echo $modData->bayarke; 
                                                                    ?></td>-->
                                <td><span><?php echo (isset($modData->pajak) ? $modData->pajak->pajak_nama : ""); ?></span></td>
                                <td style="text-align:right;">Rp<?php echo MyFormatter::formatNumberForPrint($modData->totalhutang, 2); ?></td>
                                <td style="text-align:right;">Rp<?php echo MyFormatter::formatNumberForPrint($modData->jmlpembayaran, 2); ?></td>
                                <td style="text-align:right;">Rp<?php echo MyFormatter::formatNumberForPrint($modData->totalsisahutang, 2); ?></td>
                                <td>
                                    <?php echo $modData->keterangansetoran; ?>
                                </td>
                            </tr>
                        <?php } ?>
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
<br><br>
<br><br>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<br>
<?php
if (!isset($_GET['caraPrint'])) {
?>
    <div class="form-actions">
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            'javascript:void(0);',
            array(
                'class' => 'btn btn-info',
                'onClick' => 'print("PRINT")'
            )
        );
        ?>
    </div>
<?php
    $urlPrint = $this->createUrl('rincian', array('tandabuktikeluar_id' => $modBuktiKeluar->tandabuktikeluar_id, 'caraPrint' => 'PRINT'));
    $js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');

}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
}
?>