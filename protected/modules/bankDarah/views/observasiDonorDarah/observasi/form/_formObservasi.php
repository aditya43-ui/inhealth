<?php
/**
 * form utama untuk menginput observasi donor darah
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<style>
    .kel-tekanan{
        width:70px !important;
    }

    .control-label{
        text-align:left !important;
        vertical-align: top !important;
    }
</style>

<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Tanggal Penyadapan</label>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglmulaiobservasi',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                ),
            ));
            ?>
        </div>
        <div class="controls">
            <label>Mulai Penyadapan</label>
        </div>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'jamawal',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                    'onClose' => 'js:function(){generateDurasi("awal");}',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2 awalsadap', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                ),
            ));
            ?>
        </div>
        <div class="controls">
            <label>Selesai Penyadapan</label>
        </div>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'jamakhir',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                    'onClose' => 'js:function(){generateDurasi("akhir");}',
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span2 akhirsadap', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:120px;'
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Durasi Penyadapan</label>
        <div class="controls">
            <div class="input-append">
                <?php echo $form->textField($model, 'durasi_penyadapan', array('readonly' => true, 'class' => 'span2')) ?>
                <span id="BDObservasipendonorT_durasi_penyadapan" class="add-on">
                    <i class="icon-time"></i>
                </span>
            </div>
        </div>        
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="control-group">
        <div class="control-group">
            <label class="control-label">Kelancaran Aliran Darah</label>
            <?php
            $alasan = LookupM::getItems('kelancarandarah');
            $get = array();
            foreach ($alasan as $key => $val) {
                echo "<div class='controls'>";
                echo $form->radioButton($model, 'kelancarandarah', array('uncheckValue' => null, 'value' => $key)) . '<label>' . $val . '</label>';
                echo "</div>";
            }
            ?>                
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Keluhan', 'ada_keluhan', array('class' => 'control-label')) ?>
        <div class="controls">     
            <?php echo CHtml::activeRadioButtonList($model, 'ada_keluhan', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setPerubahan(this);')); ?>       
        </div>
    </div>
    <div class="control-group" id="fieldkeluhan" style="display:none">
        <label class="control-label"></label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $model,
                'attribute' => 'keluhan_pendonor',
                'data' => explode(',', $model->keluhan_pendonor),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    //'json_url'=>$this->createUrl('MasterKeluhan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
            &nbsp;
        </div>
    </div>       


</div>
<div class="clear"></div>
<p>&nbsp;</p>

<div class="panel panel-darkk" id="adakeluhan" style="display:none">
    <span class="group-title">
        Tanda Vital
    </span>
    <div class="panel-body" id="tandavital">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nadi_observasi', array('class' => 'span2 numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>                        

            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'nadi_observasi', array('class' => 'span2 numbers-only')); ?>
                </div>
                <div class="controls">
                    <label><sup>o</sup>C</label>
                </div>
            </div>

            <div class="control-group" >
                <label class="control-label">Tekanan Darah</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'td_systolic', array('class' => 'kel-tekanan numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>/</label>
                </div>
                <div class="controls">
                    <?php echo $form->textField($model, 'td_diastolic', array('class' => 'kel-tekanan numbers-only')); ?>
                </div>
                <div class="controls">
                    <label>mm/Hg</label>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Pernapasan</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'pernapasan', array('class' => 'span2')); ?>
                </div>
                <div class="controls">
                    <label>x/mnt</label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Kesadaran</label>
                <div class="controls">
                    <?php echo $form->textField($model, 'kesadaran', array('class' => 'span2')); ?>
                </div>               
            </div>
        </div>
    </div>
</div>

<div class="clear">
</div>
<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label">Keterangan</label>
        <div class="controls">
            <?php echo $form->textArea($model, 'ket_observasi', array()); ?>
        </div>
    </div>
</div>
<div class="clear">
</div>
<div class="panel">    
    <div class="panel-body">
        <?php echo $form->checkBox($model, 'is_batalpenyadapan', array('onclick' => 'cekBatal(this);')); ?><label>&nbsp;&nbsp;&nbsp;Cek jika penyadapan darah gagal</label>
    </div>
    <span id="message-batalsadap"></span>
</div>

<div class="clear">
</div>
<div class="panel panel-darkk">
    <span class="group-title">
        Alasan gagal sadap
    </span>
    <?php echo $form->hiddenField($model, 'ket_alasanbatal', array('readonly' => true)); ?>
    <div class="panel-body" id="alasanbatal-sadap">
        <?php
        $alasan = LookupM::getItems('alasanbatal_penyadapan');
        $get = array();
        foreach ($alasan as $key => $val) {
            if (strcmp(strtolower($key), strtolower($val)) != 0) {
                $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['look'] = ucwords(str_replace(strtolower($val), '', strtolower($key)));
                $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['val'] = $key;
                $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['det'][$key]['name'] = $val;
                $get[trim(str_replace(strtolower($val), '', strtolower($key)))]['det'][$key]['value'] = $key;
            } else {
                $get[$key]['look'] = $val;
            }
        }
        ?>
        <table width="100%" id="alasanbatalcek">
            <?php
            if (!empty($get)) {

                $value = $model->alasanbatal_penyadapan;
                $ket = $model->ket_alasanbatal;

                foreach ($get as $look) {
                    echo "<div class='control-group'>";
                    $st = (strtolower($value) == strtolower($look['look']) ? true : false);
                    if (isset($look['det'])) {

                        echo "<div class='controls'>" . CHtml::checkBox('cekPilih', $st, array('class' => 'utama ceklis tidakmasuk haschild', 'value' => $look['look'], 'onclick' => 'openChild(this);')) . "<label>&nbsp;" . $look['look'] . " :</label></div>";
                        echo "<div class='controls'>";
                        foreach ($look['det'] as $d) {
                            $st = (strtolower($value) == strtolower($d['value']) ? true : false);

                            if ($st != true) {
                                $ket = '';
                            } else {
                                $ket = $model->ket_alasanbatal;
                            }

                            echo "<div class=''>";
                            echo "<div class='col-sm-4'>";
                            echo CHtml::checkBox('cekPilih', $st, array('class' => 'ceklis masuk hasparent', 'value' => $d['value'], 'onclick' => 'tambahCeklis(this);')) . "<label>&nbsp;" . $d['name'];
                            echo "</div>";
                            echo '<div class="col-sm-6">' . CHtml::textField('textPilih', $ket, array('class' => 'masuk hasparent', 'hasil' => $d['value'], 'onblur' => 'inputKeterangan(this);')) . "</div>";
                            echo '</label></div>';
                            echo "<div class='clear' style='padding:5px;'></div>";
                            //echo "<br/>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='controls'>" . CHtml::checkBox('cekPilih', $st, array('class' => 'utama ceklis masuk', 'value' => $look['look'], 'onclick' => 'tambahCeklis(this);')) . "<label>&nbsp;" . $look['look'] . "</label></div>";
                    }
                    echo "</div>";
                }
            }
            ?>
        </table>

        <table width="100%" id="tampungceklis" hidden>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="panel">    
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Waktu Observasi</label>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'waktu_observasi',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                        ),
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
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label"> Petugas Penyadap </label>
                <div class="controls">
                    <?php
                    if (empty($model->petugas_id)) {
                        $cekSkalaNyeri = PeriksanyeripendonorT::model()->findByAttributes(array('daftardonasi_id' => $_GET['daftardonasi_id']));
                        $model->petugas_id = !empty($cekSkalaNyeri->petugas_id) ? $cekSkalaNyeri->petugas_id : "";
                        $model->petugas_nama = !empty($cekSkalaNyeri->petugas_id) ? $cekSkalaNyeri->petugaspenyadap->namaLengkap : "";
                    } else {    
                        $model->petugas_id = !empty($model->petugas_id) ? $model->petugas->pegawai_id : "";
                        $model->petugas_nama = !empty($model->petugas_nama) ? $model->petugas->namaLengkap : "";
                    }
                                            
                    echo $form->hiddenField($model, 'petugas_id', array('readonly' => true));
                    echo $form->textField($model, 'petugas_nama', array('readonly' => true));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel">    
    <div class="panel-body">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('onclick' => 'cekForm();', 'class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . '&nbsp;';
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/observasiDonorDarah/penyadapan', array('daftardonasi_id' => $modDaftarDonasi->daftardonasi_id)), array('class' => 'btn btn-danger',
            'onclick' => 'if(!confirm("Apakah Anda yakin ingin mengulang form ini ?")) return false;')) . '&nbsp;';
        echo CHtml::link(Yii::t('mds', '{icon} Cetak Label Penyadapan', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => $model->isNewRecord, 'class' => 'btn btn-info', 'onclick' => "printLabel();return false"));
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
</div>
<script>

    function printLabel()
    {
        window.open('<?php echo $this->createUrl('PrintLabel', array('observasipendonor_id' => $model->observasipendonor_id)); ?>', 'printwin', 'left=100,top=100,width=377.9527559055,height=188.9763779528');
    }
</script>