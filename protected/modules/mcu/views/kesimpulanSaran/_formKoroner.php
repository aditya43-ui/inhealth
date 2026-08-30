<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Tgl Hitung Resiko</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"> <?php echo $modKoroner->tglhitungresiko; ?> </td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Total Kolesterol</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->total_kolesterol; ?></td>
                    <td width="30%" style="border:none;">Triglyceride</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->triglycerida; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">HDL Kolesterol</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->hdl_kolesterol; ?></td>
                    <td width="30%" style="border:none;">LDL Kolesterol</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->ldl_kolesterol; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Tekanan Darah</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->tekanandarah; ?></td>
                    <td width="30%" style="border:none;">Hasil Review</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->hasil_review_ab; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Hasil Total Poin</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modKoroner->hasil_totalpoint; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>