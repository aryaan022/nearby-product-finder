<?php
$pageTitle = "Discover Businesses";

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Build query
$query = "SELECT * FROM businesses WHERE status = 'approved'";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (business_name LIKE '%$search%' OR description LIKE '%$search%')";
}

if (!empty($category) && $category != 'all') {
    $category = mysqli_real_escape_string($conn, $category);
    $query .= " AND category = '$category'";
}

if (!empty($location)) {
    $location = mysqli_real_escape_string($conn, $location);
    $query .= " AND (city LIKE '%$location%' OR state LIKE '%$location%')";
}

$query .= " ORDER BY business_name ASC";

$result = mysqli_query($conn, $query);

// Get all categories for filter
$categories_query = "SELECT DISTINCT category FROM businesses WHERE status = 'approved' ORDER BY category ASC";
$categories_result = mysqli_query($conn, $categories_query);
$categories = [];
while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row['category'];
}

// Get all locations (cities and states) for filter
$locations_query = "SELECT DISTINCT city, state FROM businesses WHERE status = 'approved' ORDER BY state ASC, city ASC";
$locations_result = mysqli_query($conn, $locations_query);
$locations = [];
while ($row = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $row['city'] . ', ' . $row['state'];
}
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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    <style>
        #map { height: 400px; width: 100%; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-20">
        <!-- Hero Section -->
        <div class="bg-finder-blue py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-4">Discover Local Businesses</h1>
                    <p class="text-xl text-finder-lightBlue max-w-3xl mx-auto">
                        Find the perfect local businesses for all your needs across India
                    </p>
                </div>
                
                <!-- Search Form -->
                <div class="max-w-5xl mx-auto mt-8">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i data-lucide="search" class="w-4 h-4 inline-block mr-1"></i>
                                    Search
                                </label>
                                <input type="text" id="search" name="search" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                       placeholder="Business name or keywords"
                                       value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i data-lucide="tag" class="w-4 h-4 inline-block mr-1"></i>
                                    Category
                                </label>
                                <select id="category" name="category"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue">
                                    <option value="all" <?php echo empty($category) || $category == 'all' ? 'selected' : ''; ?>>All Categories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category == $cat ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i data-lucide="map-pin" class="w-4 h-4 inline-block mr-1"></i>
                                    Location
                                </label>
                                <input type="text" id="location" name="location" list="locations"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                       placeholder="City or state"
                                       value="<?php echo htmlspecialchars($location); ?>">
                                <datalist id="locations">
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?php echo htmlspecialchars($loc); ?>">
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-center">
                            <button type="submit" class="px-6 py-3 bg-finder-blue text-white font-medium rounded-md hover:bg-finder-lightBlue focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                                <i data-lucide="search" class="w-5 h-5 inline-block mr-1"></i>
                                Search Businesses
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="bg-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-finder-dark mb-4">Businesses Near You</h2>
                <div id="map" class="w-full h-96 rounded-lg shadow-md"></div>
            </div>
        </div>
        
        <!-- Results Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center">
                <h2 class="text-2xl font-bold text-finder-dark mb-4 md:mb-0">
                    <?php 
                    $count = mysqli_num_rows($result);
                    echo $count . ' ' . ($count == 1 ? 'Business' : 'Businesses') . ' Found';
                    
                    if (!empty($search) || !empty($category) || !empty($location)) {
                        echo ' for ';
                        $filters = [];
                        if (!empty($search)) $filters[] = '"' . htmlspecialchars($search) . '"';
                        if (!empty($category) && $category != 'all') $filters[] = htmlspecialchars($category);
                        if (!empty($location)) $filters[] = htmlspecialchars($location);
                        echo implode(', ', $filters);
                    }
                    ?>
                </h2>
                
                <div>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline-flex items-center text-sm text-finder-blue hover:text-finder-lightBlue">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 mr-1"></i>
                        Clear All Filters
                    </a>
                </div>
            </div>
            
            <?php if ($count > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($business = mysqli_fetch_assoc($result)): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-finder-dark mb-1"><?php echo htmlspecialchars($business['business_name']); ?></h3>
                                        <p class="text-finder-blue mb-2"><?php echo htmlspecialchars($business['category']); ?></p>
                                    </div>
                                    
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                        Verified
                                    </span>
                                </div>
                                
                                <p class="text-finder-gray text-sm mb-4 line-clamp-2">
                                    <?php 
                                    echo !empty($business['description']) 
                                         ? htmlspecialchars(substr($business['description'], 0, 150)) . (strlen($business['description']) > 150 ? '...' : '')
                                         : 'No description available';
                                    ?>
                                </p>
                                
                                <div class="space-y-2 text-sm text-finder-gray">
                                    <div class="flex items-start">
                                        <i data-lucide="map-pin" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                        <span><?php echo htmlspecialchars($business['address']); ?>, <?php echo htmlspecialchars($business['city']); ?>, <?php echo htmlspecialchars($business['state']); ?></span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <i data-lucide="phone" class="w-4 h-4 mr-2 flex-shrink-0"></i>
                                        <span><?php echo htmlspecialchars($business['phone']); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <a href="business-detail.php?id=<?php echo $business['id']; ?>" class="block w-full text-center px-4 py-2 border border-finder-blue rounded-md text-finder-blue hover:bg-finder-blue hover:text-white transition-colors duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="inline-block p-3 rounded-full bg-blue-50 text-finder-blue mb-4">
                        <i data-lucide="search-x" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-medium text-finder-dark mb-2">No businesses found</h3>
                    <p class="text-finder-gray mb-6">We couldn't find any businesses matching your search criteria.</p>
                    <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="inline-flex items-center px-4 py-2 border border-finder-blue rounded-md text-finder-blue hover:bg-finder-blue hover:text-white transition-colors duration-300">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 mr-1"></i>
                        Clear Filters & Try Again
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Category Browse Section -->
        <div class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-finder-dark">Browse by Category</h2>
                    <p class="mt-2 text-finder-gray">Find the perfect local business for your needs</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    <a href="?category=Coffee+%26+Tea" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-finder-blue mb-4 group-hover:bg-finder-lightBlue transition-colors duration-300">
                                    <i data-lucide="coffee" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Coffee & Tea</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Retail" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-finder-teal mb-4 group-hover:bg-teal-500 transition-colors duration-300">
                                    <i data-lucide="shopping-bag" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Retail</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Food" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-amber-500 mb-4 group-hover:bg-amber-600 transition-colors duration-300">
                                    <i data-lucide="utensils" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Food</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Books" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-emerald-500 mb-4 group-hover:bg-emerald-600 transition-colors duration-300">
                                    <i data-lucide="book" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Books</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Clothing" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-purple-500 mb-4 group-hover:bg-purple-600 transition-colors duration-300">
                                    <i data-lucide="shirt" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Clothing</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Outdoor" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-rose-500 mb-4 group-hover:bg-rose-600 transition-colors duration-300">
                                    <i data-lucide="bike" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Outdoor</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Gifts" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-orange-500 mb-4 group-hover:bg-orange-600 transition-colors duration-300">
                                    <i data-lucide="gift" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Gifts</h3>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?category=Services" class="group">
                        <div class="bg-white shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300 h-full">
                            <div class="p-6 flex flex-col items-center text-center">
                                <div class="p-3 rounded-full bg-gray-500 mb-4 group-hover:bg-gray-600 transition-colors duration-300">
                                    <i data-lucide="scissors" class="w-6 h-6 text-white"></i>
                                </div>
                                <h3 class="font-medium text-finder-dark">Services</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="bg-finder-blue py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Own a Business?</h2>
                <p class="text-xl text-finder-lightBlue mb-8 max-w-3xl mx-auto">
                    Join our platform and reach thousands of potential customers in your area.
                </p>
                <a href="register-business.php" class="inline-block px-6 py-3 bg-white text-finder-blue font-medium rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                    Register Your Business
                </a>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Initialize map
        const map = L.map('map').setView([20.5937, 78.9629], 5); // Center of India
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add markers for businesses
        <?php
        // Reset pointer to first row
        mysqli_data_seek($result, 0);
        
        while ($business = mysqli_fetch_assoc($result)) {
            // For demo purposes, we'll generate random coordinates near major cities in India
            // In a real app, you would store actual coordinates in your database
            
            // Generate a random offset based on business ID
            $randomLat = 0;
            $randomLng = 0;
            
            // Determine city location
            switch(strtolower($business['city'])) {
                case 'mumbai':
                    $baseLat = 19.0760;
                    $baseLng = 72.8777;
                    break;
                case 'delhi':
                case 'new delhi':
                    $baseLat = 28.6139;
                    $baseLng = 77.2090;
                    break;
                case 'bangalore':
                case 'bengaluru':
                    $baseLat = 12.9716;
                    $baseLng = 77.5946;
                    break;
                case 'hyderabad':
                    $baseLat = 17.3850;
                    $baseLng = 78.4867;
                    break;
                case 'chennai':
                    $baseLat = 13.0827;
                    $baseLng = 80.2707;
                    break;
                case 'kolkata':
                    $baseLat = 22.5726;
                    $baseLng = 88.3639;
                    break;
                case 'pune':
                    $baseLat = 18.5204;
                    $baseLng = 73.8567;
                    break;
                default:
                    // Default to center of India with some randomness if city not recognized
                    $baseLat = 20.5937 + (($business['id'] % 10) / 10);
                    $baseLng = 78.9629 + (($business['id'] % 15) / 15);
            }
            
            // Add some randomness but keep it small enough to be in the city
            $randomLat = $baseLat + (($business['id'] % 20) / 1000);
            $randomLng = $baseLng + (($business['id'] % 30) / 1000);
            
            echo "const marker" . $business['id'] . " = L.marker([" . $randomLat . ", " . $randomLng . "]).addTo(map);\n";
            echo "marker" . $business['id'] . ".bindPopup('<b>" . addslashes(htmlspecialchars($business['business_name'])) . "</b><br>" . 
                  addslashes(htmlspecialchars($business['address'])) . "<br><a href=\"business-detail.php?id=" . $business['id'] . 
                  "\">View Details</a>');\n";
        }
        ?>
    </script>
</body>
</html>
