
<?php
$pageTitle = "Business Details";

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get business ID from URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $business_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get business details
    $query = "SELECT * FROM businesses WHERE id = $business_id AND status = 'approved'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $business = mysqli_fetch_assoc($result);
    } else {
        header("Location: discover.php");
        exit();
    }
} else {
    header("Location: discover.php");
    exit();
}

// For demo purposes, let's assign some default coordinates if not in database
// In a real application, you would store latitude and longitude in your database
$latitude = 12.9352; // Default to Bangalore
$longitude = 77.6245;

// For this demo, we'll assign some random coordinates near Bangalore based on business ID
$latitude += ($business_id * 0.01);
$longitude += ($business_id * 0.01);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($business['business_name']); ?> - LocalFinder</title>
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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <style>
        #map { height: 300px; width: 100%; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-20">
        <!-- Business Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-finder-dark mb-2"><?php echo htmlspecialchars($business['business_name']); ?></h1>
                        <div class="flex items-center mb-2">
                            <span class="text-finder-blue mr-2"><?php echo htmlspecialchars($business['category']); ?></span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                Verified
                            </span>
                        </div>
                        <p class="text-finder-gray"><?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?></p>
                    </div>
                    
                    <div class="mt-4 md:mt-0">
                        <a href="tel:<?php echo htmlspecialchars($business['phone']); ?>" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-finder-blue hover:bg-finder-lightBlue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                            <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                            Contact Business
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Business Details -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow rounded-lg p-6 mb-8">
                        <h2 class="text-2xl font-bold text-finder-dark mb-4">About</h2>
                        <p class="text-finder-gray">
                            <?php echo !empty($business['description']) ? nl2br(htmlspecialchars($business['description'])) : 'No description available.'; ?>
                        </p>
                    </div>
                    
                    <div class="bg-white shadow rounded-lg p-6 mb-8">
                        <h2 class="text-2xl font-bold text-finder-dark mb-4">Location</h2>
                        <div class="mb-4">
                            <div class="flex items-start">
                                <i data-lucide="map-pin" class="w-5 h-5 mr-2 mt-0.5 text-finder-blue"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Address</h3>
                                    <p class="text-finder-gray">
                                        <?php echo htmlspecialchars($business['address']); ?><br>
                                        <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?> <?php echo htmlspecialchars($business['postal_code']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Map -->
                        <div id="map" class="w-full h-64 rounded-md"></div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div>
                    <div class="bg-white shadow rounded-lg p-6 mb-8">
                        <h2 class="text-lg font-bold text-finder-dark mb-4">Contact Information</h2>
                        
                        <div class="space-y-4">
                            <?php if (!empty($business['owner_name'])): ?>
                                <div class="flex items-start">
                                    <i data-lucide="user" class="w-5 h-5 mr-2 mt-0.5 text-finder-blue"></i>
                                    <div>
                                        <h3 class="font-medium text-finder-dark">Owner/Manager</h3>
                                        <p class="text-finder-gray"><?php echo htmlspecialchars($business['owner_name']); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex items-start">
                                <i data-lucide="phone" class="w-5 h-5 mr-2 mt-0.5 text-finder-blue"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Phone</h3>
                                    <p class="text-finder-gray"><?php echo htmlspecialchars($business['phone']); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <i data-lucide="mail" class="w-5 h-5 mr-2 mt-0.5 text-finder-blue"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Email</h3>
                                    <p class="text-finder-gray"><?php echo htmlspecialchars($business['email']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="tel:<?php echo htmlspecialchars($business['phone']); ?>" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-finder-blue hover:bg-finder-lightBlue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                <i data-lucide="phone" class="w-4 h-4 inline-block mr-1"></i>
                                Call Business
                            </a>
                            
                            <a href="mailto:<?php echo htmlspecialchars($business['email']); ?>" class="block w-full text-center mt-3 px-4 py-2 border border-finder-blue rounded-md text-finder-blue hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                <i data-lucide="mail" class="w-4 h-4 inline-block mr-1"></i>
                                Email Business
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-lg font-bold text-finder-dark mb-4">Business Hours</h2>
                        <p class="text-finder-gray italic mb-4">Business hours information not available</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-finder-gray">
                                <i data-lucide="alert-circle" class="w-4 h-4 inline-block mr-1"></i>
                                Hours may vary. Contact business for current hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Similar Businesses Section -->
            <div class="mt-10">
                <h2 class="text-2xl font-bold text-finder-dark mb-6">Similar Businesses</h2>
                
                <?php
                // Get similar businesses in the same category (excluding current)
                $similar_query = "SELECT * FROM businesses 
                                  WHERE category = '{$business['category']}' 
                                  AND id != {$business['id']} 
                                  AND status = 'approved' 
                                  LIMIT 3";
                $similar_result = mysqli_query($conn, $similar_query);
                
                if (mysqli_num_rows($similar_result) > 0):
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php while ($similar = mysqli_fetch_assoc($similar_result)): ?>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-finder-dark mb-1"><?php echo htmlspecialchars($similar['business_name']); ?></h3>
                                    <p class="text-finder-blue mb-2"><?php echo htmlspecialchars($similar['category']); ?></p>
                                    
                                    <p class="text-finder-gray text-sm mb-4 line-clamp-2">
                                        <?php 
                                        echo !empty($similar['description']) 
                                             ? htmlspecialchars(substr($similar['description'], 0, 100)) . (strlen($similar['description']) > 100 ? '...' : '')
                                             : 'No description available';
                                        ?>
                                    </p>
                                    
                                    <div class="space-y-2 text-sm text-finder-gray mb-4">
                                        <div class="flex items-center">
                                            <i data-lucide="map-pin" class="w-4 h-4 mr-2 flex-shrink-0"></i>
                                            <span><?php echo htmlspecialchars($similar['city']); ?>, <?php echo htmlspecialchars($similar['state']); ?></span>
                                        </div>
                                    </div>
                                    
                                    <a href="business-detail.php?id=<?php echo $similar['id']; ?>" class="block w-full text-center px-4 py-2 border border-finder-blue rounded-md text-finder-blue hover:bg-finder-blue hover:text-white transition-colors duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-finder-gray">No similar businesses found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Initialize map
        const map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker for business location
        const marker = L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);
        marker.bindPopup("<b><?php echo htmlspecialchars($business['business_name']); ?></b><br><?php echo htmlspecialchars($business['address']); ?>, <?php echo htmlspecialchars($business['city']); ?>").openPopup();
    </script>
</body>
</html>
