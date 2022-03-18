<?php


defined('BASEPATH') or exit('No direct script access allowed');

class knitstore extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_knitstore');
        $this->load->model('m_kategori');
    }

    // List all your items
    public function index()
    {
        $data = array(
            'title' => 'knitstore',
            'knitstore' => $this->m_knitstore->get_all_data(),
            'isi' => 'knitstore/v_knitstore'
        );
        $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    }

    // Add a new item
    public function add()
    {

        $this->form_validation->set_rules(
            'judul',
            'Judul knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'id_kategori',
            'Kategori',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'harga',
            'harga knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'berat',
            'berat knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'deskripsi',
            'Deskripsi knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );


        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = './assets/gambar/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
            $config['max_size']     = '2000';
            $this->upload->initialize($config);
            $field_name = "gambar";
            if (!$this->upload->do_upload($field_name)) {
                $data = array(
                    'title' => 'Add knitstore',
                    'kategori' => $this->m_kategori->get_all_data(),
                    'error_upload' => $this->upload->display_errors(),
                    'isi' => 'knitstore/v_add'
                );
                $this->load->view('layout/v_wrapper_backend', $data, FALSE);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/gambar/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'harga' => $this->input->post('harga'),
                    'berat' => $this->input->post('berat'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'gambar' => $upload_data['uploads']['file_name'],
                );
                $this->m_knitstore->add($data);
                $this->session->set_flashdata('pesan', 'Data Berhasil Ditambahkan!!!');
                redirect('knitstore');
            }
        }


        $data = array(
            'title' => 'Add knitstore',
            'kategori' => $this->m_kategori->get_all_data(),
            'isi' => 'knitstore/v_add'
        );
        $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    }

    //Update one item
    public function edit($id_knitstore = NULL)
    {
        $this->form_validation->set_rules(
            'judul',
            'Judul knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'id_kategori',
            'Kategori',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'harga',
            'harga knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'berat',
            'harga knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );

        $this->form_validation->set_rules(
            'deskripsi',
            'Deskripsi knitstore',
            'required',
            array('required' => '%s Harus Diissi!!!')
        );


        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = './assets/gambar/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
            $config['max_size']     = '2000';
            $this->upload->initialize($config);
            $field_name = "gambar";
            if (!$this->upload->do_upload($field_name)) {
                $data = array(
                    'title' => 'Edit knitstore',
                    'kategori' => $this->m_kategori->get_all_data(),
                    'knitstore' => $this->m_knitstore->get_data($id_knitstore),
                    'error_upload' => $this->upload->display_errors(),
                    'isi' => 'knitstore/v_edit'
                );
                $this->load->view('layout/v_wrapper_backend', $data, FALSE);
            } else {
                //hapus gambar
                $knitstore = $this->m_knitstore->get_data($id_knitstore);
                if ($knitstore->gambar != "") {
                    unlink('./assets/gambar/' . $knitstore->gambar);
                }
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/gambar/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);
                $data = array(
                    'id_knitstore' => $id_knitstore,
                    'judul' => $this->input->post('judul'),
                    'id_kategori' => $this->input->post('id_kategori'),
                    'harga' => $this->input->post('harga'),
                    'berat' => $this->input->post('berat'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'gambar' => $upload_data['uploads']['file_name'],
                );
                $this->m_knitstore->edit($data);
                $this->session->set_flashdata('pesan', 'Data Berhasil Diganti!!!');
                redirect('knitstore');
            }
            //jika ganti gambar
            $data = array(
                'id_knitstore' => $id_knitstore,
                'judul' => $this->input->post('judul'),
                'id_kategori' => $this->input->post('id_kategori'),
                'harga' => $this->input->post('harga'),
                'berat' => $this->input->post('berat'),
                'deskripsi' => $this->input->post('deskripsi'),
            );
            $this->m_knitstore->edit($data);
            $this->session->set_flashdata('pesan', 'Data Berhasil Diganti!!!');
            redirect('knitstore');
        }


        $data = array(
            'title' => 'Edit knitstore',
            'kategori' => $this->m_kategori->get_all_data(),
            'knitstore' => $this->m_knitstore->get_data($id_knitstore),
            'isi' => 'knitstore/v_edit'
        );
        $this->load->view('layout/v_wrapper_backend', $data, FALSE);
    }

    //Delete one item
    public function delete($id_knitstore = NULL)
    {
        //hapus gambar
        $knitstore = $this->m_knitstore->get_data($id_knitstore);
        if ($knitstore->gambar != "") {
            unlink('./assets/gambar/' . $knitstore->gambar);
        }
        //end
        $data = array('id_knitstore' => $id_knitstore);
        $this->m_knitstore->delete($data);
        $this->session->set_flashdata('pesan', 'Data Berhasil Dihapus!!!');
        redirect('knitstore');
    }
}

/* End of file knitstore.php */
