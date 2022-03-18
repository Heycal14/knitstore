<?php

defined('BASEPATH') or exit('No direct script access allowed');

class gambarknitstore extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_gambarknitstore');
        $this->load->model('m_knitstore');
    }


    public function index()
    {
        $data = array(
            'title' => 'Gambar knitstore',
            'gambarknitstore' => $this->m_gambarknitstore->get_all_data(),
            'isi' => 'gambarknitstore/v_index',
        );
        $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    }

    public function add($id_knitstore)
    {
        $this->form_validation->set_rules(
            'keterangan',
            'Keterangan Gambar',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = './assets/gambarknitstore/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
            $config['max_size']     = '2000';
            $this->upload->initialize($config);
            $field_name = "gambar";
            if (!$this->upload->do_upload($field_name)) {
                $data = array(
                    'title' => 'Add Gambar knitstore',
                    'error_upload' => $this->upload->display_errors(),
                    'knitstore' => $this->m_knitstore->get_data($id_knitstore),
                    'gambar' => $this->m_gambarknitstore->get_gambar($id_knitstore),
                    'isi' => 'gambarknitstore/v_add',
                );
                $this->load->view('layout/v_wrapper_backend', $data, FALSE);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/gambarknitstore/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $data = array(
                    'id_knitstore' => $id_knitstore,
                    'keterangan' => $this->input->post('keterangan'),
                    'gambar' => $upload_data['uploads']['file_name'],
                );
                $this->m_gambarknitstore->add($data);
                $this->session->set_flashdata('pesan', 'Gambar Berhasil Ditambahkan!!!');
                redirect('gambarknitstore/add/' . $id_knitstore);
            }
        }
        $data = array(
            'title' => 'Add Gambar knitstore',
            'knitstore' => $this->m_knitstore->get_data($id_knitstore),
            'gambar' => $this->m_gambarknitstore->get_gambar($id_knitstore),
            'isi' => 'gambarknitstore/v_add',
        );
        $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    }
    public function delete($id_knitstore ,$id_gambar)
    {
        //hapus gambar
        $gambar = $this->m_gambarknitstore->get_data($id_gambar);
        if ($gambar->gambar != "") {
            unlink('./assets/gambarknitstore/' . $gambar->gambar);
        }
        //end
        $data = array('id_gambar' => $id_gambar);
        $this->m_gambarknitstore->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Dihapus!!!');
        redirect('gambarknitstore/add/' . $id_knitstore);
    }
}

/* End of fils Home.php */
