/**
* - digunakan untuk mengerate tanggal atau waktu untuk menentukan hari, bulan dan lainnya
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/HWN>
*/

function getNamaHari(tgl,bulan,tahun){
    var weekday=new Array(7);
    weekday[0]='Minggu';
    weekday[1]='Senin';
    weekday[2]='Selasa';
    weekday[3]='Rabu';
    weekday[4]='Kamis';
    weekday[5]='Jumat';  
    weekday[6]='Sabtu';  
    
    var bln = getNoBulan(bulan);
    
    var a = new Date(bln+'/'+tgl+'/'+tahun);    
    
    return weekday[a.getDay()]; 
}

function getNoBulan(bulan){
    var weekday=new Array(12);
    weekday['Jan']='01';
    weekday['Feb']='02';
    weekday['Mar']='03';
    weekday['Apr']='04';
    weekday['Mei']='05';
    weekday['Jun']='06';
    weekday['Jul']='07';
    weekday['Agus']='08';
    weekday['Sep']='09';
    weekday['Okt']='10';
    // weekday['Nop']='11';
    // weekday['Nov']='11';
    weekday['Des']='12';
    
    return weekday[bulan];
}

function getSelisihHari(awal, akhir){
    var splitAwal = awal.split("/");
    var splitAkhir = akhir.split("/");

    var cekAwal = new Date(splitAwal[2],splitAwal[1],splitAwal[0]);
    var cekAkhir = new Date(splitAkhir[2],splitAkhir[1],splitAkhir[0]);       


    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = cekAkhir.getTime() - cekAwal.getTime();
    var days = millisBetween / millisecondsPerDay;                


   
    return Math.floor(days);    
}


