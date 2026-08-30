<style>
    .tab_head td {
        padding: 2px;
        vertical-align: top;
    }
</style>

<?php foreach ($penunjang as $item): 
    
    if (empty($item['rencana']) || count((array)$item['rencana']) == 0) {
        continue;
    }
    
    $base = $item['rencana'][0];
    
    ?>

<table width="100%" class="tab_head">
    <tr>
        <td nowrap>Tgl. Rencana</td>
        <td nowrap> : </td>
        <td width="100%"><?php echo MyFormatter::formatDateTimeForUser($base->tglrencanaoperasi); ?></td>
        <td nowrap>No. Rencana</td>
        <td nowrap> : </td>
        <td nowrap><?php echo $base->norencanaoperasi; ?></td>
    </tr>
    <tr>
        <td nowrap>Operator</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->dokterpelaksana1_id)) {
            $peg = PegawaiM::model()->findByPk($base->dokterpelaksana1_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
         ?></td>
        <td nowrap>Kamar Ruangan</td>
        <td nowrap> : </td>
        <td nowrap><?php 
        
        $kamar = null;
        if (!empty($base->kamarruangan_id)) {
            $kamar = KamarruanganM::model()->findByPk($base->kamarruangan_id);
            echo !empty($kamar) ? "Kamar ".$kamar->kamarruangan_nokamar." - Bed ".$kamar->kamarruangan_nobed : "-";
        } else {
            echo "-";
        }
        
        ?></td>
    </tr>
    <tr>
        <td nowrap>Asisten Operator</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->dokterpelaksana2_id)) {
            $peg = PegawaiM::model()->findByPk($base->dokterpelaksana2_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
         ?></td>
        <td nowrap>Dokter Anastesi</td>
        <td nowrap> : </td>
        <td nowrap><?php 
        
        $peg = null;
        if (!empty($base->dokteranastesi_id)) {
            $peg = PegawaiM::model()->findByPk($base->dokteranastesi_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
        
        ?></td>
    </tr>
    <tr>
        <td nowrap>Petugsa RR</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->suster_id)) {
            $peg = PegawaiM::model()->findByPk($base->suster_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
         ?></td>
        <td nowrap>Penata/Perawat<br>Anastesi</td>
        <td nowrap> : </td>
        <td nowrap><?php  
        
        $peg = null;
        if (!empty($base->paramedis_id)) {
            $peg = PegawaiM::model()->findByPk($base->paramedis_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
        
        ?></td>
    </tr>
    <tr>
        <td nowrap>Perawat Instrumen</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->bidan_id)) {
            $peg = PegawaiM::model()->findByPk($base->bidan_id);
            echo !empty($peg) ? $peg->namaLengkap : "-";
        } else {
            echo "-";
        }
         ?></td>
    </tr>
    <tr>
        <td nowrap>Perawat Sirkuler</td>
        <td nowrap> : </td>
        <td width="100%"><?php 
        $peg = null;
        if (!empty($base->perawatsirkuler_id)) {
            $peg = PegawaiM::model()->findByPk($base->perawatsirkuler_id);
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
            <th width="100">Mulai Operasi</th>
            <th width="100">Selesai Operasi</th>
            <th>Nama</th>
            <th width="100">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($item['rencana'] as $detail): ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($detail->mulaioperasi); ?></td>
            <td><?php echo MyFormatter::formatDateTimeForUser($detail->selesaioperasi); ?></td>
            <td><?php 
            $operasi = OperasiM::model()->findByPk($detail->operasi_id);
            
            if (!empty($operasi)) {
                
                $nama = "";
                if (!empty($operasi->kegiatanoperasi_id)) {
                    $jenis = KegiatanOperasiM::model()->findByPk($operasi->kegiatanoperasi_id);
                    if (!empty($jenis)) {
                        $nama .= $jenis->kegiatanoperasi_nama." - ";
                    }
                }
                echo $nama.$operasi->operasi_nama;
            } else {
                echo "-";
            }
            ?></td>
            <td><?php echo $detail->statusoperasi; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<hr>

<?php endforeach; ?>
