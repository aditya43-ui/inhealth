<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarPasien-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pasien'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <label for="namaPasien" class="control-label">
                <?php echo CHtml::activecheckBox($model, 'ceklis', array('id' => 'namaPasien', 'uncheckValue' => 0, 'onClick' => 'cekTanggal()', 'rel' => 'tooltip', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal')); ?>
                Tanggal Pindah
            </label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $prefix = array(
                    0 => Params::PREFIX_RAWAT_DARURAT,
                    1 => Params::PREFIX_RAWAT_INAP,
                    2 => Params::PREFIX_RAWAT_JALAN
                );
                echo $form->dropDownList($model, 'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix), array('class' => 'numbers-only', 'style' => 'width:75px;'));
                ?>
                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10, 'placeholder' => 'No. Pendaftaran')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6)); ?>
        <?php //echo $form->textField($model,'nama_pegawai',array('placeholder'=>'Dokter PJP','class'=>'span4 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
        ?>
        <?php //echo $form->dropDownList($model, 'nama_pegawai' ,  CHtml::listData(DokterV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ORDER BY nama_pegawai ASC"), 'nama_pegawai', 'namaLengkap') ,array('empty' => '-- Pilih --')) 
        ?>
        <?php
        $pegawai = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        ), array(
            'order' => 'nama_pegawai',
            'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM
        ));
        $pegawaiUmum = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
            'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
        ), array(
            'order' => 'nama_pegawai',
        ));
        echo $form->dropDownListRow($model, 'dokterpenerima_id', CHtml::listData($pegawaiUmum, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4'));
        echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($pegawai, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span4'));
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                //                      'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
            'class' => 'span4',
        )); ?>
        <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Ruangan Tujuan", 'ruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $ruangan = RIPasienAdmisiT::model()->getRuanganCustom(
                    array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU),
                    array(Yii::app()->user->getState('ruangan_id'))
                );
                echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'),
                    array(
                        'empty' => '-- Pilih --',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span4',
                        'onchange' => 'getKelasPelKamarRuangan(this);'
                    )
                );
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelaspelayanan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("Kamar Ruangan", 'kamarruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kamarruangan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
            </div>
        </div>
    </div>
</div>
<!--fieldset class="box"-->
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang2'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--</fieldset>-->
<script>
    document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style", "display:none;");
    document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style", "display:none;");

    function cekTanggal() {
        var checklist = $('#RIPasienriyangpindahV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('RIPasienriyangpindahV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RIPasienriyangpindahV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function cekClear() {
        var nama_pegawai = $("#RIPasienriyangpindahV_nama_pegawai").val();
        if (nama_pegawai == '') {
            $("#RIPasienriyangpindahV_namaDokter").val('');
        }
    }

    function getKelasPelKamarRuangan(obj) {
        var ruangan_id = $(obj).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/ActionAjax/GetKelasPelKamarRuangan'); ?>',
            data: {
                ruangan_id: ruangan_id
            },
            dataType: "json",
            success: function(data) {
                $("#RIPasienriyangpindahV_kelaspelayanan_id").find('option').remove().end().append(data.kelasPelayanan);
                $("#RIPasienriyangpindahV_kamarruangan_id").find('option').remove().end().append(data.kamarRuangan);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Pencarian Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
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
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (count((array)$j) > 0) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id',  Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
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