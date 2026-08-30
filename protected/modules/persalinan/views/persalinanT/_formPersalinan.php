<fieldset class='' id="panel-persalinan" hidden>
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Dokter / Petugas</b>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($model->DokterItems, 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan2_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan3_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'paramedis_id',  CHtml::listData($model->ParamedisItems, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model, 'catatan_dokter', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Lokasi dan Rujukan
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->label($model, 'lokasi_persalinan', array('class' => 'control-label', 'label' => 'Tempat Persalinan')); ?>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'lokasi_persalinan', array(
                                'Rumah Ibu' => 'Rumah Ibu',
                                'Polindes' => 'Polindes',
                                'Klinik Swasta' => 'Klinik Swasta',
                                'Puskesmas' => 'Puskesmas',
                                'Rumah Sakit' => 'Rumah Sakit',
                            ), array(
                                'uncheckValue' => null,
                                'template' => '<div class="checkbox" style="margin-left: 20px;">{input}{label}</div>'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($model, 'alamat_persalinan', array('class' => 'control-label', 'label' => 'Alamat Tempat Persalinan')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($model, 'alamat_persalinan', array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($model, 'is_rujuk', array('class' => 'control-label', 'label' => 'Catatan')); ?>
                        <div class="controls">
                            <div class="checkbox-inline"><?php echo $form->checkBox($model, 'is_rujuk') ?><label>Rujuk</label></div><br>
                            <label>Kala :</label>
                            <?php echo $form->radioButtonList($model, 'rujuk_kala', array(
                                'I' => 'I',
                                'II' => 'II',
                                'III' => 'III',
                                'IV' => 'IV',
                            ), array(
                                'template' => '<div class="radio-inline">{input}{label}</div>'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($model, 'rujuk_alasan', array('class' => 'control-label', 'label' => 'Alasan Merujuk')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'rujuk_alasan', array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($model, 'rujuk_tempat', array('class' => 'control-label', 'label' => 'Tempat Rujukan')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'rujuk_tempat', array('class' => 'span3')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($model, 'rujuk_pendamping', array('class' => 'control-label', 'label' => 'Pendampingan pada saat merujuk')); ?>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'rujuk_pendamping', array(
                                'Bidan' => 'Bidan',
                                'Suami' => 'Suami',
                                'Keluarga' => 'Keluarga',
                                'Teman' => 'Teman',
                                'Dukun' => 'Dukun',
                                'Tidak Ada' => 'Tidak Ada',
                            ), array(
                                'uncheckValue' => null,
                                'template' => '<div class="checkbox" style="margin-left: 20px;">{input}{label}</div>'
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->label($model, 'masalah_kehamilan', array('class' => 'control-label', 'label' => 'Masalah dalam kehamilan/persalinan ini ')); ?>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'masalah_kehamilan', array(
                                'Gawat Darurat' => 'Gawat Darurat',
                                'Pendarahan' => 'Pendarahan',
                                'HDK' => 'HDK',
                                'Infeksi' => 'Infeksi',
                                'PMTCT' => 'PMTCT',
                            ), array(
                                'uncheckValue' => null,
                                'template' => '<div class="checkbox" style="margin-left: 20px;">{input}{label}</div>'
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Abortus</b>
                    </div>
                </div>
                <div class="panel-body">
                    <?php echo $form->dropDownListRow($model, 'kelsebababortus_id', CHtml::listData(PSKelsebababortusM::model()->findAll("kelsebababortus_aktif = TRUE ORDER BY kelsebababortus_nama ASC"), 'kelsebababortus_id', 'kelsebababortus_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php echo $form->dropDownListRow($model, 'sebababortus_id', CHtml::listData(PSSebababortusM::model()->findAll("sebababortus_aktif = TRUE ORDER BY sebababortus_nama ASC"), 'sebababortus_id', 'sebababortus_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group">
                        <?php
                        $model->tglabortus = null;
                        echo $form->labelEx($model, 'tglabortus', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglabortus',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglabortus'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'jmlabortus', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Persalinan</b>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglmulaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmulaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    //'onkeypress' => "js:function(){getUmur(this);}",
                                    //'onSelect' => 'js:function(){$(this).close();}',
                                    //'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglmulaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglselesaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglselesaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglselesaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'lamapersalinan_jam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'lamapersalinan_jam', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> Jam
                            <?php echo $form->error($model, 'lamapersalinan_jam'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglmelahirkan', array(
                            'class' => 'control-label',
                            'label' => 'Tanggal Melahirkan <span class="required">*</span>'
                        )); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmelahirkan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group" hidden>
                        <?php echo $form->labelEx($model, 'islahirdirs', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'islahirdirs', array('value' => 1, 'uncheckValue' => null)); ?> Ya &emsp;
                            <?php echo $form->radioButton($model, 'islahirdirs', array('value' => 0, 'uncheckValue' => null)); ?> Tidak
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'keadaanlahir', LookupM::getItems('keadaanlahir'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setKematian();', 'maxlength' => 100)); ?>
                    <?php echo $form->dropDownListRow($model, 'sebabkematian', LookupM::getItems('sebabkematian'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masagestasi_minggu', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'masagestasi_minggu', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> Minggu
                            <br>
                            <?php echo $form->error($model, 'masagestasi_minggu'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'paritaske', LookupM::getItemsUrutan('paritas'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'jmlkelahiranhidup', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranhidup', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> Orang
                            <?php echo $form->error($model, 'jmlkelahiranhidup'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'jmlkelahiranmati', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranmati', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> Orang
                            <?php echo $form->error($model, 'jmlkelahiranmati'); ?>
                        </div>
                    </div>

                    <?php echo $form->dropDownListRow($model, 'jeniskegiatanpersalinan', LookupM::model()->getItems('jeniskegiatanpersalinan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'kegiatanpersalinan_id', CHtml::listData(PSKegiatanpersalinanM::model()->findAll("kegiatanpersalinan_aktif ORDER BY kegiatanpersalinan_nama ASC"), 'kegiatanpersalinan_id', 'kegiatanpersalinan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'carapersalinan', LookupM::getItems('carapersalinan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'posisijanin', LookupM::getItems('posisijanin'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php //echo $form->textFieldRow($model, 'tglmelahirkan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                    ?>

                    <?php //echo $form->textFieldRow($model, 'masagestasi_minggu', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                    ?>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Lain - lain
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo CHtml::label('Masalah dalam kehamilan/ persalinan', '', array('class' => 'control-label')) ?>
                        <div class="controls" style="width: 70%;">
                            <table width="100%">
                        <?php
                            $lookup_penyunting = LookupM::model()->findAllByAttributes(array('lookup_type'=>'penyulit_kehamilan_persalinan'),array('condition'=>"lookup_value <> 'Lainnya' ",'order'=>'lookup_urutan ASC'));
                            $html_penyunting = "";
                            $index_urut = 0;

                            if(!empty($lookup_penyunting)){
                            $ind_penyuting = 1;
                            foreach($lookup_penyunting as $i => $look){
                                $ischeck = false;
                                
                                if(!empty($model->penyulit_kehamilan_persalinan)){
                                    $oriPenyunting = json_decode($model->penyulit_kehamilan_persalinan);
                                    
                                    foreach ($oriPenyunting as $ori_data) {
                                        if($ori_data->penyulit == $look->lookup_value){
                                            $ischeck = true;
                                        }
                                    }
                                }
                                if($ind_penyuting == 1){
                                    $html_penyunting .= '<tr>';
                                }
                                $html_penyunting .= '<td>';
                                $html_penyunting .= CHtml::hiddenField('PenyulitKehamilan['.$index_urut.'][penyulit]',$look->lookup_value);
                                $html_penyunting .= CHtml::checkBox('PenyulitKehamilan['.$index_urut.'][ischeck]',$ischeck , array('class'=>'ischeck', 'look_value'=>$look->lookup_value,'onchange'=>'changePenyulitKehamilan(this)')).' <label>'.$look->lookup_name.'</label>';

                                $html_penyunting .= '</td>';
                                if($ind_penyuting == 3){
                                    $html_penyunting .= '<tr>';
                                    $ind_penyuting = 0;
                                }
                                $ind_penyuting++;
                                $index_urut++;
                            }
                        }
                            $lookup_penyuntinglain = LookupM::model()->findAllByAttributes(array('lookup_type'=>'penyulit_kehamilan_persalinan'),array('condition'=>"lookup_value = 'Lainnya' ",'order'=>'lookup_urutan ASC'));

                            if(!empty($lookup_penyuntinglain)){
                                foreach($lookup_penyuntinglain as $i => $look){
                                    $ischeck = false;
                                    $ket = "";
    
                                    if(!empty($model->penyulit_kehamilan_persalinan)){
                                        $oriPenyunting = json_decode($model->penyulit_kehamilan_persalinan);
                                        foreach ($oriPenyunting as $ori_data) {
                                            if($ori_data->penyulit == $look->lookup_value){
                                                $ischeck = true;
                                                $ket = $ori_data->keterangan;
                                            }
                                        }
                                    }
                                    $html_penyunting .= '<tr>';
                                    $html_penyunting .= '<td colspan="3">';
                                    $html_penyunting .= CHtml::hiddenField('PenyulitKehamilan['.$index_urut.'][penyulit]',$look->lookup_value);
                                    $html_penyunting .= CHtml::checkBox('PenyulitKehamilan['.$index_urut.'][ischeck]',$ischeck , array('class'=>'ischeck', 'index'=>$index_urut, 'look_value'=>$look->lookup_value,'onchange'=>'changePenyulitKehamilan(this)')).' <label>'.$look->lookup_name.'</label>';
                                    $html_penyunting .= "<br /><span style='padding-left: 20px'></span>".CHtml::textArea('PenyulitKehamilan['.$index_urut.'][keterangan]',$ket,array('class'=>'span3 keterangan_persalinan','readonly'=>($ischeck==true)?false:true));
    
                                    $html_penyunting .= '</td>';
                                    $html_penyunting .= '</tr>';
                                    $index_urut++;
                                }
                            }

                                echo $html_penyunting;
                        ?>
                            </table>
                        </div>
                    </div>
                    <div class="control-group">
                    <?php echo CHtml::label('Prevention Mother To Child Transmission', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                echo $form->textArea($model, 'pmtct', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php /*
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                   
                    
                    <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    
                    
                    <?php //echo $form->textFieldRow($model,'tglmulaipersalinan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    
                    
                </td>
                <td>                    
                    
                    
                </td>
            </tr>
        </table>
			 * 
			 */ ?>
</fieldset>