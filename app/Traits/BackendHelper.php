<?php
namespace App\Traits;

trait BackendHelper{

    public function get_pathao_token()
    {
        $curl = curl_init();
        $token_postdata = [
            'client_id' => '1114',
            'client_secret' => 'uO4zJsLzcJA65IevRaYc69ERcTXmQqHHkMDmQxIc',
            'username' => 'monowa19@gmail.com',
            'password' => 'Monow@19',
            'grant_type' => 'password',
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/issue-token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($token_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $token_response = curl_exec($curl);
        $result = json_decode($token_response);
        $access_token = $result->access_token;


        return $access_token;
        // End Get City
    }

    public function create_pathao_order($r_name, $r_phone, $r_address, $r_city, $r_zone, $r_area, $d_type = 48, $item_type = 2, $add_note = '', $item_qty, $item_weight, $amount_to_collect = 0, $item_description = '')
    {
        $curl = curl_init();

        $create_order_postdata = [
            'store_id' => '338',
            'merchant_order_id' => '',
            'recipient_name' => $r_name,
            'recipient_phone' => $r_phone,
            'recipient_address' => $r_address,
            'recipient_city' => $r_city,
            'recipient_zone' =>  $r_zone,
            'recipient_area' => $r_area,
            'delivery_type' => $d_type, //48 for Normal Delivery, 12 for On Demand Delivery
            'item_type' => $item_type, //1 for document and 2 for parcel
            'special_instruction' => $add_note,
            'item_quantity' => $item_qty,
            'item_weight' => $item_weight,
            'amount_to_collect' => $amount_to_collect,
            'item_description' => $item_description,
        ];



        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($create_order_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "Authorization: Bearer ". $this->get_pathao_token(),
            ),
        ));

        $order_response = curl_exec($curl);
        $result = json_decode($order_response);

        return $result;
    }

    public function get_pathao_city()
    {
        $curl = curl_init();
        $token_postdata = [
            'client_id' => '1114',
            'client_secret' => 'uO4zJsLzcJA65IevRaYc69ERcTXmQqHHkMDmQxIc',
            'username' => 'monowa19@gmail.com',
            'password' => 'Monow@19',
            'grant_type' => 'password',
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/countries/1/city-list",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => json_encode($token_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $token_response = curl_exec($curl);
        $result_city = json_decode($token_response);

        return $result_city;
        // End Get City
    }

    public function get_pathao_zone($city_id)
    {
        $curl = curl_init();
        $token_postdata = [
            'client_id' => '1114',
            'client_secret' => 'uO4zJsLzcJA65IevRaYc69ERcTXmQqHHkMDmQxIc',
            'username' => 'monowa19@gmail.com',
            'password' => 'Monow@19',
            'grant_type' => 'password',
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/cities/$city_id/zone-list",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => json_encode($token_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $token_response = curl_exec($curl);
        $result = json_decode($token_response);

        return $result;
        // End Get City
    }

    public function get_pathao_area($zone_id)
    {
        $curl = curl_init();
        $token_postdata = [
            'client_id' => '1114',
            'client_secret' => 'uO4zJsLzcJA65IevRaYc69ERcTXmQqHHkMDmQxIc',
            'username' => 'monowa19@gmail.com',
            'password' => 'Monow@19',
            'grant_type' => 'password',
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/zones/$zone_id/area-list",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => json_encode($token_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $token_response = curl_exec($curl);
        $result = json_decode($token_response);

        return $result;
    }

    public function get_pathao_service_charge($product_weight, $recipient_city, $recipient_zone)
    {

        $curl = curl_init();
        $price_postdata = [
            'store_id' => '338',
            'item_type' => '2', //1 for document and 2 for parcel
            'delivery_type' => '48', //48 for Normal Delivery, 12 for On Demand Delivery
            'item_weight' => $product_weight,
            'recipient_city' => $recipient_city,
            'recipient_zone' => $recipient_zone,
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-hermes.pathaointernal.com/aladdin/api/v1/merchant/price-plan",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($price_postdata),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "Authorization: Bearer ". $this->get_pathao_token(),
            ),
        ));

        $token_response = curl_exec($curl);
        $result = json_decode($token_response);

        return $result;
    }

    //End
}
