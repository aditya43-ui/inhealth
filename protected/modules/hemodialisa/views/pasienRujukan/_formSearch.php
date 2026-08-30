<fieldset>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'search-pasienrujukan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '',
        'htmlOptions' => array(),
    ));

    Yii::app()->clientScript->registerScript('search', "
    $('#search-pasienrujukan-form').submit(function(){
        $.fn.yiiGridView.update('pasienrujukan-m-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">		
<?php echo CHtml::label("Tgl Permintaan HD", 'tgl_permintaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
<?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group ">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                <div class="controls">
<?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'alphanumeric-only', 'placeholder' => 'Ketikkan No Pendaftaran', 'maxlength' => 20, 'id' => 'noPendaftaran', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                        <!--<input class ="alphanumeric-only" type="text" value="" maxlength="20" placeholder="Ketik no. pendaftaran" id="noPendaftaran" name="PasienkirimkeunitlainV[no_pendaftaran]" autofocus=true onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>    
            <div class="control-group ">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                <div class="controls">
<?php echo $form->textField($model, 'no_rekam_medik', array('class' => '', 'placeholder' => 'Ketikkan No Rekam Medik', 'maxlength' => 12, 'id' => 'noRekamMedik', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                        <!--<input class ="numbers-only" type="text" value="" maxlength="10" placeholder="Ketik no. rekam medik" id="noRekamMedik" name="PasienkirimkeunitlainV[no_rekam_medik]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div>    
            <div class="control-group ">
                <label for="namaPasien" class="control-label">Nama Pasien </label>
                <div class="controls">
<?php echo $form->textField($model, 'nama_pasien', array('class' => 'hurufs-only', 'placeholder' => 'Ketikkan Nama Pasien ', 'maxlength' => 50, 'id' => 'namaPasien', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                        <!--<input class ="hurufs-only" type="text" value="" maxlength="50" placeholder="Ketik nama pasien" id="namaPasien" name="PasienkirimkeunitlainV[nama_pasien]" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">-->
                </div>
            </div> 
        </div>
        <div class="col-sm-6">
            <?php // $this->Widget('ext.bootstrap.widgets.BootAccordion',array('id'=>'kunjungan','slide'=>true,'content' => array('content2' => array('multi' => 'multi','header' => 'Instalasi Asal','isi' => 
            //'<div class="control-group">'
            //.CHtml::label('Instalasi Asal','instalasiasal_id', array('class' => 'control-label')).
            //' <div class="controls" id="cbMenuDiet">'
            //.$form->dropDownList($model,'instalasi_nama' ,CHtml::listData(BahanmakananM::model()->findAll(array("order"=>"namabahanmakanan ASC")), 'bahanmakanan_id', 'namabahanmakanan'), array('multiple'=>true)).
            //'</div></div>'
            //,'active' => true,),),)); 
            ?>
            <div class="control-group ">
                    <?php echo Chtml::label("Instalasi Asal", 'instalasiasal_id', array('class' => 'control-label')); ?>
                <div class="controls" id="cdInstalasiAsal">
                    <?php
                    echo $form->dropDownList($model, 'instalasi_nama', CHtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_nama', 'instalasi_nama'), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'multiple'=>true,
                        'ajax' => array('type' => 'POST',
                            'url' => $this->createUrl('GetRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_nama") . '").html(data); }',
//                            'success' => 'function(data){setRuangan(data); }',
                        ),
                    ));

                    ?>
                </div>
            </div>

            <div class="control-group ">
                    <?php echo Chtml::label("Ruangan Asal", 'ruanganasal_id', array('class' => 'control-label')); ?>
                <div class="controls" id="cdRuanganAsal">
                    <?php
                    echo $form->dropDownList($model, 'ruangan_nama',array(), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'multiple'=>'multiple',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetDokterPengirimDariRuanganAsal', array(
                                'encode' => false,
                                'namaModel' => get_class($model)
                            )),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "nama_pegawai") . '").html(data)}'
                        )
                    ));
                    ?>
                </div>
            </div>

            <div class="control-group ">
<?php echo Chtml::label("Dokter Pengirim", 'dokterpengirim_id', array('class' => 'control-label')); ?>
                <div class="controls">
<?php echo $form->dropDownList($model, 'nama_pegawai', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'multiple'=>'multiple')); ?>
                </div>
            </div>



<?php //echo $form->dropDownListRow($model, 'nama_pegawai', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50)); ?>

        </div>
    </div>                              
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
        <?php
        $content = $this->renderPartial('../tips/informasiPasienRujukan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>	
    </div>
<?php $this->endWidget(); ?>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if (isset($_GET['DokterV'])) {
    $modDokter->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchAllDokter(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->namaLengkap\");                            
                            $(\"#' . CHtml::activeId($model, 'namaDokter') . '\").val(\"$data->nama_pegawai\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only')),
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });                '
    . '}',
));

$this->endWidget();
?>

<script>
    function cekClear() {
        var nama_pegawai = $("#PasienkirimkeunitlainV_nama_pegawai").val();

        if (nama_pegawai == '') {
            $("#PasienkirimkeunitlainV_namaDokter").val('');
        }
    }
</script>