<?php if (count($modKantongDarah) == 1) { ?>
<style>
    tr, td{ 
        font-size: 8pt !important; 
        margin-top: 0px;
    }
    body{
        margin-top: -20px;
        width:6cm; 
    }
</style>
    <table>
        <tr>
            <td>
                <?php
                if (count($modKantongDarah) > 0) {
                    foreach ($modKantongDarah as $data) {
                        ?>
                        <div style="width:320px; height: 180px;">
                            <table style="margin-top: 20px;">
                                <tr>
                                <span style="margin-left: 26px;font-size: 18px;font-weight: bolder; position:absolute">ITD. RS. SAIFUL ANWAR</span>
                                </tr>
                                <tr>
                                    <td>
                                        <img style="height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                        <br>
                                        <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                    </td>
                                </tr> 
                            </table>
                        </div>
                        <?php
                        /* looping berdasarkan jumlah kantong sebanyak 6 lembar */
                        for ($i = 1; $i < 8; $i++) {
                            ?>
                            <div style="width:320px; height: 180px;">
                                <table>
                                    <tr>
                                    <span style="margin-left: 26px;font-size: 18px;font-weight: bolder; position:absolute">ITD. RS. SAIFUL ANWAR</span>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                            <br>
                                            <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                        </td>
                                    </tr> 
                                </table>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
    </table>
<?php } else if (count($modKantongDarah) == 2) { ?>
<style>
    tr, td{ 
        font-size: 8pt !important; 
        margin-top: 0px;
    }
    body{
        margin-top: -5px;
        width:6cm; 
    }
</style>
    <table>
        <tr>
            <td>
                <?php
                if (count($modKantongDarah) > 0) {
                    foreach ($modKantongDarah as $data) {
                        ?>
                        <div style="width:320px; height: 180px;">
                            <table style="margin-top: 5px;">
                                <tr>
                                <span style="margin-left: 26px;font-size: 18px;font-weight: bolder; position:relative">ITD. RS. SAIFUL ANWAR</span>
                                </tr>
                                <tr>
                                    <td>
                                        <img style="margin-top: -30px;height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                        <br>
                                        <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                    </td>
                                </tr> 
                            </table>
                        </div>
                        <?php
                        /* looping berdasarkan jumlah kantong sebanyak 6 lembar */
                        for ($i = 1; $i < 8; $i++) {
                            ?>
                            <div style="width:320px; height: 180px;">
                                <table>
                                    <tr>
                                    <span style="margin-left: 26px;font-size: 18px;font-weight: bolder; position:relative">ITD. RS. SAIFUL ANWAR</span>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="margin-top: -24px;height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                            <br>
                                            <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                        </td>
                                    </tr> 
                                </table>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
    </table>
<?php } else if (count($modKantongDarah) == 3) { ?>
<style>
    tr, td{ 
        font-size: 8pt !important; 
        margin-top: 0px;
    }
    body{
        margin-top: -15px;
        width:6cm; 
    }
    .atas{
        margin-top: 15px;
    }
</style>
    <table>
        <tr>
            <td>
                <?php
                if (count($modKantongDarah) > 0) {
                    foreach ($modKantongDarah as $data) {
                        ?>
                        <div class="atas" style="width:320px; height: 170px;" >
                            <table>
                                    <tr>
                                    <span style="margin-top:15px !important; margin-left: 26px;font-size: 18px;font-weight: bolder; position:relative">ITD. RS. SAIFUL ANWAR</span>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="margin-top: -26px;height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                            <br>
                                            <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                        </td>
                                    </tr> 
                                </table>
                            </div>
                        <?php
                        /* looping berdasarkan jumlah kantong sebanyak 6 lembar */
                        for ($i = 1; $i < 8; $i++) {
                            ?>
                            <div style="width:320px; height: 180px;">
                                <table>
                                    <tr>
                                    <span style="margin-left: 26px;font-size: 18px;font-weight: bolder; position:relative">ITD. RS. SAIFUL ANWAR</span>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img style="margin-top: -24px;height: 113.385826772px; width:265px; margin-bottom: -52px; margin-left: 3px;" src="index.php?r=barcode/myBarcode&code=<?php echo $data->no_kantongdarah; ?>&is_text=">
                                            <br>
                                            <span style="margin-left: 24px;font-size: 29px;font-weight: bolder;"><?php echo $data->no_kantongdarah; ?></span>
                                        </td>
                                    </tr> 
                                </table>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
    </table>
    <?php
}?>