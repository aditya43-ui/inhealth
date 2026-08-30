<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'permintaanDarah-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

if ($this->init != 'OK') {
    $hide = '';
    $show = 'hide';
}else{
    $hide = 'hide';
    $show = '';
}
?>
<div class="panel panel-primary panel-success <?php echo $hide; ?>">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . 'formPasien', array(
            'modPendaftaran' => $modPendaftaran,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modPermintaanDarahDet' => $modPermintaanDarahDet,
            'format' => $format,
            'modPasien' => $modPasien,
            'form' => $form,
        ));
        ?>
    </div>
</div>
<?php
if ($this->init == 'OK') {
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'jenisobat',
        'slide' => true,
        'content' => array(
            'content2' => array(
                'multi' => 'multi',
                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan riwayat')) . ' Riwayat WO - Permintaan Darah',
                'isi' => $this->renderPartial($this->path_view.'_tabelRiwayat', array(
                    'model' => $modRiwayat,
                        ), true),
                'active' => false,
            ),
        ),
    ));
} 
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Permintaan Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . 'formPermintaan', array(
            'modPendaftaran' => $modPendaftaran,
            'modPermintaanDarah' => $modPermintaanDarah,
            'modPermintaanDarahDet' => $modPermintaanDarahDet,
            'format' => $format,
            'modPasien' => $modPasien,
            'form' => $form,
            'modPermintaanPenunjang' => $modPermintaanPenunjang
        ));
        ?>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Permintaan Darah</div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                if(!empty($_GET['permintaandarah_id'])){
                    echo '<table class="table table-bordered table-condensed" id="table-detailbarang">
                            <thead>
                                <tr>                  
                                    <th>Jenis Darah Yang Dibutuhkan</th>
                                    <th>Indikasi</th>
                                    <th style="text-align: center;">Rencana Transfusi <br> Tanggal & Jam</th>
                                    <th style="text-align: center;">Batal</th>
                                </tr>
                            </thead>
                            <tbody>';
                                $cekPermintaanDarahDet = BDPermintaandarahdetT::model()->findAllByAttributes(array('permintaandarah_id' => $_GET['permintaandarah_id']));
                                $i = 0;
                                foreach ($cekPermintaanDarahDet as $val) {
                                    $modPermintaanDarahDet = BDPermintaandarahdetT::model()->findByPk($val->permintaandarahdet_id);
                                    $modKomponendarah = KomponendarahM::model()->findByAttributes(array('singkatan_komp' => $val->singkatan_komp));
                                    $this->renderPartial($this->path_view . '_detailPermintaanDarahUbah', array(
                                        'modPermintaanDarahDet' => $modPermintaanDarahDet,
                                        'modKomponendarah' => $modKomponendarah,
                                        'modPasien' => $modPasien,
                                        'i' => $i++
                                    ));
                                }
                    echo '</tbody>
                        </table>';
                } else {
                    $this->renderPartial($this->path_view . '_tableDetail', array(
                        'modPendaftaran' => $modPendaftaran,
                        'modPermintaanDarah' => $modPermintaanDarah,
                        'modPermintaanDarahDet' => $modPermintaanDarahDet,
                        'format' => $format,
                        'modPasien' => $modPasien,
                        'form' => $form
                    ));
                }
                ?>			
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
            
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosa X <span class="required">*</span>','',array('class'=>'control-label')); ?>
                    <div class="controls">
                       
                            <?php
                            echo $form->hiddenField($modkirimkeunitlain, 'pasienkirimkeunitlain_id', ['id' => 'pasienkirimkeunitlain_id']);
                            echo $form->hiddenField($modkirimkeunitlain, 'diagnosa_id', ['id' => 'diagnosa_id']);
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modkirimkeunitlain,
                                'attribute' => 'diagnosa_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                        url: "' . Yii::app()->createUrl('ActionAutoComplete/Diagnosa') . '",
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
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.diagnosa_nama);
                                        $("#diagnosa_id").val( ui.item.diagnosa_id);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 required'
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDiagnosa'),
                            ));
                            ?>
                      
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Diagnosis','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modkirimkeunitlain, 'diagnosis',[ 'class' => 'span4']) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Keterangan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modkirimkeunitlain, 'catatandokterpengirim',[ 'class' => 'span4']) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <?php echo $form->radioButtonListInlineRow($modPermintaanPenunjang, 'pernah_transfusi', array('Ya' => 'Ya', 'Tidak' => 'Tidak', 'Tidak Tahu' => 'Tidak Tahu'), array('class' => 'reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'showTanggal(this)')); ?>
                    <div class="control-group tgl_transfusisebelumnya" hidden>
                        <?php echo CHtml::label("Tanggal Transfusi Sebelumnya", '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $modPermintaanPenunjang->tgl_transfusisebelumnya  = MyFormatter::formatDateTimeForUser($modPermintaanPenunjang->tgl_transfusisebelumnya );
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPermintaanPenunjang,
                                'attribute' => 'tgl_transfusisebelumnya',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group tgl_transfusisebelumnya" hidden>
                        <?php echo CHtml::label("Macam Transfusi", '', array('class' => 'control-label')) ?>
                        <?php echo CHtml::dropDownList('macam_transfusi','', CHtml::listData(JeniskomponendarahM::model()->findAll('jeniskantongdarah_aktif is true'),'jeniskantongdarah_singkatan','jeniskantongdarah_singkatan'),array('class'=>'span3','empty'=>'-- Pilih --')) ?>
                    </div>
                    <?php echo $form->radioButtonListInlineRow($modPermintaanPenunjang, 'rekasi_transfusi', array('Ya' => 'Ya', 'Tidak' => 'Tidak', 'Tidak Tahu' => 'Tidak Tahu'), array('class' => 'reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Gejala Reaksi Transfusi', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($modPermintaanPenunjang, 'gejala_transfusi', array('readonly' => false, 'class' => 'span3 gejala_transfusi')); ?>
                    </div>
                    <div class="tidak">     
                        <div class='controls'>
                            <?php echo $form->checkBox($modPermintaanPenunjang, 'is_tidak', array('class' => 'negatif-anemia', 'onclick' => 'gejalaTransfusi(this)')); ?><label>Tidak Tahu</label>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                        <?php echo CHtml::label("Tanggal Permintaan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $modPermintaanPenunjang->tglpermintaankepenunjang  = MyFormatter::formatDateTimeForUser($modPermintaanPenunjang->tglpermintaankepenunjang );
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modPermintaanPenunjang,
                            'attribute' => 'tglpermintaankepenunjang',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label('Dokter DPJP <span class="required">*</span>', 'pegawai_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
                    <div class="controls">    
                        <?php
                        echo $form->hiddenField($modkirimkeunitlain, 'pegawai_id', array());
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modkirimkeunitlain,
                            'attribute' => 'pegawai_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePetugas') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#dpjp_nama").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'pegawai_nama') . '").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array(
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 required'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPetugas_dpjp'),
                        ));
                        ?>
                    </div>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div class="control-group" hidden>
                        <?php echo CHtml::label('Petugas', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modkirimkeunitlain, 'pegpemesan_id', array('disabled' => true, 'class' => 'span3')); ?>
                        <?php echo $form->textField($modkirimkeunitlain, 'pegpemesan_nama', array('disabled' => true, 'class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                        <?php echo CHtml::label('PPDS', 'ppds_id', array('class' => 'control-label', 'label' => 'DPJP')); ?>
                    <div class="controls">    
                        <?php
                        echo $form->hiddenField($modkirimkeunitlain, 'ppds_id', array());
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modkirimkeunitlain,
                            'attribute' => 'ppds_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompletePetugas') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#dpjp_nama").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'ppds_id') . '").val(ui.item.ppds_id);
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'ppds_nama') . '").val(ui.item.ppds_nama);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array(
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPPDS'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group hide">
                        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label', 'label' => 'Ruangan')); ?>
                    <div class="controls">    
                        <?php
                        echo $form->hiddenField($modkirimkeunitlain, 'ruangan_id', array());
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modkirimkeunitlain,
                            'attribute' => 'ruangan_nama',
                            'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteRuangan') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'ruangan_id') . '").val(ui.item.ruangan_id);
                                            $("#' . CHtml::activeId($modkirimkeunitlain, 'ruangan_nama') . '").val(ui.item.ruangan_nama);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array(
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="form-actions">
            <?php if (isset($_GET['lihat'])) { ?>
                <?php echo ""; ?>
            <?php }else{ ?>
                <?php
                $btnSimpan = $modPendaftaran->isPasienPulangAtauTindakLanjut($_GET['konsulpoli_id'] ?? null);
                if (empty($_GET['detail'])) {
                    if(!$btnSimpan) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                        echo "&nbsp;";
                    }
                }
                ?>
                <?php
                if (empty($_GET['pendaftaran_id'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Resets', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-danger',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index', array('pendaftaran_id' => $_GET['pendaftaran_id'])) . '";} ); return false;'));
                }
                ?>
                <?php
                if (isset($_GET['sukses']) || isset($_GET['detail'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PDF')", 'disabled' => false));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                }
                ?>
            <?php }?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function gejalaTransfusi(obj) {
        if($(obj).is(':checked')) {
            $('.gejala_transfusi').removeClass('required');
            $('.gejala_transfusi').attr('readonly', 'true');

        } else {
            $('.gejala_transfusi').removeAttr('readonly');
            
        }
    }

    function print(caraPrint)
    {
        var permintaandarah_id = '<?php echo isset($_GET['permintaandarah_id']) ? $_GET['permintaandarah_id'] : null; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&permintaandarah_id=' + permintaandarah_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    function printRiwayat(caraPrint, permintaandarah_id)
    {
        window.open('<?php echo $this->createUrl('print'); ?>&permintaandarah_id=' + permintaandarah_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'modPermintaanDarah' => $modPermintaanDarah,
    'modPermintaanDarahDet' => $modPermintaanDarahDet,
    'format' => $format,
    'modPasien' => $modPasien,
    'form' => $form
));
?>	
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosa = new DiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {

                $attr = CJSON::encode($data->attributes);

                return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                    'class' => 'btn-small',
                    'id' => 'selectPasien',
                    'onclick' => "
                        $('#BDPasienKirimKeUnitLainT_diagnosa_nama').val('".$data->diagnosa_nama."');
                        $('#diagnosa_id').val('".$data->diagnosa_id."');
                        $('#dialogDiagnosa').dialog('close'); return false;"
                ));
            },
        ),
        'diagnosa_kode',
        array(
            'header' => 'Diagnosis',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Catatan',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Petugas Pengambilan Sample ==========
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas_sample',
    'options' => array(
        'title' => 'Daftar Petugas Pengambilan Sample',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawai->ruangan_id = $ruangan_id;
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugassample-m-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
                                                $(\'#' . Chtml::activeId($modPermintaanDarah, 'peg_pengambilsampel_id') . '\').val(\'$data->pegawai_id\');						
						$(\'#peg_pengambilsampel_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas_sample\').dialog(\'close\');
						return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '$data->jabatan_nama',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog pegawai dpjp =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas_dpjp',
    'options' => array(
        'title' => 'Daftar Dokter Penanggung Jawab Pelayanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegRuangan');
$ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawai->ruangan_id = $ruangan_id;
$modPegawai->kelompokpegawai_id = 1;
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];
$modPegawai->kelompokpegawai_id = 1;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasdpjp-m-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modkirimkeunitlain, 'pegawai_id') . '\').val(\'$data->pegawai_id\');
						$(\'#' . Chtml::activeId($modkirimkeunitlain, 'pegawai_nama') . '\').val(\'$data->nama_pegawai\');
						
						$(\'#dpjp_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas_dpjp\').dialog(\'close\');
						return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '$data->jabatan_nama',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Nomor Handphone',
            'value' => '$data->nomobile_pegawai',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
    function cekPermintaan(){
        var cek = $("#table-detailbarang > tbody > tr ").length;
        
        if (cek == 0){
            return false;
        }
        
        return true;
    }
    
    $(document).ready(function () {
        renameInputRowBarang($("#table-detailbarang"));     
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this,cekPermintaan);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form',cekPermintaan);
        });
        
        cekDisabled('form',cekPermintaan);
    });
</script>
