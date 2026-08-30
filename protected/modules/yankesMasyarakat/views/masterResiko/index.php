<?php
/**
 * view utama untuk menampilkan interface awal menu master resiko
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Master <strong>Risiko</strong></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
        <?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
        <div>
                <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
        </div>
    </div>
</div>
    
