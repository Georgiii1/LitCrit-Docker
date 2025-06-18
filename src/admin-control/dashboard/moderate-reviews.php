<?php
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
    echo "<script>alert('Нямате достъп до съдържанието на страницата!');</script>";
    exit;
}



// require '../../vendor/autoload.php';
// use OpenAI\Client;

// // Load .env file for API key
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// // Access the API key
// $apiKey = $_ENV['OPENAI_API_KEY'];

// // Connect to database
// include("../../database/connection.php"); // should return $connection (PDO)

// if (!$connection) {
//     die("Database connection failed.");
// }

// // Fetch pending reviews
// $stmt = $connection->query("SELECT reviewID, review FROM Reviews WHERE status = 'pending'");

// if (!$stmt) {
//     $errorInfo = $connection->errorInfo();
//     die("Error fetching reviews: " . $errorInfo[2]);
// }

// // Initialize OpenAI client
// $client = OpenAI::client($apiKey);

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $review_id = $row['reviewID'];
//     $review_content = $row['review'];

//     try {
//         $response = $client->chat()->create([
//             'model' => 'gpt-3.5-turbo',
//             'messages' => [
//                 [
//                     'role' => 'user',
//                     'content' => "Analyze the following review content for harmful or hateful language: \"$review_content\". Respond with 'APPROVE' if the content is acceptable and 'DECLINE' if it is harmful."
//                 ],
//             ],
//             'max_tokens' => 10,
//         ]);
//         $decision = trim($response['choices'][0]['message']['content']);
        

//         $decision = trim($response['choices'][0]['text']);
//         $status = ($decision === 'APPROVE') ? 'approved' : 'declined';

//         $updateStmt = $connection->prepare("UPDATE Reviews SET status = :status WHERE reviewID = :id");
//         $updateSuccess = $updateStmt->execute(['status' => $status, 'id' => $review_id]);

//         if (!$updateSuccess) {
//             $updateError = $updateStmt->errorInfo();
//             echo "Error updating review ID $review_id: " . $updateError[2] . "\n";
//         }
//     } catch (Exception $e) {
//         echo "Error processing review ID $review_id: " . $e->getMessage() . "\n";
//     }
// }

// // Close connection (optional, or just unset)
// $connection = null;

// echo "Review moderation complete.";

?>