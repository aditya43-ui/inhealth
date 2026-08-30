<?php

/**
 * mengenerate form implementasi risiko jatuh, jika kondisi tertentu terpenuhi
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */

$implementasi = array(
    'a' => array(
        'label' => 'Memastikan Tempat Tidur / Brankard Dalam Posisi Rendah dan Roda Terkunci',
        'param' => 'imp_rt_rodaterkunci',
    ),
    'b' => array(
        'label' => 'Menutup Pagar Tempat Tidur / Brankard sebelah Kanan',
        'param' => 'imp_rt_menutuppagarbrankard_kanan',
    ),
    'c' => array(
        'label' => 'Menutup Pagar Tempat Tidur / Brankard sebelah Kiri',
        'param' => 'imp_rt_menutuppagarbrankard_kiri',
    ),
    'd' => array(
        'label' => 'Orientasi Pasien / Penunggu tentang Lingkungan / Ruangan',
        'param' => 'imp_rt_orientasikanpasien',
    ),
    'e' => array(
        'label' => 'Beri tanda Segitiga Kuning pada Tempat Tidur',
        'param' => 'imp_rt_beritandasegitiakuning',
    ),
    'f' => array(
        'label' => 'Pastikan Pasien memiliki pin warna kuning penanda RT jatuh pada gelang',
        'param' => 'imp_rt_beripinkuning',
    ),
    'g' => array(
        'label' => 'Lakukan Pemanasa Fiksasi Apabila Diperlukan dengan persetujuan Keluarga',
        'param' => 'imp_rt_pasangfiksasifisik',
    ),
);

?>

<div class="panel panel-success" id="panel_implementasi_tinggi">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Implementasi Resiko Tinggi dan Resiko Rendah
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kegiatan</th>
                    <th>Status Implementasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($implementasi as $no => $item) : ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $item['label']; ?></td>
                        <td><?php echo $form->dropDownList($model, $item['param'], LookupM::getItems('implementasiresikojatuh'), array(
                                // 'empty'=>'-- Pilih --',
                            )); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>