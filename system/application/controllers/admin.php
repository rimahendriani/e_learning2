<?php

class Admin extends Controller {

	function Admin()
	{
		parent::Controller();
		$this->load->helper(array('form','url', 'text_helper','date','file'));
		$this->load->database();
		$this->load->plugin();
		$this->load->model('Admin_model');
		session_start();
	}
	
	function index()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/isi_index',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function berita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->Admin_model->Tampil_Berita($limit_ti,$offset_ti);
			$tot_hal = $this->Admin_model->Total_Berita();
      		$config['base_url'] = base_url() . '/index.php/admin/berita';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/berita',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$page=$this->uri->segment(3);
			$this->load->model('Admin_model');
			$data['det']=$this->Admin_model->Edit_Berita($id);
			$data['kategori']=$this->Admin_model->Kat_Berita();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_berita',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updateberita()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$config['upload_path'] = './system/application/views/e-learning/berita/';
			$config['allowed_types'] ='bmp|gif|jpg|jpeg|png';
			$config['max_size'] = '10000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';						
			$this->load->library('upload', $config);
		
			if(empty($_FILES['userfile']['name'])){
				$in["judul_berita"]=$this->input->post('judul');
				$in["isi"]=$this->input->post('isi_tutorial');
				$in["id_berita"]=$this->input->post('id_tutorial');
				$in["id_kategori"]=$this->input->post('kategori');
				$this->Admin_model->Update_Berita($in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/berita'>";
				
			}
			else{
				if(!$this->upload->do_upload())
				{
			 	echo $this->upload->display_errors();
				}
				else {
				$in2["judul_berita"]=$this->input->post('judul');
				$in2["isi"]=$this->input->post('isi_tutorial');
				$in2["id_berita"]=$this->input->post('id_tutorial');
				$in2["gambar"]=$_FILES['userfile']['name'];
				$in2["id_kategori"]=$this->input->post('kategori');
				$this->Admin_model->Update_Berita($in2);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/berita'>";
				}
			}

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$data['kategori']=$this->Admin_model->Kat_Berita();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_berita',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpanberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$jam = "%h:%i:%a";
			$time = time();
			$in=array();
			if(empty($_FILES['userfile']['name'])){
			$in['judul_berita']=$this->input->post('judul');
			$in['id_kategori']=$this->input->post('kategori');
			$in['isi']=$this->input->post('isi');
			$in['gambar']="gbr-news.jpg";
			$in["tanggal"] = mdate($tgl,$time);
			$in["waktu"] = mdate($jam,$time);
			$in["counter"] = 0;
			$this->Admin_model->Simpan_Berita($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/berita'>";
			}
			else{
			$in['judul_berita']=$this->input->post('judul');
			$in['id_kategori']=$this->input->post('kategori');
			$in['isi']=$this->input->post('isi');
			$in['gambar']=$_FILES['userfile']['name'];
			$in["tanggal"] = mdate($tgl,$time);
			$in["waktu"] = mdate($jam,$time);
			$in["counter"] = 0;
			
			$config['upload_path'] = './system/application/views/e-learning/berita/';
			$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
			$config['max_size'] = '10000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';						
			$this->load->library('upload', $config);
		
			if(!$this->upload->do_upload())
			{
			 echo $this->upload->display_errors();
			}
			else {
			$this->Admin_model->Simpan_Berita($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/berita'>";
			}
			}
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapusberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$this->Admin_model->Hapus_Berita($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/berita'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function katberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$data['kategori']=$this->Admin_model->Kat_Berita();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/kat_berita',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahkatberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_kat_berita',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpankatberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['nama_kategori']=$this->input->post('nama');
			$this->Admin_model->Simpan_Kat_Berita($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katberita'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editkatberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$data['det']=$this->Admin_model->Edit_Kat_Berita($id);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_kat_berita',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatekatberita()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['id_kategori']=$this->input->post('id_kat');
			$in['nama_kategori']=$this->input->post('nama');
			$this->Admin_model->Update_Kat_Berita($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katberita'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapuskatberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$this->Admin_model->Hapus_Kat_Berita($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katberita'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function komenberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->Admin_model->Komen_Berita($limit_ti,$offset_ti);
			$tot_hal = $this->Admin_model->Total_Komen_Berita();
      		$config['base_url'] = base_url() . '/index.php/admin/komenberita';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/komen_berita',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapuskomenberita()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$this->Admin_model->Hapus_Komen_Berita($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/komenberita'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function pengumuman()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->Admin_model->Tampil_Pengumuman($limit_ti,$offset_ti);
			$tot_hal = $this->Admin_model->Total_Pengumuman();
      		$config['base_url'] = base_url() . '/index.php/admin/pengumuman';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/pengumuman',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahpengumuman()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';

		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_pengumuman');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpanpengumuman()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$time = time();
			$in["tanggal"] = mdate($tgl,$time);
			$in["judul_pengumuman"]=$this->input->post('judul');
			$in["isi"]=$this->input->post('isi');
			$in["penulis"]=$nim;
			$this->Admin_model->Simpan_Pengumuman($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/pengumuman'>";

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editpengumuman()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$this->load->model('Admin_model');
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($data["status"]=="admin"){
			$data["det"]=$this->Admin_model->Edit_Pengumuman($id,$data["nim"]);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_pengumuman',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatepengumuman()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
				$in["judul_pengumuman"]=$this->input->post('judul');
				$in["isi"]=$this->input->post('isi');
				$in["id_pengumuman"]=$this->input->post('id_pengumuman');
				$in["penulis"]=$nim;
				$this->load->model('Admin_model');
				$this->Admin_model->Update_Pengumuman($in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/pengumuman'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapuspengumuman()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->load->model('Admin_model');
			$this->Admin_model->Delete_Pengumuman($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/pengumuman'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function agenda()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->Admin_model->Tampil_Agenda($limit_ti,$offset_ti);
			$tot_hal = $this->Admin_model->Total_Agenda();
      		$config['base_url'] = base_url() . '/index.php/admin/agenda';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/agenda',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahagenda()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$tgl = "%d-%m-%Y";
		$time = time();
		$data["wkt_skr"] = mdate($tgl,$time);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_agenda',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpanagenda()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$time = time();
			$in["tgl_posting"] = mdate($tgl,$time);
			$in["tema_agenda"]=$this->input->post('judul');
			$in["isi"]=strip_tags($this->input->post('isi'));
			$t_mulai=$this->input->post('tgl_mulai');
			$b_mulai=$this->input->post('bln_mulai');
			$y_mulai=$this->input->post('thn_mulai');
			$in["tgl_mulai"]="".$y_mulai."-".$b_mulai."-".$t_mulai."";
			$t_selesai=$this->input->post('tgl_selesai');
			$b_selesai=$this->input->post('bln_selesai');
			$y_selesai=$this->input->post('thn_selesai');
			$in["tgl_selesai"]="".$y_selesai."-".$b_selesai."-".$t_selesai."";
			$in["tempat"]=$this->input->post('tempat');
			$in["jam"]=$this->input->post('jam');
			$in["keterangan"]=strip_tags($this->input->post('keterangan'));
			$this->Admin_model->Simpan_Agenda($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/agenda'>";

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editagenda()
	{
		$data=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$id='';		
			if ($this->uri->segment(3) === FALSE)
			{
    			$id='';
			}
			else
			{
    			$id = $this->uri->segment(3);
			}
			$tgl = "%d-%m-%Y";
			$time = time();
			$data["wkt_skr"] = mdate($tgl,$time);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->model('Admin_model');
			$data["ed"]=$this->Admin_model->Edit_Agenda($id);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_agenda',$data);
			$this->load->view('admin/bg_bawah');

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updateagenda()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$in["id_agenda"]=$this->input->post('id_agenda');
			$in["tema_agenda"]=$this->input->post('judul');
			$in["isi"]=strip_tags($this->input->post('isi'));
			$t_mulai=$this->input->post('tgl_mulai');
			$b_mulai=$this->input->post('bln_mulai');
			$y_mulai=$this->input->post('thn_mulai');
			$in["tgl_mulai"]="".$y_mulai."-".$b_mulai."-".$t_mulai."";
			$t_selesai=$this->input->post('tgl_selesai');
			$b_selesai=$this->input->post('bln_selesai');
			$y_selesai=$this->input->post('thn_selesai');
			$in["tgl_selesai"]="".$y_selesai."-".$b_selesai."-".$t_selesai."";
			$in["tempat"]=$this->input->post('tempat');
			$in["jam"]=$this->input->post('jam');
			$in["keterangan"]=strip_tags($this->input->post('keterangan'));
			$this->Admin_model->Update_Agenda($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/agenda'>";

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function hapusagenda()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->load->model('Admin_model');
			$this->Admin_model->Delete_Agenda($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/agenda'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function upload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->Admin_model->Tampil_File($limit_ti,$offset_ti);
			$tot_hal = $this->Admin_model->Total_File();
      		$config['base_url'] = base_url() . '/index.php/admin/upload';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/upload',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahupload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$data["kat"]=$this->Admin_model->Kat_Down();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_upload',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpanupload()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$jam = "%h:%i:%a";
			$time = time();
			$in["tgl_posting"] = mdate($tgl,$time);
			$in["judul_file"]=$this->input->post('judul');
			$in["author"]=$nim;
			$in["id_kat"]=$this->input->post('kategori');
			$acak=rand(00000000000,99999999999);
			$bersih=$_FILES['userfile']['name'];
			$nm=str_replace(" ","_","$bersih");
			$pisah=explode(".",$nm);
			$nama_murni=$pisah[0];
			$ubah=$acak.$nama_murni; //tanpa ekstensi
			$config["file_name"]=$ubah; //dengan eekstensi
			$in["nama_file"]=$acak.$nm;
			$config['upload_path'] = './system/application/views/e-learning/download/';
			$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|mid|midi|mp2|mp3|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
			$config['max_size'] = '50000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';						
			$this->load->library('upload', $config);
		
			if(!$this->upload->do_upload())
			{
			 echo $this->upload->display_errors();
			}
			else {
			$this->Admin_model->Simpan_Upload($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/upload'>";
			}

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editupload()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$data["kategori"]=$this->Admin_model->Edit_Upload($id);
			$data["cur_kat"]=$this->Admin_model->Kat_Down();
			$data["tanggal"] = mdate($datestring, $time);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_upload',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updateupload()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$config['upload_path'] = './system/application/views/e-learning/download/';
			$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|mid|midi|mp2|mp3|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
			$config['max_size'] = '10000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['userfile']['name'];
				$nm=str_replace(" ","_","$bersih");
				$pisah=explode(".",$nm);
				$nama_murni=$pisah[0];
				$ubah=$acak.$nama_murni; //tanpa ekstensi
				$config["file_name"]=$ubah; //dengan eekstensi
				$in2["nama_file"]=$acak.$nm;			
			$this->load->library('upload', $config);
		
			if(empty($_FILES['userfile']['name'])){
				$in["judul_file"]=$this->input->post('judul');
				$in["id_download"]=$this->input->post('id_download');
				$in["id_kat"]=$this->input->post('kategori');
				$this->Admin_model->Update_Upload($in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/upload'>";
				
			}
			else{
				if(!$this->upload->do_upload())
				{
			 	echo $this->upload->display_errors();
				}
				else {
				$in2["judul_file"]=$this->input->post('judul');
				$in2["id_download"]=$this->input->post('id_download');
				$in2["id_kat"]=$this->input->post('kategori');

				$this->Admin_model->Update_Upload($in2);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/upload'>";
				}
			}

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapusupload()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->load->model('Admin_model');
			$hapus=$this->Admin_model->Edit_Upload($id);
			foreach($hapus->result() as $t)
			{
				unlink("./system/application/views/e-learning/download/$t->nama_file");
			}
			$this->Admin_model->Delete_Upload($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/upload'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Dosen...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function katdownload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$data['kategori']=$this->Admin_model->Kat_Down();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/kat_download',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahkatdownload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_kat_download',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpankatdownload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['nama_kategori_download']=$this->input->post('nama');
			$this->Admin_model->Simpan_Kat_Download($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katdownload'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editkatdownload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$data['det']=$this->Admin_model->Edit_Kat_Download($id);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_kat_download',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatekatdownload()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['id_kategori_download']=$this->input->post('id_kat');
			$in['nama_kategori_download']=$this->input->post('nama');
			$this->Admin_model->Update_Kat_Download($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katdownload'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapuskatdownload()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$this->Admin_model->Hapus_Kat_Download($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/katdownload'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tutorial()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
			if($data["status"]=="admin"){
		$data["tanggal"] = mdate($datestring, $time);
		$this->load->model('Admin_model');
		$this->load->library('Pagination');	
		$page=$this->uri->segment(3);
      		$limit_ti=15;
		if(!$page):
		$offset_ti = 0;
		else:
		$offset_ti = $page;
		endif;
		$query=$this->Admin_model->Tampil_Tutorial($limit_ti,$offset_ti);
		$tot_hal = $this->Admin_model->Total_Tutorial();
      		$config['base_url'] = base_url() . '/index.php/admin/tutorial';
       		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit_ti;
		$config['uri_segment'] = 3;
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';
		$this->pagination->initialize($config);
		$paginator=$this->pagination->create_links();
	   	$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tutorial',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
					else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Dosen...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahtutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$data['kategori']=$this->Admin_model->Kat_Tutorial();
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_tutorial',$data);
			$this->load->view('admin/bg_bawah');

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpantutorial()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$jam = "%h:%i:%a";
			$time = time();
			if(empty($_FILES['userfile']['name'])){
			$in["tanggal"] = mdate($tgl,$time);
			$in["waktu"] = mdate($jam,$time);
			$in["judul_tutorial"]=$this->input->post('judul');
			$in["isi"]=$this->input->post('isi');
			$in["author"]=$nim;
			$in["id_kategori_tutorial"]=$this->input->post('kategori');
			$in["counter"]=0;
			$in["gambar"]="gbr-tutor.jpg";
			$this->Admin_model->Simpan_Tutorial($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tutorial'>";
			}
			else{
			$in["tanggal"] = mdate($tgl,$time);
			$in["waktu"] = mdate($jam,$time);
			$in["judul_tutorial"]=$this->input->post('judul');
			$in["isi"]=$this->input->post('isi');
			$in["author"]=$nim;
			$in["id_kategori_tutorial"]=$this->input->post('kategori');
			$in["counter"]=0;
			$in["gambar"]=$_FILES['userfile']['name'];
			$config['upload_path'] = './system/application/views/e-learning/tutorial/';
			$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
			$config['max_size'] = '10000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';						
			$this->load->library('upload', $config);
		
			if(!$this->upload->do_upload())
			{
			 echo $this->upload->display_errors();
			}
			else {
			$this->Admin_model->Simpan_Tutorial($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tutorial'>";
			}
			}

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function edittutorial()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$data["kategori"]=$this->Admin_model->Edit_Tutorial($id);
			$data["cur_kat"]=$this->Admin_model->Kat_Tutorial();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_tutorial',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatetutorial()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$config['upload_path'] = './system/application/views/e-learning/tutorial/';
			$config['allowed_types'] = 'exe|sql|psd|pdf|xls|ppt|php|php4|php3|js|swf|Xhtml|zip|mid|midi|mp2|mp3|wav|bmp|gif|jpg|jpeg|png|html|htm|txt|rtf|mpeg|mpg|avi|doc|docx|xlsx';
			$config['max_size'] = '10000';
			$config['max_width'] = '400';
			$config['max_height'] = '300';						
			$this->load->library('upload', $config);
		
			if(empty($_FILES['userfile']['name'])){
				$in["judul_tutorial"]=$this->input->post('judul');
				$in["isi"]=$this->input->post('isi_tutorial');
				$in["id_tutorial"]=$this->input->post('id_tutorial');
				$in["author"]=$nim;
				$in["id_kategori_tutorial"]=$this->input->post('kategori');
				$this->Admin_model->Update_Tutorial($in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tutorial'>";
				
			}
			else{
				if(!$this->upload->do_upload())
				{
			 	echo $this->upload->display_errors();
				}
				else {
				$in2["judul_tutorial"]=$this->input->post('judul');
				$in2["isi"]=$this->input->post('isi_tutorial');
				$in2["id_tutorial"]=$this->input->post('id_tutorial');
				$in2["author"]=$nim;
				$in2["gambar"]=$_FILES['userfile']['name'];
				$in2["id_kategori_tutorial"]=$this->input->post('kategori');
				$this->Admin_model->Update_Tutorial($in2);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tutorial'>";
				}
			}

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapustutorial()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->load->model('Admin_model');
			$this->Admin_model->Delete_Tutorial($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tutorial'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function inbox()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
			if($data["status"]=="admin"){
		$data["tanggal"] = mdate($datestring, $time);
		$this->load->model('Admin_model');
		$this->load->library('Pagination');	
		$page=$this->uri->segment(3);
      		$limit_ti=15;
		if(!$page):
		$offset_ti = 0;
		else:
		$offset_ti = $page;
		endif;
		$query=$this->Admin_model->Tampil_Inbox($data["nim"],$limit_ti,$offset_ti);
		$tot_hal = $this->Admin_model->Total_Inbox($data["nim"]);
      		$config['base_url'] = base_url() . '/index.php/admin/inbox';
       		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit_ti;
		$config['uri_segment'] = 3;
		$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';
		$this->pagination->initialize($config);
		$paginator=$this->pagination->create_links();
	   	$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/inbox',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
					else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function detailinbox()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$data["tanggal"] = mdate($datestring, $time);
			$this->load->model('Admin_model');
			$data["detail"]=$this->Admin_model->Detail_Inbox($data["nim"],$id);
			$this->Admin_model->Update_Pesan($id);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/detail_inbox',$data);
			$this->load->view('admin/bg_bawah');
			}
					else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function balasinbox()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$datestring = "%d-%m-%Y | %h:%i:%a";
		$time = time();
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
				$in["username"]=$this->input->post('username');
				$in["tujuan"]=$this->input->post('tujuan');
				$in["subjek"]=$this->input->post('subjek');
				$in["pesan"]=$this->input->post('pesan');
				$in["waktu"]=mdate($datestring,$time);
				$in["status_pesan"]="N";
				$id=$this->input->post('id_inbox');
				$this->load->model('Admin_model');
				$this->Admin_model->Balas_Pesan($in);
				$this->Admin_model->Update_Pesan_Lama($in["pesan"],$id);
				?>
				<script type="text/javascript" language="javascript">
				alert("Pesan anda sudah terkirim.");
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/inbox'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapusinbox()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->load->model('Admin_model');
			$this->Admin_model->Delete_Pesan($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/inbox'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function kattutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		$page=$this->uri->segment(3);
      		$limit_ti=15;
		if(!$page):
		$offset_ti = 0;
		else:
		$offset_ti = $page;
		endif;
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$data['kategori']=$this->Admin_model->Tampil_Kat_Tutorial($limit_ti,$offset_ti);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/kat_tutorial',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>

			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahkattutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_kat_tutorial',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpankattutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['nama_kategori']=$this->input->post('nama');
			$this->Admin_model->Simpan_Kat_Tutorial($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/kattutorial'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editkattutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$data['det']=$this->Admin_model->Edit_Kat_Tutorial($id);
	   		$data['scriptmce'] = $this->scripttiny_mce();
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_kat_tutorial',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatekattutorial()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$in=array();
			$in['id_kategori_tutorial']=$this->input->post('id_kat');
			$in['nama_kategori']=$this->input->post('nama');
			$this->Admin_model->Update_Kat_Tutorial($in);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/kattutorial'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapuskattutorial()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$data = array();
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			$this->load->model('Admin_model');
			$this->Admin_model->Hapus_Kat_Tutorial($id);
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/kattutorial'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}



	function mhs()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->db->get_where("tbllogin",array("status"=>"Mahasiswa"),$limit_ti,$offset_ti);
			$tot_hal = $this->db->get_where("tbllogin",array("status"=>"Mahasiswa"));
      		$config['base_url'] = base_url() . '/index.php/admin/mhs';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/mhs',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahmahasiswa()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';

		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_mahasiswa');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpanmahasiswa()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$time = time();

			$this->db->set('username', $this->input->post('username', TRUE));
			$this->db->set('psw', 'PASSWORD("'.$this->input->post('psw', TRUE).'")', FALSE);
			$this->db->set('nama', $this->input->post('nama', TRUE));
			$this->db->set('status', "Mahasiswa");
			$this->db->set('idlink', $this->input->post('username', TRUE));

			$this->db->insert("tbllogin");
			
			$data['id_mahasiswa'] = $_POST['username'];
			$data['alamat'] = $_POST['alamat'];
			$data['angkatan'] = $_POST['angkatan'];
			$data['tempat_lahir'] = $_POST['tempat_lahir'];
			$data['tgl_lahir'] = $_POST['tgl_lahir'];
			$data['jurusan'] = $_POST['jurusan'];

			$this->db->insert("tblmahasiswa",$data);

			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/mhs'>";

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editmahasiswa()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$this->load->model('Admin_model');
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($data["status"]=="admin"){
			$det1=$this->db->get_where("tbllogin",array("username"=>$id))->row();
			$data['nama'] = $det1->nama;
			$data['username'] = $det1->username;

			$det=$this->db->get_where("tblmahasiswa",array("id_mahasiswa"=>$det1->username))->row();

			if($this->db->get_where("tblmahasiswa",array("id_mahasiswa"=>$det1->username))->num_rows()>0)
			{
			$data['alamat'] = $det->alamat;
			$data['angkatan'] = $det->angkatan;
			$data['tempat_lahir'] = $det->tempat_lahir;
			$data['tgl_lahir'] = $det->tgl_lahir;
			$data['jurusan'] = $det->jurusan;
			$data['id_link'] = $det1->idlink;
			}
			else
			{
			$data['alamat'] = "";
			$data['angkatan'] = "";
			$data['tempat_lahir'] = "";
			$data['tgl_lahir'] = "";
			$data['jurusan'] = "";
			$data['id_link'] = "";
			}


			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_mahasiswa',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatemahasiswa()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){

				if(empty($_POST['psw']))
				{
					$this->db->set('nama', $this->input->post('nama', TRUE));

				    $this->db->where('username', $_POST['username']);
				    $this->db->update('tbllogin');
			
					$data['nama'] = $_POST['nama'];
					$data['alamat'] = $_POST['alamat'];
					$data['angkatan'] = $_POST['angkatan'];
					$data['tempat_lahir'] = $_POST['tempat_lahir'];
					$data['tgl_lahir'] = $_POST['tgl_lahir'];
					$data['jurusan'] = $_POST['jurusan'];

					$this->db->update("tblmahasiswa",$data,array("id_mahasiswa"=>$_POST['username']));
				}
				else
				{
					$this->db->set('nama', $this->input->post('nama', TRUE));
					$this->db->set('psw', 'PASSWORD("'.$this->input->post('psw', TRUE).'")', FALSE);

				    $this->db->where('username', $_POST['username']);
				    $this->db->update('tbllogin');
			
					$data['nama'] = $_POST['nama'];
					$data['alamat'] = $_POST['alamat'];
					$data['angkatan'] = $_POST['angkatan'];
					$data['tempat_lahir'] = $_POST['tempat_lahir'];
					$data['tgl_lahir'] = $_POST['tgl_lahir'];
					$data['jurusan'] = $_POST['jurusan'];

					$this->db->update("tblmahasiswa",$data,array("id_mahasiswa"=>$_POST['username']));
				}

				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/mhs'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapusmahasiswa()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->db->delete("tbllogin",array("username"=>$id));
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/mhs'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}

	function dosen()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->db->get_where("tbllogin",array("status"=>"PA"),$limit_ti,$offset_ti);
			$tot_hal = $this->db->get_where("tbllogin",array("status"=>"PA"));
      		$config['base_url'] = base_url() . '/index.php/admin/dosen';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/dosen',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function tambahdosen()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';

		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_dosen');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function simpandosen()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){
			$this->load->model('Admin_model');
			$tgl = " %Y-%m-%d";
			$time = time();

			$in['dosen'] = $_POST['nama'];
			$in['alamat'] = $_POST['alamat'];
			$in['tempat_lahir'] = $_POST['tempat_lahir'];
			$in['tgl_lahir'] = $_POST['tgl_lahir'];
			$in['pend_terakhir'] = $_POST['pend_terakhir'];

			$this->db->insert("tbldosen",$in);

			$id_dosen = $this->db->insert_id();

			$this->db->set('username', $this->input->post('username', TRUE));
			$this->db->set('psw', 'PASSWORD("'.$this->input->post('psw', TRUE).'")', FALSE);
			$this->db->set('nama', $this->input->post('nama', TRUE));
			$this->db->set('status', "PA");
			$this->db->set('idlink', $id_dosen);

			$this->db->insert("tbllogin");


			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/dosen'>";

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function editdosen()
	{
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		$this->load->model('Admin_model');
		if($session!=""){
		$pecah=explode("|",$session);
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($data["status"]=="admin"){
			$det=$this->db->get_where("tbllogin",array("username"=>$id))->row();
			$data['nama'] = $det->nama;
			$data['username'] = $det->username;
			$data['id_link'] = $det->idlink;

			$det_dosen=$this->db->get_where("tbldosen",array("id_dosen"=>$det->idlink))->row();

			$data['dosen'] = $det_dosen->dosen;
			$data['alamat'] = $det_dosen->alamat;
			$data['tempat_lahir'] = $det_dosen->tempat_lahir;
			$data['tgl_lahir'] = $det_dosen->tgl_lahir;
			$data['pend_terakhir'] = $det_dosen->pend_terakhir;


			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_dosen',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function updatedosen()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
			if($status=="admin"){

				if(empty($_POST['psw']))
				{
					$this->db->set('nama', $this->input->post('nama', TRUE));

				    $this->db->where('username', $_POST['username']);
				    $this->db->update('tbllogin');

				    $id['id_dosen'] = $_POST['id_link'];

					$in['dosen'] = $_POST['nama'];
					$in['alamat'] = $_POST['alamat'];
					$in['tempat_lahir'] = $_POST['tempat_lahir'];
					$in['tgl_lahir'] = $_POST['tgl_lahir'];
					$in['pend_terakhir'] = $_POST['pend_terakhir'];

					$this->db->update("tbldosen",$in,$id);
				}
				else
				{
					$this->db->set('nama', $this->input->post('nama', TRUE));
					$this->db->set('psw', 'PASSWORD("'.$this->input->post('psw', TRUE).'")', FALSE);

				    $this->db->where('username', $_POST['username']);
				    $this->db->update('tbllogin');

				    $id['id_dosen'] = $_POST['id_link'];

					$in['dosen'] = $_POST['nama'];
					$in['alamat'] = $_POST['alamat'];
					$in['tempat_lahir'] = $_POST['tempat_lahir'];
					$in['tgl_lahir'] = $_POST['tgl_lahir'];
					$in['pend_terakhir'] = $_POST['pend_terakhir'];

					$this->db->update("tbldosen",$in,$id);
				}

				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/dosen'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	function hapusdosen()
	{
		$in=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$status=$pecah[3];
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
			if($status=="admin"){
			$this->db->delete("tbllogin",array("username"=>$id));
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/dosen'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}


	
	function polling()
	{
		$page=$this->uri->segment(3);
      	$limit=9;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$tot_hal = $this->Admin_model->Total_Artikel("tblsoalpolling");
			$config['base_url'] = base_url() . '/index.php/admin/polling/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$data["paginator"]=$this->pagination->create_links();
			$data["page"] = $page;
			$data["detail"] = $this->Admin_model->Daftar_Polling($offset,$limit);

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/polling');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function tambahsoalpoll()
	{
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$tgl = "%d-%m-%Y";
		$time = time();
		$data["wkt_skr"] = mdate($tgl,$time);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_soal_poll');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function simpansoalpoll() 
	{
		$data=array();
		$data2=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
				$tgl = " %Y-%m-%d";
				$time = time();
				$in["soal_poll"]=$this->input->post('soal');
				$in["status"]=$this->input->post('status');
				if($in["soal_poll"]=="")
				{
					echo "Data masih kosong..!!!";
				}
				else{
				$this->Admin_model->Simpan_Artikel("tblsoalpolling",$in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/polling'>";
				}
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function editsoalpolling()
	{
		$id='';
		if ($this->uri->segment(3) === FALSE)
		{
    			$id=$id;
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$tgl = "%d-%m-%Y";
			$time = time();
			$data["wkt_skr"] = mdate($tgl,$time);
			$data["detail"]=$this->Admin_model->Edit_Content("tblsoalpolling","id_soal_poll=".$id."");

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_soal_poll');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function updatesoalpoll()
	{
		$in = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
				$in["id_soal_poll"]=$this->input->post('id');
				$in["soal_poll"]=$this->input->post('soal');
				$in["status"]=$this->input->post('status');
				$this->Admin_model->Update_Content("tblsoalpolling",$in,"id_soal_poll");
	   			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/polling'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function hapussoalpolling()
	{
		$id='';
		if ($this->uri->segment(3) === FALSE)
		{
    			$id=$id;
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->Admin_model->Delete_Content($id,"id_soal_poll","tblsoalpolling");
			?>
			<script type="text/javascript">
			javascript:history.go(-1);
			</script>
			<?php
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function tambahjwbpoll()
	{
		$page=$this->uri->segment(3);
      	$limit=5;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$tgl = "%d-%m-%Y";
		$time = time();
		$data["wkt_skr"] = mdate($tgl,$time);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$tot_hal = $this->Admin_model->Total_Artikel("tbljawabanpoll");
			$config['base_url'] = base_url() . '/index.php/admin/tambahjwbpoll/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$data["paginator"]=$this->pagination->create_links();
			$data["page"] = $page;
			$data["soal_poll"]=$this->Admin_model->Tampil_Data("tblsoalpolling","id_soal_poll");
			$data["jwb_poll"]=$this->Admin_model->Tampil_Data_Terbatas("tbljawabanpoll","id_jawaban_poll","left join tblsoalpolling on 
			tbljawabanpoll.id_soal_poll=tblsoalpolling.id_soal_poll",$offset,$limit);


			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_jwb_poll');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function simpanjwbpoll() 
	{
		$data=array();
		$data2=array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
				$tgl = " %Y-%m-%d";
				$time = time();
				$in["id_soal_poll"]=$this->input->post('pertanyaan');
				$in["jawaban"]=$this->input->post('jawaban');
				$in["counter"]="1";
				if($in["jawaban"]=="")
				{
					echo "Data masih kosong..!!!";
				}
				else{
				$this->Admin_model->Simpan_Artikel("tbljawabanpoll",$in);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tambahjwbpoll'>";
				}
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function editjwbpoll()
	{
		$id='';
		if ($this->uri->segment(3) === FALSE)
		{
    			$id=$id;
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$tgl = "%d-%m-%Y";
			$time = time();
			$data["wkt_skr"] = mdate($tgl,$time);
			
			$data["soal_poll"]=$this->Admin_model->Tampil_Data("tblsoalpolling","id_soal_poll");
			$data["detail"]=$this->Admin_model->Edit_Content("tbljawabanpoll","id_jawaban_poll=".$id."");
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_jwb_poll',$data);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function updatejwbpoll()
	{
		$in = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
				$in["id_jawaban_poll"]=$this->input->post('id');
				$in["id_soal_poll"]=$this->input->post('pertanyaan');
				$in["jawaban"]=$this->input->post('jawaban');
				$in["counter"]=$this->input->post('counter');
				$this->Admin_model->Update_Content("tbljawabanpoll",$in,"id_jawaban_poll");
	   			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/admin/tambahjwbpoll'>";
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function hapusjwbpoll()
	{
		$id='';
		if ($this->uri->segment(3) === FALSE)
		{
    			$id=$id;
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$data = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data["username"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[2];
	   	$data['scriptmce'] = $this->scripttiny_mce();
			if($data["status"]=="admin"){
			$this->Admin_model->Delete_Content($id,"id_jawaban_poll","tbljawabanpoll");
			?>
			<script type="text/javascript">
			javascript:history.go(-1);
			</script>
			<?php
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
		else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function matkul()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->model('Admin_model');
			$this->load->library('Pagination');
			$query=$this->db->get("tblmatkul",$limit_ti,$offset_ti);
			$tot_hal = $this->db->get("tblmatkul");
      		$config['base_url'] = base_url() . '/index.php/admin/matkul';
       		$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit_ti;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
			$this->pagination->initialize($config);
			$paginator=$this->pagination->create_links();
	   		$data['scriptmce'] = $this->scripttiny_mce();
        	$data_isi = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/matkul',$data_isi);
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function tambahmatkul()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;
			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_matkul');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function editmatkul($id)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;

			$get = $this->db->get_where("tblmatkul",array("id_mk"=>$id))->row();
			$data['id_mk'] = $get->id_mk;
			$data['semester'] = $get->semester;
			$data['kode_mk'] = $get->kode_mk;
			$data['nama_mk'] = $get->nama_mk;
			$data['sks'] = $get->sks;
			$data['id_dosen'] = $get->id_dosen;
			$data['prasyarat'] = $get->prasyarat;
			$data['prodi'] = $get->prodi;

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_matkul');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function simpanmatkul()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			
			$in['semester'] = $_POST['semester'];
			$in['kode_mk'] = $_POST['kode_mk'];
			$in['nama_mk'] = $_POST['nama_mk'];
			$in['sks'] = $_POST['sks'];
			$in['id_dosen'] = $_POST['id_dosen'];
			$in['prasyarat'] = $_POST['prasyarat'];
			$in['prodi'] = $_POST['prodi'];

			$this->db->insert("tblmatkul",$in);
			redirect("admin/matkul");

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function updatematkul()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			
			$id['id_mk'] = $_POST['id_mk'];
			$in['semester'] = $_POST['semester'];
			$in['kode_mk'] = $_POST['kode_mk'];
			$in['nama_mk'] = $_POST['nama_mk'];
			$in['sks'] = $_POST['sks'];
			$in['id_dosen'] = $_POST['id_dosen'];
			$in['prasyarat'] = $_POST['prasyarat'];
			$in['prodi'] = $_POST['prodi'];

			$this->db->update("tblmatkul",$in,$id);
			redirect("admin/matkul");

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function hapusmatkul($id)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			
			$in['id_mk'] = $id;

			$this->db->delete("tblmatkul",$in);
			redirect("admin/matkul");

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function soal()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			
			

				$this->load->model('Tes_model');
				$this->load->library('Pagination');		
				$page=$this->uri->segment(3);
		      	$limit_ti=15;
				if(!$page):
				$offset_ti = 0;
				else:
				$offset_ti = $page;
				endif;
				$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
				$time = time();
				$data_atas = array();
				$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
				if($session!=""){
				$pecah=explode("|",$session);
				$data_atas["nama"]=$pecah[1];
				}
				$data_atas["tanggal"] = mdate($datestring, $time);
				$query=$this->Tes_model->Tampil_Soal($limit_ti,$offset_ti);
				$total_soal = $query->num_rows();
				$tot_hal = $this->Tes_model->Total_Soal();
		      	$config['base_url'] = base_url() . '/index.php/tes/katalogsoal';
		        $config['total_rows'] = $tot_hal->num_rows();
		        $config['per_page'] = $limit_ti;
				$config['uri_segment'] = 3;
			    $config['first_link'] = 'Awal';
				$config['last_link'] = 'Akhir';
				$config['next_link'] = 'Selanjutnya';
				$config['prev_link'] = 'Sebelumnya';
		        $this->pagination->initialize($config);
				$paginator=$this->pagination->create_links();

		        $data = array('query' => $query,'paginator'=>$paginator, 'page'=>$page);
	   			$data_atas['scriptmce'] = $this->scripttiny_mce();
				$this->load->view('admin/bg_head',$data_atas);
				$this->load->view('admin/kat_soal',$data);
				$this->load->view('admin/bg_bawah',$data);

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function lihatsoal($id)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			
			
		$this->load->model('Tes_model');
		$this->load->library('Pagination');	
		$page=$this->uri->segment(4);
      		$limit_ti=15;
		if(!$page):
		$offset_ti = 0;
		else:
		$offset_ti = $page;
		endif;
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data_atas = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data_atas["nama"]=$pecah[1];
		}
		$data_atas["tanggal"] = mdate($datestring, $time);
		
		$id_mk='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id_mk='';
		}
		else
		{
    			$id_mk = $this->uri->segment(3);
		}
		$query=$this->Tes_model->Lihat_Soal($id_mk,$limit_ti,$offset_ti);
		$judul=$this->Tes_model->Judul_MK($id_mk);
		$tot_hal = $this->Tes_model->Total_Lihat_Soal($id_mk);
      		$config['base_url'] = base_url() . '/index.php/tes/lihatsoal/'.$id_mk;
        	$config['total_rows'] = $tot_hal->num_rows();
       		$config['per_page'] = $limit_ti;
		$config['uri_segment'] = 4;
	   	$config['first_link'] = 'Awal';
		$config['last_link'] = 'Akhir';
		$config['next_link'] = 'Selanjutnya';
		$config['prev_link'] = 'Sebelumnya';
        	$this->pagination->initialize($config);
		$paginator=$this->pagination->create_links();
		
        	$data = array('query' => $query,'paginator'=>$paginator,'judul'=>$judul, 'page'=>$page);
	   			$data_atas['scriptmce'] = $this->scripttiny_mce();
				$this->load->view('admin/bg_head',$data_atas);
				$this->load->view('admin/lihat_soal',$data);
				$this->load->view('admin/bg_bawah',$data);

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function daftar_soal($id_mk,$no_soal)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
		if($data["status"]=="admin"){
			
			
		
		$this->load->model('Tes_model');
		$datestring = "Login : %d-%m-%Y pukul %h:%i %a";
		$time = time();
		$data_atas = array();
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$nim=$pecah[0];
		$data_atas["nama"]=$pecah[1];
		}
		$data_atas["tanggal"] = mdate($datestring, $time);
		
		$id_mk='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id_mk='';
		}
		else
		{
    			$id_mk = $this->uri->segment(3);
		}
		$no_soal='';		
		if ($this->uri->segment(4) === FALSE)
		{
    			$no_soal='';
		}
		else
		{
    			$no_soal = $this->uri->segment(4);
		}
		$data = array();
		$data["username"]=$nim;
		$lempar=$this->Tes_model->Validasi_Tes($id_mk,$no_soal,$nim);
		
		$data["judul"]=$this->Tes_model->Judul_MK($id_mk);
		$data["soal"] = $this->Tes_model->Tampilkan_Soal_Admin($id_mk,$no_soal);
		$data["jumlah"] = $data["soal"]->num_rows;

	   			$data_atas['scriptmce'] = $this->scripttiny_mce();
				$this->load->view('admin/bg_head',$data_atas);
				$this->load->view('admin/daftar_soal',$data);
				$this->load->view('admin/bg_bawah',$data);

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function edit_soal($id)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;

			$get = $this->db->get_where("tblsoal",array("id_soal"=>$id))->row();
			$data['id_soal'] = $get->id_soal;
			$data['no_soal'] = $get->no_soal;
			$data['id_matkul'] = $get->id_matkul;
			$data['pertanyaan'] = $get->pertanyaan;
			$data['jwb_a'] = $get->jwb_a;
			$data['jwb_b'] = $get->jwb_b;
			$data['jwb_c'] = $get->jwb_c;
			$data['jwb_d'] = $get->jwb_d;
			$data['jwb_e'] = $get->jwb_e;
			$data['kunci'] = $get->kunci;

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/edit_soal');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function updatesoal()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			
			$id['id_soal'] = $_POST['id_soal'];
			$in['no_soal'] = $_POST['no_soal'];
			$in['id_matkul'] = $_POST['id_matkul'];
			$in['pertanyaan'] = $_POST['pertanyaan'];
			$in['jwb_a'] = $_POST['jwb_a'];
			$in['jwb_b'] = $_POST['jwb_b'];
			$in['jwb_c'] = $_POST['jwb_c'];
			$in['jwb_d'] = $_POST['jwb_d'];
			$in['jwb_e'] = $_POST['jwb_e'];
			$in['kunci'] = $_POST['kunci'];

			$this->db->update("tblsoal",$in,$id);
			redirect("admin/daftar_soal/".$in['id_matkul']."/".$in['no_soal']);

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function tambahsoal()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;

			$data['id_soal'] = "";
			$data['no_soal'] = "";
			$data['id_matkul'] = "";
			$data['pertanyaan'] = "";
			$data['jwb_a'] = "";
			$data['jwb_b'] = "";
			$data['jwb_c'] = "";
			$data['jwb_d'] = "";
			$data['jwb_e'] = "";
			$data['kunci'] = "";

			$this->load->view('admin/bg_head',$data);
			$this->load->view('admin/tambah_soal');
			$this->load->view('admin/bg_bawah');
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function simpansoal()
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			
			$in['no_soal'] = $_POST['no_soal'];
			$in['id_matkul'] = $_POST['id_matkul'];
			$in['pertanyaan'] = $_POST['pertanyaan'];
			$in['jwb_a'] = $_POST['jwb_a'];
			$in['jwb_b'] = $_POST['jwb_b'];
			$in['jwb_c'] = $_POST['jwb_c'];
			$in['jwb_d'] = $_POST['jwb_d'];
			$in['jwb_e'] = $_POST['jwb_e'];
			$in['kunci'] = $_POST['kunci'];
			$in['author'] = $data["nim"];

			$this->db->insert("tblsoal",$in);
			redirect("admin/daftar_soal/".$in['id_matkul']."/".$in['no_soal']);

			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}
	
	function hapus_soal($id)
	{
		$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		if($session!=""){
		$pecah=explode("|",$session);
		$data=array();
		$data["nim"]=$pecah[0];
		$data["nama"]=$pecah[1];
		$data["status"]=$pecah[3];
	   	$data['scriptmce'] = $this->scripttiny_mce();
		if($data["status"]=="admin"){
			$page=$this->uri->segment(3);
      		$limit_ti=15;
			if(!$page):
			$offset_ti = 0;
			else:
			$offset_ti = $page;
			endif;

			$get = $this->db->delete("tblsoal",array("id_soal"=>$id));

			redirect("admin/soal");
			}
			else{
			?>
			<script type="text/javascript" language="javascript">
			alert("Anda tidak berhak masuk ke Control Panel Admin...!!!");
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
		}
			else{
			?>
			<script type="text/javascript" language="javascript">
		alert("Anda belum Log In...!!!\nAnda harus Log In untuk mengakses halaman ini...!!!");
		</script>
		<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/'>";
			}
	}

//Function TinyMce------------------------------------------------------------------
		private function scripttiny_mce($selectcategory=null) {
		return '
		<!-- TinyMCE -->
		<script type="text/javascript" src="'.base_url().'jscripts/tiny_mce/tiny_mce_src.js"></script>
		<script type="text/javascript">
		tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "'.base_url().'system/application/views/themes/css/BrightSide.css",

		// Drop lists for link/image/media/template dialogs
		//"'.base_url().'media/lists/image_list.js"
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "'.base_url().'index.php/",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : \'Bold text\', inline : \'b\'},
			{title : \'Red text\', inline : \'span\', styles : {color : \'#ff0000\'}},
			{title : \'Red header\', block : \'h1\', styles : {color : \'#ff0000\'}},
			{title : \'Example 1\', inline : \'span\', classes : \'example1\'},
			{title : \'Example 2\', inline : \'span\', classes : \'example2\'},
			{title : \'Table styles\'},
			{title : \'Table row 1\', selector : \'tr\', classes : \'tablerow1\'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>';	
	} 
}








?>
