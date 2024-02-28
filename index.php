<?php
// CROS PARA ABRIR URL NO NAVEGADOR

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

// REQUISIÇÃO E CONEXAO
include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$user = file_get_contents('php://input');
$method = $_SERVER['REQUEST_METHOD'];
switch($method) {

// LISTAR DADOS 

    case "GET":
    $sql = "SELECT * FROM users";
    $path = explode('/', $_SERVER['REQUEST_URI']);
    if(isset($path[3]) && is_numeric($path[3])) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $path[3]);
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
     }else{
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
    }
    echo json_encode($users);
    
    break;

       // INSERIR DADOS NO BANCO DE DADOS 

    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO users(id, nome, email, telefone) VALUES (null, :nome, :email, :telefone)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $user->nome);
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
        $sql = "UPDATE users SET nome =:nome, email =:email, telefone =:telefone WHERE id =:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':nome', $user->nome);
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
              
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $path[3]);              
              
                if($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Deletado com sucesso'];
                }else{
                    $response = ['status' => 0, 'message' => 'failed'];
                }
                echo json_encode($response);
                break;
           

}
