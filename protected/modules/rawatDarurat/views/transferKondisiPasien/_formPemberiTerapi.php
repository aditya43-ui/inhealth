<div class="row">
    <div class="col-sm-12">
        <p style="font-weight: bold; color: black">Pemakaian Bahan Habis Pakai (BHP)</p>
        <table class="table table-bordered table-condensed" style="width: 900px">
            <thead>
                <th>Tgl. Pemakaian</th>
                <th>Jenis Obat Alkes</th>
                <th>Nama Obat Alkes</th>
                <th>Jumlah</th>
            </thead>
            <tbody>
        <?php 
        
        if(count($modRiwayatResepBHP) > 0){
        foreach ($modRiwayatResepBHP as $i => $bmhp) { ?>
            <tr>
                <td>
                    <?php echo $bmhp->tglpelayanan; ?>
                </td>
                <td>
                    <?php echo (isset($bmhp->obatalkes->jenisobatalkes)? $bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama: ""); ?>
                </td>
                <td>
                    <?php echo $bmhp->obatalkes->obatalkes_nama; ?>
                </td>
                <td style="text-align:right;">
                    <?php echo $bmhp->qty_oa; ?>
                </td>
            </tr>
        <?php } ?>
        <?php  }else{ ?>
            <tr>
                <td colspan="4">Tidak ditemukan hasil.</td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <p style="font-weight: bold; color: black">Resep</p>
        <table class="items table table-bordered table-striped table-condensed" id="tblInputTindakan">
            <thead>
                <tr>
                    <th>Tanggal Resep</th>
                    <th>No. Resep</th>
                    <th>Nama Dokter</th>
                    <th>Lihat Detail</th>
                </tr>
            </thead>
            <?php 
            if(count($modRiwayatResep) > 0){
            foreach ($modRiwayatResep as $i => $resep) { ?>
            <tr>
                <td><?php echo $resep->tglreseptur ?></td>
                <td><?php echo $resep->noresep ?></td>
                <?php $pegawai = PegawaiM::model()->findByPk($resep->pegawai_id) ?>
                <td><?php echo  $pegawai->namaLengkap ?></td>
                <td><center><?php echo CHtml::link("<i class='icon-eye-open'></i>", 'javascript:void(0)', array('onclick'=>'viewDetailResep("'.$resep->reseptur_id.'","'.$model->pendaftaran_id.'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail resep'));  ?></center></td>
            </tr>
            <?php }  ?>
           <?php  }else{ ?>
            <tr>
                <td colspan="4">Tidak ditemukan hasil.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
