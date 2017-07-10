<div id="bg-isi"><h2>Module Mahasiswa - E-Learning</h2><br />
<table width="870" style="border: 1pt ridge #cccccc;" cellpadding="2" cellspacing="1" class="widget-small">
<?php echo form_open_multipart('admin/updatemahasiswa');?>
<tr><td width="150">username</td><td width="10">:</td><td><input type="text" name="username" class="textfield" size="80" value="<?php echo $username; ?>" readonly required></td></tr>
<tr><td width="150">psw</td><td width="10">:</td><td><input type="password" name="psw" class="textfield" size="80"></td></tr>
<tr><td width="150">nama</td><td width="10">:</td><td><input type="text" name="nama" class="textfield" size="80" value="<?php echo $nama; ?>" required></td></tr>

<tr><td width="150">alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="textfield" size="80" value="<?php echo $alamat; ?>" required></td></tr>

<tr><td width="150">tempat_lahir</td><td width="10">:</td><td><input type="text" name="tempat_lahir" class="textfield" size="80" value="<?php echo $tempat_lahir; ?>" required></td></tr>

<tr><td width="150">tgl_lahir</td><td width="10">:</td><td><input type="date" name="tgl_lahir" class="textfield" size="80" value="<?php echo $tgl_lahir; ?>" required></td></tr>

<tr><td width="150">angkatan</td><td width="10">:</td><td><input type="text" name="angkatan" class="textfield" size="80" value="<?php echo $angkatan; ?>" required></td></tr>

<tr><td width="150">jurusan</td><td width="10">:</td><td><input type="text" name="jurusan" class="textfield" size="80" value="<?php echo $jurusan; ?>" required></td></tr>

<input type="hidden" name="id_link" value="<?php echo $id_link; ?>">

<tr><td width="150" valign="top"></td><td width="10" valign="top"></td><td><input type="submit" value="Simpan" class="tombol"></td></tr>
</form>
</table><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>