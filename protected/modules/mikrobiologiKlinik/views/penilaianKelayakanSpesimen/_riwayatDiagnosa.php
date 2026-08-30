<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal Diagnosa</th>
            <th>Kelompok Diagnosa</th>
            <th>Kode Diagnosa</th>
            <th>Nama Diagnosa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        $modMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        if(count($modMorbiditas) > 0){
            foreach ($modMorbiditas as $key => $value) {
            ?>
            <tr>
                <td><?= MyFormatter::formatDateTimeForUser($value->tglmorbiditas) ?></td>
                <td><?= $value->kelompokdiagnosa->kelompokdiagnosa_nama ?></td>
                <td><?= $value->diagnosa->diagnosa_kode ?></td>
                <td><?= $value->diagnosa->diagnosa_nama ?></td>
            </tr>
            <?php
            }
        }
        
        ?>
    </tbody>
</table>