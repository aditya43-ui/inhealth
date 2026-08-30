<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'facopyresep-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>
<style>
    .dropdown {
        position: relative;
        display: inline-block;
        width: 60px;
    }

    /* Style untuk tombol dropdown */
    .dropbtn {
        background-color: #3498db;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
    }

    /* Style untuk konten dropdown */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        top: -8px;
        right: -160px; /* Menggeser dropdown ke arah kiri */
    }

    /* Style untuk pilihan dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Style untuk pilihan dropdown saat dihover */
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Menampilkan konten dropdown saat tombol di-hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<legend class="rim2">Salin Resep</legend>
	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary(array($model)); ?>
<fieldset>
        <table>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modelPenjualanResep,'noresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo $form->textField($modelPenjualanResep,'noresep',array('class'=>'span3','readonly'=>true));
                                 echo $form->hiddenField($modelPenjualanResep,'penjualanresep_id',array('class'=>'span2','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'no_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo $form->textField($modPasien,'no_rekam_medik',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                 <td>
                    <div class="control-group ">
                        <?php
                        $modelPenjualanResep->tglresep = MyFormatter::formatDateTimeForUser($modelPenjualanResep->tglresep);
                        echo $form->labelEx($modelPenjualanResep,'tglresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo $form->textField($modelPenjualanResep,'tglresep',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo $form->textField($modPasien,'nama_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label('Dokter','dokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo CHtml::textField($modelPenjualanResep->pegawai_id,isset($modelPenjualanResep->pegawai->NamaLengkap)?$modelPenjualanResep->pegawai->NamaLengkap:'-',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPasien,'alamat_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php
                                 echo $form->textArea($modPasien,'alamat_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table id="table-obatalkespasien" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Resep</th>
                    <th>Status</th>
                    <th>Option</th>
					<th>R ke</th>
					<th>Kode / Nama Obat Pada Resep</th>
					<th width='180'>Kode / Nama Obat Dilayani</th>
					<th>Jumlah Pada Resep</th>
					<th>Jumlah Dilayani</th>
					<th hidden>Sumber Dana</th>
					<th hidden>Satuan Kecil</th>
					<th>Harga</th>
                    <th>Total Embalase (Rp)</th>
					<th>Keringanan (%)</th>
					<th>Keringanan (Rp)</th>
					<th>PPN (%)</th>
					<th>PPN (Rp)</th>
					<th>Sub Total</th>
					<th>Signa</th>
					<th>Etiket</th>
					<th>Tipe Racikan</th>
					<th>Sediaan Racikan</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                if(count((array)$modObatAlkesPasien) > 0){
                    foreach($modObatAlkesPasien AS $iii=> $modDetail){
                        $subtotal += $modDetail->hargajual_oa;

                        $modDetail->obatalkes_nama = $modDetail->obatalkes->obatalkes_nama;
											$modDetail->ppnpersen = $modDetail->persenppnjual;
											$modDetail->qty_oa = is_numeric($modDetail->qty_oa) ? number_format($modDetail->qty_oa, 2, ",", "") : $modDetail->qty_oa;
                        if (empty($modDetailReseptur[$iii])) {
                            $modDetailReseptur[$iii] = new FAResepturDetailT;
                        }                    
                                            
                                            $modDetailReseptur[$iii]->qty_reseptur = is_numeric($modDetailReseptur[$iii]->qty_reseptur) ? number_format($modDetailReseptur[$iii]->qty_reseptur, 2, ",", "") : $modDetailReseptur[$iii]->qty_reseptur;

//                        echo $this->renderPartial('_rowDetailCopyResep',array('modObatAlkesPasien'=> $modDetail));
                        echo $this->renderPartial('_rowDetailOaPasien',array('modPendaftaran' => $modPendaftaran, 'modObatAlkesPasien'=> $modDetail,'iii'=>$iii,'modDetailReseptur'=>$modDetailReseptur));
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" style="text-align: right;"><strong>Jasa Pelayanan Farmasi</strong></td>
                    <td ><strong><?php 
                    $jasa = $modelPenjualanResep->jasapelayanan_farmasi;
                    
                    echo $form->textField($modelPenjualanResep, 'jasapelayanan_farmasi',array('class'=>'integer-decimal','style'=>'width:120px;', 'readonly'=>'true', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></strong>
                    <?php //echo CJSON::encode($modPenjualan); ?>
                    </td>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td colspan="11" style="font-weight: bold; text-align: right;">Total</td>
                    <td>
                        <?php 
                        $subtotal += $jasa;
                        echo CHtml::textField('totalAll',$subtotal,array('class'=>'span2 integer-decimal','readonly'=>true)) ?>
                    </td>
                    <td colspan="6"></td>
                </tr>
            </tfoot>
        </table>
        <table>
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'keterangancopy', array()) ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                     <div class="control-group ">
                            <?php
                                 echo $form->textArea($model,'keterangancopy',array('class'=>'span3','readonly'=>false));
                            ?>
                    </div>
                </td>
            </tr>
        </table>
</fieldset>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Salin Resep',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanCopyResep();'))."&nbsp"; ; ?>

        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), array('class'=>'btn btn-danger','onclick'=>'ulang(this.id)'))."&nbsp"; ; ?>
        <?php if(($tersimpan == 'Ya')){ ?>
            <script>
                print(<?php echo $modelPenjualanResep->penjualanresep_id?>,'PRINT');
            </script>
		<?php } ?>
		<?php
			$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
			$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
			$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPenjualanObat');
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'PRINT\')'))."&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'PDF\')'))."&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\''.$modelPenjualanResep->penjualanresep_id.'\',\'EXCEL\')'))."&nbsp&nbsp";
		?>
    </div>

<?php $this->endWidget(); ?>

<?php // if($tersimpan=='Ya'){ ?>
<script>//
//parent.location.reload();
//</script>
<?php // } ?>

<?php
$urlPrintCopyResep = Yii::app()->createUrl('farmasiApotek/PenjualanDariReseptur/PrintCopyResep',array('idPenjualanResep'=>''));
$jscript = <<< JS
function print(idPenjualanResep,caraPrint)
{
    window.open("${urlPrintCopyResep}"+idPenjualanResep+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JS;
Yii::app()->clientScript->registerScript('jsCopyResep',$jscript, CClientScript::POS_BEGIN);
?>
<?php // $this->renderPartial('_jsFunctions', array('modPenjualan'=>$modelPenjualanResep)); ?>
<script type="text/javascript">
function ulang(id){
    $('#<?php echo CHtml::activeId($model,"keterangancopy"); ?>').val('');
}

function simpanCopyResep(){
	if(requiredCheck($("form"))){
			$("form").find('.integer2, .float2, .integer-decimal').each(function(){
					$(this).val(unformatNumber($(this).val()));
			});
			$('#facopyresep-t-form').submit();
	}
	return false;
}
$(document).ready(function(){
	formatNumberSemua();
});

function batalObatAlkesPasienDetail(obj){
	var asd = $(obj).parents('tr');
	var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
	if(obatalkes_id != ''){
		myConfirm("Apakah anda akan membatalkan obat ini?",
		"Perhatian!",
		function(r){
			if(r){
				$(asd).addClass("animation-loading-1");
				setTimeout(function(){
					$(obj).parents('tr').detach();
					renameInputRowObatAlkes($("#table-obatalkespasien"));
					$(asd).removeClass("animation-loading-1");
				},400);
				setTimeout(function(){
					hitungTotal();
				},600);
			}
		});
	}else{
		$(obj).parents('tr').detach();
		renameInputRowObatAlkes($("#table-obatalkespasien"));
	}
}

function hitungTotal(){
    unformatNumberSemuaResep();
    //obj_totalharganetto =  $('#<?php //echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    //obj_totalhargajual =  $('#<?php //echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
    var jasapelayanan_farmasi = parseFloat($('input[name*="[jasapelayanan_farmasi]"]').val());
    if (isNaN(jasapelayanan_farmasi)) {
            jasapelayanan_farmasi = 0;
        }
	var asd = $(obj_totalhargajual).parents('td');
	$(asd).addClass("animation-loading-1");
    totalharganetto = 0;
    totalhargajual = 0;
    var totaldiskon = 0;
    var totalppn = 0;

    $('#table-obatalkespasien > tbody > tr').each(function(){
      var ppnpersen = parseFloat($(this).find('input[name*="[ppnpersen]"]').val());
      var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
      var qty = parseFloat(unformatNumber($(this).find('input[name*="[qty_dilayani]"]').val()));
      var persenDiskon = parseFloat($(this).find('input[name*="[persen_discount]"]').val());
      var biayadmn = parseFloat($(this).find('input[name*="[biayaadministrasi]"]').val());
      var totalembalase = parseFloat($(this).find('input[name*="[total_embalase]"]').val());

      if (isNaN(totalembalase)) {
            totalembalase = 0;
    }

      if (isNaN(persenDiskon)) {
        persenDiskon = 0;
      }

      if(Math.ceil(persenDiskon) > 100){
        myAlert('Keringanan (%) Lebih dari 100%');
        persenDiskon = 0;
        $(this).find('input[name*="[persen_discount]"]').val(0);
      }

      var totalBiayaadmn = (biayadmn * qty);
      if (totalBiayaadmn > 0){
        totalBiayaadmn = parseFloat(totalBiayaadmn.toFixed(2));
      }


      var jmlqty = (hargasatuan * qty);
      if (jmlqty > 0){
         jmlqty = parseFloat(jmlqty.toFixed(2));
     }

     var jmldiskon = (((jmlqty + totalBiayaadmn) * persenDiskon)/100);
     if (jmldiskon > 0){
        jmldiskon = parseFloat(jmldiskon.toFixed(2));
      }
      var subtotalSementara = ((jmlqty  + totalBiayaadmn)-jmldiskon);

      var jmlppn = ((subtotalSementara * ppnpersen)/100);
      if (jmlppn > 0){
         jmlppn = parseFloat(jmlppn.toFixed(2));
     }

       var subtotal = (subtotalSementara + jmlppn + totalembalase);
       if (subtotal > 0){
          subtotal = parseFloat(subtotal.toFixed(2));
      }

       $(this).find('input[name*="[jumlahppn]"]').val(jmlppn);
       $(this).find('input[name*="[subtotal]"]').val(subtotal);
       $(this).find('input[name*="[discount]"]').val(jmldiskon);
       $(this).find('input[name*="[totalbiayaadministrasi]"]').val(totalBiayaadmn);

        totalharganetto += parseFloat( $(this).find('input[name*="[hargasatuan_reseptur]"]').val() * $(this).find('input[name*="[qty_dilayani]"]').val() );
        totalhargajual = totalhargajual + jasapelayanan_farmasi + subtotal;
        totaldiskon += jmldiskon;
        totalppn += jmlppn;
    });
    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
    //$('#<?php //echo CHtml::activeId($modPenjualan, 'discount'); ?>').val(totaldiskon);
    //$('#<?php //echo CHtml::activeId($modPenjualan, "totalppn"); ?>').val(totalppn);

    setTimeout(function(){
		$(asd).removeClass("animation-loading-1");
	},300);
    formatNumberSemuaResep();
}
</script>
