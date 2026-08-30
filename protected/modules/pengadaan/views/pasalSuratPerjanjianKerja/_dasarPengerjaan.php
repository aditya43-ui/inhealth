<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Dasar Pekerjaan </b></div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.redactorjs.Redactor',array(
            'model'=>$model, 
            'attribute'=>'dasarpengerjaan',
            'toolbar'=>'mini',
            'height'=>'200px', 
            'htmlOptions' => array('placeholder' => 'Ketikkan Catatan Atas Laporan Keuangan')
        )) ?>
    </div>
</div>