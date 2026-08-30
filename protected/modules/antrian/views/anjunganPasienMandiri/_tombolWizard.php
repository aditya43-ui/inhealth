<br/>
<br/>
<div class="row-fluid">
    <div class="pull-left">
        <?php 
        if (!empty($prev_id) && !empty($prev_label)) {
            echo CHtml::htmlButton($prev_label, array(
                'class'=>'btn btn-success', 'onclick'=>"setFormPanel('".$prev_id."', 'prev');"
            ));
        } ?>
    </div>
    <div class="pull-right">
    <?php 
        if (!empty($next_id) && !empty($next_label)) {
            if ($next_id == "submit") {
                echo CHtml::htmlButton($next_label, array(
                    'class'=>'btn btn-success', 'onclick'=>"cekVerifikasi();"
                ));
            } else {
                echo CHtml::htmlButton($next_label, array(
                    'class'=>'btn btn-success', 'onclick'=>"setFormPanel('".$next_id."', 'next');"
                ));
            }

            
        } ?>
    </div>
</div>
<div class="row-fluid" style="text-align: center">
    <?php echo CHtml::htmlButton("<i class='entypo-home'></i>Kembali ke Halaman Awal", array(
        'class'=>'btn btn-info', 'onclick'=>"kembaliKeHalamanAwal();"
    )); ?>
</div>