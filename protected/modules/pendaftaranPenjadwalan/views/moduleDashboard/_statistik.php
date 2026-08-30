<div class="row">
<?php $this->renderPartial('_pie',array('id'=>'pie_rasio_kunjungan','title'=>'Rasio Kunjungan Pasien','modKunjungan'=>$modKunjungan,'dataProvider' => $dataProviderPasien)); ?>
<?php $this->renderPartial('_kotak',array('id'=>'kotak_pasien_rjrd','title'=>'','modKunjungan'=>$modKunjungan,'dataProviderRD' => $dataProviderPasienRD,'dataProviderRJ' => $dataProviderPasienRJ)); ?>
<?php $this->renderPartial('_kotak2',array('id'=>'kotak_pasien_ri','title'=>'','modKunjungan'=>$modKunjungan,'dataProvider' => $dataProviderPasienRI)); ?>
<?php $this->renderPartial('_batang',array('id'=>'batang_cara_bayar','title'=>'Jenis Penjamin','modKunjungan'=>$modKunjungan,'dataProvider' => $dataProviderPasien)); ?>
<?php $this->renderPartial('_batang2',array('id'=>'batang_status','title'=>'Status Pasien','modKunjungan'=>$modKunjungan,'dataProvider' => $dataProviderPasien)); ?>
<?php $this->renderPartial('_kotak3',array('id'=>'kotak_pasien_booking','title'=>'','dataProviderBooking' => $dataProviderBooking,'dataProviderJanjiPoli' => $dataProviderJanjiPoli)); ?>
<?php $this->renderPartial('_speedo',array('id'=>'speedo_kunjungan_pasien','title'=>'Jumlah Kunjungan Pasien','modKunjungan'=>$modKunjungan,'dataProvider' => $dataProviderPasien)); ?>
<?php $this->renderPartial('_notif',array('id'=>'notifikasi','title'=>'Notifikasi','isi_notif' => $isi_notif)); ?>
</div>
