<?php

/**
 * - digunakan sebagai Informasi Kalibrasi
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'kalibrasi-r-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
));
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Kalibrasi",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Jenis Peralatan",'Nama Barang', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'invperalatan_namabrg',array('class'=>' span3','placeholder'=>'Ketik jenis peralatan')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Kode Aset",'Nama Barang', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'invperalatan_kode',array('class'=>' span3','placeholder'=>'Ketik kode aset')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Seri",'Nama Barang', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'peralatan_noseri',array('class'=>'span3','placeholder'=>'Ketik nomor seri')) ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Hasil Kalibrasi",'vendor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'hasil_kalibrasi', LookupM::getItemsUrutan('hasilkalibrasi'),array('class'=>'span3','empty'=>'-- Pilih --')) ?>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">                
        <div class="control-group ">        
            <label class="control-label">Ruangan Aset</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ruangan_id',['class'=>'ruangan_id']); ?>   
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'ruangan_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/GetRuangan') . '",
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
                                setRuangan(ui.item)
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik Nama Ruangan Aset ",
                        'class' => 'span3 ruangan_nama',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruangan_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRuangan'),    
                ));
                ?>
            </div>
        </div>
        
        <div class="control-group ">        
            <label class="control-label">Lokasi Aset</label>
            <div class="controls">
                <?php 
                    $model->lokasi_id = null;
                    echo $form->hiddenField($model, 'lokasi_id',['class'=>'lokasi_id']); ?>   
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'lokasiaset_namalokasi',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/GetLokasiAset') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id:$(".ruangan_id").val(),
                                notpj:"ya"
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
                                setRuangan(ui.item)
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik Lokasi Aset ",
                        'class' => 'span3 lokasiaset_namalokasi',
                        'onblur'=>'if(this.value==""){$(".lokasi_id").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLokasi','jsFunction'=>'$("#dialogLokasi").dialog("open");refreshGridLokasi()'),    
                ));
                ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Vendor",'vendor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'supplier_nama',array('class'=>'custom-only span3','placeholder'=>'Ketik Nama Vendor')) ?>
            </div>
        </div>
        
        <div class = "control-group">
            <?php echo Chtml::label("Pelaksana",'vendor', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'pelaksanadet_nama',array('class'=>'span3','placeholder'=>'Ketik Nama pelaksana')) ?>
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