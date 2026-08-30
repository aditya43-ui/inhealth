<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_pendaftaran',
                    'value'=>$modKunjungan->no_pendaftaran,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                            dataType: "json",
                            data: {
                                no_pendaftaran: request.term,
                                ruangan_id: $("#ruangan_id").val(),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'minLength' => 4,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val( ui.item.no_pendaftaran);
                            setKunjungan(ui.item.pasienadmisi_id);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                    'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Pendaftaran <span class='required'>*</span>", 'tgl_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Admisi', 'tgladmisi', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgladmisi',$modKunjungan->tgladmisi,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pasienadmisi_id',$modKunjungan->pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Instalasi Asal", 'instalasi_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('instalasi_nama',$modKunjungan->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruangan Asal", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modKunjungan->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama',$modKunjungan->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modKunjungan->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modKunjungan->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modKunjungan->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modKunjungan->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div style="text-align: center;">
        <?php 
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div><br>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_rekam_medik',
                    'value'=>$modKunjungan->no_rekam_medik,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                            dataType: "json",
                            data: {
                                no_rekam_medik: request.term,
                                ruangan_id: $("#ruangan_id").val(),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'minLength' => 4,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val( ui.item.no_rekam_medik);
                            setKunjungan(ui.item.pasienadmisi_id);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modKunjungan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'nama_pasien',
                    'value'=>$modKunjungan->nama_pasien,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                            dataType: "json",
                            data: {
                                nama_pasien: request.term,
                                ruangan_id: $("#ruangan_id").val(),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val( "");
                            return false;
                          }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val( ui.item.nama_pasien);
                            setKunjungan(ui.item.pasienadmisi_id);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array('placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan','class'=>'span3',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modKunjungan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modKunjungan->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modKunjungan->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modKunjungan->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    
<!--<div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modKunjungan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Status Penanggung Jawab", 'pengantar', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('pengantar',$modKunjungan->pengantar,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>-->     
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>520,
        'resizable'=>false,
    ),
));

if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI){
    $modDialogKunjungan = new RIInfopasienmasukkamarV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['RIInfopasienmasukkamarV'])) {
        $modDialogKunjungan->attributes = $_GET['RIInfopasienmasukkamarV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pasienadmisi_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                   // 'no_pendaftaran',
                    array(
                        'name'=>'tgladmisi',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgladmisi)',
                        'filter'=> false,
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::dropDownList('RIInfopasienmasukkamarV[jeniskelamin]', $modDialogKunjungan->jeniskelamin, LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    //'instalasi_nama',
                  //  'ruangan_nama',
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::dropDownList('RIInfopasienmasukkamarV[carabayar_id]', $modDialogKunjungan->carabayar_id, CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --')),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
}else{
    $modDialogKunjungan = new InfokunjunganpersalinanV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $format = new MyFormatter();
    $modKunjungan2 = clone $modDialogKunjungan;
    $modKunjungan2->tgl_pendaftaran = date('d/m/Y') . ' - ' . date('d/m/Y');
    $tanggal1 = explode(" - ",$modKunjungan2->tgl_pendaftaran);
    $modDialogKunjungan->tgl_awal = MyFormatter::formatDateTimeForDb(trim($tanggal1[0]));
    $modDialogKunjungan->tgl_akhir = MyFormatter::formatDateTimeForDb(trim($tanggal1[1]));
        
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if(isset($_GET['InfokunjunganpersalinanV'])) {
        $modDialogKunjungan->attributes = $_GET['InfokunjunganpersalinanV'];
        $tanggal = explode(" - ",$_GET['InfokunjunganpersalinanV']['tgl_pendaftaran'] );
        $modDialogKunjungan->tgl_awal = MyFormatter::formatDateTimeForDb(trim($tanggal[0]));
        $modDialogKunjungan->tgl_akhir = MyFormatter::formatDateTimeForDb(trim($tanggal[1]));
        $modKunjungan2->tgl_pendaftaran = $_GET['InfokunjunganpersalinanV']['tgl_pendaftaran'];
   }

    $dropPenjamin = array();
    $cri = new CDbCriteria();
    if (!empty($modDialogKunjungan->carabayar_id)){
        $cri->addCondition("carabayar_id = '".$modDialogKunjungan->carabayar_id."' ");
        $dropPenjamin = Chtml::listData(PenjaminpasienM::model()->findAll($cri),'penjamin_id','penjamin_nama');
    }
    
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        /*'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan(!empty($data->pasienadmisi_id, $data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',*/
                         'value'=> function ($data){
                            return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan(".(!empty($data->pasienadmisi_id)?$data->pasienadmisi_id:"''")." , ".$data->pendaftaran_id.");
                                            $(\"#dialogKunjungan\").dialog(\"close\");"));
                         }
                    ),
                    array(
                        'header' => 'No. Pendaftaran',
                        'name' => 'no_pendaftaran',
                        'value' => '$data->no_pendaftaran',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
                    ),
                   // 'no_pendaftaran',
                    array(
                        'header' => 'Tanggal Pendaftaran',
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=>CHtml::activeTextField($modKunjungan2, 'tgl_pendaftaran', array('style' => 'text-align:center','readonly'=>true)),
                        
                    ),        
                     array(
                        'header'=>'Tanggal Admisi',
                        'type'=>'raw',
                        'value'=>function($data){
                            $a = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                            
                            if (!empty($a)){
                                return MyFormatter::formatDateTimeForUser($a->tgladmisi);
                            }else{
                                return '-';
                            }
                            
                        },
                        'filter'=> false,
                    ),
                    array(
                        'header' => 'No. Rekam Medik',
                        'name' => 'no_rekam_medik',
                        'value' => '$data->no_rekam_medik',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'no_rekam_medik', array('class' => 'numbers-only'))
                    ),                    
                    array(
                        'header' => 'Nama Pasien',
                        'name' => 'nama_pasien',
                        'value' => '$data->nama_pasien',
                        'filter' => Chtml::activeTextField($modDialogKunjungan, 'nama_pasien', array('class' => 'hurufs-only'))
                    ),                                        
                    array(
                        'header'=>'jenis Kelamin',
                        'name' => 'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    //'instalasi_nama',
                  //  'ruangan_nama',
                    array(
                        'name'=>'carabayar_id',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header' => 'Penjamin',
                        'value'=>'$data->penjamin_nama',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan, 'penjamin_id', $dropPenjamin,array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header' => 'Status Periksa',
                        'name' => 'statusperiksa',
                        'filter'=> CHtml::activeDropDownList($modDialogKunjungan, 'statusperiksa', LookupM::model()->getItems('statusperiksa'),array('empty'=>'-- Pilih --')),
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                                . '$(".angkahuruf-only").keyup(function(){'
                                . 'setAngkaHurufsOnly(this);});'
                                . '$(".numbers-only").keyup(function(){'
                                . 'setNumbersOnly(this);});'
                                . '$(".hurufs-only").keyup(function(){'
                                . 'setHurufsOnly(this);});'
                                . 'setPickerRangeTanggal();'
                                . '}',
    ));
}
$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script type="text/javascript">
    $(document).ready(function(){
        setPickerRangeTanggal();
    });
    
function setPickerRangeTanggal() {
    $('input[name="InfokunjunganpersalinanV[tgl_pendaftaran]"]').daterangepicker({
        "maxDate": "<?php echo date('m/d/Y') ?>",
        "format": "DD/MM/YYYY",
        "applyClass": "btn-primary btn_pendaftaran_apply",
        "showDropdowns": true,
    });
    
    $(".btn_pendaftaran_apply").on("click", function() {
        setTimeout(function() {
            $.fn.yiiGridView.update("datakunjungan-grid", {data: $("#datakunjungan-grid :input").serialize()});
        }, 100);
    });
}
</script>