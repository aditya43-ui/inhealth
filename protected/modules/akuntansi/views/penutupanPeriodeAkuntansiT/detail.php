<style>
    
    body {
        color: black;
    }
    
    
    .tab_header {
        margin-bottom: 20px;
    }
    
    .tab_header td {
        padding: 2px;
    }
    
    
    
    .tab_detail, .tab_header {
        width: 100%;
    }
    .tab_detail thead th, .tab_detail tfoot td {
        font-weight: bold;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 3px;
    }
    
    
    
</style>

<table class="tab_header">
    <tr>
        <td nowrap>Tgl. Penutupan</td><td>:</td><td width="100%"><?php echo MyFormatter::formatDateTimeForUser($model->tglpenutupan); ?></td>
        <td nowrap>No. Penutupan</td><td>:</td><td><?php echo $model->nopenutupan; ?></td>
    </tr>
    <tr>
        <td nowrap>Periode Akuntansi</td><td>:</td><td>
            <?php
            $period = RekperiodM::model()->findByPk($model->rekperiod_id);
            echo $period->deskripsi;
            ?>
        </td>
        <td nowrap>Petugas</td><td>:</td><td nowrap>
            <?php
            if (!empty($model->pegawai_id)) {
                $peg = PegawaiM::model()->findByPk($model->pegawai_id);
                echo $peg->namaLengkap;
            } else {
                echo "-";
            }
            ?>
        </td>
    </tr>
</table>


<table class="tab_detail">
    <thead>
        <tr>
            <th>Keterangan</th>
            <th>Saldo Debit</th>
            <th>Saldo Kredit</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $debit = 0;
        $kredit = 0;
        foreach ($det as $item): 
            $debit += $item->saldodebit;
            $kredit += $item->saldokredit;
            
            ?>
        <tr>
            <td><?php
            $rek5 = Rekening5M::model()->findByPk($item->rekening5_id);
            echo $rek5->kdrekening5." - ".$rek5->nmrekening5;
            ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->saldodebit, 2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->saldokredit, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>Total Saldo</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($debit, 2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($kredit, 2); ?></td>
        </tr>
    </tfoot>
</table>