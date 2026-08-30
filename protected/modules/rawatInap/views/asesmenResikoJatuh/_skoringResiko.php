<style>
    .tab_keterangan {
        width: 100%;
    }

    .tab_keterangan th {
        font-weight: bold;
    }

    .tab_keterangan td,
    .tab_keterangan th {
        border: 1px solid black;
        padding: 2px;
    }
</style>
<?php
/**
 * mengenerate skoring risiko ke dalam bentuk tabel
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */

$formSkoring = array(
    array(
        'label' => 'Riwayat Jatuh - Kejadian Jatuh dalam 3 Bulan Terakhir',
        'lookup' => 'resikojatuh_riwayatjatuh',
        'param_keterangan' => 'riwayatjatuh_keterangan',
        'param_skor' => 'riwayatjatuh_skor',
    ),
    array(
        'label' => 'Status Mental',
        'lookup' => 'resikojatuh_statusmental',
        'param_keterangan' => 'statusmental_keterangan',
        'param_skor' => 'statusmental_skor',
    ),
    array(
        'label' => 'Pengobatan',
        'lookup' => 'resikojatuh_pengobatan',
        'param_keterangan' => 'pengobatan_keterangan',
        'param_skor' => 'pengobatan_skor',
    ),
    array(
        'label' => 'Mobilitas - Gaya Berjalan',
        'lookup' => 'resikojatuh_mobilitasgayaberjalan',
        'param_keterangan' => 'mobgayaberjalan_keterangan',
        'param_skor' => 'mobgayaberjalan_skor',
    ),
    array(
        'label' => 'Mobilitas - Alat Bantu',
        'lookup' => 'resikojatuh_mobilitasalatbantu',
        'param_keterangan' => 'mobilitasalatbantu_keterangan',
        'param_skor' => 'mobilitasalatbantu_skor',
    ),
    array(
        'label' => 'Kondisi Penyakit',
        'lookup' => 'resikojatuh_kondisipenyakit',
        'param_keterangan' => 'kondisipenyakit_keterangan',
        'param_skor' => 'konsidipenyakit_skor',
    ),
);

$formSkoringAnak = array(
    array(
        'label' => 'Usia',
        'lookup' => 'resikojatuh_anak_usia',
        'param_keterangan' => 'anak_usia_keterangan',
        'param_skor' => 'anak_usia_skor',
    ),
    array(
        'label' => 'Jenis Kelamin',
        'lookup' => 'resikojatuh_anak_jeniskelamin',
        'param_keterangan' => 'anak_jeniskelamin_keterangan',
        'param_skor' => 'anak_jeniskelamin_skor',
    ),
    array(
        'label' => 'Diagnosis',
        'lookup' => 'resikojatuh_anak_diagnosis',
        'param_keterangan' => 'anak_diagnosis_keterangan',
        'param_skor' => 'anak_diagnosis_skor',
    ),
    array(
        'label' => 'Gangguan Kognitif',
        'lookup' => 'resikojatuh_anak_gangguankognitif',
        'param_keterangan' => 'anak_gangguankognitif_keterangan',
        'param_skor' => 'anak_gangguankognitif_skor',
    ),
    array(
        'label' => 'Faktor Lingkungan',
        'lookup' => 'resikojatuh_anak_faktorlingkungan',
        'param_keterangan' => 'anak_faktorlingkungan_keterangan',
        'param_skor' => 'anak_faktorlingkungan_skor',
    ),
    array(
        'label' => 'Pembedahan / Sedasi / Anestesi',
        'lookup' => 'resikojatuh_anak_pembedahan',
        'param_keterangan' => 'anak_pembedahan_keterangan',
        'param_skor' => 'anak_pembedahan_skor',
    ),
    array(
        'label' => 'Penggunaan Medika Mentosa',
        'lookup' => 'resikojatuh_anak_medikamentosa',
        'param_keterangan' => 'anak_medikamentosa_keterangan',
        'param_skor' => 'anak_medikamentosa_skor',
    ),
);

$i = 1;
// echo '<pre>';var_dump($modPendaftaran->masihAnak);die;
?>

<!-- $modPendaftaran->masihAnak kondisi masih anak atau tidak di hide dan dijadikan defult true karena untuk panel anak di hard di panel anak tidak lagi pakai file ini -->
        <?php if (true) : ?>

            <div class="panel_dewasa">
                <table class="table table-bordered table-condensed" id="tab_skor">
                    <thead>
                        <tr>
                            <th width="50">No.</th>
                            <th>Pengkajian</th>
                            <th width="400">Penilaian</th>
                            <th width="80">Skoring</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($formSkoring as $item) : ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $item['label']; ?></td>
                                <td>
                                    <?php

                                    $paramLookup = LookupM::model()->findAllByAttributes(array(
                                        'lookup_type' => $item['lookup'],
                                    ));

                                    $resParam = CHtml::listData($paramLookup, 'lookup_name', 'lookup_name');
                                    $dataOption = array();

                                    foreach ($paramLookup as $paramItem) {
                                        $dataOption[$paramItem->lookup_name] = array(
                                            'data-value' => $paramItem->lookup_value,
                                        );
                                    }

                                    echo $form->dropDownList(
                                        $model,
                                        $item['param_keterangan'],
                                        $resParam,
                                        array(
                                            'empty' => '-- Pilih --',
                                            'class' => 'list_skor',
                                            'onchange' => 'hitungSkor(this);',
                                            'style' => 'width: 300px',
                                            'options' => $dataOption,
                                        ),
                                        $dataOption
                                    );
                                    ?>
                                </td>
                                <td>
                                    <?php echo $form->textField(
                                        $model,
                                        $item['param_skor'],
                                        array(
                                            'empty' => '-- Pilih --',
                                            'class' => 'txt_skor span1',
                                            'readonly' => 'true',
                                            'style' => 'text-align: right;',
                                        )
                                    );
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>TOTAL SCORING</td>
                            <td></td>
                            <td><?php echo $form->textField($model, 'totalskor', array(
                                    'readonly' => true,
                                    'class' => 'span1',
                                    'style' => 'text-align: right;',
                                )); ?></td>
                        <tr>
                    </tfoot>
                </table>

                <table class="tab_keterangan table table-bordered table-condensed" style="margin: 17px 0 0 !important;">
                    <thead>
                        <tr>
                            <th>Tingkatan Resiko</th>
                            <th>Nilai MPS</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tidak ada Resiko (TR)</td>
                            <td>0 - 24</td>
                            <td>Perawatan Dasar</td>
                        </tr>
                        <tr>
                            <td>Resiko Rendah (RR)</td>
                            <td>25 - 50</td>
                            <td>Pelaksanaan Intervensi Pencegahan Jatuh Standar</td>
                        </tr>
                        <tr>
                            <td>Resiko Tinggi</td>
                            <td>>= 51</td>
                            <td>Pelaksanaan Intervensi Jatuh Resiko Tinggi</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php else : ?>
            <br>

            <div class="panel_anak">
                <table class="table table-bordered table-condensed" id="tab_skor_anak">
                    <thead>
                        <tr>
                            <th width="50">No.</th>
                            <th>Pengkajian</th>
                            <th width="400">Penilaian</th>
                            <th width="80">Skoring</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($formSkoringAnak as $item) : ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $item['label']; ?></td>
                                <td>
                                    <?php

                                    $paramLookup = LookupM::model()->findAllByAttributes(array(
                                        'lookup_type' => $item['lookup'],
                                    ));

                                    $resParam = CHtml::listData($paramLookup, 'lookup_name', 'lookup_name');
                                    $dataOption = array();

                                    foreach ($paramLookup as $paramItem) {
                                        $dataOption[$paramItem->lookup_name] = array(
                                            'data-value' => $paramItem->lookup_value,
                                        );
                                    }

                                    echo $form->dropDownList(
                                        $model,
                                        $item['param_keterangan'],
                                        $resParam,
                                        array(
                                            'empty' => '-- Pilih --',
                                            'class' => 'list_skor',
                                            'onchange' => 'hitungSkorAnak(this);',
                                            'style' => 'width: 300px',
                                            'options' => $dataOption,
                                        ),
                                        $dataOption
                                    );
                                    ?>
                                </td>
                                <td>
                                    <?php echo $form->textField(
                                        $model,
                                        $item['param_skor'],
                                        array(
                                            'empty' => '-- Pilih --',
                                            'class' => 'txt_skor span1',
                                            'readonly' => 'true',
                                            'style' => 'text-align: right;',
                                        )
                                    );
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>TOTAL SCORING</td>
                            <td></td>
                            <td><?php echo $form->textField($model, 'totalskor', array(
                                    'readonly' => true,
                                    'class' => 'span1',
                                    'style' => 'text-align: right;',
                                )); ?></td>
                        <tr>
                    </tfoot>
                </table>
                <div>
                    Skor Penilaian Resiko Jatuh (skor minimum 7, skor maksimum 25)
                    <ul>
                        <li>Skor 7 - 11 Resiko Rendah</li>
                        <li>> 11 Resiko Tinggi</li>
                    </ul>
                </div>
            </div>

        <?php endif; ?>
