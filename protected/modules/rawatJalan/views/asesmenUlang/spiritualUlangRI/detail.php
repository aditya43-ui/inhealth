
<div class="panel  panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Detail CPIS Pasien</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
                'CPIS Pasien'
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php                 
        echo $this->renderPartial('_form',array(
            'model'=>$model,
            'modDet'=>$modDet,
        )); ?>
    </div>
</div>
<?= $this->renderPartial('_jsFunction',['model'=>$model], true) ?>

<script type="text/javascript">
    (function () {
        $(".dis-form").find("input:not(.open-field), select, textarea:not(.open-field)").attr("disabled", true);
        $(".dis-form").find(".add-on, .dis-btn").hide();
    })();
</script>


