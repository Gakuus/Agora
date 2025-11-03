<?php
/* ============================================
   🔐 UTILIZA LAS CREDENCIALES CORRESPONDIENTES
   ============================================ */

class Database {
    private $conn;
    private $host     
    private $user   
    private $password  
    private $database 
    private $port     

    public function __construct() {
        // Crear conexión con MySQLi
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        // Verificar conexión
        if ($this->conn->connect_error) {
            error_log("❌ Error de conexión MySQLi: " . $this->conn->connect_error);
            $this->conn = null;
            return;
        }

        // Configurar charset
        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function isConnected() {
        return $this->conn && $this->conn->ping();
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Crear instancia global
$database = new Database();
$conn = $database->getConnection();

// Verificar conexión y redirigir si hay error
if (!$conn || !$database->isConnected()) {
    // Solo redirigir si no estamos en el login
    if (strpos($_SERVER['PHP_SELF'], 'index.php') === false && 
        strpos($_SERVER['PHP_SELF'], 'login.php') === false) {
        header("Location: ../index.php?error=db_conexion");
        exit();
    }
}
?>
