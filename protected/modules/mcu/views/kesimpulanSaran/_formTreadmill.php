<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Rest Time</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"> <?php echo $modTreadmill->resttime_menit; ?> </td>
                    <td width="30%" style="border:none;">Work Time</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modTreadmill->worktime_menit; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Recovery Time</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modTreadmill->recoverytime_menit; ?></td>
                    <td width="30%" style="border:none;">Total Time</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modTreadmill->totaltime_menit; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Hasil Treadmill</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modTreadmill->hasiltreadmill; ?></td>
                    <td width="30%" style="border:none;">Kebugaran</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modTreadmill->tingkatkebugaran; ?></td>
                    
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>