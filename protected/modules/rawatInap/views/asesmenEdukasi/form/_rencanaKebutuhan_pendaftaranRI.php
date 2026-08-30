<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Rencana Kebutuhan Edukasi
        </div>
    </div>
    <div class="panel-body">
        <p>&nbsp;</p>
        <div class="panel panel-darkk">
            <span class="group-title">
                    Topik Edukasi
            </span>
            <div class="panel-body" id="rencanaEdukasi"> 
                <div class="col-sm-12">
                
                <div id="kel-1" class="parent-data">
                    <div class="control-group">    
                        <label class="control-label">Admisi</label>                                
                        <div class="controls">
                           <?php echo $form->checkBox($model,'admisi_penjaminan',array('disabled'=>($model->admisi_penjaminan)?true:false)); ?> <label>Penjaminan</label>
                       </div>        
                        <div class="controls">
                           <?php echo $form->checkBox($model,'admisi_pemasangangelang',array('disabled'=>($model->admisi_pemasangangelang)?true:false)); ?> <label>Pemasangan Gelangan</label>
                       </div>  
                        <div class="controls">
                           <?php echo $form->checkBox($model,'admisi_biayapengobatan',array('disabled'=>($model->admisi_biayapengobatan)?true:false)); ?> <label>Biaya</label>
                       </div>
                   </div>
                </div>
                
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <?php
          echo $this->renderPartial($this->path_view.'form/_hasilEvaluasiVerifikasi', array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'form'=>$form,
            'getDet'=>$getDet
        ), true);
        ?>
</div>
</div>