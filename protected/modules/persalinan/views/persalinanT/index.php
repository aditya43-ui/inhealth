<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
//if($sukses > 0) 
//  Yii::app()->user->setFlash('success',"Transaksi berhasil disimpan!");

?>
<style>
.tablecustom td, .tablecustom th{
  padding: 5px;
  color: black;
}
</style>
<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Persalinan
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php // $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,'format'=>$format)); 
        ?>
        <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
        <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pspersalinan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekGinekologi(this);'),
            'focus' => '#',
        ));
        ?>

        <?php echo $this->renderPartial('_tabMenu', array(), true); ?>
        <div class='biru'>
            <div class="white">
                <?php echo $this->renderPartial('_formPersalinan', array('model' => $model, 'form' => $form), true); ?>
                <?php echo $this->renderPartial('_obsterikus', array('model' => $model, 'modPemeriksaan' => $modPemeriksaan, 'form' => $form, 'modKala' => $modKala), true); ?>
                <?php echo $this->renderPartial('_ginekologi', array('form' => $form, 'modRiwayatKehamilan' => $modRiwayatKehamilan, 'modGinekologi' => $modGinekologi,'modPemeriksaanGambar'=>$modPemeriksaanGambar), true); ?>
                <?php //echo $this->renderPartial('persalinan.views.persalinanT.partograf.index', array('form'=>$form, 'modPartograf'=>$modPartograf, 'modPartografObat'=>$modPartografObat, 'modPartografDet'=>$modPartografDet, 'model'=>$model, 'loadDataPartoDet'=>$loadDataPartoDet), true); 
                // echo $this->renderPartial('persalinan.views.persalinanT.partograf.index', array('form' => $form, 'modPartograf' => $modPartograf, 'modPartografDet' => $modPartografDet, 'model' => $model, 'getPartoDet' => $getPartoDet, 'modPartografLain' => $modPartografLain, 'getPartoLain' => $getPartoLain, 'modPendaftaran' => $modPendaftaran), true); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/daftarPasien/index'), array(
                'class' => 'btn btn-default',
                'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'
            ));
            ?>
            <?php
            $content = $this->renderPartial('../persalinanT/tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('modKala'=>$modKala,'modGinekologi'=>$modGinekologi, 'modPemeriksaan'=>$modPemeriksaan)); ?>
<?php $this->renderPartial($this->path_view.'ginekologi/_jsFunctionsAnggotaTubuh',array('modBagianTubuh'=>$modBagianTubuh, 'modGambarTubuh'=>$modGambarTubuh)); ?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugasPemeriksaan_obs',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasObs = new PegawairuanganV('searchDialogPegawai');
$modPetugasObs->unsetAttributes();
$modPetugasObs->ruangan_id = Yii::app()->user->getState("ruangan_id");
$modPetugasObs->kelompokpegawai_id = array(Params::KELOMPOKPEGAWAI_ID_BIDAN,Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK);

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasObs->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasobs-grid',
    'dataProvider' => $modPetugasObs->searchDialogPegawai(),
    'filter' => $modPetugasObs,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modPemeriksaan, 'obs_pemeriksa') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugasPemeriksaan_obs\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasObs, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasObs, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasObs, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>



<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas_kala1',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala1 = new PegawairuanganV('searchDialogPegawai');
$modPetugasKala1->unsetAttributes();
$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasKala1->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaskala1-grid',
    'dataProvider' => $modPetugasKala1->searchDialogPegawai(),
    'filter' => $modPetugasKala1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_1_petugaspemeriksa') . '\").val(\"$data->pegawai_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_1_petugaspemeriksa_nama') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugas_kala1\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala1, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala1, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasKala1, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPDS_kala1',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala1 = new PpdsM('searchDialogPPDS');
$modPetugasKala1->unsetAttributes();
//$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PpdsM'])) {
    $modPetugasKala1->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdskala1-grid',
    'dataProvider' => $modPetugasKala1->searchDialogPPDS(),
    'filter' => $modPetugasKala1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_1_ppds_id') . '\").val(\"$data->ppds_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_1_ppds_nama') . '\").val(\"$data->ppds_nama\");
                                $(\"#dialogPPDS_kala1\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
         
        array(
            'header' => 'Nama PPDS',
            'filter' =>  CHtml::activeTextField($modPetugasKala1, 'ppds_nama', array('class' => 'hurufs-only')),
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ), 
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPDS_obsterikus',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala1 = new PpdsM('searchDialogPPDS');
$modPetugasKala1->unsetAttributes();
//$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PpdsM'])) {
    $modPetugasKala1->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdsobsterikus1-grid',
    'dataProvider' => $modPetugasKala1->searchDialogPPDS(),
    'filter' => $modPetugasKala1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modPemeriksaan, 'obs_ppds_id') . '\").val(\"$data->ppds_id\");
                                $(\"#' . CHtml::activeId($modPemeriksaan, 'obs_ppds_nama') . '\").val(\"$data->ppds_nama\");
                                $(\"#dialogPPDS_obsterikus\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
         
        array(
            'header' => 'Nama PPDS',
            'filter' =>  CHtml::activeTextField($modPetugasKala1, 'ppds_nama', array('class' => 'hurufs-only')),
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ), 
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPDS_kala2',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala2 = new PpdsM('searchDialogPPDS');
$modPetugasKala2->unsetAttributes();
//$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PpdsM'])) {
    $modPetugasKala2->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdskala2-grid',
    'dataProvider' => $modPetugasKala2->searchDialogPPDS(),
    'filter' => $modPetugasKala2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_2_ppds_id') . '\").val(\"$data->ppds_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_2_ppds_nama') . '\").val(\"$data->ppds_nama\");
                                $(\"#dialogPPDS_kala2\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
         
        array(
            'header' => 'Nama PPDS',
            'filter' =>  CHtml::activeTextField($modPetugasKala2, 'ppds_nama', array('class' => 'hurufs-only')),
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ), 
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPDS_kala3',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala3 = new PpdsM('searchDialogPPDS');
$modPetugasKala3->unsetAttributes();
//$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PpdsM'])) {
    $modPetugasKala3->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdskala3-grid',
    'dataProvider' => $modPetugasKala3->searchDialogPPDS(),
    'filter' => $modPetugasKala3,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_3_ppds_id') . '\").val(\"$data->ppds_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_3_ppds_nama') . '\").val(\"$data->ppds_nama\");
                                $(\"#dialogPPDS_kala3\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
         
        array(
            'header' => 'Nama PPDS',
            'filter' =>  CHtml::activeTextField($modPetugasKala3, 'ppds_nama', array('class' => 'hurufs-only')),
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ), 
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>



<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPPDS_kala4',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala4 = new PpdsM('searchDialogPPDS');
$modPetugasKala4->unsetAttributes();
//$modPetugasKala1->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PpdsM'])) {
    $modPetugasKala4->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppdskala4-grid',
    'dataProvider' => $modPetugasKala4->searchDialogPPDS(),
    'filter' => $modPetugasKala4,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_4_ppds_id') . '\").val(\"$data->ppds_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_4_ppds_nama') . '\").val(\"$data->ppds_nama\");
                                $(\"#dialogPPDS_kala4\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
         
        array(
            'header' => 'Nama PPDS',
            'filter' =>  CHtml::activeTextField($modPetugasKala4, 'ppds_nama', array('class' => 'hurufs-only')),
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ), 
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas_kala2',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala2 = new PegawairuanganV('searchDialogPegawai');
$modPetugasKala2->unsetAttributes();
$modPetugasKala2->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasKala2->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaskala2-grid',
    'dataProvider' => $modPetugasKala2->searchDialogPegawai(),
    'filter' => $modPetugasKala2,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_2_petugaspemeriksa') . '\").val(\"$data->pegawai_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_2_petugaspemeriksa_nama') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugas_kala2\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala2, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala2, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasKala2, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas_kala3',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala3 = new PegawairuanganV('searchDialogPegawai');
$modPetugasKala3->unsetAttributes();
$modPetugasKala3->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasKala3->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaskala3-grid',
    'dataProvider' => $modPetugasKala3->searchDialogPegawai(),
    'filter' => $modPetugasKala3,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_3_petugaspemeriksa') . '\").val(\"$data->pegawai_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_3_petugaspemeriksa_nama') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugas_kala3\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala3, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala3, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasKala3, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>

<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas_kala4',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasKala4 = new PegawairuanganV('searchDialogPegawai');
$modPetugasKala4->unsetAttributes();
$modPetugasKala4->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasKala4->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaskala4-grid',
    'dataProvider' => $modPetugasKala4->searchDialogPegawai(),
    'filter' => $modPetugasKala4,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modKala, 'kala_4_petugaspemeriksa') . '\").val(\"$data->pegawai_id\");
                                $(\"#' . CHtml::activeId($modKala, 'kala_4_petugaspemeriksa_nama') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugas_kala4\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala4, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasKala4, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasKala4, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugas_ginekologi',
    'options' => array(
        'title' => 'Pencarian Petugas Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPetugasGinekologi = new PegawairuanganV('searchDialogPegawai');
$modPetugasGinekologi->unsetAttributes();
$modPetugasGinekologi->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPetugasGinekologi->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasginekologi-grid',
    'dataProvider' => $modPetugasGinekologi->searchDialogPegawai(),
    'filter' => $modPetugasGinekologi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"javascript:void(0)",
                "id" => "selectObat",
                "onClick" => "
                                $(\"#' . CHtml::activeId($modGinekologi, 'periksadalam_pemeriksa') . '\").val(\"$data->pegawai_id\");
                                $(\"#' . CHtml::activeId($modGinekologi, 'periksadalam_pemeriksa_nama') . '\").val(\"$data->NamaLengkap\");
                                $(\"#dialogPetugas_ginekologi\").dialog(\"close\"); 
                                return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' =>  CHtml::activeTextField($modPetugasGinekologi, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ), 
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasGinekologi, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ), 
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPetugasGinekologi, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function ($data) {
                return $data->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function(){'
        . 'setNumbersOnly(this);'
        . '});'
        . '$(".hurufs-only").keyup(function(){'
        . 'setHurufsOnly(this);'
        . '});'
        . '}',
));
$this->endWidget();
?>