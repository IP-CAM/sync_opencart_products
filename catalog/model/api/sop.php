<?php
class ModelApiBaeli extends Model {
    public function __construct($object)
    {
        parent::__construct($object);
        $data = $this->getJson();
        $this->request->post = $data;
    }
    public function getJson()
    {
        $data = json_decode(file_get_contents('php://input'),true);
        return $data;
    }
    public function getAction()
    {
        $action=null;
        if(isset($this->request->post['action'])){
            $action = $this->request->post['action'];
        }
        return $action;
    }
    public function getProductData()
    {
        $product_data=array();
        if(isset($this->request->post['product_data'])){
            $product_data = $this->request->post['product_data'];
        }
        return $product_data;
    }

    public function getProductId()
    {
        $product_id=null;
        if(isset($this->request->post['product_id'])){
            $product_id = $this->request->post['product_id'];
        }
        return $product_id;
    }

    public function getProductQty()
    {
        $product_qty=null;
        if(isset($this->request->post['product_qty'])){
            $product_qty = $this->request->post['product_qty'];
        }
        return $product_qty;
    }

    public function getProductSku()
    {
        $product_sku=null;
        if(isset($this->request->post['product_sku'])){
            $product_sku = $this->request->post['product_sku'];
        }
        return $product_sku;
    }

    public function getServerId()
    {
        $server_id='';
        if(isset($this->session->data['server_id']) and $this->session->data['server_id']!==''){
            $server_id = $this->session->data['server_id'];
        }
        return $server_id;


    }
    public function isLogged()
    {
        if(isset($this->session->data['server_id']) and $this->session->data['server_id']!==''){
            return true;
        }
        return false;
    }
    public function isLogin()
    {
        if(isset($this->request->post['action'])and $this->request->post['action']=='login'){
            return true;
        }
        return false;
    }
    public function logout()
    {
        unset($this->session->data['server_id']);
        $this->session->data['server_id']='';
        return true;
    }
    public function validateLogin()
    {
        if(isset($this->request->post['username'])and $this->request->post['username']=='baeli_api_user'){
            if(isset($this->request->post['password'])and $this->request->post['password']=='hereputalongstriingasapassword'){
                $this->session->data['server_id']='baeli';
                return true;
            }
        }
        return false;
    }

}
