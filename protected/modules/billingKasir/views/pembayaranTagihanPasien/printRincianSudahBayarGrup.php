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
$detailRincian = array();
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
    // $itemsubtotal = $item->tarif_tindakanpelayanan;

    $item->tarif_satuan = ($item->tarif_satuan);


    if ($item->is_alkes) {
        $detBayar = OasudahbayarT::model()->findByAttributes(array(
            'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
            'obatalkespasien_id'=>$item->tindakanpelayanan_id
        ));

        // var_dump($detBayar->attributes); die;

        if ($modPembayaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
            $item_subtotal = $detBayar->jmlbayar_oa;
        } else {
            $item_subtotal = $detBayar->jmlsubsidi_asuransi;
        }
        // var_dump($detBayar->attributes); die;
    } else {
        $detBayar = TindakansudahbayarT::model()->findByAttributes(array(
            'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
            'tindakanpelayanan_id'=>$item->tindakanpelayanan_id
        ));

        // var_dump($detBayar->attributes); die;

        if ($modPembayaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
            $item_subtotal = $detBayar->jmlbayar_tindakan;
        } else {
            $item_subtotal = $detBayar->jmlsubsidi_asuransi;
        }
    }

    if ($item_subtotal == 0) continue;

    $subtotalkotor += $item_subtotal;
    $subtotal += $item_subtotal;
    $itemsubtotal = $item_subtotal;


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
        $pelayanan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);

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
        $detailRincian[] = array(
            'ruang'=>$item->ruangan_nama,
            'tanggal'=>date('Y-m-d', strtotime($item->tgl_tindakan)),
            'no_nota'=>$pelayanan->noNota,
            'kode'=>$tindakan->daftartindakan_kode,
            'uraian'=>$tindakan->daftartindakan_nama,
            'jumlah'=>$itemsubtotal,
        );
    } else {
        $oa = ObatalkesM::model()->findByPk($item->daftartindakan_id);
        $jenis = JenisobatalkesM::model()->findByPk($oa->jenisobatalkes_id);
        $dat = GrouplayanankasiroaM::model()->findByAttributes(array(
            'jenisobatalkes_id'=>$oa->jenisobatalkes_id,
        ));
        $pelayanan = ObatalkespasienT::model()->findByPk($item->tindakanpelayanan_id);

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
        
        // var_dump($pelayanan->attributes); die;
        $detailRincian[] = array(
            'ruang'=>$item->ruangan_nama,
            'tanggal'=>date('Y-m-d', strtotime($item->tgl_tindakan)),
            'no_nota'=>'-', //$modPendaftaran->no_pendaftaran.$pelayanan->nopelayanan,
            'kode'=>$oa->obatalkes_kode,
            'uraian'=>$oa->obatalkes_nama,
            'jumlah'=>$itemsubtotal,
        );
    }
}
//exit();
$subr = $modPembayaran->totalsubsidirs;

// var_dump($detailRincian, $groupTindakanAlkes);


?>

<div id='headers'>

<?php
// if (!isset($_GET['frame'])){
//     echo $this->renderPartial($this->path_view.'_headerPrint');
// }
?>
<?php echo $this->renderPartial($this->path_view.'_headerSudahBayarGrupKop', array()); ?>
<div style="text-align: center; font-weight: bold; font-size: 16pt">
    PERINCIAN BIAYA PASIEN
</div>

<!-- <h3 style="text-align: center;">
    RINCIAN BIAYA PERAWATAN
    <?php // echo !empty($admisi) ? 'RINCIAN BIAYA PERAWATAN' : 'REKAP RINCIAN BEAYA PENGOBATAN DAN PERAWATAN';?> -->
<!-- </h3> -->
<br/>
<?php echo $this->renderPartial($this->path_view.'_headerSudahBayarGrup', array(
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
<?php /*
<table width="100%" class="tab_detail">
    <thead style=''>
      <th style='text-align: left;' colspan='2'>URAIAN</th>
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
                  </td>
                  <td style="text-align: right; width:100px;"><strong><?php echo $detailGrp['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($detailGrp['value'], 2, true); ?></strong></td>
              </tr>
              <?php
            }
          }
        }
       ?>


        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="2"><b>TOTAL BIAYA PELAYANAN<b/></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor,2); ?></td>
        </tr>

    </tbody>

</table>
<br/>
*/ ?>
<table width="100%" class="tab_detail">
    <thead style=''>
        <tr>
            <th width="200" style='text-align: center; font-weight: bold;'>RUANG</th>
            <th width="80" style='text-align: center; font-weight: bold;'>TANGGAL</th>
            <th width="100" style='text-align: center; font-weight: bold;'>NO NOTA</th>
            <th width="120" style='text-align: center; font-weight: bold;'>KODE TARIF</th>
            <th style='text-align: center; font-weight: bold;'>URAIAN TARIF</th>
            <th width="110" style='text-align: center; font-weight: bold;'>JUMLAH</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detailRincian as $item): ?>
        <tr>
            <td><?php echo $item['ruang']; ?></td>
            <td><?php echo $item['tanggal']; ?></td>
            <td><?php echo $item['no_nota']; ?></td>
            <td><?php echo $item['kode']; ?></td>
            <td><?php echo $item['uraian']; ?></td>
            <td style="text-align: right";><?php echo MyFormatter::formatNumberForPrint($item['jumlah'], 0); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if ($tandabukti->jmlpembulatan > 0) : ?>
        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="5"><b>PEMBULATAN<b/></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
        </tr>
        <?php endif; ?>
        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="5"><b>TOTAL BIAYA PELAYANAN<b/></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint(round($subtotalkotor) + $tandabukti->jmlpembulatan,0); ?></td>
        </tr>
    </tbody>
</table>
<br/><br/>


<?php
// if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_BILLINGKASIR){
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
	// echo "&nbsp;";
	// echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-success','onclick'=>"printExcel();"));
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
}
// }
?>
