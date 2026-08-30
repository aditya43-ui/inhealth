<?php
if (count($modTindakan) > 0) {
    foreach ($modTindakan as $i => $data) {
        // echo 'tes ini';
        ?>
        <div style="text-align: center">
            <span style="font-size: 15px;font-weight: bold;"></span><br>
            <barcode code="<?php echo $data->no_pengambilansample; ?>" type="EAN128B"></barcode><br>
            <span style="font-size: 20px;font-weight: bold;"><?php echo $data->no_pengambilansample; ?></span><br>
        </div>
        <?php
        if($i !== count($modTindakan) - 1) {
            echo '<br>';
        }
    }
}
?>