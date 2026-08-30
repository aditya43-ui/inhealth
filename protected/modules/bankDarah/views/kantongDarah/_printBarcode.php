<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: left;
        letter-spacing: 3px; 
        font-size: 5pt;
    } 
    tr, td{ 

        font-size: 8pt !important; 
        margin-top: 0px;
    }
    body{
        margin-top: -20px;
        width:3cm; 

    }
</style>
<table>
    <tr>
        <td>
            <div style="width:320px; height: 180px;">
                    <table style="margin-top: 20px;">
                        <tr>
                        <span style="margin-left: 27px;font-size: 18px;font-weight: bolder; position:absolute">ITD. RS. SAIFUL ANWAR</span>
                        </tr>
                        <tr>
                            <td>
                                <img style="height: 113.385826772px; margin-bottom: -52px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modKantongDarah->nomorbarcode_utama; ?>&is_text=">
                                <br>
                                <span style="margin-left: 25px;font-size: 30px;font-weight: bolder;"><?php echo $modKantongDarah->nomorbarcode_utama; ?></span>
                            </td>
                        </tr> 
                    </table>
                </div>
            <?php for ($i = 1; $i < 12; $i++) { ?>
                <div style="width:320px; height: 180px;">
                    <table>
                        <tr>
                        <span style="margin-left: 27px;font-size: 18px;font-weight: bolder; position:absolute">ITD. RS. SAIFUL ANWAR</span>
                        </tr>
                        <tr>
                            <td>
                                <img style="height: 113.385826772px; margin-bottom: -52px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modKantongDarah->nomorbarcode_utama; ?>&is_text=">
                                <br>
                                <span style="margin-left: 25px;font-size: 30px;font-weight: bolder;"><?php echo $modKantongDarah->nomorbarcode_utama; ?></span>
                            </td>
                        </tr> 
                    </table>
                </div>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div style="width:320px; height: 180px;">
                    <table>
                        <tr>
                        <span style="margin-left: 32px;font-size: 18px;font-weight: bolder; position:absolute">ITD. RS. SAIFUL ANWAR</span>
                        </tr>
                        <tr>
                            <td>
                                <img style="margin-left: -25px;height: 113.385826772px; margin-bottom: -52px; " src="index.php?r=barcode/myBarcode&code=<?php echo ($i == 1)?$modKantongDarah->nomorbarcode_sample:$modKantongDarah->nomorbarcode_sample_imltd; ?>&is_text=">
                                <br>
                                <span style="margin-left: 30px;font-size: 30px;font-weight: bolder;"><?php echo ($i == 1)?$modKantongDarah->nomorbarcode_sample:$modKantongDarah->nomorbarcode_sample_imltd; ?></span>
                            </td>
                        </tr> 
                    </table>
                </div>
            <?php } ?>
        </td>
    </tr>
</table>