<style>
    body {
        color: black;
    }

    .tab_detail {
        width: 100%;
    }

    .tab_detail th,
    .tab_detail td {
        color: black;
        border: 1px solid black;
        padding: 3px;
    }

    .tab_detail th {
        font-weight: bold;
    }

    .tab_header {
        width: 100%;
        margin-bottom: 10px;

        .tab_header td {
            padding: 3px;
            border: none;
        }
</style>
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
                    <div class="judulcontent"> <?php echo $judulLaporan ?>
                    </div>
                    <table class='tab_header'>
                        <tr>
                            <td>No. Pemesanan</td>
                            <td>:</td>
                            <td width="100%">
                                <?php echo CHtml::encode($modPesan->nopemesanan); ?>
                            </td>
                            <td nowrap>Ruangan Pemesan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPesan->ruanganpemesan->ruangan_nama); ?></td>
                        </tr>
                        <tr>
                            <td nowrap>Tgl. Pemesanan</td>
                            <td>:</td>
                            <td><?php echo CHtml::encode($modPesan->tglpesanbarang); ?></td>
                            <td nowrap>Ruangan Tujuan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPesan->ruangantujuan->ruangan_nama); ?></td>
                        </tr>
                    </table>

                    <table id="tableObatAlkes" class="tab_detail">
                        <thead>

                            <th>No.</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Jml. Permintaan</th>
                            <th>Jml. Mutasi</th>
                            <!--<th>Ukuran<br>Bahan</th>-->

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($modDetailPesan as $detail) :
                            ?>
                                <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php
                                        echo 12; //!empty($modBarang->bidang_id)?$modBarang->bidang->subsubkelompok->subkelompok->kelompok->golongan->golongan_nama:null; 
                                        ?>
                                        <?php echo $modBarang->barang_type; ?>
                                    </td>
                                    <td><?php echo $modBarang->barang_kode; ?></td>
                                    <td><?php echo $modBarang->barang_nama; ?></td>
                                    <td><?php echo $modBarang->barang_merk; ?></td>
                                    <td style="text-align: right;"><?php echo $detail->qty_pesan . " " . $detail->satuanbarang; ?></td>
                                    <td style="text-align: right;"><?php echo $detail->qty_mutasi . " " . $detail->satuanbarang; ?></td>
                                    <!--<td><?php //echo $modBarang->barang_ukuran;   
                                            ?><br><?php //echo $modBarang->barang_bahan;   
                                                                                                ?></td>-->
                                </tr>
                            <?php
                                $no++;

                            endforeach;
                            ?>
                        </tbody>
                    </table>

                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="100%" align="left" align="top">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td width="35%" align="center">
                                            <div>Mengetahui<br> Kepala Ruangan</div>
                                            <div style="margin-top:60px;"><?php echo isset($modPesan->pegmengetahui_id) ? $modPesan->pegawaimengetahui->NamaLengkap : "" ?></div>
                                        </td>
                                        <td width="35%" align="center">
                                        </td>
                                        <td width="35%" align="center">
                                            <div>Dibuat Oleh :</div>
                                            <div style="margin-top:60px;"><?php echo isset($modPesan->pegpemesan_id) ? $modPesan->pegawaipemesan->NamaLengkap : "" ?></div>
                                            <div>(Petugas Pemesan)</div>
                                        </td>
                                    </tr>
                                </table>
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
    <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php } ?>
</div>

<?php
if (isset($caraPrint)) {
} else {
?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print&id=' . $modPesan->pesanbarang_id);
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
<?php } ?>