<?php

class Database {
    private $host = "localhost";
    private $port = "5432"; // Puerto por defecto de PostgreSQL
    private $db_name = "utsearch";
    private $username = "postgres";
    private $password = "bautista29";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Data Source Name (DSN) para PostgreSQL
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            // Crear la instancia de PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Configurar el manejo de errores para que lance excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Forzar el formato de retorno de datos como arreglos asociativos
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            // En producción, es mejor registrar esto en un log y no mostrar detalles al usuario
            echo "Error de conexión en UT-Search: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

// === EJEMPLO DE USO / SIMULACIÓN DE API ===
// Puedes probar este bloque interconsultando la base de datos

/*
require_html_headers_or_similar(); // Si fuera una API REST

$database = new Database();
$db = $database->getConnection();

if ($db) {
    // Ejemplo: Consultar la ubicación actual simulada del docente según su horario
    $query = "SELECT d.nombre AS docente, d.estado_disponibilidad, a.nombre AS aula, a.edificio 
              FROM docentes d
              LEFT JOIN horarios_docentes h ON d.id = h.docente_id
              LEFT JOIN aulas a ON h.aula_id = a.id
              WHERE d.num_empleado = :num_empleado";
              
    $stmt = $db->prepare($query);
    $stmt->execute(['num_empleado' => 'DOC202601']);
    
    $resultado = $stmt->fetch();
    
    // Imprimir en formato JSON para que sea consumido por Angular 17
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "success",
        "data" => $resultado
    ]);
}
*/