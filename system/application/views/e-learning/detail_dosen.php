<div id="tengah">
<table width="100%" style="border: 1pt ridge #cccccc;" cellpadding="2" cellspacing="1" class="widget-small">
<?php echo form_open_multipart('admin/updatedosen');?>
<tr><td width="150">nama</td><td width="10">:</td><td><input type="text" name="nama" class="textfield" size="40" value="<?php echo $nama; ?>" required></td></tr>

<tr><td width="150">alamat</td><td width="10">:</td><td><input type="text" name="alamat" class="textfield" size="40" value="<?php echo $alamat; ?>" required></td></tr>

<tr><td width="150">tempat_lahir</td><td width="10">:</td><td><input type="text" name="tempat_lahir" class="textfield" size="40" value="<?php echo $tempat_lahir; ?>" required></td></tr>

<tr><td width="150">tgl_lahir</td><td width="10">:</td><td><input type="date" name="tgl_lahir" class="textfield" size="40" value="<?php echo $tgl_lahir; ?>" required></td></tr>

<tr><td width="150">pendidikan_terakhir</td><td width="10">:</td><td><input type="text" name="pend_terakhir" class="textfield" size="40" value="<?php echo $pend_terakhir; ?>" required></td></tr>


</form>
</table>
</div>