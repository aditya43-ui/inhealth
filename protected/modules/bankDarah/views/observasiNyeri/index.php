<?php
/**
 * view utama menampilkan form - form inputan yang ada di menu asesmen nyari
 * RSST-1498
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
        ));


Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:1;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }
</style>

<!--div class="white-container"-->
<div class="panel panel-gradient panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Pemeriksaan <strong>Asesmen Nyeri</strong></div>
    </div>
    <div class="panel-body">
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>        

        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglperiksanyeri', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglperiksanyeri',
                    'value' => null,
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 htpd',
                        'style'=>'position: relative; z-index: 100000;'
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Ada Keluhan Nyeri ?</label>
            <div class="controls" id="status-nyeri">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($model, 'keluhannyeri', array('id' => 'nyeriYes', 'value' => true, 'onclick' => 'adaNyeri(this);', 'uncheckValue' => null)); ?>  <label>Ada</label>   
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $form->radioButton($model, 'keluhannyeri', array('id' => 'nyeriNo', 'value' => false, 'onclick' => 'adaNyeri(this);', 'uncheckValue' => null)); ?> <label>Tidak Ada</label>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Skala Nyeri</div>
            </div>
            <div class="panel-body" >
                <div id="disableDewasa" ><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                </div>

                <h2 style="text-align:center;">Intensitas "WONG BAKER FACE SCALE"</h2>
                <br/>
                <?php
                echo $this->renderPartial($this->path_view . 'form._formNyeri', array(
                    'form' => $form,
                    'model' => $model
                        ), true);
                ?>   


            </div>
        </div>                                

        <div class="panel panel-success" >
            <div class="panel-heading">
                <div class="panel-title">Lokasi Nyeri</div>
            </div>
            <div class="panel-body">
                <div id="disableLokasiNyeri"><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                </div>   

                <?php
                echo $this->renderPartial($this->path_view . 'form._formLokasiNyeri', array(
                    'form' => $form,
                    'model' => $model,
                    'modGambarTubuh' => $modGambarTubuh,
                    'modPeriksaGambar' => $modPeriksaGambar
                        ), true);
                ?>   


            </div>
        </div>

        <div class="panel panel-success"  id="periksa_nyeri">
            <div class="panel-heading">
                <div class="panel-title">Pemeriksaan Nyeri</div>
            </div>
            <div class="panel-body">
                <div id="disablePeriksaNyeri" ><!--background-color:rgba(0, 0, 0, 0.1);-->                        
                </div>

                <?php
                echo $this->renderPartial($this->path_view . 'form._formPemeriksaanNyeri', array(
                    'form' => $form,
                    'model' => $model,
                        ), true);
                ?>   


            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label("Petugas Penyadap <i style='color: red'> * </i>", '', array('class' => 'control-label', 'style' => '')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'petugas_id', array('readonly' => true));
                $model->petugas_nama = !empty($model->petugas_id) ? $model->petugaspenyadap->namaLengkap : "";
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'petugas_nama',
                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                            url: "' . $this->createUrl('/ActionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id: ' . Yii::app()->user->getState('ruangan_id') . '
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                                     $(this).val( ui.item.label);
                                                     return false;
                                             }',
                        'select' => 'js:function( event, ui ) {
                                                     $("#' . CHtml::ActiveId($model, 'petugas_id') . '").val(ui.item.value); 
                                                     return false;
                                             }',
                    ),
                    'htmlOptions' => array('class' => 'span4 required', 'rel' => 'tooltip', 'placeholder' => 'Ketik nama untuk Petugas Penyadap',),
                    'tombolDialog' => array('idDialog' => 'dialogTransporter', 'idTombol' => 'tombolKoordinator'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama Petugas</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>
                <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true)); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                    echo "&nbsp;";
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true));
                    echo "&nbsp;";
                }
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/observasiNyeri/index', array('daftardonasi_id' => $modDaftarDonasi->daftardonasi_id)), array('class' => 'btn btn-danger',
                    'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
                ?>
                <?php
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                ?>
            </div>
        </div>

    </div>
</div>    
<?php echo $this->renderPartial($this->path_view . 'js._jsFunctions', array('model' => $model, 'modGambarTubuh' => $modGambarTubuh, 'modPemeriksaanGambar' => $modPeriksaGambar, 'modBagianTubuh' => $modBagianTubuh), true); ?>                                                    

<?php $this->endWidget(); ?>