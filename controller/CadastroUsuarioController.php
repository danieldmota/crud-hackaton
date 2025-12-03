<?php

require_once __DIR__ . '/../models/ClientModel.php';

class ClientController
{
    private $model;

    public function __construct()
    {
        $this->model = new ClientModel();
    }

    public function registerClient()
    {
        // Verificar se é uma requisição POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responseJSON(['error' => true, 'message' => 'Método inválido.']);
            return;
        }

        // Campos obrigatórios
        $requiredFields = ['restaurant_name', 'cpf', 'phone', 'email', 'password', 'confirm_password'];

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $this->responseJSON([
                    'error' => true,
                    'message' => "O campo {$field} é obrigatório."
                ]);
                return;
            }
        }

        // Verificar senha
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $this->responseJSON(['error' => true, 'message' => 'As senhas não coincidem.']);
            return;
        }

        // Verificar CPF existente
        if ($this->model->checkCpfExists($_POST['cpf'])) {
            $this->responseJSON(['error' => true, 'message' => 'CPF já está cadastrado.']);
            return;
        }

        // Verificar e-mail existente
        if ($this->model->checkEmailExists($_POST['email'])) {
            $this->responseJSON(['error' => true, 'message' => 'E-mail já está cadastrado.']);
            return;
        }

        // Upload da imagem
        $fotoPerfil = null;
        if (!empty($_FILES['restaurant_image']['name'])) {
            $upload = $this->uploadImage($_FILES['restaurant_image']);

            if ($upload['error']) {
                $this->responseJSON($upload); // Retorna erro de upload
                return;
            }

            $fotoPerfil = $upload['file'];
        }

        $data = [
            'nome_completo' => trim($_POST['restaurant_name']),
            'cpf' => trim($_POST['cpf']),
            'foto_perfil' => $fotoPerfil,
            'telefone' => trim($_POST['phone']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password']
        ];

        // Tentar cadastrar
        $result = $this->model->createClient($data);

        if (is_array($result) && isset($result['error']) && $result['error'] === true) {
            $this->responseJSON($result);
            return;
        }

        $this->responseJSON([
            'error' => false,
            'message' => 'Cadastro realizado com sucesso! Você já pode fazer login.'
        ]);
    }

    private function uploadImage($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; // 5 MB

        if ($file['size'] > $maxSize) {
            return ['error' => true, 'message' => 'Arquivo muito grande. Tamanho máximo: 5MB.'];
        }

        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => true, 'message' => 'Formato inválido. Envie JPG ou PNG.'];
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid('cliente_') . '.' . $ext;

        $uploadDir = __DIR__ . '/../uploads/clientes/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fullPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            return ['error' => false, 'file' => 'uploads/clientes/' . $newName];
        } else {
            return ['error' => true, 'message' => 'Erro ao fazer upload da imagem.'];
        }
    }

    /**
     * Retorna resposta em JSON
     */
    private function responseJSON($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
