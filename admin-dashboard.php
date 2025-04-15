
<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$pageTitle = "Admin Dashboard";
$success_message = "";
$error_message = "";

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle business approval/rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['business_id'])) {
    $business_id = mysqli_real_escape_string($conn, $_POST['business_id']);
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $query = "UPDATE businesses SET status = 'approved' WHERE id = $business_id";
        if (mysqli_query($conn, $query)) {
            $success_message = "Business approved successfully!";
        } else {
            $error_message = "Error approving business: " . mysqli_error($conn);
        }
    } elseif ($action == 'reject') {
        $query = "UPDATE businesses SET status = 'rejected' WHERE id = $business_id";
        if (mysqli_query($conn, $query)) {
            $success_message = "Business rejected successfully!";
        } else {
            $error_message = "Error rejecting business: " . mysqli_error($conn);
        }
    } elseif ($action == 'delete') {
        $query = "DELETE FROM businesses WHERE id = $business_id";
        if (mysqli_query($conn, $query)) {
            $success_message = "Business deleted successfully!";
        } else {
            $error_message = "Error deleting business: " . mysqli_error($conn);
        }
    }
}

// Get businesses
$pending_query = "SELECT * FROM businesses WHERE status = 'pending' ORDER BY id DESC";
$pending_result = mysqli_query($conn, $pending_query);

$approved_query = "SELECT * FROM businesses WHERE status = 'approved' ORDER BY id DESC";
$approved_result = mysqli_query($conn, $approved_query);

$rejected_query = "SELECT * FROM businesses WHERE status = 'rejected' ORDER BY id DESC";
$rejected_result = mysqli_query($conn, $rejected_query);

// Count businesses by status
$count_query = "SELECT status, COUNT(*) as count FROM businesses GROUP BY status";
$count_result = mysqli_query($conn, $count_query);
$counts = array(
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
);
while ($row = mysqli_fetch_assoc($count_result)) {
    $counts[$row['status']] = $row['count'];
}
$total_businesses = array_sum($counts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - LocalFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'finder-blue': '#3B82F6',
                        'finder-lightBlue': '#60A5FA',
                        'finder-dark': '#1F2937',
                        'finder-gray': '#6B7280',
                        'finder-teal': '#14B8A6',
                    }
                }
            }
        }
    </script>
    <link href="https://unpkg.com/lucide-icons/dist/umd/lucide.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-20">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-finder-dark">Admin Dashboard</h1>
                
                <div class="mt-4 md:mt-0">
                    <a href="logout.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>
            
            <?php if (!empty($success_message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-blue-50 text-finder-blue">
                            <i data-lucide="building" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Businesses</p>
                            <p class="text-2xl font-bold text-finder-dark"><?php echo $total_businesses; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                            <i data-lucide="clock" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Pending Approval</p>
                            <p class="text-2xl font-bold text-finder-dark"><?php echo $counts['pending']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-green-50 text-green-600">
                            <i data-lucide="check-circle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Approved</p>
                            <p class="text-2xl font-bold text-finder-dark"><?php echo $counts['approved']; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 rounded-full bg-red-50 text-red-600">
                            <i data-lucide="x-circle" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Rejected</p>
                            <p class="text-2xl font-bold text-finder-dark"><?php echo $counts['rejected']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending Businesses Section -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-finder-dark mb-4">Pending Businesses</h2>
                
                <?php if (mysqli_num_rows($pending_result) > 0): ?>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            <?php while ($business = mysqli_fetch_assoc($pending_result)): ?>
                                <li>
                                    <div class="px-4 py-5 sm:px-6">
                                        <div class="flex flex-col md:flex-row justify-between">
                                            <div class="mb-4 md:mb-0">
                                                <h3 class="text-lg font-medium text-finder-dark"><?php echo htmlspecialchars($business['business_name']); ?></h3>
                                                <p class="text-finder-gray"><?php echo htmlspecialchars($business['category']); ?></p>
                                                <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?></p>
                                                
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                                <button type="button" onclick="toggleDetails('<?php echo $business['id']; ?>')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-finder-gray bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                                    <i data-lucide="info" class="w-4 h-4 mr-1"></i>
                                                    Details
                                                </button>
                                                
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline">
                                                    <input type="hidden" name="business_id" value="<?php echo $business['id']; ?>">
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <i data-lucide="check" class="w-4 h-4 mr-1"></i>
                                                        Approve
                                                    </button>
                                                </form>
                                                
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline" onsubmit="return confirm('Are you sure you want to reject this business?');">
                                                    <input type="hidden" name="business_id" value="<?php echo $business['id']; ?>">
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        <i data-lucide="x" class="w-4 h-4 mr-1"></i>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div id="details-<?php echo $business['id']; ?>" class="mt-4 hidden">
                                            <div class="border-t border-gray-200 pt-4">
                                                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                                    <div class="sm:col-span-1">
                                                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                                                        <dd class="mt-1 text-sm text-finder-dark"><?php echo nl2br(htmlspecialchars($business['description'])); ?></dd>
                                                    </div>
                                                    <div class="sm:col-span-1">
                                                        <dt class="text-sm font-medium text-gray-500">Owner/Manager</dt>
                                                        <dd class="mt-1 text-sm text-finder-dark"><?php echo htmlspecialchars($business['owner_name']); ?></dd>
                                                    </div>
                                                    <div class="sm:col-span-1">
                                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                                        <dd class="mt-1 text-sm text-finder-dark">
                                                            <?php echo htmlspecialchars($business['address']); ?><br>
                                                            <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?> <?php echo htmlspecialchars($business['postal_code']); ?>
                                                        </dd>
                                                    </div>
                                                    <div class="sm:col-span-1">
                                                        <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                                        <dd class="mt-1 text-sm text-finder-dark">
                                                            <div><?php echo htmlspecialchars($business['phone']); ?></div>
                                                            <div><?php echo htmlspecialchars($business['email']); ?></div>
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="bg-white shadow overflow-hidden sm:rounded-md p-6 text-center">
                        <p class="text-finder-gray">No pending businesses to review.</p>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- All Businesses Section with Tabs -->
            <section>
                <h2 class="text-2xl font-bold text-finder-dark mb-4">All Businesses</h2>
                
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button onclick="showTab('approved')" class="inline-block p-4 border-b-2 rounded-t-lg active" id="approved-tab" type="button" role="tab" aria-controls="approved" aria-selected="true">
                                Approved
                            </button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button onclick="showTab('rejected')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg" id="rejected-tab" type="button" role="tab" aria-controls="rejected" aria-selected="false">
                                Rejected
                            </button>
                        </li>
                    </ul>
                </div>
                
                <!-- Approved Businesses Tab -->
                <div id="approved-content" class="tab-content">
                    <?php if (mysqli_num_rows($approved_result) > 0): ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php while ($business = mysqli_fetch_assoc($approved_result)): ?>
                                    <li>
                                        <div class="px-4 py-5 sm:px-6">
                                            <div class="flex flex-col md:flex-row justify-between">
                                                <div class="mb-4 md:mb-0">
                                                    <h3 class="text-lg font-medium text-finder-dark"><?php echo htmlspecialchars($business['business_name']); ?></h3>
                                                    <p class="text-finder-gray"><?php echo htmlspecialchars($business['category']); ?></p>
                                                    <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?></p>
                                                    
                                                    <div class="mt-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Approved
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                                    <button type="button" onclick="toggleDetails('<?php echo $business['id']; ?>-approved')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-finder-gray bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                                        <i data-lucide="info" class="w-4 h-4 mr-1"></i>
                                                        Details
                                                    </button>
                                                    
                                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone.');">
                                                        <input type="hidden" name="business_id" value="<?php echo $business['id']; ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <div id="details-<?php echo $business['id']; ?>-approved" class="mt-4 hidden">
                                                <div class="border-t border-gray-200 pt-4">
                                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark"><?php echo nl2br(htmlspecialchars($business['description'])); ?></dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Owner/Manager</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark"><?php echo htmlspecialchars($business['owner_name']); ?></dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark">
                                                                <?php echo htmlspecialchars($business['address']); ?><br>
                                                                <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?> <?php echo htmlspecialchars($business['postal_code']); ?>
                                                            </dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark">
                                                                <div><?php echo htmlspecialchars($business['phone']); ?></div>
                                                                <div><?php echo htmlspecialchars($business['email']); ?></div>
                                                            </dd>
                                                        </div>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md p-6 text-center">
                            <p class="text-finder-gray">No approved businesses found.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Rejected Businesses Tab -->
                <div id="rejected-content" class="tab-content hidden">
                    <?php if (mysqli_num_rows($rejected_result) > 0): ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                <?php while ($business = mysqli_fetch_assoc($rejected_result)): ?>
                                    <li>
                                        <div class="px-4 py-5 sm:px-6">
                                            <div class="flex flex-col md:flex-row justify-between">
                                                <div class="mb-4 md:mb-0">
                                                    <h3 class="text-lg font-medium text-finder-dark"><?php echo htmlspecialchars($business['business_name']); ?></h3>
                                                    <p class="text-finder-gray"><?php echo htmlspecialchars($business['category']); ?></p>
                                                    <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?></p>
                                                    
                                                    <div class="mt-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Rejected
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                                    <button type="button" onclick="toggleDetails('<?php echo $business['id']; ?>-rejected')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-finder-gray bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                                        <i data-lucide="info" class="w-4 h-4 mr-1"></i>
                                                        Details
                                                    </button>
                                                    
                                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline">
                                                        <input type="hidden" name="business_id" value="<?php echo $business['id']; ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                            <i data-lucide="check" class="w-4 h-4 mr-1"></i>
                                                            Approve
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone.');">
                                                        <input type="hidden" name="business_id" value="<?php echo $business['id']; ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <div id="details-<?php echo $business['id']; ?>-rejected" class="mt-4 hidden">
                                                <div class="border-t border-gray-200 pt-4">
                                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark"><?php echo nl2br(htmlspecialchars($business['description'])); ?></dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Owner/Manager</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark"><?php echo htmlspecialchars($business['owner_name']); ?></dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark">
                                                                <?php echo htmlspecialchars($business['address']); ?><br>
                                                                <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?> <?php echo htmlspecialchars($business['postal_code']); ?>
                                                            </dd>
                                                        </div>
                                                        <div class="sm:col-span-1">
                                                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                                            <dd class="mt-1 text-sm text-finder-dark">
                                                                <div><?php echo htmlspecialchars($business['phone']); ?></div>
                                                                <div><?php echo htmlspecialchars($business['email']); ?></div>
                                                            </dd>
                                                        </div>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md p-6 text-center">
                            <p class="text-finder-gray">No rejected businesses found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Toggle details section
        function toggleDetails(id) {
            const detailsSection = document.getElementById('details-' + id);
            if (detailsSection.classList.contains('hidden')) {
                detailsSection.classList.remove('hidden');
            } else {
                detailsSection.classList.add('hidden');
            }
        }
        
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('[role="tab"]').forEach(tab => {
                tab.classList.remove('active', 'border-finder-blue', 'text-finder-blue');
                tab.classList.add('border-transparent', 'text-finder-gray', 'hover:text-finder-gray', 'hover:border-gray-300');
                tab.setAttribute('aria-selected', 'false');
            });
            
            // Show the selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Set active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('active', 'border-finder-blue', 'text-finder-blue');
            activeTab.classList.remove('border-transparent', 'text-finder-gray', 'hover:text-finder-gray', 'hover:border-gray-300');
            activeTab.setAttribute('aria-selected', 'true');
        }
    </script>
</body>
</html>
