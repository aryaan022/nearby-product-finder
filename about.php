
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LocalFinder</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-icons@0.265.0/dist/umd/lucide.min.js">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-16">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-finder-dark sm:text-5xl">
                        About LocalFinder
                    </h1>
                    <p class="mt-4 text-xl text-finder-gray max-w-3xl mx-auto">
                        Bridging the gap between local businesses and customers across India.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Our Story Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-finder-dark">Our Story</h2>
                        <div class="mt-6 text-finder-gray space-y-4">
                            <p>
                                LocalFinder was born from a simple observation: while the world was becoming more connected digitally, local businesses in India were being left behind. Founded in 2021 in Bangalore, our mission has been to build technology that creates real-world connections.
                            </p>
                            <p>
                                We noticed that small businesses across the country had amazing products but struggled to reach customers beyond their immediate locality. Meanwhile, customers were looking for specific products but didn't know which local shops carried them without physically visiting multiple stores.
                            </p>
                            <p>
                                This disconnect inspired us to create a platform that would bridge this gap, empowering local retailers while giving customers the convenience of modern shopping with the authenticity of local businesses.
                            </p>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Our Story" class="rounded-lg shadow-lg">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our Mission Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-finder-dark">Our Mission & Values</h2>
                    <p class="mt-4 text-finder-gray max-w-3xl mx-auto">
                        We're guided by a set of core principles that inform everything we do.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="map-pin" class="text-finder-blue"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-finder-dark mb-2">Community First</h3>
                        <p class="text-finder-gray">
                            We believe in strengthening local economies by connecting businesses with customers in their community, fostering growth and sustainability.
                        </p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="search" class="text-finder-blue"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-finder-dark mb-2">Transparency</h3>
                        <p class="text-finder-gray">
                            We're committed to clear, honest relationships with businesses and customers alike, with no hidden fees or misleading information.
                        </p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="zap" class="text-finder-blue"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-finder-dark mb-2">Innovation</h3>
                        <p class="text-finder-gray">
                            We continuously strive to improve our technology to better serve the evolving needs of Indian businesses and shoppers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Impact Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-finder-dark">Our Impact</h2>
                    <p class="mt-4 text-finder-gray max-w-3xl mx-auto">
                        We're proud of the difference we're making in communities across India.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <p class="text-4xl font-bold text-finder-blue">5,000+</p>
                        <p class="mt-2 text-finder-gray">Local Businesses</p>
                    </div>
                    
                    <div>
                        <p class="text-4xl font-bold text-finder-blue">50+</p>
                        <p class="mt-2 text-finder-gray">Cities Across India</p>
                    </div>
                    
                    <div>
                        <p class="text-4xl font-bold text-finder-blue">100,000+</p>
                        <p class="mt-2 text-finder-gray">Monthly Active Users</p>
                    </div>
                    
                    <div>
                        <p class="text-4xl font-bold text-finder-blue">₹10Cr+</p>
                        <p class="mt-2 text-finder-gray">Revenue Generated for Businesses</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Team Section (Link to Founders) -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-finder-dark">Meet Our Team</h2>
                <p class="mt-4 text-finder-gray max-w-3xl mx-auto mb-8">
                    Our dedicated team is passionate about empowering local businesses and creating a seamless experience for customers.
                </p>
                
                <a href="founders.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-finder-blue hover:bg-finder-lightBlue transition-colors duration-300">
                    Meet Our Founders
                    <i data-lucide="arrow-right" class="ml-2 h-5 w-5"></i>
                </a>
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
