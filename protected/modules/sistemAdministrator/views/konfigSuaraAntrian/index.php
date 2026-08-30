
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Konfigurasi Suara Antrian
        </div>        
    </div>
    <div class="panel-body form-horizontal">
        <?php $this->renderPartial('_search',array()); ?>
        <div class="clear"></div>
        <hr>
        <?php $this->renderPartial('form/_formTambah',array()); ?>
        <div id="form-antrian">
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>
<div class="form-suara-panggilan"></div>
<iframe id="suarapanggilan" src="" name="suarapenggilan" style="display: none;"></iframe>
<?php
    $this->renderPartial('_jsFunctions',array());
?>