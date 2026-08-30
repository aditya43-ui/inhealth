<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail Penerimaan Darah dari PMI</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed" id="detail">
            <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align: center">Jenis Komponen Darah</th>
                    <th style="text-align: center">Gol. Darah</th>
                    <th style="text-align: center">Rhesus</th>
                    <th style="text-align: center">No. Kantong Darah <span class="required">*</span></th>
                    <th style="text-align: center">Tgl. Aftap <?= (!isset($_GET['sukses'])) ? CHtml::checkBox('cekTglAftap', false, array('rel' => 'tooltip', 'title' => 'Klik untuk isi tanggal Aftap', 'onclick' => 'cekAllTglAftap();')) : null; ?></th>
                    <th style="text-align: center">Tgl. Kedaluwarsa <span class="required">*</span> <?= (!isset($_GET['sukses'])) ? CHtml::checkBox('cekTglExp', false, array('rel' => 'tooltip', 'title' => 'Klik untuk isi Tgl. Kedaluwarsa', 'data-placement' => 'left', 'onclick' => 'cekAllTglKadaluarsa();')) : null; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['sukses'])) {
                    if (count((array)$modelDetail)) {
                        $k = 0;
                        foreach ($modelDetail as $key => $value) {

                            $jeniskomponenedarah_nama = "";
                            if (!empty($value->jeniskomponendarah_id)) {
                                $mod = JeniskomponendarahM::model()->findByPk($value->jeniskomponendarah_id);
                                $jeniskomponenedarah_nama = $mod->jeniskomponenedarah_nama;
                            }

                            $modKantong = KantongdarahT::model()->findAllByAttributes(array('penerimaandarahpmidet_id' => $value->penerimaandarahpmidet_id));

                            foreach ($modKantong as $key => $kantong) {
                                echo '
                                        <tr>
                                            <td>' . ($k + 1) . '</td>
                                            <td style="text-align: center">' . $jeniskomponenedarah_nama . '</td>
                                            <td style="text-align: center">' . $value->golongandarah . '</td>
                                            <td style="text-align: center">' . $value->rhesus . '</td>
                                            <td style="text-align: center">' . $kantong->no_kantongdarah . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($kantong->tgl_aftap) . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($kantong->tgl_kadaluarsa) . '</td>
                                        </tr>
                                    ';
                                $k++;
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>