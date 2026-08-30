<?php
$i = !empty($i)?$i:0;
$a = 0;
$cek = false;

if (!empty($load[trim($val['akses'])])){        
    $cek = true;
}
?>
<div class="control-group kelompok">
    <div class="col-sm-1" style="width:1%;padding:0px;">
        <?= CHtml::checkBox('hd_kateter',$cek,['value'=>$val['akses'],'uncheckValue'=>null,'class'=>'open-ket-dis','id'=>'a','onclick'=>'hapus_akses(this);']) ?>
    </div>        
    <div class="col-sm-2"><label for="a"><?= $val['akses'] ?></label></div>
    <div class="col-sm-9">
        <?php 
            foreach($val['det'] as $det){                
                $model = new AksesVaskularT;
                if (isset($load[trim($val['akses'])]['kateter'][$det])){
                    $init = $load[trim($val['akses'])]['kateter'][$det];
                    $model->attributes = $init->attributes;
                    $model->akses_vaskular_id = $init->akses_vaskular_id;
                }
                
                
                echo $this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/row/_row_vaskuler_more_2',['model'=>$model,
                    'val_prev'=>trim($val['akses']),
                    'val'=>$det,'i'=>$i,'a'=>$a], true) ;                
                $i++;
            }
        ?>
        
    </div>
</div>
<div class="clear" style="padding:1px"></div>