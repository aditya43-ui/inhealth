<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Komentar</label>
        <div class="controls" style="width:80%;">
            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'komentar','height'=>'200px', 'htmlOptions'=>array('class'=>'span1',), 'toolbar'=>'mini',)); ?>
        </div>
    </div>
</div>