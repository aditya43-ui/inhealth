<table width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <th>No</th>
        <th>Tanggal Perbaikan</th>
        <th>Tanggal Selesai</th>
        <th>Penanggung Jawab</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if(count($model) > 0){
            foreach($model AS $i=>$value){ 
                $modPegawai = PegawaiM::model()->findByPk($value->wo_pegawai_id);
    ?>
            <tr>   
                <td><?php echo $no++; ?></td>
                <td><?php echo !empty($value->tglpemeliharaan) ? date('d M Y', strtotime($value->tglpemeliharaan)):""; ?> </td>
                <td><?php echo !empty($value->tglpemeliharaan_selesai) ? date('d M Y', strtotime($value->tglpemeliharaan_selesai)):""; ?></td>
                <td><?php echo $modPegawai->nama_pegawai; ?></td>
            </tr>
    <?php
            }
        } ?>
    </tbody>
</table>
