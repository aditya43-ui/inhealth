<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Detail Catatan Edukasi</div>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Data Edukasi</div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label">Nama Pasien</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_pasien', $pendaftaran->pasien->nama_pasien, array('class' => 'span3', 'readonly' => true)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">No. Rekam Medik</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_pasien', $pendaftaran->pasien->no_rekam_medik, array('class' => 'span3', 'readonly' => true)); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tanggal Lahir</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_pasien', MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir), array('class' => 'span3', 'readonly' => true)); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Jenis Kelamin</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_pasien', $pendaftaran->pasien->jeniskelamin, array('class' => 'span3', 'readonly' => true)); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <label class="control-label">Nama Edukator</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_edukator', empty($model->edukator) ? "" : $model->edukator->namaLengkap, array('class' => 'span3', 'readonly' => true)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Metode</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_edukator', $model->metodeedukasi, array('class' => 'span3', 'readonly' => true)); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Durasi</label>
                                <div class="controls">
                                    <?php echo CHtml::textField('nama_edukator', $model->durasi . " Menit", array('class' => 'span3', 'readonly' => true)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Form Catatan Edukasi A</div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th colspan="2"><?php echo $model->kodeprofesi; ?></th>
                            </tr>
                            <tr>
                                <th width="50%">Penjelasan</th>
                                <th>Keterangan dan Evaluasi Respon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    if (count($penjelasan) > 0) {
                                        echo '<ul style="list-style-type: none; margin-left: 0px;">';
                                        foreach ($penjelasan as $item2) {
//                                            if (!$item2->isceklis) {
//                                                continue;
//                                            }
                                            echo "<li>";
                                            echo $item2->isceklis ? $ceklis : $unceklis." ";
                                            echo $item2->nama_edukasi;
                                            if ($item2->nama_edukasi == "Lainnya") {
                                                echo ", " . $item2->lainnya;
                                            }
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (count($keterangan) > 0) {
                                        echo '<ul style="list-style-type: none; margin-left: 0px;">';
                                        foreach ($keterangan as $item2) {
//                                            if (!$item2->isceklis) {
//                                                continue;
//                                            }
                                            echo "<li>";
                                            echo $item2->isceklis ? $ceklis : $unceklis." ";
                                            echo $item2->keterangan_evaluasi;
                                            if ($item2->keterangan_evaluasi == "Lainnya") {
                                                echo ", " . $item2->lainnya;
                                            }
                                            echo "</li>";
                                        }
                                        echo "</ul>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Form Catatan Edukasi B</div>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <label>Penjelasan/IKE</label><br/>
                            <?php echo CHtml::textArea('penjelasan', $model->penjelasan_kie, array('class'=>'span4', 'readonly'=>true)); ?>
                        </div>
                        <div class="col-sm-6">
                            <label>Keterangan dan Evaluasi</label><br/>
                            <?php echo CHtml::textArea('penjelasan', $model->keterangan_dan_evaluasi, array('class'=>'span4', 'readonly'=>true)); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
