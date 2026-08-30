<div class="panel panel-gradient">    
    <div class="panel-heading">
        <div class="panel-title">Surat Rencana Kontrol</div>
    </div>
    <div class="panel-body form-horizontal" id="form-infopasien">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        <?= $this->renderPartial($this->pathView.'form/_1_data_pasien',[
            'model'=>$model,
        ], true)  ?>
    </div>    
</div>

 <?= $this->renderPartial($this->pathView.'_jsFunction',[
            'model'=>$model
        ], true)  ?>
 <?= $this->renderPartial($this->pathView.'_dialog',[           
        ], true)  ?>