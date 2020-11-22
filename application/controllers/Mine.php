<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Mine extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Conecte_model');
    }

    public function index()
    {

        $this->load->view('conecte/login');
    }

    public function sair()
    {
        $this->session->sess_destroy();
        redirect('mine');
    }

    public function login()
    {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required|trim');
        $this->form_validation->set_rules('documento', 'Documento', 'required|trim');
        $ajax = $this->input->get('ajax');
        if ($this->form_validation->run() == false) {

            if ($ajax == true) {
                $json = array('result' => false);
                echo json_encode($json);
            } else {
                $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                redirect('mine');
            }
        } else {

            $email = $this->input->post('email');
            $documento = $this->input->post('documento');

            $this->db->where('email', $email);
            $this->db->where('documento', $documento);
            $this->db->limit(1);
            $cliente = $this->db->get('clientes')->row();

            if (count($cliente) > 0) {
                $dados = array('nome' => $cliente->nomeCliente, 'cliente_id' => $cliente->idClientes, 'conectado' => true);
                $this->session->set_userdata($dados);

                if ($ajax == true) {
                    $json = array('result' => true);
                    echo json_encode($json);
                } else {
                    redirect(site_url() . '/mine');
                }
            } else {

                if ($ajax == true) {
                    $json = array('result' => false);
                    echo json_encode($json);
                } else {
                    $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                    redirect(site_url() . '/mine');
                }
            }
        }
    }

    public function painel()
    {

        if (!session_id() || !$this->session->userdata('conectado')) {
            redirect('mine');
        }

        $data['menuPainel'] = 'painel';
        //$data['compras'] = $this->Conecte_model->getLastCompras($this->session->userdata('cliente_id'));
        $data['os'] = $this->Conecte_model->getLastOs($this->session->userdata('cliente_id'));
        $data['output'] = 'conecte/painel';
        $this->load->view('conecte/template', $data);
    }

    public function conta()
    {

        if (!session_id() || !$this->session->userdata('conectado')) {
            redirect('mine');
        }

        $data['menuConta'] = 'conta';
        $data['result'] = $this->Conecte_model->getDados();

        $data['output'] = 'conecte/conta';
        $this->load->view('conecte/template', $data);
    }

    public function os()
    {

        if (!session_id() || !$this->session->userdata('conectado')) {
            redirect('mine');
        }

        $data['menuOs'] = 'os';
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'index.php/mine/os/';
        $config['total_rows'] = $this->Conecte_model->count('os', $this->session->userdata('cliente_id'));
        $config['per_page'] = 10;
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

        $data['results'] = $this->Conecte_model->getOs('os', '*', '', $config['per_page'], $this->uri->segment(3), '', '', $this->session->userdata('cliente_id'));

        $data['output'] = 'conecte/os';
        $this->load->view('conecte/template', $data);
    }

    public function visualizarOs($id = null)
    {

        if (!session_id() || !$this->session->userdata('conectado')) {
            redirect('mine');
        }

        $data['menuOs'] = 'os';
        $this->data['custom_error'] = '';
        $this->load->model('sos_model');
        $this->load->model('os_model');
        $data['result'] = $this->os_model->getById($this->uri->segment(3));
        $data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $data['emitente'] = $this->sos_model->getEmitente();

        if ($data['result']->idClientes != $this->session->userdata('cliente_id')) {
            $this->session->set_flashdata('error', 'Esta Ordem de serviço não pertence ao cliente logado.');
            redirect('mine/painel');
        }

        $data['output'] = 'conecte/visualizar_os';
        $this->load->view('conecte/template', $data);
    }

    public function imprimirOs($id = null)
    {

        if (!session_id() || !$this->session->userdata('conectado')) {
            redirect('mine');
        }

        $data['menuOs'] = 'os';
        $this->data['custom_error'] = '';
        $this->load->model('sos_model');
        $this->load->model('os_model');
        $data['result'] = $this->os_model->getById($this->uri->segment(3));

        $data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $data['emitente'] = $this->sos_model->getEmitente();

        if ($data['result']->idClientes != $this->session->userdata('cliente_id')) {
            $this->session->set_flashdata('error', 'Esta Ordem de serviço não pertence ao cliente logado.');
            redirect('mine/painel');
        }

        $this->load->view('conecte/imprimirOs', $data);
    }


    public function minha_ordem_de_servico($y = null, $when = null)
    {

        if (($y != null) && (is_numeric($y))) {

            // Do not forget this number -> 44023
            // function sending => y = (7653 * ID) + 44023
            // function recieving => x = (y - 44023) / 7653

            // Example ID = 2 | y = 59329

            $y = intval($y);
            $id = ($y - 44023) / 7653;

            $data['menuOs'] = 'os';
            $this->data['custom_error'] = '';
            $this->load->model('sos_model');
            $this->load->model('os_model');
            $data['result'] = $this->os_model->getById($id);
            if ($data['result'] == null) {
                // Resposta em caso de não encontrar a ordem de serviço
                //$this->load->view('conecte/login');

            } else {

                $data['servicos'] = $this->os_model->getServicos($id);
                $data['emitente'] = $this->sos_model->getEmitente();

                $this->load->view('conecte/minha_os', $data);
            }
        } else {
            // Resposta em caso de não encontrar a ordem de serviço
            //$this->load->view('conecte/');
        }
    }

    
}

