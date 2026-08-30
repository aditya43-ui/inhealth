<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'dataawal-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row-fluid">
    <div class="col-sm-12">
        
        <div style="font-style: italic; color: red;">Input pertanda bintang wajib diisi !</div>
        <br />
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tglawal_pelayanan', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tglawal_pelayanan',
                        'mode'=>'date',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'jamawal_pelayanan', array('class' => 'control-label')) ?>
                <div class="controls">
                      <?php
                      $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                          'attribute'=>'jamawal_pelayanan',
                            'mode'=>'time',

                            'options'=> array(
                                    'showOn' => false,
                            ),
                            'htmlOptions'=>array(
                        'readonly'=>TRUE,
                        'class'=>'span2',
                        'placeholder'=>'00:00:00',
                        'onkeyup'=>"return $(this).focusNextInputField(event),",
                            ),
                          ));
                      ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo $form->labelEx($model, 'petugaspemeriksa_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'petugaspemeriksa_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 required')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'ketubahpecahsejak_jam', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'ketubahpecahsejak_jam',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'mulessejak_jam', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'mulessejak_jam',
                        'mode'=>'datetime',
                        'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php  echo CHtml::label('Gravida', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'gravida', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo CHtml::label('Para', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'para', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo CHtml::label('Abortus', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'abortus', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php  echo CHtml::label('Anak Hidup', '', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jml_anakhidup', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'siklushaid', array('class'=>'control-label', 'label'=>'Siklus Haid <span class="required">*</span>')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'siklushaid',array('placeholder' => 'Siklus Haid','class'=>'numbers-only span2', 'onblur'=>'hitungSiklusHaid();')) ?>
                </div>
                <div class="controls">
                    <label> hari</label>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'haripertamahaidterakhir', array('class'=>'control-label', 'label'=>'Hari Pertama Haid Terakhir <span class="required">*</span>')); ?>
                <div class="controls">
                    <?php                        
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'haripertamahaidterakhir',
                            'mode' => 'date',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'placeholder'=>'Haid Terakhir',
                                'readonly' => true, 
                                'class' => 'span3', 
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'hitungSiklusHaid();',
                            ),
                        ));                       
                    ?>
                </div>
            </div>
            
            <div class="control-group">                
                <label class=""><b>Usia Kehamilan Menurut :</b></label>
                <div class="controls">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Haid Terakhir</label>
                <div class="controls">
                    <?php echo $form->textField($model,'perkiraan_usiahamil_byhaid',array('placeholder' => 'usia kehamilan menurut : haid terakhir','class'=>'numbers-only span2')) ?>
                </div>
                <div class="controls">
                    <label> minggu</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tinggi Fundus</label>
                <div class="controls">
                    <?php echo $form->textField($model,'perkiraan_usiahamil_byfundus',array('placeholder' => 'usia kehamilan menurut : tinggi fundus','class'=>'numbers-only span2')) ?>
                </div>
                <div class="controls">
                    <label> minggu</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USG</label>
                <div class="controls">
                    <?php echo $form->textField($model,'perkiraan_usiahamil_byusg',array('placeholder' => 'usia kehamilan menurut : USG','class'=>'numbers-only span2')) ?>
                </div>
                <div class="controls">
                    <label> minggu</label>
                </div>
            </div>

            <div class="control-group">
                <label class=""><b>Tafsiran Kelahiran</b></label>
                <div class="controls">
                    
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Lahir</label>
                <div class="controls">
                    <?php                        
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'perkiraanlahir_tgl',
                            'mode' => 'date',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
//                                    'minDate' => 'd',
                            ),
                            'htmlOptions' => array('placeholder'=>'Tanggal Lahir','readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));                       
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
                <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); //RND-8620
                        echo "&nbsp;";
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                            $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                            array('class'=>'btn btn-danger',
                                'onclick'=>'return refreshForm(this);'));
                        $content = $this->renderPartial('../tips/informasi',array(),true);
                        
                ?>
                <?php $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function hitungSiklusHaid() {
        var siklus = parseFloat($("#<?php echo CHtml::activeId($model,'siklushaid'); ?>").val());
        var tgl = $("#<?php echo CHtml::activeId($model,'haripertamahaidterakhir'); ?>").val();
        
        var arr_tgl = tgl.split(" ");
        var date_label = {
            "Mei": "May",
            "Agus": "Aug",
            "Okt": "Oct",
            "Nop": "Nov",
            "Des": "Dec"
        };
            
        if (date_label[arr_tgl[1]] != null) {
            arr_tgl[1] = date_label[arr_tgl[1]];
        }
        
        tgl = arr_tgl.join(" ");
        
        var tgl_full = new Date(tgl);
        var tgl_o = new Date(tgl);
        var month = tgl_full.getMonth();
        
        if (!isNaN(siklus) && !isNaN(tgl_full.getTime())) {
            if (siklus === 28) {
                if (month >= 4) {
                    tgl_full.setDate(tgl_full.getDate() + 7);
                    tgl_full.setMonth(tgl_full.getMonth() - 3);
                    tgl_full.setFullYear(tgl_full.getFullYear() + 1);
                } else {
                    tgl_full.setDate(tgl_full.getDate() + 7);
                    tgl_full.setMonth(tgl_full.getMonth() + 9);
                }
            } else {
                tgl_full.setMonth(tgl_full.getMonth() + 9);
                tgl_full.setDate(tgl_full.getDate() + (siklus - 21));
            }
        }
        
        var tgl_sekarang = new Date();
        var tgldate = '';

        if (!isNaN(tgl_full.getTime())) {
            
            var selisih = tgl_sekarang.getTime() - tgl_o.getTime();
            var selisih_hari = Math.floor(selisih / (1000 * 3600 * 24));
            var selisih_minggu = Math.floor(selisih_hari / 7);
            tgldate = tgl_full.toLocaleDateString("id-ID", {day:"numeric", month: "short", year:"numeric"}); 

            $("#<?php echo CHtml::activeId($model,'perkiraan_usiahamil_byhaid'); ?>").val(selisih_minggu);
        }
        $("#<?php echo CHtml::activeId($model,'perkiraanlahir_tgl'); ?>").val(tgldate);
    }
</script>