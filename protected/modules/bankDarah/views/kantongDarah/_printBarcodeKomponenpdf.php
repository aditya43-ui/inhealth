<?php
if (empty($jenis)){    
    for($i = 1; $i < ($jml_input+1); $i++){
        if (count($modKantongDarah) > 0) {
            foreach ($modKantongDarah as $data) {
                ?>
                <?php for ($i = 1; $i < 9; $i++) { ?>
                    <div style="text-align: center">
                        <span style="font-size: 15px;font-weight: bold;">ITD. RS. SAIFUL ANWAR</span><br>
                        <barcode code="<?php echo $data->no_kantongdarah; ?>" type="EAN128B"></barcode>
                        <span style="font-size: 25px;font-weight: bold;"><?php echo $data->no_kantongdarah; ?></span><br>
                    </div>
                    <?php
                }
            }
        }
    }        
}else{
    foreach ($modKantongDarah as $data) {
        ?>        
            <div style="text-align: center">
                <span style="font-size: 15px;font-weight: bold;">ITD. RS. SAIFUL ANWAR</span><br>
                <barcode code="<?php echo $data->no_kantongdarah; ?>" type="EAN128B"></barcode>
                <span style="font-size: 25px;font-weight: bold;"><?php echo $data->no_kantongdarah; ?></span><br>
            </div>
            <?php
        
    }
}
?>