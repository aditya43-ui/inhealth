<div id="form-carimenu" class="form-horizontal">
    <div class="row">
        <div class="control-group">
            <div class="controls" style="float:left;">
                <?php echo CHtml::activeTextField($modMenu, 'menu_nama',array("onchange"=>"updateListMenu();",'style'=>'width:1100px;','placeholder'=>'untuk mencari menu')); ?>
            </div>
            <div style="float:right;margin:-4px 20px 0 0;">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'button',"onclick"=>"updateListMenu()", 'rel'=>'tooltip', 'title'=>'Klik untuk mencari menu')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'button', "onclick"=>"setListMenuReset();", 'rel'=>'tooltip', 'title'=>'Klik untuk default view menu')); ?>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
/**
 * update (refresh) checklist menu (sistem administrator)
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateListMenu(){
    $('#carimenu').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetListPencarianMenu'); ?>',
        data: {data:$("#form-carimenu :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#carimenu').html(data.content);
            $('#carimenu').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * reset pencarian list menu
 */
function setListMenuReset(){
    $("#form-carimenu").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateListMenu();
}
</script>