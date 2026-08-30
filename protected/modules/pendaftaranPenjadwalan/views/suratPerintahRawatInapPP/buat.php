<div class="panel panel-gradient">    
    <div class="panel-heading">
        <div class="panel-title">Tambah Surat Perintah Rawat Inap SPRI</div>
    </div>
    <div class="panel-body form-horizontal" id="form-infopasien">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        
        <?= $this->renderPartial('form/_1_data_pasien',[
            'model'=>$modInfoKunjungan,
        ], true)  ?>
    </div>
    <div class="panel-body <?= isset($_GET['suratperintahranap_id'])?'':'hide'; ?>" id="form-surat">
        <?= $this->renderPartial($this->path_view.'index',[
            'model'=>$model,
            'modPendaftaran'=>$modPendaftaran,
        ], true);  ?>
    </div>
</div>

 <?= $this->renderPartial('_jsFunction',[
            'model'=>$modInfoKunjungan
        ], true)  ?>
 <?= $this->renderPartial('_dialog',[           
        ], true)  ?>