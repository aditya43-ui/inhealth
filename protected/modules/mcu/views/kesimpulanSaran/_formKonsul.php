<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Tgl Konsul</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"> <?php echo $modKonsul->tglkonsulpoli; ?> </td>
                    <td width="30%" style="border:none;">Status Periksa</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKonsul->statusperiksa; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;"></td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"></td>
                    <td width="30%" style="border:none;">Catatan Dokter Konsul</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKonsul->catatan_dokter_konsul; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>