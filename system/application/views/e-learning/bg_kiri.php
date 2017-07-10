<div id="isi">
<div id="kiri">
<div id="sidebar">
<?php
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$status = $data["status"] = $pecah[3];
			if($status=="Mahasiswa"){
?>
<table style="border: 1pt ridge #DDDDDD;" bgcolor="#fff" class="widget" width="230">
<tr bgcolor="#eee"><td colspan="3"><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/login-icon.png" /> Selamat Datang</h2></td></tr>
<tr><td align="center" colspan="3">Hai, <b><?php echo $nama; ?></b></td></tr>
<tr><td width="5"></td><td><img src="<?php echo base_url(); ?>foto/<?php echo $pecah[0]; ?>.jpg" width="80" class="image"/><td width="175">
<a href="<? echo base_url(); ?>index.php/learning/passwordmhs" onclick="return popitup('<? echo base_url(); ?>index.php/learning/passwordmhs')"><div class="menu-user">Ganti Password</div></a>
<a href="<? echo base_url(); ?>index.php/learning/pesanadmin" onclick="return popitup('<? echo base_url(); ?>index.php/learning/pesanadmin')"><div class="menu-user">Kirim Pesan ke Admin</div></a>
<a href="<? echo base_url(); ?>index.php/learning/pesandosen" onclick="return popitup('<? echo base_url(); ?>index.php/learning/pesandosen')"><div class="menu-user">Kirim Pesan ke Dosen</div></a>
</td></tr>
<tr><td colspan="3" height="10"><a href="<? echo base_url(); ?>index.php/learning/inboxmhs" onclick="return popitup('<? echo base_url(); ?>index.php/learning/inboxmhs')"><div class="menu-user-bawah">Inbox Pesan</div></a>
	<a href="<? echo base_url(); ?>index.php/learning/uploadfoto" onclick="return popitup('<? echo base_url(); ?>index.php/learning/uploadfoto')"><div class="menu-user-bawah">Upload Foto</div></a>
<a href="<? echo base_url(); ?>index.php/learning/logout"><div class="menu-user-bawah">Keluar / Log Out</div></a>
</td></tr>
</table><br />
<?php
			}
			else if($status=="admin"){
?>
<table style="border: 1pt ridge #DDDDDD;" bgcolor="#fff" class="widget" width="230">
<tr bgcolor="#eee"><td colspan="3"><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/login-icon.png" /> Selamat Datang</h2></td></tr>
<tr><td align="center" colspan="3">Hai, <b><?php echo $nama; ?></b></td></tr>
<tr><td width="5"></td><td><img src="<?php echo base_url(); ?>foto/<?php echo $pecah[0]; ?>.jpg" width="80" class="image"/><td width="175">
<a href="<? echo base_url(); ?>index.php/admin"><div class="menu-user">Masuk ke Panel Admin</div></a>
<a href="<? echo base_url(); ?>index.php/learning/passwordmhs" onclick="return popitup('<? echo base_url(); ?>index.php/learning/passwordmhs')"><div class="menu-user">Ganti Password</div></a>
<a href="<? echo base_url(); ?>index.php/learning/logout"><div class="menu-user">Keluar / Log Out</div></a>
</td></tr>
<tr><td colspan="3" height="10">
	<a href="<? echo base_url(); ?>index.php/learning/uploadfoto" onclick="return popitup('<? echo base_url(); ?>index.php/learning/uploadfoto')"><div class="menu-user-bawah">Upload Foto</div></a></td></tr>
</table><br />
<?php
			}
			else if($status=="PA"){
?>
<table style="border: 1pt ridge #DDDDDD;" bgcolor="#fff" class="widget" width="230">
<tr bgcolor="#eee"><td colspan="3"><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/login-icon.png" /> Selamat Datang</h2></td></tr>
<tr><td align="center" colspan="3">Hai, <b><?php echo $nama; ?></b></td></tr>
<tr><td width="5"></td><td><img src="<?php echo base_url(); ?>foto/<?php echo $pecah[0]; ?>.jpg" width="80" class="image"/><td width="175">
<a href="<? echo base_url(); ?>index.php/dosen"><div class="menu-user">Masuk ke Panel Dosen</div></a>
<a href="<? echo base_url(); ?>index.php/learning/passwordmhs" onclick="return popitup('<? echo base_url(); ?>index.php/learning/passwordmhs')"><div class="menu-user">Ganti Password</div></a>
<a href="<? echo base_url(); ?>index.php/learning/logout"><div class="menu-user">Keluar / Log Out</div></a>
</td></tr>
<tr><td colspan="3" height="10">
	<a href="<? echo base_url(); ?>index.php/learning/uploadfoto" onclick="return popitup('<? echo base_url(); ?>index.php/learning/uploadfoto')"><div class="menu-user-bawah">Upload Foto</div></a></td></tr>
</table><br />
<?php
			}
		}
		else {
?>
<form method="post" action="<?php echo "".base_url()."index.php/learning/login" ?>">
<table style="border: 1pt ridge #DDDDDD;" bgcolor="#fff" class="widget" width="230">
<tr bgcolor="#eee"><td colspan="3"><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/login-icon.png" /> Login Pengguna</h2></td></tr>
<tr><td width="70">Username</td><td width="5">:</td><td width="130"><input name="usernameteks" type="text" class="textfield" size="16"/></td></tr>
<tr><td width="70">Password</td><td width="5">:</td><td width="130"><input name="passwordteks" type="password" class="textfield" size="16"/></td></tr>
<tr><td width="70"></td><td width="5"></td><td width="135"><input type="reset" value="Hapus" class="tombol"/> <input type="submit" value="Log In" class="tombol"/><br><br></td></tr>
</table>
</form>
<?php
}
?>
<table style="border: 1pt ridge #DDDDDD;" width="230" bgcolor="#fff" cellpadding="5" class="widget">
<tr bgcolor="#eee"><td><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/berita-top-icon.png" /> Berita Terpopuler</h2></td></tr>
<tr><td>
<ul>
<?php
foreach($berita_populer->result_array() as $pop)
{
echo "<li class='li-class'><a href=".base_url()."index.php/learning/detailberita/".$pop['id_berita'].">".$pop['judul_berita']." <b>[".$pop['counter']."]</b></a></li>";
}
?>
</ul>
</td></tr>
</table>
<br>
<table style="border: 1pt ridge #DDDDDD;" width="230" bgcolor="#fff" cellpadding="5" class="widget">
<tr bgcolor="#eee"><td colspan="3"><h2><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/agenda.png" /> Agenda Kampus</h2></td></tr>
<tr><td><ul>
<?php
foreach($agenda->result_array() as $agenda)
{
echo "<li class='li-class'><a href=".base_url()."index.php/learning/detailagenda/".$agenda['id_agenda']." onclick=\"return hs.htmlExpand(this, { objectType: 'iframe' } )\">".$agenda['tema_agenda']."</a></li>";
}
?>
</ul></td></tr>
<tr bgcolor="#eee"><td colspan="3"><img src="<?php echo base_url(); ?>system/application/views/e-learning/images/pict-index.png" class="image-index"/> <b><a href="<?php echo base_url(); ?>index.php/learning/agenda/">Lihat Semua Agenda</b></td></tr>
</table>
<br />
</div>
</div>
