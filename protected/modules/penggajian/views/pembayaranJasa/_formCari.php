<style>
    #checkBoxList {
        width: 100%;
    }

    #checkBoxList label.checkbox {
        width: 150px;
        display: inline-block;
    }
</style>

<?php
$model2 = clone $model;
$model2->tgl_awalPenunjang = date('d/m/Y', strtotime($model2->tgl_awalPenunjang));
$model2->tgl_akhirPenunjang = date('d/m/Y', strtotime($model2->tgl_akhirPenunjang));

$model2->tgl_awalPendaftaran = date('d/m/Y', strtotime($model2->tgl_awalPendaftaran));
$model2->tgl_akhirPendaftaran = date('d/m/Y', strtotime($model2->tgl_akhirPendaftaran));

?>

<!--fieldset class="box" id="formCari"-->
<div class="row" id="formCari">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Jasa ', 'komponentarif_id', array('class' => 'control-label')); ?>
            <!--span class="control-label"></span-->
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'komponentarif_id',
                    CHtml::listData(KomponentarifM::model()->getItemPembayaranJasa(), 'komponentarif_id', 'komponentarif_nama'),
                    array('onchange' => 'pilihDokter();', 'class' => 'span4 komponentarif_id', 'multiple' => 'multiple')
                ); ?>

            </div>
        </div>
        <div class="control-group" id="formTglPendaftaranAwal">
            <?php echo CHtml::label('Periode Jasa', 'tgl_awalPendaftaran', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php

                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awalPendaftaran',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                        'yearRange' => "-100y:+0y",
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'class' => "span2",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));

                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(" carabayar_aktif = TRUE ORDER BY carabayar_nama ASC "), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control carabayar_id', 'multiple' => 'multiple'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control penjamin_id', 'multiple' => 'multiple')
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group" id="formDokter">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label', 'label' => 'Nama Dokter')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaiNama',
                    'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('GetDokterSpesialis') . '",
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
									$(this).val("");
									return false;
								 }',
                        'select' => 'js:function( event, ui ) {
									$(this).val(ui.item.NamaLengkap);
									$("#GJPembayaranjasaT_pegawai_id").val(ui.item.pegawai_id);
									$("#GJPembayaranjasaT_pegawaiNama").val(ui.item.nama_pegawai);
                                                                        bersihTabelDetail();
                                                                        bersihFormPembayaran();
									return false;
								}',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogDokter', 'idTombol' => 'tombolDokterDialog'),
                    'htmlOptions' => array('class' => 'span3', 'placeholder' => 'Nama Tenaga Medis RS', 'onkeypress' => "return $(this).focusNextInputField(event);"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group instalasikomponen">
            <?php echo $form->labelEx($model, 'instalasi_id', array('class' => 'control-label', 'label' => 'Instalasi')); ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_aktif' => true,
                    'revenuecenter' => true,
                ), array(
                    'order' => 'instalasi_nama asc',
                )), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control instalasi_id', 'multiple' => 'multiple'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                Jenis Bukti Potong
          </label>
            <div class="controls">
                <?php echo CHtml::textField('jenis_bukti_potong', '', array(
                    'readonly' => true,
                    'class' => 'span3'
                )); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    if (!isset($_GET['id'])) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'addDetail();')
        );
    }
    ?>
</div>
<!--</fieldset>-->
<script>
    function checkAllKomponen() {
        if ($('#pilihSemua').is(':checked')) {
            $('#checkBoxList').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#checkBoxList').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAllKomponen();
</script>

<?php
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Data Pegawai Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new DokterpegawaiV();
if (isset($_GET['DokterpegawaiV'])) {
    $pegawai->attributes = $_GET['DokterpegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-t-grid',
    'dataProvider' => $pegawai->searchByDokter(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
											$(\"#GJPembayaranjasaT_rujukandari_id\").val(\"$data->pegawai_id\");
                                            $(\"#GJPembayaranjasaT_rujukandariNama\").val(\"$data->gelardepan"." "."$data->nama_pegawai".", "."$data->gelarbelakang_nama\");
											
                                            $(\"#GJPembayaranjasaT_pegawai_id\").val(\"$data->pegawai_id\");
                                            $(\"#GJPembayaranjasaT_pegawaiNama\").val(\"$data->gelardepan"." "."$data->nama_pegawai".", "."$data->gelarbelakang_nama\");
                                            $(\"#jenis_bukti_potong\").val(\"$data->jenisBuktiPotong\");
                                            bersihTabelDetail();
                                            bersihFormPembayaran();
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai'
        ),
        /*
                    array(
                        'type' => 'raw',
                        'name' => 'kelompokpegawai_id',
                        'value' => function($data) {
                            $kel = KelompokpegawaiM::model()->findByPk($data->kelompokpegawai_id);
                            return $kel->kelompokpegawai_nama;
                        },
                        'filter' => CHtml::activeDropDownList($pegawai, 'kelompokpegawai_id', CHtml::listData(
                            KelompokpegawaiM::model()->findAllByAttributes(array('kelompokpegawai_aktif' => true), array('order'=>'kelompokpegawai_nama asc')),
                        'kelompokpegawai_id', 'kelompokpegawai_nama'), array('empty'=>'-- Pilih --')),
                    ),
                 * 
                 */
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap'
        ),
        /*
                    array(
                        'header' => 'Jabatan',
                        'filter' => CHtml::activeDropDownList($pegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('empty' => '-- Pilih --')),
                        'value' => function($data){
                            $j = JabatanM::model()->findByPk($data->jabatan_id);
                            
                            if (count((array)$j)>0){
                                return$j->jabatan_nama;
                            }else{
                                return '-';
                            }
                                   
                        }
                    ),
                 * 
                 */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>

<?php
//========= Dialog buat cari data dokter =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPerujuk',
    'options' => array(
        'title' => 'Pencarian Data Perujuk',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$perujuk = new RujukandariM('search');
if (isset($_GET['RujukandariM'])) {
    $perujuk->attributes = $_GET['RujukandariM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perujuk-t-grid',
    'dataProvider' => $perujuk->search(),
    'filter' => $perujuk,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogPerujuk\").dialog(\"close\");
                                            $(\"#GJPembayaranjasaT_rujukandari_id\").val(\"$data->rujukandari_id\");
                                            $(\"#GJPembayaranjasaT_rujukandariNama\").val(\"$data->namaperujuk\");
                                            bersihTabelDetail();
                                            bersihFormPembayaran();
                                        "))',
        ),
        'namaperujuk',
        'spesialis',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>