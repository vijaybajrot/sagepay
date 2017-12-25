<?php 
namespace Services\Sage;

use Services\Sage\SagepayFormApi;
use Services\Sage\SagepaySettings;
use Services\Sage\SagepayItem;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as HttpClient;

class SagePay
{
	private $api;
    protected $sageRequest;
    protected $config;
    public $paymentRequest;
    protected $basketItemsRequiredFields = array(
        'title',
       /* 'productSku',
        'productCode',*/
        'quantity',
        'amount',
        /* 'unitNetAmount',
         'unitTaxAmount',
         'unitGrossAmount',
         'totalGrossAmount'*/
    );

    protected $billingRequiredField = array(
        'firstname',
        "lastname",
        "address1",
        "city",
        "postcode",
        "country",
        "email",
    );

	function __construct(SagepayFormApi $api)
	{
		$this->api = $api;
        $this->init();
   }

    private function init()
    {
        $env = $this->api->config->env;
        $encryptionPassword = $this->api->config->getFormEncryptionPassword($env);
        $this->sageRequest = [ 
            'integrationType' => $this->api->integrationMethod,
            'fullUrl' => $this->api->config->siteFqdn[$env]."sage-payment",
            'siteFqdn' => $this->api->config->getSiteFqdn(),
            'env' => $env,
            'vendorName' => $this->api->config->getVendorName(),
            'currency' => $this->api->config->getCurrency(),
            'purchaseUrl' => $this->api->config->getPurchaseUrl('form', $env),
            'isEncryptionPasswordOk' => (!empty($encryptionPassword) && (strlen($encryptionPassword) == 16)),
        ];
  
    }

    public function create()
    {
        echo "hi";die;
    }

    public function config(array $config)
    {
        $this->config = $config;
        $this->sageRequest = array_merge($this->sageRequest,$this->config);
        return $this;
    }

    public function addBasketItems($items)
    {
        if(is_array($items)){
            foreach ($items as $itemKey => $item) {
                if(is_array($item)){
                    echo "It is multi array";
                }
                else{
                    /*if(!in_array($itemKey, $this->basketItemsRequiredFields)){
                        trigger_error("Item has required fields(".implode(',',$this->basketItemsRequiredFields).")");
                    }*/
                }
            }
            return $this->_addItemInBasket($items);
        }
        return $this;
    }

    private function _addItemInBasket($item)
    {
        $sageItem = new SagepayItem();
        $sageItem->setDescription($item["title"]);
        $sageItem->setProductCode(isset($item["taxAmount"]) ? $item["productCode"] : null);
        $sageItem->setProductSku(isset($item["taxAmount"]) ? $item["productSku"] : null);
        $sageItem->setUnitTaxAmount(isset($item["taxAmount"]) ? $item["taxAmount"] : 0);
        $sageItem->setQuantity(isset($item["quantity"]) ? $item["quantity"] : 1);
        $sageItem->setUnitNetAmount($item["amount"]);
        /*Add Item in Basket*/ 
        $this->api->basket->addItem($sageItem);
    }

    public function billing($billing)
    {
        if(is_array($billing)){
            if(!array_has($billing, $this->billingRequiredField)){
                trigger_error("Biiling has required fields(".implode(',',$this->billingRequiredField).")");
            }
        }
        $billingAddress = new \StdClass;
        $billingAddress->firstname = $billing['firstname'];
        $billingAddress->lastname = $billing['lastname'];
        $billingAddress->address1 = isset($billing['address1']) ? $billing['address1'] : null;
        $billingAddress->address2 = isset($billing['address2']) ? $billing['address2'] : null;
        $billingAddress->city = isset($billing['city']) ? $billing['city'] : null;
        $billingAddress->postcode = isset($billing['postcode']) ? $billing['postcode'] : null;
        $billingAddress->country = isset($billing['country']) ? $billing['country'] : null;
        $billingAddress->state = isset($billing['state']) ? $billing['state'] : null;
        $billingAddress->phone = isset($billing['phone']) ? $billing['phone'] : null; 
        $billingAddress->email = $billing['email']; 
        
        $this->api->createBilling($billingAddress);
        return $this;
    }

	private function _makePay()
	{
        $this->paymentRequest = array(
            'basket' => array(
                'items' => $this->api->basket->items,
                'deliveryGrossPrice' => number_format($this->api->basket->getDeliveryGrossAmount(), 2),
                'totalGrossPrice' => number_format($this->api->basket->getAmount(), 2),
            ),
            'request' => $this->api->createRequest((object) $this->config),
            'queryString' => htmlspecialchars(rawurldecode(utf8_encode($this->api->getQueryData()))),
            'billing' => $this->api->billing,
        );

        $this->sageRequest = array_merge($this->sageRequest,$this->paymentRequest);
	}

	public function processPayment()
	{
		if(count($this->api->basket->items) < 1){
            trigger_error("Basket Items is empty");
        }
        if(is_null($this->api->billing)){
            trigger_error("billing information is empty");
        }
        $this->_makePay();

        return $this->sageRequest;
	}

}