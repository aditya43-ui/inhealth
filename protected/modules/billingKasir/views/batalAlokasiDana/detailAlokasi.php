<style>

    .tab_judul {
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .page_judul {
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }

    .tab_detail {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_detail th {
        font-weight: bold;
    }

    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 3px;
    }

    .tab_detail tfoot td {
        font-weight: bold;
    }

    .num {
        text-align: right;
    }

</style>

<div class="page_judul">ALOKASI BIAYA</div>

<div class="tab_judul">Tanggungan Tindakan</div>
<table class="tab_detail">
    <thead>
        <tr>
            <th width="150">Tgl. Transaksi</th>
            <th>No. Nota</th>
            <th>Kode Tarif</th>
            <th>Uraian Tarif</th>
            <th width="50">Jumlah</th>
            <th width="100">Tanggungan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $totalTindakan = 0;
        foreach ($tindakan as $item): 

            $tanggungan = $item->jmliurbiaya;
            if ($alokasi->carabayar_id != Params::CARABAYAR_ID_MEMBAYAR) {
                $tanggungan = $item->jmlsubsidi_asuransi;
            }

            $modTindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
            $totalTindakan += $tanggungan;
            //var_dump($modTindakan->attributes); die;
            // var_dump($item->attributes); die;
            
            ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan); ?></td>
            <td><?php echo $modTindakan->noNota; //empty($modTindakan->nopelayanan) ? "" : ($pendaftaran->no_pendaftaran.$modTindakan->nopelayanan); ?></td>
            <td><?php echo $modTindakan->daftartindakan->daftartindakan_kode; ?></td>
            <td><?php echo $modTindakan->daftartindakan->daftartindakan_nama; ?></td>
            <td class="num"><?php echo $modTindakan->qty_tindakan; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($tanggungan); ?></td>
        </tr>

        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="num">Total Tanggungan Tindakan</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalTindakan); ?></td>
        </tr>
    </tfoot>
</table>

<br/>

<div class="tab_judul">Tanggungan Obat & Alkes</div>
<table class="tab_detail">
    <thead>
        <tr>
            <th width="150">Tgl. Transaksi</th>
            <th>Uraian Tarif</th>
            <th width="50">Jumlah</th>
            <th width="100">Tanggungan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $totalOa = 0;
        
        foreach ($oa as $item): 

            $tanggungan = $item->jmliurbiaya;
            if ($alokasi->carabayar_id != Params::CARABAYAR_ID_MEMBAYAR) {
                $tanggungan = $item->jmlsubsidi_asuransi;
            }

            $modOa = ObatalkespasienT::model()->findByPk($item->obatalkespasien_id);
            // var_dump($item->attributes); die;
            // var_dump($modOa->attributes); die;

            $totalOa += $tanggungan;
            ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($modOa->tglpelayanan); ?></td>
            <td><?php echo $modOa->obatalkes->obatalkes_nama; ?></td>
            <td class="num"><?php echo $item->qty_oa; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($tanggungan); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="num">Total Tanggungan Obat & Alkes</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($totalOa); ?></td>
        </tr>
    </tfoot>
</table>
<br/>
<table class="tab_detail">
    <tfoot>
        <tr>
            <td class="num">Total Tanggungan Keseluruhan</td>
            <td width="100" class="num"><?php echo MyFormatter::formatNumberForPrint($totalTindakan + $totalOa); ?></td>
        </tr>
    </tfoot>
</table>