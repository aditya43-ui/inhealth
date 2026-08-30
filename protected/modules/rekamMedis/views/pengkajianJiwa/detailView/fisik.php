<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_5'>
    <div class="panel-heading">
        <div class="panel-title">Fisik</div>
    </div>
    <div class="panel-body">
        <ol style="list-style: decimal">
            <li>
                Tanda Vital
                <div>
                    <div class="label_d">Tekanan Darah</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo (empty($model->td_systolic) ? "-" : $model->td_systolic)." / ".(empty($model->td_diastolic) ? "-" : $model->td_diastolic) ?> mmHg</div>
                </div>
                <div>
                    <div class="label_d">Nadi</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo (empty($model->nadi) ? "-" : $model->nadi); ?> x/menit</div>
                </div>
                <div>
                    <div class="label_d">Pernapasan</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo (empty($model->pernapasan) ? "-" : $model->pernapasan); ?> x/meni</div>
                </div>
                <div>
                    <div class="label_d">Suhu</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo (empty($model->suhutubuh) ? "-" : number_format($model->suhutubuh, 2, ",", "")); ?> &deg;C</div>
                </div>
            </li>
            <li>
                Ukur
                <div>
                    <div class="label_d">Tinggi Badan/Panjang Badan</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo (empty($model->tinggibadan) ? "-" : number_format($model->tinggibadan, 2, ",", "")); ?> cm</div>
                </div>
                <div>
                    <div class="label_d">Berat Badan</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d">
                        <?php echo (empty($model->beratbadan) ? "-" : number_format($model->beratbadan, 2, ",", "")); ?> Kg<br/>
                        <span><?php echo $model->hasilukur_bbtb == "Turun" ? $ceklis : $unceklis?> Turun </span>
                        <span><?php echo !$model->hasilukur_bbtb == "Naik" ? $ceklis : $unceklis?> Naik </span>
                    </div>
                </div>
            </li>
            <li>
                Keluhan Fisik : 
                <span><?php echo $model->keluhanfisik_status == "Ya" ? $ceklis : $unceklis?> Ya </span>
                <span><?php echo !$model->keluhanfisik_status == "Tidak" ? $ceklis : $unceklis?> Tidak </span>
            </li>
        </ol>
        <br/>
        <div>
            <div class="label_d">Diagnosa Keperawatan</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo empty($model->fisik_diagnosakeperawatan) ? "-" : $model->fisik_diagnosakeperawatan; ?></div>
        </div>
        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
            'diagnosa'=>$diagnosa,
            'label_diagnosa'=>'Diagnosa Fisik',
            'jenisdiagnosa'=>'diagnosa_fisik',
            'kelompokdiagnosa'=>'diagnosa_fisik',
        )); ?>
    </div>
</div>