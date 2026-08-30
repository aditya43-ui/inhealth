<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Diagnosa</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"> <?php echo $modDiagnosis->diagnosa->diagnosa_nama; ?> </td>
                    <td width="30%" style="border:none;">Kelompok Diagnosa</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modDiagnosis->kelompokdiagnosa->kelompokdiagnosa_nama; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Tgl Diagnosa</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modDiagnosis->tglmorbiditas; ?></td>
                    <td width="30%" style="border:none;">Kasus Diagnosa</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modDiagnosis->kasusdiagnosa; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>