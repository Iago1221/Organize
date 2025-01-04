<?php

use Piggly\Pix\StaticPayload;

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class NotaFiscal_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get($where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select('*, lpad(nota_fiscal.numero, 9, 0) as numeroNotaFiscal, lpad(nota_fiscal.serie, 2, 0) as serieNotaFiscal, nota_fiscal.numero as nfid, clientes.ibge as cliente_ibge');
        $this->db->from('nota_fiscal');
        $this->db->join('vendas', 'vendas.idVendas = nota_fiscal.venda');
        $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id');
        $this->db->limit($perpage, $start);
        $this->db->order_by('nota_fiscal.numero', 'desc');
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result =  !$one ? $query->result() : $query->row();
        return $result;
    }

    public function getItens($idVenda)
    {
        $this->db->select('*, coalesce(produtos.ean, \'SEM GTIN\') AS produto_ean');
        $this->db->from('itens_de_vendas');
        $this->db->join('produtos', 'produtos.idProdutos = itens_de_vendas.produtos_id');
        $this->db->where('vendas_id', $idVenda);
        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('*, lpad(nota_fiscal.numero, 9, 0) as numeroNotaFiscal, lpad(nota_fiscal.serie, 2, 0) as serieNotaFiscal, nota_fiscal.numero as nfid, clientes.ibge as cliente_ibge');
        $this->db->from('nota_fiscal');
        $this->db->join('vendas', 'vendas.idVendas = nota_fiscal.venda');
        $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id');
        $this->db->where('nota_fiscal.numero', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }


    public function getByVenda($vendaId = null)
    {
        $this->db->select('nota_fiscal.*');
        $this->db->from('nota_fiscal');
        $this->db->where('venda', $vendaId);
        return $this->db->get()->result();
    }

    public function add($table, $data, $returnId = false)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            if ($returnId == true) {
                return $data['numero'];
            }
            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function getSerie() {
        $this->db->select('max(serie) AS serie');
        $this->db->from('nota_fiscal');
        $result = $this->db->get()->result();
        return $result[0]->serie ?: 01;
    }

    public function getNumero($serie) {
        $this->db->select('(max(numero) + 1) AS numero');
        $this->db->from('nota_fiscal');
        $this->db->where('serie', $serie);
        $result = $this->db->get()->result();
        return $result[0]->numero ?: 00000001;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }
}

/* End of file vendas_model.php */
/* Location: ./application/models/vendas_model.php */
