<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_home');
    }


    public function index()
    {
        $data = array(
            'title' => 'Home',
            'knitstore' => $this->m_home->get_all_data(),
            'isi' => 'v_home'
        );
        $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
    }

    public function kategori($id_kategori)
    {
        $kategori = $this->m_home->kategori($id_kategori);
        $data = array(
            'title' => 'Kategori knitstore : ' . $kategori->nama_kategori,
            'knitstore' => $this->m_home->get_all_data_knitstore($id_kategori),
            'isi' => 'v_kategori_knitstore'
        );
        $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
    }

    public function detail_knitstore($id_knitstore)
    {
        $data = array(
            'title' => 'Detail knitstore',
            'gambar'=> $this->m_home->gambar_knitstore($id_knitstore),
            'knitstore' => $this->m_home->detail_knitstore($id_knitstore),
            'isi' => 'v_detail_knitstore'
        );
        $this->load->view('layout/v_wrapper_frontend', $data, FALSE);
    }

    public function search(){
        $keyword = $this->input->post('keyword');
        $data = array(
            'title' => "Search knitstore",
            'knitstore' => $this->m_home->get_keyword($keyword),
            'isi' => 'v_search_knitstore'
        );
        $this->load->view('layout/v_wrapper_frontend', $data, FALSE);

    }
}

/* End of fils Home.php */
