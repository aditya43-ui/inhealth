<?php
$myicon = new MyIcon();

$this->breadcrumbs=array(
	'Informed to Consent',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'informedtoconsent-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
//        'focus'=>'#namaObatNonRacik',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
)); ?>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'list-rujukankeluar',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Hemodialisis Pasien')).'<b> Riwayat Informed To Consent</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_listHD',array(
                            'model'=>$model,
                            'modPendaftaran'=>$modPendaftaran,
                            'modPasien'=>$modPasien,
                            'loadRiwayat'=>$loadRiwayat
                            ),true),
                    'active'=>true,
                    ),   
                ),
        )); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Informed To Consent</div>
    </div>
    <div class="panel-body">
<!--        <fieldset class="box row-fluid">
            <legend class="rim">Informed To Consent</legend>-->
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->radioButton($model, 'hd', array('class'=>'hd', 'value'=>'fhd', 'uncheckValue'=>null, 'onclick'=>'cekTable("fhd")')); ?> <label style="color: red;">Akut</label>
                    <?= $form->radioButton($model, 'hd', array('class'=>'hd', 'value'=>'ghd', 'uncheckValue'=>null, 'onclick'=>'cekTable("ghd")')); ?> <label>Reguler</label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped" id="tbl-fhd">
                        <tr>
                            <th style="width: 200px">Jenis Informasi</th>
                            <th>Isi Informasi</th>
                            <th style="width: 50px;">Tandai</th>
                        </tr>
                        <tr>
                            <td><label>Diagnosis (diagnosis kerja - diagnosa banding)</label></td>
                            <!--<td id="tr-fhd1"><label>Diagnosis (diagnosis kerja - diagnosa banding)</label></td>-->
                            <td id="tr-fhd2"><label>Acute Kidney Injury (AKI)</label></td>
                            
                            <!--<td id="tr-ghd1" hidden><label>Diagnosis</label></td>-->
                            <td id="tr-ghd2" hidden><label>Penyakit ginjal tahap akhir</label></td>
                            
                            <td><center><?php echo $form->checkBox($model,'diagnosis', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr>
                            <td><label>Dasar Diagnosis</label></td>
                            <td><label>Riwayat penyakit - pemeriksaan fisik - pemeriksaan penunjang</label></td>
                            <td><center><?php echo $form->checkBox($model,'dasar_diagnosis', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr id="tr-fhd">
                            <td><label>Tindakan Kedokteran</label></td>
                            <td id="tr-fhd3"><label>Hemodialisis Akut</label></td>
                            
                            <td id="tr-ghd3" hidden><label>Hemodialisis Reguler</label></td>
                            <td><center><?php echo $form->checkBox($model,'tindakan_kedokteran', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        
                        <tr>
                            <td><label>Indikasi Tindakan</label></td>
                            <td><label>Gangguan elektrolit - produk sampah ginjal dalam kadar toksik - sindroma kelebihan cairan</label></td>
                            <td><center><?php echo $form->checkBox($model,'indikasi_tindakan', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr>
                            <td><label>Tata Cara</label></td>
                            <td><label>Pembuluh darah arteri dan vena dihubungkan dengan mesin hemodialisis yang mengalirkan darah lalu sampah dan cairan berlebih dipindahkan dari tubuh dan darah kembali ke tubuh </label></td>
                            <td><center><?php echo $form->checkBox($model,'tata_cara', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr>
                            <td><label>Tujuan</label></td>
                            <td><label>Mengatur keseimbangan elektrolit - keseimbangan cairan dan membersihkan tubuh dari sampah ginjal</label></td>
                            <td><center><?php echo $form->checkBox($model,'tujuan', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr id="tr-fhd">
                            <td><label>Risiko / Komplikasi yang mungkin</label></td>
                            <td  id="tr-fhd4"><label>Perdarahan - pembengkakan dan infeksi di tempat penusukan - mula muntah - kontaminasi tekanan darah - gejala ketidakseimbangan - irama jantung tidak teratur - reaksi cairan dialisat - kematian</label></td>
                            
                            <td id="tr-ghd4" hidden><label>Perdarahan - pembengkakan dan infeksi di tempat penusukan - mula muntah - kontaminasi sistem air yang digunakan hemodialisis - kram otot - penurunan tekanan darah - gejala ketidakseimbangan - irama jantung tidak teratur -reaksi cairan dialisat - kematian</label></td>
                            <td><center><?php echo $form->checkBox($model,'risiko', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                       
                        <tr>
                            <td><label>Prognosis</label></td>
                            <td><label>Baik</label></td>
                            <td><center><?php echo $form->checkBox($model,'prognosis', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column'))?></center></td>
                        </tr>
                        <tr>
                            <td><label>Alternatif dan  Risikonya</label></td>
                            <td><?= $form->textArea($model,'alternatif_risiko_isi_informasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'', 'style'=>'width:100%; height: 100px'));?></td>
                            <td><center><?php echo $form->checkBox($model,'alternatif_risiko', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column', 'onclick'=>'cekAlternatif()'))?></center></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal dan Jam','tanggal', array('class'=>'control-label required')) ?>
                   <div class="controls">
                           <?php   
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                           $this->widget('MyDateTimePicker',array(
                                   'model'=>$model,
                                   'attribute'=>'waktu',
                                   'mode'=>'datetime',
                                   'options'=> array(
                                           'dateFormat'=>Params::DATE_FORMAT,
                                           'maxDate' => 'd',
                                           'yearRange'=> "-60:+0",
                                   ),
                                   'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                   ),
                           )); ?>
                   </div>
               </div>
            </div>
            <div class="span6">
                <div class="control-group ">
                    <?php echo CHtml::label('Prof./Dr./Spesialis','dokteri_id', array('class'=>'control-label')) ?>
                    <?php echo CHtml::activeHiddenField($model, 'dokteri_id',array('readonly'=>true,'style'=>'width:110px;')); ?>
                    <div class="controls">
                            <div class="input-append" style='display:inline'>
                                <?php 
                                    $this->widget('MyJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'dokter_nama',
                                            'source'=>'js: function(request, response) {
                                                    $.ajax({
                                                            url: "'.$this->createUrl('AutoCompleteDokter').'",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    dokter_id: $("#dokteri_id").val(),
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                                            'options'=>array(
                                                    'showAnim'=>'fold',
                                                    'minLength' => 3,
                                                    'focus'=> 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                     }',
                                                    'select'=>'js:function( event, ui ) {
                                                            $("#dokteri_id").val(ui.item.dokteri_id); 
                                                            $("#dokter_nama").val(ui.item.dokter_nama);
                                                            return false;
                                                    }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                            'htmlOptions'=>array('class'=>'span3'),
                                    )); 
                                ?>
                        </div>      
                    </div>
		</div>
            </div>
        </fieldset>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="form-actions">
                
            <?php
		if(isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.$myicon::getIcons('simpan').'"></i>')),
						array('class'=>'btn btn-danger', 'id'=>'btn_submit','disabled'=>true))."&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']), array(
				'class'		 => 'btn btn-default',
				'onclick'	 => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']).'";}); return false;'
                ))."&nbsp";
                                
                                echo CHtml::link(Yii::t('mds', '{icon} Print', 
                array('{icon}'=>'<i class="icon-print icon-white"></i>')), 
                    'javascript:void(0);', array('class'=>'btn btn-success',
                    'onclick'=>"print(".$modPendaftaran->pendaftaran_id.",'');return false"))."&nbsp;";
                
		}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.$myicon::getIcons('simpan').'"></i>')),
						array('class'=>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-danger submit', 'id'=>'btn_submit', 'onclick'=>'cekInsert();', 'onKeypress'=>'cekInsert();', 'disabled'=>(isset($_GET['sukses']))? true : false))."&nbsp";
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']), array(
				'class'		 => 'btn btn-default',
				'onclick'	 => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl($this->id . '/index&pendaftaran_id='.$_GET['pendaftaran_id']).'";}); return false;'
                ))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-success', 'type'=>'button','disabled'=>'disabled'))."&nbsp"; 
		}
		?>
            
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Prof./Dr./Spesialis',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialog');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawairuanganV'])){
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'therapiobat-grid',
	'dataProvider'=>$modPegawai->searchDialogPegRuangan(),
	'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                                $(\"#HDInformtoconsentHdT_dokteri_id\").val(\"$data->pegawai_id\"); 
                                                $(\"#HDInformtoconsentHdT_dokter_nama\").val(\"$data->nama_pegawai\"); 
                                                $(\'#dialogDokter\').dialog(\'close\');
                                                return false;"))',
                ),
				'nama_pegawai',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function(){        
        <?php if(!isset($_GET['informtoconsent_hd_id'])) : ?>
            var hd = $('#HDInformtoconsentHdT_hd[value="ghd"]').attr("checked",true);
            $('input[class="checkbox-column"]').attr("checked", true);
                        
            cekTable(hd.val());
            cekAlternatif();
        <?php else : ?>
            var hd = $('#HDInformtoconsentHdT_hd[checked="checked"]').val();            
//            console.log(hd);
            cekTable(hd);
            cekAlternatif();
        <?php endif; ?>
        
        <?php 
            if (isset($_GET['mode'])) { ?>
                $("#informedtoconsent-t-form").find('input,select,textarea, button').each(function(){
                    $(this).attr('disabled',true);
            });
        <?php } ?>                    
    })
    
    function cekTable(param){
        console.log(param);
        if(param=='fhd'){
            
            $('#HDInformtoconsentHdT_hd[value="ghd"]').prop("checked",false);
            $('#HDInformtoconsentHdT_hd[value="fhd"]').prop("checked",true);            

            $('#tr-fhd2').attr("hidden", false);
            $('#tr-fhd3').attr("hidden", false);
            $('#tr-fhd4').attr("hidden", false);
//            $('#tr-ghd1').attr("hidden",true);
            $('#tr-ghd2').attr("hidden",true);
            $('#tr-ghd3').attr("hidden",true);
            $('#tr-ghd4').attr("hidden",true);
        }else if(param=='ghd'){
//            $('#HDInformtoconsentHdT_hd[value="fhd"]').removeAttr("checked");
            $('#HDInformtoconsentHdT_hd[value="fhd"]').prop("checked",false);
            $('#HDInformtoconsentHdT_hd[value="ghd"]').prop("checked",true);            
//            $('#tr-fhd1').attr("hidden", true);
            $('#tr-fhd2').attr("hidden", true);
            $('#tr-fhd3').attr("hidden", true);
            $('#tr-fhd4').attr("hidden", true);
//            $('#tr-ghd1').attr("hidden",false);
            $('#tr-ghd2').attr("hidden",false);
            $('#tr-ghd3').attr("hidden",false);
            $('#tr-ghd4').attr("hidden",false);
        }
    }
    function cekAlternatif()
    {
        if($('#HDInformtoconsentHdT_alternatif_risiko').is(':checked')){
            console.log('ya');
            $("#HDInformtoconsentHdT_alternatif_risiko_isi_informasi").attr("disabled",false);
        }else{
            console.log('no');
            $("#HDInformtoconsentHdT_alternatif_risiko_isi_informasi").attr("disabled",true);
            $("#HDInformtoconsentHdT_alternatif_risiko_isi_informasi").val('');
//            document.getElementsById('HDInformtoconsentHdT_alternatif_risiko_isi_informasi').readOnly=true;
        }
    }
    function cekInsert(){
        $(".integer").each(function(){
                $(this).val(parseInt(unformatNumber($(this).val())));
        });
        $(".float").each(function(){
                $(this).val(parseFloat(unformatNumber($(this).val())));
        });

//            var hd = $('#HDInformtoconsentHdT_hd').val();
//            console.log(hd);return false;

        $('#informedtoconsent-t-form').submit();


    }
    function print(pendaftaran_id, informedid)
    {
        window.open('<?php echo $this->createUrl('printInformed'); ?>&informtoconsent_hd_id='+informedid+'&id='+pendaftaran_id,'printwin','left=100,top=100,width=640,height=640');
    }
</script>