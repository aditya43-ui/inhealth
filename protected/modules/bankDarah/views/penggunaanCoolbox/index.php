<?php Yii::app()->clientScript->registerScriptFile('js/dropdownMulti.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style>        
    .control-label{
        text-align:right !important;
        vertical-align: top !important;
    }        
    .form-horizontal .control-label{
        width: 150px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Transaksi <b>Penggunaan Coolbox</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penggunaancoolbox-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));

        echo $this->renderPartial($this->path_view . 'form/_formPenggunaan', array('model' => $model, 'form' => $form), true);

        echo $this->renderPartial($this->path_view . 'form/_formMonitoring', array('model' => $model, 'form' => $form), true);

        $this->endWidget();
        ?>
    </div>
</div>
<script>

    function cekForm() {
        var jam_monitoring = $("#<?php echo CHtml::activeId($model, 'jam_monitoring') ?>").val();
        if (jam_monitoring == "") {
            myAlert("Jam Monitoring Belum Diinputkan");
            return false;
        } else {

            var coolboxdarah_id = $("#<?php echo CHtml::activeId($model, 'coolboxdarah_id') ?>").val();
            var tgl_penggunaan_coolbox = $("#<?php echo CHtml::activeId($model, 'tgl_penggunaan_coolbox') ?>").val();

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('cekForm'); ?>',
                data: {coolboxdarah_id: coolboxdarah_id, tgl_penggunaan_coolbox: tgl_penggunaan_coolbox},
                dataType: "json",
                success: function (data) {
                    if (data.status == true) {
                        myAlert('Jenis Coolbox telah dipilih');
                    } else {
                        cekSimpan();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function cekData() {
        var coolboxdarah_id = $("#<?php echo CHtml::activeId($model, 'coolboxdarah_id') ?>").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekData'); ?>',
            data: {coolboxdarah_id: coolboxdarah_id},
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($model, 'ukuran_coolbox') ?>").val(data.coolbox_ukuran);
                $("#<?php echo CHtml::activeId($model, 'jenis_kantong') ?>").val(data.jenis_kantong);
                $("#<?php echo CHtml::activeId($model, 'standar_suhu') ?>").val(data.standart_suhu);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function () {
        dropMulti('<?php echo CHtml::activeId($model, 'ruangan_id') ?>', {
            buttonWidth: '180px',
        });
<?php if (!empty($_GET['id'])) { ?>
            cekData();
<?php } ?>
    });
</script>