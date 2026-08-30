<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_10'>
    <div class="panel-heading">
        <div class="panel-title">Masalah Psikososial dan Lingkungan</div>
    </div>
    <div class="panel-body">
        <div>
            <?php echo $model->masalahdlm_dukungankelompok ? $ceklis : $unceklis ?> Masalah dengan dukungan kelompok
            <?php if ($model->masalahdlm_dukungankelompok) {
                echo '<div style="margin-left: 15px;">';
                echo "Uraian : ".$model->masalahdlm_dukungankelompokket;
                echo '</div>';
            } ?>
        </div>
        <div>
            <?php echo $model->masalahhub_dengankelompok ? $ceklis : $unceklis ?> Masalah hubungan dengan lingkungan
            <?php if ($model->masalahhub_dengankelompok) {
                echo '<div style="margin-left: 15px;">';
                echo "Uraian : ".$model->masalahhub_dengankelompokket;
                echo '</div>';
            } ?>
        </div>
        <div>
            <?php echo $model->masalahdgn_pendidikan ? $ceklis : $unceklis ?> Masalah dengan pendidikan
            <?php if ($model->masalahdgn_pendidikan) {
                echo '<div style="margin-left: 15px;">';
                echo "Uraian : ".$model->masalahdgn_pendidikanket;
                echo '</div>';
            } ?>
        </div>
        <div>
            <?php echo $model->masalahdgn_pekerjaan ? $ceklis : $unceklis ?> Masalah dengan pekerjaan
            <?php if ($model->masalahdgn_pekerjaan) {
                echo '<div style="margin-left: 15px;">';
                echo "Uraian : ".$model->masalahdgn_pekerjaanket;
                echo '</div>';
            } ?>
        </div>
        <div>
            <?php echo $model->masalahdgn_perumahan ? $ceklis : $unceklis ?> Masalah dengan perumahan
            <?php if ($model->masalahdgn_perumahan) {
                echo '<div style="margin-left: 15px;">';
                echo "Uraian : ".$model->masalahdgn_perumahanket;
                echo '</div>';
            } ?>
        </div>
    </div>
</div>