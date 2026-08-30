
<div class="col-sm-1">
</div>
<div class="col-sm-3" style="text-align:center;">
    <div class="panel panel-success">
        <div class="panel-body" style="padding:0px;">
            <?php
                $img = Yii::app()->getBaseUrl('webroot').'/images/Avatar.png';
                if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai) && !empty($val->photopegawai)){
                    $img = Params::urlPegawaiTumbsDirectory(). 'kecil_' . $model->photopegawai;
                }

                echo CHtml::image($img,$model->namaLengkap,['width'=>'80%',]);
            ?>
        </div>
    </div>    
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-body" style="padding:0px;padding-left:10px;">
            <h2><?= $model->namaLengkap ?></h2>
            <?= 'Poliklinik : '.$model->ruangan_nama ?>
            <br/>
            <br/>
            <h3>Jam Pratek & Kuota</h3>
            <div class="col-sm-12" style="padding:0px;">
            <?php
                $jumlah = count($jadwal)-1;
                $bagi = round($jumlah/2)-1;
                foreach($jadwal as $key => $val){
                    if ($key == 0){
                        echo '<div class="col-sm-6" style="padding:0px;">';
                    }
                    
                    $opa = 1;
                    if ($val->maximumantrian < 1){
                        $opa = 0.5;
                    }
                    
                    echo '<div class="control-group" style="opacity:'.$opa.'">';
                    echo $val->jadwaldokter_buka.' sisa '.$val->maximumantrian;
                    echo '</div>';
                    
                    if ($jumlah == $key){
                        echo '</div>';
                    }else{
                        if ($bagi == $key){
                            echo '</div>';
                            echo '<div class="col-sm-6">';
                        }
                    }
                }
            ?>
            </div>
        </div>
    </div>   
    <div class='clear'></div>
    <div class="form-actions">
        <div class="col-sm-6">
            <?= CHtml::button("Kembali",['onclick'=>"bukaTabDokter();", 'class'=>'btn btn-white']) ?>
        </div>      
        
        <div class="col-sm-6 lanjut-position" style="text-align:right;">
            <?= CHtml::button("Lanjut",['onclick'=>"loadVerifikasi();", 'class'=>'btn btn-success btn-lanjut']) ?>
        </div> 
    </div>
</div>
<div class="col-sm-2">
</div>
</div>
<div class="clear"></div>
