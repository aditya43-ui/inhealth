<ol class="row-fluid">
    <div class="span6">
        <li>
            Bagian dengan tanda bintang <span class="required">*</span> harus diisi.
        </li>
        <li>
            Icon <i class="icon-calendar"></i><i class="icon-time"></i> untuk menentukan tanggal dan waktu.
        </li>
        <li>
            Icon <i class="icon-chevron-down"></i> untuk menampilkan form yang tersembunyi.
        </li>
        <li>
            Icon <i class="icon-list-alt"></i> berfungsi untuk mencari dan menampilkan daftar data sesuai yang diketikan.
        </li>
        <li>
            Icon <span class="add-on"><a id="" href="javascript:void(0);"><i class="icon-list-alt"></i><i class="icon-search"></i></a></span> 
            berfungsi untuk mencari dan menampilkan daftar data sesuai yang diketikan serta menampilkan dialog box jika diklik.
        </li>
        <li>
            Tombol  <div class="btn btn-mini btn-primary" name="yt0" type="button"><i class="icon-ok icon-white"></i></div> / <div class="btn btn-mini" name="yt0" type="button"><i class="icon-minus icon-white"></i></div>
            berfungsi untuk memberikan tanda dipilih / tidak dipilih.
        </li>
<!--        <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-plus icon-white"></i></div>
            berfungsi untuk menambah data.
        </li>-->
        <li>
            Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i></div>
            berfungsi untuk me-refresh form.
        </li>
<!--        <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-camera icon-white"></i> Ambil Foto</div>
            berfungsi untuk mengambil foto dari kamera.
        </li>-->
        <li>
            Tombol  <div class="btn btn-primary" name="yt0" type="button"><i class="icon-ok icon-white"></i> Simpan</div>
            berfungsi untuk menyimpan.
        </li>
        <li>
            Tombol  <div class="btn btn-danger" name="yt0" type="button"><i class="icon-refresh icon-white"></i> Ulang</div>
            berfungsi untuk melakukan pembayaran ulang.
        </li>
        
    </div>
    <div class="span6">
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i></div> dapat digunakan (sedang aktif)
            sedangkan tombol <div class="btn btn-info" name="yt0" type="button" disabled="disabled"><i class="icon-print icon-white"></i></div> tidak dapat digunakan (tidak aktif).
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i> Print Rincian</div>
            berfungsi untuk mencetak rincian biaya.
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i> Print Rincian RS</div>
            berfungsi untuk mencetak rincian biaya untuk rumah sakit.
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i> Print Bukti Kas Masuk</div>
            berfungsi untuk mencetak bukti kas masuk.
        </li>
        <li>
            Tombol  <div class="btn btn-info" name="yt0" type="button"><i class="icon-print icon-white"></i> Print Kuitansi</div>
            berfungsi untuk mencetak kuitansi pembayaran.
        </li>
    </div>
</ol>

<ol class="row-fluid">
	<h3>Rumus-rumus:</h3>
	<div class="span12">
		<li>
            Subtotal (Tindakan) = (Tarif Satuan * Jumlah) + Tarif Cyto - Diskon.
        </li>
		<li>
            Tanggungan Pasien (Tindakan) = Subtotal (Tindakan) - Pembebasan - Tanggungan Asuransi - Tanggungan Rumah Sakit.
        </li>
		<li>
            Subtotal (Obat Alkes) = (Harga Satuan * Jumlah) + Tarif Cyto - Diskon + Biaya Admin.
        </li>
		<li>
            Tanggungan Pasien (Obat Alkes) = Subtotal (Obat Alkes) - Tanggungan Asuransi - Tanggungan Rumah Sakit.
        </li>
		<li>
            Jumlah Pembulatan = Penambahan nominal agar jumlah yang harus dibayarkan pasien bulat, sesuai dengan yang diatur di konfig farmasi - pembulatan harga.
        </li>
		<li>
			Cara Pembayaran = Otomatis berdasarkan perbandingan antara jumlah yang harus dibayarkan dengan uang yang diterima.
		</li>
	</div>
</ol>
