<?php
    foreach ($modKantongDarah as $data) {
        if ($data['nomorbarcode_utama'] == $data['no_kantongdarah']){
            $init = 16;
        }else{
            $init = 8;
        }
        
        for($i=1;$i<=$init;$i++){
?>
            <div style="text-align: center">
                <span style="font-size: 15px;font-weight: bold;">ITD. RS SAIFUL ANWAR</span><br>
                <barcode code="<?php echo $data['no_kantongdarah']; ?>" type="EAN128B"></barcode>
                <span style="font-size: 25px;font-weight: bold;"><?php echo $data['no_kantongdarah']; ?></span><br>
            </div>
<?php
        }
    }    
?>