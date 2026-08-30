  <div class="panel-body overflow-x" >
<table id="table-detail-pengiriman" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>No. Kantong Darah</th>
            <th>Jenis Komponen Darah</th>
            <th>Jenis Kantong</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if(count($modDetail) > 0) {
            foreach ($modDetail as $data) {
             $modJenis = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
             $modKomponen = KomponendarahM::model()->findByPk($data->komponendarah_id); ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $data->nomorbarcode; ?></td>
            <td><?php echo $modJenis->nama_jenis; ?></td>
            <td><?php echo $modKomponen->singkatan_komp; ?></td>
            <td><?php echo $data->golongan_darah; ?></td>
            <td><?php echo $data->rhesus; ?></td>
        </tr>     
        <?php
        $no++;
            }
        }
        ?>
        
    </tbody>
</table>
  </div>

