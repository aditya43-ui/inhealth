<?php
$form = $this->beginWidget(
	'ext.bootstrap.widgets.BootActiveForm',
	array(
		'method' => 'post',
		'type' => 'horizontal',
		'id' => 'form-update-kontrol',
		'htmlOptions' => array(
			'onKeyPress' => 'return disableKeyPress(event)'
		),
	)
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row-fluid">
	<div class="col-sm-6">
            <?php echo CHtml::activeHiddenField($modSurat, 'suratketerangan_id', array(
                'class' => 'srk_suratketerangan_id',
            )); ?>
			<div class="control-group ">
                <?php echo CHtml::label('No. Kartu','nokartu_asuransi', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modSurat,'nokartu_asuransi',array('class'=>'span3', 'readonly'=>true));
                    ?>
                    <?php echo $form->error($modSurat, 'nokartu_asuransi'); ?> 
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('No. Surat Kontrol','nomorsurat_bpjs', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modSurat,'nomorsurat_bpjs',array('class'=>'span3', 'readonly'=>true));
                    ?>
                    <?php echo $form->error($modSurat, 'nomorsurat_bpjs'); ?> 
                </div>
            </div>
			
            
            <div class="control-group ">
                <?php echo CHtml::label('No. SEP','nomorsurat', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modSurat,'nosep',array('class'=>'span3', 'readonly'=>true));
                    ?>
                    <?php echo $form->error($modSurat, 'nosep'); ?> 
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal SEP','nomorsurat', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                         echo $form->textField($modSurat,'tglsep',array('class'=>'span3', 'readonly'=>true));
                         ?>
                    <?php echo $form->error($modSurat, 'tglsep'); ?> 
                </div>
            </div>

            <div class="control-group ">
                <?php echo $form->labelEx($modSurat,'Tgl Kontrol', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modSurat,
                                            'attribute'=>'tglrenkontrol',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                // 'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3 span3'),
                    )); ?>
                    <?php echo $form->error($modSurat, 'tglrenkontrol'); ?> 
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Sub / Spesialis', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php

                    $dataSP = SpesialissubspesialisM::model()->findAllByAttributes(array(
                        'spesialissubspesialis_aktif' => true,
                    ), array(
                        'order' => 'spesialissubspesialis_nama asc'
                    ));
                    $listSP = CHtml::listData($dataSP, 'spesialissubspesialis_id', 'spesialissubspesialis_nama');
                    $optionSP = array();


                    foreach ($dataSP as $item) {
                        $optionSP[$item->spesialissubspesialis_id] = array(
                            'data-kode' => $item->spesialissubspesialis_kodebpjs
                        );
                    }

                    echo CHtml::activeDropDownList(
                        $modSurat,
                        'spesialissubspesialis_id',
                        $listSP,
                        array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3 srk_spesialissubspesialis_id',
                            'options' => $optionSP,
                            'onchange' => 'cekSpesialisVClaim();'
                        )
                    );
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('DPJP Melayani', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $dataDokter = PegawaiM::model()->findAllByAttributes(array(
                        'pegawai_aktif' => true,
                    ), array(
                        'condition' => "kodedokter_bpjs is not null and kodedokter_bpjs not ilike '%null%'",
                        'order' => 'nama_pegawai asc'
                    ));
                    $listDokter = CHtml::listData($dataDokter, 'pegawai_id', 'namaLengkap');
                    $optionDokter = array();

                    foreach ($dataDokter as $item) {
                        $optionDokter[$item->pegawai_id] = array(
                            'data-kode' => $item->kodedokter_bpjs
                        );
                    }
                    echo CHtml::activeDropDownList($modSurat, 'doktertujuankontrol_id', $listDokter, array('empty' => '-- Pilih --', 'class' => 'span3 srk_doktertujuankontrol_id', 'options' => $optionDokter));
                    ?>
                </div>
            </div>
	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton( Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-floppy"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::htmlButton('<i class="entypo-print"></i> Cetak', array(
                'class' => 'btn btn-info srk_btn_cetak',
                'onclick' => 'printSRK();',
                'disabled' => isset($_GET['sukses']) ? false : true,
            )) ?>
</div>

<?php $this->endWidget(); ?>

<script>

$(document).ready(function() {
	// srkSetKontrolDariSEP('<?= !empty($modSurat->nosep) ? $modSurat->nosep : null ?>');
});
function srkSetKontrolDariSEP(nosep) {
    console.log(nosep)
    if(nosep !== null) {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/srkLoadSEP'); ?>', {
            nosep: nosep
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                console.log(data.sepData);
               ;
                var spesialis_id = null;
                $(".srk_spesialissubspesialis_id option").each(function() {
                    if ($(this).data('kode') == data.sepData.poli) {
                        spesialis_id = $(this).val();
                    }
                });
                if (spesialis_id != null) {
                    $(".srk_spesialissubspesialis_id").val(spesialis_id);
                }
    
                var dokter = null;
                $(".srk_doktertujuankontrol_id").html(data.html_dpjp);
                $(".srk_doktertujuankontrol_id option").each(function() {
                    if ($(this).data('kode') == data.sepData.dpjp.dkDPJP) {
                        dokter = $(this).val();
                    }
                });
                if (dokter != null) {
                    $(".srk_doktertujuankontrol_id").val(dokter);
                }
    
    
            }
        }, 'json');
    } else {
        myAlert('No Sep Tidak Ditemukan')
    }
}
function cekSpesialisVClaim() {

    var no_kartu = $("#SuratketeranganR_nokartu_asuransi").val();
    var spesialis_id = $("#SuratketeranganR_spesialissubspesialis_id").val();
    var tgl = $("#SuratketeranganR_tglsep").val();

    if (no_kartu == "") {
        myAlert("Nomor Kartu BPJS harus di isi.");
        return false;
    }
    if (spesialis_id == "") {
        myAlert("Spesialis harus di isi.");
        return false;
    }
    if (tgl == "") {
        myAlert("Tanggal rencana harus di isi.");
        return false;
    }

    $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratKontrolDanRanap/cekVClaimSpesialis'); ?>', {
        no_kartu: no_kartu,
        spesialis_id: spesialis_id,
        tgl: tgl
    }, function(data) {
        if (data.ok == 0) {
            myAlert(data.msg);
        }

        $("#SuratketeranganR_doktertujuankontrol_id").html(data.html);

    }, 'json');
}
function printSRK() {
    var id = $(".srk_suratketerangan_id").val();

    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/printSRK'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');
}
</script>