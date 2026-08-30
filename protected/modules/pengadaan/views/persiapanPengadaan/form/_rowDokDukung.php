<tr rowdata="<?php echo $i; ?>">
    <td style="text-align: center;">
        <label><?php echo $modDok->dokumenpendukungpengadaan_nama.(!empty($jenis)?' ('.implode($jenis,",").')':'').((trim($required)=='required')?'<span class="required">*</span>':''); ?></label>                
        <?php             
            echo CHtml::activeHiddenField($modDok,'['.$i.']dokumenpendukungpengadaan_nama',array('readonly' => true)); 
            echo CHtml::activeHiddenField($modDok,'['.$i.']dokumenpengadaan_id',array('readonly' => true)); 
        ?>               
    </td>
    <td style="text-align: left;">               
        <!--<div class="fileinput fileinput-new" data-provides="fileinput"><input type="hidden">
                <span class="btn btn-primary btn-file">
                        <span class="fileinput-new">Browse...</span>
                        <span class="fileinput-exists">Ubah</span>-->

    <?php
        $a = 0;        
        foreach($det as $d){
            $modDok->temp_file = $d['file'];
            $modDok->dokumenpendukungpengadaan_file = $d['file'];
            $modDok->dokumenpendukungpengadaan_id = $d['id'];            
            $req2 = 'required';
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
                echo CHtml::activeHiddenField($modDok,'['.$i.'][det]['.$a.']dokumenpendukungpengadaan_id',array('readonly' => true, 'class'=>'dokumenpendukungpengadaan_id','row-file'=>$a)); 
                echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                echo CHtml::activeHiddenField($modDok, '['.$i.'][det]['.$a.']temp_file',array('readonly' => true));
                echo "<br/>".CHtml::link("<u>".$namafile."</u>",$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
                echo "<div class='hide'>";
                echo CHtml::activeFileField($modDok,'['.$i.'][det]['.$a.']dokumenpendukungpengadaan_file',array('onchange'=>'cekFile(this);','accept'=>implode($tipe,','), 'class' => $required));
                echo "</div>";                  
                echo "</div>";                
            }else{
                echo CHtml::activeHiddenField($modDok,'['.$i.'][det]['.$a.']dokumenpendukungpengadaan_id',array('readonly' => true, 'class'=>'dokumenpendukungpengadaan_id','row-file'=>$a)); 
                echo CHtml::activeHiddenField($modDok, '['.$i.'][det]['.$a.']temp_file',array('readonly' => true));
                echo CHtml::activeHiddenField($modDok, '['.$i.'][det]['.$a.']dokumenpendukungpengadaan_file',array('readonly' => true));
                echo "<br/>".CHtml::link("<u>".$namafile."</u>",$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
            }
            $a++;
        }
        
        
    ?>
                <!--</span>
                <span class="fileinput-filename"></span>
                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
        </div>      -->          


    </td>
</tr>