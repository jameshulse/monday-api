<?php

namespace TBlack\MondayAPI;

class MondayAPI implements ClientInterface
{
    private $APIV2_Token;
    private $API_Url     = "https://api.monday.com/v2/";

    function __construct($token = null)
    {
        if($token)
            $this->setToken($token);
    }

    public function setToken( Token $token )
    {
        $this->APIV2_Token = $token;
        return $this;
    }

    protected function content($type, $request, $variables = null)
    {
        $body = ['query' => $type.' { '.$request.' } '];

        if ($variables) {
            $body['variables'] = $variables;
        }

        return json_encode($body);
    }

    public function request($request, $type = 'query', $variables = null)
    {
        $headers = [
            'Content-Type: application/json',
            'User-Agent: [Tblack-IT] GraphQL Client',
            'Authorization: ' . $this->APIV2_Token->getToken()
        ];

        $data = @file_get_contents($this->API_Url, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => $headers,
                'content' => $this->content($type, $request, $variables),
            ]
        ]));

        return $this->response( $data );
    }

    protected function response( $data )
    {
        if(!$data)
            return false;

        $json = json_decode($data, true);

        if( isset($json['data']) ){
            return $json['data'];
        }else if( isset($json['errors']) && is_array($json['errors']) ){
            return $json['errors'];
        }

        return false;
    }
}

?>
