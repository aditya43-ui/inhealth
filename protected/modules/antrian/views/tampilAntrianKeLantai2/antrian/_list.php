
<div class="box-antrian stretch" data-antrian-id="<?= !empty($model)?$model->antrian_id:'' ?>">
    <div class="header-no-antrian" style="<?= ($is_fasttrack)?'background-color:#de7b89':'' ?> ">NO. ANTRIAN</div>
    <div class="body-no-antrian">
        <div class="no-antrian">
            <?php 
            if(!empty($model)) {
                if($model->modelantrian_id == 1) {
                    echo $model->modelantrian_singkatan.'-'. str_pad($model->noantrian, 3, '0', STR_PAD_LEFT); 
                } else {
                    echo $model->ruangan_singkatan.'-'.str_pad($model->noantrian, 3, '0', STR_PAD_LEFT); 
                }
            } else {
                echo '';
            }
            ?>
        </div>
        <?php if ($is_fasttrack){ ?>
        <div class="kunjungan-fasttrack" style="color:#de7b89;font-size:1.1vw"><?= !empty($model)?$model->jenis_kunjungan:'' ?></div>
        <?php } ?>
        <div class="loket"><?= 'Loket '.(!empty($model)?$model->loket_singkatan:'1') ?></div>    
    </div>
</div>
