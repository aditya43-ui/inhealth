
var singkatan_waktu = {'Asia/Jakarta': 'WIB', 'Asia/Makassar': 'WITA', 'Asia/Jayapura': 'WIT'};

function date_time()
{
        var date;
        if (app_timezone != null) {
            var date_proto = new Date();
            date = new Date(date_proto.toLocaleString('en-US', { timeZone: app_timezone }));
        } else {
            date = new Date;
        }
        
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nop', 'Des');
        var d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        var date = ""+d+"";
        if(date.length === 1)
            d = '0'+d;
//        var result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
        var result = d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
        
        $("input[class*='realtime']").val(result);
        $("div[class*='realtime']").html(result);
        return true;
}

function date_time_id(){ //RSPMC-770
        var date;
        if (app_timezone != null) {
            var date_proto = new Date();
            date = new Date(date_proto.toLocaleString('en-US', { timeZone: app_timezone }));
        } else {
            date = new Date;
        }
        
        var time_zone = date.getTimezoneOffset();
        
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nop', 'Des');
        var d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        daysId = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        var date = ""+d+"";
        if(date.length === 1)
            d = '0'+d;
//        var result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
        var result = daysId[day]+' '+ d+'-'+months[month]+'-'+year+' '+h+':'+m;
        
        if (app_timezone != null && singkatan_waktu[app_timezone] != null) {
            result += " " + singkatan_waktu[app_timezone];
        }
        
//        $("input[class*='realtimeHeader']").val(result);
        $("div[class*='headerTimeClock']").html(result);
        return true;
}

function date_time_get() {
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nop', 'Des');
        var d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        var date = ""+d+"";
        if(date.length === 1)
                d = '0'+d;
        //        var result = ''+days[day]+' '+months[month]+' '+d+' '+year+' '+h+':'+m+':'+s;
        var result = d+' '+months[month]+' '+year+' '+h+':'+m+':'+s;
        return result;
}