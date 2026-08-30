<p>
<table style="width:100%; padding: none; border: none;">
  <tr>
    <td style="width: 20px;">1.</td>
    <td>Icon <i class="entypo-calendar"></i> untuk menentukan tanggal pendaftaran.</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Gunakan tombol ini <button class="btn btn-danger" name="yt0" type="submit"><i class="entypo-search"></i>
Cari
</button> berfungsi untuk mengeksekusi pencarian.</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Gunakan tombol ini    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'')); ?> dapat di klik dan akan memunculkan pilihan pencetakan melalui PDF, Excel, atau Grafik.</td>
  </tr>
  <tr>
    <tr>
        <td>4</td>
        <td>Tombol <a class="btn btn-info">
            <i class="icon-book icon-white"></i> PDF</a> untuk membuka data dengan PDF.</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Tombol <a class="btn btn-info">
            <i class="icon-pdf icon-white"></i> Excel</a> untuk membuka data dengan program Excel.</td>
    </tr>
    <tr>
        <td>6.</td>
        <td>Tombol <a class="btn btn-info">
            <i class="entypo-print"></i> Print</a> untuk mencetak data.</td>
    </tr>
  <tr>
    <td>7</td>
    <td><table style="width: 100%; border: none;">
  <tr>
    <td><ul class="nav nav-tabs">
<li class="active" type="batang" onclick="setType(this);">
<a>Batang</a>
</li>
<li class="" type="pie" onclick="setType(this);">
<a>Pie</a>
</li>
<li class="" type="garis" onclick="setType(this);">
<a>Garis</a>
</li>
</ul></td>
  </tr>
  <tr>
    <td>Navigasi ini berfungsi untuk menampilkan pencarian dalam bentuk digram batang, pie, atau garis.</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</p>