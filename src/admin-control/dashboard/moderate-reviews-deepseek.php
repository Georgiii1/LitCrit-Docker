<?php
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
    echo "<script>alert('Нямате достъп до съдържанието на страницата!'); window.location.href = '../../index.php';</script>";
    exit;
}
require '../../vendor/autoload.php';
use GuzzleHttp\Client;

// Load .env file for API key
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['DEEPSEEK_API_KEY'];

include("../../database/connection.php");

if (!$connection) {
    die("Database connection failed.");
}

$stmt = $connection->query("SELECT reviewID, review FROM Reviews WHERE status = 'pending'");

if (!$stmt) {
    $errorInfo = $connection->errorInfo();
    die("Error fetching reviews: " . $errorInfo[2]);
}

// Initialize HTTP client for DeepSeek API
$httpClient = new Client([
    'base_uri' => 'https://api.deepseek.com/v1/',
    'headers' => [
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ],
]);

function customErrorLog($error){
    $logFile = __DIR__ . '/error_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $error\n", FILE_APPEND);
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $review_id = $row['reviewID'];
    $review_content = $row['review'];

    try {
        $response = $httpClient->post('chat/completions', [
            'json' => [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a review moderator. Analyze for harmful language. " .
                                     "Respond ONLY with 'APPROVE' or 'DECLINE'."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Review: \"$review_content\""
                    ]
                ],
                'max_tokens' => 15
            ]
        ]);
        
        $responseData = json_decode($response->getBody(), true);
        $decision = trim($responseData['choices'][0]['message']['content']);
        $status = ($decision === 'APPROVE') ? 'approved' : 'declined';

        $updateStmt = $connection->prepare("UPDATE Reviews SET status = :status WHERE reviewID = :id");
        $updateSuccess = $updateStmt->execute(['status' => $status, 'id' => $review_id]);
        customErrorLog("Full API response: " . print_r($responseData, true));

        if (!$updateSuccess) {
            $updateError = $updateStmt->errorInfo();
            echo "Error updating review ID $review_id: " . $updateError[2] . "\n";
        }
    } catch (Exception $e) {
        echo "Error processing review ID $review_id: " . $e->getMessage() . "\n";
    }
}


// Close connection (optional, or just unset)
$connection = null;

echo "<script>
    alert('All reviews have been processed.');
    window.location.href = '../sections/reviews/list.php';
</script>";
exit();