<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Relatorios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ((!session_id()) || (!$this->session->userdata('logado'))) {
            redirect('sos/login');
        }

        $this->load->model('Relatorios_model', '', true);
        $this->load->model('Usuarios_model', '', true);
        $this->load->model('Sos_model', '', true);

        $this->data['menuRelatorios'] = 'Relatórios';
    }

    public function index()
    {
        redirect(base_url());
    }

    public function clientes()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de clientes.');
            redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_clientes';
        $this->load->view('tema/topo', $this->data);
    }

    public function clientesCustom()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de clientes.');
            redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');

        $data['title'] = 'Relatório de Clientes';
        $data['dataInicial'] = date('d/m/Y', strtotime($dataInicial));
        $data['dataFinal'] = date('d/m/Y', strtotime($dataFinal));

        $data['clientes'] = $this->Relatorios_model->clientesCustom($dataInicial, $dataFinal);
        $data['emitente'] = $this->Sos_model->getEmitente();
        $data['topo'] = $this->load->view('relatorios/imprimir/imprimirTopo', $data, true);

        $this->load->helper('mpdf');
        //$this->load->view('relatorios/imprimir/imprimirClientes', $data);
        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), true);
    }

    public function clientesRapid()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de clientes.');
            redirect(base_url());
        }

        $data['title'] = 'Relatório de Clientes';
        $data['clientes'] = $this->Relatorios_model->clientesRapid();
        $data['emitente'] = $this->Sos_model->getEmitente();
        $data['topo'] = $this->load->view('relatorios/imprimir/imprimirTopo', $data, true);

        $this->load->helper('mpdf');

        $html = $this->load->view('relatorios/imprimir/imprimirClientes', $data, true);
        pdf_create($html, 'relatorio_clientes' . date('d/m/y'), true);
    }

    public function servicos()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de serviços.');
            redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_servicos';
        $this->load->view('tema/topo', $this->data);
    }

    public function servicosCustom()
    {

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de serviços.');
            redirect(base_url());
        }

        $precoInicial = $this->input->get('precoInicial');
        $precoFinal = $this->input->get('precoFinal');
        $data['servicos'] = $this->Relatorios_model->servicosCustom($precoInicial, $precoFinal);
        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), true);
    }

    public function servicosRapid()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de serviços.');
            redirect(base_url());
        }

        $data['servicos'] = $this->Relatorios_model->servicosRapid();

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirServicos', $data, true);
        pdf_create($html, 'relatorio_servicos' . date('d/m/y'), true);
    }

    public function os()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de OS.');
            redirect(base_url());
        }
        $this->data['view'] = 'relatorios/rel_os';
        $this->load->view('tema/topo', $this->data);
    }

    public function osRapid()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de Ordem de Serviço.');
            redirect(base_url());
        }

        $data['os'] = $this->Relatorios_model->osRapid();
        $data['title'] = 'Relatório de Ordem de Serviço';

        $this->load->helper('mpdf');
        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), true, true);
    }

    public function osCustom()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'rOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para gerar relatórios de Ordem de Serviço.');
            redirect(base_url());
        }

        $dataInicial = $this->input->get('dataInicial');
        $dataFinal = $this->input->get('dataFinal');
        $cliente = $this->input->get('cliente');
        $responsavel = $this->input->get('responsavel');
        $status = $this->input->get('status');

        $this->load->helper('mpdf');

        $title = $status == null ? 'Todas' : $status;
        $user = $responsavel == null ? 'Não foi selecionado' : $this->Usuarios_model->get(1, intval($responsavel) - 1);

        $os = $this->Relatorios_model->osCustom($dataInicial, $dataFinal, $cliente, $responsavel, $status);
        $emitente = $this->Sos_model->getEmitente();
        $usuario = is_array($user) ? $user[0]->nome : $user;

        $data['title'] = 'Relatório de Ordem de Serviço - ' . $title;
        $data['os'] = $os;
        $data['res_nome'] = $usuario;

        $data['dataInicial'] = $dataInicial != null ? date('d-m-Y', strtotime($dataInicial)) : 'indefinida';
        $data['dataFinal'] = $dataFinal != null ? date('d-m-Y', strtotime($dataFinal)) : 'indefinida';

        if ($emitente) {
            $data['em_nome'] = $emitente[0]->nome;
            $data['em_cnpj'] = $emitente[0]->cnpj;
            $data['em_logo'] = $emitente[0]->url_logo;
            $data['topo'] = $this->load->view('relatorios/rel_os_topo', $data, true);
        }

        $html = $this->load->view('relatorios/imprimir/imprimirOs', $data, true);
        pdf_create($html, 'relatorio_os' . date('d/m/y'), true, true);
    }

}
