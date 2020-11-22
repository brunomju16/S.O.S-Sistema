<?php
class Servicos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    
    function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idServicos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getServicos($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        
        $lista_servicos = array();
        if ($where) {

            if (array_key_exists('pesquisa', $where)) {
                $this->db->select('idServicos');
                $this->db->like('nome', $where['pesquisa']);
                $this->db->limit(15);
                $Servicos = $this->db->get('servicos')->result();

                foreach ($Servicos as $c) {
                    array_push($lista_servicos, $c->idServicos);
                }
            }
        }
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idServicos', 'desc');
        $this->db->limit($perpage, $start);
        // condicionais da pesquisa

        // condicional de Servicos
        if (array_key_exists('pesquisa', $where)) {
            if ($lista_servicos != null) {
                $this->db->where_in('servicos.idServicos', $lista_servicos);
            }
        }

        $this->db->limit($perpage, $start);

        $query = $this->db->get();

        $result = !$one ? $query->result() : $query->row();
        return $result;
    }

    function getById($id)
    {
        $this->db->where('idServicos', $id);
        $this->db->limit(1);
        return $this->db->get('servicos')->row();
    }
    
    function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    
    function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }
        
        return false;
    }
    
    function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }
        
        return false;
    }
    function getAllTipos()
    {
        $this->db->where('situacaoser', 1);
        return $this->db->get('tiposServicos')->result();
    }
    
    function count($table)
    {
        return $this->db->count_all($table);
    }
}
