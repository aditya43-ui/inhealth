<style>

    @page {
        margin-top: 1.5cm;
    }

    @media print {
        #headers {
            position: fixed;
            top: 0;
        }

        body {
            display:table;
            table-layout:fixed;
            padding-top:6.5cm;
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
		font-size: 12px;
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

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

$format = new MyFormatter;


$info = new InformasipasiensudahbayarV;

$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
$masukkamar = empty($admisi) ? null : MasukkamarT::model()->findByAttributes(array(
    'pasienadmisi_id'=>$admisi->pasienadmisi_id,
), array(
    'order'=>'masukkamar_id desc',
));
$penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);

$verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'verifikasitagihan_id desc',
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
$admin = 0;
$jasafarmasi = 0;


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

    if($item->is_alkes){
        if ($item->qty_tindakan <= 0) continue;
    }

    if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;

    $diskon += $item->discount_tindakan;


    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;

    // $itemsubtotal = ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;

    // if ($item->is_alkes) {
      $itemsubtotal = $item->tarif_hargajual;
    // }
    $subtotalkotor += $itemsubtotal;
    // $subtotalkotor += ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    // $subtotal += ($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    $subtotal += $itemsubtotal - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

    $jasafarmasi += $item->jasapelayanan_farmasi;

    $nama_tindakan = $item->daftartindakan_nama;
    $tarif_daftar = $nama_tindakan.".".$item->daftartindakan_id;
    $tarif_satuan = MyFormatter::formatNumberForPrint($item->tarif_satuan);



    $grand_totals = $subtotalkotor;

    $group_id = $modGroupLain->grouplayanan_id;

    if (!$item->is_alkes) {
        $tindakan = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
        $pelayanan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);

        if (!empty($pelayanan->tindakansudahbayar_id)) continue;

        $dat = GrouplayanankasirM::model()->findByAttributes(array(
            'daftartindakan_id'=>$item->daftartindakan_id,
        ));

        $group_id = $modGroupLain->grouplayanan_id;

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
        $oap = ObatalkespasienT::model()->findByPk($item->tindakanpelayanan_id);

        if (!empty($oap->oasudahbayar_id)) continue;

        $jenis = JenisobatalkesM::model()->findByPk($oa->jenisobatalkes_id);
        $dat = GrouplayanankasiroaM::model()->findByAttributes(array(
            'jenisobatalkes_id'=>$oa->jenisobatalkes_id,
        ));

        $group_id = $modGroupLain->grouplayanan_id;


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

if (!empty($admisi)) {
    if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
        $admin = $verifikasi->biaya_administrasi;
    } else {
        $admin = $subtotalkotor * $penjamin->biaya_administrasi / 100;
    }
}
$grand_totals = $subtotalkotor + $admin + $jasafarmasi;
// var_dump($grp);
// echo '<pre>';
// print_r($groupTindakanAlkes);
// exit();

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
    <?php // echo !empty($admisi) ? 'RINCIAN BIAYA PERAWATAN' : 'REKAP RINCIAN BEAYA PENGOBATAN DAN PERAWATAN';?>
</h3> -->
<br/>
<?php echo $this->renderPartial('_headerBelumBayar', array(
    // 'modPembayaran'=>$modPembayaran,
    'modPendaftaran'=>$modPendaftaran,
    'admisi'=>$admisi,
    'grand_totals'=>$grand_totals,
    'subtotalkotor'=>$subtotalkotor,
    'pasien'=>$pasien,
    'masukkamar'=>$masukkamar,
    'asuransi'=>$asuransi
), true);

?>

</div>

<br/>
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
        <?php //foreach ($grp as $item) :

            //if ($item['value'] == 0) continue;

            //  var_dump($item['value']); die;
            ?>
        <!-- <tr>
        <td><strong><?php //echo $item['name']; ?></strong></td>
        <td></td>
        <td style=" width:100px;"></td>
        <!-- <td style="text-align: right; width:100px;"><strong><?php //echo $item['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item['value'], 2); ?></strong></td> -->

        <!-- </tr> -->
        <?php //if (isset($item['detail'])) {
            //foreach ($item['detail'] as $item2): ?>
        <!-- <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php
                //echo $item2['name'];
            ?>
            </td>
            <td style="text-align: right;">
            <?php
                // if (isset($item2['qty']) && $item2['qty'] != 0 && !empty($item2['satuan'])) {
                //     $values = round($item2['value'] / $item2['qty']);
                //
                //     echo " ".$item2['qty']." ".$item2['satuan']." @ ".MyFormatter::formatNumberForPrint($values);
                // }
            ?>
            </td>
            <td style="text-align: right; width:100px;"><strong><?php //echo $item2['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item2['value'], 2); ?></strong></td>
            <!-- <td style="width:100px;"></td> -->
        <!-- </tr>  -->



        <?php //endforeach;
        //} ?>
        <?php //endforeach; ?>

        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="2" style="font-weight: bold">TOTAL BIAYA PELAYANAN</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor, 2); ?></td>
        </tr>
        <?php if ($admin > 0): ?>
            <tr class="closing footee">
                <td colspan="2">Administrasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($admin, 2); ?></td>
            </tr>
           
        <?php endif; ?>
        <?php if ($jasafarmasi > 0): ?>
            <tr class="closing footee">
                <td colspan="2">Jasa Pelayanan Farmasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jasafarmasi, 2); ?></td>
            </tr>
           
        <?php endif; ?>
        <tr class="closing footee">
            <td colspan="2">TOTAL</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals, 2); ?></td>
        </tr>
        


    </tbody>

</table>
<br/><br/>


<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/printRincianBelumBayarGrup", array(
            "instalasi_id"=>$_GET['instalasi_id'],
            'pendaftaran_id'=>$_GET['pendaftaran_id'],
            'pasienadmisi_id'=>!isset($_GET['pasienadmisi_id'])?null:$_GET['pasienadmisi_id'],
        )) ?>","",'location=_new, width=1024px');
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
}
?>
