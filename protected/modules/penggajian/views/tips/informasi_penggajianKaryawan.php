<ol>
    <div class="col-sm-6">
        <li>
            Icon <i class="icon-form-detail"></i>
            berfungsi untuk melihat penggajian pegawai secara detail.
        </li>
        <?php
        if (isset($gaji)) :
            if ($gaji == true) {
        ?>
                <li>
                    Icon <i class="icon-form-bayar"></i>
                    berfungsi untuk melanjutkan ke halaman transaksi pembayaran gaji.
                </li>
        <?php
            }
        endif;
        ?>

        <li>
            Icon <i class="entypo-calendar"></i>
            berfungsi untuk menentukan tanggal.
        </li>
        <li>
            Tombol <div class="btn btn-danger" name="yt0" type="button"><i class="entypo-search"></i> Cari</div>
            berfungsi untuk mencari data.
        </li>
        <li>
            Tombol <div class="btn btn-default" name="yt0" type="button"><i class="entypo-arrows-ccw"></i> Ulang</div>
            berfungsi untuk mengulang kembali pencarian.
        </li>
    </div>
</ol>