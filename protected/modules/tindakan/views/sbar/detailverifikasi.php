<style>
    body {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding: 2px;
    }


    .table thead:first-child{
        border-top:1px solid #000;
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }

    .text-center{
        text-align: center !important;
    }
</style>

<table width="100%">
    <tr>
        <td width="200px">Hasil Review Petugas Pengisi </td>
        <td width="5px">:</td>
        <td><?php echo $model->pegawaiverifikasi->namaLengkap; ?></td>
    </tr>
    <tr>
        <td colspan="3">
          <?php echo $model->hasil_review; ?>
        </td>
    </tr>
</table>
