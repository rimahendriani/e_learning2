<div id="kanan">
<a href="<?php echo base_url(); ?>index.php/forum"><div class="bg-menu">Beranda<br /><h3><i>Kembali ke menu utama</i></h3></div></a>
<a href="<?php echo base_url(); ?>index.php/kategori"><div class="bg-menu">Kategori Forum<br /><h3><i>Kategori Forum</i></h3></div></a>
<a href="<?php echo base_url(); ?>index.php/post_new"><div class="bg-menu">Post New<br /><h3><i>Postingan Baru</i></h3></div></a>
<a href="<?php echo base_url(); ?>index.php/learning"><div class="bg-menu">E-Learning<br /><h3><i>Kembali ke situs e-learning</i></h3></div></a>
<?php
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
?>
<a href="<?php echo base_url(); ?>index.php/learning/logout"><div class="bg-menu">Log Out<br /><h3><i>Keluar dari sistem</i></h3></div></a>
<?php
		} else{
?>
<span><h4>Form Login</h4></span>
<form method="post" action="<?php echo "".base_url()."index.php/learning/login" ?>">
<div class="bg-menu"><input type="text" class="textfield" size="20" name="usernameteks"/><br /><h3><i>Masukkan Username</i></h3></div>
<div class="bg-menu"><input type="password" class="textfield" size="20" name="passwordteks"/><br /><h3><i>Masukkan Password</i></h3></div>
<input type="submit" value="Login" class="tombol"/> <input type="reset" value="Hapus" class="tombol"/>
</form>
<?php
		}
?>
<div id="kanan-bawah"><img src="<?php echo base_url(); ?>system/application/views/tes/images/bg-kanan-bawah.png" /></div>
</div>
</div>