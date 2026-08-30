<fieldset id="fieldsetpph21" class="">
        <div class="control-group">
            <?php echo CHtml::label('GAJI POKOK', 'gajipokok', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'gajipokok',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 / Bulan
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('TUNJANGAN LAINNYA, UANG LEMBUR, DAN SEBAGAINYA', 'tunjangantetap', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'tunjangantetap',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 / Bulan
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('HONORARIUM DAN IMBALAN LAIN SEJENISNYA', 'tunjangantetap', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'honorarium',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 / Bulan
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('PREMI ASURANSI YANG DIBAYAR PEMBERI KERJA', 'premiasuransi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'premiasuransi',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                 / Bulan
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label(' PENERIMAAN DALAM BENTUK NATURA', '', array('class' => 'control-label', 'data-toggle'=>'tooltip', 'title'=>'PENERIMAAN DALAM BENTUK NATURA DAN KENIKMATAN LAINNYA YANG DIKENAKAN PEMOTONGAN PPh PASAL 21')) ?>
            <div class="controls">
                <?php echo CHtml::textField('tunjanganmakan','0',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
		<?php echo CHtml::label('TANTIEM, BONUS, GRATIFIKASI, JASA PRODUKSI DAN THR', '', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo CHtml::textField('tunjangantransportasi','0',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('JUMLAH PENGHASILAN BRUTO', 'gajipph', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'gajipph',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->hiddenField($model,'persentasepph21',array('class'=>'inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->hiddenField($model,'kodeptkp',array('class'=>'inputFormTabel', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Bulan
		</div>
	</div>
    <div class="panel panel-darkk" style="margin-top: 30px;">
       <span class="group-title">
        Pengurangan
        </span>
        <div class="panel-body">
            <div class="control-group peg_tetap">
                <?php echo CHtml::label('BIAYA JABATAN (5%)', 'biayajabatan', array('class' => 'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'biayajabatan',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        Maks. 500.000 / Bulan
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('IURAN PENSIUN ATAU IURAN THT/JHT', 'iuranpensiun', array('class' => 
                    'control-label', 
                    'data-toggle'=>'tooltip',
                    'title'=>'Pensiun(1%) + JHT(2%)'
                 )) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'iuranpensiun',array(
                        'class'=>'span2 inputFormTabel integer2', 
                        'readonly'=>true, 
                        'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?> Maks. 200.000 / Bulan
                </div>
            </div>

            <?php /*
            <div class="control-group">
                    <?php echo CHtml::label('JAMINAN PENSIUN', 'jaminanpensiun', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'jaminanpensiun',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                             / Bulan
                    </div>
            </div>
            <div class="control-group peg_tetap">
                    <?php echo CHtml::label('BPJS KESEHATAN', 'bpjskesehatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'bpjskesehatan',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                             / Bulan
                    </div>
            </div>
             * 
             */ ?>
        </div>
   </div>
	
    
	<div class="control-group">
		<?php echo CHtml::label('JUMLAH PENGHASILAN NETO', 'Netto', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'penerimaanpph',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Bulan
		</div>
    </div>
	<div class="control-group">
		<?php echo CHtml::label('JUMLAH PENGHASILAN NETO MASA SEBELUMNYA', 'Netto', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'netto_masasebelumnya',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onblur'=>'hitungGaji();')); ?>
			/ Bulan
		</div>
    </div>
	<div class="control-group">
		<?php echo CHtml::label('JUMLAH PENGHASILAN NETO DISETAHUNKAN', 'Netto', array('class' => 'control-label', 'data-toggle'=>'tooltip', 'title'=>'JUMLAH PENGHASILAN NETO UNTUK PERHITUNGAN PPh PASAL 21(SETAHUN/DISETAHUNKAN)')) ?>
		<div class="controls">
			<?php echo CHtml::textField('netto_tahun', 0, array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PTKP', 'ptkp', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'ptkp',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        / Tahun
		</div>
	</div>
	<div class="control-group">
                <?php echo CHtml::label('PKP', 'pkp', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pkp',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::hiddenField('pphpersenkomponen','', array('class' => 'span3', 'readonly'=>TRUE)); ?>
                        <?php echo CHtml::hiddenField('pphpersen21komponen','', array('class' => 'span3', 'readonly'=>TRUE)); ?>
            / Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PPh PASAL 21 ATAS PKP DISETAHUNKAN', 'PPh', array('title'=>'5% (0 sampai 50 juta) <br> 15% (>50juta - 250 juta) <br> 25% (>250juta - 500 juta) <br> 30% (>500 juta)', "data-toggle"=>"tooltip", "data-placement"=>"top", 'class' => 'control-label', 'id'=>'label_persen')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pphpersen',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PPh PASAL 21 YANG TELAH DIPOTONG MASA SEBELUMNYA', 'PPh', array("data-placement"=>"top", 'class' => 'control-label', 'id'=>'label_dipotong')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21dipotong',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PPh PASAL 21 TERUTANG', 'PPh', array("data-placement"=>"top", 'class' => 'control-label', 'id'=>'label_terutang')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21terutang',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PPh PASAL 21 DAN PPh PASAL 26 YANG TELAH DIPOTONG DAN DILUNASI', 'PPh', array("data-placement"=>"top", 'class' => 'control-label', 'id'=>'label_dilunasi')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21telahdipotong',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Tahun
		</div>
	</div>
	<div class="control-group">
		<?php echo CHtml::label('PPh PASAL 21 PERBULAN TERUTANG', 'pph21', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($model,'pph21',array('class'=>'span2 inputFormTabel integer2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			/ Bulan
		</div>
	</div>
    
    <div class="control-group">
        <?php echo CHtml::label('Pegawai Pemotong', 'pemotong_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pemotong_id', array('readonly' => true)) ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'pemotong',
                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 4,
                    'focus' => 'js:function( event, ui ) {
				$("#' . CHtml::activeId($model, 'pemotong') . '").val(ui.item.nama_pegawai);
				return false;
			}',
                    'select' => 'js:function( event, ui ) {
			$("#' . CHtml::activeId($model, 'pemotong') . '").val(ui.item.nama_pegawai);
                        $("#' . CHtml::activeId($model, 'pemotong_id') . '").val(ui.item.pegawai_id);     
			return false;
                    }',
                ),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                'tombolDialog' => array('idDialog' => 'dialogPemotong', 'idTombol' => 'tombolPasienDialog'),
            ));
            ?>
        </div>
    </div>
    
</fieldset>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemotong',
    'options' => array(
        'title' => 'Pegawai Pemotong PPh',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipemotong-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'pemotong') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'pemotong_id') . '\").val(\"$data->pegawai_id\");    
                                                      $(\"#dialogPemotong\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP'  ,
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
//            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only', 'disabled'=>false))
        ),
        array(
            'header' => 'Nama Pegawai'  ,
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
//            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),        
        array(
            'header' => 'Jabatan'  ,
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),  
        //'tempatlahir_pegawai',
        //'tgl_lahirpegawai',
        //'jeniskelamin',
        //'statusperkawinan',        
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    .' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
    . '}',
));

$this->endWidget();
?>

<script type="text/javascript">
	function setPtkp(pegawai_id){
        $.ajax({
	        type:'POST',
	        url:'<?php echo $this->createUrl('SetPtkpNew'); ?>',
	        data: { pegawai_id: pegawai_id},
	        dataType: "json",
	        success:function(data){
	            if(data.status="ada"){
	                $('#<?php echo CHtml::activeId($model,"ptkp") ?>').val(formatNumber(data.ptkp));
                    hitungpph();
	            }
	        },
	        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    });
    }
    
   $(document).ready(function(){
        $('#pegawaipemotong-m-grid').find("input[type=text]").each(function(){
            $(this).removeAttr('disabled');
        }); 
        $('#pegawaipemotong-m-grid').find("select").each(function(){
            $(this).removeAttr('disabled');
        });
   });
</script>
