<fieldset>
    <?php
$mycion = new MyIcon();
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'infojadwal-m-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class="control-group">		
            <?php echo CHtml::label("Tanggal Jadwal", 'periode', array('class' => 'control-label')) ?>
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
                <label class="control-label">Shift</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'shift_hd_id', CHtml::listData(ShiftHdM::model()->findAll("shift_hd_aktif = TRUE ORDER BY shift_hd_nama ASC"), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label for="noRekamMedik" class="control-label">No. RM </label>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'numbers-only span4', 'placeholder' => 'Ketikkan No Rekam Medik', 'maxlength' => 8, 'id' => 'noRekamMedik', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                </div>
            </div>  

            <div class="control-group ">
                <label for="namaPasien" class="control-label">Nama Pasien </label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nama_pasien', array('class' => 'hurufs-only span4', 'placeholder' => 'Ketikkan Nama Pasien ', 'maxlength' => 50, 'id' => 'namaPasien', 'autofocus' => true, 'onkeypress' => 'return $(this).focusNextInputField(event)')) ?>
                </div>
            </div> 

            <div class="control-group">
                <label class="control-label">Jenis Kelamin</label>
                <div class="controls">
                    <select class="span4" id="JadwalhemodialisaV_jeniskelamin" name="JadwalhemodialisaV[jeniskelamin]">
                        <option value="">-- Pilih --</option>
                        <option value="perempuan">Perempuan</option>
                        <option value="laki-laki">Laki-laki</option>
                    </select>
                </div>
            </div>

        </div>
    </div>                              
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="'.$mycion::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.$mycion::getIcons('ulang').'"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/index'), 
                            array('class'=>'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

        <?php
        $content = $this->renderPartial('../tips/informasiPasienRujukan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>	
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Jadwal', array('{icon}' => '<i class="' . MyIcon::getIcons('pdf') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "";
        echo "&nbsp;";
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

