<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class post_new extends Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 **/

	function post_new()
	{
		parent::Controller();
		$this->load->helper(array('form','url', 'text_helper','date','captcha'));
		$this->load->database();
		$this->load->library();
		$this->load->plugin();
		session_start();
	}
 

	function index()
	{
		if($_SESSION['username_belajar']!="")
		{

			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$d['gbr_captcha'] = $cap['image'];

			$this->load->view($GLOBALS['site_theme'].'/forum/bg_atas',$d);
			$this->load->view($GLOBALS['site_theme'].'/forum/post_new');
			$this->load->view($GLOBALS['site_theme'].'/forum/bg_menu');
			$this->load->view($GLOBALS['site_theme'].'/forum/bg_bawah');
		}
		else
		{
			redirect(base_url());
		}
	}

	function save()
	{
		if($_SESSION['username_belajar']!="")
		{
			$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
		
			$pecah=explode("|",$session);
			$id_anggota=$pecah[0];

			$id_gen = $this->db->query("SELECT REPLACE(UUID(),'-','') as hasil")->row();
			$this->db->set('id_forum',$id_gen->hasil); 
			$this->db->set("judul",$this->input->post('judul'));
			$this->db->set("isi",$this->input->post('isi'));
			$this->db->set("id_kategori",$this->input->post('id_kategori'));
			$this->db->set("id_anggota",$id_anggota);
			$this->db->set("post_date",gmdate('Y-m-d H:i:s',time()+60*60*9));
			$this->db->set("last_date",gmdate('Y-m-d H:i:s',time()+60*60*9));
			$this->db->set("hitung",1);

			$id = $id_gen->hasil; 
			
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'],  $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			
			if ($row->count == 0)
			{
				?>
					<script>
						alert('Kode captcha salah...');
						javascript:history.go(-1);
					</script>
				<?php
			}
			else
			{
				$this->db->insert("dlmbg_thread_forum");
				redirect("forum/detail/".$id."");
			}
		}
		else
		{
			redirect(base_url());
		}
	}
}
