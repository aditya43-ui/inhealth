<?php $linkHalaman = CustomFunction::getUrlByMenuID(1515); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
$this->breadcrumbs = array(
    'Transaksi Visite Dokter'
);
?>
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
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-hospital-user"></i> Transaksi <b>Visite Dokter</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!--div class="search-form"--->
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::label('Jenis Visite', 'Jenis Visite', array()); ?>
                            </div>
                            <div class="controls">
                                <?php
                                echo CHtml::dropDownList('jenisVisite', null, CHtml::listdata(RIDaftarTindakanM::model()->findAll('daftartindakan_visite=TRUE AND daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC'), "daftartindakan_id", "daftartindakan_nama"), array(
                                    'empty' => '-- Pilih --',
                                    'onchange' => 'getDokterVisite();',
                                ));
                                ?>
                                <?php /* $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'jenisVisite',    
                                    'value'=>'',
                                    'sourceUrl'=> $this->createUrl('GetDaftarTindakanVisite'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 2,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                        'select'=>'js:function( event, ui ) {
                                         samakanVisite(ui.item.daftartindakan_id);
                                                  }'
                                    ),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                                    )); */ ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo CHtml::label('Pegawai Visite <span class="required"> *</span>', 'Nama Pegawai', array()); ?>
                            </div>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'namaDokter',
                                    'value' => '',
                                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/GetDokterJenisKelamin'),
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val( ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($model, 'pegawai_id') . '").val( ui.item.pegawai_id);
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                samakanDokter(ui.item.pegawai_id);
                                            }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogDokter'),
                                    'htmlOptions' => array('placeholder' => 'Pegawai Visite', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                )); ?>
                                <?php echo CHtml::activeHiddenField($model, 'nama_pegawai', array('class' => 'span4')); ?>
                                <?php echo CHtml::activeHiddenField($model, 'pegawai_id', array('class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group" style="padding-left: 124px;">
                            <label class='controls'>
                                <?php echo CHtml::activeCheckBox($model, 'is_dokter', array('style' => 'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                                Dokter Penanggung Jawab
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <div class="control-label">No. Rekam Medik</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'no_rekam_medik', array('class' => 'span3', 'placeholder' => 'No. Rekam Medik')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">Nama Pasien</div>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'nama_pasien', array('class' => 'span3', 'placeholder' => 'Nama Pasien')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'searchVisite();')); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Visite Dokter</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <table class="items table table-bordered table-striped table-condensed" id="table-visite">
                    <thead>
                        <tr>
                            <th>Tanggal Admisi/<br>Masuk Kamar</th>
                            <th>Tgl. Pendaftaran/<br>No. Pendaftaran</th>
                            <th>No. Rekam Medik</th>
                            <th>Nama Pasien / Alias</th>
                            <th>Jenis Kelamin</th>
                            <th>Jenis Penjamin / Penjamin</th>
                            <th>Kamar/</br>Kelas Pelayanan</th>
                            <th>Kasus Penyakit</th>
                            <th>Dokter Penanggung Jawab</th>
                            <th>Visite Dokter <span class="required"> *</span></th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--div-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Form <b>Visite Dokter</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <div class="control-label">
                        <?php echo CHtml::label('Tgl. Visite <span class="required"> *</span>', 'Tanggal Visite *', array()); ?>
                    </div>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'name' => 'tanggalVisite',
                            'value' => Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd hh:mm:ss')
                            ),
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 isRequired'
                            ),
                        ));
                        ?>
                    </div>
                </div>
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
            );
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/TransaksiVisiteDokter/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<!--<legend class="rim">Berdasarkan tanggal</legend>-->
<?php
//$this->renderPartial('_rowVisiteDokter',array('model'=>$model));
?>
<?php
$this->endWidget();
$urlCekTarifTindakan = Yii::app()->createUrl('rawatInap/TransaksiVisiteDokter/getTarifTindakan');
$urlCekDokter = Yii::app()->createUrl('rawatInap/TransaksiVisiteDokter/cekDokter');
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
function cekDokter(obj,change){
        var daftartindakan_id = $(obj).parents('tr').find("select[name*='[daftartindakan_id]']").val();
        var pendaftaran_id = $(obj).parents('tr').find("input[name*='[pendaftaran_id]']").val();
        var pegawai_id = $(obj).parents('tr').find("input[name*='[pegawai_id]']").val();
        $.post("${urlCekDokter}", { daftartindakan_id: daftartindakan_id, pendaftaran_id: pendaftaran_id, pegawai_id:pegawai_id },
            function(data){
                if (data.sukses == 1){
                    if(data.status == 'ada')
                    {
                        if (change == 'change'){
                            myAlert('Maaf, Jenis Visite ini hanya bisa di kunjungi 1 kali.')
                        }
                       $(obj).parents('tr').find('.ceklist').attr('style','display:none;');
                        $(obj).parents('tr').find('#dokterDPJP').attr('style','display:block;');
                    }
                    else
                    {
                        $(obj).parents('tr').find('.ceklist').attr('style','display:block;');
                        $(obj).parents('tr').find('#dokterDPJP').attr('style','display:none;');
                    }
                }else{
                    myAlert(data.pesan);
                }                
        }, "json");
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
                            myAlert('Maaf, Daftar Tindakan tidak memiliki tarif');
                            $(obj).parent().find('.ceklist').attr('checked',false);
                        }
                }, "json");
            }else{
                myAlert('Silakan pilih jenis Visite Dokter');
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
                myAlert('Harap Isi Semua Yang Bertanda *')
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
        myAlert('Anda Belum Memilih Pasien');
      }else if(validasiDokter=='Tidak'){
        myAlert('Harap Isi Semua Data Dokter Yang Diperlukan');
      }else if (validasiVisite=='Tidak'){
        myAlert('Harap Isi Semua Data Visite Yang Diperlukan');
      }else{
        //$('#btn_simpan').click();
		$('#pasienVisite-form').submit();		
//        myAlert('simpan');
      }    
    }
JS;
Yii::app()->clientScript->registerScript('sasfsddfsgfhgdfgsgsdg', $js, CClientScript::POS_HEAD);
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian <span id="kelpeg">Dokter</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modDokter = new PegawairuanganV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modDokter->pegawai_aktif = TRUE;
if (isset($_GET['PegawairuanganV'])) {
    $modDokter->attributes = $_GET['PegawairuanganV'];
    $modDokter->is_dokterumum = $_GET['PegawairuanganV']['is_dokterumum'];
    $modDokter->pegawai_aktif = TRUE;
}
$prov = $modDokter->search();
if ($modDokter->is_dokterumum == 1) {
    $prov->criteria->addCondition('jabatan_id = ' . Params::JABATAN_ID_DOKTER_UMUM);
} else {
    $prov->criteria->addCondition('jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM);
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $prov,
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
                            $(\"#namaDokter\").val(\"$data->namaLengkap\");
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->namaLengkap\");
                            $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))',
            'filter' => CHtml::activeHiddenField($modDokter, 'is_dokterumum', array('class' => 'is_dokterumum'))
                . CHtml::activeHiddenField($modDokter, 'kelompokpegawai_id', array('class' => 'kelompokpegawai_id')),
        ),
        //'gelardepan',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama',
            'value' => '$data->namaLengkap',
        ),
        //'gelarbelakang_nama',
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
    function getDokterVisite() {
        var jenisVisite = $("#jenisVisite").val();
        $("#namaDokter, #RIInfopasienmasukkamarV_nama_pegawai, #RIInfopasienmasukkamarV_pegawai_id").val(null);
        if (jenisVisite == <?php echo Params::DAFTARTINDAKAN_ID_VISITE_UMUM; ?>) {
            $(".is_dokterumum").val(1);
        } else {
            $(".is_dokterumum").val(0);
        }
        if (jenisVisite == <?php echo Params::DAFTARTINDAKAN_ID_VISITE_PERAWAT; ?>) {
            $(".kelompokpegawai_id").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN; ?>);
            $("#kelpeg").html("Perawat");
        } else {
            $(".kelompokpegawai_id").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK; ?>);
            $("#kelpeg").html("Dokter");
        }
        $("#table-visite tbody").empty();
        $.fn.yiiGridView.update('pegawaiYangMengajukan-m-grid', {
            data: $('#pegawaiYangMengajukan-m-grid :input').serialize()
        });
        console.log(jenisVisite);
    }
</script>