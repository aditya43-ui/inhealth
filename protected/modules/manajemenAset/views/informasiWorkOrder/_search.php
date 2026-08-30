<?php

/**
 * - digunakan sebagai informasi work order
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'workorder-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Work Order",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor WO",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'workorder_no',array('placeholder'=>'Ketik Nomor WO')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Peralatan",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'invperalatan_namabrg',array('placeholder'=>'Ketik Jenis Peralatan')) ?>
            </div>
        </div>
         <div class = "control-group">
            <?php echo Chtml::label("Kode Aset",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'invperalatan_kode',array('placeholder'=>'Ketik No Aset')) ?>
            </div>
        </div>
        
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Seri",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'peralatan_noseri',array('placeholder'=>'Ketik Nomor Seri')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
         <?php if (!$model->is_pj_asset){ ?>
        <div class="control-group ">        
            <label class="control-label">Ruangan Aset</label>
            <div class="controls">
                <?php                 
                echo $form->hiddenField($model, 'ruangan_id',['class'=>'ruangan_id']); 
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'ruangan_nama',
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
                        'class' => 'span3 ruangan_nama',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruangan_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRuangan'),    
                ));
                ?>
            </div>
        </div>
        <?php } ?>
        <div class="control-group">
            <label class="control-label">Lokasi Aset</label>
            <div class="controls">
                <?php
                    echo CHtml::activeHiddenField($model, 'lokasi_id',['class'=>'lokasi_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute'=>'lokasiaset_namalokasi',                                
                                'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.Yii::app()->createUrl('/ActionAutoComplete/getLokasiAset').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            notpj:"ya"
                                        },
                                        success: function (data) {
                                                response(data);
                                        }
                                    })
                                }',
                                'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength' => 2,
                                    'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                    'select'=>'js:function( event, ui ) { 
                                        $(".lokasi_id").val(ui.item.lokasi_id);
                                        $(".lokasi_nama").val(ui.item.lokasiaset_namalokasi);                                        
                                        return false;
                                    }',
                                ),
                                'htmlOptions'=>array(
                                    'onblur' => 'if(this.value==""){$(".lokasi_id").val("")}',
                                    'id'=>'lokasi_nama',
                                    'class'=>'span3 lokasi_nama',
                                    'placeholder'=>'Ketik Lokasi',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogLokasiAset', 'jsFunction'=>'$("#dialogLokasiAset").dialog("open");refreshGridLokasi();'),    
                            )); 
                ?>
            </div>
        </div>
        
        <div class = "control-group">
            <?php echo Chtml::label("Penanggung Jawab",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'pegawai_pjp_nama',array('placeholder'=>'Ketik Penanggung Jawab')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Teknisi",'invperalatan_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'pegawai_teknisi_nama',array('placeholder'=>'Ketik Teknisi')) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
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

<?php $this->endWidget();

$urlPrint = $this->createUrl('printInfo');
$js = <<< JSCRIPT
                       
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#workorder-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
