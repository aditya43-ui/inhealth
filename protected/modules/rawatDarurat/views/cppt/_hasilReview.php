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
<table style="width: 100%">
    <tr>
        <td>Hasil Review DPJP : </td>
        <td><?php echo preg_replace('#</?p.*?>#is', '', $model->verifikasidpjp_hasilreview);  ?></td>
    </tr>
</table>
