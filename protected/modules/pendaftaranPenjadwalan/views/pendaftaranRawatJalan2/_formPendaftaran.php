<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($model, 'buatjanjipoli_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class="col-sm-6">
    <div class="box2">
        <?php 
            echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        <div class='control-group'>
            <?php echo CHtml::label("Instalasi <span class='required'>*</span>", CHtml::activeId($model,'instalasi_id'),array('class'=>'control-label required'))?>                                   
            <div class='controls'>
                <?php echo $form->dropDownList($model,'instalasi_id', CHtml::listData($model->getInstalasiRJ(), 'instalasi_id', 'instalasi_nama') ,
                    array('empty'=>'-- Pilih --',
                  'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                  'ajax'=>array(
                        'type'=>'POST',
                        'url'=>$this->createUrl('SetDropdownRuanganRJ',array('encode'=>false,'namaModel'=>get_class($model))),
                        'update'=>'#'.CHtml::activeId($model, 'ruangan_id')),
                  )); ?>  
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label("Poliklinik <span class='required'>*</span>", CHtml::activeId($model,'ruangan_id'),array('class'=>'control-label required'))?>                                   
            <div class='controls'>
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganRJ(), 'ruangan_id', 'ruangan_nama') ,
                                      array('empty'=>'-- Pilih --',
                                    'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan();getRuanganPoliklinikPasien();",
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                    )); ?>  
                <div class="checkbox inline">
                    <i class="entypo-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                    <?php echo $form->checkBox($model,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                </div><?php echo CHtml::textField('max-antrian-ruangan',0, array('class'=>'','rel'=>'tooltip','title'=>'Maksimum Antrian Ruangan','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
            </div>
        </div>
        <?php
        echo CHtml::hiddenField('jam_awal').CHtml::hiddenField('jam_tutup').
                CHtml::hiddenField("nama_ruangan").CHtml::hiddenField('jam_awal_a').CHtml::hiddenField('jam_tutup_a');
        echo $form->dropDownListRow($model,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 form-control2', 'empty'=>'-- Pilih --')); ?>
        <span hidden>
		<?php 
			if (empty($model->buatjanjipoli_id)){
				echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis()", 'class'=>'span3 form-control2')); 
			}else{
				echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis()", 'class'=>'span3 form-control2')); 
			}
		?>
		</span>
        <div class="control-group">
                    <label for="PPPendaftaranT_pegawai_id" class="control-label required">
                            DPJP <span class="required">*</span>
                            <?php echo
                            CHtml::link("<i class='entypo-calendar'></i>",
                                            'javascript:void(0)',
                                            array("rel"=>"tooltip",
                                                            "title"=>"Klik untuk Melihat Jadwal Dokter",
                                                            "onclick"=>"setRuanganJadwalDokter(); $('#jadwalDokter').dialog('open');return true;"
                                                    ));
                            ?>
                  </label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'pegawai_id', (!empty($model->ruangan_id))? CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap') : array() ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 form-control2')); ?>
                <?php echo CHtml::textField('max-antrian-dokter',0, array('class'=>'','rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;','value'=>0)); ?>
            </div>
        </div>
        <div class="control-group">
                <label for="PPPendaftaranT_ppjp_id" class="control-label">
                    PPJP
              </label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'ppjp_id', (!empty($model->ruangan_id))? CHtml::listData($model->getPPJPItems($model->ruangan_id), 'pegawai_id', 'namaLengkap') : array() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 form-control2')); ?>
            </div>
        </div>
            <div class="control-group">
                    <?php echo $form->labelEx($model,'carabayar_id', array('class'=>'control-label ')) ?>
                    <div class="controls">
                            <?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type'=>'POST',
                                                            'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                                            'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); setKarcis(); cekPilihSatu($("#'.CHtml::activeId($model,"penjamin_id").'")); setKelasTanggunganDrop();}',
                                                        ),
                                                        'onchange'=>'setFormAsuransi(this.value);',
                                                        'class'=>'span3 form-control ',
                            )); ?>
                    </div>
            </div>
        
        <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --',
                                                                                    'onchange'=>'setKarcis(); setNamaAsuransiDariPenjamin(this); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);setFormAsuransiInhealth(this.value);',
                                                                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                                    'class'=>'span3 form-control'
                                            )); ?>
        <div class="control-group cek_sep" style="display: none;">
            <?php echo CHtml::label('Briging SEP Langsung', '', array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->checkBox($model,'is_langsung_briging', array('onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Pilih jika akan create SEP saat pendaftaran','onclick'=>'setCreateSep(this);')); ?>
            </div>
        </div>
        <!--S-No Rujukan-->
        <div class="panel panel-success rujukan" style="display: none;" id="rujukan-nomor">
            <div class="control-group rujukan">
                <div class="control-label"><?php echo Chtml::label('Jenis Rujukan','jenis_rujukan',array('class'=>'control-label')); ?></div>
                <div class="controls form-inline">
                    <?php 
                    echo $form->radioButtonList($model,'jenis_rujukan',array("1"=>"PCare&nbsp;&nbsp;","2"=>"Rumah Sakit"), array('onkeyup'=>"return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group rujukan">
                <?php echo CHtml::label("No. Rujukan BPJS <span class='required'>*</span>", 'no_rujukan', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php echo $form->textField($model,'no_rujukan',array('placeholder'=>'No Rujukan BPJS','class'=>'span3 all-caps required norujukan', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>19, 'rel'=>'tooltip','title'=>'Masukan No. Rujukan BPJS Peserta')); ?>
                </div>
            </div>
            <div class="control-group rujukan">
                <?php echo CHtml::label("No. Kontrol", 'no_kontrol_bpjs', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php echo $form->textField($model,'no_kontrol_bpjs',array('placeholder'=>'No Kontrol','class'=>'span3 norujukan no_kontrol_bpjs', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6, 'rel'=>'tooltip','title'=>'Masukan Jika Pasien Ada No. Kontrol Poli')); ?>
                </div>
            </div>
        </div>
        <!--E-No Rujukan-->
            <?php echo $form->textAreaRow($model,'keterangan_pendaftaran',array('placeholder'=>'Catatan Khusus Pendaftaran','rows'=>2, 'cols'=>50, 'class'=>'span3 form-control autogrow','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<?php
    //=============================== Dialog Jadwal Dokter =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'jadwalDokter',
            'options'=>array(
                'title'=>'Jadwal Dokter Poliklinik' ,
                'autoOpen'=>false,
                'width' => 840,
				'height' => 420,
                'resizable' => true,
            ),
        )
    );
	
	$format = new MyFormatter();
	$modJadDok=new PPJadwaldokterM('search');
	$modJadDok->unsetAttributes();
	$modJadDok->jadwaldokter_hari = $format->getDayUser(date('w'));
	if(isset($_GET['PPJadwaldokterM'])){
		$modJadDok->attributes=$_GET['PPJadwaldokterM'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'rdjadwaldokter-m-grid',
		'dataProvider'=>$modJadDok->search(),
		'filter'=>$modJadDok,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectJadwalDokter",
								"onClick" => "
									setDokterJadwal(\"$data->pegawai_id\");

								"))',
			),
			array(
						'name'=>'pegawai_id',
						'filter'=>false,
						'value'=>'(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "")',
					),
			'jadwaldokter_hari',
			'jadwaldokter_buka',
		),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
			
    $this->endWidget('zii.widgets.jui.CJuiDialog');
	//=============================== END Dialog Jadwal Dokter =======================================
?>
