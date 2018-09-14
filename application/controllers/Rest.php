<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rest extends CI_Controller
{
    private $currency;
    private $account_name;

    public function __construct()
    {
        parent::__construct();
        $this->currency = $this-> input->post('currency');
        $account_name = $this->input->post('account_name');
        if (!(in_array($this->currency,  $this->config->item('monedas')))) {
            header('Content-Type: application/json');
            echo json_encode(array("mensaje"=>"Moneda $this->currency no soportada","error"=>1));
            die;
        }
        $this->account_name = $this->input->post('account_name');
        if ($this->account_name=="") {
            echo json_encode(array("mensaje"=>"Nombre de cuenta no suministrada","error"=>1));
            die;
        }
    }
    public function create_wallet()
    {
        header('Content-Type: application/json');
        try {
            $wallet=$this->currency.'Client';
            $this->load->library($wallet);
            $wallet=strtolower($wallet);
            echo json_encode(array("address"=>$this->$wallet->createaccount($this->account_name),"error"=>0));
        } catch (Exception $e) {
            echo json_encode(array("mensaje"=>$e->getMessage(),"error"=>1));
        }
    }

    public function consult_balance()
    {
        header('Content-Type: application/json');
        try {
            $wallet=$this->currency.'Client';
            $this->load->library($wallet);
            $wallet=strtolower($wallet);
            echo json_encode(array("balance"=>$this->$wallet->balance($this->account_name),"error"=>0));
        } catch (Exception $e) {
            echo json_encode(array("mensaje"=>$e->getMessage(),"error"=>1));
        }
    }

    public function get_coin_address()
    {
        header('Content-Type: application/json');
        try {
            $wallet=$this->currency.'Client';
            $this->load->library($wallet);
            $wallet=strtolower($wallet);
            echo json_encode(array("address"=>$this->$wallet->getaddress($this->account_name),"error"=>0));
        } catch (Exception $e) {
            echo json_encode(array("mensaje"=>$e->getMessage(),"error"=>1));
        }
    }

    public function transfer()
    {
        header('Content-Type: application/json');
        try {
          $destino = $this-> input->post('destino');
          if ($destino==""){
              echo json_encode(array("mensaje"=>"No se especifica destino","error"=>1));
              die;
          }
          $cantidad = $this->input->post('cantidad');
          if ($cantidad==""){
              echo json_encode(array("mensaje"=>"Cantidad erronea","error"=>1));
              die;
          }
            $wallet=$this->currency.'Client';
            $this->load->library($wallet);
            $wallet=strtolower($wallet);
            echo json_encode(array("tx"=>$this->$wallet->send($this->account_name,$destino,$cantidad),"error"=>0));
        } catch (Exception $e) {
            echo json_encode(array("mensaje"=>$e->getMessage(),"error"=>1));
        }
    }

    public function transaction_list()
    {
        header('Content-Type: application/json');
        try {
            $wallet=$this->currency.'Client';
            $this->load->library($wallet);
            $wallet=strtolower($wallet);
            echo json_encode(array("lista"=>$this->$wallet->listtransactions($this->account_name),"error"=>0));
        } catch (Exception $e) {
            echo json_encode(array("mensaje"=>$e->getMessage(),"error"=>1));
        }
    }
}
