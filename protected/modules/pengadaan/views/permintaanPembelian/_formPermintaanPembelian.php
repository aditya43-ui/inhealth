<div class = "col-sm-6">
    <?php echo CHtml::hiddenField('supplier_id',"", array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo CHtml::hiddenField('permintaanpembelian_id',$modPermintaanPembelian->permintaanpembelian_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    
    <?php if(isset($_GET['sukses'])){ ?> 
    <?php if(!empty($modPermintaanPembelian->rencanakebfarmasi_id)){ ?>
		<?php echo $form->hiddenField($modPermintaanPembelian,'rencanakebfarmasi_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php $this->widget('MyDateTimePicker',array(
				'model'=>$modRencanaKebFarmasi,
				'attribute'=>'tglperencanaan',
				'mode'=>'datetime',
				'options'=> array(
					'dateFormat'=>PARAMS::DATE_FORMAT,
					'maxDate'=>'d',
				),
				'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)"
				),
			)); ?>
		</div>    
    <?php } ?>
    
    <?php }else if(isset($_GET['rencana_id'])){ ?>
		<?php echo $form->textFieldRow($modRencanaKebFarmasi,'noperencnaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->hiddenField($modPermintaanPembelian,'rencanakebfarmasi_id',array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
		<?php echo $form->labelEx($modRencanaKebFarmasi,'tglperencanaan', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php $this->widget('MyDateTimePicker',array(
				'model'=>$modRencanaKebFarmasi,
				'attribute'=>'tglperencanaan',
				'mode'=>'datetime',
				'options'=> array(
					'dateFormat'=>PARAMS::DATE_FORMAT,
					'maxDate'=>'d',
				),
				'htmlOptions'=>array(
                                    'readonly'=>true,
                                    'class'=>'dtPicker3 isRequired span3', 
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
				),
            )); ?>
        </div>
    <?php } ?>
    <?php if(isset($_GET['penawaran_id'])){ ?>
    <?php echo $form->hiddenField($modPermintaanPembelian,'permintaanpenawaran_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPermintaanPenawaran,'nosuratpenawaran',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPenawaran,'tglpenawaran', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                    $modPermintaanPenawaran->tglpenawaran = (!empty($modPermintaanPenawaran->tglpenawaran) ? date("d/m/Y H:i:s",strtotime($modPermintaanPenawaran->tglpenawaran)) : null);
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$modPermintaanPenawaran,
                        'attribute'=>'tglpenawaran',
                        'mode'=>'datetime',
                        'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                        ),
                        'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                        ),
                )); ?>
        </div>
    </div>
    <?php } ?>  
        <div class="control-group ">
            <?php echo CHtml::label('Permintaan Penawaran', 'permintaanpenawaran', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($modPermintaanPembelian,'permintaanpenawaran_id',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPermintaanPembelian,
                    'attribute'=>'nosuratpenawaran',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('AutocompletePermintaanPenawaran').'",
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
                           'showAnim'=>'fold',
                           'minLength' => 2,
                           'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                           'select'=>'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#ADPermintaanpembelianT_permintaanpenawaran_id").val(ui.item.permintaanpenawaran_id);
                                $("#ADPermintaanpembelianT_nosuratpenawaran").val(ui.item.nosuratpenawaran);
                                return false;
                            }',
                    ),
                    'htmlOptions'=>array(
                        'class' => 'span3 custom-only',
                        'placeholder'=>'Pilih Permintaan Penawaran',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#ADPermintaanpembelianT_permintaanpenawaran_id").val(""); '
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogPermintaanPenawaran'),
                )); 
                ?>
            </div>
        </div>
	<?php echo $form->textFieldRow($modPermintaanPembelian,'nopermintaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
	<div class="control-group ">
		<?php echo $form->labelEx($modPermintaanPembelian,'tglpermintaanpembelian', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php   
				//$modPermintaanPembelian->tglpermintaanpembelian = (!empty($modPermintaanPembelian->tglpermintaanpembelian) ? date("d/m/Y H:i:s",strtotime($modPermintaanPembelian->tglpermintaanpembelian)) : null);
				$modPermintaanPembelian->tglpermintaanpembelian = (!empty($modPermintaanPembelian->tglpermintaanpembelian) ? MyFormatter::formatDateTimeforUser(date("d-m-Y H:i:s",strtotime($modPermintaanPembelian->tglpermintaanpembelian))) : null);
				$this->widget('MyDateTimePicker',array(
					'model'=>$modPermintaanPembelian,
					'attribute'=>'tglpermintaanpembelian',
					'mode'=>'datetime',
					'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
						'showOn' => false,
						'maxDate' => 'd',
						'yearRange'=> "-150:+0",
					),
					'htmlOptions'=>array(
                                            //'placeholder'=>'00/00/0000 00:00:00',
                                            //'class'=>'span3 dtPicker2 datetimemask',
                                            'class'=>'span3 dtPicker2',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)"
					),
			)); ?>
		</div>
	</div>  
	<?php echo $form->dropDownListRow($modPermintaanPembelian,'supplier_id',
		CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
		array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
		'empty'=>'-- Pilih --')); ?>   
	<?php echo $form->dropDownListRow($modPermintaanPembelian,'syaratbayar_id',
		CHtml::listData($modPermintaanPembelian->SyaratBayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
		array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
		'empty'=>'-- Pilih --',)); ?>
</div>
<div class = "col-sm-6">
    <?php echo $form->textAreaRow($modPermintaanPembelian,'keteranganpermintaan',array('placeholder'=>'Ket. Permintaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

    <?php echo $form->textAreaRow($modPermintaanPembelian,'alamatpengiriman',array('placeholder'=>'Alamat Pengirim','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<!--    <div class="control-group ">
        <?php // echo $form->labelEx($modPermintaanPembelian,'statuspembelian', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($modPermintaanPembelian,'statuspembelian',LookupM::getItems('statuspembelian'),array('empty'=>'--Pilih--','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
    </div>-->
</div>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new ADPegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['ADPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['ADPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$modPegawaiMengetahui->searchMengetahui(),
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  $(\"#ADPermintaanpembelianT_keteranganpermintaan\").blur();
                                                  return false;
                                        "))',
                ),
                 array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                 array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                    'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Menyetujui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new ADPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['ADPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['ADPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->searchMenyetujui(),
	'filter'=>$modPegawaiMenyetujui,
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
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  $(\"#ADPermintaanpembelianT_keteranganpermintaan\").blur();
                                                  return false;
                                        "))',
                ),
                 array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                 array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                   // 'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                     'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);                                
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>

<?php
//========= Dialog buat cari data Permintaan Penawaran =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPermintaanPenawaran',
    'options'=>array(
        'title'=>'Permintaan Penawaran',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>650,
        'resizable'=>false,
    ),
));
$modPenawaran = new ADPermintaanPenawaranT('search');
$modPenawaran->unsetAttributes();
if(isset($_GET['ADPermintaanPenawaranT'])){
    $modPenawaran->attributes = $_GET['ADPermintaanPenawaranT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rencanakebutuhan-m-grid',
	'dataProvider'=>$modPenawaran->search(),
	'filter'=>$modPenawaran,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#ADPermintaanpembelianT_permintaanpenawaran_id\').val($data->permintaanpenawaran_id);
                                        $(\'#ADPermintaanpembelianT_nosuratpenawaran\').val(\'$data->nosuratpenawaran\');
                                        $(\'#dialogPermintaanPenawaran\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'No Permintaan Penawaran',
                    'name'=>'nosuratpenawaran',
                    'type'=>'raw',
                    'value'=>'$data->nosuratpenawaran',
                    'filter' => CHtml::activeTextField($modPenawaran,'nosuratpenawaran', array())
                ),
                array(
                    'header'=>'Tanggal Permintaan Penawaran',
                    'name' => 'tglpenawaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenawaran)',
                    'filter' => false,
                ), 
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".custom-only").keyup(function(){setCustomOnly(this);});'
    . '}',
)); 

$this->endWidget();
?>