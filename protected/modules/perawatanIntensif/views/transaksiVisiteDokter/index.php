<?php $linkHalaman = CustomFunction::getUrlByMenuID(2618); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Visite Dokter',
);
?>
<!--<div class="white-container">
    <legend class="rim2">Transaksi <b>Visite Dokter</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Visite Dokter</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Visite Dokter berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pasienVisite-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#namaDokter',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <!--<legend class="rim">Berdasarkan tanggal</legend>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::label('Tgl. Visite/Masuk Kamar <span class="required"> *</span>', 'Tanggal Visite *', array()); ?>
                            </div>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    //                                                            'name'=>'tanggalVisite',
                                    'model' => $model,
                                    'attribute' => 'tanggalVisite',
                                    'mode' => 'date',
                                    //                                                            'mode'=>'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'isRequired span3'
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::label('Sampai Dengan', 'Tanggal Visite *', array()); ?>
                            </div>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    //                                                            'name'=>'tanggalVisite',
                                    'model' => $model,
                                    'attribute' => 'tanggalVisite_akhir',
                                    'mode' => 'date',
                                    //                                                            'mode'=>'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        //                                                                    'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'isRequired span3'
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::label('Jenis Visite', 'Jenis Visite', array()); ?>
                            </div>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'jenisVisite',
                                    //										'name'=>'jenisVisite',    
                                    //										'value'=>'',
                                    'sourceUrl' => $this->createUrl('GetDaftarTindakanVisite'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												$("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val( ui.item.daftartindakan_id);
												return false;
											}',
                                        'select' => 'js:function( event, ui ) {
											 samakanVisite(ui.item.daftartindakan_id);
											 $("#' . CHtml::activeId($model, 'daftartindakan_id') . '").val( ui.item.daftartindakan_id);
													  }'
                                    ),
                                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Jenis Visite', 'rel' => 'tooltip', 'title' => 'Ketik tindakan visit'),
                                )); ?>
                                <?php echo CHtml::activeHiddenField($model, 'daftartindakan_id', array('class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::activeCheckBox($model, 'is_dokter', array('style' => 'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik jika pencarian berdasarkan Dokter PJP')) ?>
                                <?php echo CHtml::label('Dokter Visite <span class="required"> *</span>', 'Nama Dokter', array()); ?>
                            </div>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'nama_pegawai',
                                    'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutocompleteDokter') . '",
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
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
											$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val( ui.item.nama_pegawai);
											$("#' . CHtml::activeId($model, 'pegawai_id') . '").val( ui.item.pegawai_id);
											return false;
										}',
                                        'select' => 'js:function( event, ui ) {
											samakanDokter(ui.item.pegawai_id);
											return false;
										}',
                                    ),
                                    'tombolDialog' => array("idDialog" => 'dialogDokter'),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'placeholder' => 'Nama Dokter',
                                        'rel' => 'tooltip',
                                        'title' => 'Ketik nama dokter',
                                        'class' => 'span3',
                                    ),
                                )); ?>
                                <?php echo CHtml::activeHiddenField($model, 'pegawai_id', array('class' => 'span4')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-label"></div>
                            <div class="controls">
                                <?php echo CHtml::activeCheckBox($model, 'is_nursestation', array('onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                                <?php echo CHtml::label('Berdasarkan Nurse Station', 'PIInfopasienmasukkamarV_is_nursestation', array()); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">No. Rekam Medik</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'no_rekam_medik', array('class' => 'span4', 'placeholder' => 'No. Rekam Medik')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">Nama Pasien</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'nama_pasien', array('class' => 'span4', 'placeholder' => 'Nama Pasien')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'searchVisite();')
                    ); ?>
                </div>
            </div>
        </div>
        <?php
        //$this->renderPartial('_rowVisiteDokter',array('model'=>$model));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Visite Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="items table table-striped table-condensed" id="table-visite">
                    <thead>
                        <tr>
                            <th>Tanggal Admisi / Masuk Kamar</th>
                            <th>No. Rekam Medik / No. Pendaftaran</th>
                            <th>Nama Pasien / Alias</th>
                            <th>Jenis Kelamin</th>
                            <th>Jenis Penjamin / Penjamin</th>
                            <th>Ruangan / Kelas Pelayanan</th>
                            <th>Kasus Penyakit</th>
                            <th>Dokter Penanggung Jawab</th>
                            <th>Visite Dokter <span class="required"> *</span></th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <div style="display: none;">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                ); ?>
            </div>
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasi()', 'disabled' => $disableSave)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/TransaksiVisiteDokter/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/TransaksiVisiteDokter/index') . '";}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php
        $this->endWidget();
        $urlCekTarifTindakan = Yii::app()->createUrl('perawatanIntensif/TransaksiVisiteDokter/getTarifTindakan');
        $js = <<< JS
function samakanDokter(idPegawai){   
$('.idDokter').each(function(){
        $(this).val(idPegawai);
    });   
}
function samakanVisite(idVisite){   
    $('.idVisite').each(function(){
        $(this).parents('tr').find('.ceklist').attr('checked',false);
        $(this).val(idVisite);
    });   
} 
function dipilih(obj){
	if($(obj).is(':checked')){
		daftartindakan_id = $(obj).parents('tr').find("select[name*='[daftartindakan_id]']").val();
		kelaspelayanan_id = $(obj).parents('tr').find("input[name*='[kelaspelayanan_id]']").val();
		if(daftartindakan_id != '' && kelaspelayanan_id != ''){
			$.post("${urlCekTarifTindakan}", { daftartindakan_id: daftartindakan_id, kelaspelayanan_id: kelaspelayanan_id },
				function(data){
					if(data.status == 'Ada')
					{
					   $(obj).parent().find('input').val('Ya');
					}
					else
					{
						window.parent.myAlert('Maaf, Daftar Tindakan tidak memiliki tarif');
						$(obj).parent().find('.ceklist').attr('checked',false);
					}
			}, "json");
		}else{
			window.parent.myAlert('Silakan pilih jenis Visite Dokter');
			$(obj).parent().find('.ceklist').attr('checked',false);
		}
	}else{
		$(obj).parent().find('input').val('Tidak');
	}
}
    function validasi()
    {
        jumlahCeklist=0;
        validasiDokter='Ya';
        validasiVisite='Ya';
        $('.isRequired').each(function(){
            if($(this).val()==''){
                window.parent.myAlert('Harap Isi Semua Yang Bertanda *')
                $(this).focus();
            }
        }); 
          $('.ceklist').each(function(){
            if($(this).is(':checked'))
               {
                  jumlahCeklist = jumlahCeklist +1;  
                  if($(this).parent().prev().find('select').val()==''){
                        $(this).parent().prev().find('select').focus();
                                                validasiVisite='Tidak';
                    }
                   if($(this).parent().prev().prev().find('select').val()==''){
                        $(this).parent().prev().prev().find('select').focus();
                        validasiDokter='Tidak';
                  }
               } 
          });
      if(jumlahCeklist==0){
        window.parent.myAlert('Anda Belum Memilih Pasien');
      }else if(validasiDokter=='Tidak'){
        window.parent.myAlert('Harap Isi Semua Data Dokter Yang Diperlukan');
      }else if (validasiVisite=='Tidak'){
        window.parent.myAlert('Harap Isi Semua Data Visite Yang Diperlukan');
      }else{
        //$('#btn_simpan').click();
		$('#pasienVisite-form').submit();		
//        window.parent.myAlert('simpan');
      }    
    }
JS;
        Yii::app()->clientScript->registerScript('sasfsddfsgfhgdfgsgsdg', $js, CClientScript::POS_HEAD);
        ?>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));
$modDokter = new PIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PIDokterV'])) {
    $modDokter->attributes = $_GET['PIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"samakanDokter($data->pegawai_id);
                            $(\"#namaDokter\").val(\"$data->nama_pegawai\");
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->nama_pegawai\");
                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        'gelardepan',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
        ),
        'gelarbelakang_nama',
        'jeniskelamin',
        'notelp_pegawai',
        'nomobile_pegawai',
        array(
            'name' => 'nomorindukpegawai',
            'header' => 'NIK',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<script>
    //function pencarianForm(){
    //	$.fn.yiiGridView.update('daftarPasien-grid', {
    //        data: $('.search-form input').serialize()
    //    });
    //}
    //function setDokter(obj){
    //	var nama_pegawai = $('#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>').val();
    //	var pilih = $('#<?php echo CHtml::activeId($model, 'is_dokter'); ?>');
    //	if($(obj).is(':checked')){
    //		if(nama_pegawai == ''){
    //			window.parent.myAlert('Silakan pilih dokter terlebih dahulu!');
    //			$(obj).attr('checked', false);
    //			pilih.val(0);
    //		}
    //		pilih.val(1);
    //	}else{
    //		pilih.val(0);
    //	}
    //	
    //}
</script>