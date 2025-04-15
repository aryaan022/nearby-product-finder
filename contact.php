
<?php
$pageTitle = "Contact Us";
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
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 max-w-7xl mx-auto mt-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"> Your message has been sent successfully. We'll get back to you soon.</span>
            </div>
        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-7xl mx-auto mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"> 
                    <?php if(isset($_GET['message']) && $_GET['message'] == 'database'): ?>
                        There was a problem connecting to the database. Please try again later.
                    <?php elseif(isset($_GET['message']) && $_GET['message'] == 'insert'): ?>
                        There was a problem saving your message. Please try again later.
                    <?php else: ?>
                        There was a problem processing your request. Please try again.
                    <?php endif; ?>
                </span>
            </div>
        <?php endif; ?>

        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-finder-dark mb-4">Contact Us</h1>
                    <p class="text-lg text-finder-gray max-w-2xl mx-auto">
                        Have a question or feedback? We'd love to hear from you. Fill out the form below and our team will get back to you shortly.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="col-span-1 md:col-span-1 bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-bold text-finder-dark mb-6">Get In Touch</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <i data-lucide="map-pin" class="h-6 w-6 text-finder-blue mr-4 mt-1"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Our Location</h3>
                                    <p class="text-finder-gray mt-1">
                                        123 Main Street, Koramangala<br />
                                        Bangalore, Karnataka 560034<br />
                                        India
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i data-lucide="mail" class="h-6 w-6 text-finder-blue mr-4 mt-1"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Email Us</h3>
                                    <p class="text-finder-gray mt-1">
                                        info@localfinder.in<br />
                                        support@localfinder.in
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i data-lucide="phone" class="h-6 w-6 text-finder-blue mr-4 mt-1"></i>
                                <div>
                                    <h3 class="font-medium text-finder-dark">Call Us</h3>
                                    <p class="text-finder-gray mt-1">
                                        +91 98765 43210<br />
                                        +91 80 4321 5678
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 p-4 bg-gray-50 rounded-md">
                            <h3 class="font-medium text-finder-dark mb-2">Business Hours</h3>
                            <ul class="text-finder-gray space-y-1">
                                <li class="flex justify-between">
                                    <span>Monday - Friday:</span>
                                    <span>9:00 AM - 6:00 PM</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Saturday:</span>
                                    <span>10:00 AM - 4:00 PM</span>
                                </li>
                                <li class="flex justify-between">
                                    <span>Sunday:</span>
                                    <span>Closed</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-bold text-finder-dark mb-6">Send Us a Message</h2>
                        
                        <form action="process_contact.php" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        placeholder="John Doe"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                        required
                                    />
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Your Email</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        placeholder="john@example.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input 
                                        type="text" 
                                        id="phone" 
                                        name="phone" 
                                        placeholder="+91 98765 43210"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                    />
                                </div>
                                
                                <div class="space-y-2">
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                    <input 
                                        type="text" 
                                        id="subject" 
                                        name="subject" 
                                        placeholder="How can we help you?"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                        required
                                    />
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    placeholder="Tell us more about your query..."
                                    rows="6"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-finder-blue focus:border-finder-blue"
                                    required
                                ></textarea>
                            </div>
                            
                            <button 
                                type="submit" 
                                class="inline-flex items-center justify-center bg-finder-blue hover:bg-finder-lightBlue text-white px-6 py-3 rounded-md font-medium transition-colors w-full md:w-auto"
                            >
                                <span>Send Message</span>
                                <i data-lucide="send" class="ml-2 h-4 w-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-12">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-bold text-finder-dark mb-6">Find Us On Map</h2>
                        <div id="map" class="h-96 rounded-md"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Initialize the map
        const map = L.map('map').setView([12.9352, 77.6245], 15); // Koramangala coordinates
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add a marker for the office location
        const marker = L.marker([12.9352, 77.6245]).addTo(map);
        marker.bindPopup("<b>LocalFinder Office</b><br>123 Main Street, Koramangala<br>Bangalore, Karnataka 560034").openPopup();
    </script>
</body>
</html>
