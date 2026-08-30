
<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pelayanan Kerohanian','url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'default-tab','onclick'=>'setTab(this);', 'tab'=>$this->getUrlPelayananKerohanian())),
        array('label'=>'Berita Acara Pasien Kabur','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlBeritaPasienKabur())),
        array('label'=>'Permintaan Pendapat Lain','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPendapatLain())),
        array('label'=>'Penolakan Resusitasi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPenolakanResusitasi())),
        array('label'=>'Tidak Dilakukan Resusitasi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTidakResusitasi())),
        array('label'=>'Penundaan dan Kelambatan','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPenundaanKelambatan())),
        array('label'=>'Perintah Tidak Dilakukan Resusitasi','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPerintahTidakResusitasi())),
        array('label'=>'Tindakan Restraint','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTindkanRestraint())),
        array('label'=>'Pelepasan Tindakan Restraint','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPelepasanTindkanRestraint())),
        array('label'=>'Observasi Pemasangan Restrain','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPemasanganRestraint())),
        array('label'=>'Pengkajian Keperawatan Kesehatan Jiwa','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getURLPengkajianJiwa())),
        array('label'=>'Monitoring Transfusi Darah','url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlMonitoringTransfusi())),
    ),
    'htmlOptions'=>array('class'=>'menu','id'=>'menuBoot')
));
?>