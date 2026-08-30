<label>b. Riwayat Penganiayaan</label>

<?php echo $this->renderPartial($this->path_view.'form.predisposisi.psikososial._tabAniaya', array(
    'form'=>$form, 'model'=>$model, 'jenisaniaya'=>'aniaya_fisik', 'jenisaniaya_attr'=>'isriwayataniaya_fisik', 'jenisaniaya_label'=>'Aniaya Fisik',
)); ?>
<?php echo $this->renderPartial($this->path_view.'form.predisposisi.psikososial._tabAniaya', array(
    'form'=>$form, 'model'=>$model, 'jenisaniaya'=>'aniaya_seksual', 'jenisaniaya_attr'=>'isriwayataniaya_seksual', 'jenisaniaya_label'=>'Aniaya Seksual',
)); ?>
<?php echo $this->renderPartial($this->path_view.'form.predisposisi.psikososial._tabAniaya', array(
    'form'=>$form, 'model'=>$model, 'jenisaniaya'=>'aniaya_penolakan', 'jenisaniaya_attr'=>'isriwayataniaya_penolakan', 'jenisaniaya_label'=>'Penolakan',
)); ?>
<?php echo $this->renderPartial($this->path_view.'form.predisposisi.psikososial._tabAniaya', array(
    'form'=>$form, 'model'=>$model, 'jenisaniaya'=>'aniaya_kekerasandlmkeluarga', 'jenisaniaya_attr'=>'isriwayataniaya_kekerasandlmkeluarga', 'jenisaniaya_label'=>'Kekerasan dalam Keluarga',
)); ?>
<?php echo $this->renderPartial($this->path_view.'form.predisposisi.psikososial._tabAniaya', array(
    'form'=>$form, 'model'=>$model, 'jenisaniaya'=>'aniaya_tindakkriminal', 'jenisaniaya_attr'=>'isriwayataniaya_tindakkriminal', 'jenisaniaya_label'=>'Tindak Kriminal',
)); ?>


<div class="control-group">
    <?php echo $form->labelEx($model, 'riwayataniaya_penjelasan', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'riwayataniaya_penjelasan', 'toolbar' => 'mini', 'height' => '100px')) ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <div id="panel_diagnosa_aniaya">
            <?php
            echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][riwayatpenganiayaan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                        'isaktif' => true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'riwayatpenganiayaan',
                        ), array('order' => 'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null));
            ?>
        </div>
        <?php
        echo CHtml::htmlButton('+ Tambah Diagnosa', array(
            'class' => 'btn btn-success', 'onclick' => "dialogTambahDiagnosa('panel_diagnosa_aniaya', 'diagnosa_gangguan', 'riwayatpenganiayaan');"
        ));
        ?>
    </div>
</div>

<script>
    
    var cnt_tab_aniaya = 0;
    
    function tambahRowRiwayatAniaya(obj) {
        var jenisaniaya = $(obj).parents(".panel_aniaya").data('jenis');
        
        $.post('<?php echo $this->createUrl('tambahDataRiwayatAniaya'); ?>', {
            'jenisaniaya': jenisaniaya,
            'idx': cnt_tab_aniaya
        }, function(data) {
            if (data.ok == 1) {
                $(obj).parents('.tab_aniaya').find('tbody').append(data.html);
                cnt_tab_aniaya++;
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }
    
    function hapusItemRiwayatAniaya(obj) {
        $(obj).parents("tr").remove();
    }
    
    function setCeklisRiwayatAniaya() {
        $(".panel_aniaya").each(function() {
            if ($(this).find(".ceklis_aniaya").is(":checked")) {
                $(this).find(".tab_aniaya :input").attr("disabled", false);
            } else {
                $(this).find(".tab_aniaya :input").attr("disabled", true);
                $(this).find(".tab_aniaya tbody").empty();
            }
        });
    }
    
    $(document).ready(function() {
        $(".panel_aniaya .ceklis_aniaya").on("click", setCeklisRiwayatAniaya);
        setCeklisRiwayatAniaya();
    });
    
</script>