<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_payment  extends AIN_Service {

    public function __construct() {
      $this->_setParam = AIN::getParam('adnetwork.bank_of_baku');  
    }
    public function pay($aVals) 
	{
        $params = array();
        $params['amount'] = isset($aVals['amount']) ? $aVals['amount'] : 0;
        $params['phone'] = isset($aVals['phone']) ? $aVals['phone'] : '994552046244';
        $params['email'] = isset($aVals['email']) ? $aVals['email'] : getUserBy('email');
       // $params['user_id'] = isset($aVals['user_id']) ? $aVals['user_id'] : getUserBy('user_id');
        $params['description'] = isset($aVals['description']) ? $aVals['description'] : 'pending';			
        $params['cardType'] = isset($aVals['cardType']) ? $aVals['cardType'] : 0;
        $params['payFormType'] = ( AIN::getLib('request')->isOsId() == 1 ) ? 'DESKTOP' : 'MOBILE';
      	$params['successUrl'] = AIN::getParam('core.path')."_ajax/?core[ajax]=1&core[call]=video.payment_successUrl";

		$params['successUrl'] = AIN::getLib('url')->makeUrl('ad.wallet.info');
		$params['errorUrl'] = AIN::getLib('url')->makeUrl('ad.wallet.info');

		//payment_error
        $params['key'] = $this->_setParam['openKey']; //you open key
		ksort($params);
		 
        $sum = '';
        foreach ($params as $k => $v) {
            $sum .= (string) $v;
        }
        $sum .= $this->_setParam['privateKey']; //your private key
        $control_sum = md5($sum);
        $params['sum'] = $control_sum; //you open key
        
		$data = file_get_contents($this->_setParam['payUrl'] . http_build_query($params));
        $data = json_decode($data, true);
		$query = parse_url($data['paymentUrl'], PHP_URL_QUERY);
		parse_str($query, $query);
		$data['mdOrder'] = $query['mdOrder']; 
		
		if( $result['result'] !== 'success' )
		{
			$params['description'] .= $result['info'];
		}	
		
		$apiData = AIN::getService('video')->create_payment(
			array(
			  'id' => isset($data['id']) ? $data['id'] : 0,	
			  'order_id' => isset($data['mdOrder']) ? $data['mdOrder'] : 'error',	
			  'status_text' => $data['result'],						  
			  'user_id' => isset($aVals['user_id']) ? $aVals['user_id'] : getUserBy('user_id'),
			  'amount' => $params['amount'],			
			  'email' => $params['email'],			
			  'phone' => $params['phone'],			
			  'cardType' => $params['cardType'],			
			  'description' => $params['description'],			
			)
		);	
		
        return $data;
    }
	public function get_order_id( $id )
	{
        $params = array();
        $params['id'] = $id;
        $params['key'] = $this->_setParam['openKey']; //you open key
        ksort($params);
        $sum = '';
        foreach ($params as $k => $v) {
            $sum .= (string) $v;
        }
        $sum .= $this->_setParam['privateKey']; //your private key
        $control_sum = md5($sum);
        $params['sum'] = $control_sum; //you open key
		$data = file_get_contents($this->_setParam['statusUrl'] . http_build_query($params));
        $data = json_decode($data, true);	
		return $data;
	}

	
	
	
	
	
}

?>