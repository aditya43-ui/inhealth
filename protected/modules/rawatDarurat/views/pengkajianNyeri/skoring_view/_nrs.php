<div class="panel panel-success form_skoring form_nrs">
    <div class="panel-heading">
        <div class="panel-title">Numerical Rating Scale (NRS)</div>
    </div>
    <div class="panel-body">

        <style>
            .ruler-nyeri-tengah{
                border-left:1px solid #333 !important;
                border-top:1px solid #333 !important;
                border-right:1px solid #333 !important;
            }

            .ruler-nyeri-left{
                border-left:1px solid #333 !important;				
            }
            .ruler-nyeri-right{
                border-right:1px solid #333 !important;				
            }

            .nyeri-nomor{
                margin-left: -11px;
            }
        </style>

        <h2 style="text-align: center;">Numerical Rating Scale (NRS)</h2>
        
        <table class="table noborder paddingtext" style="text-align: center; box-shadow: none;">  
            <tr>
                <td width='1px;'>
                    &nbsp;
                </td>
                <td colspan="12" style="margin-left:10px;">
                    <table width='100%'>
                        <tr>
                            <td class='ruler-nyeri-left'></td>
                            <td class=''></td>
                            <td class=''></td>
                            <td class=''></td>					
                            <td class=''></td>
                            <td class=''></td>				
                            <td class=''></td>
                            <td class=''></td>
                            <td class=''></td>
                            <td class='ruler-nyeri-right'></td>
                        </tr>
                        <tr>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>
                            <td class='ruler-nyeri-tengah'></td>					
                            <td class='ruler-nyeri-tengah'></td>					
                            <td class='ruler-nyeri-tengah'></td>	
                        </tr>
                        <tr>

                            <?php
                            for ($i = 0; $i <= 10; $i++) {
                                ?>
                                <td width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a style="position:relative; left:-5px;" class="hover"><span style="padding: 4px;" class="nyeri-nomor" id="nyerinomor_<?php echo $i; ?>" ><?php echo $i; ?></span></a></td>
                                <?php
                            }
                            ?>
                        </tr>				
                    </table>			
                </td>
            </tr>	
            <tr>
                <td colspan="12" style="color:black">
                    Skala Nyeri
                    <?php echo CHtml::activeTextField($model, 'skalanyeri', array('class' => 'span1', 'readonly' => true, 'style' => 'text-align:right;')) ?>
                    <?php echo CHtml::activeTextField($model, 'keterangan_skalanyeri', array('class' => 'span3', 'readonly' => true, 'style' => 'text-align:left;')) ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>
    
    
function pilihScala_nrs(skor){
    var keterangan;

    if (skor == 0){
        keterangan = '<?php echo Params::SKALA_NYERI_0; ?>';
    }else if (skor >= 1 && skor <= 2){
        keterangan = '<?php echo Params::SKALA_NYERI_1_2; ?>';
    }else if (skor >= 3 && skor <= 4){
        keterangan = '<?php echo Params::SKALA_NYERI_3_4; ?>';
    }else if (skor >= 5 && skor <= 6){
        keterangan = '<?php echo Params::SKALA_NYERI_5_6; ?>';
    }else if (skor >= 7 && skor <= 8){
        keterangan = '<?php echo Params::SKALA_NYERI_7_8; ?>';
    }else if (skor >= 9 && skor <= 10){
        keterangan = '<?php echo Params::SKALA_NYERI_9_10; ?>';
    }
    //if(skor != 0){
        $('.form_nrs').find("#<?php echo CHtml::activeId($model, 'skalanyeri') ?>").val(skor);
        $('.form_nrs').find("#<?php echo CHtml::activeId($model, 'keterangan_skalanyeri') ?>").val(keterangan);
    //}

    $('.form_nrs').find(".nyeri-nomor").css("border", "none");
    $('.form_nrs').find(".nyeri-nomor").css("border-radius", "5px");
    $('.form_nrs').find("#nyerinomor_" + skor).css("border", "1px solid black");
}

$(document).ready(function() {
    <?php if (!$model->isNewRecord && $model->sistemskoring == "nrs") { ?>
            pilihScala_nrs(<?php echo $model->skalanyeri; ?>);
    <?php } ?>
});
    
</script>