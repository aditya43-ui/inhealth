<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span4')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id', array('readonly' => true, 'class' => 'span4')); ?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ruangan_id', array('readonly' => true, 'class' => 'span4')); ?>


<div class="control-group">
    <?php echo CHtml::label('Tgl. Pemeriksaan','tgl_tindakan', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php 
        // $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_tindakan);
        if(!empty($modPasienMasukPenunjang->tglrencanapemeriksaan) && date('Y-m-d H:i:s') < MyFormatter::formatDateTimeForDb($modPasienMasukPenunjang->tglrencanapemeriksaan)) {
            echo $form->textField($modPasienMasukPenunjang, 'tglmasukpenunjang', ['readonly' => true, 'class' => 'span4 tglrencanapemeriksaan']);
        } else {
            $this->widget('MyDateTimePicker',array(
                                'model' => $modPasienMasukPenunjang,
                                'attribute' => 'tglmasukpenunjang',
                                'mode'=>'datetime',
                                'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                                'htmlOptions'=>array('class'=>'span3 tglmasukpenunjang',
                                'onkeypress'=>"return $(this).focusNextInputField(event)"),
            )); 
        }
        ?>
    </div> 
</div> 
<?php
$jeniskp = LBPendaftaranT::model()->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id);
// echo $form->dropDownListRow($modPasienMasukPenunjang, 'jeniskasuspenyakit_id', CHtml::listData($jeniskp, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')); ?>
<?php // echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData(LBPendaftaranT::model()->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onchange'=>'setChecklistPemeriksaanLab();setTindakanPemeriksaanReset();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span4')); 
?>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'kelaspelayanan_id'); ?>
<div class="control-group">
    <?php 
        if(empty($modPasienMasukPenunjang->pegawai_id)) {
            // var_dump(Yii::app()->user->getState('pegawai_id'));
            $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if(!empty($modPegawai)) {
                if($modPegawai->kelompokpegawai_id === 1) {
                    $modPasienMasukPenunjang->pegawai_id = $modPegawai->pegawai_id;
                    $modPasienMasukPenunjang->pegawai_nama = $modPegawai->NamaLengkap;
                }
            }
        }
    ?>
    <?php

        $instalasi = Yii::app()->user->getState('instalasi_id');            

        if($instalasi == Params::INSTALASI_ID_LAB) {
            echo CHtml::label("Dokter MOD <span class='required'>*</span>", 'pegawai_id', array('class' => 'control-label'));
        } else {
            echo $form->labelEx($modPasienMasukPenunjang, 'pegawai_id', array('class' => 'control-label required', 'label' => 'Dokter Pemeriksa<span class="required">*</span>'));
        }
    ?>
    <div class="controls">
        <?php
        //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); 
        echo $form->hiddenField($modPasienMasukPenunjang, 'pegawai_id', array('readonly' => true, 'class' => 'required'));

        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'pegawai_nama',
            'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . $this->createUrl('/ActionAutoComplete/dropDokterRuangan') . '",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
					},
					success: function (data) {
						response(data);
					}
				})
			}',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 0,
                'focus' => 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
                'select' => 'js:function( event, ui ) {
					 $("#' . CHtml::ActiveId($modPasienMasukPenunjang, 'pegawai_id') . '").val(ui.item.value); 
					 return false;
				 }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Dokter',
                'class' => 'span4 required',

            ),
            'tombolDialog' => array('idDialog' => 'dialogDokter'),
        ));
        ?>
    </div>
</div>
<?php echo $form->hiddenField($modPasienMasukPenunjang, 'ppds_id'); ?>
<div class="control-group">
    <?php echo $form->labelEx($modPasienMasukPenunjang, 'ppds_id', array('class' => 'control-label ', 'label' => 'PPDS')); ?>
    <div class="controls">
        <?php
        //echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData(LBPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'namaLengkap') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); 
        echo $form->hiddenField($modPasienMasukPenunjang, 'ppds_id', array('readonly' => true));
        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'ppds_nama',
            'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . $this->createUrl('/ActionAutoComplete/dropPPDS') . '",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
					},
					success: function (data) {
						response(data);
					}
				})
			}',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 0,
                'focus' => 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
                'select' => 'js:function( event, ui ) {
					 $("#' . CHtml::ActiveId($modPasienMasukPenunjang, 'ppds_id') . '").val(ui.item.value); 
					 return false;
				 }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'PPDS',
                'class' => 'span4',

            ),
            'tombolDialog' => array('idDialog' => 'dialogPPDS'),
        ));
        ?>
  
  </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('Analis', 'perawat_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php

        echo $form->hiddenField($modPasienMasukPenunjang, 'perawat_id', array('readonly' => true));

        $this->widget('MyJuiAutoComplete', array(
            'model' => $modPasienMasukPenunjang,
            'attribute' => 'perawat_nama',
            'source' => 'js: function(request, response) {
					$.ajax({
					url: "' . $this->createUrl('/ActionAutoComplete/dropPerawatRuangan') . '",
					dataType: "json",
					data: {
						term: request.term,
						ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
					},
					success: function (data) {
						response(data);
					}
				})
			}',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 0,
                'focus' => 'js:function( event, ui ) {
					 $(this).val( ui.item.label);
					 return false;
				 }',
                'select' => 'js:function( event, ui ) {
					 $("#' . CHtml::ActiveId($modPasienMasukPenunjang, 'perawat_id') . '").val(ui.item.value); 
					 return false;
				 }',
            ),
            'htmlOptions' => array(
                'placeholder' => 'Analis',
                'class' => 'span4',

            ),
            'tombolDialog' => array('idDialog' => 'dialogPerawat'),
        ));
        ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPPDS',
    'options' => array(
        'title' => 'PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPPDS = new PpdsM('search');
$modPPDS->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPPDS->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPPDS->search(),
    'filter' => $modPPDS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPPDS",
                "onClick"=>"                            
                            $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'ppds_nama') . '\").val(\"$data->ppds_nama\");                            
                            $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'ppds_id') . '\").val(\"$data->ppds_id\");                            
                            $(\"#dialogPPDS\").dialog(\"close\");
                            return false;"
                ))'
        ),

        //'gelardepan',
        array(
            'header' => 'NAMA PPDS',
            'value' => '$data->ppds_nama',
            'name' => '$data->ppds_nama',
            'filter' => Chtml::activeTextField($modPPDS, 'ppds_nama', array('class' => 'numbers-only')),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
        . '}',
));

$this->endWidget();
?>






<?php
    $this->renderPartial('_dialogDaftarPencarianDokter', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
?>


<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPerawat',
        'options' => array(
            'title' => 'Daftar Analis',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    )
);
$modPerawat = new PegawairuanganV();
$modPerawat->unsetAttributes();
$modPerawat->pegawai_aktif = true;
// $modPerawat->ruangan_id = Yii::app()->user->getState('ruangan_id');


if (isset($_GET['PegawairuanganV'])) {
    $modPerawat->attributes = $_GET['PegawairuanganV'];
}

$prov_ppa = $modPerawat->searchAnalisLab();
$prov_ppa->sort->defaultOrder = 'nama_pegawai';

$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'perawatppa-grid',
        'dataProvider' => $prov_ppa,
        'filter' => $modPerawat,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                    "id"=>"selectPegawai",
                    "onClick"=>"                            
                                $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'perawat_nama') . '\").val(\"$data->namaLengkap\");                            
                                $(\"#' . CHtml::activeId($modPasienMasukPenunjang, 'perawat_id') . '\").val(\"$data->pegawai_id\");                            
                                $(\"#dialogPerawat\").dialog(\"close\");
                                return false;"
                    ))'
            ),
            array(
                'header' => 'NIP',
                'value' => '$data->nomorindukpegawai',
                'name' => 'nomorindukpegawai',
                'filter' => Chtml::activeTextField($modPerawat, 'nomorindukpegawai', array('class' => 'numbers-only')),
            ),
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function ($data) {
                    if (empty($data->jabatan_id))
                        return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList(
                    $modPerawat,
                    'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')
                ),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>