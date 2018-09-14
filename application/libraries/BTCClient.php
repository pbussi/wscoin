<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BTCClient
{
  var $ci;
  var $RPC;

   public function __construct() {
     $this->ci =& get_instance();
     $bitcoind_server =$this->ci->config->item('bitcoind_server');
     $bitcoind_port =$this->ci->config->item('bitcoind_port');
     $bitcoind_user =$this->ci->config->item('bitcoind_user');
     $bitcoind_password =$this->ci->config->item('bitcoind_password');
     require_once('jsonRPCClient.php');
     $this->RPC = new \jsonRPCClient("http://$bitcoind_user:$bitcoind_password@$bitcoind_server:$bitcoind_port/");

   }
    public function createaccount($username)
    {
      $result = $this->RPC->getnewaddress($username);
      return $result;
    }
    public function balance($username)
    {
      $result = $this->RPC->getbalance($username);
      return $result;
    }
    public function getaddress($username)
    {
      $result = $this->RPC->getaccountaddress($username);
      return $result;
    }

    public function send($username,$to,$qty)
    {
      $result = $this->RPC->sendfrom($username,$to,$qty);
      return $result;
    }

    public function listtransactions($username)
    {
      $result = $this->RPC->listtransactions($username);
      return $result;
    }
}
