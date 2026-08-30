<tr>
    <td style="text-align: center;">
        <label><?php echo $modDok->dokumenpendukungpengadaan_nama; ?></label>                
        <?php 
            echo CHtml::activeHiddenField($modDok,'[0]dokumenpendukungpengadaan_id',array('readonly' => true)); 
            echo CHtml::activeHiddenField($modDok,'[0]dokumenpendukungpengadaan_nama',array('readonly' => true)); 
            echo CHtml::activeHiddenField($modDok,'[0]dokumenpengadaan_id',array('readonly' => true)); 
        ?>               
    </td>
    <td style="text-align: left;">        

    <?php         
        echo CHtml::link('<u>'.$modDok->dokumenpendukungpengadaan_file.'</u>',$this->createUrl('UnduhDokDukungRUP',array('dokumenpendukungpengadaan_id'=>$modDok->dokumenpendukungpengadaan_id)),array('class'=>'','title'=>'Klik untuk download dokumen pendukung','rel'=>'tooltip'));
        echo CHtml::activeHiddenField($modDok, '[0]temp_file',array('readonly' => true));
        echo "<br/><label style='color:blue;'>".$modDok->temp_file.'</label>';
        echo "<div class='hide'>";
        echo CHtml::activeFileField($modDok,'[0]dokumenpendukungpengadaan_file',array( 'onchange'=>'cekFile(this);'));
        echo "</div>";                    
    ?>
    </td>
</tr>