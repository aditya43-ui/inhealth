<hr/>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">a. Inspeksi</label>        
    </div>
    <div class="control-group">
        <label class="control-label">- Statik</label>
        <div class="controls">
            <?php echo $form->dropDownList($model,'inspeksi_statik', LookupM::getItems('neuromuskular_inspeksi_statik'),array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <label>di &nbsp;&nbsp;</label><?php echo $form->textField($model,'inspeksi_statik_di',array('class' => 'span3')); ?>
        </div>
    </div>
          
    <div class="control-group">
        <label class="control-label">b. Palpasi</label>
        <div class="controls">
            <?php echo $form->dropDownList($model,'palpasi', LookupM::getItems('neuromuskular_inspeksi_palpasi'),array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <label>di &nbsp;&nbsp;&nbsp;</label><?php echo $form->textField($model,'palpasi_di', array('class' => 'span3')); ?>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">- Dinamis</label>
        <div class="controls">
            <label>Adanya perubahan dalam</label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->dropDownList($model,'inspeksi_dinamis', LookupM::getItems('neuromuskular_inspeksi_dinamis'),array('empty' => '-- Pilih --','onchange'=>'cekPolaLain(this);')); ?>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->textField($model,'inspeksi_dinamis_polalain',array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>    
</div>

<div class="clear"></div>
<hr/>
<div class="col-sm-12" id="satu-check">
    <div class="control-group">
        <label class="control-label">a. Reflek Patologi</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_NEUROMUSKULAR_REFLEK_PATOLOGIS]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_patologis][]reflek_patologis',array('checked'=>($model->reflek_patologis == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_NEUROMUSKULAR_REFLEK_PATOLOGIS]['type'])+1){
                                echo "</tr>";
                            }else{
                                if ($i % 4 == 0){
                                    echo "</tr><tr>";
                                }
                            }
                        }
                        $i++;
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">b. Tes Sensoris</label>       
    </div>
    <div class="control-group">
        <label class="control-label">- Nyeri Superficial</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_superfisial][]tes_sensoris_nyeri_superfisial',array('checked'=>($model->tes_sensoris_nyeri_superfisial == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- Sentuhan Ringan</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_sentuhanringan][]tes_sensoris_sentuhan_ringan',array('checked'=>($model->tes_sensoris_sentuhan_ringan == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- Tekanan</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_tekanan][]tes_sensoris_tekanan',array('checked'=>($model->tes_sensoris_tekanan == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- Proprioseptif</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SENSORIS]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_proprioseptif][]tes_proprioseptif',array('checked'=>($model->tes_proprioseptif == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">c. Tes Tremor</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_TREMOR]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_tremor][]tes_tremor',array('checked'=>($model->tes_tremor == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">d. Tes Spastisitas</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <td><label>: Skala Asworth</label></td>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TES_SPASTISITAS]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_skalaasworth][]tes_spastisitas_skala_asworth',array('checked'=>($model->tes_spastisitas_skala_asworth == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">e. Tonus Otot</label>       
        <div class="controls">
            <table width="100%">
                <tr>
                    <?php
                        foreach ($look[Params::LOOKUPTYPE_NEUROMUSKULAR_TONUS_OTOT]['type'] as $det){
                            echo "<td>".$form->checkBox($model,'[det_tonus][]tonus_otot',array('checked'=>($model->tonus_otot == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        }
                    ?>
                </tr>
            </table>
        </div>
    </div>
</div>
