<hr/>
<div class="col-sm-6 satu-check">
    <div class="control-group">
        <label class="control-label">a. Inspeksi</label>        
    </div>
    <div class="control-group">
        <label class="control-label">- Statik</label>
        <div class="controls">
            <label>: Bentuk Dada</label>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_statik_bentukdada][]inspeksi_statik_bentukdada',array('checked'=>($model->inspeksi_statik_bentukdada == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_STATIK_DADA]['type'])+1){
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
        <label class="control-label">- Dinamis</label>
        <div class="controls">
            <label></label>
        </div>
    </div>
    
     <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_DINAMIS]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_dinamis][]inspeksi_dinamis',array('checked'=>($model->inspeksi_dinamis == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_INSPEKSI_DINAMIS]['type'])+1){
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
    
    
</div>

<div class="col-sm-6 satu-check">    
    <div class="control-group">
        <label class="control-label">b. Palpasi</label>
        <div class="controls">
            
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">- Ekspansi Thorax</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_palpasi_thorax][]palpasi_ekspansi_thorax',array('checked'=>($model->palpasi_ekspansi_thorax == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_THORAX]['type'])+1){
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
        <label class="control-label">- Spasme Otot</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_palpasi_spasme][]palpasi_spasme_otot',array('checked'=>($model->palpasi_spasme_otot == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_PALPASI_SPASME]['type'])+1){
                                echo "</tr>";
                            }else{
                                if ($i % 2 == 0){
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
</div>

<div class="clear"></div>
<hr/>
<div class="col-sm-12 satu-check">
    <div class="control-group">
        <label class="control-label">Pemeriksaan Khusus</label>
        <div class="controls">
            
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">a. Perkusi</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_khusus_perkusi][]khusus_perkusi',array('checked'=>($model->khusus_perkusi == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_PERKUSI]['type'])+1){
                                echo "</tr>";
                            }else{
                                if ($i % 2 == 0){
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
        <label class="control-label">b. Auskultasi</label>
        <div class="controls">
            
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">- Suara Nafas</label>
        <div class="controls">
            <table width="100%">
                <?php
                    $i = 1;
                    foreach($look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA]['type'] as $det){
                        if ($i ==0){
                            echo "<tr>";
                        }
                            echo "<td>".$form->checkBox($model,'[det_khusus_auskultasi_suara][]khusus_auskultasi_suaranafas',array('checked'=>($model->khusus_auskultasi_suaranafas == $det['value'])?true:false,'uncheckValue'=>null,'value'=>$det['value']))." <label>".$det['name']."&nbsp;&nbsp;&nbsp;</label></td>";
                        if ($i != 0){
                            if ($i == count($look[Params::LOOKUPTYPE_KARDIOPULMONAL_KHUSUS_AUSKULTASI_SUARA]['type'])+1){
                                echo "</tr>";
                            }else{
                                if ($i % 2 == 0){
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
        <label class="control-label">- Lokasi Sputum</label>
        <div class="controls">
            <?php echo $form->textField($model,'khusus_auskultasi_lokasisputum',array('class' => 'span4')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">c. Pengukuran Ekspansi Thorax</label>
        <div class="controls">
            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- Axilla</label>
        <div class="controls">
            <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_axilla',array('class' => 'span2 numbers-only')); ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- ICS 5</label>
        <div class="controls">
            <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_ics5',array('class' => 'span2 numbers-only')); ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">- Processus Xyphoideus</label>
        <div class="controls">
            <?php echo $form->textField($model,'khusus_pengukuran_eksthoraks_processus',array('class' => 'span2 numbers-only')); ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>
</div>
