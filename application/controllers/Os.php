<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Os extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('sos/login');
        }

        $this->load->helper(array('form', 'codegen_helper'));
        $this->load->model('os_model', '', true);
        $this->data['menuOs'] = 'OS';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        $this->load->library('pagination');
        $this->load->model('sos_model');

        $where_array = array();

        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');

        if ($pesquisa) {
            $where_array['pesquisa'] = $pesquisa;
        }
        if ($status) {
            $where_array['status'] = $status;
        }
        if ($de) {

            $de = explode('/', $de);
            $de = $de[2] . '-' . $de[1] . '-' . $de[0];

            $where_array['de'] = $de;
        }
        if ($ate) {
            $ate = explode('/', $ate);
            $ate = $ate[2] . '-' . $ate[1] . '-' . $ate[0];

            $where_array['ate'] = $ate;
        }

        $config['base_url'] = base_url() . 'index.php/os/gerenciar/';
        $config['total_rows'] = $this->os_model->count('os');
        $config['per_page'] = 15;
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';
        $config['full_tag_open'] = '<div class="pagination alternate"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a style="color: #2D335B"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->data['results'] = $this->os_model->getOs('os', 'idOs,dataInicial,dataFinal,descricaoProduto,defeito,status,observacoes,laudoTecnico', $where_array, $config['per_page'], $this->uri->segment(3));
        $this->data['emitente'] = $this->sos_model->getEmitente();
        $this->data['view'] = 'os/os';
        $this->load->view('tema/topo', $this->data);
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Ordem de Serviço');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {

                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2] . '-' . $dataInicial[1] . '-' . $dataInicial[0];

                if ($dataFinal) {
                    $dataFinal = explode('/', $dataFinal);
                    $dataFinal = $dataFinal[2] . '-' . $dataFinal[1] . '-' . $dataFinal[0];
                } else {
                    $dataFinal = date('Y/m/d');
                }

                
            } catch (Exception $e) {
                $dataInicial = date('Y/m/d');
                $dataFinal = date('Y/m/d');
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'clientes_id' => $this->input->post('clientes_id'), //set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'), //set_value('idUsuario'),
                'dataFinal' => $dataFinal,
                'descricaoProduto' => set_value('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico'),
            );

            if (is_numeric($id = $this->os_model->add('os', $data, true))) {
                $this->load->model('sos_model');
                $this->load->model('usuarios_model');

                $idOs = $id;
                $os = $this->os_model->getById($idOs);
                $emitente = $this->sos_model->getEmitente()[0];
                $tecnico = $this->usuarios_model->getById($os->usuarios_id);

                $this->session->set_flashdata('success', 'Ordem de serviço adicionada com sucesso!');
              
            
                redirect('os/editar/' . $id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Um erro ocorreu.</p></div>';
            }
        }

        $this->data['view'] = 'os/adicionarOs';
        $this->load->view('tema/topo', $this->data);
    }

    public function adicionarAjax()
    {
        $this->load->library('form_validation');

        if ($this->form_validation->run('os') == false) {
            $json = array("result" => false);
            echo json_encode($json);
        } else {
            $data = array(
                'dataInicial' => set_value('dataInicial'),
                'clientes_id' => $this->input->post('clientes_id'), //set_value('idCliente'),
                'usuarios_id' => $this->input->post('usuarios_id'), //set_value('idUsuario'),
                'dataFinal' => set_value('dataFinal'),
                'descricaoProduto' => $this->input->post('descricaoProduto'),
                'defeito' => set_value('defeito'),
                'status' => set_value('status'),
                'observacoes' => set_value('observacoes'),
                'laudoTecnico' => set_value('laudoTecnico'),
            );

            if (is_numeric($id = $this->os_model->add('os', $data, true))) {
                $json = array("result" => true, "id" => $id);
                echo json_encode($json);
            } else {
                $json = array("result" => false);
                echo json_encode($json);
            }
        }
    }

    public function editar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Ordem de Serviço');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');

            try {

                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2] . '-' . $dataInicial[1] . '-' . $dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2] . '-' . $dataFinal[1] . '-' . $dataFinal[0];
                
            } catch (Exception $e) {
                $dataInicial = date('Y/m/d');
            }

            $data = array(
                'dataInicial' => $dataInicial,
                'dataFinal' => $dataFinal,
                'descricaoProduto' => $this->input->post('descricaoProduto'),
                'defeito' => $this->input->post('defeito'),
                'status' => $this->input->post('status'),
                'observacoes' => $this->input->post('observacoes'),
                'laudoTecnico' => $this->input->post('laudoTecnico'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'clientes_id' => $this->input->post('clientes_id'),
            );

            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == true) {
                $this->load->model('sos_model');
                $this->load->model('usuarios_model');

                $idOs = $this->input->post('idOs');

                $os = $this->os_model->getById($idOs);
                $emitente = $this->sos_model->getEmitente()[0];
                $tecnico = $this->usuarios_model->getById($os->usuarios_id);

                $this->session->set_flashdata('success', 'Ordem de serviço editada com sucesso!');
            
                redirect(base_url() . 'index.php/os/editar/' . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anotacoes'] = $this->os_model->getAnotacoes($this->uri->segment(3));

        $this->load->model('sos_model');
        $this->data['emitente'] = $this->sos_model->getEmitente();
        
        $this->data['view'] = 'os/editarOs';
        $this->load->view('tema/topo', $this->data);
    }

    public function visualizar()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sos_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->sos_model->getEmitente();
        $this->data['view'] = 'os/visualizarOs';
        $this->load->view('tema/topo', $this->data);
    }

    public function imprimir()
    {
        if (!$this->uri->segment(3) || !is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sos');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar Ordem de Serviço');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sos_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->sos_model->getEmitente();

        $this->load->view('os/imprimirOs', $this->data);
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir O.S.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {

            $this->session->set_flashdata('error', 'Erro ao tentar excluir OS.');
            redirect(base_url() . 'index.php/os/gerenciar/');
        }

        $this->db->where('os_id', $id);
        $this->db->delete('servicos_os');

        $this->db->where('os_id', $id);
        $this->db->delete('anexos');

        $this->os_model->delete('os', 'idOs', $id);

     
        $this->session->set_flashdata('success', 'Ordem de Serviço excluída com sucesso!');
        redirect(base_url() . 'index.php/os/gerenciar/');
    }

    public function autoCompleteCliente()
    {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteUsuario()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }
    }

    public function autoCompleteServico()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteServico($q);
        }
    }

    public function adicionarServico()
    {

        $data = array(
            'servicos_id' => $this->input->post('idServico'),
            'quantidade' => $this->input->post('quantidade'),
            'preco' => $this->input->post('preco'),
            'os_id' => $this->input->post('idOsServico'),
            'subTotal' => $this->input->post('preco') * $this->input->post('quantidade'),
        );

        if ($this->os_model->add('servicos_os', $data) == true) {

           
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    public function excluirServico()
    {
        $ID = $this->input->post('idServico');
        if ($this->os_model->delete('servicos_os', 'idServicos_os', $ID) == true) {

            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    } 

    public function adicionarAnotacao()
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run('anotacoes_os') == false) {
            echo json_encode(validation_errors());
        } else {
            $data = array(
                'anotacao' => $this->input->post('anotacao'),
                'data_hora' => date('Y-m-d H:i:s'),
                'os_id' => $this->input->post('os_id'),
            );

            if ($this->os_model->add('anotacoes_os', $data) == true) {

                
                echo json_encode(array('result' => true));
            } else {
                echo json_encode(array('result' => false));
            }
        }
    }

    public function excluirAnotacao()
    {
        $id = $this->input->post('idAnotacao');
        if ($this->os_model->delete('anotacoes_os', 'idAnotacoes', $id) == true) {

           
            echo json_encode(array('result' => true));
        } else {
            echo json_encode(array('result' => false));
        }
    }
}
