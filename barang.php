<!DOCTYPE html>
    <html>
        <head>
            <title>Form </title>
            <script src="js/jquery.js"></script>
            <script>
                //mengidentifikasikan variabel yang kita gunakan
                var id_paket;
                var nm_paket;
                var harga;
                var ket;
               
                $(function(){
                    $("#id_paket").load("proses.php","op=id_paket");
                    $("#barang").load("proses.php","op=barang");
                    
                    //jika ada perubahan di id_paket barang
                    $("#id_paket").change(function(){
                        id_paket=$("#id_paket").val();
                        
                        //tampilkan status loading dan animasinya
                        $("#status").html("loading. . .");
                        $("#loading").show();
                        
                        //lakukan pengiriman data
                        $.ajax({
                            url:"proses.php",
                            data:"op=ambildata&id_paket="+id_paket,
                            cache:false,
                            success:function(msg){
                                data=msg.split("|");
                                
                                //masukan isi data ke masing - masing field
                                $("#nm_paket").val(data[0]);
                                $("#harga").val(data[1]);
                                $("#ket").val(data[2]);
                                                              
                                
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });
                    });
                    
                    //cek id_paket barang yang sudah ada
                    $("#id_paket2").change(function(){
                        var kd=$("#id_paket2").val();
                        
                        $.ajax({
                            url:"proses.php",
                            data:"op=cek&kd="+kd,
                            success:function(data){
                                if(data==0){
                                    $("#pesan").html('id_paket Barang Tersedia');
                                    $("#id_paket2").css('border','3px #090 solid');
                                }else{
                                    $("#pesan").html('id_paket Barang sudah ada');
                                    $("#id_paket2").css('border','3px #c33 solid');
                                }
                            }
                        });
                    });
                    
                    //ketika tombol update di klik
                    $("#update").click(function(){
                        //cek apakah id_paket barang kosong atau tidak
                        id_paket=$("#id_paket").val();
                        if(id_paket=="id_paket"){
                            alert("Pilih id_paket barang dulu");
                            exit();
                        }
                        nm_paket=$("#nm_paket").val();
                        harga=$("#harga").val();
                        ket=$("#ket").val();
                        
                        
                        //tampilkan status update
                        $("#status").html('sedang diupdate. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses.php",
                            data:"op=update&id_paket="+id_paket+"&nm_paket="+nm_paket+"&harga="+harga+"&ket="+ket,
                            cache:false,
                            success:function(msg){
                                if(msg=='Sukses'){
                                    $("#status").html('Update Berhasil. . .');
                                }else{
                                    $("#status").html('ERROR. . .')
                                }
                                $("#loading").hide();
                                $("#nm_paket").val("");
                                $("#ket").val("");
                                $("#harga").val("");
                                
                                $("#barang").load("proses.php","op=barang");
                                $("#id_paket").load("proses.php","op=id_paket");
                            }
                        });
                    });
                    
                    //ketika tombol hapus diklik
                    $("#hapus").click(function(){
                        id_paket=$("#id_paket").val();
                        if(id_paket=="id_paket Barang"){
                            alert("id_paket barang hargam dipilih");
                            exit();
                        }
                        $("#status").html('Sedang Dihapus. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses.php",
                            data:"op=delete&id_paket="+id_paket,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html('Berhasil Dihapus. . .');
                                }else{
                                    $("#status").html('ERROR. . .');
                                }
                                $("#nm_paket").val("");
                                $("#ket").val("");
                                $("#harga").val("");
                                
                                $("#barang").load("proses.php","op=barang");
                                $("#id_paket").load("proses.php","op=id_paket");
                                
                            }
                        });
                    });
                    
                    //ketika tombol simpan diklik
                    $("#simpan").click(function(){
                        id_paket=$("#id_paket2").val();
                        if(id_paket==""){
                            alert("id_paket Barang Harus diisi");
                            exit();
                        }
                        nm_paket=$("#nm_paket").val();
                        harga=$("#harga").val();
                        ket=$("#ket").val();
                        
                        
                        $("#status").html("sedang diproses. . .");
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses.php",
                            data:"op=simpan&id_paket="+id_paket+"&nm_paket="+nm_paket+"&harga="+harga+"&ket="+ket,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html("Berhasil disimpan. . .");
                                }else{
                                    $("#status").html("ERROR. . .");
                                }
                                $("#loading").hide();
                                $("#nm_paket").val("");
                                $("#ket").val("");
                                $("#harga").val("");
                                
                                $("#id_paket2").val("");
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
                        <legend>Data Paket</legend>
                        <label>ID Paket</label>
                        <select id="id_paket"></select>
                        <input type="text" id="nm_paket" placeholder="nm_paket Paket" class="span2">
                        <input type="text" id="harga" placeholder="Harga" class="span2">
                        <input type="text" id="ket" placeholder="Keterangan" class="span2">
                        
                        <button id="update" class="btn">Update</button>
                        <button id="hapus" class="btn">Hapus</button>
                    <div id="status"></div><br>
                    <div id="barang"></div>';
                    break;
                case "tambah":
                        echo'<legend>Tambah Data Paket</legend>
                        <label>ID Paket</label>
                            <input type="text" id="id_paket2"> <span id="pesan"></span>
                        <label>Nama Paket</label>
                            <input type="text" id="nm_paket" >
                        <label>Harga</label>
                            <input type="text" id="harga" >
                        <label>Keterangan</label>
                            <input type="text" id="ket" >
                        <label></label>
                        <button id="simpan" class="btn">Simpan</button>
                        <a href="?page=barang" class="btn">Kembali</a>
                        <div id="status"></div>';
                    break;
            }
            ?>
        </body>
    </html>