<style>
    .border th, .border td{
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000 !important;        
    }
    
    thead tr{
        background:none !important;
        color:#333 !important;
    }

    .border {
        box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none !important;
    }
    .table-bordered th + th, .table-bordered td + td, .table-bordered th + td, .table-bordered td + th {
        border-left: 1px solid #000;
        box-shadow:none !important;
    }
    .table-bordered{
        border-collapse: collapse;
    }
</style>
<table width="100%" class="border" border="1px solid" style="font-size: 8px !important;">
    <thead style="font-size: 8px !important;">
        <tr>
            <th rowspan="3" style="text-align:center; vertical-align: middle"> No </th>
            <th rowspan="3" style="text-align:center; vertical-align: middle"> Kelompok Umur </th>
            <th rowspan="3" style="text-align:center; vertical-align: middle" >Jumlah Total Donasi <br> (kantong) <br> (a)</th>
            <th colspan="4" style="text-align:center; vertical-align: middle">Jumlah Donasi Dalam Gedung (jumlah kantong) <br> yang berasal dari <br> (b) </th>
            <th colspan="2" style="text-align:center; vertical-align: middle">Jumlah Donasi Sukarela dari Kegiatan <br> Mobile Unit (jumlah kantong) <br> (c) </th>
            <th colspan="2" style="text-align:center; vertical-align: middle"> Jumlah Donasi Darah Menurut Jenis Kelamin <br> (jumlah kantong) <br> (d) </td>    
            <th colspan="8" style="text-align:center; vertical-align: middle"> Jumlah Donasi Darah Menurut Golongan Darah dan Rhesus <br> (e) </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align:center;vertical-align: middle"> Donor Sukarela </th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Donor Pengganti </th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Donor Bayaran </th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Baru </th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Ulang</th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Pria </th>
            <th rowspan="2" style="text-align:center;vertical-align: middle"> Wanita </th>
            <th colspan="2" style="text-align:center;vertical-align: middle"> O </th>
            <th colspan="2" style="text-align:center;vertical-align: middle"> A </th>
            <th colspan="2" style="text-align:center;vertical-align: middle"> B </th>
            <th colspan="2" style="text-align:center;vertical-align: middle"> AB </th>
        </tr>
        <tr>
            <th style="text-align:center;"> Baru </th>
            <th style="text-align:center;"> Ulang </th>
            <th style="text-align:center;"> Pos </th>
            <th style="text-align:center;"> Neg </th>
            <th style="text-align:center;"> Pos </th>
            <th style="text-align:center;"> Neg </th>
            <th style="text-align:center;"> Pos </th>
            <th style="text-align:center;"> Neg </th>
            <th style="text-align:center;"> Pos </th>
            <th style="text-align:center;"> Neg </th>

        </tr>
    </thead>
    <tbody style="font-size: 8px !important;">
        <?php
        $tglsekarang = 'sekarang';
        $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
        $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
        $a_positif = 'a_positif';
        $a_negatif = 'a_negatif';
        $b_positif = 'b_positif';
        $b_negatif = 'b_negatif';
        $o_negatif = 'o_negatif';
        $o_positif = 'o_positif';
        $ab_positif = 'ab_positif';
        $ab_negatif = 'ab_negatif';
        //Donasi Sukarela Baru 
        $donasi_sukarela_baru = 'donasi_sukerela_baru';
        $donasi_sukarela_ulang = 'donasi_sukerela_ulang';
        $donasi_pengganti = 'donasi_pengganti';
        $donasi_luar_baru = 'donasi_luar_baru';
        $donasi_luar_ulang = 'donasi_luar_ulang';
        ?>  
        <tr>
            <td style="text-align: center"> 1. </td>
            <td style="text-align: center">< 18 Thn</td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']['umur<18']) ? $b["kelompok_18"]['det']['umur<18'] : ""; ?></td>                
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$donasi_sukarela_baru"]['umur<18']) ? $b["kelompok_18"]['det']["$donasi_sukarela_baru"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$donasi_sukarela_ulang"]['umur<18']) ? $b["kelompok_18"]['det']["$donasi_sukarela_ulang"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$donasi_pengganti"]['umur<18']) ? $b["kelompok_18"]['det']["$donasi_pengganti"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php // echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['umur<18']) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['umur<18'] :""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$donasi_luar_baru"]['umur<18']) ? $b["kelompok_18"]['det']["$donasi_luar_baru"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$donasi_luar_ulang"]['umur<18']) ? $b["kelompok_18"]['det']["$donasi_luar_ulang"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$laki"]['umur<18']) ? $b["kelompok_18"]['det']["$laki"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$perempuan"]['umur<18']) ? $b["kelompok_18"]['det']["$perempuan"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$o_positif"]['umur<18']) ? $b["kelompok_18"]['det']["$o_positif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$a_negatif"]['umur<18']) ? $b["kelompok_18"]['det']["$a_negatif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$a_positif"]['umur<18']) ? $b["kelompok_18"]['det']["$a_positif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$a_negatif"]['umur<18']) ? $b["kelompok_18"]['det']["$a_negatif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$b_positif"]['umur<18']) ? $b["kelompok_18"]['det']["$b_positif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$b_negatif"]['umur<18']) ? $b["kelompok_18"]['det']["$b_negatif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$ab_positif"]['umur<18']) ? $b["kelompok_18"]['det']["$ab_positif"]['umur<18'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_18"]['det']["$ab_negatif"]['umur<18']) ? $b["kelompok_18"]['det']["$ab_negatif"]['umur<18'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align: center"> 2. </td>
            <td style="text-align: center">18 - 24 Thn</td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']['18sampai24']) ? $b["kelompok_24"]['det']['18sampai24'] : ""; ?></td>                
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$donasi_sukarela_baru"]['18sampai24']) ? $b["kelompok_24"]['det']["$donasi_sukarela_baru"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$donasi_sukarela_ulang"]['18sampai24']) ? $b["kelompok_24"]['det']["$donasi_sukarela_ulang"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$donasi_pengganti"]['18sampai24']) ? $b["kelompok_24"]['det']["$donasi_pengganti"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php // echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24'] :""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$donasi_luar_baru"]['18sampai24']) ? $b["kelompok_24"]['det']["$donasi_luar_baru"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$donasi_luar_ulang"]['18sampai24']) ? $b["kelompok_24"]['det']["$donasi_luar_ulang"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$laki"]['18sampai24']) ? $b["kelompok_24"]['det']["$laki"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$perempuan"]['18sampai24']) ? $b["kelompok_24"]['det']["$perempuan"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$o_positif"]['18sampai24']) ? $b["kelompok_24"]['det']["$o_positif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$o_negatif"]['18sampai24']) ? $b["kelompok_24"]['det']["$o_negatif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$a_positif"]['18sampai24']) ? $b["kelompok_24"]['det']["$a_positif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$a_negatif"]['18sampai24']) ? $b["kelompok_24"]['det']["$a_negatif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$b_positif"]['18sampai24']) ? $b["kelompok_24"]['det']["$b_positif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$b_negatif"]['18sampai24']) ? $b["kelompok_24"]['det']["$b_negatif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$ab_positif"]['18sampai24']) ? $b["kelompok_24"]['det']["$ab_positif"]['18sampai24'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_24"]['det']["$ab_negatif"]['18sampai24']) ? $b["kelompok_24"]['det']["$ab_negatif"]['18sampai24'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align: center"> 3. </td>
            <td style="text-align: center">25 - 44 Thn</td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']['25sampai44']) ? $b["kelompok_44"]['det']['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$donasi_sukarela_baru"]['25sampai44']) ? $b["kelompok_44"]['det']["$donasi_sukarela_baru"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$donasi_sukarela_ulang"]['25sampai44']) ? $b["kelompok_44"]['det']["$donasi_sukarela_ulang"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$donasi_pengganti"]['25sampai44']) ? $b["kelompok_44"]['det']["$donasi_pengganti"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php // echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24'] :""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$donasi_luar_baru"]['25sampai44']) ? $b["kelompok_44"]['det']["$donasi_luar_baru"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$donasi_luar_ulang"]['25sampai44']) ? $b["kelompok_44"]['det']["$donasi_luar_ulang"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$laki"]['25sampai44']) ? $b["kelompok_44"]['det']["$laki"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$perempuan"]['25sampai44']) ? $b["kelompok_44"]['det']["$perempuan"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$o_positif"]['25sampai44']) ? $b["kelompok_44"]['det']["$o_positif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$o_negatif"]['25sampai44']) ? $b["kelompok_44"]['det']["$o_negatif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$a_positif"]['25sampai44']) ? $b["kelompok_44"]['det']["$a_positif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$a_negatif"]['25sampai44']) ? $b["kelompok_44"]['det']["$a_negatif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$b_positif"]['25sampai44']) ? $b["kelompok_44"]['det']["$b_positif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$b_negatif"]['25sampai44']) ? $b["kelompok_44"]['det']["$b_negatif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$ab_positif"]['25sampai44']) ? $b["kelompok_44"]['det']["$ab_positif"]['25sampai44'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_44"]['det']["$ab_negatif"]['25sampai44']) ? $b["kelompok_44"]['det']["$ab_negatif"]['25sampai44'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align: center"> 4. </td>
            <td style="text-align: center">45 - 59 Thn</td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']['45sampai59']) ? $b["kelompok_59"]['det']['45sampai59'] : ""; ?></td>                
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$donasi_sukarela_baru"]['45sampai59']) ? $b["kelompok_59"]['det']["$donasi_sukarela_baru"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$donasi_sukarela_ulang"]['45sampai59']) ? $b["kelompok_59"]['det']["$donasi_sukarela_ulang"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$donasi_pengganti"]['45sampai59']) ? $b["kelompok_59"]['det']["$donasi_pengganti"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php // echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['18sampai24'] :""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$donasi_luar_baru"]['45sampai59']) ? $b["kelompok_59"]['det']["$donasi_luar_baru"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$donasi_luar_ulang"]['45sampai59']) ? $b["kelompok_59"]['det']["$donasi_luar_ulang"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$laki"]['45sampai59']) ? $b["kelompok_59"]['det']["$laki"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$perempuan"]['45sampai59']) ? $b["kelompok_59"]['det']["$perempuan"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$o_positif"]['45sampai59']) ? $b["kelompok_59"]['det']["$o_positif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$o_negatif"]['45sampai59']) ? $b["kelompok_59"]['det']["$o_negatif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$a_positif"]['45sampai59']) ? $b["kelompok_59"]['det']["$a_positif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$a_negatif"]['45sampai59']) ? $b["kelompok_59"]['det']["$a_negatif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$b_positif"]['45sampai59']) ? $b["kelompok_59"]['det']["$b_positif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$b_negatif"]['45sampai59']) ? $b["kelompok_59"]['det']["$b_negatif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$ab_positif"]['45sampai59']) ? $b["kelompok_59"]['det']["$ab_positif"]['45sampai59'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_59"]['det']["$ab_negatif"]['45sampai59']) ? $b["kelompok_59"]['det']["$ab_negatif"]['45sampai59'] : ""; ?></td>
        </tr>
        <tr>
            <td style="text-align: center"> 5. </td>
            <td style="text-align: center"> > 60Thn</td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']['lebih61']) ? $b["kelompok_60"]['det']['lebih61'] : ""; ?></td>   
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$donasi_sukarela_baru"]['lebih61']) ? $b["kelompok_60"]['det']["$donasi_sukarela_baru"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$donasi_sukarela_ulang"]['lebih61']) ? $b["kelompok_60"]['det']["$donasi_sukarela_ulang"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$donasi_pengganti"]['lebih61']) ? $b["kelompok_60"]['det']["$donasi_pengganti"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php // echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['18sampai24']) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['18sampai24'] :"";  ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$donasi_luar_baru"]['lebih61']) ? $b["kelompok_60"]['det']["$donasi_luar_baru"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$donasi_luar_ulang"]['lebih61']) ? $b["kelompok_60"]['det']["$donasi_luar_ulang"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$laki"]['lebih61']) ? $b["kelompok_60"]['det']["$laki"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$perempuan"]['lebih61']) ? $b["kelompok_60"]['det']["$perempuan"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$o_positif"]['lebih61']) ? $b["kelompok_60"]['det']["$o_positif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$o_negatif"]['lebih61']) ? $b["kelompok_60"]['det']["$o_negatif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$a_positif"]['lebih61']) ? $b["kelompok_60"]['det']["$a_positif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$a_negatif"]['lebih61']) ? $b["kelompok_60"]['det']["$a_negatif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$b_positif"]['lebih61']) ? $b["kelompok_60"]['det']["$b_positif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$b_negatif"]['lebih61']) ? $b["kelompok_60"]['det']["$b_negatif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$ab_positif"]['lebih61']) ? $b["kelompok_60"]['det']["$ab_positif"]['lebih61'] : ""; ?></td>
            <td style="text-align: center"><?php echo isset($b["kelompok_60"]['det']["$ab_negatif"]['lebih61']) ? $b["kelompok_60"]['det']["$ab_negatif"]['lebih61'] : ""; ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: center"> JUMLAH </td>
            <td style="text-align: center"> <?php echo isset($b['det']['jumlahnya']['jumlah']) ? $b['det']['jumlahnya']['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$donasi_sukarela_baru]['jumlah']) ? $b['det'][$donasi_sukarela_baru]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$donasi_sukarela_ulang]['jumlah']) ? $b['det'][$donasi_sukarela_ulang]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$donasi_pengganti]['jumlah']) ? $b['det'][$donasi_pengganti]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$donasi_luar_baru]['jumlah']) ? $b['det'][$donasi_luar_baru]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$donasi_luar_ulang]['jumlah']) ? $b['det'][$donasi_luar_ulang]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$laki]['jumlah']) ? $b['det'][$laki]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$perempuan]['jumlah']) ? $b['det'][$perempuan]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$o_positif]['jumlah']) ? $b['det'][$o_positif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$o_negatif]['jumlah']) ? $b['det'][$o_negatif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$a_positif]['jumlah']) ? $b['det'][$a_positif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$a_negatif]['jumlah']) ? $b['det'][$a_negatif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$b_positif]['jumlah']) ? $b['det'][$b_positif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$b_negatif]['jumlah']) ? $b['det'][$b_negatif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$ab_positif]['jumlah']) ? $b['det'][$ab_positif]['jumlah'] : ""; ?> </td>
            <td style="text-align: center"> <?php echo isset($b['det'][$ab_negatif]['jumlah']) ? $b['det'][$ab_negatif]['jumlah'] : ""; ?> </td>
        </tr> 
    </tfoot>
</table>