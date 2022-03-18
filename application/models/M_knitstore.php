<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_knitstore extends CI_Model 
{
    public function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tbl_knitstore');
        $this->db->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_knitstore.id_kategori', 'left');  
        $this->db->order_by('id_knitstore', 'desc');
        return $this->db->get()->result();  
    }

    public function get_data($id_knitstore)
    {
        $this->db->select('*');
        $this->db->from('tbl_knitstore');
        $this->db->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_knitstore.id_kategori', 'left');  
        $this->db->where('id_knitstore', $id_knitstore);
        
        return $this->db->get()->row();  
    }

    public function add($data)
    {
        $this->db->insert('tbl_knitstore', $data);
        
    }
    public function edit($data)
    {
        $this->db->where('id_knitstore', $data['id_knitstore']);
        $this->db->update('tbl_knitstore', $data);
        
        
    }
    public function delete($data)
    {
        $this->db->where('id_knitstore', $data['id_knitstore']);
        $this->db->delete('tbl_knitstore', $data);
    }
}
