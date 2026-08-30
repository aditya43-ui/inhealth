<tr>
    <td style="text-align: center;">
        <label><?php echo $modDok->jenis_dokumen.(!empty($jenis)?' ('.implode($jenis,",").')':'').((trim($required)=='required')?'<span class="required">*</span>':''); ?></label>                
        <?php 
            echo CHtml::activeHiddenField($modDok,'['.$i.']dokumenpengadaan_id',array('readonly' => true)); 
            echo CHtml::activeHiddenField($modDok,'['.$i.']jenis_dokumen',array('readonly' => true)); 
            echo CHtml::activeHiddenField($modDok,'['.$i.']penyedia_id',array('readonly' => true)); 
        ?>               
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modDok,'['.$i.']nomor_dokumen',array('readonly' => false, 'class' => 'span3 '.((trim($required)=='required')?'required':'')));
        ?>
    </td>
    <td style="text-align: left;">               

    <?php         
        echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary '.((trim($required)=='required')?'required':''))).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse '.((trim($required)=='required')?'required':'')));
        echo CHtml::activeHiddenField($modDok, '['.$i.']pengadaandokumenpenyedia_file',array('readonly' => true));
        echo "<br/>".CHtml::link("<u>".$modDok->pengadaandokumenpenyedia_file."</u>",$this->createUrl('UnduhDok',array('pengadaandokumenpenyedia_id'=>$modDok->pengadaandokumenpenyedia_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
        echo "<div class='hide'>";
        echo CHtml::activeFileField($modDok,'['.$i.']pengadaandokumenpenyedia_file',array( 'onchange'=>'cekFile(this);','accept'=>implode($tipe,','), 'class' => $required));
        echo "</div>";                    
    ?>
    </td>
</tr>