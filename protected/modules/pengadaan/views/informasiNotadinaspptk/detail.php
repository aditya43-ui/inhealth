<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'notadinaspptk-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<style>
    .control-label{
        width: 195px !important; 
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Detail <strong>Nota Dinas PPTK</strong></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data <b> Referensi  </b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('detail/_formPersiapanpengadaan', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
            </div>
        </div>
        <?php if(!empty($model->suratperjanjiankerja_id)) : ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Kontrak </b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('detail/_formKontrak', array('model' => $model, 'form' => $form), true); ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Nota Dinas PPTK </b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('detail/_formNotadinas', array('model' => $model, 'form' => $form), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b> Rincian </b></div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-condensed" id="tabelRincian">
                    <?php
                    echo $this->renderPartial('detail/_rowdetail', array('modDetail' => $modDetail, 'model' => $model, 'form' => $form), true);
                    ?>
                </table>
                <?php 
                        echo $form->textFieldRow($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                        echo $form->textFieldRow($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                        echo $form->textFieldRow($model, 'jumlah_diterima', array('class' => 'span3 integer-decimal', 'readonly' => true));
                        echo $form->textFieldRow($model, 'sisa_pagu', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                    ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-green', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>

    $(document).ready(function () {
        $("#notadinaspptk-t-form").find('input,select,textarea').each(function () {
            $(this).attr('disabled', true);
        });

        var nomor_kuitansi = $("#NotadinaspptkT_nomor_kuitansi").val();
        var panelkuitansi = document.getElementById("panelkuitansi");
        var unitkerja = document.getElementById("unitkerja");
        var jabatan = document.getElementById("jabatan");
        if (nomor_kuitansi == '') {
            panelkuitansi.style.display = "none";
            unitkerja.style.display = "block";
            jabatan.style.display = "block";
        } else {
            panelkuitansi.style.display = "block";
            unitkerja.style.display = "none";
            jabatan.style.display = "none";
        }
    });
</script>