<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rootwizard',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title judul">Output</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="control-group">
                    <label class="control-label">Jam Ke -</label>
                    <div class="controls">
                        <?php
                        $cekOutput = ATOutputintraanastesiT::model()->findByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id));
                        if (!empty($cekOutput)) {
                           $modOutput = ATOutputintraanastesiT::model()->findByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id));
                        } else {
                            $modOutput = new ATOutputintraanastesiT();
                        }    
                        $modOutput->jam_ke = !empty($cekOutput) ? $cekOutput->jam_ke : null;
                        $modOutput->monitoringintraanastesi_id = !empty($cekOutput) ? $cekOutput->monitoringintraanastesi_id : null;
                        
                        echo CHtml::activeHiddenField($modOutput, 'monitoringintraanastesi_id', array('class' => 'numbers-only span1'));
                        echo CHtml::activeTextField($modOutput, 'jam_ke', array('class' => 'numbers-only span1'));
                        ?>
                    </div>
                </div>
                <?php
                $output = LookupM::getItemsUrutan('monitorintraanestesi_outcairankeluar');

                if (!empty($output)) {
                    $i = 0;
                    foreach ($output as $key => $val) {
                        $modOutput->jenis_output2 = $key;
                        if (!empty($model->monitoringintraanastesi_id)) {
                            $cekOutput = OutputintraanastesiT::model()->findByAttributes(array('monitoringintraanastesi_id' => $model->monitoringintraanastesi_id, 'jenis_output2' => $key));
                            $modOutput->nama_output2 = !empty($cekOutput) ? $cekOutput->nama_output2 : null;
                            $modOutput->outputintraanastesi_id = !empty($cekOutput) ? $cekOutput->outputintraanastesi_id : null;
                        }
                        ?>
                        <div class="control-group">
                            <label class="control-label"><?php echo $val ?></label>
                            <div class="controls">
                                <?php
                                echo CHtml::activeHiddenField($modOutput, '[det][' . $i . ']outputintraanastesi_id', array('class' => 'span4'));
                                echo CHtml::activeTextField($modOutput, '[det][' . $i . ']nama_output2', array('class' => 'span4'));
                                echo CHtml::activeHiddenField($modOutput, '[det][' . $i . ']jenis_output2', array('class' => 'span4', 'readonly' => true));
                                ?>
                            </div>
                            <div class="controls">
                                <?php
                                if ($key == Params::MONITOR_INTRAANESTESI_OUTCAIRANKELUAR_EBL) {
                                    echo '<label>%</label>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>   
<script>
    $(document).ready(function () {
        $("#rootwizard").find('input,select,textarea').each(function () {
            $(this).attr('disabled', true);
        });

        $(".add-on").hide();
        $(".buttontambah").hide();
        $(".buttonhapus").hide();
        $(".rowbutton").attr("style", "display:none;");
    });
</script>