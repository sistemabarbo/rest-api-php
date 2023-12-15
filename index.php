<?php
// CROS PARA ABRIR URL NO NAVEGADOR

header("Access-Control-Allow_Origin: *");
header("Access-Control-Allow_Headers: *");
header("Access-Control-Allow_Methods: *");

// REQUISIÇÃO E CONEXAO
include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$user = file_get_contents('php://input');
$method = $_SERVER['REQUEST_METHOD'];
switch($method) {

// LISTAR DADOS 

    casse "GET":
    $sql = "SELECT * FROM users";
    $path = explode('/', $_SERVER['REQUEST_URI']);
    if(isset($path[3]) && is_nuemric($path[3])) {
        $sql .= "WHERE id = :id";
        $stmt->prepare($sql);
        $stmt->bindParam(':id', $path[3]);
    }else{
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($user);
    break;

       // INSERIR DADOS NO BANCO DE DADOS 

    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO users(id, name, email, telefone) VALUES (null, :name, :email, :telefone)";
        $conn->prepare($sql);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':telefone', $user->telefone);
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created'];
        }else{
            $response = ['status' => 0, 'message' => 'failed'];
        }
        break;

        // ATUALIZAR DADOS

    case "PUT":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "UPDATE users SET name = :name, email = :email, telefone = :telefone WHERE id = :id)";
        $conn->prepare($sql);
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':telefone', $user->telefone);
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Atualizado com sucesso'];
        }else{
            $response = ['status' => 0, 'message' => 'failed'];
        }
        echo json_encode($response);
        break;
        
        // DELETANDO DADOS DO BANCO DE DADOS

        case "DELETE":
            $sql = "DELETE FROM users WHERE id = :id";
            $path = explode('/', $_SERVER['REQUEST_URI']);
           
                $sql .= "WHERE id = :id";
                $stmt->prepare($sql);
                $stmt->bindParam(':id', $path[3]);
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                if($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Deletado com sucesso'];
                }else{
                    $response = ['status' => 0, 'message' => 'failed'];
                }
                echo json_encode($response);
                break;
           

}