<?php 
$this->widget('bootstrap.widgets.BootAlert'); 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'invpersparepart-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup'=>(!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '','onclick'=>(!isset($_GET['sukses']))? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>  
<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::label("Gambar",'invsparepart_gbr');?>
            </label>
            <div class="controls">
                <?php echo $form->fileField($model, 'invsparepart_gbr', array('onchange'=>'cekFile(this);','accept'=>'image/*','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'barang',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/barang') . '",
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
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                        setBarang(ui.item);
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 custom-only', 'placeholder'=>'Ketik Nama Barang',
                            'id'=>'barang_nama',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogBarang',
                        ),
                    ));
                ?>
                <?php echo $form->hiddenField($model, 'barang_id', array('class' => 'span1 numbers-only')); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
            <label class="control-label">
                <?php echo $form->labelEx($model, 'invpersparepart_jml', array('class'=>'control-label')); ?>
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'invpersparepart_jml', array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder'=>0)); ?>
                <?php echo $form->dropDownList($model, 'invpersparepart_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">
                <?php echo $form->labelEx($model, 'invpersparepart_jenis', array('class'=>'control-label')); ?>
            </label>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'invpersparepart_jenis', LookupM::getItems('perbekalan_jenis'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    ?>
</div>
<br>
<table id="table-sparepart" width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <th>Gambar</th>
        <th>Perbekalan</th>
        <th>Jumlah Kebutuhan</th>
        <th>Satuan</th>
        <th>Jenis</th>
        <th>Hapus</th>
    </thead>
    <tbody>
    <?php
        if(count($modSparepart) > 0){
            foreach($modSparepart AS $i=>$value){ 
    ?>
            <tr>   
                <td><?php 
                        if(!empty($value->invsparepart_gbr)){
                            $url_photopasien= ParamsUrl::urlInvpersparepartTumbsDirectory().'kecil_'.$value->invsparepart_gbr;
                        }else {
                            $url_photopasien=  ParamsUrl::urlInvpersparepartTumbsDirectory().'no_photo.jpeg';
                        }
                    ?>
                    <img src="<?php echo $url_photopasien; ?>">
                </td>
                <td><?php echo !empty($value->barang->barang_nama) ? $value->barang->barang_nama : "-"; ?></td>
                <td><?php echo !empty($value->invpersparepart_jml) ? $value->invpersparepart_jml : "-"; ?></td>
                <td><?php echo !empty($value->invpersparepart_satuan) ? $value->invpersparepart_satuan : "-"; ?></td>
                <td><?php echo !empty($value->invpersparepart_jenis) ? $value->invpersparepart_jenis : "-"; ?></td>
                <td style="text-align: center">
                    <?php echo CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord(".$value->invpersparepart_id.")",array("id"=>"$value->invpersparepart_id","rel"=>"tooltip","title"=>"Hapus"));?>
                </td>
            </tr>
    <?php
            }
        }
    ?>
    </tbody>
</table>

<?php $this->endWidget(); ?>

<script>
    function cekFile(obj){       

        var cek = $(obj).val();        

        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                          
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');                   

            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val("");                 
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                myAlert("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                                 
                return false;
            }
        }       
    }
    
    function setBarang(data) {
        $("#invpersparepart-m-form #MAInvpersparepartM_barang_id").val(data.barang_id);
        $("#invpersparepart-m-form #barang_nama").val(data.barang_nama);
        $("#invpersparepart-m-form #MAInvpersparepartM_invpersparepart_satuan").val(data.barang_satuan);
        $("#invpersparepart-m-form #barang_nama").blur();
    }

    function deleteRecord(id){
        var id = id;

        console.log(id);
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Apakah anda yakin untuk menghapus data ini ?','Perhatian!',function(r){
            if (r){
                $.post(url, {id: id},
                function(data){
                    if(data.status == 'sukses'){
                        window.location.reload();
                    }else{
                        myAlert('Data Gagal di Hapus')
                    }
                },"json");
            }
        });
    }
</script>
<!--Start Dialog Barang-->
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogBarang',
        'options'=>array(
                'title'=>'Data Barang',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>500,
                'minHeight'=>400,
                'resizable'=>true,
        ),
));

$modBarang = new BarangM('search');

$modBarang->unsetAttributes();
$modBarang->barang_aktif = true;

if (isset($_GET['BarangM'])){
    $modBarang->attributes = $_GET['BarangM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->search(),
    'filter'=>$modBarang,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                array(
                    "class"=>"btn-small",
                    "id" => "subkegiatanprogram",
                    "onClick" => "\$(\"#MAInvpersparepartM_barang_id\").val($data->barang_id);
                                  \$(\"#barang_nama\").val(\"$data->barang_nama\");
                                  \$(\"#MAInvpersparepartM_invpersparepart_satuan\").val(\"$data->barang_satuan\");

                                  \$(\"#dialogBarang\").dialog(\"close\");"

                 )
             )',
        ),
        
        'barang_nama',
        'barang_satuan',
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

?>
<?php $this->endWidget(); ?>
<!-- End Dialog Barang -->