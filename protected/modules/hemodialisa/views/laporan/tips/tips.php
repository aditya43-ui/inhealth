<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table border="0" style="padding :none;">
  <tr>
    <td>1. </td>
    <td>Icon <i class="icon-calendar"></i><i class="icon-time"></i> untuk menentukan tanggal dan waktu pendaftaran.</td>
  </tr>
  <tr>
    <td>2. </td>
    <td>Gunakan tombol ini    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'')); ?> dapat di klik dan akan memunculkan pilihan pencetakan melalui PDF, Excel, atau Grafik.</td>
  </tr>
  <tr>
    <td>3. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown">
<span class="caret"></span>
</a> dapat di klik dan akan memunculkan pilihan pencetakan melalui PDF, Excel, atau Grafik.</td>
  </tr>
  
  <tr>
    <td>3. </td>
    <td>Gunakan tombol ini  <button class="btn btn-primary" name="yt0" type="submit"><i class="icon-ok icon-white"></i>
Cari
</button> berfungsi untuk mengeksekusi pencarian.</td>
  </tr>
  <tr>
    <td>4. </td>
    <td>Gunakan tombol ini <a class="btn btn-primary" href="javascript:void(0);" onclick="return false;">
<i class="icon-print icon-white"></i>
Print
</a> untuk mencetak halaman file.</td>
  </tr>
  <tr>
    <td>5. </td>
    <td><table border="0">
  <tr>
    <td>Navigasi di atas berfungsi untuk menampilkan pencarian dalam bentuk digram batang, pie, atau garis.</td>
  </tr>
  <tr>
    <td><ul class="nav nav-tabs" style="width:170px;">
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
</table>

	</td>
  </tr>
  <tr>
    <td>6. </td>
    <td><table border="0">
  <tr>
    <td>Untuk fungsi dibawah dapat di klik untuk menampilkan form-form yang menjadi acuan dalam pencarian.
</td>
  </tr>
  <tr>
    <td><div class="accordion-heading1" style=" width:200px;"><a class="accordion-toggle btn-info" data-toggle="collapse" data-parent="#big"> Berdasarkan Wilayah
<i class="icon-white icon-chevron-down pull-right"></a></div> </td>
  </tr>
</table>
</td>
  </tr>
</table>
</p>