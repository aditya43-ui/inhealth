<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="30%" style="border:none;">Tgl Surat</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"> <?php echo $modSurat->tglsurat; ?> </td>
                    <td width="30%" style="border:none;">Judul Surat</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSurat->judulsurat; ?></td>
                </tr>
                <tr style="border:none;">
                    <td width="30%" style="border:none;">No Surat</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSurat->nomorsurat; ?></td>
                    <td width="30%" style="border:none;">Alasan Kontrol</td>
                    <td width="1%" style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modSurat->kontrol_alasan; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>