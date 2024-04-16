<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
class DbHandler {
    protected $dbConnection;
    public function __construct() {
        $this->dbConnection = $this->databaseConnect();
    }

    protected function databaseConnect() {
        // Localhost
        $host = '103.147.154.162';
        $username = 'voucherp_phdkomunitas';
        $password = '9Lhufn@oyI1D2%ye';
        $database = 'voucherp_phdkomunitas';

        $connection = new mysqli($host, $username, $password, $database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $connection->set_charset("utf8mb4");
        // $connection->set_charset("utf8");

        return $connection;
    }

    protected function getCurrentUserId() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return null;
        }
    }
}
class GetOutlet extends DbHandler{
    public function viewOutlet(){
        if(isset($_POST['pincode']) && isset($_POST['outlet'])){
            $pincode = $_POST['pincode'];
            $outletId = $_POST['outlet'];

            $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT * FROM outlet WHERE idoutlet = '$outletId'"));
            // Add your logic here to compare $pincode with database values
            if(isset($data['idoutlet'])){
                $_SESSION['outletlink'] = $data['linkkomunitas'];
                $numericPart = filter_var($data['idoutlet'], FILTER_SANITIZE_NUMBER_INT);
                if($pincode === $numericPart){
                    return http_response_code(200);
                }else{
                    return http_response_code(401);
                }
            }else{
                return http_response_code(401);
            }
        } else {
            return http_response_code(401);
        }
    }
}

$new = new GetOutlet();
echo json_encode($new->viewOutlet());

?>