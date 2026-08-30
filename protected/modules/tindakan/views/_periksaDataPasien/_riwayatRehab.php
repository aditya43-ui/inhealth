<style>
    .tab_head td {
        padding: 2px;
        vertical-align: top;
    }
</style>

<?php foreach ($penunjang as $item): 
    
    if (empty($item['hasil']) || count((array)$item['hasil']) == 0) {
        continue;
    }
    
    $base = $item['hasil'][0];
    
    ?>

<table width="100%" class="tab_head">
    <tr>
        <td nowrap>Tgl. Pemeriksaan</td>
        <td nowrap> : </td>
        <td width="100%"><?php echo MyFormatter::formatDateTimeForUser($base->tglpemeriksaanrm); ?></td>
        <td nowrap>No. Penunjang</td>
        <td nowrap> : </td>
        <td nowrap><?php echo $item['data']->no_masukpenunjang; ?></td>
    </tr>
    <tr>
        <td nowrap>Dokter Pemeriksa</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->pegawai_id)) {
            $peg = PegawaiM::model()->findByPk($base->pegawai_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
         ?></td>
    </tr>
</table>

<table class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            <th>Tindakan</th>
            <th width="100">Problematik Fisioterapi</th>
            <th width="100">Dosis Tindakan</th>
            <th width="100">Evaluasi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($item['hasil'] as $detail): ?>
            
        <tr>
            <td>
            <?php    
            $periksa = TindakanrmM::model()->findByPk($detail->tindakanrm_id);
            if (!empty($periksa)) {
                echo $periksa->tindakanrm_nama;
            } else {
                echo "-";
            }
            ?>
            </td>
            <td><?php echo $detail->hasilpemeriksaanrm; ?></td>
            <td><?php echo $detail->keteranganhasilrm; ?></td>
            <td><?php echo $detail->evaluasi; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<hr>

<?php endforeach; ?>
