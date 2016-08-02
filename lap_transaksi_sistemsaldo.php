<?php
include "db/koneksi.php";
$pencarianSQL = "";
# PENCARIAN DATA 
if(isset($_POST['btnCari'])) {
  $txtKataKunci = trim($_POST['txtKataKunci']);

  // Menyusun sub query pencarian
  $pencarianSQL = "WHERE id_pel LIKE '%$txtKataKunci%'";
}

# Teks pada form
$dataKataKunci = isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris  = 25;
$hal  = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql= "SELECT * FROM data_transaksi_sistemsaldo $pencarianSQL";
$pageQry= mysql_query($pageSql) or die ("error paging: ".mysql_error());

//$r=mysql_fetch_array($total);

$jumlah = mysql_num_rows($pageQry);
$maks = ceil($jumlah/$baris);
$mulai  = $baris * ($hal-1); 

?>
<style type="text/css">

<!--
.style1 {
  font-family: Arial, Helvetica, sans-serif;
  font-weight: bold;
}
.style2 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<div class="box">
      <label><h2>Laporan Data Transaksi Sistem Saldo</h2></label>
<table width="917" border="0" cellspacing="1" cellpadding="3" class="table-border">
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" class="style2" id="form1">
      <table  class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="2" bgcolor="#F5F5F5"><strong>PENCARIAN</strong></td>
          </tr>
        <tr>
          <td width="30%"><strong>ID Pelanggan </strong> </td>
          <td width="70%"><input name="txtKataKunci" type="text" value="<?php echo $dataKataKunci; ?>" size="35" maxlength="100" />
            <input name="btnCari" type="submit" value=" Cari " /></td>
        </tr>
      </table>
                </form>    </td>
  </tr>

  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style2"></span></td>
  </tr>
  <tr>
    <td colspan="2">
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="table-list style2">
      <tr>
        <th width="3%" bgcolor="#F5F5F5">No </th>
        <th width="10%" bgcolor="#F5F5F5">Nota</th>
        <th width="15%" bgcolor="#F5F5F5">Nama</th>
        <th width="15%" bgcolor="#F5F5F5">Tanggal</th>
        <th width="16%" bgcolor="#F5F5F5">Debit</th>
        <th width="17%" bgcolor="#F5F5F5">Kredit</th>
         <th width="17%" bgcolor="#F5F5F5">Saldo</th>
        
        </tr>
    <?php
  $mySql = "SELECT * FROM data_transaksi_sistemsaldo $pencarianSQL ORDER BY id_nota ASC LIMIT $mulai, $baris";
  $myQry = mysql_query($mySql)  or die ("Query salah : ".mysql_error()); 
  $nomor = $mulai; 
  $count=1;
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['id_nota'];
  ?>    
      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['id_nota']; ?> </td>
        <td><?php echo $myData['id_pel']; ?></td>
        <td><?php echo $myData['tgl']; ?></td>
       <?php 
         if($count==1){
    /* pertama kali deklarasi Debit */
                echo"<td>Rp. ".$myData['debit']."</td>";
                echo"<td>Rp. ".$myData['kredit']."</td>"; 
        $kredit=$myData['kredit'];
        $debit=$myData['debit'];
        $saldo=$myData['debit'];
                 echo"<td>Rp. ".($saldo);  
        }else{   
           if($myData['debit']!=0){   
     /* Jika debit tidak sama dengan 0 */
           echo"<td>Rp. ".($myData['debit'])."</td>";
           echo"<td>Rp. ".($myData['kredit'])."</td>";
           $debit=$debit+$myData['debit'];
          $saldo=$saldo+$myData['debit']."</td>";
          echo"<td>Rp. ".($saldo);    
           }else{
    /* Jika debit sama dengan 0 */
          echo"<td>Rp. ".($myData['debit'])."</td>";
          echo"<td>Rp. ".($myData['kredit'])."</td>";
          $kredit=$kredit+$myData['kredit'];
          $saldo=$saldo-$myData['kredit']."</td>";
          echo"<td>Rp. ".($saldo);    
          }
        }
         echo"</tr>";
         echo"<tr>";
         $count++;
  ?>
     

      </tr>
    <?php } echo"<tr>";
  echo"<th colspan='2'>Jumlah</th>";
  echo"<th colspan='2'></th>";
  echo"<th>Rp. ".($debit)."</th>";
  echo"<th>Rp. ".($kredit)."</th>";
  echo"<th>Rp. ".($saldo)."</th>";
 echo"</tr>";
echo"</table>";?>
    </table></td>
  </tr>
  <tr bgcolor="#00CC00">
    <td width="495"><b>Jumlah Data :<?php echo $jumlah; ?></b></td>
   
    <td width="407" align="right"><b>Halaman ke :</b>
      <?php
  for ($h = 1; $h <= $maks; $h++) {
    echo " <a href='?page=lap_transaksi_sistemsaldo&hal=$h'>$h</a> ";
  }
  ?></td>
  </tr>
</table>
 
 </div>
</div>
