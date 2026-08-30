<?php
$akses = LookupM::getItemsUrutan('akses_vaskular');
$load = $model->set_akses_vaskular;
$align = !empty($align)?$align:'right';
$_vas = [];
foreach($akses as $key => $val){
    $pecah = explode(':', $key);
    $_vas[$pecah[0]]['akses'] = $pecah[0];    
    if (count($pecah) > 1)
        $_vas[$pecah[0]]['det'][$pecah[1]] = $pecah[1];
    
}

?>

<div class="control-group">        
    <div class="controls clear row-fluid" style="margin-left:0px;">
        <label class="control-label">Akses Vaskuler</label>        
        <div class="col-sm-10" style="padding:10px;">
            <?php
                $i = 0;
                foreach($_vas as $key => $val){                    
                    if (!empty($val['det'])){
                        $modVas = new AksesVaskularT;
                        $this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/row/_row_vaskuler_more',['model'=>$modVas,'val'=>$val, 'i'=>$i, 'load'=>$load]);
                    }else{
                        $modVas = new AksesVaskularT;                        
                        $this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/row/_row_vaskuler',['model'=>$modVas,'val'=>$val['akses'], 'i'=>$i,'load'=>$load]);
                    }
                    $i++;
                }
            ?>
        </div>
    </div>
</div>

<table id="akses-vaskular-hapus" class="hide">
    <tbody>
        
    </tbody>
</table>