<div class="clear"></div>
<br/>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglasesmentriase', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglasesmentriase',
                'value' => null,
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 htpd tglext',
                ),
            ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kategori<span class="required">*</span></label>
        <div class="controls">
            <?= $form->checkBox($model, 'kategori_i', ['id'=>'kategori_i']) ?> <label for="kategori_i">I</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kategori_ii', ['id'=>'kategori_ii']) ?> <label for="kategori_ii">II</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kategori_iii', ['id'=>'kategori_iii']) ?> <label for="kategori_iii">III</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kategori_iv', ['id'=>'kategori_iv']) ?> <label for="kategori_iv">IV</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kategori_v', ['id'=>'kategori_v']) ?> <label for="kategori_v">V</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Cara Datang<span class="required">*</span></label>
        <div class="controls">
            <?= $form->checkBox($model, 'caradatang_sendiri', ['id'=>'caradatang_sendiri']) ?> <label for="caradatang_sendiri">Sendiri</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'caradatang_ambulance', ['id'=>'caradatang_ambulance']) ?> <label for="caradatang_ambulance">Ambulance</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'caradatang_diantarpolisi', ['id'=>'caradatang_diantarpolisi']) ?> <label for="caradatang_diantarpolisi">Diantar Polisi</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'caradatang_rujukan', ['id'=>'caradatang_rujukan']) ?> <label for="caradatang_rujukan">Rujukan</label>
        </div>        
    </div>
    
    <div class="control-group">
        <label class="control-label">Pengantar Pasien</label>
        <div class="controls">
            <?= $form->textField($model, 'pengantar_pasien',['placeholder'=>'pengantar pasien']) ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kecelakaan</label>
        <div class="controls">
            <?= $form->checkBox($model, 'kecelakaan_lalulintas', ['id'=>'kecelakaan_lalulintas']) ?> <label for="kecelakaan_lalulintas">Kecelakaan Lalu Lintas</label>
        </div>                
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?= $form->checkBox($model, 'kecelakaan_kerja', ['id'=>'kecelakaan_kerja']) ?> <label for="kecelakaan_kerja">Kecelakaan Kerja</label>
        </div>        
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>       
        <div class="controls">
            <?= $form->checkBox($model, 'kecelakaan_rumahtangga', ['id'=>'kecelakaan_rumahtangga']) ?> <label for="kecelakaan_rumahtangga">Kecelakaan Rumah Tangga</label>
        </div>        
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>              
        <div class="controls">
            <?= $form->checkBox($model, 'kecelakaan_pejalankaki', ['id'=>'kecelakaan_pejalankaki']) ?> <label for="kecelakaan_pejalankaki">Kecelakaan Pejalan Kaki</label>
        </div>          
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>                      
        <div class="controls">
            <?= $form->checkBox($model, 'kecelakaan_kecelakaanair', ['id'=>'kecelakaan_kecelakaanair']) ?> <label for="kecelakaan_kecelakaanair">Kecelakaan Air</label>
        </div>  
    </div>
    
    
    <div class="control-group">
        <label class="control-label">Skrining Airbone Disease</label>
        <div class="controls">
            <?= $form->checkBox($model, 'sad_gejalapernapasan', ['id'=>'sad_gejalapernapasan']) ?> <label for="sad_gejalapernapasan">Gejala pernapasan</label>
        </div>                
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?= $form->checkBox($model, 'sad_demam', ['id'=>'sad_demam']) ?> <label for="sad_demam">Demam (>37<sup>o</sup>C)</label>
        </div>        
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>       
        <div class="controls">
            <?= $form->checkBox($model, 'sad_riwayat', ['id'=>'sad_riwayat']) ?> <label for="sad_riwayat">Riwayat dari Daerah Endemik</label>
        </div>        
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>              
        <div class="controls">
            <?= $form->checkBox($model, 'sad_erupsi', ['id'=>'sad_erupsi']) ?> <label for="sad_erupsi">Erupsi Kulit</label>
        </div>          
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>              
        <div class="controls">
            <?= $form->checkBox($model, 'sad_eritema', ['id'=>'sad_eritema']) ?> <label for="sad_eritema">Eritema</label>
        </div>          
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>                      
        <div class="controls">
            <?= $form->checkBox($model, 'sad_riwayatkontak', ['id'=>'sad_riwayatkontak']) ?> <label for="sad_riwayatkontak">Riwayat Kontak</label>
        </div>  
    </div>
</div>

<div class="col-sm-6">
    <div class="control-group">
        <div class="controls">
            <?= $form->checkBox($model, 'is_truemergency', ['id'=>'is_truemergency']) ?> <label for="is_truemergency">True Emergency</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'is_falseemergency', ['id'=>'is_falseemergency']) ?> <label for="is_falseemergency">False Emergency</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Jenis Kasus</label>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_nontrauma', ['id'=>'jeniskasus_nontrauma']) ?> <label for="jeniskasus_nontrauma">Non Trauma</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_trauma', ['id'=>'jeniskasus_trauma']) ?> <label for="jeniskasus_trauma">Trauma</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_obstetri', ['id'=>'jeniskasus_obstetri']) ?> <label for="jeniskasus_obstetri">Obstetri</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_neonatus', ['id'=>'jeniskasus_neonatus']) ?> <label for="jeniskasus_neonatus">Neonatus</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_pediatrik', ['id'=>'jeniskasus_pediatrik']) ?> <label for="jeniskasus_pediatrik">Pediatrik</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'jeniskasus_geriatrik', ['id'=>'jeniskasus_geriatrik']) ?> <label for="jeniskasus_geriatrik">Geriatrik</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Doa</label>
        <label class="controls">
            Jam:
        </label>
        <div class="controls">
             <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'jamdoa',
                'value' => null,
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'span3 htpd tglext',
                ),
            ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls span2">
            Tanda Kehidupan:
        </label>
        <div class="controls">
            <?=
                $form->radioButtonList($model, 'tandakehidupan', [
                    '1' => 'Ya',
                    '0' => 'Tidak'
                ])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls span2">
            Denyut Nadi:
        </label>
        <div class="controls">
            <?=
                $form->radioButtonList($model, 'denyutnadi', [
                    '1' => 'Ya',
                    '0' => 'Tidak'
                ])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls span2">
            RC(/):
        </label>
        <div class="controls">
            <?=
                $form->radioButtonList($model, 'rc', [
                    '1' => 'Ya',
                    '0' => 'Tidak'
                ])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls span2">
            EKG Flat:
        </label>
        <div class="controls">
            <?=
                $form->radioButtonList($model, 'ekg', [
                    '1' => 'Ya',
                    '0' => 'Tidak'
                ])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Riwayat Alergi</label>
        <label class="controls span2">
            <?= $form->checkBox($model,'riwayatalergi_makanan',['id'=>'riwayatalergi_makanan']) ?> <label for="riwayatalergi_makanan">Makanan</label>
        </label>
        <div class="controls">
            <?=
                $form->textField($model,'riwayatalergi_makanan_keterangan',['class'=>'span3'])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls span2">
            <?= $form->checkBox($model,'riwayatalergi_obat',['id'=>'riwayatalergi_obat']) ?> <label for="riwayatalergi_obat">Obat</label>
        </label>
        <div class="controls">
            <?=
                $form->textField($model,'riwayatalergi_obat_keterangan',['class'=>'span3'])
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kesadaran</label>
        <div class="controls">
            <?= $form->checkBox($model, 'kesadaran_composmentis', ['id'=>'kesadaran_composmentis']) ?> <label for="kesadaran_composmentis">Compos Mentis</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kesadaran_apatis', ['id'=>'kesadaran_apatis']) ?> <label for="kesadaran_apatis">Apatis</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'kesadaran_somolen', ['id'=>'kesadaran_somolen']) ?> <label for="kesadaran_somolen">Somolen</label>
        </div>       
    </div>
    
    <div class="control-group">
        <label class="control-label">Pupil</label>
        <div class="controls">
            <?= $form->checkBox($model, 'pupil_isokor', ['id'=>'pupil_isokor']) ?> <label for="pupil_isokor">Isokor</label>
        </div>
        <div class="controls">
            <?= $form->checkBox($model, 'pupil_anisokor', ['id'=>'pupil_anisokor']) ?> <label for="pupil_anisokor">Anisokor</label>
        </div>           
    </div>
    
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <label class="controls">
            Diameter
        </label>
        <div class="controls">
            <?= $form->textField($model, 'diameter', ['class'=>'span3']) ?>
        </div>
        <label class="controls">
            mm
        </label>                
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <label class="controls">
            Reaksi Cahaya
        </label>
        <div class="controls">
            <?= $form->textField($model, 'reaksi_cahaya', ['class'=>'span3']) ?>
        </div>                     
    </div>
</div>

<div class="clear"></div>