<!--<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>-->
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gzpesanmenudiet-t-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo Chtml::label("Tgl. Pesan Menu", 'tglpesanmenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                //$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                //$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                $model->tgl_awal = date('d M Y', strtotime($model->tgl_awal));
                $model->tgl_akhir = date('d M Y', strtotime($model->tgl_akhir));
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label for="namaPasien" class="control-label">
                Sampai dengan
          </label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                )); ?>
            </div>
        </div>

        <div class="control-group hide">
            <?php echo Chtml::label("No Pesan Menu", 'nopesnamenu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopesanmenu', array('class' => 'span4 angkahuruf-only', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'No. Pesan Menu')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?php
            if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                echo $form->dropDownListRow(
                    $model,
                    'instalasi_id',
                    Chtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('/actionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "ruangan_id") . '").html(data); }',
                            //'url' => $this->createUrl('/ActionDynamic/GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($model))),
                            //'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
                        )
                    )
                );

            ?>
        <div class="control-group">
            <?php echo Chtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php
                echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    Chtml::listData(RuanganM::model()->findAll("instalasi_id in (4, 20) ORDER BY ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    )
                );
            ?>
            </div>
        </div>
            
        <?php
            } 
        ?>

        <div class="control-group">
            <?php echo Chtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pasien', array('class' => 'span4 hurufs-only', 'maxlength' => 100, 'placeholder' => 'Nama Pasien')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo Chtml::label("Waktu", 'waktu', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php
                echo $form->dropDownList(
                    $model,
                    'jeniswaktu_id',
                    Chtml::listData(JeniswaktuM::model()->findAll("jeniswaktu_aktif is true ORDER BY urutan ASC"), 'jeniswaktu_id', 'jeniswaktu_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    )
                );
            ?>
            </div>
        </div>

        <?php $form->dropDownListRow($model, 'status_terima', Params::getStatusTerima(), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
     
    
    </div>
</div>

<br><br>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php 
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php
    if (in_array($model->jenispesanmenu, array(Params::JENISPESANMENU_PASIEN, Params::JENISPESANMENU_PENDAMPING))) {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'PRINT\')')
        );

        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'PDF\')')
        );

        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'EXCEL\')')
        );
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print All Etiket', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printEtiket(\'PRINT\')')
        );
    } else {
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPegawai(\'PRINT\')')
        );

        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPegawai(\'PDF\')')
        );

        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')),
            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printPegawai(\'EXCEL\')')
        );
    }
    ?>

    <?php
    $content = $this->renderPartial('gizi.views.tips.informasiPesanMenuDiet', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPasien');
$urlPrintPegawai =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPegawai');
$urlPrintEtiket =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintAllEtiket');

$js = <<< JSCRIPT
function printInformasi(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPegawai(caraPrint)
{
    window.open("${urlPrintPegawai}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printEtiket(caraPrint)
{
    window.open("${urlPrintEtiket}/"+$('#gzpesanmenudiet-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('printInformasi', $js, CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('printPegawai', $js, CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('printEtiket', $js, CClientScript::POS_HEAD);
?>