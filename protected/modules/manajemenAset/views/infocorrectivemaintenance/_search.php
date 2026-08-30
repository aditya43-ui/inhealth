<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'corectivemaintenance-r-search',
    'type' => 'horizontal',
));
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Permintaan",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nomor Permintaan</label>
            <div class="controls">                
                <?php echo $form->TextField($model, 'korektifmainten_no', array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Peralatan",'', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->TextField($model, 'jenisbarang_nama', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No Aset",'', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->TextField($model, 'invperalatan_kode', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nomor Seri</label>
            <div class="controls">                
                <?php echo $form->TextField($model, 'peralatan_noseri', array('class'=>'span3')); ?>
            </div>
        </div>
        
        
    </div>
    <div class="col-sm-6">
        <?php if (!$model->is_pj_asset){ ?>
        <div class="control-group ">        
            <label class="control-label">Ruangan Aset</label>
            <div class="controls">
                <?php 
                
                echo $form->hiddenField($model, 'ruangpemohon_id',['class'=>'ruangpemohon_id']); 
                if ($this->module->id == 'manajemenAset'){
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,                                        
                        'attribute' => 'ruangpemohon_nama',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('/actionAutoComplete/getRuangan') . '",
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
                                    setRuangan(ui.item);
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder' => "Ketik Ruangan ",
                            'class' => 'span3 ruangpemohon_nama',
                            'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruangpemohon_id') . '").val("")}'
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRuangan'),    
                    ));
                }else{
                    echo $form->textField($model, 'ruangpemohon_nama',['class'=>'ruangpemohon_nama', 'readonly'=>true]); 
                }
                ?>
            </div>
        </div>
        <?php } ?>
        <div class="control-group ">        
            <label class="control-label">Lokasi Aset</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'lokasi_id',['class'=>'lokasi_id']); ?>   
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'lokasiaset_namalokasi',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/getLokasiAset') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: $(".ruangpemohon_id").val()
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
                                setLokasi(ui.item);
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik lokasi ",
                        'class' => 'span3 lokasiaset_namalokasi',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'lokasi_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLokasi', 'jsFunction'=>'$("#dialogLokasi").dialog("open");refreshGridLokasi();'),    
                ));
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label("Pemohon", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->TextField($model, 'pemohon_nama', array('class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group ">        
            <label class="control-label">Teknisi</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'teknisipemeliharaanaset_id',['class'=>'teknisipemeliharaanaset_id']); ?>   
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'teknisipemeliharaanaset_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                is_peg_teknisipeliharaaset: true
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
                                setPegawai(ui.item);
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik teknisi ",
                        'class' => 'span3 teknisipemeliharaanaset_nama',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'teknisipemeliharaanaset_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTeknisi', 'jsFunction'=>'$("#dialogTeknisi").dialog("open");'),    
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Status", '', array('class' => 'control-label')) ?>
            <div class="controls">
             <?php echo $form->dropDownList($model, 'korektifmainten_status', LookupM::getItems('statusdokumen'), array('empty'=>'--Pilih--','class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

            </div>
        </div>
        
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/index'), 
        array('class'=>'btn btn-default',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp";
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) ;        
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>


<?php
$urlPrint = $this->createUrl('printInfo');
$js = <<< JSCRIPT
                       
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#corectivemaintenance-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
