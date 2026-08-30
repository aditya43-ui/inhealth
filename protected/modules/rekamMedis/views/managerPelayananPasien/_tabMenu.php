
<div class="tabber">
    <?php
    $module = '/'.$this->module->id;
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Skrinning', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_skrining', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlSkrinning())),
            array('label'=>'Evaluasi Awal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_evaluasi', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlEvaluasiAwal())),
            array('label'=>'Catatan Implementasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tabber_implementasi', 'onclick'=>'setTab(this);', 'tab'=>$this->getUrlCatatanImplementasi())),
        ),
    ));
    ?>
    
</div>
