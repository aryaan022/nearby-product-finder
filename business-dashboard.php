
<?php
session_start();
$pageTitle = "Business Dashboard";

// Check if logged in
if (!isset($_SESSION['business_id'])) {
    header("Location: business-login.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get business details
$business_id = $_SESSION['business_id'];
$query = "SELECT * FROM businesses WHERE id = $business_id";
$result = mysqli_query($conn, $query);
$business = mysqli_fetch_assoc($result);

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
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-finder-dark">Business Dashboard</h1>
                    <p class="mt-1 text-finder-gray">
                        Welcome back, <?php echo htmlspecialchars($business['business_name']); ?>
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        <?php 
                            if ($business['status'] == 'approved') echo 'bg-green-100 text-green-800';
                            elseif ($business['status'] == 'pending') echo 'bg-yellow-100 text-yellow-800';
                            else echo 'bg-red-100 text-red-800';
                        ?>">
                        <i data-lucide="<?php 
                            if ($business['status'] == 'approved') echo 'check';
                            elseif ($business['status'] == 'pending') echo 'clock';
                            else echo 'x';
                        ?>" class="w-4 h-4 mr-1"></i>
                        <?php echo ucfirst($business['status']); ?>
                    </span>
                </div>
            </div>
            
            <!-- Dashboard Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <ul class="-mb-px flex overflow-x-auto" role="tablist">
                    <li class="mr-2">
                        <button onclick="showTab('profile')" class="tab-btn active inline-block p-4 border-b-2 border-finder-blue text-finder-blue rounded-t-lg" role="tab">
                            <i data-lucide="user" class="w-4 h-4 inline-block mr-1"></i>
                            Business Profile
                        </button>
                    </li>
                    <li class="mr-2">
                        <button onclick="showTab('edit')" class="tab-btn inline-block p-4 border-b-2 border-transparent hover:text-finder-blue hover:border-gray-300 rounded-t-lg" role="tab">
                            <i data-lucide="edit" class="w-4 h-4 inline-block mr-1"></i>
                            Edit Information
                        </button>
                    </li>
                    <li class="mr-2">
                        <button onclick="showTab('stats')" class="tab-btn inline-block p-4 border-b-2 border-transparent hover:text-finder-blue hover:border-gray-300 rounded-t-lg" role="tab">
                            <i data-lucide="bar-chart" class="w-4 h-4 inline-block mr-1"></i>
                            Stats & Analytics
                        </button>
                    </li>
                </ul>
            </div>
            
            <!-- Tab Content -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Business Profile Tab -->
                <div id="profile-tab" class="tab-content block">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden mb-4">
                                <div class="flex items-center justify-center h-full bg-gray-200 rounded-lg">
                                    <i data-lucide="store" class="w-24 h-24 text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <i data-lucide="tag" class="w-5 h-5 text-finder-gray mr-2"></i>
                                    <span class="text-finder-dark"><?php echo htmlspecialchars($business['category']); ?></span>
                                </div>
                                
                                <div class="flex items-start">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-finder-gray mr-2 mt-0.5"></i>
                                    <span class="text-finder-dark">
                                        <?php echo htmlspecialchars($business['address']); ?><br>
                                        <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?> <?php echo htmlspecialchars($business['postal_code']); ?>
                                    </span>
                                </div>
                                
                                <div class="flex items-center">
                                    <i data-lucide="phone" class="w-5 h-5 text-finder-gray mr-2"></i>
                                    <span class="text-finder-dark"><?php echo htmlspecialchars($business['phone']); ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <i data-lucide="mail" class="w-5 h-5 text-finder-gray mr-2"></i>
                                    <span class="text-finder-dark"><?php echo htmlspecialchars($business['email']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h2 class="text-2xl font-bold text-finder-dark mb-4"><?php echo htmlspecialchars($business['business_name']); ?></h2>
                            
                            <div class="prose max-w-none mb-6">
                                <p><?php echo nl2br(htmlspecialchars($business['description'] ?: 'No business description added yet.')); ?></p>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mt-6">
                                <h3 class="text-lg font-medium text-finder-dark mb-2">Business Owner</h3>
                                <p class="text-finder-gray">
                                    <?php echo htmlspecialchars($business['owner_name'] ?: 'Not specified'); ?>
                                </p>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mt-6">
                                <h3 class="text-lg font-medium text-finder-dark mb-2">Registration Date</h3>
                                <p class="text-finder-gray">
                                    <?php echo date('F j, Y', strtotime($business['created_at'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Business Tab -->
                <div id="edit-tab" class="tab-content hidden">
                    <h2 class="text-2xl font-bold text-finder-dark mb-6">Edit Business Information</h2>
                    
                    <form method="POST" action="update-business.php" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name*</label>
                                <input type="text" id="business_name" name="business_name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                       value="<?php echo htmlspecialchars($business['business_name']); ?>">
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                                <select id="category" name="category" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                                    <option value="Coffee & Tea" <?php echo ($business['category'] == 'Coffee & Tea') ? 'selected' : ''; ?>>Coffee & Tea</option>
                                    <option value="Retail" <?php echo ($business['category'] == 'Retail') ? 'selected' : ''; ?>>Retail</option>
                                    <option value="Food" <?php echo ($business['category'] == 'Food') ? 'selected' : ''; ?>>Food</option>
                                    <option value="Books" <?php echo ($business['category'] == 'Books') ? 'selected' : ''; ?>>Books</option>
                                    <option value="Clothing" <?php echo ($business['category'] == 'Clothing') ? 'selected' : ''; ?>>Clothing</option>
                                    <option value="Outdoor" <?php echo ($business['category'] == 'Outdoor') ? 'selected' : ''; ?>>Outdoor</option>
                                    <option value="Gifts" <?php echo ($business['category'] == 'Gifts') ? 'selected' : ''; ?>>Gifts</option>
                                    <option value="Services" <?php echo ($business['category'] == 'Services') ? 'selected' : ''; ?>>Services</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Business Description</label>
                            <textarea id="description" name="description" rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"><?php echo htmlspecialchars($business['description']); ?></textarea>
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                            <input type="text" id="address" name="address" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                  value="<?php echo htmlspecialchars($business['address']); ?>">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City*</label>
                                <input type="text" id="city" name="city" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo htmlspecialchars($business['city']); ?>">
                            </div>
                            
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State*</label>
                                <select id="state" name="state" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                                    <option value="Andhra Pradesh" <?php echo ($business['state'] == 'Andhra Pradesh') ? 'selected' : ''; ?>>Andhra Pradesh</option>
                                    <option value="Assam" <?php echo ($business['state'] == 'Assam') ? 'selected' : ''; ?>>Assam</option>
                                    <option value="Bihar" <?php echo ($business['state'] == 'Bihar') ? 'selected' : ''; ?>>Bihar</option>
                                    <option value="Delhi" <?php echo ($business['state'] == 'Delhi') ? 'selected' : ''; ?>>Delhi</option>
                                    <option value="Goa" <?php echo ($business['state'] == 'Goa') ? 'selected' : ''; ?>>Goa</option>
                                    <option value="Gujarat" <?php echo ($business['state'] == 'Gujarat') ? 'selected' : ''; ?>>Gujarat</option>
                                    <option value="Karnataka" <?php echo ($business['state'] == 'Karnataka') ? 'selected' : ''; ?>>Karnataka</option>
                                    <option value="Kerala" <?php echo ($business['state'] == 'Kerala') ? 'selected' : ''; ?>>Kerala</option>
                                    <option value="Madhya Pradesh" <?php echo ($business['state'] == 'Madhya Pradesh') ? 'selected' : ''; ?>>Madhya Pradesh</option>
                                    <option value="Maharashtra" <?php echo ($business['state'] == 'Maharashtra') ? 'selected' : ''; ?>>Maharashtra</option>
                                    <option value="Punjab" <?php echo ($business['state'] == 'Punjab') ? 'selected' : ''; ?>>Punjab</option>
                                    <option value="Rajasthan" <?php echo ($business['state'] == 'Rajasthan') ? 'selected' : ''; ?>>Rajasthan</option>
                                    <option value="Tamil Nadu" <?php echo ($business['state'] == 'Tamil Nadu') ? 'selected' : ''; ?>>Tamil Nadu</option>
                                    <option value="Telangana" <?php echo ($business['state'] == 'Telangana') ? 'selected' : ''; ?>>Telangana</option>
                                    <option value="Uttar Pradesh" <?php echo ($business['state'] == 'Uttar Pradesh') ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                    <option value="West Bengal" <?php echo ($business['state'] == 'West Bengal') ? 'selected' : ''; ?>>West Bengal</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo htmlspecialchars($business['postal_code']); ?>">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                                <input type="tel" id="phone" name="phone" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo htmlspecialchars($business['phone']); ?>">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                                <input type="email" id="email" name="email" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo htmlspecialchars($business['email']); ?>">
                            </div>
                        </div>
                        
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">Owner/Manager Name</label>
                            <input type="text" id="owner_name" name="owner_name" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                  value="<?php echo htmlspecialchars($business['owner_name']); ?>">
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full md:w-auto bg-finder-blue hover:bg-finder-lightBlue text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Stats Tab -->
                <div id="stats-tab" class="tab-content hidden">
                    <h2 class="text-2xl font-bold text-finder-dark mb-6">Stats & Analytics</h2>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <div class="flex items-center justify-center h-40">
                            <div class="text-finder-gray">
                                <i data-lucide="bar-chart-2" class="w-16 h-16 mx-auto mb-4 text-gray-300"></i>
                                <p class="text-lg">Analytics coming soon!</p>
                                <p class="text-sm mt-2">We're working on providing detailed stats about your business profile views and interactions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Show the selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Update active tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-finder-blue', 'text-finder-blue');
                btn.classList.add('border-transparent', 'hover:text-finder-blue', 'hover:border-gray-300');
            });
            
            // Set the clicked button as active
            event.currentTarget.classList.add('active', 'border-finder-blue', 'text-finder-blue');
            event.currentTarget.classList.remove('border-transparent', 'hover:text-finder-blue', 'hover:border-gray-300');
        }
    </script>
</body>
</html>
