<?php
session_start();
require_once 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ensure the user is a provider
if ($_SESSION['user_role'] !== 'provider') {
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

// Count upcoming appointments (example)
$upcoming_count = 5; // In a real app, you would query this from the database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-indigo-600 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-briefcase text-2xl"></i>
                    <span class="text-xl font-semibold">Provider Portal</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
                    <a href="logout.php" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded-lg">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Business Overview -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <i class="fas fa-chart-line text-indigo-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">Business Overview</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Upcoming Appointments</span>
                            <span class="font-bold"><?php echo $upcoming_count; ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Today's Appointments</span>
                            <span class="font-bold">2</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pending Requests</span>
                            <span class="font-bold">3</span>
                        </div>
                    </div>
                    <button class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg">
                        View Analytics
                    </button>
                </div>

                <!-- Manage Appointments -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">Manage Appointments</h2>
                    </div>
                    <p class="text-gray-600 mb-4">View and manage your upcoming appointments.</p>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">
                        View Calendar
                    </button>
                </div>

                <!-- Service Management -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-concierge-bell text-green-600 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold">Service Management</h2>
                    </div>
                    <p class="text-gray-600 mb-4">Add or edit your services and availability.</p>
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                        Manage Services
                    </button>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Upcoming Appointments</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Sarah Johnson</td>
                                <td class="px-6 py-4 whitespace-nowrap">Hair Coloring</td>
                                <td class="px-6 py-4 whitespace-nowrap">June 15, 2023 - 10:00 AM</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-indigo-600 hover:text-indigo-900">Details</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Michael Brown</td>
                                <td class="px-6 py-4 whitespace-nowrap">Haircut</td>
                                <td class="px-6 py-4 whitespace-nowrap">June 16, 2023 - 2:30 PM</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button class="text-indigo-600 hover:text-indigo-900">Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>