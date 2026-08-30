<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'laporan-search',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin label.checkbox {
            width: 200px;
            display: inline-block;
        }

        label.checkbox,
        label.radio {
            width: 260px;
            display: inline-block;
        }
    </style>

    <div class="row">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php /*<div class="col-sm-4">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<?php echo CHtml::label('Tgl. Inventarisasi', 'tglterimabahan', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('onchange'=>'ubahJnsPeriode();')); ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class='control-group hari'>
				<?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
				   <?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_awal',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
					<?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
				</div> 

			</div>
			<div class='control-group bulan'>
				<?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
					<?php 
						$this->widget('MyMonthPicker', array(
							'model' => $model,
							'attribute' => 'bln_awal', 
							'options'=>array(
								'dateFormat' => Params::MONTH_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));  
					?>
					<?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
				</div> 
			</div>
			<div class='control-group tahun'>
				<?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php 
					echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
					?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class='control-group hari'>
				<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate'=>'d',
						),
						'htmlOptions' => array('readonly' => true,
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
					<?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
				</div> 
			</div>
			<div class='control-group bulan'>
				<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				<div class="controls"> 
					<?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
					<?php 
						$this->widget('MyMonthPicker', array(
							'model' => $model,
							'attribute' => 'bln_akhir', 
							'options'=>array(
								'dateFormat' => Params::MONTH_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));  
					?>
					<?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
				</div> 
			</div>
			<div class='control-group tahun'>
				<?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php 
					echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
					?>
				</div>
			</div>
		</div>     */ ?>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo Chtml::label("Nama Barang", 'barang_nama', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_nama', array('placeholder' => 'Nama Barang', 'class' => 'span4')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("Kode Barang", 'barang_kode', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_kode', array('placeholder' => 'Kode Barang', 'class' => 'span4')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("Merk", 'barang_merk', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_merk', array('placeholder' => 'Merk', 'class' => 'span4')) ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo Chtml::label("No Seri", 'barang_noseri', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'barang_noseri', array('placeholder' => 'No Seri', 'class' => 'span4')) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'stok', array('disabled' => 'disabled')) .
                '<div class="control-group">
                ' . CHtml::label('Stok Barang', 'stok', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'stok', array('0' => 'Habis', '1' => 'Stok Ada'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                </div>
            </div>';

            echo CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                    $model,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                    </div>
                </div>';
            ?>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-sm-6">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'stok',
                'slide' => true,
                'content' => array(
                    'content2' => array(
                        'multi' => 'multi',
                        'header' => 'Berdasarkan Stok Barang',
                        'isi' => CHtml::hiddenField('filter', 'stok', array('disabled' => 'disabled')) .
                            '<div class="control-group">
                                    ' . CHtml::label('Stok Barang', 'stok', array('class' => 'control-label')) . ' 
                                    <div class="controls">
                                        ' . $form->dropDownList($model, 'stok', array('0' => 'Habis', '1' => 'Stok Ada'), array(
                                'class' => 'form-control', 'multiple' => 'multiple'
                            )) . '
                                    </div>
                                </div>',
                        'active' => true,
                    ),
                ),
            ));
            ?>-->
    <!--div class="control-group">
				<?php //echo Chtml::label("Stok Barang",'stok',array('class'=>'control-label')) 
                ?>
				<div class="controls">
					<?php //echo $form->dropDownList($model, 'stok',array('0'=>'Habis','1'=>'Stok Ada'),array('class'=>'span4','empty'=>'-- Pilih --')) 
                    ?>
				</div>
			</div-->
    <!--</div>
        <div class="col-sm-6">
            <div id='searching'>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'instalasi',
                    'slide' => true,
                    'content' => array(
                        'content3' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Instalasi dan Ruangan',
                            'isi' => CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
										' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
										<div class="controls">
											' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
										</div>
									</div>
									<div class="control-group">
										' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
										<div class="controls">												 
											' . $form->dropDownList(
                                    $model,
                                    'ruangan_id',
                                    array(),
                                    array('class' => 'form-control', 'multiple' => 'multiple')
                                ) . '
										</div>
									</div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>-->
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t(
            'mds',
            '{icon} Search',
            array('{icon}' => '<i class="entypo-search"></i>')
        ), array(
            'title' => 'Cari',
            'class' => 'btn btn-danger',
            'type' => 'submit', 'id' => 'btn_simpan'
        )); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#supplier").find("input").attr("checked", "checked");
 
',  CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#GZLaporanmakanangiziV_tgl_awal').val(data.periodeawal);
            $('#GZLaporanmakanangiziV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode', $js, CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            myAlert('Silakan pilih kategori pencarian!');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }

    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
        var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
        var pelayanan = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');
        var tujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruangantujuan_id') ?>');
        var penunjang = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpenunj_id') ?>');
        var obat = jQuery('#<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>');
        var cara_keluar = jQuery('#<?php echo CHtml::activeId($model, 'carakeluar') ?>');
        var tindakan = jQuery('#<?php echo CHtml::activeId($model, 'tindakansudahbayar_id') ?>');
        var jenispenjualan = jQuery('#<?php echo CHtml::activeId($model, 'jenispenjualan') ?>');
        var statusbayar = jQuery('#<?php echo CHtml::activeId($model, 'statusbayar') ?>');
        var instalasiasal_nama = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
        var ruanganasal_nama = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');
        var obatalkes_kategori = jQuery('#<?php echo CHtml::activeId($model, 'obatalkes_kategori') ?>');
        var pegawai = jQuery('#<?php echo CHtml::activeId($model, 'pegawai_id') ?>');
        var kunjungan = jQuery('#<?php echo CHtml::activeId($model, 'kunjungan') ?>');
        var instalasiasal_id = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
        var ruanganasal_id = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
        var asalrujukan_id = jQuery('#<?php echo CHtml::activeId($model, 'asalrujukan_id') ?>');
        var namaperujuk = jQuery('#<?php echo CHtml::activeId($model, 'namaperujuk') ?>');
        var nama_pegawai = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');
        var supplier_id = jQuery('#<?php echo CHtml::activeId($model, 'supplier_id') ?>');
        var kondisi_barang = jQuery('#<?php echo CHtml::activeId($model, 'kondisi_barang') ?>');
        var stok = jQuery('#<?php echo CHtml::activeId($model, 'stok') ?>');

        jQuery(instalasiasal_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = '';
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();

        jQuery(instalasiasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = '';


                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = '';


                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = '';


                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select propinsi dan kabupaten
         */

        jQuery(prop).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = '';


                kab.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(kab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pelayanan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tujuan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(penunjang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obat).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(cara_keluar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tindakan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(jenispenjualan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statusbayar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(instalasiasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obatalkes_kategori).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kunjungan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganasal_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(asalrujukan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(namaperujuk).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(nama_pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(supplier_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kondisi_barang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(stok).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>