<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'peralatansterilisasi-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype' => 'multipart/form-data', 'onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<style>
    #hidden {
    /*z-index:9999;*/
    display:none;
    background-color:#fff;
    position:fixed;
    height:100%;
    width:100%;
    left: 0px;
    top: 0px;    
    text-align: center;
}
.close {
    position: absolute;
    right: 0px;
    top: 0px;
    background: #000;
    color: #fff;
    cursor: pointer;
    width: 30px;
    height: 30px;
    text-align: center;
    line-height: 30px;
}
</style>

	<?php echo $form->errorSummary($model); ?>

<div class="row-fluid" >
            <div class = "col-sm-12">
                <div class="control-group">
                <?php echo CHtml::label("File",'invgambar_nama',array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->fileField($model, 'invgambar_nama[]', array(
                            'onchange'=>'imgPreview(this, "#gallery");',
                            'multiple'=>'multiple',
                        )); ?>
                    <div id='gallery'>

                    </div>
                    <div class="controls">
                        <?php // echo $form->fileField($model,'invgambar_nama[]',array('maxlength'=>254, 'multiple'=>true)); ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
                ?>
            </div>
</div>
    <hr />
<div style="min-height:500px">
        <div align="center">
            <?php 
            foreach ($modShow as $value){
                if(!empty($value->invgambar_nama)){
                    $url_photopasien= ParamsUrl::urlInvgambarTumbsDirectory().'kecil_'.$value->invgambar_nama;
                    $url_photopasien2= ParamsUrl::urlInvgambarDirectory().$value->invgambar_nama;
                }else {
                    $url_photopasien=  ParamsUrl::urlInvgambarTumbsDirectory().'no_photo.jpeg';
                    $url_photopasien2=  ParamsUrl::urlInvgambarDirectory().'no_photo.jpeg';
                }
            ?>
            <div class="span3 tile_gambar">
                <span style="float:right; position: relative;"><?php echo CHtml::link('<i class="icon-white icon-remove"></i>','#', array(
                    'class'=>'btn btn-xs btn-danger',
                    'title'=>'Hapus',
                    'rel'=>'tooltip',
                    'onclick'=>'hapusGambar(this); return false;',
                    'data-id'=>$value->invgambar_id,
                )) ; ?></span>
                <div class="fileupload-preview fileupload-exists thumbnail dopelessrotate" style="width: 100%; height: 100%;">
                    <span class="image fit"><a class="img_upload" href="#" target="_blank" data-src="<?php echo $url_photopasien2; ?>"><img src="<?php echo $url_photopasien; ?>" style="height: 150px;" alt="image" /></a></span>
                </div>
                <br/>
            </div>
            
            <?php
            }
            ?>
            
        </div> 
    </div>
<div id="hidden">
        <img id="img_detail" src="<?php echo ""; ?>">
    <div class="close">X</div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(document).ready(function() {
  $('.img_upload').click( function(e) {
      e.preventDefault();
      $("#img_detail").prop("src", $(this).data("src"));
      $("#hidden").show();
      return false;
  });
  $('.close').click(function(){
      $("#hidden").hide();
  })
}); 

var parseHTML = function(str) {
  var tmp = document.implementation.createHTMLDocument();
  tmp.body.innerHTML = str;
  return tmp.body.children;
};

function imgPreview(input, placeToInsertImagePreview) {
	$(placeToInsertImagePreview).empty();
	if (input.files) {
		var filesAmount = input.files.length;
		for (i = 0; i < filesAmount; i++) {
			var reader = new FileReader();
			reader.onload = function(event) {
                var imgs = $(parseHTML('<img>')).prop('src', event.target.result);
                
                imgs.css("height", "100px");
                
				imgs.appendTo(placeToInsertImagePreview);
			}
			reader.readAsDataURL(input.files[i]);
		}
	}
};


function hapusGambar(obj) {
    myConfirm("Anda yakin untuk menghapus gambar peralatan ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('delete'); ?>', {
                id: $(obj).data('id')
            }, function(data) {
                if (data.ok == 1) {
                    $(obj).parents(".tile_gambar").remove();
                    myAlert(data.msg);
                } else {
                    myAlert(data.msg);
                }
            }, "json");
        }
    })
}
</script>


