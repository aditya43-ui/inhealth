<style>

    @page {
        margin-top: 0.5cm;
    }

    @media print {
        #headers {
            position: fixed;
            top: 0;
        }

        body {
            display:table;
            table-layout:fixed;
            padding-top:7cm;
            height:auto;
        }
    }

    body{
        width: 100%;
        color: black;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
    }

    .identitas td {
        vertical-align: top;
    }

    .rincian th, .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }

    .rincian tfoot td {
        font-weight: bold;
    }


    .table-rincian td, th{
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
    }

	TABLE, TBODY, TFOOT, TR, TH, TD{
		font-family: "Arial";
		font-size: 10px;
	}

    .tab_detail tfoot td, .footee {
        font-weight: bold;
    }

    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .tab_detail .closing td {
        border-bottom: 1px solid black;
    }

    .hddn {
        display: none;
    }
</style>
<?php
if (isset($_GET['caraPrint'])){
	if ($_GET['caraPrint'] == 'EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="grouplayanantindakandanfarmasi-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');
	}
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

$format = new MyFormatter;

$info = InformasipasiensudahbayarV::model()->findByAttributes(array(
    'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
));

$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
$masukkamar = empty($admisi) ? null : MasukkamarT::model()->findByAttributes(array(
    'pasienadmisi_id'=>$admisi->pasienadmisi_id,
), array(
    'order'=>'masukkamar_id desc',
));
$tandabukti = TandabuktibayarT::model()->findByAttributes(array(
    'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
));

// var_dump($masukkamar->attributes); die;

$grp = array();

$modGroup = GrouplayananM::model()->findAllByAttributes(array(
    'grouplayanan_aktif'=>true,
), array(
    'order'=>'grouplayanan_order',
));

foreach ($modGroup as $item) {
    // var_dump($item->attributes);

    $grp[$item->grouplayanan_id] = array(
        'kode'=>$item->grouplayanan_kode,
        'name'=>$item->grouplayanan_nama,
        'breakdown'=>$item->grouplayanan_breakdown,
        'is_alkes'=>$item->is_oa,
        // 'detail'=>array(),
        'value'=>0,
//        'instalasi'=>$item->instalasi_nama,
//        'ruangan'=>$item->ruangan_nama,
    );

}

// var_dump($grp);
// die;

// $grp = CJSON::decode($this->renderPartial('_templateAsuransi', array('grp' => &$grp), true));

$diskon = 0;
$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;
$grand_totals = 0;


// var_dump($grp);


$sisa = array();
// var_dump($tandabukti->attributes); die;

$modGroupLain = GrouplayananM::model()->findByAttributes(array(
    'grouplayanan_kode'=>'GL-018',
));
$modGroupPendaftaran = GrouplayananM::model()->findByAttributes(array(
    'grouplayanan_kode'=>'GL-001',
));



$grp[$modGroupPendaftaran->grouplayanan_id]['value'] = 0;
$groupTindakanAlkes = array();
foreach ($modRincians as $item) {

    $group_id = null;

    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;

    $unit_name = $item->getNamaUnitGrupRincian($modPendaftaran, $admisi);
//    foreach ($modGroup as $itemgr) {
//        $grp[$itemgr->grouplayanan_id]['instalasi']=$item->instalasi_nama;
//    }

    /*
    if (empty($grp[$unit_name])) {
        $grp[$unit_name] = array(
            'nama'=>$unit_name,
            'content'=>array(),
        );
    }
     *
     */





    if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;

    $diskon += $item->discount_tindakan;


    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;

    // $itemsubtotal = ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    $itemsubtotal = $item->tarif_tindakanpelayanan;

    $item->tarif_satuan = round($item->tarif_satuan);
    $subtotalkotor += round($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    $subtotal += round($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);


    $nama_tindakan = $item->daftartindakan_nama;
    $tarif_daftar = $nama_tindakan.".".$item->daftartindakan_id;
    $tarif_satuan = MyFormatter::formatNumberForPrint($item->tarif_satuan);



    $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
    $konfigPembulatan = Yii::app()->user->getState('pembulatanhargakasir');
    $jmlBulat = 0;
    if($konfigPembulatan > 0){
        $nilaibulat = ceil(($grand_totals)/$konfigPembulatan)*$konfigPembulatan;
        $jmlBulat = $nilaibulat - $grand_totals;

        if($konfigPembulatan == $jmlBulat){
           $jmlBulat = 0;
        }
    }
    $grand_totals = $grand_totals; //+$jmlBulat;



    $group_id = $modGroupLain->grouplayanan_id;
//   echo '<pre>';
//                print_r($grp);

    if (!$item->is_alkes) {
        $tindakan = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
        $dat = GrouplayanankasirM::model()->findByAttributes(array(
            'daftartindakan_id'=>$item->daftartindakan_id,
        ));

        $group_id = $modGroupLain->grouplayanan_id;
//        echo '<br>==========s=========';
//        echo '<br>';
//        echo '===  '.$group_id;
//        echo '<br>';
//        echo '==p=  '.$grouppp_id;
//        echo '<br>';
//        echo '=b==  '.$grp[$group_id]['breakdown'];

        foreach ($modGroup as $a){
            $idgrp = $a->grouplayanan_id;
            if ($grp[$idgrp]['breakdown']) {
                if (empty($grp[$idgrp]['detail'])) {
                 $grp[$idgrp]['detail'] = array();
                }
//                echo '<pre>';
//                print_r($item->instalasi_nama);
                if (empty($grp[$idgrp]['detail']["T.".$item->daftartindakan_id])) {
                    $grp[$group_id]['detail']["T.".$item->daftartindakan_id] = array(
                        'instalasi'=>$item->instalasi_nama,
                        'ruangan'=>$item->ruangan_nama,
                        'name'=>$item->daftartindakan_nama,
                        'qty'=>$item->qty_tindakan,
                        'satuan'=>'',
                        'value'=>$itemsubtotal,
                    );
                }
//                echo '== '.$item->qty_tindakan;
//                $grp[$idgrp]['detail']["T.".$item->daftartindakan_id]['qty'] += $item->qty_tindakan;
//                $grp[$idgrp]['detail']["T.".$item->daftartindakan_id]['value'] += $itemsubtotal;
            }
        }

        if (!empty($dat)) {
            $group_id = $dat->grouplayanan_id;
        }
        // var_dump($tindakan->daftartindakan_karcis);


        if ($grp[$group_id]['breakdown']) {

            if (empty($grp[$group_id]['detail'])) {
                $grp[$group_id]['detail'] = array();
            }

            if ($grp[$group_id]['kode'] == 'GL-012') {
                if (empty($grp[$group_id]['detail']["K.".$item->kelaspelayanan_id])) {
                    $grp[$group_id]['detail']["K.".$item->kelaspelayanan_id] = array(
                        'name'=>$item->kelaspelayanan_nama,
                        'qty'=>0,
                        'satuan'=>'Hari',
                        'value'=>0,
                    );
                }
                $grp[$group_id]['detail']["K.".$item->kelaspelayanan_id]['qty'] += $item->qty_tindakan;
                $grp[$group_id]['detail']["K.".$item->kelaspelayanan_id]['value'] += $itemsubtotal;
            } else {

                if (empty($grp[$group_id]['detail']["T.".$item->daftartindakan_id])) {
                    $grp[$group_id]['detail']["T.".$item->daftartindakan_id] = array(
                        'name'=>$item->daftartindakan_nama,
                        'qty'=>0,
                        'satuan'=>'',
                        'value'=>0,
                    );
                }
                $grp[$group_id]['detail']["T.".$item->daftartindakan_id]['qty'] += $item->qty_tindakan;
                $grp[$group_id]['detail']["T.".$item->daftartindakan_id]['value'] += $itemsubtotal;
            }

        }

        $grp[$group_id]['value'] += $itemsubtotal;


        // var_dump($group_id);

        // $grp[$group_id]['value'] += $itemsubtotal;
        $groupTindakanAlkes['TINDAKAN'][]=array('name'=>$tindakan->daftartindakan_nama,'value'=>$itemsubtotal,'qty'=>$item->qty_tindakan,'satuan'=>'');

    } else {
        $oa = ObatalkesM::model()->findByPk($item->daftartindakan_id);
        $jenis = JenisobatalkesM::model()->findByPk($oa->jenisobatalkes_id);
        $dat = GrouplayanankasiroaM::model()->findByAttributes(array(
            'jenisobatalkes_id'=>$oa->jenisobatalkes_id,
        ));

        $group_id = $modGroupLain->grouplayanan_id;

//echo '==========s========= <br>';
//        echo '===  '.$group_id;
        if (!empty($dat)) {
            $group_id = $dat->grouplayanan_id;
        }

        if ($grp[$group_id]['breakdown']) {
            if (empty($grp[$group_id]['detail'])) {
                $grp[$group_id]['detail'] = array();
            }
            if (empty($grp[$group_id]['detail']["O.".$item->daftartindakan_id])) {
                $grp[$group_id]['detail']["O.".$item->daftartindakan_id] = array(
                    'name'=>$item->daftartindakan_nama,
                    'qty'=>0,
                    'satuan'=>null,
                    'value'=>0,
                );
            }
            $grp[$group_id]['detail']["O.".$item->daftartindakan_id]['qty'] += $item->qty_tindakan;
            $grp[$group_id]['detail']["O.".$item->daftartindakan_id]['value'] += $itemsubtotal;

        }

        $grp[$group_id]['value'] += $itemsubtotal;
        $groupTindakanAlkes['FARMASI'][]=array('name'=>$oa->obatalkes_nama,'value'=>$itemsubtotal,'qty'=>$item->qty_tindakan,'satuan'=>null);

    }
}
//exit();
$subr = $modPembayaran->totalsubsidirs;

// var_dump($grp);

//echo '<pre>';
//print_r($grp);
//exit();
// $grp[10]['value'] = $tandabukti->biayaadministrasi;


// var_dump($grp);

/*
// if (empty($admisi)) {
    // cleanup
    foreach ($grp as $idx => $item) {
        if (isset($item['detail'])) {
            foreach ($item['detail'] as $idx2 => $item2) {
                if (isset($item2['detail'])) {
                    foreach ($item2['detail'] as $idx3 => $item3) {
                        if ($item3['value'] == 0) unset($grp[$idx]['detail'][$idx2]['detail'][$idx3]);
                    }
                } else {
                    if (isset($item2['value']) && $item2['value'] == 0)
                        unset($grp[$idx]['detail'][$idx2]);
                }


            }
        } else {
            if (isset($item['value']) && $item['value'] == 0)
                unset($grp[$idx]);
        }
    }

    foreach ($grp as $idx => $item) {
        if (isset($item['detail'])) {
            if (count((array)$item['detail']) == 0)
                unset ($grp[$idx]);
            else {
                foreach ($item['detail'] as $idx2 => $item2) {
                    if (isset($item2['detail'])) {
                         if (count((array)$item2['detail']) == 0)
                            unset ($grp[$idx]['detail'][$idx2]);
                    }
                }
            }
        }
    }
// }

/*
if (count((array)$sisa) > 0) {
    foreach ($sisa as $item) {
        var_dump($item->daftartindakan_nama, $item->instalasi_nama, $item->ruangan_nama);
    }
    die;
}
 *
 */
//     die;

?>

<div id='headers'>

<?php
// if (!isset($_GET['frame'])){
//     echo $this->renderPartial($this->path_view.'_headerPrint');
// }
?>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); ?>
<div style="text-align: center; font-weight: bold; font-size: 16pt">
  GRUP LAYANAN TINDAKAN DAN FARMASI
</div>

<!-- <h3 style="text-align: center;">
    RINCIAN BIAYA PERAWATAN
    <?php // echo !empty($admisi) ? 'RINCIAN BIAYA PERAWATAN' : 'REKAP RINCIAN BEAYA PENGOBATAN DAN PERAWATAN';?> -->
<!-- </h3> -->
<br/>
<?php echo $this->renderPartial($this->path_view.'_headerSudahBayar', array(
    'modPembayaran'=>$modPembayaran,
    'modPendaftaran'=>$modPendaftaran,
    'admisi'=>$admisi,
    'grand_totals'=>$grand_totals,
    'subtotalkotor'=>$subtotalkotor,
    'pasien'=>$pasien,
    'masukkamar'=>$masukkamar,
    'asuransi'=>$asuransi,
), true); ?>

</div>

<br/>

<table width="100%" class="tab_detail">
    <thead style=''>
      <th style='text-align: left;' colspan='2'>GRUP TINDAKAN DAN LAYANAN</th>
      <th style='text-align: center;'>SUBTOTAL</th>
    </thead>
    <tbody>
      <?php
        foreach ($groupTindakanAlkes as $name => $valGrp) {
          if(count((array)$valGrp) > 0){
            ?>
            <tr>
            <td colspan="3"><strong><?php echo $name; ?></strong></td>
            </tr>
            <?php
            foreach ($valGrp as $detailGrp) {
              ?>
              <tr>
                  <td>
                    &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $detailGrp['name']; ?>
                  </td>
                  <td style="text-align: right;">
                  <?php
                      // if (isset($detailGrp['qty']) && $detailGrp['qty'] != 0 && !$detailGrp($detailGrp['satuan'])) {
                      //     $values = round($detailGrp['value'] / $detailGrp['qty']);
                      //
                      //     echo " ".$detailGrp['qty']." ".$detailGrp['satuan']." @ ".MyFormatter::formatNumberForPrint($values, 2);
                      // }
                  ?>
                  </td>
                  <td style="text-align: right; width:100px;"><strong><?php echo $detailGrp['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($detailGrp['value'], 2, true); ?></strong></td>
              </tr>
              <?php
            }
          }
        }
       ?>

        <?php //$aas = 0; foreach ($grp as $item) :

            //if ($item['value'] == 0) continue;

//              var_dump($item['name']); die;
            ?>
        <!-- <tr>
        <td><strong><?php //echo $item['name']; ?></strong></td>
        <td></td>
        <td style=" width:100px;"></td>
        <td style="text-align: right; width:100px;"><strong><?php //echo $item['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item['value']); ?></strong></td>

        </tr> -->

        <?php

        ?>

        <?php //if (isset($item['detail'])) {
            //  $ruangandt = array();
            // if($item['kode']=='GL-018'){
            //     $rua = array();
            //     $i=0;
            //     $j=0;
            //     foreach ($item['detail'] as $item2) {
            //         $ruangandt[] = $item2['instalasi'] ." - ". $item2['ruangan'];
            //     }
            //
            // }

//             if (count((array)$ruangandt)>0){
//                foreach ($resultRuangan as $aa){
//
//                     foreach ($item['detail'] as $item2){
//                         if(trim($aa)==trim($item2['instalasi'] ." - ". $item2['ruangan'])){
//                             echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$item2['name'].'</td></tr>';
//                         }
//                     }
//                }
//             }





//            foreach ($item['detail'] as $item2):
//                if (count((array)$ruangandt)>0){
//
//                     foreach ($resultRuangan as $ruang){
//                          echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.$ruang.'</td></tr>';
//                     }
//                     if(trim($aa)==trim($item2['instalasi'] ." - ". $item2['ruangan'])){
                ?>
        <?php
         // if (count((array)$ruangandt)>0){
         //     $resultRuangan = array_unique($ruangandt);
         //
         //      foreach ($resultRuangan as $ruang){
         //          echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.$ruang.'</td></tr>';
         //     foreach ($item['detail'] as $item2){
         //  if(trim($ruang)==trim($item2['instalasi'] ." - ". $item2['ruangan'])){
        ?>
        <!-- <tr>

            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
            <?php
                //echo $item2['name'];
            ?>
            <!-- </td>
            <td style="text-align: right;"> -->
            <?php
                // if (isset($item2['qty']) && $item2['qty'] != 0 && !empty($item2['satuan'])) {
                //     $values = round($item2['value'] / $item2['qty']);
                //
                //     echo " ".$item2['qty']." ".$item2['satuan']." @ ".MyFormatter::formatNumberForPrint($values);
                // }
            ?>
            <!-- </td>
            <td style="text-align: right; width:100px;"><strong><?php //$aas+= $item2['value']; echo $item2['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item2['value']); ?></strong></td>
            <td style="width:100px;"></td>
        </tr> -->

        <?php
        //          }
        //     }
        // }
        // }else{
        //     foreach ($item['detail'] as $item2){
            ?>

        <!-- <tr>

            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
              <?php
                // echo $item2['name'];
            ?>
            <!-- </td>
            <td style="text-align: right;"> -->
            <?php
                // if (isset($item2['qty']) && $item2['qty'] != 0 && !empty($item2['satuan'])) {
                //     $values = round($item2['value'] / $item2['qty']);
                //
                //     echo " ".$item2['qty']." ".$item2['satuan']." @ ".MyFormatter::formatNumberForPrint($values);
                // }
            ?>
            <!-- </td>
            <td style="text-align: right; width:100px;"><strong><?php //echo $item2['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item2['value']); ?></strong></td>
            <td style="width:100px;"></td>
        </tr> -->
            <?php //}
        //} ?>

        <?php // endforeach;
        //} ?>
        <?php //endforeach; ?>

        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="2"><b>TOTAL BIAYA PELAYANAN<b/></td>
            <!-- <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($diskon); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($suba); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($subp); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($subr); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($subtotal); ?></td> -->
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor,2); ?></td>
        </tr>
        <?php //if ($tandabukti->biayaadministrasi != 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Administrasi</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi, 2); ?></td>
            </tr> -->
        <?php //endif; ?>

        <?php



        $modSubsidi = SubsidikelasT::model()->findByAttributes(array(
            'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
        ));

        $kelas_master = array(
            Params::KELASPELAYANAN_ID_KELAS_III => 1,
            Params::KELASPELAYANAN_ID_KELAS_II => 2,
            Params::KELASPELAYANAN_ID_KELAS_I => 3
        );

        // var_dump($kelas); die;

        $bkelas = array();

        if (!empty($modSubsidi)) {

        ?>

        <?php //if ($modPembayaran->totaldiscount != 0): ?>
            <!-- <tr class="footee">
                <td colspan="3">Potongan</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
            </tr> -->
            <?php //endif; ?>

        <?php //if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
        <!-- <tr class="grand_total footee">
            <td colspan="3">TOTAL</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
        </tr> -->
        <?php //endif; ?>

        <?php


            $suba = 0;
            $modPembayaran->totalsubsidiasuransi = 0;


            /*
            foreach ($modSubsidi as $item) {

                if (!empty($admisi) && $item->kelaspelayanan_id == $admisi->kelaspelayanan_id) {
                    $bkelas[0] = array(
                        'kelas'=>$item->kelaspelayanan_id,
                        'value'=>$item->subsidiasuransi,

                    );
                }

                if (!empty($asuransi) && $item->kelaspelayanan_id == $asuransi->kelastanggunganasuransi_id) {
                    $bkelas[1] = array(
                        'kelas'=>$item->kelaspelayanan_id,
                        'value'=>$item->subsidiasuransi,
                    );
                }
            }

            // var_dump($bkelas); die;
            ksort($bkelas);


            foreach ($bkelas as $item) {
             *
             */
                $suba += $modSubsidi->subsidiasuransi;
                $modPembayaran->totalsubsidiasuransi += $modSubsidi->subsidiasuransi;
                $kelas = KelaspelayananM::model()->findByPk($modSubsidi->kelaspelayanan_id);
        ?>
        <!-- <tr class="closing footee">
            <td colspan="3">INA <?php //echo $kelas->kelaspelayanan_nama; ?></td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi); ?></td>
        </tr> -->
        <?php //}

        // var_dump($bkelas, $kelas_master); die;

        ?>

        <?php //if ($modPembayaran->total_inacbg != 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Total INACBG</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
            </tr> -->
        <?php //endif; ?>

        <?php // if ($suba < ($subtotalkotor + $tandabukti->biayaadministrasi)) {

        $ekses = $modSubsidi->subsidiasuransi - $modPembayaran->total_inacbg;
        /*
            $bcount = count((array)$bkelas);




            if ($bcount != 0) {
                if ($bcount == 1) {
                    if (empty($bkelas[0])) {
                        $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi - $modPembayaran->totaldiscount) - $bkelas[1]['value'];
                    } else {
                        $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi - $modPembayaran->totaldiscount) - $bkelas[0]['value'];
                    }
                } else {
                    $kelas_a = $bkelas[0];
                    $kelas_b = $bkelas[1];

                    if ($kelas_master[$kelas_a['kelas']] > $kelas_master[$kelas_b['kelas']]) {
                        $ekses = $kelas_a['value'] - $kelas_b['value'];
                    } else {
                        $ekses = $kelas_b['value'] - $kelas_a['value'];
                    }
                }
            }
            if ($ekses < 0) $ekses = 0;
         *
         */

        if ($ekses > 0) : ?>

            <?php //if ($tandabukti->jmlpembulatan != 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembulatan</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
            </tr> -->
            <?php //endif; ?>

            <?php
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)):

            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            $ekses -= $jml_uangmuka;
            $ekses += $tandabukti->jmlpembulatan;

            ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Total Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="3">Pemakaian Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="3">Sisa Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
            </tr> -->

            <?php endif; ?>

            <!-- <tr class="closing footee">
                <td colspan="3">Dibayar Oleh Pasien</td>
                <td style="text-align: right;"><?php
                // echo MyFormatter::formatNumberForPrint($ekses); ?>
              </td>
            </tr> -->
            <?php //if ($tandabukti->bank_nominal > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembayaran Non-Tunai</td><td style="text-align: right;">(<?php //echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?>)</td>
            </tr> -->
            <?php //endif; ?>


            <?php //if ($ekses - $tandabukti->bank_nominal > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembayaran Tunai</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal); ?></td>
            </tr> -->
            <?php //endif; ?>



            <?php //if ($ekses - $tandabukti->bank_nominal): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Diterima Kasir</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal); ?></td>
            </tr> -->
            <?php //endif; ?>

            <?php //if ($modPembayaran->selisihuntungrugibpjs != 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Selisih Keuntungan/Kerugian BPJS</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs, 0, true); ?></td>
            </tr> -->
            <?php //endif; ?>

        <?php endif; ?>
        <?php

        //    }
        } else {

        ?>
            <?php //if ($modPembayaran->totaldiscount != 0): ?>
            <!-- <tr class="footee">
                <td colspan="3">Potongan</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
            </tr> -->
            <?php //endif; ?>


            <?php //if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
            <!-- <tr class="grand_total footee">
                <td colspan="3">TOTAL</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
            </tr> -->
            <?php //endif; ?>

            <?php //if ($modPembayaran->total_inacbg != 0): ?>
                <!-- <tr class="closing footee">
                    <td colspan="3">Total INACBG</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
                </tr> -->
            <?php //endif; ?>

                <?php //if ($modPembayaran->totalsubsidiasuransi != 0): ?>
                <!-- <tr class="closing footee">
                    <td colspan="3">Dijamin Asuransi</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidiasuransi); ?></td>
                </tr> -->

                <?php //endif; ?>
                <?php if ($subp > 0): ?>
                <!-- <tr class="closing footee">
                    <td colspan="3">Dijamin Pemerintah</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($subp); ?></td>
                </tr> -->
                <?php endif; ?>
                <?php if ($subr > 0): ?>
                <!-- <tr class="closing footee">
                    <td colspan="3">Dijamin RS</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($subr); ?></td>
                </tr> -->
                <?php endif; ?>


            <?php if ($tandabukti->jmlpembulatan != 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembulatan</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
            </tr> -->
            <?php endif; ?>

            <?php
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)):

            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Total Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="3">Pemakaian Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="3">Sisa Uang Muka</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
            </tr> -->

            <?php endif; ?>


            <?php

            $great_total = ($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) - $jml_uangmuka) + $tandabukti->jmlpembulatan;

            if (($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr)) > 0 && (($modPembayaran->penjamin_id != Params::PENJAMIN_ID_UMUM && !empty($admisi)) || (!empty($bayaruangmuka) && $bayaruangmuka->pemakaianuangmuka > 0))): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($great_total); ?></td>
            </tr> -->
            <?php

            endif; ?>

            <?php if ($tandabukti->bank_nominal > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembayaran Non-Tunai</td><td style="text-align: right;">(<?php //echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?>)</td>
            </tr> -->
            <?php endif; ?>


            <?php if ($great_total - $tandabukti->bank_nominal > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Pembayaran Tunai</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($great_total - $tandabukti->bank_nominal); ?></td>
            </tr> -->
            <?php endif; ?>


            <?php if ($great_total - $tandabukti->bank_nominal + $tandabukti->jmlpembulatan > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="3">Diterima Kasir</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($great_total - $tandabukti->bank_nominal); ?></td>
            </tr> -->
            <?php endif; ?>


        <?php } ?>
    </tbody>

</table>
<br/><br/>


<?php
if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_BILLINGKASIR){
    if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
	echo "&nbsp;";
	echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-success','onclick'=>"printExcel();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayarGrup", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
    }

	function printExcel(){
		var pegawai_id = '<?php echo Yii::app()->user->getState('pegawai_id') ?>';

		<?php
			if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))){
		?>
				window.open("<?php echo Yii::app()->createUrl("billingKasir/pembayaranTagihanPasien/PrintRincianSudahBayarGrup&caraPrint=EXCEL", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
		<?php
			}else{
		?>
				myAlert("Anda tidak berhak untuk mengakses fungsi ini","Perhatian!");
		<?php
			}
		?>


    }
    </script>
<?php
}else{
?>
    <table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td align='center'>Pasien / Keluarga Pasien</td>
            <td align='center'></td>
            <td align='center'>Bagian Keuangan</td>
        </tr>
        <tr height='100px'>
            <td align='center'>__________________</td>
            <td align='center'></td>
            <td align='center'><?php
            $nama = "";
            $id = Yii::app()->user->getState('pegawai_id');

            if (!empty($id)) {
                $peg = PegawaiM::model()->findByPk($id);
                echo $peg->namaLengkap;
            } else {
                echo "__________________";
            }

            ?></td>
        </tr>
    </table>
<?php
}}
?>
