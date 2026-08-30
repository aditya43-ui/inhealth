

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Faktor Predisposisi</div>
    </div>
    <div class="panel-body">
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Biologik
            </span>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."form.predisposisi.biologik._biologik", array(
                    'form'=>$form, 'model'=>$model,
                )); ?>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Psikososial
            </span>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."form.predisposisi.psikososial._pengalamanMasaLalu", array(
                    'form'=>$form, 'model'=>$model, 'det'=>$diag_jiwa_det,
                )); ?>
                <br/>
                <br/>
                <?php echo $this->renderPartial($this->path_view."form.predisposisi.psikososial._riwayatPenganiayaan", array(
                    'form'=>$form, 'model'=>$model, 'det'=>$diag_jiwa_det,
                )); ?>
                <br/>
                <br/>
                <?php echo $this->renderPartial($this->path_view."form.predisposisi.psikososial._genogram", array(
                    'form'=>$form, 'model'=>$model, 'det'=>$diag_jiwa_det,
                )); ?>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Pengambilan Keputusan
            </span>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'pengambilankeputusan', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Pola Komunikasi
            </span>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'polakomunikasi', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
        <br/>
    </div>
</div>