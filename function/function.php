<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DbHandler {
    protected $dbConnection;
    public function __construct() {
        $this->dbConnection = $this->databaseConnect();
    }

    protected function databaseConnect() {
        // Put your mysql Server settings here
        $host = 'ip';
        $username = 'username';
        $password = 'password';
        $database = 'databasename';

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
}class ExcelExporter extends DbHandler
{
    private function fetchData()
    {
        $sql = "SELECT phonenumber, idoutlet FROM phonebook";
        $result = $this->dbConnection->query($sql);

        if (!$result) {
            die("Error fetching data: " . $this->dbConnection->error);
        }

        return $result;
    }

    public function exportToExcel()
    {
        $result = $this->fetchData();

        if ($result->num_rows > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Phone Number');
            $sheet->setCellValue('B1', 'Outlet ID');

            $row = 2;

            while ($row_data = $result->fetch_assoc()) {
                $sheet->setCellValue('A' . $row, $row_data['phonenumber']);
                $sheet->setCellValue('B' . $row, $row_data['idoutlet']);
                $row++;
            }

            $result->free(); // Free the result set

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="phonebook_data.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit(); // Ensure script execution stops after saving the file
        } else {
            echo "No data found in the phonebook table.";
        }

        $this->dbConnection->close();
    }

    private function fetchDatabyOutlet($outlet)
    {
        
        $sql = "SELECT phonenumber, idoutlet FROM phonebook WHERE idoutlet='$outlet'";
        $result = $this->dbConnection->query($sql);

        if (!$result) {
            die("Error fetching data: " . $this->dbConnection->error);
        }

        return $result;
    }

    public function exportToExcelOutlet()
    {
        $outlet = $_POST['outlet'];
        $result = $this->fetchDatabyOutlet($outlet);

        if ($result->num_rows > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Phone Number');
            $sheet->setCellValue('B1', 'Outlet ID');

            $row = 2;

            while ($row_data = $result->fetch_assoc()) {
                $sheet->setCellValue('A' . $row, $row_data['phonenumber']);
                $sheet->setCellValue('B' . $row, $row_data['idoutlet']);
                $row++;
            }

            $result->free(); // Free the result set

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$outlet.'.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit(); // Ensure script execution stops after saving the file
        } else {
            echo "No data found in the phonebook table.";
        }

        $this->dbConnection->close();
    }
}
class LoadMe extends DbHandler{
    public function LoadUser(){
        $query = mysqli_fetch_assoc(mysqli_query($this->dbConnection,"SELECT * FROM users where id = {$_SESSION['user']['id']}"));
        return $query;

    }
}
class MyProfile extends DbHandler{
    public $response; // Make $response public
    private $myid,$FullName, $Password, $Password_Confirm;

    public function __construct($myid,$FullName, $Password, $Password_Confirm) {
        parent::__construct();
        $this->myid = $myid;
        $this->FullName = $FullName;
        $this->Password = $Password;
        $this->Password_Confirm = $Password_Confirm;
    }
    function Profile(){
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT * from users"));
        return $data['Total'];
    }
    private function encryptPassword($Password) {
        return password_hash($Password, PASSWORD_DEFAULT);
    }

    private function checkRegistrationData($Password, $Password_Confirm) {
        $errors = [];

        if (empty($Password)) {
            $errors['Password'] = 'Kata Sandi tidak boleh kosong';
        }

        if ($Password !== $Password_Confirm) {
            $errors['Password_confirmation'] = 'Ulangi Kata Sandi tidak sesuai';
        }

        return $errors;
    }

    public function updateProfile() {
        $errors = $this->checkRegistrationData($this->Password, $this->Password_Confirm);

        if (!empty($errors)) {
            $this->response = [
                'status' => 'error',
                'message' => 'Invalid input data',
                'errors' => $errors
            ];
        } elseif($this->Password && $this->Password_Confirm) {
            $hashedPassword = $this->encryptPassword($this->Password);

            $query = "UPDATE users SET Fullname = '$this->FullName', password = '$hashedPassword' WHERE id = '{$this->myid}'";

            if ($this->dbConnection->query($query)) {
                return true;
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Registration failed',
                    'error_message' => $this->dbConnection->error
                ];
            }
        }else{
            $query = "UPDATE users SET Fullname = '$this->FullName' WHERE id = '{$this->myid}'";

            if ($this->dbConnection->query($query)) {
                return true;
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Registration failed',
                    'error_message' => $this->dbConnection->error
                ];
            }
        }
    }
}
class Users extends DbHandler{

    function TotalAdmins(){
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT count(*) as Total from users"));
        return $data['Total'];
    }

    function ListAdminId(){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM users");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);
        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from users LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;
    }

    function carikan(){
        $word = $_POST['search'];
        header("Location: ?p=1&search=".$word);
    }
    
    function cariAdmin($keyword){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM users where Fullname LIKE '%$keyword%'");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);

        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from users where Fullname LIKE '%$keyword%' LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;

    }
    
    public function deleteAdmin($idAdmin, $redirect) {
        // Sanitize the input
        $idAdmin = $this->dbConnection->real_escape_string($idAdmin);
        $redirect = $this->dbConnection->real_escape_string($redirect);

        // Delete the phone number from the database
        $deleteQuery = "DELETE FROM users WHERE id = '$idAdmin'";
        
        if ($this->dbConnection->query($deleteQuery)) {
            // Phone number successfully deleted
            header("Location: $redirect");
            return ['status' => 'success', 'message' => 'Phone number deleted successfully'];
        } else {
            // Error in the deletion process
            return ['status' => 'error', 'message' => 'Failed to delete phone number'];
        }
    }
}

class Viewnumber extends DbHandler{
    public function viewOutlet($idOutlet){
        $id = strtoupper($idOutlet);
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT * FROM outlet WHERE idoutlet = '$id'"));
        return $data;
    }
    function ListNumberbyId($idOutlet){
        $id = strtoupper($idOutlet);
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook where idoutlet='{$id}'");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);
        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        if(isset($_GET['short']) && strtolower($_GET['short']) === "asc"){
            $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where idoutlet='{$id}' LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        }else{
            $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where idoutlet='{$id}' ORDER BY date DESC LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        }
        return $ListNumber;
    }

    function carikan(){
        $word = $_POST['search'];
        $kode = $_GET['outlet'];
        
        if(isset($_GET['short']) && strtolower($_GET['short']) === "asc"){
            header("Location: ?outlet=".$kode."&p=1&search=".$word);
        }else{
            header("Location: ?outlet=".$kode."&p=1&search=".$word."&short=desc");
        }
    }
    function cariNumber($keyword,$idoutlet){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook where phonenumber LIKE '%$keyword%' AND idoutlet = '$idoutlet'");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);

        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where phonenumber LIKE '%$keyword%' AND idoutlet = '$idoutlet' LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;

    }
}
class InputFront extends DbHandler {
    public function updateContent($title,$content,$website,$mobile) {
        $content = $this->dbConnection->real_escape_string($content);
        $title = $this->dbConnection->real_escape_string($title);
    
        // Handle image upload
        $imagePathwebsite = $this->uploadwebsite($website);
        $imagePathmobile = $this->uploadmobile($mobile);
    
        if ($imagePathwebsite === false) {
            // Handle the case where image upload fails
            return false;
        }
        if ($imagePathmobile === false) {
            // Handle the case where image upload fails
            return false;
        }
    
        if($website && $mobile){
            $updateQuery = "UPDATE frontpage SET Title = '$title',Words = '$content', Website = '$imagePathwebsite', Mobile = '$imagePathmobile'  WHERE id = '1'";
        }elseif($mobile){
            $updateQuery = "UPDATE frontpage SET Title = '$title',Words = '$content', Mobile = '$imagePathmobile'  WHERE id = '1'";
        }elseif($website){
            $updateQuery = "UPDATE frontpage SET Title = '$title',Words = '$content', Website = '$imagePathwebsite'  WHERE id = '1'";
        }else{
            $updateQuery = "UPDATE frontpage SET Title = '$title',Words = '$content' WHERE id = '1'";
        }
    
        if ($this->dbConnection->query($updateQuery)) {
            // Data successfully updated
            return true;
        } else {
            // Error in the update process
            return false;
        }
    }
    private function uploadwebsite($website) {
        if (!$website) {
            // No file uploaded
            return null;
        }
    
        $uploadDirectory = '../images/upload/'; // Adjust this to your actual upload directory
        $targetFile = $uploadDirectory . basename($website['name']);
    
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($website['tmp_name'], $targetFile)) {
            return basename($website['name']);
        } else {
            // Handle the case where file move fails
            return false;
        }
    }
    private function uploadmobile($mobile) {
        if (!$mobile) {
            // No file uploaded
            return null;
        }
    
        $uploadDirectory = '../images/upload/'; // Adjust this to your actual upload directory
        $targetFile = $uploadDirectory . basename($mobile['name']);
    
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($mobile['tmp_name'], $targetFile)) {
            return basename($mobile['name']);
        } else {
            // Handle the case where file move fails
            return false;
        }
    }
    
    public function loadData(){
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT * from frontpage"));
        return $data;
    }
}

class outletClass extends DbHandler{
    public function getOutlet(){
        $query = "SELECT * FROM `outlet`";
        $result = $this->dbConnection->query($query);
    
        $outlets = [];
    
        while ($row = $result->fetch_assoc()) {
            $outlets[] = $row;
        }
    
        return $outlets;
    }
    public function getDatanonVerified($id) {
        $query = "SELECT COUNT(*) AS totalUsers FROM phonebook where idoutlet='$id'";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalUsers'];
        } else {
            return false;
        }
    }
}

class Phonebook extends DbHandler{
    public function getPaginatedOutlets($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
    
        $query = "SELECT *  FROM phonebook  WHERE phonebook.verifieduser = 1 LIMIT $offset, $perPage";
    
        $result = $this->dbConnection->query($query);
    
        $outlets = [];
    
        while ($row = $result->fetch_assoc()) {
            $outlets[] = $row;
        }
    
        return $outlets;
    }
    public function deletePhoneNumber($phoneNumber, $redirect) {
        // Sanitize the input
        $phoneNumber = $this->dbConnection->real_escape_string($phoneNumber);
        $redirect = $this->dbConnection->real_escape_string($redirect);

        // Delete the phone number from the database
        $deleteQuery = "DELETE FROM phonebook WHERE phonenumber = '$phoneNumber'";
        
        if ($this->dbConnection->query($deleteQuery)) {
            // Phone number successfully deleted
            header("Location: $redirect");
            return ['status' => 'success', 'message' => 'Phone number deleted successfully'];
        } else {
            // Error in the deletion process
            return ['status' => 'error', 'message' => 'Failed to delete phone number'];
        }
    }
    function TotalInValid(){
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT count(id) as Total from phonebook where verifieduser = 0;"));
        return $data['Total'];
    }
    function ListInvalid(){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook where verifieduser=0");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);
        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where verifieduser=0 LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;
    }

    function carikanInvalid(){
        $word = $_POST['search'];
        header("Location: ?p=1&search=".$word);
    }
    
    function cariNumberInvalid($keyword){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook where phonenumber LIKE '%$keyword%' and verifieduser=0");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);

        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where phonenumber LIKE '%$keyword%' and verifieduser=0 LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;

    }
    
    function TotalValid(){
        $data = mysqli_fetch_assoc(mysqli_query($this->dbConnection, "SELECT count(id) as Total from phonebook"));
        return $data['Total'];
    }
    function ListValid(){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);
        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        if(isset($_GET['short']) && strtolower($_GET['short']) === "asc"){
            $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        }else{
            $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook ORDER BY date DESC LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        }
        
        return $ListNumber;
    }

    function carikanValid(){
        $word = $_POST['search'];
        if(isset($_GET['short']) && strtolower($_GET['short']) === "asc"){
            header("Location: ?p=1&search=".$word);
        }else{
            header("Location: ?p=1&search=".$word."&short=desc");
        }
    }
    
    function cariNumberValid($keyword){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM phonebook where phonenumber LIKE '%$keyword%'");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);

        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from phonebook where phonenumber LIKE '%$keyword%' LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;

    }
}
class VoucherHandler extends DbHandler {
    public function generateVoucher($phoneNumber, $idOutlet) {
        // Generate a unique voucher code (You may customize this logic based on your requirements)
        $voucherCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        $_SESSION['vouchers'] = $voucherCode;

        // Set starting date as the current date
        $startDate = date('Y-m-d');

        // Calculate expired date as current date + 7 days
        $expiredDate = date('Y-m-d', strtotime($startDate . ' + 7 days'));

        // Insert voucher details into the database
        $insertQuery = "INSERT INTO voucher (phonenumber, voucher, idoutlet, verification, startdate, expireddate) 
                        VALUES ('$phoneNumber', '$voucherCode', '$idOutlet', 0, '$startDate', '$expiredDate')";

        if ($this->dbConnection->query($insertQuery)) {
            // Voucher successfully generated and inserted into the database
            return $voucherCode;
        } else {
            // Error in the insert process
            return false;
        }
    }
    public function claimVoucher($voucher, $passcode) {
        // Validate the passcode against the idoutlet
        $idOutlet = $this->getIdOutletByPasscode($passcode);
    
        if (!$idOutlet) {
            // Invalid passcode, handle accordingly
            return ['status' => 'error', 'message' => 'Invalid passcode'];
        }
    
        // Check if a voucher exists for the given phone number and idoutlet
        $voucherQuery = "SELECT * FROM voucher WHERE Voucher = '$voucher'";
        $getVoucher = $this->dbConnection->query($voucherQuery);
    
        if (!$getVoucher) {
            // Handle the case where the query fails
            return ['status' => 'error', 'message' => 'Database error'];
        }
    
        $rowVoucher = $getVoucher->fetch_assoc();
        
        $query = "UPDATE `phonebook` SET `verifieduser` = '1' WHERE `phonebook`.`phonenumber` = '{$rowVoucher['Phonenumber']}'";
        $result = $this->dbConnection->query($query);
    
        if (!$result) {
            // Handle the case where the database update failed
            echo 'Database update failed';
        }
    
        if (!$rowVoucher) {
            // Voucher not found
            return ['status' => 'error', 'message' => 'Voucher not found'];
        }
    
        if ($rowVoucher['Verification'] == 1) {
            return ['status' => 'error', 'message' => 'Voucher already claimed'];
        } elseif ($rowVoucher['ExpiredDate'] < date('Y-m-d H:i:s')) {
            return ['status' => 'error', 'message' => 'Failed Voucher Expired'];
        } elseif($idOutlet !== $rowVoucher['idoutlet']){
            return ['status' => 'error', 'message' => 'Passcode yang dimasukkan salah'];
            
        }
    
        // Continue with the voucher claiming logic
        $updateQuery = "UPDATE voucher SET Verification = 1, claimdate = NOW() WHERE Voucher = '$voucher' AND idoutlet = '$idOutlet'";
    
        if ($this->dbConnection->query($updateQuery)) {
            // Voucher successfully claimed
            header("Location: Redemed");
            exit; // Ensure script stops execution after redirect
        } else {
            // Error in the update process
            return ['status' => 'error', 'message' => 'Failed to update voucher status'];
        }
    }

    private function getIdOutletByPasscode($passcode) {
        // You need to implement the logic to retrieve idoutlet based on the passcode
        // Replace this with your actual logic to verify the passcode
        // Example: $idOutlet = retrieveIdOutletByPasscode($passcode);
        // For demonstration purposes, assuming passcode is directly used as idoutlet
        $idOutlet = $passcode;

        return $idOutlet;
    }
}
class sender extends DbHandler{
    private $phone, $templateId;

    public function __construct($phone, $templateId) {
        parent::__construct();
        $this->phone = $phone;
        $this->templateId = $templateId;
    }

    private function checkuser() {
        $query = "SELECT * FROM outlet WHERE idoutlet = '{$this->templateId}'";
        $result = $this->dbConnection->query($query);

        if ($result) {
            $row = $result->fetch_assoc();

            if ($row) {
                return $row;
            }
        }

        return false;
    }
    
    
    public function sendTextMessageFromUrl() {
        $idtemplate = $this->checkuser();
        $url = 'https://api.fonnte.com/send'; // Replace with your actual API endpoint

        // Build the payload data
        $payload = array(
            'target' => $this->phone,
            'message' => $idtemplate['Words'] . ' Voucher: https://'. $_SERVER['SERVER_NAME'].'/Redeme?voucher='. $_SESSION['vouchers'],
            'file' => new CURLFile($idtemplate['Gambar']),
            'countryCode' => '62', // optional
        );

        // Set up the cURL options
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                'Authorization: 95FakESY-iS9c3w5y3tJ', // Replace with your actual token
            ),
        ));

        try {
            // Execute the cURL request
            $response = curl_exec($curl);

            if ($response === false) {
                throw new Exception(curl_error($curl));
            }

            // Check HTTP status code
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode >= 400) {
                throw new Exception('Request failed');
            }

            // Decode the response
            $data = json_decode($response, true);

            // Check if the message sending was successful
            if (isset($data['success']) && $data['success']) {
                // Redirect to the dashboard with the query parameters
                header("Location: {$idtemplate['linkkomunitas']}");
                exit;
            } else {
                // Handle the case where sending failed
                header("Location: {$idtemplate['linkkomunitas']}");
                exit;
            }
        } catch (Exception $error) {
            echo $error->getMessage();
        } finally {
            // Close cURL session
            curl_close($curl);
        }
    }
    
}

class OutletHandler extends DbHandler {
    public $response; // Make $response public

    public function checkOutletExists($idoutlet) {
        $idoutlet = $this->dbConnection->real_escape_string($idoutlet);

        $query = "SELECT COUNT(*) as count FROM outlet WHERE idoutlet = '$idoutlet'";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'] > 0; // Return true if the outlet exists
        }

        return false;
    }
    public function deleteOutlet($id, $redirect) {
        // Sanitize the input
        $id = $this->dbConnection->real_escape_string($id);
        $redirect = $this->dbConnection->real_escape_string($redirect);

        // Delete the phone number from the database
        $deleteQuery = "DELETE FROM outlet WHERE id = '$id'";
        
        if ($this->dbConnection->query($deleteQuery)) {
            // Phone number successfully deleted
            header("Location: $redirect");
            return ['status' => 'success', 'message' => 'Phone number deleted successfully'];
        } else {
            // Error in the deletion process
            return ['status' => 'error', 'message' => 'Failed to delete phone number'];
        }
    }
    public function getAllData() {
        $query = "SELECT COUNT(*) AS totaloutlet FROM outlet";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['totaloutlet'];
        } else {
            return false;
        }
    }
    public function updateOutlet($myid, $idoutlet, $outletName, $linkKomunitas) {
        $idoutlet = $this->dbConnection->real_escape_string($idoutlet);
        $outletName = $this->dbConnection->real_escape_string($outletName);
        $linkKomunitas = $this->dbConnection->real_escape_string($linkKomunitas);
        $updateQuery = "UPDATE outlet SET outlatename = '$outletName', linkkomunitas = '$linkKomunitas' WHERE id = '$myid'";
        if ($this->dbConnection->query($updateQuery)) {
            // Data successfully updated
            return true;
        } else {
            // Error in the update process
            return false;
        }
    }
    
    private function uploadImage($file) {
        if (!$file) {
            // No file uploaded
            return null;
        }
    
        $uploadDirectory = '../images/upload/'; // Adjust this to your actual upload directory
        $targetFile = $uploadDirectory . basename($file['name']);
    
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            // Handle the case where file move fails
            return false;
        }
    }    
    
    public function getOutletById($idoutlet) {
        $idoutlet = $this->dbConnection->real_escape_string($idoutlet);

        $query = "SELECT * FROM outlet WHERE id = '$idoutlet'";
        $result = $this->dbConnection->query($query);

        return $result->fetch_assoc();
    }
    
    function Listoutlet(){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM outlet");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);
        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from outlet LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;
    }

    function carikanOutlet(){
        $word = $_POST['search'];
        header("Location: ?p=1&search=".$word);
    }
    
    function cariidOutlet($keyword){
        // Pagination
        $GLOBALS['jlhdataperhalaman'] = 10;
        $data = mysqli_query($this->dbConnection, "SELECT * FROM outlet where idoutlet LIKE '%$keyword%' OR outlatename LIKE '%$keyword%'");
        $GLOBALS['jumlahdata'] = mysqli_num_rows($data);

        $GLOBALS['jmlhhalaman'] = ceil($GLOBALS['jumlahdata'] / $GLOBALS['jlhdataperhalaman']);
        $GLOBALS['halamanaktif'] = (isset($_GET['p'])) ? $_GET['p'] : 1;

        $GLOBALAS['awalData'] = ($GLOBALS['jlhdataperhalaman'] * $GLOBALS['halamanaktif']) - $GLOBALS['jlhdataperhalaman'];
        // $GLOBALS['totaldata'] = mysqli_num_rows($result);
        $ListNumber = mysqli_query($this->dbConnection, "SELECT * from outlet where idoutlet LIKE '%$keyword%' OR outlatename LIKE '%$keyword%' LIMIT {$GLOBALAS['awalData']},{$GLOBALS['jlhdataperhalaman']}");
        return $ListNumber;

    }
    public function inputOutlet($idoutlet, $outletName, $linkKomunitas) {
        
        $idoutlet = $this->dbConnection->real_escape_string($idoutlet);
        $outletName = $this->dbConnection->real_escape_string($outletName);
        $linkKomunitas = $this->dbConnection->real_escape_string($linkKomunitas);
        
        $updateQuery = "INSERT INTO outlet (idoutlet, outlatename, linkkomunitas) VALUES ('$idoutlet', '$outletName', '$linkKomunitas')";
    
        if ($this->dbConnection->query($updateQuery)) {
            // Data successfully updated
            return true;
        } else {
            // Error in the update process
            return false;
        }
    }
}



class ClaimInstance extends DbHandler {
    private $Phonenumber, $idoutlet;

    public function __construct($Phonenumber, $idoutlet) {
        parent::__construct();
        $this->Phonenumber = $Phonenumber;
        $this->idoutlet = $idoutlet;
    }

    private function CheckNumber($Phonenumber) {
        $Phonenumber = $this->dbConnection->real_escape_string($Phonenumber);
    
        $query = "SELECT COUNT(*) as count FROM phonebook WHERE phonenumber = ?";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bind_param("s", $Phonenumber);
        $stmt->execute();
    
        // Bind the result variable
        $stmt->bind_result($count);
    
        // Fetch the result
        $stmt->fetch();
    
        // Close the statement
        $stmt->close();
    
        // Check the count
        return $count == 0;
    }


    public function inputdata() {
        if ($this->CheckNumber($this->Phonenumber)) {
            // The phone number does not exist, proceed to insert data or perform other actions
            $this->Phonenumber = $this->dbConnection->real_escape_string($this->Phonenumber);
            $currentDateTime = date('Y-m-d H:i:s');

            // Assuming you have other fields to insert, modify the query accordingly
            $insertQuery = "INSERT INTO phonebook (phonenumber, idoutlet, verifieduser, date) VALUES (?, ?, 0, ?)";
            $stmt = $this->dbConnection->prepare($insertQuery);
            $stmt->bind_param("sss", $this->Phonenumber, $this->idoutlet, $currentDateTime);
            
            if ($stmt->execute()) {
                // Data successfully inserted
                return true;
            } else {
                // Error in the insertion process
                return false;
            }
        } else {
            // The phone number already exists, handle accordingly
            return false;
        }
    }
}

class Register extends DbHandler {
    public $response; // Make $response public
    private $Fullname, $Username, $Password, $PasswordConfirmation;

    public function __construct($Fullname, $Username, $Password, $PasswordConfirmation) {
        parent::__construct();
        $this->Fullname = $Fullname;
        $this->Username = $Username;
        $this->Password = $Password;
        $this->PasswordConfirmation = $PasswordConfirmation;
    }

    private function CheckUsername($Username) {
        $Username = $this->dbConnection->real_escape_string($Username);

        $query = "SELECT COUNT(*) as count FROM users WHERE username = '$Username'";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'] == 0;
        }

        return false;
    }

    private function encryptPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function checkRegistrationData($Username, $Password, $PasswordConfirmation) {
        $errors = [];

        if (!$this->CheckUsername($Username)) {
            $errors['Username'] = 'Username sudah terdaftar';
        }

        if (empty($Password)) {
            $errors['Password'] = 'Kata Sandi tidak boleh kosong';
        }

        if ($Password !== $PasswordConfirmation) {
            $errors['Password_confirmation'] = 'Ulangi Kata Sandi tidak sesuai';
        }

        return $errors;
    }

    public function registerUser() {
        $errors = $this->checkRegistrationData($this->Username, $this->Password, $this->PasswordConfirmation);

        if (!empty($errors)) {
            $this->response = [
                'status' => 'error',
                'message' => 'Invalid input data',
                'errors' => $errors
            ];
        } else {
            $hashedPassword = $this->encryptPassword($this->Password);
            $currentDateTime = date('Y-m-d H:i:s');

            $query = "INSERT INTO users (Fullname, username, password, created) VALUES ('$this->Fullname', '$this->Username', '$hashedPassword', '$currentDateTime')";
            $result = $this->dbConnection->query($query);

            if ($result) {
                header("Location: administrator");
            } else {
                $this->response = [
                    'status' => 'error',
                    'message' => 'Registration failed',
                    'error_message' => $this->dbConnection->error
                ];
            }
        }
        
    }
}
class Login extends DbHandler {
    public $loginResponse;

    private $Username, $Password;

    public function __construct($Username, $Password) {
        parent::__construct();
        $this->Username = $Username;
        $this->Password = $Password;
    }

    private function verifyUser($Username, $Password) {
        $Username = $this->dbConnection->real_escape_string($Username);

        $query = "SELECT * FROM users WHERE username = '$Username'";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            // Verify password
            if (password_verify($Password, $row['password'])) {
                return $row;
            }
        }

        return null;
    }

    public function loginUser() {
        $user = $this->verifyUser($this->Username, $this->Password);

        if ($user) {
            // Successful login
            $_SESSION['user'] = $user; // Store more user information if needed
            $this->loginResponse = [
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user
            ];
        } else {
            // Failed login
            $this->loginResponse = [
                'status' => 'error',
                'message' => 'Invalid username or password'
            ];
        }
    }
}

class Home extends DbHandler{
    public function getAllData() {
        $query = "SELECT COUNT(*) AS totalUsers FROM phonebook";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalUsers'];
        } else {
            return false;
        }
    }
    public function getDataVerified() {
        $query = "SELECT COUNT(*) AS totalVerified FROM phonebook where verifieduser=1";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalVerified'];
        } else {
            return false;
        }
    }
    public function getDatanonVerified() {
        $query = "SELECT COUNT(*) AS totalnonVerified FROM phonebook where verifieduser=0";
        $result = $this->dbConnection->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalnonVerified'];
        } else {
            return false;
        }
    }
}

?>
