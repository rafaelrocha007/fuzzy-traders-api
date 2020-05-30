<?php

namespace App\Controller;

class Controller
{
    protected $method;
    protected $resourceId;
    protected $gateway;

    public function __construct($method, $resourceId, $gateway)
    {
        $this->method = $method;
        $this->resourceId = $resourceId;
        $this->gateway = $gateway;
    }

    public function processRequest()
    {
        switch ($this->method) {
            case 'GET':
                if ($this->resourceId) {
                    $response = $this->get($this->resourceId);
                } else {
                    $response = $this->getAll();
                }
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->update($this->resourceId);
                break;
            case 'DELETE':
                $response = $this->delete($this->resourceId);
                break;
            case 'OPTIONS':
                $response = $this->options();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) echo $response['body'];
    }

    private function getAll()
    {
        $result = $this->gateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function get($id)
    {
        $result = $this->gateway->find($id);

        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function create()
    {
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        $this->gateway->create($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function update($id)
    {
        $result = $this->gateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        $this->gateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function delete($id)
    {
        $result = $this->gateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $this->gateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    protected function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function options()
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = '';
        return $response;
    }
}
