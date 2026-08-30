<tr row-pengadaan="<?php echo $modDok->dokumenpengadaan_id; ?>">
    <td style="text-align: center;" class="label_dokumen">
        <label class="label_dok"><?php echo $modDok->dokumenpendukungpengadaan_nama.(!empty($jenis)?' ('.implode($jenis,",").')':'').((trim($required)=='required')?'<span class="required label_required">*</span>':'<span class="required label_required"></span>'); ?></label>                
        <?php 
            echo CHtml::activeHiddenField($modDok,'['.$modDok->dokumenpengadaan_id.']dokumenpengadaan_id',array('readonly' => true, 'class' => 'dokumenpengadaan_id'));             
            echo CHtml::activeHiddenField($modDok,'['.$modDok->dokumenpengadaan_id.']dokumenpendukungpengadaan_nama',array('readonly' => true)); 
        ?>               
    </td>
    <td style="text-align: left;">               

    <?php         
        $a = 0;        
        foreach($det as $d){
            $modDok->temp_file = $d['file'];            
            $modDok->dokumenpendukungpengadaan_file = $d['file'];
            $modDok->dokumenpendukungpengadaan_id = $d['id'];            
            $req2 = $required;
            $namafile = $modDok->temp_file;
            $pecah = explode(".",$modDok->temp_file);
            if (!empty($modDok->temp_file)){
                $namafile = $pecah[0].'-'.($a+1).'.'.$pecah[1];
            }
            
            if (!empty($modDok->temp_file)) {
                $req2 = ''; 
            }
            
            if ($a == 0){
                echo "<div class='load-gambar'>";
                echo CHtml::activeHiddenField($modDok,'['.$modDok->dokumenpengadaan_id.']dokumenpendukungpengadaan_id',array('readonly' => true, 'value' => $modDok->dokumenpendukungpengadaan_id, 'class'=>'dokumenpendukungpengadaan_id','row-file'=>$a)); 
                echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                echo CHtml::activeHiddenField($modDok, '['.$modDok->dokumenpengadaan_id.']temp_file',array('readonly' => true, 'class' => 'temp_file' ));
                echo "<br/>".CHtml::link("<u>".$namafile."</u>",$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
                echo "<div class='hide'>";
                echo CHtml::activeFileField($modDok,'['.$modDok->dokumenpengadaan_id.']dokumenpendukungpengadaan_file',array('onchange'=>'cekFile(this);','accept'=>implode($tipe,','), 'class' => "dokumenpendukungpengadaan_file ".$req2));
                echo "</div>";                  
                echo "</div>";                
            }else{
                echo CHtml::activeTextField($modDok,'['.$modDok->dokumenpengadaan_id.']dokumenpendukungpengadaan_id',array('readonly' => true, 'class'=>'dokumenpendukungpengadaan_id','row-file'=>$a)); 
                echo CHtml::activeTextField($modDok, '['.$modDok->dokumenpengadaan_id.']temp_file',array('readonly' => true, 'class' => 'temp_file'));
                echo CHtml::activeTextField($modDok, '['.$modDok->dokumenpengadaan_id.']dokumenpendukungpengadaan_file',array('readonly' => true));
                echo "<br/>".CHtml::link("<u>".$namafile."</u>",$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
            }
            $a++;
        }
    ?>
    </td>
</tr>