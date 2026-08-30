<tr>
    <td style="text-align: center;">
        <label><?php echo $modDok->jenis_dokumen.(!empty($jenis)?' ('.implode($jenis,",").')':'').((trim($required)=='required')?'<span class="required">*</span>':''); ?></label>                
        <?php 
            echo CHtml::activeHiddenField($modDok,'['.$i.']pengadaandokumenpenyedia_id',array('readonly' => false, 'class' => 'span1'))."<br>";
            echo CHtml::activeHiddenField($modDok,'['.$i.']dokumenpengadaan_id',array('readonly' => true))."<br>";
            echo CHtml::activeHiddenField($modDok,'['.$i.']jenis_dokumen',array('readonly' => true))."<br>";
            echo CHtml::activeHiddenField($modDok,'['.$i.']supplier_id',array('readonly' => true))."<br>";
        ?>               
    </td>
    <td>
        <?php 
            echo CHtml::activeTextField($modDok,'['.$i.']nomor_dokumen',array('readonly' => false, 'class' => 'span3 '.((trim($required)=='required')?'required':'')));
        ?>
    </td>
    <td style="text-align: left;">               

        <?php         
        echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
        echo CHtml::activeHiddenField($modDok, '['.$i.']temp_file',array('readonly' => true));
        echo "<br/>".CHtml::link("<u>".$modDok->temp_file."</u>",$this->createUrl('UnduhDok',array('pengadaandokumenpenyedia_id'=>$modDok->pengadaandokumenpenyedia_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;'));
        echo "<div class='hide'>";
        echo CHtml::activeFileField($modDok,'['.$i.']pengadaandokumenpenyedia_file',array( 'onchange'=>'cekFile(this);','accept'=>implode($tipe,',')));
        echo "</div>";                    
    ?>
    </td>
</tr>