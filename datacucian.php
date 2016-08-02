<!DOCTYPE html>
    <html>
        <head>
            <title>Form </title>
            <script src="js/jquery.js"></script>
            <script>
                //mengidentifikasikan variabel yang kita gunakan
                var id_nota;
                var id_pel;
                var nm_pel;
                var tgl;
                var total;
				 var status_bayar;
                  var status_cucian;
				 var katakunci;
               
                $(function(){
                    $("#id_nota").load("proses_datacucian.php","op=id_nota");
                    $("#barang").load("proses_datacucian.php","op=barang");
                   
                    //jika ada perubahan di id_nota barang
                    $("#id_nota").change(function(){
                        id_nota=$("#id_nota").val();
                        
                        //tampilkan status loading dan animasinya
                        $("#status").html("loading. . .");
                        $("#loading").show();
                        
                        //lakukan pengiriman data
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=ambildata&id_nota="+id_nota,
                            cache:false,
                            success:function(msg){
                                data=msg.split("|");
                                
                                //masukan isi data ke masing - masing field
                                $("#id_pel").val(data[0]);
                                $("#tgl").val(data[1]);
                                $("#total").val(data[2]);
								$("#status_bayar").val(data[3]);
                                $("#status_cucian").val(data[4]);
                                                              
                                
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });

                    });
                    
                    //cek id_nota barang yang sudah ada
                    $("#id_nota2").change(function(){
                        var kd=$("#id_nota2").val();
                        
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=cek&kd="+kd,
                            success:function(data){
                                if(data==0){
                                    $("#pesan").html('id_nota Barang Tersedia');
                                    $("#id_nota2").css('border','3px #090 solid');
                                }else{
                                    $("#pesan").html('id_nota Barang sudah ada');
                                    $("#id_nota2").css('border','3px #c33 solid');
                                }
                            }
                        });
                    });
                    
                    //totalika tombol update di klik
                    $("#update").click(function(){
                        //cek apakah id_nota barang kosong atau tidak
                        id_nota=$("#id_nota").val();
                        if(id_nota=="id_nota"){
                            alert("Pilih id_nota barang dulu");
                            exit();
                        }
                        id_pel=$("#id_pel").val();
                        tgl=$("#tgl").val();
                        total=$("#total").val();
						status_bayar=$("#status_bayar").val();
                        status_cucian=$("#status_cucian").val();
                        
                        //tampilkan status update
                        $("#status").html('sedang diupdate. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=update&id_nota="+id_nota+"&id_pel="+id_pel+"&tgl="+tgl+"&total="+total+"&status_bayar="+status_bayar+"&status_cucian="+status_cucian,
                            cache:false,
                            success:function(msg){
                                if(msg=='Sukses'){
                                    $("#status").html('Update Berhasil. . .');
                                }else{
                                    $("#status").html('ERROR. . .')
                                }
                                $("#loading").hide();
                                $("#id_pel").val("");
                                $("#total").val("");
                                $("#tgl").val("");
								$("#status_bayar").val("");
                                $("#status_cucian").val("");
                                
                                $("#barang").load("proses_datacucian.php","op=barang");
                                $("#id_nota").load("proses_datacucian.php","op=id_nota");
                            }
                        });
                    });
                    
                    //totalika tombol hapus diklik
                    $("#hapus").click(function(){
                        id_nota=$("#id_nota").val();
                        if(id_nota=="id_nota Barang"){
                            alert("id_nota barang blom dipilih");
                            exit();
                        }
                        $("#status").html('Sedang Dihapus. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=delete&id_nota="+id_nota,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html('Berhasil Dihapus. . .');
                                }else{
                                    $("#status").html('ERROR. . .');
                                }
                                $("#id_pel").val("");
                                $("#total").val("");
                                $("#tgl").val("");
								$("#status_bayar").val("");
                                $("#status_cucian").val("");
                                $("#barang").load("proses_datacucian.php","op=barang");
                                $("#id_nota").load("proses_datacucian.php","op=id_nota");
                                
                            }
                        });
                    });
                    
					   //totalika tombol cari diklik
                    $("#cari").click(function(){
                        id_nota=$("#id_nota").val();
                        id_pel=$("#id_pel").val();
						katakunci=$("#katakunci").val();

                        tgl=$("#tgl").val();
                        total=$("#total").val();
                         status_bayar=$("#status_bayar").val();
                        $("#status").html('Sedang Dicari. . .');
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=cari&katakunci="+katakunci,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html('Berhasil Dicari. . .');
                                }else{
                                    $("#status").html('Pencarian gagal. . .');
                                }
                                 $("#id_nota").val("");
                                $("#id_pel").val("");
                                $("#total").val("");
                                $("#tgl").val("");
								$("#status_bayar").val("");
                                
                                $("#barang").load("proses_datacucian.php","op=barang");
                                $("#id_nota").load("proses_datacucian.php","op=id_nota");
                                
                            }
                        });
                    });
					
                    //totalika tombol simpan diklik
                    $("#simpan").click(function(){
                        id_nota=$("#id_nota2").val();
                        if(id_nota==""){
                            alert("id_nota Barang Harus diisi");
                            exit();
                        }
                        id_pel=$("#id_pel").val();
                        tgl=$("#tgl").val();
                        total=$("#total").val();
                        
                        
                        $("#status").html("sedang diproses. . .");
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_datacucian.php",
                            data:"op=simpan&id_nota="+id_nota+"&id_pel="+id_pel+"&tgl="+tgl+"&total="+total,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html("Berhasil disimpan. . .");
                                }else{
                                    $("#status").html("ERROR. . .");
                                }
                                $("#loading").hide();
                                $("#id_pel").val("");
                                $("#total").val("");
                                $("#tgl").val("");
                                
                                $("#id_nota2").val("");
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
						 <legend>Data Transaksi</legend>
						<input type="text" id="katakunci" placeholder="Cari" class="span2" >
						<button id="cari" class="btn">Cari</button>
                        <label>ID Pelanggan</label>
                        <select id="id_nota"></select>
                        <input type="text" id="tgl" placeholder="Tanggal" class="span2" readonly>
                         <input type="text" id="id_pel" placeholder="Pelanggan" class="span3" readonly>
                        <input type="text" id="total" placeholder="Total" class="span2" readonly>
                         <select id="status_cucian">
                            <option>  Pilih Status </option>
                            <option>  Proses </option>
                            <option> Selesai </option>
                            <option> Sudah Diambil</option>
                             </select>
                        <select id="status_bayar">
							<option>  Pilih Status </option>
							<option> Lunas </option>
							<option> Belum Lunas</option>
		  					 </select>
                        <button id="update" class="btn">Update</button>
                        <button id="hapus" class="btn">Hapus</button>
                    <div id="status"></div><br>
                    <div id="cari"></div><br>
                    <div id="barang"></div>';
                    break;
                case "tambah":
                        echo'<legend>Tambah Data Patotal</legend>
                        <label>ID Patotal</label>
                            <input type="text" id="id_nota2"> <span id="pesan"></span>
                        <label>Nama Patotal</label>
                            <input type="text" id="id_pel" >
                        <label>tgl</label>
                            <input type="text" id="tgl" >
                        <label>totalerangan</label>
                            <input type="text" id="total" >
                        <label></label>
                        <button id="simpan" class="btn">Simpan</button>
                        <a href="?page=barang" class="btn">Kembali</a>
                        <div id="status"></div>';
                    break;
            }
            ?>
        </body>
    </html>