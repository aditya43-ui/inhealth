<?php
$this->renderPartial('_tabPhoto', array());
?>
<div class="gallery">
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'judulphoto' => $judulphoto)); ?>