<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>
<style>
    table.a tr td {
        vertical-align: top;
    }

    table.a tr td label {
        font-size: 13pt;
    }

    table.a tr td {
        font-size: 13pt;
    }

    table tr td label {
        /*      font-size:8pt;*/
    }

    table tr td {
        /*      font-size:8pt;*/
    }

    .header_detail h4 {
        /*        font-size: 8pt;*/
    }

    /*   @media (min-width:0px) and (max-width: 1000px) {
    table
    {
        width:100%;
        padding:10px;
    }
    
}*/
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                                    
                                    // echo '<pre>'; var_dump($modReseptur->attributes); die;
                                    
                                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table width="100%" class="a">
                        <tr>
                            <td width='22%'>
                                <label class='control-label'>No. RM / No. Pendaftaran</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->no_rekam_medik; ?> / <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                            <td width='15%'>
                                <label class='control-label'>Jenis Penjamin</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo isset($modPendaftaran->carabayar->carabayar_nama) ?$modPendaftaran->carabayar->carabayar_nama :"-";  ?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Nama Pasien</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
                            <td width='20%'>
                                <label class='control-label'>Jenis Pelayanan</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo isset($modPendaftaran->instalasi->instalasi_nama) ? $modPendaftaran->instalasi->instalasi_nama : "-";?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Tgl. Lahir/Umur</label>
                            </td>
                            <td>:</td>
                            <td width='35%'><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) ?> / <?php echo $modPendaftaran->umur; ?></td>
                            <td width='15%'>
                                <label class='control-label'>No. Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->noresep; ?></td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Alamat</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                            <td width='20%'>
                                <label class='control-label'>Dokter Penulis Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->GetNamaLengkapPegawai($modReseptur->pegawai_id); ?></td>
                 
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Outlet</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->ruangan->ruangan_nama; ?></td>
                            <td width='15%'>
                                <label class='control-label'>Tanggal Resep</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->tglreseptur; ?></td>
                            
                        </tr>
                        <tr>
                            <td width='15%'>
                                <label class='control-label'>Tgl. Pelayanan</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo !empty($modReseptur->tglreseptur) ? MyFormatter::formatDateTimeForUser($modReseptur->tglreseptur) : '-'; ?></td>
                            <td width='15%'>
                                <label class='control-label'>Ruangan</label>
                            </td>
                            <td>:</td>
                            <td width='35%'> <?php echo $modReseptur->ruanganreseptur->ruangan_nama; ?></td>
                     
                            
                        </tr>
                    </table>
                    <br><br>

                    <style>
                        .iter {
                            border-top: 2px solid #000000;
                            padding: 5px;
                            width: 100%;
                        }

                        .iter legend {
                            padding: 3px;
                            background: #ffffff;
                            color: #000000;
                            text-align: center;
                            width: 15%;
                            margin-left: 85%;
                            /*                font-size: 8pt;*/
                        }

                        @media (min-width:0px) and (max-width: 1000px) {
                            .iter {
                                width: 100%;
                            }
                        }
                    </style>
                    <?php foreach ($kerangkaLooping as $i => $detail) {

                    ?>
                        <?php

                        $criteriitem = new CDbCriteria;
                        $criteriitem->compare("reseptur_id", $detail->reseptur_id);
                        $criteriitem->compare("racikan_id", $detail->racikan_id);
                        $criteriitem->compare("rke", $detail->rke);
                        
                        // $criteriitem->addCondition("reseptur_id = " . $detail->reseptur_id);
                        // $criteriitem->addCondition("racikan_id = " . $detail->racikan_id);
                        // $criteriitem->addCondition("rke = " . $detail->rke);
                        
                        $items = ResepturdetailT::model()->findAll($criteriitem);

                        $R = $detail->rke;

                        ?>
                        <?php foreach ($items as $ii => $item) {
                            $obatlain = isset($item->obatlain_nama) ? "(".$item->obatlain_nama.")" : "";
                        ?>
                            <?php if ($item->racikan_id == Params::RACIKAN_ID_NONRACIKAN) { ?>
                                <table width="50%">
                                    <tbody>
                                        <tr style="font-size:15pt;">
                                            <td width="50">R     /<?php // echo $detail->rke; 
                                                                ?></td>
                                            <td style="border-left: 0; border-right: 0;"><b><?php echo $item->obatalkes->obatalkes_nama; ?></b></td>
                                            <td width="50">Jumlah </td>
                                            <td width="50">&nbsp;<?php echo $item->qty_reseptur; ?></td>

                                        <tr style="font-size:15pt;">
                                            <td></td>
                                            <td colspan="3"><?php echo empty($item->etiket) ? "" : ("∫ " . $item->etiket); ?></td>
                                        </tr>
                                        <tr style="font-size:15pt;">
                                            <td></td>
                                            <td colspan="3"><?php echo $item->dosis ?> - <?php echo $item->etiketwaktu ?> - <?php echo !empty($item->resepturketerangan) ? $item->resepturketerangan : "-"; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <table width="50%">
                                    <tbody>
                                        <tr style="font-size:15pt;">
                                            <td width="50">R/<?php echo $item->rke; ?></td>
                                            <td style="border-left: 0; border-right: 0;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
                                            <td><?php echo $item->permintaan_reseptur."".$item->satuankekuatan;?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>
                        <?php


                            $R = "";
                        } ?>
                        <?php if ($item->racikan_id == Params::RACIKAN_ID_RACIKAN) { ?>
                            <table width="50%">
                                <tbody>
                                    <tr style="font-size:12pt;">
                                        <td width="50">&nbsp;</td>
                                        <td style="font-weight: bold;"><?php echo "m.f.l.a. " . $item->satuansediaan . " No " . CustomFunction::Romawi(ceil($item->jmlkemasan_reseptur)); ?></td>
                                    </tr>
                                    <tr style="font-size:12pt;">
                                        <td width="50">&nbsp;</td>
                                        <td style="font-weight: bold;"><?php echo empty($item->etiket) ? "" : ("∫ " . $item->etiket); ?></td>
                                    </tr>
                                    <tr style="font-size:12pt;">
                                        <td width="50">&nbsp;</td>
                                        <td style="font-weight: bold;"><?php echo $item->dosis ?> - <?php echo $item->etiketwaktu ?> - <?php echo !empty($item->resepturketerangan) ? $item->resepturketerangan : "-"; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php }

                        ?>


                        <fieldset class='iter'>
                            <legend>Iter <?php echo $detail->iter; ?></legend>
                        </fieldset>
                    <?php } ?>
                    <table>
                        <tr>
                            <?php $date = date('Y-m-d'); ?>
                            <td>Dibuat di : <?php echo $modProfilRs->kabupaten->kabupaten_nama; ?>, <?php echo MyFormatter::formatDateTimeForUser($date); ?></td>
                        </tr>
                        <tr>
                            <td>
                                Resume medis elektronik ini syah tanpa tanda tangan, UU Pradok No 29/2004 Penjelasan Ps 46(3)
                            </td>
                        </tr>
                    </table>
                    <br>

                    <?php
                    if (isset($_GET['frame'])) {
                        echo CHtml::Link("<i class='entypo-print'></i> Print Resep Dokter", '#', array('class' => 'btn btn-info', "rel" => "tooltip", "title" => "Klik untuk print resep dari dokter", 'onclick' => 'printRecordTerakhir(\'PRINT\')'));
                        $urlPrintRecordTerakhir =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printResepDokter&id=' . $modReseptur->reseptur_id);
                        $js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
                        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                    
                    ?>
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
<?php } ?> 