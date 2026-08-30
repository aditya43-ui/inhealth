<style>
    body {
        color: black;
    }

    .tab_header {
        width: 100%;
    }

    .tab_detail {
        width: 100%;
    }

    .tab_detail th,
    .tab_detail td {
        border: 1px solid black;
        padding: 3px;
    }

    .tab_detail th {
        font-weight: bold;
    }
</style>

<?php
$format = new MyFormatter;

$is_kronis = 0;
$button = $button_jual = $kronis = "";

$button_jual = CHtml::link(Yii::t('mds', '{icon} <b> Print INACBG </b>', array('{icon}' => '<i class="fas fa-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-blue', 'onclick' => "printBiasa('PRINT')"));


$modObatAlkes = ObatalkespasienT::model()->findAllByAttributes(['penjualanresep_id' => $modReseptur->penjualanresep_id]);

if (!empty($modObatAlkes)) {
    foreach ($modObatAlkes as $key => $det) {
        if ($det->is_obatkronis == true) {
            $is_kronis++;
        }
    }
}

if ($is_kronis >= 1) {
    $kronis = CHtml::link(Yii::t('mds', '{icon} <b> Print Obat Kronis </b>', array('{icon}' => '<i class="fas fa-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-blue', 'onclick' => "printKronis('PRINT')"));
}

if ($modReseptur->carabayar_id == Params::CARABAYAR_ID_BPJS) {
    $button = $button_jual . "&nbsp;" . $kronis;
}

if (!isset($_GET['frame'])) {
    echo $this->renderPartial($this->path_view . '_headerPrint');
}
?>
<table class="tab_header">
    <tr>
        <td>Tgl. Penjualan</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglpenjualan); ?></td>
        <td></td>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Tgl. Resep</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modReseptur->tglresep); ?></td>
        <td></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modReseptur->pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td><?php echo ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS) ? 'No. Nota' : "No. Resep"; ?></td>
        <td>:</td>
        <td><?php
            echo $modReseptur->noresep;
            ?></td>
        <td></td>
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo ($modReseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS or  $modReseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP_LUAR) ? '-' : (empty($modReseptur->pegawai_id) ? "-" : $modReseptur->pegawai->namaLengkap); ?></td>
    </tr>
</table>
<hr />
<table id="tableObatAlkes" class="tab_detail">
    <thead>

        <th>No.Urut</th>
        <th><span hidden>Kategori/&nbsp;&nbsp;&nbsp;&nbsp;<br /></span> Nama Obat</th>
        <th>Jenis Resep</th>
        <th hidden>Satuan Kecil</th>
        <th>Jumlah</th>
        <th>Signa</th>
        <th>Harga Satuan</th>
        <th>Total Embalase</th>
        <th>Keringanan (%)</th>
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>
        <th>PPN (Rp)</th>
        <th>SubTotal</th>
        <th>Status Bayar</th>

    </thead>
    <?php
    $no = 1;
    $subtotals = 0;
    $totalSubTotal = 0;
    $discount = 0;
    foreach ($detailreseptur as $tampilData) :
        // $jumlhqty = ($tampilData->hargasatuan_oa * $tampilData->qty_oa);
        // $ppnpersen = round($tampilData->jumlahppn/$jumlhqty * 100,2);

        // $subTotal = (($tampilData['qty_oa']*$tampilData['hargasatuan_oa']));
        $subTotal = $tampilData->hargajual_oa;
        // $discount = ((($tampilData['hargasatuan_oa']*$tampilData['qty_oa'])*($tampilData['discount']/100)));
        if ($tampilData['oasudahbayar_id'] != null) {
            $status = 'Sudah Lunas';
        } else {
            $status = 'Belum Lunas';
        }
        echo "<tr>
            <td>" . $no . "</td>
            <td>" . //$tampilData->obatalkes->obatalkes_kategori."<br>".
            $tampilData->obatalkes->obatalkes_nama . "</td>
            <td>";
        if (!empty($tampilData->racikan_id)) {
            $modRacik = RacikanM::model()->findByPk($tampilData->racikan_id);
            echo $modRacik->racikan_nama;
        } else {
            echo 'Non-Racikan';
        }
        echo "</td>
            <td hidden>" . $tampilData->obatalkes->satuankecil->satuankecil_nama . "</td>
            <td style='text-align: right;'>" . number_format($tampilData['qty_oa'], 2, ",", "") . " " . $tampilData->obatalkes->satuankecil->satuankecil_nama . "</td>
            <td>" . $tampilData['signa_oa'] . "</td>
            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($tampilData['hargasatuan_oa'], 2) . "</td>
            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($tampilData['total_embalase'], 2) . "</td>
            <td style='text-align: right;'>" . $tampilData->persen_discount . "</td>
            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($tampilData->discount, 2) . "</td>
            <td style='text-align: right;'>" . $tampilData->persenppnjual . "</td>
            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($tampilData->jumlahppn, 2) . "</td>
            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($subTotal, 2) . "</td>
            <td>" . $status . "</td>


         </tr>";
        $no++;
        $subtotals += $subTotal;
        // $subtotals += ($subTotal-$discount);
        //        $discounts +=$discount;
        $totalSubTotal = $totalSubTotal + $subTotal - $discount;

    endforeach;
    echo "<tr hidden>
            <td colspan='9' style='text-align:right;'> Biaya Administrasi</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->biayaadministrasi, 2) . "</td>
            <td></td>
         </tr>";
    echo "<tr hidden>
            <td colspan='9' style='text-align:right;'> Biaya Service</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->totaltarifservice, 2) . "</td>
            <td></td>
         </tr>";
    echo "<tr hidden>
            <td colspan='9' style='text-align:right;'> Biaya Konseling</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->biayakonseling, 2) . "</td>
            <td></td>
         </tr>";
    echo "<tr hidden>
            <td colspan='9' style='text-align:right;'> Jasa Dokter Resep</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->jasadokterresep, 2) . "</td>
            <td></td>
         </tr>";
    echo "<tr hidden>
            <td colspan='9' style='text-align:right;'> Keringanan</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->discount, 2) . "</td>
            <td></td>
         </tr>";
    //     echo "<tr>
    //            <td colspan='7' style='text-align:right;'> Total</td>
    //
    //            <td>".number_format((($totalSubTotal) - ($totalSubTotal * ($modReseptur->discount/100))) + $modReseptur->biayaadministrasi+$modReseptur->biayakonseling+$modReseptur->totaltarifservice+$modReseptur->jasadokterresep)."</td>
    //            <td></td>
    //         </tr>";
    $total = $subtotals + $modReseptur->biayaadministrasi + $modReseptur->totaltarifservice + $modReseptur->biayakonseling; //+$modReseptur->jasadokterresep << SDH TERMASUK DLM HARGA OBAT

    if (!empty($modReseptur->jasapelayanan_farmasi)) {
        echo "<tr>
            <td colspan='11' style='text-align:right;'> Jasa Pelayanan Farmasi</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint($modReseptur->jasapelayanan_farmasi, 2) . "</td>
            <td></td>
        </tr>";
    }
    echo "<tr>
            <td colspan='11' style='text-align:right;'> Total Keseluruhan</td>

            <td style='text-align: right;'>" . MyFormatter::formatNumberForPrint(($total + $modReseptur->jasapelayanan_farmasi), 2) . "</td>
            <td></td>
         </tr>";
    ?>

</table>
<iframe id="print_win" src="" style="display: none;"></iframe>
<iframe id="print_win_1" src="" style="display: none;"></iframe>

<?php
echo '<br>';
echo CHtml::Link("<i class='entypo-print'></i> Print Nota Tindakan", '#', array('class' => 'btn btn-info', "rel" => "tooltip", "title" => "Klik untuk print resep dari dokter", 'onclick' => 'printRecordTerakhir(\'PRINT\')'));
echo  "&nbsp;";

echo $button;
$urlPrintRecordTerakhir2 =  Yii::app()->createAbsoluteUrl($this->module->id . '/PenjualanResepRS/print&penjualanresep_id=' . $modReseptur->penjualanresep_id);
// $js = <<< JSCRIPT


// JSCRIPT;
// Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
            <?php
            // if(!empty($modCatatanpemberianobat->jadwalpemberianobat)){
            echo '&nbsp;';
                echo CHtml::Link('<i class="icon-print icon-white"></i> Nota Penjualan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printNotaPenjualan(\'PRINT\')', 'disabled' => false));
            // }
            ?>
            <?php
            // if(!empty($modCatatanpemberianobat->jadwalpemberianobat)){
            echo '&nbsp;';
            // if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])) {
                // echo CHtml::Link('<i class="icon-print icon-white"></i> Print E-Tiket Rawat Inap', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' => isset($_GET['sukses']) ? false : true));
            // }else{
                // CHtml::Link('<i class="icon-print icon-white"></i> Nota Tindakan', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' =>false));
            // }
            // }
            ?>
             <?php
            // if(!empty($modCatatanpemberianobat->jadwalpemberianobat)){
            echo '&nbsp;';
            // if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])) {
                // echo CHtml::Link('<i class="icon-print icon-white"></i> Print E-Tiket Rawat Inap', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printetiketRanap(\'PRINT\')', 'disabled' => isset($_GET['sukses']) ? false : true));
            // }else{
                echo CHtml::Link('<i class="icon-print icon-white"></i> Lembar Telaah', 'javascript:;', array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTelaah(\'PRINT\')', 'disabled' =>false));
            // }
            // }
            ?>

<script type='text/javascript'>
    function printRecordTerakhir(caraPrint) {
        var penjualanresep_id = '<?php echo $_GET['id']; ?>';
        var pasien_id = '<?php echo $modReseptur->pasien_id; ?>';
        window.open('<?php echo Yii::app()->createUrl('farmasiApotek/penjualanDariReseptur/PrintTindakan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    /**
     * untuk print penjualan dokter
     */
    function printBiasa() {
        var penjualanresep_id = '<?php echo $_GET['id']; ?>';
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/Printnew'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }


    /**
     * untuk print penjualan obat kronis
     */
    function printKronis() {
        var penjualanresep_id = '<?php echo $_GET['id']; ?>';
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/PrintKronisMax'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }

            
    function printNotaPenjualan(caraPrint) {
        var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
        window.open('<?php echo $this->createUrl('penjualanDariReseptur/printNotaPenjualan'); ?>&penjualanresep_id=' + <?php echo $modReseptur->penjualanresep_id ?> + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printNotaPenjualanLangsung(caraPrint) {
        var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
        console.log("PRINT!!!");
        $("#print_win").attr('src', '<?php echo $this->createUrl('penjualanDariReseptur/printNotaPenjualan'); ?>&penjualanresep_id=' + <?php echo $modReseptur->penjualanresep_id ?> + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function printTelaah(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modReseptur->penjualanresep_id) ? $modReseptur->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('penjualanDariReseptur/printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }

    function printTelaahLangsung(caraPrint) {
        var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
        console.log("PRINT!!!");
        $("#print_win_1").attr('src', '<?php echo $this->createUrl('penjualanDariReseptur/printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $(document).ready(function() {
        $('.nama-prov').html('<b>PEMERINTAH PROVINSI JAWA TIMUR</b>');
    });

</script>