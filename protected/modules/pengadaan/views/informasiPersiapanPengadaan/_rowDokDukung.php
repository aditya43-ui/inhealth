<tr>
    <td style="text-align: center;">
        <label><?php echo $modDok->dokumenpendukungpengadaan_nama.(!empty($jenis)?' ('.implode($jenis,",").')':'').((trim($required)=='required')?'<span class="required">*</span>':''); ?></label>                
        <?php 
            echo CHtml::activeHiddenField($modDok,'['.$i.']dokumenpendukungpengadaan_id',array('readonly' => true)); 
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
        $req2 = 'required';
        if (!empty($modDok->temp_file)) {
            $req2 = ''; 
        }
//        echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
//        echo CHtml::activeHiddenField($modDok, '['.$i.']temp_file',array('readonly' => true));
        echo CHtml::link($modDok->temp_file,$this->createUrl('UnduhDok',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file'));
//        echo "<div class='hide'>";
//        echo CHtml::activeFileField($modDok,'['.$i.']dokumenpendukungpengadaan_file',array( 'onchange'=>'cekFile(this);','accept'=>implode($tipe,','), 'class' => $req2));
//        echo "</div>";                    
    ?>
                <!--</span>
                <span class="fileinput-filename"></span>
                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
        </div>      -->          


    </td>
</tr>