<div class="col-sm-6">
    <?php $template = "{input} {label}&emsp;"; ?>
    <div class="control-group">
        <label class="control-label"> HBsAg </label>
        <div class="controls">
            <?php echo $form->radioButtonList($model, 'hbsag', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'onchange'=>'cekReaktif();')); ?>
            <?php echo $form->textField($model, 'lot_antihbsag', array('style' => 'width:90px', 'placeholder' => 'Masukkan Lot'));?>
        </div>
        <div class="controls">
            <?php
            $model->tgl_kadaluarsa = !empty($model->tgl_kadaluarsa) ? MyFormatter::formatDateTimeForUser($model->tgl_kadaluarsa) : "";
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_kadaluarsa',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'minDate' => '1d',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tgl_kadaluarsa'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Anti HIV </label>
        <div class="controls">
            <?php echo $form->radioButtonList($model, 'antihiv', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'onchange'=>'cekReaktif();')); ?>
            <?php echo $form->textField($model, 'lot_antihiv', array('style' => 'width:90px', 'placeholder' => 'Masukkan Lot'));?>
        </div>
        <div class="controls">
            <?php
            $model->tgl_kadaluarsa_antihiv = !empty($model->tgl_kadaluarsa_antihiv) ? MyFormatter::formatDateTimeForUser($model->tgl_kadaluarsa_antihiv) : "";
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_kadaluarsa_antihiv',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'minDate' => '1d',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tgl_kadaluarsa_antihiv'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Anti HCV </label>
        <div class="controls">
            <?php echo $form->radioButtonList($model, 'antihvc', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'onchange'=>'cekReaktif();')); ?>
            <?php echo $form->textField($model, 'lot_antihcv', array('style' => 'width:90px', 'placeholder' => 'Masukkan Lot'));?>
        </div>
        <div class="controls">
            <?php
            $model->tgl_kadaluarsa_antihcv = !empty($model->tgl_kadaluarsa_antihcv) ? MyFormatter::formatDateTimeForUser($model->tgl_kadaluarsa_antihcv) : "";
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_kadaluarsa_antihcv',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'minDate' => '1d',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tgl_kadaluarsa_antihcv'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Sifilis </label>
        <div class="controls">
            <?php echo $form->radioButtonList($model, 'sifilis', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'onchange'=>'cekReaktif();')); ?>
            <?php echo $form->textField($model, 'lot_sifilis', array('style' => 'width:90px', 'placeholder' => 'Masukkan Lot'));?>
        </div>
        <div class="controls">
            <?php
            $model->tgl_kadaluarsa_sifilis = !empty($model->tgl_kadaluarsa_sifilis) ? MyFormatter::formatDateTimeForUser($model->tgl_kadaluarsa_sifilis) : "";
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_kadaluarsa_sifilis',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    //'minDate' => '1d',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tgl_kadaluarsa_sifilis'); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <?php echo $form->textAreaRow($model, 'ket_skrining'); ?>
    <?php echo $form->textFieldRow($model, 'hasil_skrining', array(
        'readonly'=>true,
    )); ?>
</div>
<div class="clear"></div>
<hr/>
<div class="col-sm-6">
    <div class="control-group ">
        <?php echo $form->labelEx($model, 'tglskrining', array(
            'class' => 'control-label', 'label'=>'Tgl. Skrining'
        )) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglskrining',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
            <?php echo $form->error($model, 'tglpencatatan'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo Chtml::label("Petugas <font style='color:red'>*</font>", 'petugasskrining_id', array(
            'class'=>'control-label',
        )); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'petugasskrining_id',array('class' => 'required','readonly'=>true)); ?>
            <?php
            
            $petugas = "";
            if (!empty($model->petugasskrining_id)) {
                $petugas = $model->petugasskrining->nama_pegawai;
            }
            
           
            ?>
            <?php echo $form->textField($model, 'petugasskrining_nama',array('class' => 'required','readonly'=>true)); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Verifikator 1','',array('class'=>'control-label')); ?>
         <div class="controls">
            <?php 		
            echo $form->hiddenField($model,'verifikator1_id', array('readonly' => true));
            $model->verifikator1_nama = !empty($model->verifikator1_id) ? $model->verifikator1->namaLengkap : "";
            $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'verifikator1_nama',
                    'source'=>'js: function(request, response) {
                            $.ajax({
                            url: "'.$this->createUrl('/ActionAutoComplete/dropPetugasRuangan').'",
                            dataType: "json",
                            data: {
                                    term: request.term,
                                    ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                            },
                            success: function (data) {
                                    response(data);
                            }
                    })
            }',
            'options'=>array(
                    'showAnim'=>'fold',
                    'minLength' => 3,
                    'focus'=> 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                             $("#'.CHtml::ActiveId($model, 'verifikator1_id').'").val(ui.item.value); 
                             return false;
                     }',
            ),		
            'htmlOptions' => array('class'=>'span3','rel'=>'tooltip','title'=>'Ketik nama untuk verifikator',),
            'tombolDialog' => array('idDialog' => 'dialogVerifikator1', 'idTombol' => 'tombolKoordinator'),
            )); 
            ?>
        </div>
        <div class="controls">
            
             <?php 
                if (!empty($model->verifikator1_id)) {
                    if (!empty($model->verifikator1_id)) {
                        $petugas = $model->verifikator1->namaLengkap;
                    }
                    if ($model->verifikator1_id == Yii::app()->user->getState('pegawai_id')) {
                        if (!empty($model->tgl_verifikasi1)) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => true));
                        } else{
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Verifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'persetujuanVerifikator1("' . $model->nomorbarcode_sample.",".$model->pengujian_ke. '");return false;'));
                        }
                    } else {
                        if (!empty($model->tgl_verifikasi1)) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => true));
                        } else{
                            echo CHtml::link("<i class='fa fa-check'></i> Verifikasi","javascript:cekPersetujuan('$petugas')",array('class' => 'btn btn-danger', "rel"=>"tooltip","title"=>"Klik Untuk Melakukan Persetujuan"));
                        }
                    }
                } else {
                    echo CHtml::htmlButton('<i class="fa fa-check"></i> Verifikasi', array(
                                    'class' => 'btn btn-danger',
                                    'onclick'=>'toastr.error("Silahkan mengisi nama <b> Verifikator 1 </b> terlebih dahulu", "Perhatian!");',
                                    'disabled' => false,
                                    'rel'=>'tooltip',
                                    'title'=>'Klik untuk memverifikasi',
                        ));

                }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Verifikator 2','',array('class'=>'control-label')); ?>
         <div class="controls">
            <?php 		
            echo $form->hiddenField($model,'verifikator2_id', array('readonly' => true));
            $model->verifikator2_nama = !empty($model->verifikator2_id) ? $model->verifikator2->namaLengkap : "";
            $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'verifikator2_nama',
                    'source'=>'js: function(request, response) {
                            $.ajax({
                            url: "'.$this->createUrl('/ActionAutoComplete/dropPetugasRuangan').'",
                            dataType: "json",
                            data: {
                                    term: request.term,
                                    ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                            },
                            success: function (data) {
                                    response(data);
                            }
                    })
            }',
            'options'=>array(
                    'showAnim'=>'fold',
                    'minLength' => 3,
                    'focus'=> 'js:function( event, ui ) {
                             $(this).val( ui.item.label);
                             return false;
                     }',
                    'select'=>'js:function( event, ui ) {
                             $("#'.CHtml::ActiveId($model, 'verifikator2_id').'").val(ui.item.value); 
                             return false;
                     }',
            ),		
            'htmlOptions' => array('class'=>'span3','rel'=>'tooltip','title'=>'Ketik nama untuk verifikator',),
            'tombolDialog' => array('idDialog' => 'dialogVerifikator2', 'idTombol' => 'tombolKoordinator'),
            )); 
    ?>
        </div>
        <div class="controls">
             <?php 
             if (!empty($model->verifikator2_id)) {
                    if (!empty($model->verifikator2_id)) {
                        $petugas = $model->verifikator2->namaLengkap;
                    }
                    if ($model->verifikator2_id == Yii::app()->user->getState('pegawai_id')) {
                        if (!empty($model->tgl_verifikasi2)) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => true));
                        } else{
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Verifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'persetujuanVerifikator2("' . $model->nomorbarcode_sample.",".$model->pengujian_ke . '");return false;'));
                        }
                    } else {
                        if (!empty($model->tgl_verifikasi2)) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => "<i class='fa fa-check'></i>")), array('class' => 'btn btn-success', 'type' => 'button', 'disabled' => true));
                        } else{
                            echo CHtml::link("<i class='fa fa-check'></i> Verifikasi","javascript:cekPersetujuan('$petugas')",array('class' => 'btn btn-danger', "rel"=>"tooltip","title"=>"Klik Untuk Melakukan Persetujuan"));
                        }
                    }
                } else {
                    echo CHtml::htmlButton('<i class="fa fa-check"></i> Verifikasi', array(
                                    'class' => 'btn btn-danger',
                                    'onclick'=>'toastr.error("Silahkan mengisi nama <b> Verifikator 2 </b> terlebih dahulu", "Perhatian!");',
                                    'disabled' => false,
                                    'rel'=>'tooltip',
                                    'title'=>'Klik untuk memverifikasi',
                        ));

                }
             ?>
        </div>
    </div>
</div>
<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogVerifikator1',
    'options'=>array(
        'title'=>'Pencarian Verifikator 1',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,        
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'verifikator1-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'verifikator1_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'verifikator1_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogVerifikator1\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>

<?php 
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogVerifikator2',
    'options'=>array(
        'title'=>'Pencarian Verifikator 2',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,        
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'verifikator2-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'verifikator2_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'verifikator2_nama') . '\").val(\"$data->namaLengkap\");
                              $(\"#dialogVerifikator2\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>650,
        'resizable'=>false,
    ),
));
$modPegawai = new PegawairuanganV('searchPegawaiRuangan');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->unitkerja_id = Yii::app()->user->getState('unitkerja_id');
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiCRU-grid',
    'dataProvider' => $modPegawai->searchPegawaiRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = CJSON::encode($data->attributes);
    
                return CHtml::Link("<i class='icon-form-check'></i>","#",array("class"=>"btn-small", 
                                "id" => "selectpegawai",
                                "onClick" => "
                                    $('#SkriningimltdT_petugasskrining_id').val($data->pegawai_id);
                                    $('#petugasskrining_nama').val('".$data->namaLengkap."');
                                    $('#dialogPegawaiMengetahui').dialog('close');
                                    return false;"));
            },
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
                    'header'=>'Unit Kerja',
                    'filter'=>  CHtml::activeDropDownList($modPegawai, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'),array('empty'=>'-- Pilih --')),
                    'value'=> function($data){
                        $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                        if (!empty($j)){
                            return $j->namaunitkerja;
                        }else{
                            return '-';
                        }
                    }   
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
$controller = Yii::app()->controller->id; 
$module = Yii::app()->controller->module->id; 
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

?>      
<script>
    $(document).ready(function() {
        cekReaktif();
    });
    
    function cekReaktif() {
        var nilai = 0;
        $(".rd_reaksi:checked").each(function() {
            nilai += parseInt($(this).val());
        });
        
        if (nilai > 0) {
            $("#SkriningimltdT_hasil_skrining").val("REAKTIF");
        } else {
            $("#SkriningimltdT_hasil_skrining").val("NON REAKTIF");
        }
            
    }
    
    function persetujuanVerifikator1(nomorbarcode_sample, pengujian_ke){
        var url = '<?php echo $url."/persetujuanVerifikator1"; ?>';

        myConfirm('Apakah anda akan verifikasi data skrining ini?','Perhatian',function(r){
                if (r){
                     $.post(url, {nomorbarcode_sample: nomorbarcode_sample,  pengujian_ke:pengujian_ke},
                         function(data){
                            if(data.ok == 1){
                                location.reload(); 
                                toastr.success(data.msg, "Perhatian!");
                            }else {
                                toastr.error(data.msg, "Perhatian!");
                            }
                    },"json");
               }
        });
    }
    
    function persetujuanVerifikator2(nomorbarcode_sample, pengujian_ke){
        var url = '<?php echo $url."/persetujuanVerifikator2"; ?>';

        myConfirm('Apakah anda akan verifikasi data skrining ini?','Perhatian',function(r){
                if (r){
                     $.post(url, {nomorbarcode_sample: nomorbarcode_sample, pengujian_ke:pengujian_ke},
                         function(data){
                            if(data.ok == 1){
                                location.reload(); 
                                toastr.success(data.msg, "Perhatian!");
                            }else {
                                toastr.error(data.msg, "Perhatian!");
                            }
                    },"json");
               }
        });
    }
    
    function cekPersetujuan(nama){
        toastr.error('Hanya <b>'+nama+'</b> yang dapat melakukan verifikasi', "Perhatian!");
    }
    
</script>