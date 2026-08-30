<table width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <th>No</th>
        <th>Tanggal Perbaikan</th>
        <th>Tanggal Selesai</th>
        <th>Pemohon</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if(count($model) > 0){
            foreach($model AS $i=>$value){ 
                $modPegawai = PegawaiM::model()->findByPk($value->pegpemohon_id);
    ?>
            <tr>   
                <td><?php echo $no++; ?></td>
                <td><?php echo !empty($value->korektifmainten_tglpawal) ? date('d M Y', strtotime($value->korektifmainten_tglpawal)):""; ?> </td>
                <td><?php echo !empty($value->korektifmainten_tglpakhir) ? date('d M Y', strtotime($value->korektifmainten_tglpakhir)):""; ?></td>
                <td><?php echo $modPegawai->nama_pegawai; ?></td>
            </tr>
    <?php
            }
        } ?>
    </tbody>
</table>
