<table class="table table-bordered table-striped datatable">
    <thead>
        <tr>
            <th> No.</th>
            <th> Nama Barang </th>
            <th> Kode Aset </th>
            <th> Merk</th>
            <th> Ukuran </th>
        </tr>
    </thead>
    <?php 
        $row = 1;
        $modDet = GUPeminjamanbrgT::model()->findAllByAttributes(array('peminjamanbrg_nomor' => $model->peminjamanbrg_nomor));
        foreach($modDet as $det){
    ?>
    <tbody>
        <tr>
            <td> <?php echo $row++;  ?> </td>
            <td> <?php echo $det->invperalatan->invperalatan_namabrg  ?> </td>
            <td> <?php echo $det->invperalatan->invperalatan_kode  ?> </td>
            <td> <?php echo $det->invperalatan->invperalatan_merk  ?> </td>
            <td> <?php echo $det->invperalatan->invperalatan_ukuran  ?> </td>
        </tr>
    </tbody>
    <?php } ?>
</table>