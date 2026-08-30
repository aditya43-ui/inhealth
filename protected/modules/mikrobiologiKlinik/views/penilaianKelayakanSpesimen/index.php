<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong>Penilaian Kelayakan Spesimen Pasien Rujukan</strong></div>
            </div>
            <div class="panel-body">
                
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'penilaiankelayakanspesimen-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#no_pendaftaran',
                ));
                ?>
                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><b>Data Rujukan</b></span></div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view_spesimen.'_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'modPpds' => $modPpds, 'modPpdsAlamat' => $modPpdsAlamat)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><b>Data Pemeriksaan Laboratorium</b></span></div>
                    </div>
                    <div class="panel-body" id="form-pemeriksaan">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view_spesimen.'_formPemeriksaan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'modPenilaian' => $modPenilaian, 'dataKirimSpesimen'=>$dataKirimSpesimen, 'modSpesimen'=>$modSpesimen, 'modSpesimen2'=>$modSpesimen2)); ?>
                        </div>
                        <div class="panel panel-success panel-shadow">
                            <div class="panel-heading">
                                <div class="panel-title"><span class='judul'><b>Tabel Pemeriksaan</b></span></div>
                            </div>
                            <div class="panel-body" id="tabel-pemeriksaan">
                                <?php
                                /*
                                $this->renderPartial($this->path_view_spesimen.'_formDialogTindakan', array(
                                    'modPemeriksaanLab' => $modPemeriksaanLab,'modKunjungan' => $modKunjungan
                                ));
                                 */
                                ?>
                                <div id="form-tindakanpemeriksaan">
                                    <table class="table table-bordered table-striped table-condensed" style="display: none">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis Pemeriksaan</th>
                                                <th>Nama Pemeriksaan</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Batal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($modPermintaanKePenunjang) > 0) {
                                                foreach ($modPermintaanKePenunjang as $key => $val) {
                                                    $criteria = new CDbCriteria();
                                                    $criteria->addCondition('daftartindakan_id = '. $val->daftartindakan_id);
                                                    $criteria->addCondition('kelaspelayanan_id = ' . $modKunjungan->kelaspelayanan_id);
                                                    $criteria->addCondition('penjamin_id = ' . $modKunjungan->penjamin_id);
                                                    $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_MIKROBIOLOGI);
                                                    $modTarif = TarifpemeriksaanlabruanganV::model()->findAll($criteria);

                                                    $id_tindakan = null;
                                                    $paket = null;
                                                    $str = "";

                                                    if (count($modTarif) > 0) {
                                                        foreach ($modTarif as $ii => $value) {
                                                            $crPaket = new CDbCriteria();
                                                            $crPaket->compare('t.daftartindakan_id', $value->daftartindakan_id);
                                                            $crPaket->addCondition('t.tipepaket_id <> ' . Params::TIPEPAKET_ID_NONPAKET);
                                                            $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
                                                            $crPaket->addCondition('p.tindakanpelayanan_id is null');
                                                            $crPaket->order = 'p.tindakanpelayanan_id asc';

                                                            $tindakanPaket = TindakanpelayananT::model()->find($crPaket);

                                                            if (!empty($tindakanPaket)) {
                                                                $id_tindakan = $tindakanPaket->tindakanpelayanan_id;
                                                                $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
                                                            }

                                                            $this->renderPartial($this->path_view_spesimen.'_formLoadPemeriksaanLab', array('key' => ($key+1), 'modTarif' => $value, 'id_tindakan' => $id_tindakan, 'paket' => $paket, 'permintaankepenunjang_id' => $val->permintaankepenunjang_id));
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-striped table-condensed" id="tabel-pemeriksaan2">
                                        <thead>
                                            <tr>
                                                <!--<th>No.</th>-->
                                                <th>Jenis Spesimen <span class="required">*</span></th>
                                                <th>Jenis/Nama Pemeriksaan <span class="required">*</span></th>
                                                <th>Status</th>
                                                <th>Kualitas Spesimen <span class="required">*</span></th>
                                                <th>Alasan</th>
                                                <th>Tambah/Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php /*
                <div id="input-spesimen">
                    <?php 
                    if(count($dataSpesimen) > 0){
                        $dataKirimSpesimen = $dataSpesimen;
                    }
                    if(count($dataKirimSpesimen) > 0 ){
                        foreach ($dataKirimSpesimen as $key => $value) {
                            $modSpesimen->attributes = $value->attributes;
                            $modSampleLab = SamplelabM::model()->findByPk($value->samplelab_id);
                            $modSpesimen->samplelab_id = $modSampleLab->samplelab_id;
                            $modSpesimen->samplelab_nama = $modSampleLab->samplelab_nama;
                            $modSpesimen->spesimen_id = isset($value->spesimen_id)? $value->spesimen_id : null;
                            if(isset($value->pemeriksaanlab_id)){
                                $modPeriksaLab = PemeriksaanlabM::model()->findByPk($value->pemeriksaanlab_id);
                                $modSpesimen->pemeriksaanlab_id = $modPeriksaLab->pemeriksaanlab_id;
                                $modSpesimen->pemeriksaanlab_nama = $modPeriksaLab->pemeriksaanlab_nama;
                            }
                    ?>
                        <div class="panel panel-success panel-shadow panel-spesimen">
                            <div class="panel-heading">
                                <?php
                                $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick'=>'tambahSpesimen(this);return false;'));
                                if($key == 0){
                                    $hapus = null;
                                }else{
                                    $icon = !empty($modSpesimen->spesimen_id)? "icon-trash" : "icon-minus";
                                    $hapus = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="'.$icon.' icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick'=>'batalSpesimen(this);return false;'));
                                }
                                if(isset($_GET['sukses'])){
                                    $tambah = null;
                                    $hapus = null;
                                }
                                ?>
                                <div class="panel-title"><span class='judul'><b>Data Spesimen</b>&nbsp;&nbsp;&nbsp;&nbsp;<?= $tambah ?>&nbsp;&nbsp;<?= $hapus ?></span></div>
                            </div>
                            <div class="panel-body" id="form-spesimen">
                                <div class="row-fluid">
                                    <?php
                                    $this->renderPartial($this->path_view_spesimen.'_formLoadSpesimenDetail', array(
                                        'modSpesimen' => $modSpesimen, 'i' => $key
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }else{
                    ?>
                        <div class="panel panel-success panel-shadow panel-spesimen">
                            <div class="panel-heading">
                                <?php
                                $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick'=>'tambahSpesimen(this);return false;'));
                                ?>
                                <div class="panel-title"><span class='judul'><b>Data Spesimen</b>&nbsp;&nbsp;&nbsp;&nbsp;<?= $tambah ?></span></div>
                            </div>
                            <div class="panel-body" id="form-spesimen">
                                <div class="row-fluid">
                                    <?php
                                    $this->renderPartial($this->path_view_spesimen.'_formLoadSpesimenDetail', array(
                                        'modSpesimen' => $modSpesimen, 'i' => 0
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                */ ?>
                
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'cekWajib();return false;')); ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('pasienkirimkeunitlain_id' => $modKunjungan->pasienkirimkeunitlain_id)), array('class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);'))."&nbsp;";
                    if (isset($modSpesimen2->spesimen_id)) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcode('$modSpesimen2->spesimen_id');return false"));
                        echo '&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printQr('$modSpesimen2->spesimen_id');return false"));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                        echo '&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                    }
                    echo "&nbsp;".CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="icon-arrow-left icon-white"></i>')), $this->createUrl('RujukanPenunjang/index', array()), array('class' => 'btn btn-danger'))."&nbsp;";
                    ?>
                </div>
                
                <?php $this->endWidget(); ?>
                <?php $this->renderPartial($this->path_view_spesimen.'_jsFunction', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'modSpesimen' => $modSpesimen)); ?>
            </div>
        </div>
    </div>
</div>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogManajerPelayanan',
    'options'=>array(
        'title'=>'Pencarian Manajer Pelayanan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogManajerPelayanan-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "select1",
                "onClick" => "$(\"#' . CHtml::activeId($modPenilaian, 'manajerpelayanan_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($modPenilaian, 'manajerpelayanan_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#dialogManajerPelayanan\").dialog(\"close\");    
                    return false;
                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDpjtm',
    'options'=>array(
        'title'=>'Pencarian DPJTM',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai -> unsetAttributes();
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP;
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogDpjtm-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "select1",
                "onClick" => "$(\"#' . CHtml::activeId($modPenilaian, 'dpjtm_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($modPenilaian, 'dpjtm_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#dialogDpjtm\").dialog(\"close\");    
                    return false;
                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width'=>600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM('search');
$modPpds->unsetAttributes();
$modPpds->ppds_aktif = true;
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
    $modPpds->programstudi_id = $_GET['PpdsM']['programstudi_id'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogPpds-m-grid',
    'dataProvider' => $modPpds->search(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                array(
                    "class"=>"btn-small", 
                    "id" => "selectPPDS",
                    "onClick" => " 
                        $(\"#' . CHtml::activeId($modPenilaian, 'ppds_id') . '\").val(\'$data->ppds_id\');
                        $(\"#' . CHtml::activeId($modPenilaian, 'ppds_nama') . '\").val(\'$data->ppds_nama\');
                        $(\'#dialogPpds\').dialog(\'close\');return false;"))'
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim'
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama'
        ),
        array(
            'header' => 'Program Studi',
            'name' => 'programstudi.programstudi_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemeriksaanSpesimen',
    'options' => array(
        'title' => 'Pencarian Pemeriksaan Spesimen',
        'autoOpen' => false,
        'modal' => true,
        'width'=>600,
        'resizable' => false,
    ),
));

$modSample = new SamplelabM('search');
$modSample->unsetAttributes();
$modSample->samplelab_aktif = true;
if (isset($_GET['SamplelabM'])) {
    $modSample->attributes = $_GET['SamplelabM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'samplelab-m-grid',
    'dataProvider' => $modSample->search(),
    'filter' => $modSample,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                if(!empty($data->kelompoksamplelab_id)){
                    $modKel = KelompoksamplelabM::model()->findByPk($data->kelompoksamplelab_id);
                    $kelompoksamplelab_nama = $modKel->kelompoksamplelab_nama;
                }else{
                    $kelompoksamplelab_nama = "";
                }
                
                return CHtml::Link("<i class='icon-form-check'></i>","#",
                    array(
                        "class"=>"btn-small", 
                        "id" => "selectSample",
                        "onClick" => " 
                            setPemeriksaanSpesimen('$data->samplelab_nama',$data->samplelab_id);
                            $('#dialogPemeriksaanSpesimen').dialog('close');return false;"
                    )
                );
            },
        ),
        array(
            'header' => 'Jenis Spesimen',
            'name' => 'kelompoksamplelab_id',
            'filter'=>  CHtml::activeDropDownList($modSample, 'kelompoksamplelab_id', CHtml::listData(
                            KelompoksamplelabM::model()->findAll(array(
                            'order'=>'kelompoksamplelab_nama',
                        )), 'kelompoksample_id', 'kelompoksamplelab_nama'), array('empty'=>'-- Pilih --')),
            'value' => function($data) {
                if(!empty($data->kelompoksamplelab_id)){
                    $modKel = KelompoksamplelabM::model()->findByPk($data->kelompoksamplelab_id);
                    return $modKel->kelompoksamplelab_nama;
                }else{
                    return "";
                }
            }
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'samplelab_nama',
            'value' => '$data->samplelab_nama'
        ),
        'kode_sample'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakanSpesimen',
    'options' => array(
        'title' => 'Pencarian Pemeriksaan Lab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 670,
        'resizable' => false,
    ),
));


$modTarif = new TariftindakanlaboratoriumV('search');
$modTarif->unsetAttributes();

if (isset($_GET['TariftindakanlaboratoriumV'])) {
    $modTarif->attributes = $_GET['TariftindakanlaboratoriumV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kegiatanprogram-m-grid',
    'dataProvider' => $modTarif->searchTindakanMikrobiologi(),
    'filter' => $modTarif,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data){
                $tarif = !empty($data->harga_tariftindakan) ? MyFormatter::formatRupiahForDB($data->harga_tariftindakan): 0;
                echo CHtml::Link("<i class='icon-form-check'></i>","#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectSample",
                                    "onClick" => " 
                                        setTindakanSpesimen('$data->pemeriksaanlab_id','$data->pemeriksaanlab_nama','$data->daftartindakan_id', $tarif);
                                        $('#dialogTindakanSpesimen').dialog('close');return false;"
                                )
                            );
            }
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama'
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanlab_nama'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<!--    <table class="table table-bordered table-striped table-condensed" id="pemeriksaan_spesimen">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>Jenis Pemeriksaan</th>
                <th>Nama Pemeriksaan</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>-->
<?php
//$this->endWidget();
?>