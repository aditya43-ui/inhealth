<?php
$titik = new CustomFunction;
$jarak = ' &nbsp;';

echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true], true); 
?>


<table class='w100 prinout grid' autosize="0">    
    <tr>
        <td colspan="2">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td width="35%"><b>PRESCRIPTION DOKTER</b></td>
                    <td width="3%">:</td>
                    <td width="10%"><?= ceklis($model->prescription_dokter_akut) ?> Akut</td>
                    <td width="14%"><?= ceklis($model->prescription_dokter_kronis) ?> Kronis</td>
                    <td width="15%"><?= ceklis($model->prescription_dokter_pirrt) ?> PIRRT</td>
                    <td width="45%">&nbsp;</td>
                </tr>
            </table>
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td width="3%">-</td>
                    <td>Time</td>
                    <td width="3%">:</td>
                    <td><?= $titik->defaulttitik(10,$model->durasi_time, $jarak) ?> <?= $model->time_satuan ?></td>
                    <td width="5%">&nbsp;</td>
                     <td width="3%">-</td>
                    <td>Heparinisasi</td>
                    <td width="3%">:</td>
                    <td><?= ceklis($model->heparinisasi_standar) ?> Standar</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Blood flow</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->blood_flow, $jarak) ?> mL/menit</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($model->heparinisasi_minimal) ?> Minimal</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialysate flow</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->dialysate_flow, $jarak) ?> mL/menit</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($model->heparinisasi_tanpaheparin) ?> Tanpa heparin, penyebab <?= $titik->defaulttitik(10,$model->heparinisasi_tanpaheparin_penyebab, $jarak) ?></td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialysate</td>
                    <td>:</td>
                    <td><?= ceklis($model->dialysate_bicarbonat) ?> Bicarbonat</td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($model->heparinisasi_lmwh) ?> LMWH, &nbsp;&nbsp; <?= ceklis($model->heparinisasi_lainnya) ?> <?= $titik->defaulttitik(20,$model->heparinisasi_lainnya_penyebab, $jarak) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= ceklis($model->dialysate_lainnya) ?> <?= $titik->defaulttitik(10,$model->dialysate_lainnya_keterangan, $jarak) ?></td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Selisih BB</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->selisih_berat_badan, $jarak) ?> mL</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Dialyser</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->diayser, $jarak) ?></td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Infus / transfusi</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->infus, $jarak) ?> mL</td>
                </tr>
                <tr>
                    <td>-</td>
                    <td colspan="3">Dialysate temperature : <?= $titik->defaulttitik(10,$model->dialyser_temperature, $jarak) ?><sup>o</sup>C</td>
                    <td>&nbsp;</td>
                    <td>-</td>
                    <td>Ultra filtration goal</td>
                    <td>:</td>
                    <td><?= $titik->defaulttitik(10,$model->uf_goal, $jarak) ?> mL</td>
                </tr>
            </table>
        </td>
    </tr>   
    <tr>
        <td colspan="2" height="50px">
            <table class='w100 prinout no-grid' autosize="0">    
                <tr>
                    <td >
                        Catatan Lain : <?= $titik->defaulttitik(181, $model->catatan_lain, $jarak) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>