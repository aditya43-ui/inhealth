
<?php
    if (!empty($model)){
        foreach($model as $key =>$val){
            echo '<div class="col-md-4" onclick="pilihPoli('.$val->ruangan_id.', this)" ruangan="'.strtolower($val->ruangan_nama).'">';
            echo '<button  class="btn-success btn-ruangan col-md-11" style="margin:10px;padding:20px;height:7em" >';
            echo '<p style="text-align:center;font-size:1.4em;"><b>'.$val->ruangan_nama.'</b></p>';
            echo '</button>';
            echo '</div>';
        }
    }else{
        echo '<span class="required">Poliklinik tidak ditemukan pada jadwal hari ini</span>';
    }
?>