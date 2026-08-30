<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="10%" style="border:none;">Tgl Spirometri</td>
                    <td width="1%" style="border:none;">:</td>
                    <td width="30%" style="border:none;"> <?php echo $modSpirometri->spirometri_tgl; ?> </td>
                </tr>
                <tr style="border:none;">
                    <td  style="border:none;">SVC Prediksi</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->svc_prediksi; ?></td>
                    <td  style="border:none;">SVC</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->svc; ?></td>
                    <td  style="border:none;">SVC Persen</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->svc_persen; ?></td>
                </tr>
                <tr style="border:none;">
                    <td  style="border:none;">FVC Prediksi</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fvc_prediksi; ?></td>
                    <td  style="border:none;">FVC</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fvc; ?></td>
                    <td  style="border:none;">FVC Persen</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fvc_persen; ?></td>
                </tr>
                <tr style="border:none;">
                    <td  style="border:none;">FEV1 Prediksi</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fev1_prediksi; ?></td>
                    <td  style="border:none;">FEV1</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fev1_fvc; ?></td>
                    <td  style="border:none;">FEV1 Persen</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->fev1_fvc_persen; ?></td>
                </tr>
                <tr style="border:none;">
                    <td  style="border:none;">PFR Prediksi</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->pfr_prediksi; ?></td>
                    <td  style="border:none;">PEFR</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->pfr; ?></td>
                    <td style="border:none;">PEFR Persen</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->pfr_persen; ?></td>
                </tr>
                <tr style="border:none;">
                    <td style="border:none;">Kesimpulan</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSpirometri->kesimpulan; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>