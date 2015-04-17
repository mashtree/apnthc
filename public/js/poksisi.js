//<![CDATA[

var c_user = 0;
var c_body = 0;

$(document).ready(function() {
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var w_korektor      = $(".input_fields_korektor"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var add_b_korektor  = $(".add_field_button_korektor"); //Add button ID

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        $.getJSON('http://localhost/poksisi/assesment/get_pegawai', function(data) {
            var option = '<option value=0>--PILIH PESERTA--</option>';
            for (var i = data.length - 1; i >= 0; i--) {
                option += '<option value='+data[i].id+'>'+data[i].nama+' '+data[i].nip+'</option>';
            };

            $(wrapper).append('<div><select name="peserta[]">'+option+'</select><a href="#" class="hapus">Hapus kolom atas ane!</a></div>');
        });
    });

    $(wrapper).on("click",".hapus", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); 
    })

    $(add_b_korektor).click(function(e){ //on add input button click
        e.preventDefault();
        $.getJSON('http://localhost/poksisi/assesment/get_pegawai', function(data) {
            var option = '<option value=0>--PILIH KOREKTOR--</option>';
            for (var i = data.length - 1; i >= 0; i--) {
                option += '<option value='+data[i].id+'>'+data[i].nama+' '+data[i].nip+'</option>';
            };

            $(w_korektor).append('<div><select name="korektor[]">'+option+'</select><a href="#" class="hapus">Hapus kolom atas ane!</a></div>');
        });
    });
    
    $(w_korektor).on("click",".hapus", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); 
    })
});

//]]>

function rdelete(arg){

    var answer = '';
    if(arg=='assesment'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : jenis tes per assesment, sub tes per jenis tes assesment\npeserta assesment, korektor assesment\nnilai assesment!'
    }else if(arg=='jenistes'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : jenis tes per assesment, sub tes per jenis tes assesment\nnilai assesment!';
    }else if(arg=='tesasses'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : sub tes per jenis tes assesment,nilai assesment!';
    }else if(arg=='pegawai'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : peserta assesment, korektor assesment\nnilai assesment!'
    }else if(arg=='user'){
        answer = 'Anda yakin akan menghapus data ini?\nwewenang akan dialihkan ke user salah satu PLATINUM!';
    }else if(arg=='peserta'){
         answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : nilai assesment!';
    }else if(arg=='korektor'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : nilai assesment!';
    }else if(arg=='subtes'){
        answer = 'Anda yakin akan menghapus data ini?\n data yang ikut terhapus : nilai assesment!';
    }else if(arg=='nilai'){
        answer = 'Anda yakin akan menghapus data ini?';
    }
   
    if(confirm(answer)){
        return true;
    }
    return false;
}



/*$('html').click(function(){
    if(c_body>0){
        $('#cuser').fadeOut();
        c_body--;
    }
})*/