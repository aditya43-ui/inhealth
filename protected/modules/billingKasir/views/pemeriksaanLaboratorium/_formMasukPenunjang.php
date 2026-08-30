<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'tglmasukpenunjang', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $modPasienMasukPenunjang->tglmasukpenunjang = (!empty($modPasienMasukPenunjang->tglmasukpenunjang) ? date("d/m/Y H:i:s",strtotime($modPasienMasukPenunjang->tglmasukpenunjang)) : null);
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modPasienMasukPenunjang,
                            'attribute'=>'tglmasukpenunjang',
                            'mode'=>'datetime',
                            'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
//                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('class'=>'span3 dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modPasienMasukPenunjang, 'tglmasukpenunjang'); ?>
    </div>
</div>
<div class='control-group'>
    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modPasienMasukPenunjang,'ruangan_id'),array('class'=>'control-label required'))?>                                   
    <div class='controls'>
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'ruangan_id', CHtml::listData(BKPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_LAB), 'ruangan_id', 'ruangan_nama') ,
                              array('empty'=>'-- Pilih --',
                            'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);",
                            'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                            )); ?>  
    </div>
</div>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData(BKPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
<?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(BKPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanLab(); clearTabelPemeriksaan();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>

<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(BKPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
    </div>
</div>
<div class="control-group">
    <label class="control-label">Dokter Perujuk</label>
    <div class="controls">
    <?php 
    echo $form->hiddenField($modPasienMasukPenunjang, 'dokterperujuk', array('class'=>'dokterperujuk'));
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPasienMasukPenunjang,
                                'attribute'=>'dokter_perujuk',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('autocompleteDokter').'",
                                                   dataType: "json",
                                                   data: {
                                                       term: request.term,
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
                                            $(this).val( ui.item.label);
                                            $(".dokterperujuk").val( ui.item.value);
                                            return false;
                                        }',
                                ),
                                //'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('placeholder'=>'Ketik Dokter Perujuk','class'=>'span3 dokter_perujuk','rel'=>'tooltip','title'=>'Ketik dokter perujuk / klik icon untuk mencari data dokter perujuk',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
            ?>
    </div>
</div>
<?php //echo $form->textFieldRow($modPasienMasukPenunjang,'dokter_perujuk', array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>


<?php 
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
    $pegawai = new DokterV('searchByDokter');
    $pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['DokterV'])){
        $pegawai->attributes = $_GET['DokterV'];
        $pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftaran-t-grid',
            'dataProvider'=>$pegawai->search(),
            'filter'=>$pegawai,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
                                            $(\".dokter_perujuk\").val(\"$data->namaLengkap\");
                                            $(\".dokterperujuk\").val(\"$data->pegawai_id\");

                                        "))',
                    ),          
                    array(
                        'header' => 'NIP',
                        'name' => 'nomorindukpegawai',
                        'filter' => Chtml::activeTextField($pegawai, 'nomorindukpegawai',array('class'=>'numbers-only'))
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                        'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                        'filter' => Chtml::activeTextField($pegawai, 'nama_pegawai',array('class'=>'hurufs-only'))
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name' => 'jabatan_id',
                        'value' => function($data){
                            $j = JabatanM::model()->findByPk($data->jabatan_id);
                            
                            if (!empty($j)){
                                return $j->jabatan_nama;
                            }else{
                                return '-';
                            }
                        },
                        'filter' => Chtml::activeDropDownList($pegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),                        
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                                . '$(".numbers-only").keyup(function() {
                                    setNumbersOnly(this);
                                });
                                $(".angkahuruf-only").keyup(function() {
                                    setAngkaHuruOnly(this);
                                });'
                                . ''
                                . '}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>