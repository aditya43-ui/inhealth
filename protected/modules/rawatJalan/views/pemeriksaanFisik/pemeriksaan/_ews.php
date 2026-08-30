<div class="panel panel-success panel_cgsews" id="panel_ews" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($model, 'is_ews', array('class' => 'cek_ews', 'uncheckValue' => null)); ?> Early Warning System</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'pemeriksaan.ews._ews', array(
            'model' => $model,
            'form' => $form
        ), true); ?>
    </div>
</div>
<?php if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) : ?>
    <div class="panel panel-success panel_cgsews" id="panel_pews">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $form->checkBox($model, 'is_pews', array('class' => 'cek_ews', 'uncheckValue' => null)); ?> Pediatric Early Warning System</div>
        </div>
        <div class="panel-body">
            <?php echo $this->renderPartial($this->path_view . 'pemeriksaan.ews._pews', array(
                'model' => $model,
                'form' => $form
            ), true); ?>
        </div>
    </div>
<?php endif; ?>
<div class="panel panel-success panel_cgsews" id="panel_mews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($model, 'is_mews', array('class' => 'cek_ews', 'uncheckValue' => null)); ?> Maternity Early Warning System</div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'pemeriksaan.ews._mews', array(
            'model' => $model,
            'form' => $form
        ), true); ?>
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