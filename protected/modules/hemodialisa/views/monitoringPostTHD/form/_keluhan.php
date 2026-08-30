<div class="control-group">
    <label class="control-label">Keluhan</label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_keluhan_sesaknafas', array()); ?> <label for="<?= CHtml::activeId($model, 'is_keluhan_sesaknafas') ?>">Sesak Nafas</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_keluhan_mualmuntah', array()); ?> <label for="<?= CHtml::activeId($model, 'is_keluhan_mualmuntah') ?>">Mual, Muntah</label>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'keluhan_utama_nyeri', array('onclick' => '
                if($(this).is(":checked")){
                    $("#nyeri").show();
                }else{
                    $("#nyeri").hide();
                }
            ','class'=>'cek_nyeri')); ?> <label for="<?= CHtml::activeId($model, 'keluhan_utama_nyeri') ?>">Nyeri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    </div>
    <div id="nyeri">
        <div class="hover">
            <div class="controls" style="border:1px solid #333;padding:5px;">
                <?php echo CHtml::image('images/icon_nyeri/6.png', 'alt', array('width' => '30px', 'onclick' => 'calldialogAsesmenNyeri();')); ?>
            </div>
        </div>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'asesmentnyeri_id', array('class' => 'span1', 'readonly' => true)); ?>
            <?php echo $form->textField($model, 'skornyeri', array('class' => 'span1', 'readonly' => true, 'placeholder' => 'Skor')); ?>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'keterangan_skriningnyeri', array('class' => 'span3', 'readonly' => true, 'placeholder' => 'Keterangan')); ?>
        </div>
        <div class="controls"><label>Lokasi Nyeri</label></div>
        <div class="controls">
            <?= $form->textField($model,'lokasi_nyeri') ?>
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo $form->checkBox($model, 'is_keluhan_keluhanlainnya', array('onclick' => '
                if($(this).is(":checked")){
                    $("#' . CHtml::activeId($model, 'keterangan_keluhanlainnya') . '").attr("readonly",false);
                }else{
                    $("#' . CHtml::activeId($model, 'keterangan_keluhanlainnya') . '").val("");
                    $("#' . CHtml::activeId($model, 'keterangan_keluhanlainnya') . '").attr("readonly",true);
                }
            ')); ?> <label for="<?= CHtml::activeId($model, 'is_keluhan_keluhanlainnya') ?>">Lainnya</label>
    </div>
    <div class="controls">
        <?php echo $form->textField($model, 'keterangan_keluhanlainnya', array('style' => 'width:289px', 'placeholder' => 'Jelaskan', 'readonly' => true)); ?>
    </div>
</div>
<?php
//========= Dialog Detail Asesmen Nyeri =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAsesmennyeri',
    'options' => array(
        'title' => 'Data Asesmen Nyeri',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1160,
        'height' => 600,
        'resizable' => false,
        'close' => 'js:function(){getDataAsesmenNyeri("");}',
    ),
));
?>
<iframe id="frameAsesmenNyeri" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();

$tanggal_lahir = new DateTime($model->pasien->tanggal_lahir);
$tanggal_daftar = new DateTime($model->pendaftaran->tgl_pendaftaran);
$y = $tanggal_daftar->diff($tanggal_lahir)->y;
if ($y < 3) {
    $skala = 'flacc';
} else {
    $skala = 'wbf';
}
?>
<script>
    /**
     * Load data asesmen nyeri
     * @type Arguments
     */
    function calldialogAsesmenNyeri() {
        $('#dialogAsesmennyeri').dialog('open');
        $('#frameAsesmenNyeri').attr('src', '<?php echo $this->createUrl('/hemodialisa/AsesmenNyeriHD/Index', array('pendaftaran_id' => $model->pendaftaran_id, 'skala' => $skala)); ?>');
    }

    /**
     * Get data asesmen nyeri
     * @param {type} ket
     * @returns {undefined}
     */
    function getDataAsesmenNyeri(ket) {
        var pendaftaran_id = <?php echo $model->pendaftaran_id ?>;

        $.ajax({
            url: '<?php echo $this->createUrl('/rawatInap/AsesmenAwalKeperawatan/GetDataAsesmenNyeri'); ?>',
            data: {pendaftaran_id: pendaftaran_id},
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.status == true && data.score_skalanyeri > 0) {
                    $("#<?php echo CHtml::activeId($model, 'skornyeri') ?>").val(data.score_skalanyeri);
                    $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val(data.keteranganskala_nyeri);
                    $("#<?php echo CHtml::activeId($model, 'asesmentnyeri_id') ?>").val(data.asesmentnyeri);
                    $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").attr('checked', true);
                    $("#nyeri").show();
                } else {
                    $('#<?php echo CHtml::activeId($model, 'skornyeri'); ?>').val('');
                    $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val('');
                    $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").removeAttr('checked');
                    $("#nyeri").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#<?php echo CHtml::activeId($model, 'skornyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'keterangan_skriningnyeri'); ?>').val('');
                $('#<?php echo CHtml::activeId($model, 'asesmentnyeri_id'); ?>').val('');
                $("#<?php echo CHtml::activeId($model, 'keluhan_utama_nyeri') ?>").removeAttr('checked');
                $("#nyeri").hide();
            },
            cache: false,
        });
    }
    
    $(document).ready(function(){
        <?php if ($model->keluhan_utama_nyeri){  ?>
            $("#nyeri").show();
        <?php }else{ ?>
            $("#nyeri").hide();
        <?php } ?>
    })
</script>