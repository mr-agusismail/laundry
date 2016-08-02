<!DOCTYPE html>
    <html>
        <head>
            <title>Form </title>
            <script src="js/jquery.js"></script>
            <script>
                //mengidentifikasikan variabel yang kita gunakan
                var id_pel;
                var nm_pel;
                var alamat;
                var no_hp;
               
                $(function(){
                    $("#id_pel").load("proses_pelanggan.php","op=id_pel");
                    $("#pelanggan").load("proses_pelanggan.php","op=pelanggan");
                    
                    //jika ada perubahan di id_pel pelanggan
                    $("#id_pel").change(function(){
                        id_pel=$("#id_pel").val();
                        
                        //tampilkan status loading dan animasinya
                        $("#status").html("loading. . .");
                        $("#loading").show();
                        
                        //lakukan pengiriman data
                        $.ajax({
                            url:"proses_pelanggan.php",
                            data:"op=ambildata&id_pel="+id_pel,
                            cache:false,
                            success:function(msg){
                                data=msg.split("|");
                                
                                //masukan isi data ke masing - masing field
                                $("#nm_pel").val(data[0]);
                                $("#alamat").val(data[1]);
                                $("#no_hp").val(data[2]);
                                                              
                                
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });
                    });
                    
                    //cek id_pel pelanggan yang sudah ada
                    $("#id_pel2").change(function(){
                        var kd=$("#id_pel2").val();
                        
                        $.ajax({
                            url:"proses_pelanggan.php",
                            data:"op=cek&kd="+kd,
                            success:function(data){
                                if(data==0){
                                    $("#pesan").html('id pelanggan Tersedia');
                                    $("#id_pel2").css('border','3px #090 solid');
                                }else{
                                    $("#pesan").html('id pelanggan sudah ada');
                                    $("#id_pel2").css('border','3px #c33 solid');
                                }
                            }
                        });
                    });
                    
                    //no_hpika tombol update di klik
                    $("#update").click(function(){
                        //cek apakah id_pel pelanggan kosong atau tidak
                        id_pel=$("#id_pel").val();
                        if(id_pel=="id_pel"){
                            alert("Pilih id pelanggan dulu");
                            exit();
                        }
                        nm_pel=$("#nm_pel").val();
                        alamat=$("#alamat").val();
                        no_hp=$("#no_hp").val();
                        
                        
                        //tampilkan status update
                        $("#status").html('sedang diupdate. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_pelanggan.php",
                            data:"op=update&id_pel="+id_pel+"&nm_pel="+nm_pel+"&alamat="+alamat+"&no_hp="+no_hp,
                            cache:false,
                            success:function(msg){
                                if(msg=='Sukses'){
                                    $("#status").html('Update Berhasil. . .');
                                }else{
                                    $("#status").html('ERROR. . .')
                                }
                                $("#loading").hide();
                                $("#nm_pel").val("");
                                $("#no_hp").val("");
                                $("#alamat").val("");
                                
                                $("#pelanggan").load("proses_pelanggan.php","op=pelanggan");
                                $("#id_pel").load("proses_pelanggan.php","op=id_pel");
                            }
                        });
                    });
                    
                    //no_hpika tombol hapus diklik
                    $("#hapus").click(function(){
                        id_pel=$("#id_pel").val();
                        if(id_pel=="id_pel pelanggan"){
                            alert("id  pelanggan alamatm dipilih");
                            exit();
                        }
                        $("#status").html('Sedang Dihapus. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_pelanggan.php",
                            data:"op=delete&id_pel="+id_pel,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html('Berhasil Dihapus. . .');
                                }else{
                                    $("#status").html('ERROR. . .');
                                }
                                $("#nm_pel").val("");
                                $("#no_hp").val("");
                                $("#alamat").val("");
                                
                                $("#pelanggan").load("proses_pelanggan.php","op=pelanggan");
                                $("#id_pel").load("proses_pelanggan.php","op=id_pel");
                                
                            }
                        });
                    });
                    
                    //no_hpika tombol simpan diklik
                    $("#simpan").click(function(){
                        id_pel=$("#id_pel2").val();
                        if(id_pel==""){
                            alert("id pelanggan Harus diisi");
                            exit();
                        }
                        nm_pel=$("#nm_pel").val();
                        alamat=$("#alamat").val();
                        no_hp=$("#no_hp").val();
                        
                        
                        $("#status").html("sedang diproses. . .");
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_pelanggan.php",
                            data:"op=simpan&id_pel="+id_pel+"&nm_pel="+nm_pel+"&alamat="+alamat+"&no_hp="+no_hp,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html("Berhasil disimpan. . .");
                                }else{
                                    $("#status").html("ERROR. . .");
                                }
                                $("#loading").hide();
                                $("#nm_pel").val("");
                                $("#no_hp").val("");
                                $("#alamat").val("");
                                
                                $("#id_pel2").val("");
                            }
                        });
                    });
                });
            </script>
        </head>
        <body>
            <?php
            $p=isset($_GET['act'])?$_GET['act']:null;
            switch($p){
                default:
                    echo'
                        <legend>Data Pelanggan</legend>
                        <label>ID Pelanggan</label>
                        <select id="id_pel"></select>
                        <input type="text" id="nm_pel" placeholder="Nama Pelanggan" class="span2">
                        <input type="text" id="alamat" placeholder="Alamat" class="span2">
                        <input type="text" id="no_hp" placeholder="No Hp" class="span2">
                        
                        <button id="update" class="btn">Update</button>
                        <button id="hapus" class="btn">Hapus</button>
                    <div id="status"></div><br>
                    <div id="pelanggan"></div>';
                    break;
                case "tambah":
                        echo'<legend>Tambah Data Pelanggan</legend>
                         
                        <label>ID Pelanggan (masukan no hp)</label>
                            <input type="text" id="id_pel2"> <span id="pesan"></span>
                        <label>Nama Pelanggan</label>
                            <input type="text" id="nm_pel" >
                        <label>Alamat pelanggan</label>
                            <input type="text" id="alamat" >
                        <label>No Hp Pelanggan</label>
                            <input type="text" id="no_hp" >
                        <label></label>
                        <button id="simpan" class="btn">Simpan</button>
                        <a href="?page=pelanggan" class="btn">Kembali</a>
                        <div id="status"></div>';
                    break;
            }
            ?>
        </body>
    </html>