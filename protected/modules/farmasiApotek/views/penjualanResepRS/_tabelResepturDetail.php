<table class="items table table-striped table-bordered table-condensed" id="tabel-detailreseptur">
    <thead>
        <tr>
            <th>Resep</th>
            <th>R ke</th>
            <th>Kode / Nama Obat</th>
            <th>Sumber Dana</th>
            <th>Satuan Kecil</th>
            <th>Jumlah</th>
            <th>Permintaan Dosis</th>
            <th>Jumlah Kemasan</th>
            <th>Kekuatan</th>
            <th>Signa</th>
            <th>Etiket</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(count((array)$modDetailReseptur) > 0){
			foreach($modDetailReseptur AS $i=> $modDetail){
				echo $this->renderPartial($this->path_view.'_rowDetailReseptur',array('modDetail'=> $modDetail),true);
			}
        }
        ?>
    </tbody>
</table>