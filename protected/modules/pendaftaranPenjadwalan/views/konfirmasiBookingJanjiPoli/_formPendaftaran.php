<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly'=>true,'class'=>'span3')); ?>
<?php echo $form->hiddenField($model, 'buatjanjipoli_id', array('readonly'=>true,'class'=>'span3')); ?>
<div class="col-sm-6">
        <?php 
            echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime form-control', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class='control-group'>
            <?php echo CHtml::label("Poliklinik <span class='required'>*</span>", CHtml::activeId($model,'ruangan_id'),array('class'=>'control-label required'))?>                                   
            <div class='controls'>
                <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama') ,
                                      array('empty'=>'-- Pilih --',
                                    'onchange'=>"setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan();getRuanganPoliklinikPasien();",
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                    //'ajax'=>array(
                                    //      'type'=>'POST',
                                    //      'url'=>$this->createUrl('SetDropdownKelasPelayanan',array('encode'=>false,'namaModel'=>get_class($model))),
                                    //      'update'=>'#'.CHtml::activeId($model, 'kelaspelayanan_id')),
                                    )); ?>  
                <div class="checkbox inline" hidden>
                    <?php // echo $form->checkBox($model,'kunjunganrumah', array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
                </div><?php // echo CHtml::textField('max-antrian-ruangan',0, array('class'=>'','rel'=>'tooltip','title'=>'Maksimum Antrian Ruangan','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;',)); ?>
            </div>
        </div>
        
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
                            Dokter <span class="required">*</span>
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
                <?php echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 form-control2')); ?>
                <?php // echo CHtml::textField('max-antrian-dokter',0, array('class'=>'','rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:40px;','value'=>0)); ?>
            </div>
        </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->labelEx($model,'carabayar_id', array('class'=>'control-label refreshable')) ?>
        <div class="controls">
                <?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'ajax' => array('type'=>'POST',
                                                'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
    //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                                                'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); setKarcis(); cekPilihSatu($("#'.CHtml::activeId($model,"penjamin_id").'")); setKelasTanggunganDrop();}',
                                            ),
                                            'onchange'=>'setFormAsuransi(this.value);',
                                            'class'=>'span3 form-control ',
                )); ?>
        </div>
    </div>

    <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --',
                                                                        'onchange'=>'setKarcis(); setNamaAsuransiDariPenjamin(this); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);',
                                                                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                                        'class'=>'span3 form-control'
                                )); ?>
    <?php // echo $form->textAreaRow($model,'keterangan_pendaftaran',array('placeholder'=>'Catatan Khusus Pendaftaran','rows'=>2, 'cols'=>50, 'class'=>'span3 form-control autogrow','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
						'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
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
