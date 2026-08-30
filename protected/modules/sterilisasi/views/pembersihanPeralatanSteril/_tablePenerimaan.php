<table class="items table table-striped table-condensed" id="tblPenerimaanSteril">
    <thead>
        <tr>
            <th>Tgl. Penerimaan</th>
            <th>no. Penerimaan</th>
            <th>Instalasi</th>
	    <th>Ruangan</th>
            <th>Nama Peralatan</th>
            <th>Jumlah</th>
            <th>Keadaan</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count((array)$modPenerimaanSterilDetail) > 0) {
         foreach ($modPenerimaanSterilDetail as $data) {
            ?>
        <tr>
            <?php $modRuangan = RuanganM::model()->findByPk($modPenerimaanSteril->ruangan_id);?>
            <?php $modInstalasi = InstalasiM::model()->findByPk($modRuangan->instalasi_id); ?>
            <?php $modPeralatan = PeralatansterilisasiM::model()->findByPk($data->peralatansterilisasi_id); ?>
            <td><?php echo $format->formatDateTimeForUser($modPenerimaanSteril->penerimaansterilisasi_tgl);?></td>
            <td><?php echo $modPenerimaanSteril->penerimaansterilisasi_no; ?></td>
            <td><?php echo $modInstalasi->instalasi_nama; ?> </td>
            <td><?php echo $modRuangan->ruangan_nama; ?></td>
            <td><?php echo $modPeralatan->peralatansterilisasi_nama; ?></td>
            <td><?php echo $data->penerimaansterilisasidet_jml; ?></td>
            <td><?php echo $data->keadaanperalatan; ?></td>
        </tr>
        <?php } } ?>
    </tbody>
</table>

