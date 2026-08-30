<table id="table-komgajipeg" class="table table-bordered dataTable">
    <thead>
        <th style="text-align:center;width:50px;">No</th>
        <th style="text-align:center;">Komponen Gaji <span class="required">*</span></th>
        <th style="text-align:center;">Tipe Komponen </th>
        <th style="text-align:center;">Jenis</th>
        <th style="text-align:center;width:15%;">Nilai (Rp) <span class="required">*</span></th>
        <th style="text-align:center;color:#FFF;"><?php echo CHtml::link('<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>', 'javascript:;', array('class' => 'btn btn-primary white', 'onclick' => 'tambahKomGajiPeg();', "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Klik Icon ini, untuk menambahkan data <b>komponen gaji untuk pegawai</b>", "data-html" => true)); ?></th>
    </thead>
    <tbody>
        <?php

        $cek = KPKomponengajipegawaiM::model()->findByAttributes(array('pegawai_id' => $modPegawai->pegawai_id));

        if (!empty($cek)) {
            foreach ($modKomGajiDet as $det) {
                $det->tipekomponen = $det->komponengaji->tipekomponengaji;
                $det->jeniskomponen = ($det->komponengaji->ispotongan == true) ? "Potongan" : "Gaji";
                $det->nilaigaji = number_format($det->nilaigaji, 0, "", ".");
                echo $this->renderPartial($this->path_view . "_rowKomGaji", array('model' => $det, 'i' => 0));
            }
        }
        ?>
    </tbody>
</table>

<table id="table-delkomgajipeg" class="table table-bordered dataTable" hidden>
    <tbody>

    </tbody>
</table>