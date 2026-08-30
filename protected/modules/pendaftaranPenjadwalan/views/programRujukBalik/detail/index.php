<style>
    .controls{
        padding-top:7px !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Detail Program Rujuk Balik</b></div>
    </div>
    <div class="panel-body form-horizontal">
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Pasien</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('detail/form/_1_pasien_sep', array('model' => $model)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data PRB</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('detail/form/_2_program_rujuk_balik', array('model' => $model)); ?>
                <?php $this->renderPartial('detail/form/_3_obat_program_rujuk_balik', array('model' => $modObat)); ?>
            </div>
        </div>
                      
         

        <div class="form-actions">
            <?= $this->renderPartial('detail/_button',['model'=>$model]); ?>
        </div>
       
    </div>
</div>
