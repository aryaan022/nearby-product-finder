
<?php
session_start();
$pageTitle = "Register Your Business";
$errors = [];
$success = false;

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $business_name = mysqli_real_escape_string($conn, $_POST['business_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    
    // Validation
    if (empty($business_name)) $errors[] = "Business name is required";
    if (empty($category)) $errors[] = "Category is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($city)) $errors[] = "City is required";
    if (empty($state)) $errors[] = "State is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password != $confirm_password) $errors[] = "Passwords do not match";
    
    // Check if email already exists
    $check_query = "SELECT * FROM businesses WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered. Please use a different email or login.";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert business
        $query = "INSERT INTO businesses (business_name, category, address, city, state, postal_code, phone, email, description, password, owner_name, status) 
                 VALUES ('$business_name', '$category', '$address', '$city', '$state', '$postal_code', '$phone', '$email', '$description', '$hashed_password', '$owner_name', 'pending')";
        
        if (mysqli_query($conn, $query)) {
            $success = true;
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
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
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-20">
        <div class="max-w-4xl mx-auto px-4 py-10">
            <h1 class="text-3xl font-bold text-finder-dark mb-8">Register Your Business</h1>
            
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <p class="font-bold">Registration Successful!</p>
                    <p>Your business has been registered and is pending approval. You can now <a href="business-login.php" class="underline">login to your dashboard</a>.</p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <p class="font-bold">Please fix the following errors:</p>
                    <ul class="list-disc ml-5">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!$success): ?>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="bg-white shadow-md rounded-lg p-6 space-y-6">
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-finder-dark">Business Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name*</label>
                                <input type="text" id="business_name" name="business_name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                       value="<?php echo isset($_POST['business_name']) ? htmlspecialchars($_POST['business_name']) : ''; ?>">
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                                <select id="category" name="category" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                                    <option value="" disabled <?php echo !isset($_POST['category']) ? 'selected' : ''; ?>>Select a category</option>
                                    <option value="Coffee & Tea" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Coffee & Tea') ? 'selected' : ''; ?>>Coffee & Tea</option>
                                    <option value="Retail" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Retail') ? 'selected' : ''; ?>>Retail</option>
                                    <option value="Food" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Food') ? 'selected' : ''; ?>>Food</option>
                                    <option value="Books" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Books') ? 'selected' : ''; ?>>Books</option>
                                    <option value="Clothing" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Clothing') ? 'selected' : ''; ?>>Clothing</option>
                                    <option value="Outdoor" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Outdoor') ? 'selected' : ''; ?>>Outdoor</option>
                                    <option value="Gifts" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Gifts') ? 'selected' : ''; ?>>Gifts</option>
                                    <option value="Services" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Services') ? 'selected' : ''; ?>>Services</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Business Description</label>
                            <textarea id="description" name="description" rows="3" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                            <input type="text" id="address" name="address" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                  value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City*</label>
                                <input type="text" id="city" name="city" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                            </div>
                            
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State*</label>
                                <select id="state" name="state" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                                    <option value="" disabled <?php echo !isset($_POST['state']) ? 'selected' : ''; ?>>Select a state</option>
                                    <option value="Andhra Pradesh" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Andhra Pradesh') ? 'selected' : ''; ?>>Andhra Pradesh</option>
                                    <option value="Assam" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Assam') ? 'selected' : ''; ?>>Assam</option>
                                    <option value="Bihar" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Bihar') ? 'selected' : ''; ?>>Bihar</option>
                                    <option value="Delhi" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Delhi') ? 'selected' : ''; ?>>Delhi</option>
                                    <option value="Goa" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Goa') ? 'selected' : ''; ?>>Goa</option>
                                    <option value="Gujarat" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Gujarat') ? 'selected' : ''; ?>>Gujarat</option>
                                    <option value="Karnataka" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Karnataka') ? 'selected' : ''; ?>>Karnataka</option>
                                    <option value="Kerala" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Kerala') ? 'selected' : ''; ?>>Kerala</option>
                                    <option value="Madhya Pradesh" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Madhya Pradesh') ? 'selected' : ''; ?>>Madhya Pradesh</option>
                                    <option value="Maharashtra" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Maharashtra') ? 'selected' : ''; ?>>Maharashtra</option>
                                    <option value="Punjab" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Punjab') ? 'selected' : ''; ?>>Punjab</option>
                                    <option value="Rajasthan" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Rajasthan') ? 'selected' : ''; ?>>Rajasthan</option>
                                    <option value="Tamil Nadu" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Tamil Nadu') ? 'selected' : ''; ?>>Tamil Nadu</option>
                                    <option value="Telangana" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Telangana') ? 'selected' : ''; ?>>Telangana</option>
                                    <option value="Uttar Pradesh" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Uttar Pradesh') ? 'selected' : ''; ?>>Uttar Pradesh</option>
                                    <option value="West Bengal" <?php echo (isset($_POST['state']) && $_POST['state'] == 'West Bengal') ? 'selected' : ''; ?>>West Bengal</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo isset($_POST['postal_code']) ? htmlspecialchars($_POST['postal_code']) : ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-6">
                    
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-finder-dark">Contact Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">Owner/Manager Name</label>
                                <input type="text" id="owner_name" name="owner_name" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo isset($_POST['owner_name']) ? htmlspecialchars($_POST['owner_name']) : ''; ?>">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                                <input type="tel" id="phone" name="phone" required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                      value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                            <input type="email" id="email" name="email" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                                  value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            <p class="mt-1 text-sm text-gray-500">This will be used for login to your business dashboard</p>
                        </div>
                    </div>
                    
                    <hr class="my-6">
                    
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-finder-dark">Account Setup</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                                <input type="password" id="password" name="password" required minlength="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                                <p class="mt-1 text-sm text-gray-500">Minimum 8 characters</p>
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password*</label>
                                <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-finder-blue hover:bg-finder-lightBlue text-white font-medium py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                            Register Business
                        </button>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Already registered? <a href="business-login.php" class="text-finder-blue hover:underline">Login to your business dashboard</a>
                        </p>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
