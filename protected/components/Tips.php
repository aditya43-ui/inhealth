<?php

/**
 * Params berisi:
 * 1. Nilai default
 * 2. Nilai id yang di sesuaikan dengan tabel di database
 * 3. Nilai konstant
 * 4. Nilai konstant yang disesuaikan dengan lookup_m
 */
class Tips
{
    public static function getTips()
    {
        return array(
            'tambah' => 'Gunakan tombol ini <div class="btn btn-primary">'
                . '<i class="icon-plus-sign icon-white"></i></div> berfungsi '
                . ' untuk menambah baris.',
            'tambah2' => 'Gunakan tombol ini <div class="btn btn-primary">'
                . '<i class="icon-plus icon-white"></i></div> berfungsi '
                . ' untuk menambah data.',
            'tambah3' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="icon-plus-sign icon-white"></i><i class="icon-chevron-right icon-white"></i></div> berfungsi '
                . ' untuk menampilkan dialog box pencarian.',
            'kurang' => 'Gunakan tombol ini <div class="btn btn-danger">'
                . '<i class="icon-minus-sign icon-white"></i></div> berfungsi '
                . ' untuk menghapus baris.',
            'simpan' => 'Gunakan tombol ini <div class="btn btn-danger">'
                . '<i class="entypo-check"></i> Simpan</div> berfungsi '
                . ' untuk menyimpan data.',
            'simpan2' => 'Gunakan tombol ini <div class="btn btn-primary">'
                . '<i class="entypo-floppy"></i> Simpan</div> berfungsi '
                . ' untuk menyimpan data.',
            'ulang' => 'Gunakan tombol ini <div class="btn btn-default">'
                . '<i class="entypo-arrows-ccw"></i> Ulang</div> berfungsi '
                . ' untuk mengulang kembali inputan.',
            'batalDialog' => 'Gunakan tombol ini <div class="btn btn-danger">'
                . '<i class="entypo-block"></i> Batal</div> berfungsi '
                . ' untuk membatalkan/menutup dialog box.',
            'ulang2' => 'Gunakan tombol ini <div class="btn btn-default">'
                . '<i class="entypo-arrows-ccw"></i> Ulang</div> berfungsi '
                . ' untuk mengulang kembali pencarian.',
            'masterUlang' => 'Gunakan tombol ini <div class="btn btn-danger">'
                . '<i class="entypo-arrows-ccw"></i> Ulang</div> berfungsi '
                . ' untuk membersihkan inputan pencarian lebih lanjut.',
            'cari' => 'Gunakan tombol ini <div class="btn btn-danger">'
                . '<i class="entypo-search"></i> Cari</div> berfungsi '
                . ' untuk mencari data.',
            'cari2' => 'Gunakan tombol ini <div class="btn btn-primary">'
                . '<i class="entypo-search"></i> Cari</div> berfungsi '
                . ' untuk mencari data.',
            'print' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="entypo-print"></i> Print</div> berfungsi '
                . ' untuk mencetak data.',
            'grafik' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="entypo-print"></i> Grafik</div> berfungsi '
                . ' untuk mencetak grafik.',
            'masterPRINT' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="entypo-print"></i> Print</div> berfungsi '
                . ' untuk mencetak data.',
            'masterPDF' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="icon-book icon-white"></i> PDF</div> berfungsi '
                . ' untuk mencetak data dalam bentuk PDF.',
            'masterCSV' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="icon-pdf icon-white"></i> CSV</div> berfungsi '
                . ' untuk mencetak data dalam bentuk CSV.',
            'masterEXCEL' => 'Gunakan tombol ini <div class="btn btn-info">'
                . '<i class="icon-pdf icon-white"></i> Excel</div> berfungsi '
                . ' untuk mencetak data dalam bentuk excel.',
            'pencarianlanjut' => 'Gunakan tombol ini <div class="search-button btn">'
                . '<i class="icon-accordion icon-white"></i> Pencarian Lanjut</div> berfungsi '
                . ' untuk menampilkan pencarian data lebih lanjut.',
            'status_print' => 'Tombol ini <div class="btn btn-info">'
                . '<i class="entypo-print"></i> Print</div> berarti dapat digunakan (tombol aktif), sedangkan '
                . ' tombol ini <div class="btn btn-info disabled" >'
                . '<i class="entypo-print"></i> Print</div> berarti tidak dapat digunakan (tombol tidak aktif)',
            'autocomplete-search' => 'Icon ini <i class="icon-list"></i><i class="entypo-search"></i>'
                . ' berfungsi untuk menampilkan list data sesuai dengan diketikkan dan menampilkan dialog box jika icon di klik.',
            'autocomplete' => 'Icon ini <i class="icon-list"></i>'
                . ' berfungsi untuk menampilkan list data sesuai dengan diketikkan.',
            'waktutime' => 'Icon ini <i class="entypo-calendar"></i><i class="icon-time"></i>'
                . ' berfungsi untuk menentukan tanggal dan waktu.',
            'tanggal' => 'Icon ini <i class="entypo-calendar"></i>'
                . ' berfungsi untuk menentukan tanggal.',
            'time' => 'Icon ini <i class="icon-time"></i>'
                . ' berfungsi untuk menentukan waktu.',
            'lihat' => 'Icon ini <i class="icon-form-lihat"></i>'
                . ' berfungsi untuk melihat data.',
            'ubah' => 'Icon ini <i class="icon-form-ubah"></i>'
                . ' berfungsi untuk mengubah data.',
            'hapus' => 'Icon ini <i class="icon-form-sampah"></i>'
                . ' berfungsi untuk menghapus data.',
            'closing' => 'Icon ini <i class="icon-form-silang"></i>'
                . ' berfungsi untuk closing(menutup) data.',
            'bukaclosing' => 'Icon ini <i class="icon-form-check"></i>'
                . ' berfungsi untuk membuka closing data.',
            'nonaktif' => 'Icon ini <i class="icon-form-silang"></i>'
                . ' berfungsi untuk menonaktifkan data.',
            'aktif' => 'Icon ini <i class="icon-form-check"></i>'
                . ' berfungsi untuk mengaktifkan data.',
            'bayar' => 'Icon ini <i class="icon-form-bayar"></i>'
                . ' berfungsi untuk melanjutkan ke proses transaksi pembayaran.',
            'detail' => 'Icon ini <i class="icon-form-detail"></i>'
                . ' berfungsi untuk melihat detail/rincian data.',
            'detail2' => 'Icon ini <i class="icon-form-formulir"></i>'
                . ' berfungsi untuk melihat detail/rincian data.',
            'batal' => 'Icon ini <i class="icon-form-silang"></i>'
                . ' berfungsi untuk membatalkan data.',
            'terima' => 'Icon ini <i class="icon-form-terimaobalkes"></i>'
                . ' berfungsi untuk melanjutkan ke transaksi penerimaan.',
            'printKartu' => 'Icon ini <i class="icon-form-print icon-white"></i>'
                . ' berfungsi untuk mencetak data.',

        );
    }
}
