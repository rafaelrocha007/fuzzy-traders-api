<?php

namespace App\Controller;

class SessionController extends Controller
{
    public function processRequest()
    {
        switch ($this->method) {
            case 'POST':
                $response = $this->login($this->resourceId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) echo $response['body'];
    }

    public function login($cpf)
    {
        $result = $this->gateway->findByCpf($cpf);

        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
}
