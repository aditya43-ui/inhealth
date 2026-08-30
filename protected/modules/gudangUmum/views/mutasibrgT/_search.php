<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gumutasibrg-t-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nomutasibrg'),
));
$format = new MyFormatter();
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Mutasi", 'tgl_rekam', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'nomutasibrg', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'nomutasibrg', array('class' => 'span4', 'placeholder' => 'No. Mutasi Barang', 'class' => 'span4 angkahuruf-only', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'masukkeluar', array('class' => 'control-label', 'label' => 'Jenis Mutasi')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'masukkeluar',
                            array(1 => 'MUTASI KELUAR', 2 => 'MUTASI MASUK'),
                            array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'create_ruangan', array('class' => 'control-label', 'label' => 'Ruangan Pengirim')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'create_ruangan', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = TRUE order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'ruangantujuan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = TRUE order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'pegpengirim_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegpengirim_id', array('id' => 'pegpengirim_id')); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'pegpengirim',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getPegawaiPengirim') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                 $(this).val( ui.item.label);
                                 return false;
                             }',
                                'select' => 'js:function( event, ui ) {
                                 $("#pegpengirim_id").val(ui.item.value); 
                                 return false;
                             }',
                            ),
                            'htmlOptions' => array('placeholder' => 'Pegawai Pengirim', 'id' => 'pegpengirim', 'class' => 'span4'),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogPegawai2',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
                ?>
                <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); 
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
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
                Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
                array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printInformasi(\'CSV\')')
            ); ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printInformasi');
            $urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');
            $js = <<< JSCRIPT
function printInformasi(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print_informasi', $js, CClientScript::POS_HEAD);
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips.informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>