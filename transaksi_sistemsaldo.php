<!DOCTYPE html>
    <html>
        <head>
            <title>Transaki Laundri</title>
            <link rel="stylesheet" href="css/bootstrap.css">
            <script src="js/jquery.js"></script>
            <script src="js/jquery.ui.datepicker.js"></script>
            <script>
                //mendeksripsikan variabel yang akan digunakan
                var id_cucian;
                var tgl;
				var id_pel;
                var id_paket;
                var nm_paket;
                var harga;
                var banyak;
				var subtotal;
				var kredit;
                var alamat;
                var no_hp;
                //var stok;
                $(function(){
                    //meload file proses_transaksi_sistemsaldo dengan operator ambil barang dimana nantinya
                    //isinya akan masuk di combo box
                    $("#id_paket").load("proses_transaksi_sistemsaldo.php","op=ambilbarang");
                     $("#id_pel").load("proses_transaksi_sistemsaldo.php","op=ambilpelanggan")
                    //meload isi tabel
                    $("#barang").load("proses_transaksi_sistemsaldo.php","op=barang");
                    
                    //mengkosongkan input text dengan masing2 id berikut
                    $("#nm_paket").val("");
                    $("#harga").val("");
                    $("#banyak").val("");
					$("#id_pel").val("");
                    $("#alamat").val("");
                    $("#no_hp").val("");
                   
                   // $("#stok").val("");
                                
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
                              //  $("#stok").val(data[3]);
                                $("#banyak").focus();
								$("#id_pel").focus();
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });
                       
                    });
                     $("#id_pel").change(function(){
                        id_pel=$("#id_pel").val();
                        
                        //tampilkan status loading dan animasinya
                        $("#status").html("loading. . .");
                        $("#loading").show();
                        
                        //lakukan pengiriman data
                        $.ajax({
                            url:"proses.php",
                            data:"op=ambildatapelanggan&id_pel="+id_pel,
                            cache:false,
                            success:function(msg){
                                data=msg.split("|");
                                
                                //masukan isi data ke masing - masing field
                                $("#alamat").val(data[0]);
                                $("#no_hp").val(data[1]);
                             
                                //hilangkan status animasi dan loading
                                $("#status").html("");
                                $("#loading").hide();
                            }
                        });
                     });
                    //jika tombol tambah di klik
                    $("#tambah").click(function(){
                        id_paket=$("#id_paket").val();
                        if(id_paket==""){
                            alert("Paket Harus diisi");
                            exit();
                        }   
						nm_paket=$("#nm_paket").val();
						// stok=$("#stok").val();
                        banyak=$("#banyak").val();
                       /* if(id_paket=="id_paket Barang"){
                            alert("id_paket Barang Harus diisi");
                            exit();
                        }else if(banyak > stok){
                            alert("Stok tidak terpenuhi");
                            $("#banyak").focus();
                            exit();
                        }else if(banyak < 1){
                            alert("banyak beli tidak boleh 0");
                            $("#banyak").focus();
                            exit();
                        }*/
                     
                        harga=$("#harga").val();
                        
                                                
                        $("#status").html("sedang diproses. . .");
                        $("#loading").show();
                        
                        $.ajax({
                            url:"proses_transaksi_sistemsaldo.php",
                            data:"op=tambah&id_paket="+id_paket+"&nm_paket="+nm_paket+"&harga="+harga+"&banyak="+banyak,
                            cache:false,
                            success:function(msg){
                                if(msg=="sukses"){
                                    $("#status").html("Berhasil disimpan. . .");
                                }else{
                                    $("#status").html("ERROR. . .");
                                }
                                $("#loading").hide();
                                $("#nm_paket").val("");
                                $("#harga").val("");
                                $("#banyak").val("");
                                
                                $("#id_paket").load("proses_transaksi_sistemsaldo.php","op=ambilbarang");
                                $("#barang").load("proses_transaksi_sistemsaldo.php","op=barang");
                            }
                        });
                    });
                    
					    
                    //jika tombol proses diklik
                    $("#proses").click(function(){
					    id_pel=$("#id_pel").val();
                         if(id_pel==""){
                            alert("id pelanggan Harus diisi");
                            exit();
                        }
                        nota=$("#nota").val();
                        tgl=$("#tgl").val();
						kredit=$("#kredit").val();
                        debit=$("#debit").val();
                        sisa_saldo=$("#sisa_saldo").val();
                        
                        $.ajax({
                            url:"proses_transaksi_sistemsaldo.php",
                            data:"op=proses&nota="+nota+"&tgl="+tgl+"&id_pel="+id_pel+"&id_paket="+id_paket+"&nm_paket="+nm_paket+"&harga="+harga+"&banyak="+banyak+"&total_bayar="+subtotal+"&kredit="+kredit+"&debit="+debit+"&sisa_saldo="+sisa_saldo,
                            cache:false,
                            success:function(msg){
                                if(msg=='sukses'){
                                    $("#status").html('Transaksi Pembelian berhasil');
                                    alert('Transaksi Berhasil');
                                    exit();
                                }else{
                                    $("#status").html('Transaksi Gagal');
                                    alert('Transaksi Gagal');
                                    exit();
                                }
								$("#id_pel").val("");
                                $("#id_paket").load("proses_transaksi_sistemsaldo.php","op=ambilbarang");
                                $("#barang").load("proses_transaksi_sistemsaldo.php","op=barang");
                                $("#loading").hide();
                                $("#nm_paket").val("");
                                $("#harga").val("");
                                $("#banyak").val("");
								$("#subtotal").val("");
								$("#kredit").val("");
								$("#debit").val("");
                                $("#sisa_saldo").val("");
                               // $("#stok").val("");
                            }
                        })
                    })
                });
            </script>
        </head>
        <body>
            <div class="container">
                <?php
                include "db/koneksi.php";
                $p=isset($_GET['act'])?$_GET['act']:null;
                switch($p){
                    default:
                     $tgl=date('Y-m-d');
                        //untuk autonumber di nota
                        $auto=mysql_query("select * from data_transaksi_sistemsaldo order by id_nota desc limit 1");
                        $no=mysql_fetch_array($auto);
                        $angka=$no['id_nota']+1;
                     
                        echo "<div class='navbar-form pull-right'>
                                No. Nota : <input type='text' id='nota' value='$angka' readonly >
                                <input type='text' id='tgl' value='$tgl' readonly>   
                            </div>";
                            
                            echo'<legend>Nota Transaksi Sistem Saldo</legend>
                            <label>ID Pelanggan</label>
							<select id="id_pel"><span id="pesan"></span></select>
                            <input type="text" id="alamat" placeholder="Alamat" readonly>
                            <input type="text" id="no_hp" placeholder="no Hp" class="span2" readonly>
                            <Td colspan="5"><a href="?page=pelanggan&act=tambah" class="btn btn-primary">Pelanggan Baru?</a></td>

                            <label>ID Paket</label>
                            <select id="id_paket"></select>
                            <input type="text" id="nm_paket" placeholder="Nama Paket" readonly>
                            <input type="text" id="harga" placeholder="Harga" class="span2" readonly>
                          
                            <input type="text" id="banyak" placeholder="Banyak (kg/pcs) " class="span2">
                            <button id="tambah" class="btn">Tambah</button>
                            
                            <span id="status"></span>
                            <table id="barang" class="table table-bordered">
                                    
                            </table>
							<label>Tambah saldo:  
							 <input type="text" id="debit" placeholder="Masukan Saldo" >
							</label>
                            <div class="form-actions">
                                <button id="proses">Proses</button>
								
                            </div>';
                        break;
             
					case "hapus":
						$nota=$_GET['nota'];
                        $del=mysql_query("delete from data_transaksi_sistemsaldo where id_nota='$nota'");
                      	 if($del){
      					  echo "<script>window.location='index.php?page=penjualan';</script>";
    					}else{
     					   echo "<script>alert('Hapus Data Berhasil');
        				    window.location='index.php?page=penjualan';</script>";
  						  }
						break;
						
					case "update":
						$nota=$_GET['nota'];
						$kredit=$_GET['kredit'];
                        $status_cucian=$_GET['status_cucian'];
                        
                       $update=mysql_query("update data_transaksi_sistemsaldo set 
					   	status_cucian='$status_cucian',
						kredit='$kredit'
                        where id_nota='$nota'");
                      
						break;
						
                    case "detail":
                        echo "<legend>Nota Cucian Laundry</legend>";
                        $nota=$_GET['nota'];
                        $query=mysql_query("select data_transaksi_sistemsaldo.id_nota,data_detailtransaksi.id_paket,data_paket.nm_paket,
                                           data_detailtransaksi.harga,data_detailtransaksi.banyak,data_detailtransaksi.subtotal,data_paket.ket
                                           from 
										   data_detailtransaksi,data_transaksi_sistemsaldo,data_paket
                                           where 
										   data_transaksi_sistemsaldo.id_nota=data_detailtransaksi.id_nota and data_paket.id_paket=data_detailtransaksi.id_paket
                                           and data_detailtransaksi.id_nota='$nota'");
                        $nomor=mysql_fetch_array(mysql_query("select * from data_transaksi_sistemsaldo where id_nota='$nota'"));
                        echo "<div class='navbar-form pull-right'>
                                Nota : <input type='text' value='$nomor[id_nota]' disabled>
                                <input type='text' value='$nomor[tgl]' disabled>
								 Nama :  <input type='text' value='$nomor[id_pel]' disabled>
								 
                            </div>";
                        echo "<table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <td>ID Paket</td>
                                        <td>Nama</td>
                                        <td>Harga</td>
                                        <td>banyak</td>
                                        <td>Subtotal</td>
										<td>Keterangan</td>
                                    </tr>
                                </thead>";
                                while($r=mysql_fetch_row($query)){
                                    echo "<tr>
                                            <td>$r[1]</td>
                                            <td>$r[2]</td>
                                            <td>$r[3]</td>
                                            <td>$r[4]</td>
                                            <td>$r[5]</td>
											<td>$r[6]</td>
                                        </tr>";
                                }
                                echo "<tr>
								<td><a href='?page=datacucian' class='btn btn-primary'>Kembali</a>
								</td>
								<td> Status Bayar :  <input type='text' value='$nomor[kredit]' disabled></td>		
                                        <td colspan='4'><h4 align='right'>Total</h4></td>
                                        <td colspan='5'><h4>$nomor[total]</h4></td>
								
                                    </tr>
                                    </table>";
                        break;
                }
                ?>
            </div>
        </body>
    </html>