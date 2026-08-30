<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($model, 'pemeriksaanmata', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
            <i class="glyphicon glyphicon-file"></i> <b>Pemeriksaan Mata</b>
        </div>
        
        <div class="panel-title dbnstyle">
            <span><?php echo CHtml::checkBox("DbnMata", '', array('onchange' => 'dbnMata()')) . ' <label>DBN (Dalam Batas Normal)</label>' ?></span>
        </div>
    </div>
    
    <div class="panel-body">
        <div class="control-group">
            <?= $form->labelEx($model, 'mata_kanan', ['class' => 'control-label']) ?>
            <div class="controls">
                <?= $form->textField($model, 'mata_kanan', ['class' => 'span4']) ?>
            </div>
            <label class="controls">dengan/tanpa koreksi</label>
        </div>
        <div class="control-group">
            <?= $form->labelEx($model, 'mata_kiri', ['class' => 'control-label']) ?>
            <div class="controls">
                <?= $form->textField($model, 'mata_kiri', ['class' => 'span4']) ?>
            </div>
            <label class="controls">dengan/tanpa koreksi</label>
        </div>
        <?= $form->textFieldRow($model, 'segmen_anterior', ['class' => 'span4']) ?>
        <?= $form->textFieldRow($model, 'segmen_posterior', ['class' => 'span4']) ?>
        <?= $form->textFieldRow($model, 'warna', ['class' => 'span4']) ?>
        <?= $form->textFieldRow($model, 'resume', ['class' => 'span4']) ?>
    </div>
</div>


<script>
    function ceklisCGSEWS() {
        $(".cek_ews").each(function() {
            $(this).parents(".panel_cgsews")
                .find(".panel-body").hide()
                .find(":input").prop("disabled", true);
            if ($(this).is(":checked")) {
                $(this).parents(".panel_cgsews")
                    .find(".panel-body").show()
                    .find(":input").prop("disabled", false);

            }
        });
    }

    $(document).ready(function() {
        $(".cek_ews").on("click", ceklisCGSEWS);
        ceklisCGSEWS();
    });
</script>