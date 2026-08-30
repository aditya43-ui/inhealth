<style>
    .form-horizontal .control-label{
        width: 135px;
    }
</style>
<div class="panel panel-primary panel-gradient">
    
    <div class="panel-heading">
        <div class="panel-title">Status Permintaan Darah</div>
    </div>
    <div class="panel-body">
        <?php 
            $this->renderPartial($this->path_view . '_tabelStatusPermintaanDarah',[
                'modRiwayatPermintaanDarah' => $modRiwayatPermintaanDarah
            ]);
        ?>
    </div>
</div>
<div class="panel panel-primary panel-gradient">
    
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Permintaan Darah</div>
    </div>
    <div class="panel-body">
        <?php 
            $this->renderPartial($this->path_view . '_tabelRiwayatPermintaanDarah',[
                'modRiwayatPermintaanDarah' => $modRiwayatPermintaanDarah
            ]);
        ?>
    </div>
</div>
<div class="panel panel-primary panel-gradient">
    
    <div class="panel-heading">
        <div class="panel-title">Permintaan Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs=array(
            'Permintaan Darah'=>array('index'),
            'Tambah',
        );
        
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php 
            if(isset($_GET['sukses'])){        
        ?>
            <?php echo Yii::app()->user->setFlash('success',"Data Permintaan Darah Berhasil Disimpan !"); ?>
        <?php } ?>

        <?php echo $this->renderPartial($this->path_view.'_form', array(
                'modPendaftaran'=>$modPendaftaran,
                'modPermintaanDarah'=>$modPermintaanDarah,
                'modPermintaanDarahDet'=>$modPermintaanDarahDet,
                'format'=>$format,
                'modRiwayat' => $modRiwayat,
                'modPasien'=>$modPasien,
                'modPermintaanPenunjang' => $modPermintaanPenunjang,
                'modkirimkeunitlain' => $modkirimkeunitlain
            )); ?>
    </div>

</div>

<?php
/* ====================================== Widget Dialog PPDS ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPPDS',
    'options' => array(
        'title' => 'Daftar PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPPDS = new PpdsM('searchDialog');
$modPPDS->unsetAttributes();
$modPPDS->ppds_aktif = true;
if (isset($_GET['PpdsM'])) {
    $modPPDS->attributes = $_GET['PpdsM'];
    $modPPDS->programstudi_nama = $_GET['PpdsM']['programstudi_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPPDS->searchDialog(),
    'filter' => $modPPDS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                                $(\'#' . Chtml::activeId($modkirimkeunitlain, 'ppds_id') . '\').val(\'$data->ppds_id\');	
                                $(\'#' . Chtml::activeId($modkirimkeunitlain, 'ppds_nama') . '\').val(\'$data->ppds_nama\');
                                $(\'#dialogPPDS\').dialog(\'close\');
                                return false;"))',
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
            'value' => '$data->programstudi->programstudi_nama',
            'filter' => Chtml::activeTextField($modPPDS, 'programstudi_nama')
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'filter' => Chtml::activeTextField($modPPDS, 'ppds_tahap')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Pegawai ====================================== */
?>

<?php
/* ====================================== Widget Dialog PPDS ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Daftar Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
$modRuangan = new RuanganM('search');
$modRuangan->unsetAttributes();
$modRuangan->ruangan_aktif = true;
if (isset($_GET['RuanganM'])) {
    $modRuangan->attributes = $_GET['RuanganM'];
    $modRuangan->programstudi_nama = $_GET['RuanganM']['ruangan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-m-grid',
    'dataProvider' => $modRuangan->search(),
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                                $(\'#' . Chtml::activeId($modkirimkeunitlain, 'ruangan_id') . '\').val(\'$data->ruangan_id\');	
                                $(\'#' . Chtml::activeId($modkirimkeunitlain, 'ruangan_nama') . '\').val(\'$data->ruangan_nama\');
                                $(\'#dialogRuangan\').dialog(\'close\');
                                return false;"))',
        ),
        array(
            'name'=>'ruangan_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Pegawai ====================================== */
?>

<?php
/* ====================================== Widget Dialog Terima Darah ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTerimaDarah',
    'options' => array(
        'title' => 'Terima Darah',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 300,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('grid-statusterima'); }",
    ),
));
?>
<iframe name="iframeTerimaDarah" id="iframeTerimaDarah" width="98%" height="98%"></iframe>
<?php  
$this->endWidget();
?>

<?php
/* ====================================== Widget Dialog Transfusi ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogReaksiTransfusi',
    'options' => array(
        'title' => 'Reaksi Transfusi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('grid-statusterima'); }",
    ),
));
?>
<iframe id="iframeReaksiTransfusi" width="98%" height="98%"></iframe>
<?php  
$this->endWidget();
?>