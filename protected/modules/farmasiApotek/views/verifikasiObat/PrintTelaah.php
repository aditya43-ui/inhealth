    <style>
.barcode-label {
    margin-top: -20px;
    z-index: 1;
    text-align: center;
    letter-spacing: 10px;
}

td,
th {
    font-size: 6pt !important;
    /*        font-weight: bold;*/
}

body {
    width: 61mm;
}

.content {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
    color: #000000;
    height: 60mm;
    width: 70mm;
    margin: 6px 0px 30px 5px;
    position: relative;
}

@media print {
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 6pt !important;
    }

    body {
        width: 61mm;
        font-family:"Courier New", Courier, monospace;
    }

    .content {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        color: #000000;
        height: 6cm;
        width: 7cm;
        margin: 0px 0px 30px 5px;
        position: relative;
        margin-top: 1%;
    }
}

@page {
    margin-top: 1%;
}

.garis1 {
    border-top: 1px dotted;
    margin-top: 0px;
}

.garis2 {
    border-top: 2px solid black;
    /* margin-top: -10px; */
}

.garis3 {
    border-bottom: 3px solid black;
    /* margin-top: -10px; */
}

table tr,
table td {
    vertical-align: top;
    font-size: 10pt;
    line-height: 20px;
}

table {
    width: 100%;
}

.tbl-header tr,
.tbl-header td {
    font-weight: bold;
}

.tbl-telaah-resep td, .tbl-telaah-resep th {
  border: 1px solid;
  font-size: 8pt;
}

.tbl-telaah-resep {
  margin-left: 20px;
  width: 95%;
  border-collapse: collapse;
}

.tbl-telaah-obat td, .tbl-telaah-obat th {
  border: 1px solid;
  font-size: 8pt;
  border-collapse: collapse;
}

</style>

<?php

    // echo '<pre>'; var_dump("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 order by rke desc", $rke_max->rke); die;

    $profil = ProfilrumahsakitM::model()->find();



?><br><br>
<div style="margin-left: 20px;">
<div style="padding-top: 1px;padding-bottom: 1px;"></div>
<table class="tbl-header">
    <tr>
        <td>INSTALASI FARMASI</td>
    </tr>
    <tr>
        <td><?= $profil->nama_rumahsakit ?></td>
    </tr>
    <tr>
        <td><?= $profil->alamatlokasi_rumahsakit ?> Malang</td>
    </tr>
    <tr>
        <td>Telepon (0341) 362 101</td>
    </tr>
</table>
<br><br>
<div class="garis3"></div>
<table>
    <tr>
        <td style="width: 30%;">Resep</td>
        <td> : <?= $modPenjualan->penjamin->penjamin_nama ?></td>
    </tr>
    <tr>
        <td>Jenis Pelayanan</td>
        <td> : <?= $modPenjualan->instalasiasal_nama; ?></td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td> : <?= $modPenjualan->nojual_inv; ?></td>
    </tr>
    <tr>
        <td>Tgl. Resep</td>
        <td> : <?= MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan) ?></td>
    </tr>
    <tr>
        <td>Nama Dokter</td>
        <td> : <?= $modPenjualan->pegawai->namaLengkap ?? "-" ?></td>
    </tr>
    <tr>
        <td>Asal Klinik</td>
        <td> : <?= $modPenjualan->ruanganasal_nama; ?></td>
    </tr>
    <?php if($modPendaftaran->carabayar_id == 2):?>

    <?php endif;?>
</table><br><br>
<?php
    $alergi = [];
    if(!empty($modAnamnesa)) {
        foreach($modAnamnesa as $an) {
            array_push($alergi, $an->riwayatalergiobat);
        }
    }
?>
<div class="garis2"></div>
<table>
    <tr>
        <td colspan="2">
            ALERGI : <?= implode(", ", $alergi) ?>
        </td>
    </tr>
    <?php if(!empty($modResepturDet1)): ?>

        <?php $rke = 0; ?>

        <?php if(!empty($rke_max)):?>

            <?php

                // var_dump($rke_max); die;
                ?>

            <?php for($l = 1; $l <= $rke_max->rke; $l++):?>

                <?php 
                    $c1 = new CDbCriteria;
                    $c1->select = "sum(qty_oa) as jml_obat";
                    $c1->addCondition("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 and rke = $l");
                    $jml = ObatalkespasienT::model()->find($c1);

                    $reseptur = ResepturT::model()->find("penjualanresep_id = " . $modPenjualan->penjualanresep_id);

                    if(!empty($jml->jml_obat)) {

                        ?>

                        <?php
                            $c2 = new CDbCriteria;
                            $c2->addCondition("penjualanresep_id = " . $modPenjualan->penjualanresep_id." and racikan_id = 1 and rke = $l");
                            $c2->order = "rke, obatalkespasien_id";
                            $obat_load = ObatalkespasienT::model()->findAll($c2);

                            $jumlahpermintaan = $obat_load[0]->jumlahpermintaan_obatracikan;

                        ?>
                        
                        <tr>
                            <td style="width: 5%;" rowspan="4"><?= $obat_load[0]->r ?></td>
                            <td><?= "Racikan " . $l . " NO. " . MyFormatter::formatNumberForPrint($jumlahpermintaan) ?></td>
                        </tr>
                        
                       

                        <?php
                            $signa = !empty($obat_load) ? $obat_load[0]->signa_oa . " " . $obat_load[0]->satuansediaan : "-";
                            $etiket = !empty($obat_load) ? $obat_load[0]->etiket : "-";

                            // echo '<pre>'; var_dump(count($obat_load)); die;
                        ?>

                        <tr>
                            <td>Signa : <?= $signa ?></td>
                        </tr>
                       
                        <tr>
                            <td>Waktu Pemberian / Instruksi : <?= $etiket ?></td>
                        </tr>

                        <?php
                        if(!empty($obat_load)) {



                                ?>
                                
                                    <tr>
                                        <td>
                                            <table>
                                                <?php
                                                    foreach($obat_load as $ol) {

                                                        $det = ResepturdetailT::model()->find("reseptur_id = $reseptur->reseptur_id and obatalkes_id = $ol->obatalkes_id");

                                                        $permintaan = !empty($ol->permintaan_oa) ? $ol->permintaan_oa : "";
                                                        $satuansediaan = !empty($ol->satuansediaan) ? ("per " . $ol->satuansediaan) : "";
                                                        $satuankekuatan = !empty($ol->satuankekuatan_oa) ? ($ol->satuankekuatan_oa) : "";
                                                ?>
                                                    <tr><td>
                                                    <?= "*" . $ol->obatalkes->obatalkes_nama . " (dosis " . $permintaan . " " . $satuankekuatan . " " . $satuansediaan . ")" ?>
                                                    </td></tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    </tr>
                                
                                <?php

                            
                        }
                        ?>

                        <?php
                    }
    
                    
                ?>

            <?php endfor;?>
    
        <?php endif;?>
    <?php endif;?>
    <?php
            // echo '<pre>'; var_dump($modResepturDet2); die;
            ?>
    <?php if(!empty($modResepturDet2)): ?>



    <?php foreach($modResepturDet2 as $k => $det2): ?>

        
    <tr>
        <td style="width: 5%;" rowspan="3"><?= $det2->r ?></td>
        <td><?= $det2->obatalkes->obatalkes_nama . (($det2->racikan_id == 2 ? (" NO. " . MyFormatter::formatNumberForUser(floatval($det2->qty_oa))) : "")) ?></td>
    </tr>
    <tr>
        <td>Signa : <?= $det2->signa_oa . " " . $det2->satuansediaan ?></td>
    </tr>
    <tr>
        <td>Waktu Pemberian / Instruksi : <?= $det2->etiket ?></td>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
</table><br><br>
<div class="garis3"></div>
<table>
    <tr>
        <td style="width: 30%;">Pasien</td>
        <td> : <?= $modPasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td> : <?= $modPasien->alamat_pasien ?></td>
    </tr>
    <tr>
        <td>No. RM</td>
        <td> : <?= $modPasien->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td>Berat Badan</td>
        <td> : <?= !empty($modFisik) ? (!empty($modFisik->beratbadan_kg) ? ($modFisik->beratbadan_kg . " KG") : "") : "" ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td> : <?= date('d-m-Y', strtotime($modPasien->tanggal_lahir)) ?></td>
    </tr>
    <tr>
        <?php
            $sat1 = ['Thn', 'Bln', 'Hr'];
            $sat2 = ['Tahun', 'Bulan', 'Hari'];
        ?>
        <td>Usia</td>
        <td> : <?= str_replace($sat1, $sat2, $modPendaftaran->umur) ?></td>
    </tr>
    <tr>
        <td>No. SEP</td>
        <td> : <?= $modSep->nosep ?? '' ?></td>
    </tr>
    <tr>
        <td>Kartu Peserta</td>
        <td> : <?= $modSep->nokartuasuransi ?? '' ?></td>
    </tr>
</table><br><br>
<div class="garis2"></div>
<table>
    <tr>
        <?php
            $rl = Yii::app()->user->getState('ruangan_id');
            $ruangan = RuanganM::model()->findByPk($rl);
        ?>
        <td style="width: 20%;">Outlet</td>
        <td>: <?= $ruangan->ruangan_nama ?></td>
    </tr>
</table>
<table>
    <tr>
        <?php
            $rl = Yii::app()->user->getState('ruangan_id');
            $ruangan = RuanganM::model()->findByPk($rl);
        ?>
        <td style="width: 35%;">Tgl. Pelayanan Resep</td>
        <td>: <?= date('d-m-Y') ?></td>
    </tr>
</table>
<br><br>
<div style="font-size: 8pt;">Beri Tanda Cek ()</div>
<br>
<?php
    $telaah_resep = LookupM::model()->findAll("lookup_type = 'telaah_resep'");
    $telaah_obat = LookupM::model()->findAll("lookup_type = 'telaah_obat'");
    $penyerahan_obat_kie = LookupM::model()->findAll("lookup_type = 'penyerahan_obat_kie'");
?>
<table class="tbl-telaah-resep">
    <tr>
        <td colspan="3">Telaah Resep</td>
        <td colspan="2">Petugas <?= $modPenjualan->createlogin->namaLengkap ?></td>
        <td>TTD</td>
    </tr>
    <?php 
        if(!empty($telaah_resep)) {
            $len = intval(count($telaah_resep) / 2) + (count($telaah_resep) % 2);

            for($i = 0; $i < $len; $i++) {

                ?>
                <tr>
                    <td style=" width: 25px;">&nbsp;&nbsp;<?= isset($telaah_resep[$i]) ? ($i + 1) : "" ?></td>
                    <td><?= isset($telaah_resep[$i]) ? $telaah_resep[$i]->lookup_name : '' ?></td>
                    <td style="text-align: center; width: 25px;"><?php echo strpos($modPenjualan->kiepenyerahan, $telaah_resep[$i]->lookup_name) ? '&#x2713;' : '' ?></td>
                    <td style=" width: 25px;">&nbsp;&nbsp;<?= isset($telaah_resep[$i + $len]) ? ($i + $len + 1) : "" ?></td>
                    <td><?= isset($telaah_resep[$i + $len]) ? $telaah_resep[$i + $len]->lookup_name : '' ?></td>
                    <td style="text-align: center;"><?php echo strpos($modPenjualan->kiepenyerahan, $telaah_resep[$i + $len]->lookup_name) ? '&#x2713;' : '' ?></td>
                </tr>
                
                <?php

            } 
            // var_dump($len); die;
        }
    
    ?>
    
</table>
<br>
<div style="font-size: 8pt;">Telaah Obat</div>
<br>
<table class="tbl-telaah-resep">
        <tr>
            <td style="width: 40%;">Telaah Obat</td>
            <td style="width: 30%;">Petugas</td>
            <td>Petugas</td>
        </tr>
    
    <?php
        if(!empty($telaah_obat)) {

            foreach($telaah_obat as $i => $to) {
                ?>
                    <tr>
                        <td><?= ($i + 1) . ". " . $to->lookup_name ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                
                <?php
            }

        }
    ?>
</table>
<br>
<div style="font-size: 8pt;">Penyerahan Obat + KIE</div>
<br>
<table class="tbl-telaah-resep">
    <tr>
        <td>Telaah Resep</td>
        <td>&emsp;&emsp;&emsp;&emsp;</td>
        <td>Petugas</td>
        <td>&emsp;&emsp;&emsp;&emsp;</td>
    </tr>
    <?php 
        if(!empty($penyerahan_obat_kie)) {
            $len = intval(count($penyerahan_obat_kie) / 2) + (count($penyerahan_obat_kie) % 2);

            for($i = 0; $i < $len; $i++) {

                ?>
                <tr>
                    <td><?= isset($penyerahan_obat_kie[$i]) ? (($i + 1) . ". " . $penyerahan_obat_kie[$i]->lookup_name) : '' ?></td>
                    <td>&emsp;</td>
                    <td><?= isset($penyerahan_obat_kie[$i + $len]) ? ($i + $len + 1) . ". " . $penyerahan_obat_kie[$i + $len]->lookup_name : '' ?></td>
                    <td>&emsp;</td>
                </tr>
                
                <?php

            } 
            // var_dump($len); die;
        }
    
    ?>
    <tr>
        <td colspan="2" style="height: 100pt; text-align: center; vertical-align: bottom;">(Petugas & Paraf)</td>
        <td colspan="2" style="text-align: center; vertical-align: bottom;">(Pasien & TTD)</td>
    </tr>
    
</table>
    </div>