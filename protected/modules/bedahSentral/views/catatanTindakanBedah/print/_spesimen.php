<table class="tab-detail2">
    <thead>
        <tr>
            <th>Jenis Spesimen Jaringan</th>
            <th>Diperoleh Dari Hasil</th>
            <th>Lokasi Pengambilan</th>
            <th>Volume</th>
            <th>Dikirim untuk Pemeriksaan PA</th>
            <th>Permintaan Pemeriksaan PA</th>
        </tr>
    </thead>
    <tbody>
        <?php

        $data = SpesimenhasiloperasiT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
        ), array(
            'condition'=>'laporanoperasipasien_id is null'
        ));

        foreach ($data as $item) {
        ?>
        <tr>
            <td><?php
            $jenis = JenisspesimenPaM::model()->findByPk($item->jenisspesimen_pa_id);

            if (empty($jenis)) {
                echo "-";
            } else if ($item->jenisspesimen_pa_id == 3) {
                echo $item->jenisspesimen_pa_lainnya;
            } else {
                echo $jenis->jenisspesimen_pa_nama;
            }
            ?></td>
            <td>
                <?php

                $teknik = TeknikpengambilanspesimenM::model()->findByPk($item->teknikpengambilanspesimen_id);

                echo empty($teknik) ? "-" : $teknik->teknikpengambilanspesimen_nama;

                ?>
            </td>
            <td><?php echo $item->lokasipengambilanspesimen; ?></td>
            <td><?php echo $item->volumespesimen; ?></td>
            <td><?php echo $item->statuskirim_pa;
            if ($item->statuskirim_pa == "Tidak") {
                echo ", ".(empty($item->tujuanpengirimanspesimen_lainnya) ? "-" : $item->tujuanpengirimanspesimen_lainnya);
            }

            ?></td>
            <td><?php

            $det = SpesimenhasiloperasidetT::model()->findAllByAttributes(array(
                'spesimenhasiloperasi_id'=>$item->spesimenhasiloperasi_id,
            ));

            if (count((array)$det) > 0) {
                echo "<ul>";

                foreach ($det as $item2) {
                    echo "<li>".$item2->pemeriksaanlab->pemeriksaanlab_nama."</li>";
                }

                echo "</ul>";
            }

            ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
