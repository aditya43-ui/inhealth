<div id="frame-detail">
    <?php
    $module = '/' . $this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => array(
            array('label' => 'Monitoring Pasca Anastesi/ Sedasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this,true);', 'tab' => 'anestesi/MonitoringPascaAnestesi/index', 'tabulasi' => 'rencana')),
            array('label' => 'Skor Pasca Anastesi /Sedasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick'=>'setTab(this,true);', 'tab' => 'anestesi/SkorpascaanestesiT/index', 'tabulasi' => 'evaluasi')),
            array('label' => 'Pesanan Pasca Anastesi / Sedasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this,true);', 'tab' => 'anestesi/PesananPascaAnastesi/index', 'tabulasi' => 'informasi')),
            
        ),
    ));
    ?>
</div>