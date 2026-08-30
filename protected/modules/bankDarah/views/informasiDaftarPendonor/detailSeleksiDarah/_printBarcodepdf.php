<?php
if (count($modKantongDarah) > 0) {
    foreach ($modKantongDarah as $data) {
        ?>
        <?php for ($i = 1; $i < 17; $i++) { ?>
            <div style="text-align: center">
                <span style="font-size: 15px;font-weight: bold;">ITD. RSUD. DR. SOETOMO</span><br>
                <barcode code="<?php echo $data->no_kantongdarah; ?>" type="EAN128B"></barcode>
                <span style="font-size: 25px;font-weight: bold;"><?php echo $data->no_kantongdarah; ?></span><br>
            </div>
            <?php
        }
    }
}
?>