<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LTCClient
{
  var $ci;
  var $RPC;

   public function __construct() {
     $this->ci =& get_instance();
     $litecoind_server =$this->ci->config->item('litecoind_server');
     $litecoind_port =$this->ci->config->item('litecoind_port');
     $litecoind_user =$this->ci->config->item('litecoind_user');
     $litecoind_password =$this->ci->config->item('litecoind_password');
     require_once('jsonRPCClient.php');
     $this->RPC = new \jsonRPCClient("http://$litecoind_user:$litecoind_password@$litecoind_server:$litecoind_port/");

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
