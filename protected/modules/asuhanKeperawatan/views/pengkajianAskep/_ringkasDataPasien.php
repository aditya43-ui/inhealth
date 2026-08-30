<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<!--<fieldset class="box">
    <legend class="rim">Identitas Pasien</legend>-->
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <label class="control-label no_rek">Instalasi</label>
            </td>
            <td>
                <?php 
                    if(!empty($modPendaftaran->pendaftaran_id)){
                        echo CHtml::hiddenField('instalasi_id',$modPendaftaran->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                        echo CHtml::textField('instalasi_nama',$modPendaftaran->instalasi->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                    }else{
                        echo CHtml::dropDownList('instalasi_id',$modPendaftaran->instalasi_id,CHtml::listData(InstalasiM::model()->getInstalasiPelayanans(),'instalasi_id','instalasi_nama'),array('onchange'=>'resetPencarianRuangan(); setKunjunganReset();refreshDialogKunjungan();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",)); 
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label class="control-label no_rek">No. Pendaftaran</label>
            </td>
            <td>                
                <?php 
                    if (!empty($modPendaftaran->no_pendaftaran)) {
                            echo CHtml::textField('ASPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly' => true));
                            echo CHtml::hiddenField('ASPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true));
                    } else {
                            echo CHtml::hiddenField('ASPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true));
                            echo CHtml::hiddenField('ASPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true));
                            $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modPendaftaran,
                                'attribute'=>'no_pendaftaran',
                                'value'=>$modPendaftaran->no_pendaftaran,
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompleteKunjungan').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_pendaftaran: request.term,
                                                       instalasi_id: $("#instalasi_id").val(),
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 4,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            cekPendaftaran(ui.item.pendaftaran_id, ui.item.instalasi_id);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                                'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps span3','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                    ),
                            )); 
                    }
                    $pasienadmisi_id = (isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null);
                    echo CHtml::hiddenField('ASPendaftaranT[pasienadmisi_id]',$pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                
                    
                ?>
            </td>
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('class' => 'span3', 'readonly' => true)); ?></td>  

<!--<td><?php // echo CHtml::activeLabel($modPasien, 'agama', array('class' => 'control-label')); ?></td>-->
<!--<td><?php // echo CHtml::textField('ASPasienM[agama]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>-->  
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('class' => 'span3', 'readonly' => true)); ?></td>

            <!--<td><?php // echo CHtml::label('Pekerjaan', 'pekerjaan_nama', array('class' => 'control-label')); ?></td>-->
            <!--<td><?php // echo CHtml::textField('ASPasienM[pekerjaan_nama]', $modPasien->pekerjaan_nama, array('readonly' => true)); ?></td>-->

			<td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[ruangan_nama]', isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : '-', array('class' => 'span3', 'readonly' => true)); ?></td>
        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?></td>
            <td><?php
				echo CHtml::textField('ASPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('class' => 'span3', 'readonly'=>true)); 
//				$this->widget('MyJuiAutoComplete', array(
//					'name' => 'ASPasienM[no_rekam_medik]',
//					'value' => $modPasien->no_rekam_medik,
//					'source' => 'js: function(request, response) {
//                                                          $.ajax({
//                                                              url: "' . $this->createUrl('Autocompletenorekammedik') . '",
//                                                              dataType: "json",
//                                                              data: {
//                                                                  daftarpasien:true,
//                                                                  term: request.term,
//                                                              },
//                                                              success: function (data) {
//                                                                response(data);
//                                                              }
//                                                          })
//                                                       }',
//					'options' => array(
//						'showAnim' => 'fold',
//						'minLength' => 3,
//						'focus' => 'js:function( event, ui ) {
//                                                       $(this).val(ui.item.value);
//                                                       return false;
//                                                   }',
//						'select' => 'js:function( event, ui ) {
//                                           cekPendaftaran(ui.item.pendaftaran_id);
//                                            return false;
//                                                   }',
//					),
//				));
				?></td>

			<td><?php echo CHtml::activeLabel($modPasien, 'agama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPasienM[agama]', $modPasien->jeniskelamin, array('class' => 'span3', 'readonly' => true)); ?></td>
			<!--<td><?php // echo CHtml::label('Pendidikan', 'pendidikan_nama', array('class' => 'control-label')); ?></td>-->
            <!--<td><?php // echo CHtml::textField('ASPasienM[pendidikan_nama]', isset($modPasien->pendidikan->pendidikan_nama) ? $modPasien->pendidikan->pendidikan_nama : '-', array('readonly' => true)); ?></td>-->

            <!--<td><?php // echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>-->
            <!--<td><?php // echo CHtml::textField('ASPendaftaranT[kelaspelayanan_nama]', isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : '-', array('readonly' => true)); ?></td>-->

        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?></td>
            <td><?php
				echo CHtml::textField('ASPasienM[nama_pasien]', $modPasien->nama_pasien, array('class' => 'span3', 'readonly'=>true)); 
//				$this->widget('MyJuiAutoComplete', array(
//					'name' => 'ASPasienM[nama_pasien]',
//					'value' => $modPasien->nama_pasien,
//					'source' => 'js: function(request, response) {
//                                                          $.ajax({
//                                                              url: "' . $this->createUrl('Autocompletenamapasien') . '",
//                                                              dataType: "json",
//                                                              data: {
//                                                                  daftarpasien:true,
//                                                                  term: request.term,
//                                                              },
//                                                              success: function (data) {
//                                                                      response(data);
//                                                              }
//                                                          })
//                                                       }',
//					'options' => array(
//						'showAnim' => 'fold',
//						'minLength' => 3,
//						'focus' => 'js:function( event, ui ) {
//                                                       $(this).val(ui.item.value);
//                                                       return false;
//                                                   }',
//						'select' => 'js:function( event, ui ) {
//                                           cekPendaftaran(ui.item.pendaftaran_id);
//                                            return false;
//                                                   }',
//					),
//				));
				?></td>

            <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textArea('ASPasienM[alamat_pasien]', isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : '-', array('class' => 'span3', 'readonly' => true)); ?></td>

			<!--<td><?php // echo CHtml::label('No Kamar / No. Bed', 'no_kamarbed', array('class' => 'control-label')); ?></td>-->
            <!--<td><?php // echo CHtml::textField('ASPendaftaranT[no_kamarbed]', isset($modPendaftaran->kamarruangan_nokamar) ? $modPendaftaran->kamarruangan_nokamar : '' . '/' . isset($modPendaftaran->kamarruangan_nobed) ? $modPendaftaran->kamarruangan_nobed : '', array('readonly' => true)); ?></td>-->

        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?></td>
			<td><?php echo CHtml::textField('ASPendaftaranT[umur]', isset($modPasien->umur) ? $modPasien->umur : '-', array('class' => 'span3', 'readonly' => true)); ?></td>

			<td><?php echo CHtml::activeLabel($modPasien, 'statusperkawinan', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASPendaftaranT[statusperkawinan]', isset($modPendaftaran->statusperkawinan) ? $modPendaftaran->statusperkawinan : '-', array('class' => 'span3', 'readonly' => true)); ?></td>
		</tr>
        <tr>
            <td></td>
            <td></td>

            <!--<td><?php // echo CHtml::activeLabel($modPasien, 'statusperkawinan', array('class' => 'control-label')); ?></td>-->
            <!--<td><?php // echo CHtml::textField('ASPendaftaranT[statusperkawinan]', isset($modPendaftaran->statusperkawinan) ? $modPendaftaran->statusperkawinan : '-', array('readonly' => true)); ?></td>-->
        </tr>
    </table>
<!--</fieldset>--> 
<?php
//========= Dialog buat cari data kunjungan pasien =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogKunjungan',
	'options' => array(
		'title' => 'Pencarian Data Kunjungan Pasien',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 500,
		'resizable' => false,
	),
));
$modDialogKunjungan = new ASPasienM('searchDialogKunjungan');
$modDialogKunjungan->unsetAttributes();
//$modDialogKunjungan->instalasi_id = '';
if (isset($_GET['ASPasienM'])) {
	$modDialogKunjungan->attributes = $_GET['ASPasienM'];
	$modDialogKunjungan->instalasi_id = isset($_GET['ASPasienM']['instalasi_id']) ? $_GET['ASPasienM']['instalasi_id'] : '';
	$modDialogKunjungan->no_pendaftaran = isset($_GET['ASPasienM']['no_pendaftaran']) ? $_GET['ASPasienM']['no_pendaftaran'] : '';
	$modDialogKunjungan->tgl_pendaftaran = isset($_GET['ASPasienM']['tgl_pendaftaran']) ? $_GET['ASPasienM']['tgl_pendaftaran'] : '';
	$modDialogKunjungan->instalasi_id = isset($_GET['ASPasienM']['instalasi_id']) ? $_GET['ASPasienM']['instalasi_id'] : '';
	$modDialogKunjungan->instalasi_nama = isset($_GET['ASPasienM']['instalasi_nama']) ? $_GET['ASPasienM']['instalasi_nama'] : '';
	$modDialogKunjungan->carabayar_id = isset($_GET['ASPasienM']['carabayar_id']) ? $_GET['ASPasienM']['carabayar_id'] : '';
	$modDialogKunjungan->carabayar_nama = isset($_GET['ASPasienM']['carabayar_nama']) ? $_GET['ASPasienM']['carabayar_nama'] : '';
	$modDialogKunjungan->ruangan_id = isset($_GET['ASPasienM']['ruangan_id']) ? $_GET['ASPasienM']['ruangan_id'] : '';
	$modDialogKunjungan->ruangan_nama = isset($_GET['ASPasienM']['ruangan_nama']) ? $_GET['ASPasienM']['ruangan_nama'] : '';
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogKunjungan->searchDialogKunjungan(),
		'filter'=>$modDialogKunjungan,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>function($data) {
					return CHtml::Link('<i class="icon-form-check"></i>',"javascript:void(0);",array(
						"class"=>"btn-small", 
						"id" => "selectPendaftaran",
						"onclick" => "
							cekPendaftaran($data->pendaftaran_id, $data->instalasi_id);
							$('#dialogKunjungan').dialog('close');
						"));
				},
			),
			'no_pendaftaran',
			array(
				'name'=>'tgl_pendaftaran',
				'type'=>'raw',
				'value'=>'!empty($data->tgladmisi)?MyFormatter::formatDateTimeForUser($data->tgladmisi):MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
				'filter'=> false,
			),
			array(
				'name'=>'no_rekam_medik',
				'type'=>'raw',
				'value'=>'$data->no_rekam_medik',
			),
			array(
				'name'=>'nama_pasien',
				'value'=>'$data->namadepan.$data->nama_pasien',
			),
			array(
                            'header'=>'Jenis Kelamin',
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty'=>'-- Pilih --')).
                CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
			), 

			array(
                            'header'=>'Ruangan',
                            'name'=>'ruangan_id',
                            'type'=>'raw',
                            'value'=>'$data->ruangan_nama',
                            'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'ruangan_id', CHtml::listData(
                                            RuanganM::model()->findAllByAttributes(array(
                                                    'instalasi_id'=>$modDialogKunjungan->instalasi_id,
                                                    'ruangan_aktif'=>true,
                                            ), array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array(
                                                    'empty'=>'-- Pilih --', 'id'=>'dialog_pasien_ruangan_id'
                                            )),
			),
			array(
				'header'=>'Jenis Penjamin',
				'name'=>'carabayar_nama',
				'type'=>'raw',
				'value'=>'$data->carabayar_nama',
				'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(
						CarabayarM::model()->findAllByAttributes(array(
							'carabayar_aktif'=>true,
						), array('order'=>'carabayar_nama')), 'carabayar_id', 'carabayar_nama'), array(
							'empty'=>'-- Pilih --',
						)),
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
?>
<script>
    
    /**
    * untuk mereset form kunjungan
    * @returns {undefined} 
    */
   function setKunjunganReset(){
//       $("#form-datakunjungan, #content-penanggungjawab").find('input,select,textarea').each(function(){
//            $(this).val('');
//       });
       
       $("#riwayatasesmenawal-medis > table > tbody ").html('');
       $("#riwayatasesmenawal-kritis > table > tbody ").html('');
       $("#riwayatasesmenawal-keperawatan > table > tbody ").html('');
       $("#riwayatasesmenawal-kebidanan > table > tbody ").html('');       
        
       $('#table-penunjang > tbody').html(''); 
        
       $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
       $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
       $("#form-datakunjungan > .well").addClass("box").removeClass("well");             
   }
   
    /**
    * reset tab 
    **/
    function setTabReset(){
        $(".nav-tabs > .active").removeClass("active");
        $("#frame").attr("src","");
    }
    
    function resetPencarianRuangan() {
        $("#dialog_pasien_ruangan_id").val("");
    }

    /**
    * refresh dialog kunjungan
    * @returns {undefined}
    */
    function refreshDialogKunjungan(){
        var instalasi_id = $("#instalasi_id").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "ASPasienM[instalasi_id]":instalasi_id,
                "ASPasienM[instalasi_nama]":instalasi_nama,
            }
        });
    }
    
    $(document).ready(function(){
        $('input[name="ASPasienM[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });

        <?php if (empty($modPendaftaran->pendaftaran_id)){ ?>
                setTimeout(function(){
                    refreshDialogKunjungan();
                },500);
        <?php } ?>
    });
</script>