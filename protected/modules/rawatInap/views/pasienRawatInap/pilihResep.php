<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rawat Inap</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <th>No Resep</th>
                    <th style="text-align: center;">Verifikasi</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    <?php 
                        if(count($modReseptur) > 0) {
                            foreach ($modReseptur as $i => $data) {
                    ?>
                        <tr>
                            <td><?= $data->noresep ?></td>
                            <td style="text-align: center;">
                                <?php 
                                    echo '<div class="small-container">';
                                    echo CHtml::link("<i class='fa fa-copy'></i>", Yii::app()->controller->createUrl("/farmasiApotek/verifikasiObat/index", array("reseptur_id" => $data->reseptur_id)), array("id" => $data->pendaftaran_id, "rel" => "tooltip", "title" => "Klik untuk Verifikasi Obat", 'onclick' => 'loadingAnimation()'));
                                    echo '</div>';
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $modDetailResep = ResepturdetailT::model()->findAllByAttributes(['reseptur_id' => $data->reseptur_id], "is_verifkasiapoteker is not null");

                                    if(empty($modDetailResep)) {
                                        echo 'Belum Verifikasi';
                                    } else {
                                        echo 'Sudah Verifikasi';
                                    }
                                ?>
                            </td>
                        </tr>

                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function loadingAnimation() { 
        window.parent.$('.frameTabulasi').addClass('animation-loading');
    }
</script>