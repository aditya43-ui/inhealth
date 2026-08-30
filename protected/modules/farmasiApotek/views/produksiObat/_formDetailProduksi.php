<div class="block-tabel">
    <table class="table table-responsive table-bordered table-striped table-condensed" id="tblDetailProduksi">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Bahan</th>
                <th>Nama Bahan <span class="required">*</span></th>
                <th>Dosis</th>
                <th>Kemasan</th>
                <th>Kekuatan</th>
                <th>Jumlah</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Tambah Bahan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count((array)$dataDetails) > 0) {
                foreach ($dataDetails AS $row => $data) {
//              MENGEMBALIKAN YANG DI POST TABEL
//                $modDetail->attributes = $data;
//                $modDetail->obatalkes_kode = $data['obatalkes_kode'];
//                $modDetail->obatalkes_nama = $data['obatalkes_nama'];
//                $modDetail->dosis = $data['dosis'];
//                $modDetail->kemasan = $data['kemasan'];
//                $modDetail->kekuatan = $data['kekuatan'];
//                $modDetail->satuankecil_nama = $data['satuankecil_nama'];
                    echo $this->renderPartial('_rowDetailProduksi', array('model' => $model, 'modProduksiDetail' => $modProduksiDetail, 'modObatalkesM' => $modObatalkesM, 'form' => $form, 'row' => $row));
                }
            } else {
                echo $this->renderPartial('_rowDetailProduksi', array('model' => $model, 'modProduksiDetail' => $modProduksiDetail, 'modObatalkesM' => $modObatalkesM, 'form' => $form, 'row' => 0));
            }
            ?>
        </tbody>
    </table>
</div>
