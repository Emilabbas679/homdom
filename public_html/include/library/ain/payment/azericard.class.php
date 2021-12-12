<?php

defined('AIN') or exit('NO DICE!');

class ain_payment_azericard
{
    public function result(Request $request)
    {
        $order = $request->get("ORDER");
        $amount = $request->get("AMOUNT");

        $fp = fopen(public_path('text.txt'), 'a');//opens file in append mode
        fwrite($fp, $request->get('ORDER'));
        fclose($fp);

        return 'payment result page';
    }

    public function __construct()
    {
//        $this->terminal = '17202210';
//        $this->key_for_sign = '70e5f252f7cc6ae4a89d74bfe52c421b';
//        $this->url = 'https://mpi.3dsecure.az/cgi-bin/cgi_link';
//        $this->test_url = 'https://testmpi.3dsecure.az/cgi-bin/cgi_link';
//        $this->test_url2 = 'https://213.172.75.248/cgi-bin/cgi_link';


        $this->terminal = '17202290';
        $this->key_for_sign = '2bb56c8960985735e1327dc204f90cdd';
        $this->url = 'https://mpi.3dsecure.az/cgi-bin/cgi_link';
        $this->test_url = 'https://testmpi.3dsecure.az/cgi-bin/cgi_link';
        $this->test_url2 = 'https://213.172.75.248/cgi-bin/cgi_link';
    }

    public function refund($order_id)
    {
        $payment = Payment::where("payment_code", $order_id)->first();

        if ($payment->status == 'paid'){
            $subscription = Subscription::find($payment->subscription_id);
            $subscription->update([
                'status' => 'inactive',
                'activated_at' => null
            ]);
            $payment->update([
                'status' => "cancelled",
            ]);
        }



        $db_row['AMOUNT'] = $payment->amount;
        $db_row['CURRENCY'] = 'AZN';
        $db_row['ORDER'] = $order_id;
        $db_row['RRN'] = $payment->rrn;
        $db_row['INT_REF'] = $payment->int_ref;
        $db_row['TERMINAL'] = $this->terminal;		// That is your personal ID in payment system
        $db_row['TRTYPE'] = '22';					// That is the type of operation, 1 - Authorization and checkout
        //These fields are generated automaticaly every request
        $oper_time=gmdate("YmdHis");			// Date and time UTC
        $nonce=substr(md5(rand()),0,16);		// Random data
        $to_sign = "".strlen($db_row['ORDER']).$db_row['ORDER']
            .strlen($db_row['AMOUNT']).$db_row['AMOUNT']
            .strlen($db_row['CURRENCY']).$db_row['CURRENCY']
            .strlen($db_row['RRN']).$db_row['RRN']
            .strlen($db_row['INT_REF']).$db_row['INT_REF']
            .strlen($db_row['TRTYPE']).$db_row['TRTYPE']
            .strlen($db_row['TERMINAL']).$db_row['TERMINAL']
            .strlen($oper_time).$oper_time
            .strlen($nonce).$nonce;
        $key_for_sign = $this->key_for_sign; 				// Key for sign will change in production system
        $p_sign=hash_hmac('sha1',$to_sign, $this->yubi_hex2bin($key_for_sign));
        $data = array(
            'AMOUNT' => $db_row['AMOUNT'],
            'CURRENCY' => $db_row['CURRENCY'],
            'ORDER' => $db_row['ORDER'],
            'RRN' => $db_row['RRN'],
            'INT_REF' => $db_row['INT_REF'],
            'TERMINAL' => $db_row['TERMINAL'],
            'TRTYPE' => $db_row['TRTYPE'],
            'TIMESTAMP' => $oper_time,
            'NONCE' => $nonce,
            'P_SIGN' => $p_sign,
        );

        return $this->submitFormRefund($data);
    }

    public function auth($order_id,$amount)
    {
        // These fields will be change
        $db_row['AMOUNT'] = $amount;
        $db_row['CURRENCY'] = 'AZN';
        $db_row['ORDER'] = $order_id;
        // These fields will be always static
        $db_row['DESC'] = 'New Subscription';
        $db_row['MERCH_NAME'] = 'busy.az';
        $db_row['MERCH_URL'] = 'https://busy.az';
        $db_row['TERMINAL'] = $this->terminal;		// That is your personal ID in payment system
        $db_row['EMAIL'] = 'info@busy.az';
        $db_row['TRTYPE'] = '1';					// That is the type of operation, 1 - Authorization and checkout
        $db_row['COUNTRY'] = 'AZ';
        $db_row['MERCH_GMT'] = '+4';
        $db_row['BACKREF'] = 'https://busy.az/payment-result';
        //These fields are generated automaticaly every request
        $oper_time=gmdate("YmdHis");			// Date and time UTC
        $nonce=substr(md5(rand()),0,16);		// Random data
        $to_sign = "".strlen($db_row['AMOUNT']).$db_row['AMOUNT']
            .strlen($db_row['CURRENCY']).$db_row['CURRENCY']
            .strlen($db_row['ORDER']).$db_row['ORDER']
            .strlen($db_row['DESC']).$db_row['DESC']
            .strlen($db_row['MERCH_NAME']).$db_row['MERCH_NAME']
            .strlen($db_row['MERCH_URL']).$db_row['MERCH_URL']
            .strlen($db_row['TERMINAL']).$db_row['TERMINAL']
            .strlen($db_row['EMAIL']).$db_row['EMAIL']
            .strlen($db_row['TRTYPE']).$db_row['TRTYPE']
            .strlen($db_row['COUNTRY']).$db_row['COUNTRY']
            .strlen($db_row['MERCH_GMT']).$db_row['MERCH_GMT']
            .strlen($oper_time).$oper_time
            .strlen($nonce).$nonce
            .strlen($db_row['BACKREF']).$db_row['BACKREF'];
        $key_for_sign = $this->key_for_sign; 				// Key for sign will change in production system
        $p_sign=hash_hmac('sha1',$to_sign, $this->yubi_hex2bin($key_for_sign));
        $data = array(
            'AMOUNT' => $db_row['AMOUNT'],
            'CURRENCY' => $db_row['CURRENCY'],
            'ORDER' => $db_row['ORDER'],
            'DESC' => $db_row['DESC'],
            'MERCH_NAME' => $db_row['MERCH_NAME'],
            'MERCH_URL' => $db_row['MERCH_URL'],
            'TERMINAL' => $db_row['TERMINAL'],
            'EMAIL' => $db_row['EMAIL'],
            'TRTYPE' => $db_row['TRTYPE'],
            'COUNTRY' => $db_row['COUNTRY'],
            'MERCH_GMT' => $db_row['MERCH_GMT'],
            'TIMESTAMP' => $oper_time,
            'NONCE' => $nonce,
            'BACKREF' => $db_row['BACKREF'],
            'LANG' => 'AZ',
            'P_SIGN' => $p_sign,
        );
        return $this->submitForm($data);
    }


    public function submitFormRefund($data)
    {
        if ($data) {
            $form = "<form id='azericard' action='". $this->url."' method='post'>";
            $form .= "<input name=\"AMOUNT\" value=\"{$data['AMOUNT']}\" type=\"hidden\">
            <input name=\"CURRENCY\" value=\"{$data['CURRENCY']}\" type=\"hidden\">
            <input name=\"ORDER\" value=\"{$data['ORDER']}\" type=\"hidden\">
            <input name=\"RRN\" value=\"{$data['RRN']}\" type=\"hidden\">
            <input name=\"INT_REF\" value=\"{$data['INT_REF']}\" type=\"hidden\">
            <input name=\"TERMINAL\" value=\"{$data['TERMINAL']}\" type=\"hidden\">
            <input name=\"TRTYPE\" value=\"{$data['TRTYPE']}\" type=\"hidden\">
            <input name=\"TIMESTAMP\" value=\"{$data['TIMESTAMP']}\" type=\"hidden\">
            <input name=\"NONCE\" value=\"{$data['NONCE']}\" type=\"hidden\">
            <input name=\"P_SIGN\" value=\"{$data['P_SIGN']}\" type=\"hidden\">
            ";
            $form.="<script type=\"text/javascript\"> document.forms['azericard'].submit();</script>";
            echo $form;
        }
    }
    public function submitForm($data)
    {
        if ($data) {
            $form = "<form id='azericard' action='". $this->url."' method='post'>";
            $form .= "<input name=\"AMOUNT\" value=\"{$data['AMOUNT']}\" type=\"hidden\">
            <input name=\"CURRENCY\" value=\"{$data['CURRENCY']}\" type=\"hidden\">
            <input name=\"ORDER\" value=\"{$data['ORDER']}\" type=\"hidden\">
            <input name=\"DESC\" value=\"{$data['DESC']}\" type=\"hidden\">
            <input name=\"MERCH_NAME\" value=\"{$data['MERCH_NAME']}\" type=\"hidden\">
            <input name=\"MERCH_URL\" value=\"{$data['MERCH_URL']}\" type=\"hidden\">
            <input name=\"TERMINAL\" value=\"{$data['TERMINAL']}\" type=\"hidden\">
            <input name=\"EMAIL\" value=\"{$data['EMAIL']}\" type=\"hidden\">
            <input name=\"TRTYPE\" value=\"{$data['TRTYPE']}\" type=\"hidden\">
            <input name=\"COUNTRY\" value=\"{$data['COUNTRY']}\" type=\"hidden\">
            <input name=\"MERCH_GMT\" value=\"{$data['MERCH_GMT']}\" type=\"hidden\">
            <input name=\"TIMESTAMP\" value=\"{$data['TIMESTAMP']}\" type=\"hidden\">
            <input name=\"NONCE\" value=\"{$data['NONCE']}\" type=\"hidden\">
            <input name=\"BACKREF\" value=\"{$data['BACKREF']}\" type=\"hidden\">
            <input name=\"LANG\" value=\"AZ\" type=\"hidden\">
            <input name=\"P_SIGN\" value=\"{$data['P_SIGN']}\" type=\"hidden\">
            ";
            $form.="<script type=\"text/javascript\"> document.forms['azericard'].submit();</script>";
            echo $form;
        }
    }


    public function process(Request $request)
    {
        $fp = fopen(public_path('text.txt'), 'a');//opens file in append mode
        fwrite($fp, $request);
        fclose($fp);

        $oper_time = gmdate("YmdHis");
        $nonce=substr(md5(rand()),0,16);
        $Post_Data["AMOUNT"] = $request->get("AMOUNT");
        $Post_Data["CURRENCY"] = $request->get('CURRENCY');
        $Post_Data["ORDER"] = $request->get("ORDER");
        $Post_Data["RRN"] = $request->get("RRN");				// Bank's reference number
        $Post_Data["INT_REF"] = $request->get("INT_REF");
        $Post_Data["TERMINAL"] = $request->get("TERMINAL");
        $Post_Data["TRTYPE"] = "21"; 					 // TRTYPE=21 - Checkout
        $Post_Data["TIMESTAMP"] = $oper_time;
        $Post_Data["NONCE"] = $nonce;
        $to_sign = "".strlen($request->get('ORDER')).$request->get('ORDER').
            strlen($request->get('AMOUNT')).$request->get('AMOUNT').
            strlen($request->get('CURRENCY')).$request->get('CURRENCY').
            strlen($request->get('RRN')).$request->get('RRN').
            strlen($request->get('INTREF')).$request->get('INTREF').
            strlen("21")."21".
            strlen($request->get('TERMINAL')).$request->get('TERMINAL').
            strlen($oper_time).$oper_time.
            strlen($nonce).$nonce;
        $key_for_sign = $this->key_for_sign;    // Key for sign will change in production system
        $p_sign=hash_hmac('sha1',$to_sign, $this->yubi_hex2bin($key_for_sign));
        $Post_Data["P_SIGN"] = $p_sign;
        foreach($Post_Data as $key => $value){
            $Post[] = "$key=$value";
        }
        $Post = implode("&",$Post);


        if($request->get('ACTION') == "0") {
            $order = $request->get("ORDER");
            $amount = $request->get('AMOUNT');
            $payment = Payment::where('payment_code', $order)->first();
            if ($amount>= $payment->amount){
                $subscription = Subscription::find($payment->subscription_id);
                $subscription->update([
                    'status' => 'active',
                    'activated_at' => Carbon::now()
                ]);
                $payment->update([
                    'status' => "paid",
                    'rrn' => $request->get("RRN"),
                    'int_ref' => $request->get("INT_REF"),
                    "paid_at" => Carbon::now()
                ]);
            }
        }
        return $result = $this->get_web_page($this->url,$Post);
    }

    public function get_web_page( $url, $data_in ){
        $options = array(
            //CURLOPT_SSLVERSION     => 3,
            CURLOPT_RETURNTRANSFER => true,		// return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            //CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            //-------to post-------------
            CURLOPT_POST		   => true,
            CURLOPT_POSTFIELDS	   => $data_in,	//$data,
            CURLOPT_SSL_VERIFYPEER => false,    // DONT VERIFY
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CAINFO		   => "a.cer",
        );
        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }



    public function yubi_hex2bin($hexdata) {
        $bindata="";
        for ($i=0;$i<strlen($hexdata);$i+=2) {
            $bindata.=chr(hexdec(substr($hexdata,$i,2)));
        }
        return $bindata;
    }
}
?>