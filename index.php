
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalFinder - Connect with Local Businesses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-icons@0.265.0/dist/umd/lucide.min.js">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main class="pt-16">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-finder-dark sm:text-5xl">
                        Discover Local Businesses Near You
                    </h1>
                    <p class="mt-4 text-xl text-finder-gray max-w-3xl mx-auto">
                        Find the perfect local shops, restaurants, and services in your area with LocalFinder.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="discover.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-finder-blue hover:bg-finder-lightBlue transition-colors duration-300">
                            Find Nearby Businesses
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Featured Categories -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-finder-dark">Browse by Category</h2>
                    <p class="mt-4 text-lg text-finder-gray">Explore businesses by category to find exactly what you're looking for</p>
                </div>
                
                <div class="mt-12 grid grid-cols-2 gap-8 sm:grid-cols-3 lg:grid-cols-6">
                    <!-- Category: Food -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="utensils" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Restaurants</h3>
                        <p class="mt-2 text-sm text-finder-gray">Find local dining options</p>
                    </div>
                    
                    <!-- Category: Shopping -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="shopping-bag" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Shopping</h3>
                        <p class="mt-2 text-sm text-finder-gray">Discover retail stores</p>
                    </div>
                    
                    <!-- Category: Services -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="tool" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Services</h3>
                        <p class="mt-2 text-sm text-finder-gray">Professional services</p>
                    </div>
                    
                    <!-- Category: Health -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="heart" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Health</h3>
                        <p class="mt-2 text-sm text-finder-gray">Healthcare providers</p>
                    </div>
                    
                    <!-- Category: Entertainment -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="film" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Entertainment</h3>
                        <p class="mt-2 text-sm text-finder-gray">Fun activities nearby</p>
                    </div>
                    
                    <!-- Category: Education -->
                    <div class="text-center">
                        <div class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100">
                            <i data-lucide="book-open" class="h-8 w-8 text-finder-blue"></i>
                        </div>
                        <h3 class="mt-3 text-lg font-medium text-finder-dark">Education</h3>
                        <p class="mt-2 text-sm text-finder-gray">Schools and learning</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Featured Businesses -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-finder-dark">Popular Businesses Near You</h2>
                    <p class="mt-4 text-lg text-finder-gray">Discover top-rated local businesses in your area</p>
                </div>
                
                <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Business Card: Chai Point -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform duration-300 hover:shadow-md hover:-translate-y-1">
                        <div class="h-48 bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                                alt="Chai Point" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-finder-dark">Chai Point</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    4.8 <i data-lucide="star" class="h-3 w-3 ml-1" fill="currentColor"></i>
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-finder-blue">Coffee & Tea • 0.5 km away</p>
                            <p class="mt-3 text-sm text-finder-gray line-clamp-2">
                                Premium tea shop offering a variety of Indian teas, snacks, and quick bites.
                            </p>
                            <div class="mt-5 flex justify-between items-center">
                                <div class="flex items-center text-sm text-finder-gray">
                                    <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                                    MG Road, Bangalore
                                </div>
                                <a href="business-detail.php?id=1" class="text-finder-blue hover:text-finder-lightBlue text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Business Card: Crossword Books -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform duration-300 hover:shadow-md hover:-translate-y-1">
                        <div class="h-48 bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1526243741027-444d633d7365?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                                alt="Crossword Books" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-finder-dark">Crossword Books</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    4.6 <i data-lucide="star" class="h-3 w-3 ml-1" fill="currentColor"></i>
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-finder-blue">Books • 1.0 km away</p>
                            <p class="mt-3 text-sm text-finder-gray line-clamp-2">
                                Popular bookstore with extensive collection of Indian and international titles.
                            </p>
                            <div class="mt-5 flex justify-between items-center">
                                <div class="flex items-center text-sm text-finder-gray">
                                    <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                                    Connaught Place, Delhi
                                </div>
                                <a href="business-detail.php?id=2" class="text-finder-blue hover:text-finder-lightBlue text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Business Card: FabIndia -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform duration-300 hover:shadow-md hover:-translate-y-1">
                        <div class="h-48 bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                                alt="FabIndia" class="w-full h-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-finder-dark">FabIndia</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    4.5 <i data-lucide="star" class="h-3 w-3 ml-1" fill="currentColor"></i>
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-finder-blue">Clothing • 0.7 km away</p>
                            <p class="mt-3 text-sm text-finder-gray line-clamp-2">
                                Authentic Indian ethnic wear and handcrafted products from local artisans.
                            </p>
                            <div class="mt-5 flex justify-between items-center">
                                <div class="flex items-center text-sm text-finder-gray">
                                    <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                                    Linking Road, Mumbai
                                </div>
                                <a href="business-detail.php?id=3" class="text-finder-blue hover:text-finder-lightBlue text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 text-center">
                    <a href="discover.php" class="inline-flex items-center px-4 py-2 border border-finder-blue text-base font-medium rounded-md text-finder-blue bg-white hover:bg-blue-50 transition-colors duration-300">
                        See All Businesses
                        <i data-lucide="arrow-right" class="ml-2 h-5 w-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
