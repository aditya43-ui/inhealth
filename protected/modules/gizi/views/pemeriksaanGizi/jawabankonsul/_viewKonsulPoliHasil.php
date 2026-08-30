<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Jawab</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textField($modKonsul, 'tgljawabpoli', array('style'=>'width: 100%','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Konsul</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textField($modKonsul, 'nama_pegawai', array('style'=>'width: 100%','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Poliklinik Asal</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->dropDownList($modKonsul, 'asalpoliklinikkonsul_id', array(CHtml::listData(RuanganM::model()->findAll('ruangan_aktif is true'), 'ruangan_id', 'ruangan_nama')), array('style'=>'width: 100%','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Poliklinik Tujuan</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->dropDownList($modKonsul, 'ruangan_id', array(CHtml::listData(RuanganM::model()->findAll('ruangan_aktif is true'), 'ruangan_id', 'ruangan_nama')),array('style'=>'width: 100%','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <?php 
            if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
            ?>
            <div class="control-group">
                <label class="control-label">Sesuai Permohonan Konsultasi, Pada Kasus Ini Dijumpai</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textArea($modKonsul, 'jawaban_konsul', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Diagnosa</label>
                <div class="controls">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kelompok Diagnosa</th>
                                <th>Kode Diagnosa</th>
                                <th>Nama Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count((array)$modMorbiditas)){
                                foreach ($modMorbiditas as $key => $value) {
                                    echo "
                                        <tr>
                                            <td>".$value->kelompokdiagnosa->kelompokdiagnosa_nama."</td>
                                            <td>".$value->diagnosa->diagnosa_kode."</td>
                                            <td>".$value->diagnosa->diagnosa_nama."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Saran Tindak Medik / Pengobatan</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textArea($modKonsul, 'saran_tindakan', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prof. / dr. / Spesialis</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textField($modKonsul, 'nama_pegawai', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <?php }else{ ?>
        <div class="panel-body form-horizontal">
            <div class="col-sm-12">
                <br/>
                <div>Sesuai Permohonan Konsultasi,Pada Kasus Ini Dijumpai:</div>
                <br/>
                <br/>
            </div>
            <div class="row">
        <div class="col-sm-6">
            <!-- <div class="control-group">
                <label class="control-label">Subjective</label>
                <div class="controls">
                    <?php // echo $form->textArea($modKonsul, 'subjektif_jawaban', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Objective</label>
                <div class="controls">
                    <?php // echo $form->textArea($modKonsul, 'objektif_jawaban', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Assesment</label>
                <div class="controls">
                    <?php // echo $form->textArea($modKonsul, 'assesment_jawbaan', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Planning</label>
                <div class="controls">
                    <?php // echo $form->textArea($modKonsul, 'planning_jawaban', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-label">Uraian Konsul</label>
                <div class="controls">
                    <?php echo $form->textArea($modKonsul, 'uraian_konsul', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true, 'rows' => '10', 'cols' => '230')); ?>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Jawaban Konsul</label>
                <div class="controls">
                    <?php echo $form->textArea($modKonsul, 'uraian_konsuljawaban', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true, 'rows' => '10', 'cols' => '230')); ?>
                </div>
            </div>


            
        </div>
            </div>
        </div>
            <?php } ?>
<div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds', 'Kembali', array('{icon}' => '<i class="icon-rewind icon-white"></i>')), Yii::app()->request->urlReferrer, array('class' => 'btn btn-danger'));
    ?>
    <?php echo CHtml::link(Yii::t('mds', 'Print', array('{icon}' => '<i class="icon-form-print icon-white"></i>')), '', array('onclick' => 'print("PRINT")','class' => 'btn btn-success'));
    ?>
</div>

<?php 
$urlPrintPermintaan = Yii::app()->createAbsoluteUrl('rawatJalan/konsulPoli/print&id=' . $modKonsul->pendaftaran_id) . '&idKonsulPoli=' . $modKonsul->konsulpoli_id;

$js = <<< JSCRIPT

function print(caraPrint)
{
window.open("${urlPrintPermintaan}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>

<?php $this->endWidget(); ?>