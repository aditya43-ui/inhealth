<div class="redactor">
    <div class="col-sm-12 clear">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">P = PERENCANAAN</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'perencanaan', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 clear">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">I = INTRUKSI (DOKTER) &nbsp;&nbsp;&nbsp; I = INTERVENSI - IMPLEMENTASI (KEPERAWATAN/KETERAPIAN FISIK/TENAGA GIZI/APOTEKER)</div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'instruksi', 'toolbar'=>'mini','height'=>'100px')) ?>
            </div>
        </div>
    </div>
</div>