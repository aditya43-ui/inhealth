<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'frmsuratperintahranap-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
));
echo $form->errorSummary($model); 
echo $form->hiddenField($model,'suratperintahranap_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
echo $form->hiddenField($model,'pasien_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
echo $form->hiddenField($model,'pasienpulang_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
echo $form->hiddenField($model,'instalasi_id',array()); 
echo $form->hiddenField($modPendaftaran,'carabayar_id',array('class'=>'carabayar_id')); 
?>
<br>
<table width="100%">
    <TR>
        <TD ALIGN=CENTER VALIGN=MIDDLE>
            <B><FONT FACE="Liberation Serif" SIZE=4><u>SURAT PERINTAH RAWAT INAP</u></FONT></B>
        </TD>
    </TR>
     <TR>
        <TD ALIGN=CENTER VALIGN=MIDDLE>
            <B><FONT FACE="Liberation Serif" SIZE=4>NO. <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                    'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></FONT></B>

            <?php echo CHtml::activeHiddenField($model,'nourutsurat'); ?>
        </TD>
    </TR>
</table>
<br>
<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
                <center>Kepada: Yth <br>
                    Kepala Ruangan Rawat Inap <br>
                    di- <br>
                    Tempat
                </center>
            </td>
	</tr>
</table>
<br>
<p>
  <div class="control-group ">
       <div class="controls">
           <?php echo CHtml::activeCheckBox($model, 'isranap_perinatologi',array('onchange'=>'changeGenerateNomor(this);')); ?> <label>Rawat Inap ke Perinatologi</label>
       </div>
   </div>
</p>
<p>
    Bersama ini kami kirimkan Pasien dengan data sebagai berikut:
</p>
<div class="control-group ">
    <?php echo CHtml::label('Nama','pembuatpernyataan_nama', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php
            $jkPR = '';
            $jkLK = '';            
            if (!empty($modPasien->jeniskelamin)){
                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                    $jkPR = 'line-words';
                }else if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN){
                    $jkLK = 'line-words';
                }
            } ?>
        <?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?> &nbsp;&nbsp;&nbsp;<span class="<?php echo $jkLK; ?>">Laki-Laki</span> / <span class="<?php echo $jkPR; ?>">Perempuan</span>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('No. Rekam Medis','norekammedis', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php echo CHtml::textField('norekammedis',$modPasien->no_rekam_medik,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Alamat','alamat', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php
           $alamat = $modPasien->alamat_pasien." RT.".$modPasien->rt." RW.".$modPasien->rw." ".(isset($modPasien->kelurahan)? "Kel.".$modPasien->kelurahan->kelurahan_nama : "")." ".(isset($modPasien->kecamatan)? "Kec.".$modPasien->kecamatan->kecamatan_nama : "")." ".(isset($modPasien->kabupaten)? "Kab/Kota.".$modPasien->kabupaten->kabupaten_nama : "")." ".(isset($modPasien->propinsi)? $modPasien->propinsi->propinsi_nama : "");
        echo CHtml::textArea('alamat',$alamat,array('readonly'=>true,'rows'=>5,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'width: 350px')); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Jenis Penjamin/Penjamin','', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php
        echo CHtml::textField('carabayar',(!empty($modPendaftaran->carabayar)?$modPendaftaran->carabayar->carabayar_nama:'')."/".(!empty($modPendaftaran->penjamin)?$modPendaftaran->penjamin->penjamin_nama:''),array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="control-group ">
    <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label', 'label'=>'No. Identitas Pasien', 'style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php   
            echo $form->textField($modPasien,'no_identitas_pasien',array('class'=>'span3 no_identitas_pasien','readonly'=>false, 'onblur'=>'loadDataPasienDariKartu();'));
        ?>
        <?php // echo $form->error($modPasien, 'nama_pasien'); ?> 
    </div>
</div>
<?php 
if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS): 
    
    ?>
    <div class="control-group " hidden>
        <?php echo $form->labelEx($modPendaftaran,'sep_id', array('class'=>'control-label', 'label'=>'No. SEP', 'style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls">
            <?php   

                $asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                $sep = SepT::model()->findByPk($modPendaftaran->sep_id);                
                if (!empty($sep)) {
                    $modPendaftaran->sep_id = $sep->sep_id;
                    $model->nokartubpjs = $sep->nokartuasuransi;
                } else {
                    $modPendaftaran->sepTs = new SepT;
                }

                if (empty($modPendaftaran->sepTs->nokartuasuransi) && !empty($asuransi)) {
                    $model->nokartubpjs = $asuransi->nokartuasuransi;
                }

                echo $form->hiddenField($modPendaftaran, 'sep_id');
                echo $form->textField($modPendaftaran->sepTs,'nosep',array('class'=>'span3','readonly'=>true));
            ?>
            <?php // echo $form->error($modPasien, 'nama_pasien'); ?> 
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPendaftaran,'no_kartu', array('class'=>'control-label', 'label'=>'No. Kartu BPJS', 'style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls">
            <?php   
                echo $form->textField($model,'nokartubpjs',array('class'=>'span3 nokartu_bpjs','readonly'=>false));
            ?>
            <?php // echo $form->error($modPasien, 'nama_pasien'); ?> 
        </div>
    </div>
<?php endif; ?>
<div class="control-group ">
    <?php echo $form->label($model,'tgl_rencanaranap', array('class'=>'control-label', 'label'=>'Tanggal Rencana Rawat Inap <span class="required">*</span>', 'style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php   
                $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_rencanaranap',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    // 'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 span3 tgl_rencanaranap', 'onchange'=>'cekSpesialisVClaim();'),
        )); ?>
        <?php echo $form->error($model, 'tgl_rencanaranap'); ?> 
    </div>
</div>
<div class="control-group ">
    <?php 
        if((Yii::app()->user->getState('modul_id')==Params::MODUL_ID_RD)||(Yii::app()->user->getState('modul_id')==Params::MODUL_ID_PENDAFTARAN)){
            echo CHtml::label("Spesialis","",array('class' => 'control-label', 'style'=>'text-align: left !important; padding-left: 30px'));
        }else{
            echo $form->label($model,'spesialissubspesialis_id', array('class'=>'control-label', 'style'=>'text-align: left !important; padding-left: 30px'));
        }    
            ?>
    <div class="controls">
        <?php   
            echo $form->dropDownList($model,'spesialissubspesialis_id',
            CHtml::listData(SpesialissubspesialisM::model()->findAll('spesialissubspesialis_aktif = true order by spesialissubspesialis_nama'), 'spesialissubspesialis_id', 'spesialissubspesialis_nama'),
            array('empty'=>'-- Pilih --','class'=>'span3', 'onchange'=>'cekSpesialisVClaim();'));
        ?>
        <?php echo $form->error($model, 'spesialissubspesialis_id'); ?> 
    </div>
</div>
<?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS): ?>
    <div class="control-group ">
        <?php echo $form->label($model,'nomorspri_bpjs', array('class'=>'control-label', 'style'=>'text-align: left !important; padding-left: 30px')) ?>
        <div class="controls">
            <?php   
                 echo $form->textField($model,'nomorspri_bpjs',array('class'=>'span3', 'readonly'=>true));
            ?>
            <?php echo $form->error($model, 'nomorspri_bpjs'); ?> 
        </div>
    </div>
<?php endif; ?>
<div class="control-group ">
    <?php echo CHtml::label('Diagnosa','diagnosa', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        
        <?php
        if((Yii::app()->user->getState('modul_id')==Params::MODUL_ID_RD)||(Yii::app()->user->getState('modul_id')==Params::MODUL_ID_PENDAFTARAN)){
?>
<?php
        

        $modDiagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA));
        $diagUtama = "";
        $iUtm = 0;

                    if($iUtm >0){
                       $diagUtama .= ", ";
                    }
                    $diagUtama .= (!empty($modDiagnosa)?$modDiagnosa->diagnosa->diagnosa_nama:"");
                    $iUtm++;
        

        $diagnosa = $diagUtama;
        ?>
<?php } else { ?>
           <?php 
        $diagUtama = "";
        $diagTambah = "";
        $modDiagnosa = PasienmorbiditasT::model()->findAllByAttributes(array('ruangan_id'=>$modPendaftaran->ruangan_id,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
        $iUtm = 0;
        $iCd = 0;
        if(count($modDiagnosa) > 0){
            foreach ($modDiagnosa as $dataPasienMorb){
                if ($dataPasienMorb->diagnosa_id == 0) {
                    continue;
                }
                $modDiagnosa = DiagnosaM::model()->findByPk($dataPasienMorb->diagnosa_id);

                if($dataPasienMorb->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA){
                    if($iUtm >0){
                       $diagUtama .= ", ";
                    }
                    $diagUtama .= (isset($modDiagnosa)?$modDiagnosa->diagnosa_nama:"");
                    $iUtm++;
                }else  if($dataPasienMorb->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH){
                    if($iCd >0){
                       $diagTambah .= ", ";
                    }
                    $diagTambah .= (isset($modDiagnosa)?$modDiagnosa->diagnosa->diagnosa_nama:"");
                    $iCd++;
                }
            }
        }


        $diagnosa = "Diagnosa Utama   : ".$diagUtama." \n\n"
                . "Tambahan/Penyerta   : ".$diagTambah;
    }
    ?>
        <?php echo CHtml::textArea('diagnosa',$diagnosa,array('readonly'=>true,'rows'=>5,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'style'=>'width: 400px')); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Therapi Sementara','therapi_sementara', array('class'=>'control-label','style'=>'text-align: left !important; padding-left: 30px')) ?>
    <div class="controls">
        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'therapi_sementara', 'toolbar'=>'mini','height'=>'200px','width'=>'250px')) ?>
    </div>
</div>

<br />
<p style="padding-left: 30px">
    Mohon perawatan Selanjutnya, atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
</p>

<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
                <div class="control-group ">
    <?php echo CHtml::label(Yii::app()->user->getState('kabupaten_nama').',' ,'', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php
            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_suratperintahranap',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                'class'=>'tgl_suratperintahranap',
                                'style'=>'width: 150px; float-left',
                            ),
            )); ?>
    </div>
</div>
            </td>
	</tr>
</table>
<table width="100%">
	<tr>
            <td style="width:70%; text-align: left;" colspan="2">
            </td>
            <td style="width:30%; text-align: left;" colspan="2" >
        <center><b>Mengetahui DPJP</b>
                <br><br><br><br><br><br>
                <?php
                // if((Yii::app()->user->getState('modul_id')==Params::MODUL_ID_RD)||(Yii::app()->user->getState('modul_id')==Params::MODUL_ID_PENDAFTARAN)){
                // $dpjp = PasienpulangT::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
                // if(!empty($dpjp->dokterpenerima_id)){
                // $pegawaiPj = PegawaiM::model()->findByPk($dpjp->dokterpenerima_id);
                // echo !empty($pegawaiPj)?$pegawaiPj->namaLengkap:'-';}
                // }else{
                // $dpjp->dpjp1_id = $model->dpjp_id;
                $model->dokterpembuatsurat_id = $modPendaftaran->pegawai_id;
                echo $form->dropDownList($model,'dpjp_id', $model->getItemPegawaiDokter(),array('empty'=>'-- Pilih  --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
                //} ?>
                </center>
            </td>
	</tr>
</table>
<br/>
<div class="form-actions">
    <?php
        $disabled = true;
        $disabledsimpan = false;
        if(isset($_GET['sukses'])){
            $disabledsimpan = true;
        }
        if (!$model->isNewRecord) {
            $disabled = false;
        }
    ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabledsimpan)); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak Surat Perintah Rawat Inap',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'onclick'=>'print("PRINT");', 'disabled'=>$disabled)); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak Surat Rencana Inap BPJS',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'onclick'=>'printSPRI("PRINT");', 'disabled'=>$disabled)); ?>
</div>
	
<?php $this->endWidget(); ?>

<script>

    $(document).ready(function() {
        
        var keterangan = <?= CJSON::encode(array('str' => !empty($model) ? $model->therapi_sementara : "")); ?>;
        
        var catatan = $('#SuratperintahranapT_therapi_sementara');
        $(catatan).val(keterangan.str);
        var frame = $(catatan).parent().find(".redactor_frame");
        var body = frame.contents().find("body #page");
        body.html(keterangan.str);
    
        const carabayar_id = $(".carabayar_id").val();
    
        if (carabayar_id == "<?= Params::CARABAYAR_ID_BPJS ?>"){
            if ($(".no_identitas_pasien").val() != "" && $(".nokartu_bpjs").val() == "") {
                loadDataPasienDariKartu();
            }
        }

    });

</script>