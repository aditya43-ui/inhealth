<?php $linkHalaman = CustomFunction::getUrlByMenuID(3574); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Implementasi Keperawatan</b><?= isset($_GET['status']) ? CHtml::link("<b>Lanjut ke Evaluasi Keperawatan</b>", $this->createUrl('evaluasiAskep/index', ['implementasiaskep_id' => $model->implementasiaskep_id]), ['class' => 'btn btn-info', 'style' => 'color:#fff;']) : ''; ?>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Implementasi Keperawatan',
        );
        ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#ASPendaftaranT_no_pendaftaran',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
                // 'onsubmit'=>'return cekOtorisasi();'
            ),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php //echo $form->errorSummary(array($modRetur,$modBuktiKeluar)); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rencana</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataRencana', array('modRencana' => $modRencana, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Implementasi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataImplementasi', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Riwayat Implementasi
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_riwayatImplementasi', array('model' => $modRiwayat, 'form' => $form)); ?>
                <?= CHtml::button("Print Riwayat", ['class' => 'btn btn-info', 'onclick' => 'cetakRiwayat();']); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Implementasi Keperawatan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="table-rencana" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <th>Diagnosa Keperawatan</th>
                        <th>Luaran Keperawatan</th>
                        <th>Intervensi</th>
                        <th>Implementasi</th>
                        <!--<th>Kolaborasi</th>-->
                    </thead>
                    <tbody>
                        <?php
                        $trImplementasi = $this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modDetail, 'modPilih' =>  $modPilih), true);
                        echo $trImplementasi;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                );
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true));
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger',
                        'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => true
                    )
                );
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
                //			echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/implementasiKeperawatan/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            );
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            /*
		  echo CHtml::htmlButton(
		  Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
		  array(
		  'class'=>'btn btn-danger',
		  'type'=>'reset'
		  )
		  );
		 * 
		 */
            ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&implementasiaskep_id="+$model->implementasiaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$this->renderPartial('_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'modRencana' => $modRencana,
    'form' => $form
));
?>
<?php
//========= Dialog buat cari data Rekening Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
$modDiagnosaKep = new ASDiagnosakepM('search');
$modDiagnosaKep->unsetAttributes();
if (isset($_GET['ASDiagnosakepM'])) {
    $modDiagnosaKep->attributes = $_GET['ASDiagnosakepM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosakep-m-grid',
    'dataProvider' => $modDiagnosaKep->search(),
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
        ),
        array(
            'header' => 'Status',
            'value' => '($data->diagnosakep_aktif == TRUE) ? "Aktif" : "Tidak Aktif"',
            'filter' => CHtml::dropDownList(
                'diagnosakep_aktif',
                $modDiagnosaKep->diagnosakep_aktif,
                array(
                    '1' => 'Aktif',
                    '0' => 'Tidak Aktif',
                ),
                array('empty' => '-- Pilih --')
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Rencana Keperawatan',
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