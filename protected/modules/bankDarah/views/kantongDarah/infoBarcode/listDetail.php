
<div class="form-horizontal" id="form-list-barcode-utama">
    <br/>
    <div class="control-group">
        <div class="controls">
            <label>Pilih barcode kantong darah yang akan dicetak :</label>
        </div>
    </div>
    <div class="control-group">        
        <div class="controls">
            <?php
                $i = 0;
                foreach($model as $d){
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo CHtml::checkBox("pilihBarcode",false,array('class'=>'ceklis', 'nomorbarcode'=>$d)).'<label>&nbsp;&nbsp;&nbsp;'.$d.'</label>';
                    echo "<br/>";
                }
            ?>
        </div>
    </div>
    <hr/>
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::link("<i class='".MyIcon::getIcons('cetak')."'></i> Cetak","javascript:;", array('onclick'=>'setList();','class'=>'btn btn-primary')) ?>
        </div>
    </div>
</div>


<script>
    function setList(){
        var barcode = new Array();
        
        $(".ceklis:checked").each(function(index){
            barcode[index] = $(this).attr('nomorbarcode');
        });
        
        window.open('<?php echo $this->createUrl('PrintAllBarcode'); ?>&jenis=allbarcode&nomorbarcode_utama='+barcode, 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>