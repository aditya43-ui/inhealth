<div class="col-sm-1">
</div>
<div class="col-sm-10">
    <div class="col-sm-12">
        <div class="control-group">
            <div class="input-group">
                <?= CHtml::textField('caripoli','',['placeholder'=>'pencarian','class'=>'form-control','id'=>'caripoli', 'onkeyup'=>'cariPolik(this);']) ?>
                <span class="input-group-addon btn-blue">Cari</span>
            </div>

        </div>

        <div class="control-group" style="overflow-y: scroll;height:400px;">
            <?php               
                echo $this->renderPartial("poliklinik/_listPolik",['model'=>$model], true);
            ?>
        </div>      
        
        <div class="form-actions">
            <div class="col-sm-6">
                <?= CHtml::button("Kembali",['onclick'=>"bukaTabPasien();", 'class'=>'btn btn-white']) ?>
            </div>      
        </div>
    </div>
</div>
<div class="col-sm-1">
</div>



<div class="clear"></div>
