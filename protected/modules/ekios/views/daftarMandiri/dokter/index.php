<div class="col-sm-12">
    
    <div class="control-group" style="overflow-y: scroll;height:400px;">
<?php       
    if (!empty($model)){
        foreach($model as $key =>$val){
            
            $img = Yii::app()->getBaseUrl('webroot').'/images/Avatar.png';
            if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $val->photopegawai) && !empty($val->photopegawai)){
                $img = Params::urlPegawaiTumbsDirectory(). 'kecil_' . $val->photopegawai;
            }
            
            echo '<div class="col-md-3 main-dokter" style="text-align:center;margin-bottom:20px;">';
            echo '<div class="panel panel-success">';
            echo '<div class="panel-body" style="padding:0px !important;">';
            echo CHtml::image($img,$val->namaLengkap,['width'=>'80%', 'class'=>'hover', 'onclick'=>'pilihDokter('.$val->pegawai_id.')']);            
            echo '<button onclick="pilihDokter('.$val->pegawai_id.')" class="col-sm-12 btn-success btn-dokter" style="padding:20px;height:7em" dokter="'.strtolower($val->namaLengkap).'">';           
            echo '<p style="text-align:center;font-size:1.4em;"><b>'.$val->namaLengkap.'</b></p>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo '<span class="required">Poliklinik tidak ditemukan pada jadwal hari ini</span>';
    }
?>
    </div>
    <div class="form-actions">
        <div class="col-sm-6">
            <?= CHtml::button("Kembali",['onclick'=>"bukaTabPolik();", 'class'=>'btn btn-white']) ?>
        </div>      
    </div>
</div>
<div class="clear"></div>