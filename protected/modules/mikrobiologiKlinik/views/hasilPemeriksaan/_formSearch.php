<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(	
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type'=>'horizontal',
	'id'=>'search-penunjangrujukan-form',
	'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
	'htmlOptions'=>array(),
)); 
?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Pemeriksaan",'tgl_pemeriksaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="D MMM YYYY"
                    data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>"
                    data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>" class="span4">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> -
                        <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group ">
            <label for="namaPasien" class="control-label">No. Lab </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'no_lab',array('placeholder'=>'', 'class'=>'', )); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Nama Pasien </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'nama_pasien',array('placeholder'=>'', 'class'=>'hurufs-only', )); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">No. Rekam Medik </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('placeholder'=>'', 'class'=>'', )); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">DPJP </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'nama_dpjp',array('placeholder'=>'', 'class'=>'', 'maxlength'=>8)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label">Jenis Pemeriksaan </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'daftartindakan_nama',array('placeholder'=>'', 'class'=>'', 'maxlength'=>8)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Jenis Spesimen </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'samplelab_nama',array('placeholder'=>'', 'class'=>'', 'maxlength'=>8)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Cara Bayar </label>
            <div class="controls">
                <?php echo CHtml::activeTextField($model,'carabayar_nama',array('placeholder'=>'', 'class'=>'', 'maxlength'=>8)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Status Kirim </label>
            <div class="controls">
                <?php echo Chtml::activeDropDownList($model, 'is_kirimhasil',  array(true => 'Sudah Kirim', false => 'Belum Kirim'),array('empty'=>'-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="'.MyIcon::getIcons('cari').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','name'=>'submitSearch')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), 
		$this->createUrl($this->id.'/index'), 
		array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
		'onclick'=>'myConfirm("Apakah anda yakin ingin mengulang data ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        echo "&nbsp;"; ?>
    <?php 
		$content = $this->renderPartial('../tips/informasi_pasien_rujukan',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter Pengirim',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
if(isset($_GET['DokterV'])){
    $modDokter->attributes = $_GET['DokterV'];    
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modDokter->searchAllDokter(),
    'filter'=>$modDokter,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"                            
                            $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->namaLengkap\");                            
                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");                            
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        //'gelardepan',
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class'=>'numbers-only')),
        ),
         array(
            'name'=>'nama_pegawai',
            'header'=>'Nama Dokter',
            'value'=>'$data->namaLengkap',
             'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class'=>'hurufs-only')),
         ),       
        array(
            'header'=>'Jabatan',            
            'name'=>'jabatan_id',            
            'value' => function($data){
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                
                if (!empty($j)){
                    return $j->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
         ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
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
    var nama_pegawai = $("#LBPasienKirimKeUnitLainV_nama_pegawai").val();

    if (nama_pegawai == '') {
        $("#LBPasienKirimKeUnitLainV_pegawai_id").val('');
    }
}

$(document).ready(function() {
    jQuery($("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>")).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '150px',
        enableCaseInsensitiveFiltering: true
    }).hide();
});
</script>