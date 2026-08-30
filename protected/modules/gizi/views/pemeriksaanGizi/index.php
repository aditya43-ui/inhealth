<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('daftarPasien/index'),
    'Konsultasi Gizi',
);
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jawabankonsul-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Konsultasi <b>Gizi Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));

        

        $this->renderPartial($this->path_view . '_tabMenu', array());
        $this->renderPartial($this->path_view . '_jsFunctions', array("modPasien" => $modPasien));
        ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>