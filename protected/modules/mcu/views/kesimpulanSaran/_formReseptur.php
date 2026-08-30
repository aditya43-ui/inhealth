<div class="panel panel-dark">
    <span class="group-title">
        <b></b>
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
            <table border = "0" style="border:none;">';
                <tr style="border:none;">
                    <td width="10%" style="border:none;">Tgl Reseptur</td>
                    <td width="1%" style="border:none;">:</td>
                    <td width="30%" style="border:none;"> <?php echo $modReseptur->tglreseptur; ?> </td>
                </tr>
                <tr style="border:none;">
                    <td  style="border:none;">No Resep</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php echo $modReseptur->noresep; ?></td>
                    <td  style="border:none;">Nama Obat</td>
                    <td  style="border:none;">:</td>
                    <td style="border:none;"><?php 
                    $modResepturDet = ResepturdetailT::model()->findByAttributes(array('reseptur_id' => $modReseptur->reseptur_id));
                    echo $modResepturDet->obatalkes->obatalkes_nama; ?></td>
                </tr>
            </table>  
            </div>
        </div>
    </div>
</div>