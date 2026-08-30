
<?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
<div>
<iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll; min-height:1000px;" ></iframe>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>
