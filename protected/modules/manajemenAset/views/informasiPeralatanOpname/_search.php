<?php
/**
* - digunakan sebagai informasi sampel darah
* @author Aida Rahmawati <aidarahmawati@example.com>
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'informasisampel-r-search',
    'type'=>'horizontal',
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">
        
        <div class="control-group">
            <label class="control-label">Periode Opname</label>
            <div class="controls">
                <?= $form->dropDownList($model,'periodeasetopname_id', CHtml::listData(PeriodeasetopnameK::model()->findAllByAttributes([],['order'=>'tanggal_akhir DESC']), 'periodeasetopname_id', 'periodeasetopname_nama'),['empty'=>'-- Pilih --']) ?>
            </div>
        </div>
        
        <div class="control-group">		
            <?php echo CHtml::label("Tanggal Opname",'tglterimakantong', array('class' => 'control-label')) ?>
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
            <?php echo Chtml::label("Nomor Aset",'nomorbarcode_sample', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'invperalatan_kode',array('placeholder'=>'Ketik Nomor Aset')) ?>
            </div>
        </div>
        <div class="control-group ">        
            <label class="control-label">Nama Aset</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'barang_id',['class'=>'barang_id']); ?>   
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,                                        
                    'attribute' => 'invperalatan_namabrg',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/GetBarang') . '",
                            dataType: "json",
                            data: {
                                    term: request.term,
                                    type: "'.ParamsConst::TYPE_BARANG_INVENTARIS.'"
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
                                setBarang(ui.item)
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik Nama Aset ",
                        'class' => 'span3 invperalatan_namabrg',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'barang_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBarang'),    
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">                
        <?php if (!$model->ada_pj_aset){ ?>
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
                        'placeholder' => "Ketik Nama Aset ",
                        'class' => 'span3 ruangan_nama',
                        'onblur'=>'if(this.value==""){$("#' . CHtml::activeId($model, 'ruangan_id') . '").val("")}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRuangan'),    
                ));
                ?>
            </div>
        </div>
        <?php } ?>
        
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
                                ruangan_id:$(".ruangan_id").val()
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
        
        <div class="control-group">
            <label class="control-label">Kondisi Aset</label>
            <div class="controls">
                <?= $form->dropDownList($model,'invperalatan_keadaan', LookupM::getItems('kondisi_barang'),['empty'=>'-- Pilih --']) ?>
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
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
