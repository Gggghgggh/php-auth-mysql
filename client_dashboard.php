<?php
session_start();
require_once 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ensure the user is a client
if ($_SESSION['user_role'] !== 'client') {
    header('Location: login.php');
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                    <span class="text-xl font-semibold">Booking System</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                    <a href="logout.php" class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">My Profile</h2>
                    </div>
                    <div class="space-y-2">
                        <p><span class="font-medium">Name:</span> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p><span class="font-medium">Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
                        <p><span class="font-medium">Role:</span> Client</p>
                    </div>
                    <button class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                        Edit Profile
                    </button>
                </div>

                <!-- Book Appointment -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-calendar-plus text-green-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">Book Appointment</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Schedule a new appointment with a service provider.</p>
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                        New Booking
                    </button>
                </div>

                <!-- My Appointments -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-list-alt text-purple-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">My Appointments</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span>Haircut - June 15</span>
                            <span class="text-sm text-gray-500">Pending</span>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span>Massage - June 20</span>
                            <span class="text-sm text-green-500">Confirmed</span>
                        </div>
                    </div>
                    <button class="mt-4 w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg">
                        View All
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-check-circle text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Appointment booked</p>
                            <p class="text-sm text-gray-500">Haircut with John's Salon on June 15</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="fas fa-calendar-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">Appointment confirmed</p>
                            <p class="text-sm text-gray-500">Massage with Relax Spa on June 20</p>
                            <p class="text-xs text-gray-400">1 day ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>