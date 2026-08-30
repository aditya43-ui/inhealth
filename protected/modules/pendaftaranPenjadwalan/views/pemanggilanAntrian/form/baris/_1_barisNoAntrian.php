<!-- <div class="list-no-antrian" style="text-align: center;width:15%;"> -->
<div class="list-no-antrian" style="text-align: center;width:57%; margin-top:5px">
    <?php /*
    <div class="tampil-noantrian">
        <div class="no-antrian"><?= !empty($model)?$model->ruangan_singkatan.'-'.$model->noantrian:'xx-000' ?></div>
    </div>
     * 
     */ ?>
    <div class="box-antrian stretch" >
        <div class="header-no-antrian">NO. ANTRIAN</div>
        <div class="body-no-antrian">
            <div class="no-antrian"><?= !empty($model)?$model->modelantrian->modelantrian_singkatan.'-'.$model->noantrian:'XXX-000'; ?></div>            
            <div class="loket"><?= 'Loket '.(!empty($model)?$model->loket->loket_singkatan:'1') ?></div>    
        </div>
    </div>
</div>