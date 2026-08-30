<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$this->renderPartial('detailPersiapan', 
                array(
                        'model' => $model, 
                        'modRencana' => $modRencana, 
                        'modJenisPengadaan' => $modJenisPengadaan, 
                        'modJenis' => $modJenis,
                        'modDokumen' => $modDokumen));

$this->renderPartial($this->path_detail.'tabmenu');
?>
<div>
    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y: scroll"  width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);" ></iframe>
</div>

<?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-success','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));
