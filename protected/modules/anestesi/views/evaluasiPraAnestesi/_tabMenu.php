<div id="frame-detail">
    <?php
    $module = '/' . $this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => array(
            array('label' => 'Rencana Tindakan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this,true);', 'tab' => 'anestesi/RencanaAnestesi/index', 'tabulasi' => 'rencana')),
            array('label' => 'Evaluasi Pra Anestesi / Pra Sedasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick'=>'setTab(this,true);', 'tab' => 'anestesi/EvaluasianestesiPraT/index', 'tabulasi' => 'evaluasi')),
            array('label' => 'Informasi Tindakan Anestesi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this,true);', 'tab' => 'anestesi/InformasiTindakanAnestesi/index', 'tabulasi' => 'informasi', 'class' => $hide)),
            array('label' => 'Persetujuan Tindakan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this,true);', 'tab' => 'anestesi/PersetujuanTindakanAnastesi/index', 'tabulasi' => 'persetujuan', 'class' => $hide)),
        ),
    ));
    ?>
</div>