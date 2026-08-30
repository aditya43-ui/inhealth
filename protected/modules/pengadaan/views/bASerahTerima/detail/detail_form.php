<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'baserahterima-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<div style="min-height: 950px !important">
    <div class="panel-group joined" id="accordion-khp"> 
        
        <div class="panel panel-success"> 
            <div class="panel-heading"> 
                <h4 class="panel-title" style="background-color: #b0eaa5"> 
                    <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                       Detail Berita Acara Serah Terima
                    </a> 
                </h4> 
            </div> 
            <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
                <div class="panel-body" style="background-color: #fff">
                    <div class="panel panel-success">
                        <div class="panel panel-heading">
                            <div class="panel-title"> <b> Berita Acara Serah Terima </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial('detail/_formSerahTerima', array('model' => $model, 'form' => $form)) ?>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel panel-heading">
                            <div class="panel-title"> <b> Lampiran </b> </div>
                        </div>
                        <div class="panel-body">
                            <?php $this->renderPartial('detail/_formLampiran', array('modBADetail' => $modBADetail, 'model' => $model, 'modDetail' => $modDetail, 'modSurat' => $modSurat, 'form' => $form)) ?>
                        </div>
                    </div>
                    
                </div> 
            </div> 
        </div> 
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $("#baserahterima-t-form").find("input, textarea, select").each(function () {
                $(this).attr("disabled", true);
            });
            
            $(document).ready(function(){
                $('.integer-decimal').each(function(){
                $(this).val(formatThousandDecimal(parseFloat($(this).val())));
            });
            });
</script>  