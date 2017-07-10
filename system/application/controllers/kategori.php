<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kategori extends Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 **/

	function kategori()
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
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_atas');
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_kategori_list');
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_menu');
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_bawah');
	}

	function set($param=0,$uri=0)
	{

		$where['id_kategori'] = $param;
		$get = $this->db->get_where("dlmbg_kategori",$where)->row();
		$d['kategori'] = $get->nama_kategori;

		$d['detail'] = $this->app_global_forum->generate_index_forum_thread_kategori($param,$GLOBALS['site_limit_medium'],$uri);

		$this->load->view($GLOBALS['site_theme'].'/forum/bg_atas',$d);
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_kategori');
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_menu');
		$this->load->view($GLOBALS['site_theme'].'/forum/bg_bawah');
	}
}
