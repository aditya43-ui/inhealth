<div class="row">
	<div class="col-sm-6">
	   <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pembersihan', 'tglpembersihan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPembersihan,
                                'attribute' => 'tgl_pembersihan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('class'=>'span3','readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
            </div>
               
	</div>
        </div>
	<div class="col-sm-6">
            <div class="control-group">
			<?php // echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label')); ?>
			<?php echo CHtml::label('Pegawai Pembersihan <span class="required">*</span>', 'Pegawai Pembersihan', array('class'=>'control-label required')) ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPembersihan, 'petugaspemb_id',array('readonly'=>true)); ?>
				<?php
                
                $petugaspemb_nama = "";
                if (!empty($modPembersihan->petugaspemb_id)) {
                    $peg = PegawaiM::model()->findByPk($modPembersihan->petugaspemb_id);
                    $petugaspemb_nama = $peg->nama_pegawai;
                }
                
				$this->widget('MyJuiAutoComplete', array(
					'name' => 'petugaspemb_nama',
                    'value'=>$petugaspemb_nama,
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($modPembersihan, 'petugaspemb_id') . '").val(ui.item.pegawai_id); 
                            $("#STPembersihanT_siklusmesin").blur();
							return false;
						}',
					),
					'htmlOptions' => array(
                                                'placeholder'=>'Nama Petugas Pembersih',
						'class'=>'span3 ',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiPembersih'),
				));
				?>
			</div>
		</div>
        </div>
<table class="items table table-striped table-condensed" id="tblDekontaminasi">
    <thead>
        <tr>
            <th>Tgl. Dekontaminasi</th>
            <th>no. Dekontaminasi</th>
            <th>Nama Peralatan</th>
	    <th>Jumlah</th>
            <th>Bahan</th>
            <th>Lama</th>
            <th>Status Dekontaminasi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($modDekontaminasiDetail as $dataDekontiminasi) { ?>
        <?php $Dekontaminasi = DekontaminasiT::model()->findByPk($dataDekontiminasi->dekontaminasi_id); ?>
        <?php 
            $modPenerimaansterilisasidetT = PenerimaansterilisasidetT::model()->findByPk($dataDekontiminasi->penerimaansterilisasidet_id);
            $modPeralatansterilisasi = null;
            if (!empty($modPenerimaansterilisasidetT)) {
                $modPeralatansterilisasi = PeralatansterilisasiM::model()->findByPk($modPenerimaansterilisasidetT->peralatansterilisasi_id);
            }
            
            if (empty($modPeralatansterilisasi)) {
                $modPeralatansterilisasi = new PeralatansterilisasiM;
            }
        ?>
        <tr>
             <td><?php echo $format->formatDateTimeForDb($Dekontaminasi->dekontaminasi_tgl); ?></td>
             <td><?php echo $Dekontaminasi->dekontaminasi_no; ?></td>
             <td><?php echo $modPeralatansterilisasi->peralatansterilisasi_nama?></td>
             <td><?php echo $dataDekontiminasi->dekontaminasidetail_jml;?></td>
             <td></td>
             <td><?php echo $dataDekontiminasi->dekontaminasidetail_lama;?></td>
             <td><?php echo $dataDekontiminasi->dekontaminasidetail_ket;?></td>
        </tr>
     <?php } ?>
    </tbody>
</table>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Status Proses','status',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPembersihan, 'statusproses', LookupM::getItems("statusproses"),array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPembersihan,'namamesin_id',array('class'=>'control-label required', 'label'=>'Mesin <span class="required">*</span>')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modPembersihan,'namamesin_id', CHtml::listData(BarangM::model()->findAllByAttributes(array('barang_aktif'=>true,'jenisbarang_id'=>44)), 
                'barang_id', 'barang_nama'),array('class'=>'span3','empty' => '-- Pilih --', 'class'=>'required')); ?>
            </div>
        </div>
         
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($modPembersihan, 'siklusmesin', array('class' => 'control-label', 'label'=>'Siklus Mesin')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPembersihan, 'siklusmesin', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo  $form->labelEx($modPembersihan, 'programpembersihan', array('class' => 'control-label', 'label'=>'Program')) ?>
            <div class="controls">
                <?php
                echo $form->textField($modPembersihan, 'programpembersihan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
    
    
</div>

    
    <?php 
//========= Dialog buat cari data Pegawai Pembersih =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPembersih',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>400,
        'zIndex'=>1002,
        'resizable'=>true,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
        'dataProvider'=>$modPegawaiMengetahui->search(),
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                $(\"#'.CHtml::activeId($modPembersihan,'petugaspemb_id').'\").val(\"$data->pegawai_id\");
                                                $(\"#petugaspemb_nama\").val(\"$data->NamaLengkap\");
                                                $(\"#STPembersihanT_siklusmesin\").blur();
                                                $(\"#dialogPegawaiPembersih\").dialog(\"close\"); 
                                                return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
					'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Jabatan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'jabatan_id'),
                    'value'=>'$data->getNamaJabatan($data->jabatan_id)',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Pegawai Pembersih dialog =============================
?>