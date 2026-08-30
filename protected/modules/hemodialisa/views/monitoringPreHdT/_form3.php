
<div class="row-fluid"> 
    <div class="col-md-12">
        <div class="control-group">
            <label class="control-label"><b>Keluhan Utama</b></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keluhan_utama_sesak_nafas', array()); ?> <label>Sesak Nafas</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keluhan_utama_mual_muntah', array()); ?> <label>Mual, Muntah</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keluhan_utama_nyeri', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#nyeri").show();
                        }else{
                            $("#nyeri").hide();
                        }
                    ')); ?> <label>Nyeri&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
            </div>
            <div id="nyeri">
                <div class="hover">
                    <div class="controls" style="border:1px solid #333;padding:5px;">
                        <?php echo CHtml::image('images/icon_nyeri/6.png', 'alt', array('width' => '30px', 'onclick' => 'calldialogAsesmenNyeri();')); ?>
                    </div>
                </div>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'asesmentnyeri_id', array('class' => 'span1', 'readonly' => true)); ?>
                    <?php echo $form->textField($model, 'skornyeri', array('class' => 'span1', 'readonly' => true, 'placeholder' => 'Skor')); ?>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model, 'keterangan_skriningnyeri', array('class' => 'span3', 'readonly' => true, 'placeholder' => 'Keterangan')); ?>
                </div>
                <div class="controls"><label>Lokasi Nyeri</label></div>
                <div class="controls">
                    <?= $form->textField($model,'lokasi_nyeri') ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keluhan_utama_lainnya', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'keluhan_utama_lainnya_keterangan') . '").attr("readonly",false);
                        }else{
                            $("#' . CHtml::activeId($model, 'keluhan_utama_lainnya_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'keluhan_utama_lainnya_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Lainnya</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($model, 'keluhan_utama_lainnya_keterangan', array('style' => 'width:289px', 'placeholder' => 'Jelaskan', 'readonly' => true)); ?>
            </div>
        </div>
        <br>
        <h5 style="font-weight:bold">Pemeriksaan Fisik</h5>
        <div class="control-group ">
            <label class="control-label">GCS</label>
            <div class="controls">
                <label>E</label>
                <?php
                $crit = new CDbCriteria();
                $crit->compare('LOWER(metodegcs_singkatan)', "e");
                $crit->addCondition('metodegcs_nilai is not null');
                $crit->order = 'metodegcs_nilai ASC';
                echo $form->dropDownList($model, 'gcs_eye', CHtml::listData(MetodegcsM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                ?> 
            </div>
            <div class="controls">
                <label>V</label>
                <?php
                $crit3 = new CDbCriteria();
                $crit3->compare('LOWER(metodegcs_singkatan)', "v");
                $crit3->addCondition('metodegcs_nilai is not null');
                $crit3->order = 'metodegcs_nilai ASC';
                echo $form->dropDownList($model, 'gcs_verbal', CHtml::listData(MetodegcsM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                ?>
            </div>
            <div class="controls">
                <label>M</label>
                <?php
                $crit2 = new CDbCriteria();
                $crit2->compare('LOWER(metodegcs_singkatan)', "m");
                $crit2->addCondition('metodegcs_nilai is not null');
                $crit2->order = 'metodegcs_nilai ASC';
                echo $form->dropDownList($model, 'gcs_motorik', CHtml::listData(MetodegcsM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keadaan Umum</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keadaan_umum_baik', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_sedang') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Baik</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keadaan_umum_sedang', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_baik') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Sedang</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'keadaan_umum_lainnya', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'keadaan_umum_baik') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_sedang') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").attr("readonly",false);
                        }else{
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").val("");
                            $("#' . CHtml::activeId($model, 'keadaan_umum_lainnya_keterangan') . '").attr("readonly",true);
                        }
                    ')); ?> <label>Lainnya</label>
            </div>
            <div class="controls">
                <?php echo $form->textField($model, 'keadaan_umum_lainnya_keterangan', array('class' => 'span3', 'placeholder' => 'Lainnya', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Berat Badan</label>
            <div class="controls">
                <label>Pre HD</label>
                <?php echo $form->textField($model, 'berat_badan_pre_hd', array('class' => 'span2 float2 berat_badan_pre_hd', 'onkeyup' => 'hitungBMI();selisihBb();')); ?>
                <label>kg</label>
            </div>
             <div class="controls">
                <label>BB Kering</label>
                <?php echo $form->textField($model, 'berat_badan_kering', array('class' => 'span2 float2 ',)); ?>
                <label>kg</label>
            </div>
            <div class="controls">
                <label>Post HD yang lalu</label>
                <?php echo $form->textField($model, 'berat_badan_post_hd', array('class' => 'span2 float2 berat_badan_post_hd','onkeyup'=>'selisihBb();')); ?>
                <label>kg</label>
            </div>
            <div class="controls">
                <label>Selisih</label>
                <?php echo $form->textField($model, 'selisih', array('class' => 'span2 float2 selisih')); ?>
                <label>kg</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tidaktimbang', array()); ?>
                <label for="MonitoringPreHdT_tidaktimbang">Pasien tidak timbang </label>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label">Tinggi Badan</label>
            <div class="controls">
                <?php echo $form->textField($model, 'tinggi_badan', array('class' => 'span2 float2', 'onkeyup' => 'hitungBMI()')); ?>
                <label>cm</label>
            </div>
            <div class="controls">
                <label>IMT</label>
                <?php echo $form->textField($model, 'imt', array('class' => 'span2 integer-decimal', 'readonly' => true)); ?>
                <label>kg/m2</label>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label">Tekanan Darah</label>
            <div class="controls">
                <?php echo $form->textField($model, 'tensi_sistolik', array('class' => 'span1')); ?>
                <label>&nbsp;&nbsp;/&nbsp;</label>
                <?php echo $form->textField($model, 'tensi_diastolik', array('class' => 'span1')); ?>
                <label>mmHg</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nadi</label>
            <div class="controls">
                <?php echo $form->textField($model, 'nadi', array('class' => 'span2')); ?>
                <label>x/mnt</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Respirasi</label>
            <div class="controls">
                <?php echo $form->textField($model, 'respirasi', array('class' => 'span2')); ?>
                <label>x/mnt</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Suhu</label>
            <div class="controls">
                <?php echo $form->textField($model, 'suhu', array('class' => 'span2')); ?>
                <label><sup>o</sup>C</label>
            </div>
        </div>
        <div class="pemeriksaanumum-normal">                                                
            <div class="control-group">
                <?php echo CHtml::label('Kepala', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'kepala_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'kepala_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'kepala_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'kepala_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'kepala_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'kepala_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'kepala_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'kepala_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'kepala_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;                     
                    <?php echo $form->textField($model, 'kepala_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label('Leher', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'leher_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'leher_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'leher_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'leher_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'leher_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'leher_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'leher_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'leher_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'leher_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'leher_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Jantung', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'jantung_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'jantung_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'jantung_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'jantung_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'jantung_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'jantung_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'jantung_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'jantung_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'jantung_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'jantung_keterangan', array('class' => 'span3 laintext', 'placeholder' => 'Keterangan Tidak Normal', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Paru', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'paru_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'paru_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'paru_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'paru_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'paru_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'paru_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'paru_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'paru_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'paru_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'paru_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Abdomen', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'abdomen_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'abdomen_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'abdomen_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'abdomen_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'abdomen_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'abdomen_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'abdomen_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'abdomen_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'abdomen_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'abdomen_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kulit', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'kulit_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'kulit_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'kulit_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'kulit_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'kulit_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'kulit_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'kulit_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'kulit_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'kulit_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'kulit_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Anggota Tubuh', 'penyakit_dahulu', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <?php echo $form->checkBox($model, 'anggota_tubuh_normal', array('class' => 'pilih-normal', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_tidak_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Normal</label>&nbsp;
                    <?php echo $form->checkBox($model, 'anggota_tubuh_tidak_normal', array('class' => 'lainlain', 'onclick' => '
                                    if($(this).is(":checked")){
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_normal') . '").removeAttr("checked");
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_keterangan') . '").attr("readonly",false);
                                    }else{
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_keterangan') . '").val("");
                                        $("#' . CHtml::activeId($model, 'anggota_tubuh_keterangan') . '").attr("readonly",true);
                                    }
                                ')); ?> <label>Tidak Normal</label>&nbsp;
                    <?php echo $form->textField($model, 'anggota_tubuh_keterangan', array('placeholder' => 'Keterangan Tidak Normal', 'class' => 'span3 laintext', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        
        <div class="form-cek-lis has-delete">
            <?= $this->renderPartial($this->path_view.'form._form_akses_vaskuler',['modVas'=>$modAksesVaskular,'model'=>$model,'align'=>'left']); ?>
        </div>
        
        <div class="control-group">
            <label class="control-label">Konjungtiva</label>
            <div class="controls">
                <?= $form->checkBox($model, 'konjuctiva_tidakanemis', ['id'=>'konjuctiva_tidakanemis']) ?> <label for="konjuctiva_tidakanemis">Tidak Anemis</label>
                <br/>
                <?= $form->checkBox($model, 'konjungtiva_anemis', ['id'=>'konjungtiva_anemis']) ?> <label for="konjungtiva_anemis">Anemis</label>
                <br/>
                <?php 
                    echo $form->checkBox($model, 'konjungtiva_lainlain', ['id'=>'konjungtiva_lainlain','onclick'=>'konjungtivaLain();']).'<label for="konjungtiva_lainlain">Lain-Lain</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$form->textField($model, 'konjungtiva_keterangan',['id'=>'konjungtiva_keterangan']) 
                ?> 
            </div>            
        </div>
        
        <div class="control-group">
            <label class="control-label">Ekstrimitas</label>
            <div class="controls">
                <?= $form->checkBox($model, 'ekstrimitas_tidakedema', ['id'=>'ekstrimitas_tidakedema']) ?> <label for="ekstrimitas_tidakedema">Tidak Edema/tidak dehidras</label>
                <br/>
                <?= $form->checkBox($model, 'ekstrimitas_anemis', ['id'=>'ekstrimitas_anemis']) ?> <label for="ekstrimitas_anemis">Anemis</label>
                <br/>
                <?= $form->checkBox($model, 'ekstrimitas_oedema', ['id'=>'ekstrimitas_oedema']) ?> <label for="ekstrimitas_oedema">Oedema</label>
                <br/>
                <?= $form->checkBox($model, 'ekstrimitas_anasarka', ['id'=>'ekstrimitas_anasarka']) ?> <label for="ekstrimitas_anasarka">Anasarka</label>
                <br/>
                <?= $form->checkBox($model, 'ekstrimitas_pucatdingin', ['id'=>'ekstrimitas_pucatdingin']) ?> <label for="ekstrimitas_pucatdingin">Pucat & Dingin</label>
            </div>            
        </div>
        
        <div class="control-group">
            <label class="control-label">Gizi</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'gizi_baik', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'gizi_sedang') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'gizi_buruk') . '").removeAttr("checked");
                        }
                    ')); ?> <label>Baik</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'gizi_sedang', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'gizi_baik') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'gizi_buruk') . '").removeAttr("checked");
                        }
                    ')); ?> <label>Sedang</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'gizi_buruk', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'gizi_baik') . '").removeAttr("checked");
                            $("#' . CHtml::activeId($model, 'gizi_sedang') . '").removeAttr("checked");
                        }
                    ')); ?> <label>Buruk</label>
            </div>
        </div>
        <br> 
        <h5 style="font-weight:bold">Risiko Jatuh</h5>
        <div class="control-group">
            <label class="control-label">Dewasa</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'risiko_jatuh_dewasa_rendah', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'risiko_jatuh_dewasa_tinggi') . '").removeAttr("checked");
                        }
                    ')); ?> <label>TR (0-24)</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'risiko_jatuh_dewasa_tinggi', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'risiko_jatuh_dewasa_rendah') . '").removeAttr("checked");
                        }
                    ')); ?> <label>TR (25-440)</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Anak</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'risiko_jatuh_anak_rendah', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'risiko_jatuh_anak_tinggi') . '").removeAttr("checked");
                        }
                    ')); ?> <label>TR (7-11)</label>
            </div>
            <div class="controls">
                <?php echo $form->checkBox($model, 'risiko_jatuh_anak_tinggi', array('onclick' => '
                        if($(this).is(":checked")){
                            $("#' . CHtml::activeId($model, 'risiko_jatuh_anak_rendah') . '").removeAttr("checked");
                        }
                    ')); ?> <label>TR (>=12)</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Pemeriksaan Lab</label>
            <div class="controls">
                <?= $this->renderPartial($this->path_view.'riwayat/_riwayat_periksa_lab',['model'=>$model], true) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Pemeriksaan Lab dari Luar</label>
            <div class="controls">
                <?=
                    $this->renderPartial('rawatInap.views.asesmenAwalMedisAnak.form/_form_hasil_lab_eks',['model'=>$model],true);
                ?>
                
            </div>
        </div>
    </div>
</div>
