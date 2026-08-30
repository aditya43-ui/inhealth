
<?php

//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengkajian Keperawatan / Kebidanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';

$this->endWidget();
?>

<?php

//========= Dialog buat cari Tanda dan Gejala Mayor Objektif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTandaGejalaMayorObjektif',
    'options' => array(
        'title' => 'Pilih Tanda dan Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTandaGejala = new ASTandagejalaDaftarM;
$modTandaGejala->unsetAttributes();
if (isset($_GET['ASTandagejalaDaftarM'])) {
    $modTandaGejala->attributes = $_GET['ASTandagejalaDaftarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tandagejala-mayorobjektif-m-grid',
    'dataProvider' => $modTandaGejala->searchDialogMayorObjektif(),
    'filter' => $modTandaGejala,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array('class' => 'check_all_produk', 'onchange' => 'setSemuaCeklis(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompoktandagejaladaftar_id' => $data["kelompoktandagejaladaftar_id"],
                            'onchange' => 'setTandaGejalanya1(this);',
                            'class' => 'pilih',
                            'value' => $data["kelompoktandagejaladaftar_id"]
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputTandaGejalaMayorObjektif();'))
        ),
        array(
            'header' => 'Tanda dan Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data["tandagejala_daftar_nama"]',
            'filter' => CHtml::activeTextField($modTandaGejala, 'tandagejala_daftar_nama', array('onblur' => 'setDialogMayorObjektif(this)'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekListMayorObjektif();}',
));
$this->endWidget();
?>

<?php

//========= Dialog buat cari Tanda dan Gejala Mayor Objektif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTandaGejalaMayorSubjektif',
    'options' => array(
        'title' => 'Pilih Tanda dan Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTandaGejala2 = new ASTandagejalaDaftarM;
$modTandaGejala2->unsetAttributes();
if (isset($_GET['ASTandagejalaDaftarM'])) {
    $modTandaGejala2->attributes = $_GET['ASTandagejalaDaftarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tandagejala-mayorsubjektif-m-grid',
    'dataProvider' => $modTandaGejala2->searchDialogMayorSubjektif(),
    'filter' => $modTandaGejala2,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array('class' => 'check_all_produk', 'onchange' => 'setSemuaCeklis(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompoktandagejaladaftar_id' => $data["kelompoktandagejaladaftar_id"],
                            'onchange' => 'setTandaGejalanya2(this);',
                            'class' => 'pilih',
                            'value' => $data["kelompoktandagejaladaftar_id"]
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputTandaGejalaMayorSubjektif();'))
        ),
        array(
            'header' => 'Tanda dan Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data["tandagejala_daftar_nama"]',
            'filter' => CHtml::activeTextField($modTandaGejala, 'tandagejala_daftar_nama', array('onblur' => 'setDialogMayorSubjektif(this)'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekListMayorSubjektif();}',
));
$this->endWidget();
?>

<?php

//========= Dialog buat cari Tanda dan Gejala Mayor Objektif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTandaGejalaMinorObjektif',
    'options' => array(
        'title' => 'Pilih Tanda dan Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTandaGejala3 = new ASTandagejalaDaftarM;
$modTandaGejala3->unsetAttributes();
if (isset($_GET['ASTandagejalaDaftarM'])) {
    $modTandaGejala3->attributes = $_GET['ASTandagejalaDaftarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tandagejala-minorobjektif-m-grid',
    'dataProvider' => $modTandaGejala3->searchDialogMinorObjektif(),
    'filter' => $modTandaGejala3,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array('class' => 'check_all_produk', 'onchange' => 'setSemuaCeklis(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompoktandagejaladaftar_id' => $data["kelompoktandagejaladaftar_id"],
                            'onchange' => 'setTandaGejalanya3(this);',
                            'class' => 'pilih',
                            'value' => $data["kelompoktandagejaladaftar_id"]
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputTandaGejalaMinorObjektif();'))
        ),
        array(
            'header' => 'Tanda dan Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data["tandagejala_daftar_nama"]',
            'filter' => CHtml::activeTextField($modTandaGejala3, 'tandagejala_daftar_nama', array('onblur' => 'setDialogMinorObjektif(this)'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekListMinorObjektif();}',
));
$this->endWidget();
?>

<?php

//========= Dialog buat cari Tanda dan Gejala Mayor Objektif =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTandaGejalaMinorSubjektif',
    'options' => array(
        'title' => 'Pilih Tanda dan Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

$modTandaGejala4 = new ASTandagejalaDaftarM;
$modTandaGejala4->unsetAttributes();
if (isset($_GET['ASTandagejalaDaftarM'])) {
    $modTandaGejala4->attributes = $_GET['ASTandagejalaDaftarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tandagejala-minorsubjektif-m-grid',
    'dataProvider' => $modTandaGejala4->searchDialogMinorSubjektif(),
    'filter' => $modTandaGejala4,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array('class' => 'check_all_produk', 'onchange' => 'setSemuaCeklis(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompoktandagejaladaftar_id' => $data["kelompoktandagejaladaftar_id"],
                            'onchange' => 'setTandaGejalanya4(this);',
                            'class' => 'pilih',
                            'value' => $data["kelompoktandagejaladaftar_id"]
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputTandaGejalaMinorSubjektif();'))
        ),
        array(
            'header' => 'Tanda dan Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data["tandagejala_daftar_nama"]',
            'filter' => CHtml::activeTextField($modTandaGejala4, 'tandagejala_daftar_nama', array())
        ),
    ),
    
    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); 
                            cekListMinorSubjektif();
                        }',
));
$this->endWidget();
?>

<?php

//========= Dialog buat cari Faktor Risiko =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogFaktorRisiko',
    'options' => array(
        'title' => 'Pilih Faktor Risiko',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));

$modFaktorRisiko = new ASFaktorrisikoDaftarM;
$modFaktorRisiko->unsetAttributes();
if (isset($_GET['ASFaktorrisikoDaftarM'])) {
    $modFaktorRisiko->attributes = $_GET['ASFaktorrisikoDaftarM'];
    $modFaktorRisiko->jenisfaktorrisiko_nama = $_GET['ASFaktorrisikoDaftarM']['jenisfaktorrisiko_nama'];
    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'faktorrisiko-m-grid',
    'dataProvider' => $modFaktorRisiko->searchDialog2(),
    'filter' => $modFaktorRisiko,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array('class' => 'check_all_produk', 'onchange' => 'setSemuaCeklis(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'kelompokfaktorrisikodaftar_id' => $data["kelompokfaktorrisikodaftar_id"],
                            'onchange' => 'setFaktorRisikonya(this);',
                            'class' => 'pilih',
                            'value' => $data["kelompokfaktorrisikodaftar_id"]
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputFaktorRisiko();'))
        ),
        array(
            'header' => 'Jenis Faktor Risiko',
            'name' => 'jenisfaktorrisiko_nama',
            'value' => '$data["jenisfaktorrisiko_nama"]',
            'filter' => CHtml::activeTextField($modFaktorRisiko, 'jenisfaktorrisiko_nama', array())
        ),
        array(
            'header' => 'Faktor Risiko',
            'name' => 'faktorrisiko_daftar_nama',
            'value' => '$data["faktorrisiko_daftar_nama"]',
            'filter' => CHtml::activeTextField($modFaktorRisiko, 'faktorrisiko_daftar_nama', array())
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); 
                            cekListFaktorRisiko();
                        }',
));
$this->endWidget();
?>

<?php

//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 420,
        'resizable' => false,
    ),
));

$modDiagnosaKep = new ASDiagnosakepM('searchDialog');
// $modDiagnosaKep->default  = 'kosong';
if (isset($_GET['ASDiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['ASDiagnosakepM'];
    $modDiagnosaKep->kelompoktandagejaladaftar_id = !empty($_GET['ASDiagnosakepM']['kelompoktandagejaladaftar_id']) ? $_GET['ASDiagnosakepM']['kelompoktandagejaladaftar_id'] : null;
    $modDiagnosaKep->kelompokfaktorrisikodaftar_id = !empty($_GET['ASDiagnosakepM']['kelompokfaktorrisikodaftar_id']) ? $_GET['ASDiagnosakepM']['kelompokfaktorrisikodaftar_id'] : null;
    $modDiagnosaKep->kelompoktandagejaladaftar_idnya = !empty($_GET['ASDiagnosakepM']['kelompoktandagejaladaftar_idnya']) ? $_GET['ASDiagnosakepM']['kelompoktandagejaladaftar_idnya'] : null;
    $modDiagnosaKep->kelompokfaktorrisikodaftar_idnya = !empty($_GET['ASDiagnosakepM']['kelompokfaktorrisikodaftar_idnya']) ? $_GET['ASDiagnosakepM']['kelompokfaktorrisikodaftar_idnya'] : null;
//    $modDiagnosaKep->default = !empty($_GET['ASDiagnosakepM']['default']) ? $_GET['ASDiagnosakepM']['default'] : null;
    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->searchDialog(),
    'filter' => $modDiagnosaKep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectDiagnosa",
                                    "onClick" => "
                                        setDiagnosaAuto($data->diagnosakep_id);
                                    "))'
        ),
        array(
            'header' => 'Kode Diagnosa',
            'name' => 'diagnosakep_kode',
            'value' => '$data->diagnosakep_kode',
        ),
        array(
            'header' => 'Diagnosa Keperawatan',
            'type' => 'raw',
            'name' => 'diagnosakep_nama',
            'value' => '$data->diagnosakep_nama',
        ),
        array(
            'header' => 'Deskripsi',
            'name' => 'diagnosakep_deskripsi',
            'value' => '$data->diagnosakep_deskripsi',
            'filter' => CHtml::activeTextField($modDiagnosaKep, 'diagnosakep_deskripsi', array()).Chtml::activeHiddenField($modDiagnosaKep, 'kelompoktandagejaladaftar_idnya',array('class' => 'span1')).Chtml::activeHiddenField($modDiagnosaKep, 'kelompokfaktorrisikodaftar_idnya',array('class' => 'span1')).Chtml::activeHiddenField($modDiagnosaKep, 'default',array('class' => 'span1'))
        ),
        /*
        array(
            'header' => 'Status',
            'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                    'diagnosakep_aktif', $modDiagnosaKep->diagnosakep_aktif, array('1' => 'Aktif',
                '0' => 'Tidak Aktif',), array('empty' => '-- Pilih --'))
        ),
         */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>