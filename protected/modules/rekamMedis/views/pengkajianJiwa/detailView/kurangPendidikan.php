<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_11'>
    <div class="panel-heading">
        <div class="panel-title">Kurangnya Pengetahuan, Aspek Medis & Diagnosis Keperawatan</div>
    </div>
    <div class="panel-body">
        <div>
            <div class="label_d">Kurangnya Pengetahuan</div>
            <div class="kolon_d">:</div>
            <div class="body_d">
                <?php 
                $pengetahuan = LookupM::getItemsUrutan('askepjiwa_kurangnyapendidikan');
                $data_pengetahuan = empty($model->kurangnyapendidikan) ? array() : CJSON::decode($model->kurangnyapendidikan);

                foreach ($pengetahuan as $val => $label): 
                    echo '<div>';
                    echo in_array($val, $data_pengetahuan) ? $ceklis : $unceklis;
                    echo " ".$label."  ";
                    echo '</div>';
                endforeach; ?>
            </div>
        </div>
        <br/>
        <strong>Aspek Medis</strong>
        <div>
            <div class="label_d">Diagnosa Medik</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo empty($model->diagnosamedik) ? null : $model->diagnosamedik; ?></div>
        </div>
        <div>
            <div class="label_d">Terapi Medik</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo empty($model->terapimedik) ? null : $model->terapimedik; ?></div>
        </div>
        <div>
            <div class="label_d">Riwayat penggunaan Obat</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo empty($model->riwayat_penggunaanobat) ? null : $model->riwayat_penggunaanobat; ?></div>
        </div>
        <div>
            <div class="label_d">Hasil Pemeriksaan Laboratorium</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo empty($model->hasilperiksa_lab) ? null : $model->hasilperiksa_lab; ?></div>
        </div>
        <br/>
        <strong>Diagnosa Keperawatan</strong>
        <?php echo empty($model->diagnosakeperawatan) ? null : $model->diagnosakeperawatan; ?>
    </div>
</div>