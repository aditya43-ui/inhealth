<?php
    $i = 0;
    $a = 0;
    $id = Params::MONITOR_INTRAANESTESI_INPUT_OBAT;
    $val = ucwords(strtolower($id));
    $model->jenis_input = $id;    

    if (isset($loadInput[$id]['det']['']['det'])){
        $c = 0;
        foreach($loadInput[$id]['det']['']['det'] as $det){
            $model->nama_input = $det['nama_input'];
            echo $this->renderPartial($this->path_view.'form/_rowJenis',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$a, 'count' =>$c));
            $a++;
            $c++;
        }
    }else{
        echo $this->renderPartial($this->path_view.'form/_rowJenis',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$i, 'count' =>0));
    }

?>
<hr/>
<div class="control-group">
    <label class="control-label"><b>Cairan Masuk</b></label>
    <div class="controls">
        
    </div>
</div>
<?php
    $output = LookupM::getItemsUrutan('monitorintraanestesi_incairanmasuk');
    
    if (!empty($output)){        
        
        foreach($output as $key => $val){
            $model->jenis_input = $key;            
            $id = str_replace(" ","_",strtolower($val));
            if ($model->jenis_input == Params::MONITOR_INTRAANESTESI_INCAIRANMASUK_DARAH){
?>
        <!--<div id="<?php echo $id; ?>" class="parent">
                <div class="control-group lookup">
                    <label class="control-label"><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <div class="controls">
                    </div>                        
                </div>
            

                <?php
                    /*$cri = new CDbCriteria();
                    $cri->group = " singkatan_komp ";
                    $cri->select = $cri->group;
                    $cri->addCondition(" komponendarah_aktif = TRUE ");
                    $komDarah = KomponendarahM::model()->findAll($cri);
                    
                    if (!empty($komDarah)){
                        $j = 0;
                        foreach ($komDarah as $kom){                            
                            $id = str_replace(" ","_",strtolower($kom->singkatan_komp));
                            
                            if (isset($loadInput[$key]['det'][$kom->singkatan_komp]['det'])){
                                $c = 0;
                                foreach($loadInput[$key]['det'][$kom->singkatan_komp]['det'] as $det){
                                    $model->nama_input = $det['nama_input'];
                                    $model->sub_jenis_input = $loadInput[$key]['det'][$kom->singkatan_komp]['sub_jenis'];
                                    $model->ukuran = $det['ukuran'];
                                    
                                    echo $this->renderPartial($this->path_view.'form/_rowKomDarah',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$i,'j'=>$j,'kom'=>$kom,'count'=>$c));    
                                    $a++;
                                    $c++;
                                }
                            }else{                            
                                echo $this->renderPartial($this->path_view.'form/_rowKomDarah',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$i,'j'=>$j,'kom'=>$kom,'count'=>0));    
                            }
                        $j++;
                        }
                    }*/
                ?>
        </div>-->
        <?php 
             echo $this->renderPartial($this->path_view.'form/_rowDarah',array('model' => $model,'val'=>$val,'id'=>$id,'count'=>0));    
        ?>
<?php
            }else{                  
                if (isset($loadInput[$key]['det']['']['det'])){
                    $c = 0;
                    foreach($loadInput[$key]['det']['']['det'] as $det){
                        $model->nama_input = $det['nama_input'];
                        echo $this->renderPartial($this->path_view.'form/_rowJenis',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$a, 'count' =>$c));
                        $a++;
                        $c++;
                    }
                }else{
                    echo $this->renderPartial($this->path_view.'form/_rowJenis',array('model' => $model,'val'=>$val,'id'=>$id,'i'=>$i, 'count' =>0));
                }
            }
        $i++;
        }
    }
?>