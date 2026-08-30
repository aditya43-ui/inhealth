<style type="text/css">
    .text-center{
        text-align: center !important;
    }
</style>
<?php
    $this->breadcrumbs = array(
        'Tanda Vital & Balance Cairan',
    );
?>
<div style="height: 700px">
<?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
<div>
  <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
</div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('kunjungan'=>$kunjungan)); ?>
