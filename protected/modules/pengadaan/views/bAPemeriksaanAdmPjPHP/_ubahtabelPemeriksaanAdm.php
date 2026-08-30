<div class="span12">
    <table class="table table-bordered table-condensed table-striped" id="tabel_kuesioner">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th>Jenis Dokumen Diperiksa</th>
                <th style="text-align:center;">Lengkap Sesuai</th>
                <th style="text-align:center;">Lengkap Tidak Sesuai / Tidak Lengkap</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $modPertanyaan = DokumenpemeriksaanadministratifT::model()->findAllByAttributes(array('bapemeriksaanadmpjphp_id' => $model->bapemeriksaanadmpjphp_id));

            $no = 1;
            foreach ($modPertanyaan as $value) {
                echo '<tr>';
                echo '<td style="text-align:center;"><label>' . $no . '</label></td>';
                echo '<td><label>' . $value->jenis_dokumen;
                echo CHtml::hiddenField('DokumenpemeriksaanadministratifT[' . $value->dokumenpemeriksaanadministratif_id . '][jenis_dokumen]', $value->jenis_dokumen, array('class' => 'span4')) . '</label></td>';
                echo '<td style="text-align:center;">' . CHtml::radioButtonList('DokumenpemeriksaanadministratifT[' . $value->dokumenpemeriksaanadministratif_id . '][islengkap]', !empty($value->islengkap) ? $value->islengkap : 0, array(1 => '',), array('onclick' => 'setValidasi(this,' . $value->dokumenpemeriksaanadministratif_id . ')', 'class' => 'cekLengkap', 'labelOptions' => array('style' => 'display:inline'))) . '</td>';
                echo '<td style="text-align:center;">' . CHtml::radioButtonList('DokumenpemeriksaanadministratifT[' . $value->dokumenpemeriksaanadministratif_id . '][islengkap]', !empty($value->islengkap) ? $value->islengkap : 0, array(0 => '',), array('onclick' => 'setValidasi(this,' . $value->dokumenpemeriksaanadministratif_id . ')', 'class' => 'cekLengkap', 'labelOptions' => array('style' => 'display:inline'))) . '</td>';
                echo '<td>' . CHtml::textArea('DokumenpemeriksaanadministratifT[' . $value->dokumenpemeriksaanadministratif_id . '][keterangan]', $value->keterangan, array('class' => 'span3')) . '</td>';
                echo '</tr>';
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>