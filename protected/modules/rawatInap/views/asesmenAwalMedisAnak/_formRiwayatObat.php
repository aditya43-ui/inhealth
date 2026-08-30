<?php

?>
<script>
    function showRiwayatObat(nama_obat,dosis_obat,carapemberian,tglpemberian) {
       
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormRiwayatObat'); ?>',
            data: {nama_obat:nama_obat,dosis_obat:dosis_obat,carapemberian:carapemberian,tglpemberian:tglpemberian},
            dataType: "json",
            success:function(data){
			   if(data.pesan !== ""){
				   window.parent.myAlert(data.pesan);
				   return false;
			   }
                            $('#tbl-RiwayatObat > tbody').append(data.form);
                            renameInputRowRiwayatObat($("#tbl-RiwayatObat"));
                            
		},
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
   
      
    
  }
</script>

<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Nama Obat','nama_obat',array('class'=>'control-label'));  ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_obat_clone','',array('placeholder'=>'Nama Obat','class'=>'span4')); ?>
            <?php
            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-primary', 'onclick' => "setDialogObat(this);",
                    'judul_id' => 'Obat',
                    'data_id'=>'riwayat',
                    'id' => 'btnAddobat', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => 'tooltip', 'title' => 'Klik untuk menambah obat'))
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Dosis','dosis',array('class'=>'control-label')); ?>
        <div class="controls">
              <?php echo CHtml::textField('dosis_obat_clone','',array('placeholder'=>'Dosis Obat','class'=>'span4')); ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label('Cara Pemberian','carapemberian',array('class'=>'control-label')); ?>
        <div class="controls">
              <?php echo CHtml::textField('carapemberian_clone','',array('placeholder'=>'Cara Pemberian','class'=>'span4')); ?>      
        </div>
    </div>
    
    <div class="control-group">
                      <?php echo CHtml::label('Waktu dan tanggal Terakhir diberiksan','tanggalruangan',array('class'=>'control-label')); ?>
                      <div class="controls">
                          <?php 
                            $this->widget('MyDateTimePicker', array(
                            'name'=>'tglpemberian_clone',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                            'class'=>'span4','placeholder'=>'Tanggal Pemberian',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>   
                      </div>
    </div>  
    <div class="control-group ">
		<div class="controls">
			<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambahkan',
					array('onclick'=>'inputRiwayatObat(); return false;',
						  'class'=>'btn btn-primary',
						  'rel'=>"tooltip",
						  'title'=>"Klik untuk menambahkan Riwayat Obat",)); ?>
		</div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel-body overflow-x">  
    <table id="tbl-RiwayatObat" class="table table-striped table-condensed">
           <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Cara Pemberian</th>
                <th>Waktu/Tanggal Pemberian</th>
                <th>Hapus</th>
            </tr>
            </thead>
            <tbody>
                <?php
                     
                    if(!empty($modRiwayatObatSblm)){
                       foreach($modRiwayatObatSblm as $row){
                        $nama_obat=!empty($row->nama_obat)?$row->nama_obat:"nama_obat=''";
                        $dosis_obat=!empty($row->dosis_obat)?$row->dosis_obat:"nama_obat=''";
                        $carapemberian=!empty($row->carapemberian)?$row->carapemberian:"carapemberian=''";
                        $tglpemberian=!empty($row->tglpemberian)?$row->tglpemberian:"tglpemberian=''";
                      
                        ?>
                    <script>
                        showRiwayatObat("<?php echo $nama_obat?>","<?php echo $dosis_obat?>","<?php echo $carapemberian?>","<?php echo $tglpemberian?>");
                    </script>
                <?php
                       }
                    }
                ?>
            </tbody>
    </table> 
    </div>
</div>

<?php
echo CHtml::hiddenField("tampungObat",'',array('class'=>'readonly'));

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogAddRiwayatObat',
    'options' => array(
        'title' => 'Daftar Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 720,
        'resizable' => false,
    ),
));

    $modObat = new ObatalkesM('searchObatFarmasi');
    $modObat->unsetAttributes();
    if(isset($_GET['ObatalkesM'])) {
        $modObat->attributes = $_GET['ObatalkesM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'giagnosautama-m-grid',
            'dataProvider'=>$modObat->searchObatFarmasi(),
            'filter'=>$modObat,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                        
                        $attr = CJSON::encode($data->attributes);
                        
                        return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class'=>'btn-small',
                            'id'=>'selectObat',
                            'onclick'=>"
                                $('#nama_obat_clone').val('".$data->obatalkes_nama."');
                                $('#dialogAddRiwayatObat').dialog('close'); return false;"
                        ));
                    },
                ),
                'obatalkes_kode',
                'obatalkes_nama',
                
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
);
$this->endWidget();
?>

<script>
function setDialogObat(obj){
    $('#dialogAddRiwayatObat').dialog('open');
    $("#judul").html($(obj).attr('judul_id'));
    
    var data_id = $(obj).attr('data_id');
    
    $("#tampungObat").val(data_id);
}
</script>