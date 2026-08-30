<!--<h6><b>Grafik</b></h6>-->
<?php
if (empty($riwayat)) {
    $riwayat = false;
}
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'SEP', 'url' => $this->createUrl('admin'), 'active' => !$riwayat),
        array('label' => 'Riwayat SEP', 'url' => $this->createUrl('riwayat'), 'active' => $riwayat),
    ),
));
?>