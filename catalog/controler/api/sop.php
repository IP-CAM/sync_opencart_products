<?php
class ControllerApiSop extends Controller {
    public function index() {
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        $this->load->model('api/sop');
        $this->load->model('account/customer');
        #$this->load->model('catalog/product');
        include_once(dirname(__FILE__). '/../../../admin/model/catalog/product.php');
        $this->load->model('api/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/manufacturer');
        $this->data['result']=array();
        $this->data['api_response']['result']='0';
        if ((strtoupper($this->request->server['REQUEST_METHOD']) == 'POST')) {
            if ($this->model_api_sop->isLogged()) {
                $this->data{'api_response'}['server_id']=$this->model_api_sop->getServerId();
                switch($this->model_api_sop->getAction()){
                    case 'get_category':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getCateforyId();
                        $category = $this->model_catalog_category->getCategory($this->model_api_sop->getCategoryId());
                        $this->data['api_response']['category']=$category;
                        break;
                    case 'get_categories':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        #$this->data{'api_response'}['product_id']=$this->model_api_sop->getCategoryId();
                        $categories = $this->model_catalog_category->getCategories();
                        $this->data['api_response']['categories']=$categories;
                        break;
                    case 'get_product':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getProduct($this->model_api_sop->getProductId());
                        $this->data['api_response']['product']=$product;
                        break;
                    case 'get_product_by_sku':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_sku']=$this->model_api_sop->getProductSku();
                        $product = $this->model_api_product->getProductBySku($this->model_api_sop->getProductSku());
                        $this->data['api_response']['php_storm']='is_awesome';
                        $this->data['api_response']['product']=$product;
                        break;

                    case 'update_product_qty':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->updateQty($this->model_api_sop->getProductId(),array('qty'=>$this->model_api_sop->getProductQty()));
                        $this->data['api_response']['product']=$product;
                        break;
                    case 'update_product':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getProduct($this->model_api_sop->getProductId());
                        #echo print_r($product,true) . PHP_EOL;
                        $product_data=$this->model_api_sop->getProductData();
                        #echo print_r($product_data,true) . PHP_EOL;
                        $product = array_merge($product,$product_data);
                        #echo print_r($product,true) . PHP_EOL;
                        #die;
                        $product_updated = $this->model_api_product->updateProduct($this->model_api_sop->getProductId(),$product);
                        $this->data['api_response']['product']=$product_updated;
                        break;


                    case 'get_product_options':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getProductOptions($this->model_api_sop->getProductId());
                        $this->data['api_response']['product_options']=$product;
                        break;
                    case 'get_products':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        #$this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getProducts();
                        $this->data['api_response']['products']=$product;
                        break;
                    case 'get_product_categories':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getCategories($this->model_api_sop->getProductId());
                        $this->data['api_response']['product_categories']=$product;
                        break;
                    case 'get_product_discounts':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_api_product->getProductDiscounts($this->model_api_sop->getProductId());
                        $this->data['api_response']['product_discounts']=$product;
                        break;

                    case 'get_manufacturers':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        #$this->data{'api_response'}['product_id']=$this->model_api_sop->getProductId();
                        $product = $this->model_catalog_manufacturer->getManufacturers();
                        $this->data['api_response']['manufacturers']=$product;
                        break;
                    case 'get_config':
                        $this->data{'api_response'}['action']=$this->model_api_sop->getAction();
                        $this->data['api_response']['config']=print_r($this->config,true);
                        break;
                    case 'logout':
                        $this->model_api_sop->logout();
                        $this->data['api_response']['result']='1';
                        $this->data{'api_response'}['message']='logout success';
                        break;
                }
            }else{
                if ($this->model_api_sop->isLogin()) {
                    if ($this->model_api_sop->validateLogin()) {
                        $this->data['api_response']['result']='1';
                        $this->data{'api_response'}['message']='login success';
                    }else{
                        $this->data{'api_response'}['message']='login failed';
                    }
                }else{
                    $this->data['api_response']['message']='Please login first';
                }
            }
        }else{
            $this->data['api_response']['message']='Please login';
        }
        $this->data['api_response']['code']='AX14';
        #$this->response->setOutput(htmlentities(json_encode($this->data['api_response'])));
        $this->response->setOutput(json_encode($this->data['api_response']));
    }
}
