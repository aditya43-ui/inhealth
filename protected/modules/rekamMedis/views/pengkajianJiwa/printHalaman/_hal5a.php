<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        VIII. MEKANISME KOPING
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Adatif</td>
                            <td>:</td>
                            <td>
                                <?php 
                                $koping = LookupM::getItemsUrutan('askepjiwa_kopingadatif');
                                $data_koping = empty($model->koping_adatif) ? array() : CJSON::decode($model->koping_adatif);

                                foreach ($koping as $val => $label): 
                                    echo '<div>';
                                    echo in_array($val, $data_koping) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <tr>
                            <td>Maladatif</td>
                            <td>:</td>
                            <td>
                                <?php 
                                $koping = LookupM::getItemsUrutan('askepjiwa_kopingmaladatif');
                                $data_koping = empty($model->koping_maladatif) ? array() : CJSON::decode($model->koping_maladatif);

                                foreach ($koping as $val => $label): 
                                    echo '<div>';
                                    echo in_array($val, $data_koping) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
<div class="panel_main">
    <div class="panel_judul">
        IX. MASALAH PSIKOSOSIAL DAN LINGKUNGAN
    </div>
    <div class="panel_body">
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
<div class="panel_main">
    <div class="panel_judul">
        X. KURANGNYA PENGETAHUAN
    </div>
    <div class="panel_body">
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>Kurangnya Pengetahuan</td>
                    <td>:</td>
                    <td>
                        <?php 
                        $pengetahuan = LookupM::getItemsUrutan('askepjiwa_kurangnyapendidikan');
                        $data_pengetahuan = empty($model->kurangnyapendidikan) ? array() : CJSON::decode($model->kurangnyapendidikan);

                        foreach ($pengetahuan as $val => $label): 
                            echo '<div>';
                            echo in_array($val, $data_pengetahuan) ? $ceklis : $unceklis;
                            echo " ".$label."  ";
                            echo '</div>';
                        endforeach; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

