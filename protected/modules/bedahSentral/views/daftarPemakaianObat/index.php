<?php
$this->breadcrumbs = array(
    'Catatan Perkembangan Pasien Terintegrasi',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php

if ($this->layout != '//layouts/iframe') {
    $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <span style="float: left !important; width:80% !important;"><b>Daftar Pemakaian Obat dan Alat Kesehatan Habis Pakai</b></span><span style="float: right !important;">
            </span>
        </div>
    </div>
    <div class="panel-body">        
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'observasiigd-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
        <?php echo $form->hiddenField($model, 'pasien_id'); ?>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Daftar Pemakaian Obat dan Alat Kesehatan Habis Pakai</strong></div>
            </div>
            <div class="panel-body">
                <div class="row" style="margin-top: 20px; margin-bottom: 10px;">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'ppa_namajenis', array('class' => 'control-label required', 'label' => 'Operasi')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'ppa_namajenis'); ?>
                                <?php        
                                    if(!empty($modRencana->operasi_id)){
                                        $operasi= OperasiM::model()->findAll('operasi_id=' . $modRencana->operasi_id);
                                        echo $form->dropDownList($model, 'ppa_jenis', CHtml::listData( $operasi,'operasi_id', 'operasi_nama'), array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --','onchange'=>"changeJenisPPA(this)"));
                                    }                          
                                    else{
                                        echo $form->dropDownList($model, 'ppa_jenis', array(),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);", 'onchange'=>'pilihModul(this)'));
                                    }      
                                 ?>

                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tanggal_cppt', array('class' => 'control-label required', 'label' => 'Tanggal')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tanggal_cppt',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span4', 'style' => 'width:150px;'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group  namajenis_ppa">
                            <?php echo $form->labelEx($model, 'ppa_namajenis', array('class' => 'control-label ', 'label' => 'Operator')) ?>
                            <div class="controls">
                                <!-- Pegawai Ruangan -->
                                <?php
                                    echo $form->textField($model, 'pegawaippa_id', array('class' => 'pegawaippa_id span4' ,'disabled'=>true, 'onkeypress' => "return $(this).focusNextInputField(event);",));
                                ?>

                            </div>
                        </div>
                        <div class="control-group dpjpid">
                            <?php echo $form->labelEx($model, 'dpjp_id', array('class' => 'control-label ', 'label' => 'Anestesi')) ?>
                            <div class="controls">
                                <!-- Dokter -->
                                <?php
                                echo $form->textField($model, 'dpjp_id', array('class' => 'dpjp_id span4','disabled'=>true, 'onkeypress' => "return $(this).focusNextInputField(event);",));

                                ?>

                            </div>

                        </div>


                    </div>
                </div>

                <?php

                    // echo '<pre>'; var_dump($model->attributes);
                
                ?>
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama </th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
                            $modObatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPenunjang->pasienmasukpenunjang_id));
                            $no=1;
                            if (!empty($modObatAlkes)) { 
                        ?>
                            <?php
                                foreach($modObatAlkes as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo $no?></td>
                                <td><?php echo empty($val->obatalkes_id) ? '-' : $val->obatalkes->obatalkes_nama ?></td>
                                <td><?php echo empty($val->qty_oa) ? '-' : $val->qty_oa ?></td>
                                <td><?php echo empty($val->ket_penggunaan) ? '-' : ($val->ket_penggunaan) ?></td>
                            </tr>
                            <?php $no+=1;
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <?php
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				// echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print('.$_GET['pendaftaran_id'].'\',PRINT\')')) . "&nbsp&nbsp";
                $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'buttons'=>array(
                        array('label'=>'Print', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'javascript:void(0)', 'htmlOptions'=>array('onclick'=>'printRiwayat('.$_GET['pendaftaran_id'].',"PRINT")')),
                    ),
                )); 
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
				$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

				$js = <<< JSCRIPT
				function cekForm(obj){
					$("#search :input[name='"+ obj.name +"']").val(obj.value);
				}
                
				function print(pendaftaran_id){
					window.open("${urlPrint}"+&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=900px');
				}
JSCRIPT;
				Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
				?>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'dialogCustom',
            'options' => array(
                'title' => '<span class="dialog-judul"></span>',
                'autoOpen' => false,
                'width' => 840,
                'height' => 420,
                'resizable' => true,
            ),
        )
);

echo '<div class="form-horizontal" id="form-custom">';
echo '</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
