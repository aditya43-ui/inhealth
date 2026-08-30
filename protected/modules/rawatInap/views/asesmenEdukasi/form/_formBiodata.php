<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'pasien_penerima_edukasi',array('onclick'=>'setPasien();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Pasien Penerima Edukasi</label>
        </div>
    </div>
    <?php 
        $ins_arr = array_merge(RuanganrawatdaruratV::arrIns(), RuanganrawatjalanV::arrIns());
        $ins_arr = array_merge($ins_arr, RuanganrawatinapV::arrIns());
        
        $criIns = new CDbCriteria();
        $criIns->addInCondition(" instalasi_id ",$ins_arr);
        $criIns->addCondition(" instalasi_aktif = true ");
        $criIns->order = " instalasi_nama ASC ";
        $dropIns = CHtml::listData(InstalasiM::model()->findAll($criIns),'instalasi_id','instalasi_nama');
        
        if(!empty($_GET['pendaftaran_id'])){
            $cekPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
            if(!empty($cekPendaftaran)){
                $model->instalasiawal_id = $cekPendaftaran->instalasi_id;
            }
        }
        echo $form->dropDownListRow($model,'instalasiawal_id', $dropIns,array('empty'=>'-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        echo $form->textFieldRow($model,'nama_lengkap',array('onblur'=>'generateNama(this);', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        echo $form->textFieldRow($model,'umur',array('class' =>'numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        
        echo $form->dropDownListRow($model,'agama', LookupM::getItems('agama'),array('empty'=>'-- Pilih --','class' =>'', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        
        //echo $form->dropDownListRow($model,'sukubangsa', CHtml::listData(SukuM::model()->findAll(" suku_aktif = TRUE  ORDER BY suku_nama ASC "),'suku_nama','suku_nama'),array('empty' =>'-- Pilih --'));
        echo $form->textFieldRow($model,'sukubangsa', array('class' =>'', 'onkeypress' => "return $(this).focusNextInputField(event);"));
    ?>        
    <div class="control-group">
        <label class="control-label">Kesediaan Menerima Edukasi</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'menerimaedukasi_bersedia',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Bersedia</label>
        </div>
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'menerimaedukasi_tidakbersedia',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tidak Bersedia</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Bahasa</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'bahasa_indonesia',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Indonesia</label>
        </div>
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'bahasa_inggis',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Inggris</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'bahasa_daerah',array('onclick'=>'cekBahasaDaerah();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Daerah</label>
        </div>
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'bahasa_lainnya',array('onclick'=>'cekBahasaLain();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lainnya</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->textField($model,'bahasa_daerah_keterangan',array('readonly'=>true,'class'=>'span2','placeholder'=>'Daerah', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="controls">
           
        </div>
        <div class="controls">
            <?php echo $form->textField($model,'bahasa_lainnya_ket',array('readonly'=>true,'class'=>'span2','placeholder'=>'Lainnya', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Kemampuan Berbahasa</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'kemampuanbahasa_baik',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Baik</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'kemampuanbahasa_cukup',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Cukup</label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'kemampuanbahasa_kurang',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Kurang</label>
        </div>
        
    </div>
     <div class="control-group">
        <label class="control-label">Kebutuhan Penerjemah</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanpenerjemah_ya',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Ya</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanpenerjemah_tidak',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tidak</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Baca Tulis</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'bacatulis_baik',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Baik</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'bacatulis_kurang',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Kurang</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Hambatan Edukasi</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_tidakada',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tidak Ada</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_motivasikurang',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Motivasi Kurang</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_fisiklemah',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Fisik Lemah</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_penglihatanterganggu',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Penglihatan Terganggu</label>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_kognitifterbatas',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Kognitif Terbatas</label>
        </div>
        <div class="controls">
           &nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="controls">
            <?php echo $form->checkBox($model,'hambatanedukasi_pendengaranterganggu',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Pendengaran Terganggu</label>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <?php
        echo $form->textFieldRow($model,'nilai_keyakinan',array('class' =>'', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        echo $form->textFieldRow($model,'alamat',array('class' =>'', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        
        $dropPendidikan = CHtml::listData(PendidikanM::model()->findAll("pendidikan_aktif = TRUE ORDER BY pendidikan_nama ASC"), 'pendidikan_nama', 'pendidikan_nama');
        $dropPendidikan = array_merge($dropPendidikan,array('Lain-lain'=>'Lain-lain'));
        echo $form->dropDownListRow($model,'tingkatpendidikan', $dropPendidikan,array('empty'=>'-- Pilih --','class' =>'','onchange'=>'cekPendidikan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);"));                
    ?>
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            <?php echo $form->textField($model,'tingkatpendidikan_lainnya',array('placeholder'=>'Lain - Lain','readonly'=>true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($model,'hub_denganpasien',array('class' =>'', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    
    <div class="control-group">    
         <label class="control-label">Bicara</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'bicara_normal',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Normal</label>
        </div>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'bicara_gangguansejak',array('onclick'=>'cekBicaraGangguan(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tidak Normal</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>       
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->textField($model,'bicara_gangguansejak_ket',array('class'=>'span3', 'placeholder'=>'Tidak Normal,ket', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label">Kebutuhan Privasi Keperawatan</label>
        <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_tidak',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tidak</label>
        </div>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Ya :</label>
        </div>    
          <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_wawancara',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Wawancara Klinik</label>
        </div>   
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_transportasi',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Transportasi</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_pemeriksaanfisik',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Pemeriksaan Fisik</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_ruangperawatan',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Ruang Perawatan</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_tindakan',array('onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tindakan</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->checkBox($model,'kebutuhanprivasi_ya_lainnya',array('onclick'=>'cekKebutuhanLain();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lain-lain</label>
        </div>        
    </div>
    
    <div class="control-group">    
         <label class="control-label"></label>        
         <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>        
         <div class="controls">
            <?php echo $form->textField($model,'kebutuhanprivasi_ya_lainnya_ket',array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>        
    </div>
</div>
    
<div class="clear"></div>