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
        'param' => 'imp_rr_rodaterkunci',
    ),
    'b' => array(
        'label' => 'Menutup Pagar Tempat Tidur / Brankard sebelah Kanan',
        'param' => 'imp_rr_menutuppagarbrankard_kanan',
    ),
    'b' => array(
        'label' => 'Menutup Pagar Tempat Tidur / Brankard sebelah Kiri',
        'param' => 'imp_rr_menutuppagarbrankard_kiri',
    ),
    'c' => array(
        'label' => 'Orientasi Pasien / Penunggu tentang Lingkungan / Ruangan',
        'param' => 'imp_rr_orientasipasien',
    ),
);

?>

<div class="panel panel-success" id="panel_implementasi_rendah">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Implementasi Resiko Rendah
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