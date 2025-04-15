
<header class="bg-white shadow-sm fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="index.php" class="flex-shrink-0 flex items-center">
                    <span class="text-finder-blue text-xl font-bold">LocalFinder</span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <a href="index.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                    Home
                </a>
                <a href="discover.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                    Discover
                </a>
                <a href="about.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                    About
                </a>
                <a href="founders.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                    Founders
                </a>
                <a href="contact.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                    Contact
                </a>
                <div class="border-l border-gray-300 h-6 mx-2"></div>
                <?php if(isset($_SESSION['business_id'])): ?>
                    <a href="business-dashboard.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Business Dashboard
                    </a>
                    <a href="logout.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </a>
                <?php elseif(isset($_SESSION['admin_id'])): ?>
                    <a href="admin-dashboard.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Admin Dashboard
                    </a>
                    <a href="logout.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="business-login.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Business Login
                    </a>
                    <a href="register-business.php" class="bg-finder-blue hover:bg-finder-lightBlue text-white px-4 py-2 rounded-md">
                        Register Business
                    </a>
                    <a href="admin-login.php" class="text-finder-dark hover:text-finder-blue px-3 py-2 rounded-md text-sm font-medium">
                        Admin
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="flex md:hidden items-center">
                <button
                    onclick="toggleMobileMenu()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-finder-gray hover:text-finder-blue hover:bg-gray-100 focus:outline-none"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <i data-lucide="menu" class="mobile-menu-icon"></i>
                    <i data-lucide="x" class="mobile-menu-close hidden"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white">
            <a href="index.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                Home
            </a>
            <a href="discover.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                Discover
            </a>
            <a href="about.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                About
            </a>
            <a href="founders.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                Founders
            </a>
            <a href="contact.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                Contact
            </a>
            
            <?php if(isset($_SESSION['business_id'])): ?>
                <a href="business-dashboard.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Business Dashboard
                </a>
                <a href="logout.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Logout
                </a>
            <?php elseif(isset($_SESSION['admin_id'])): ?>
                <a href="admin-dashboard.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Admin Dashboard
                </a>
                <a href="logout.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Logout
                </a>
            <?php else: ?>
                <a href="business-login.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Business Login
                </a>
                <a href="register-business.php" class="bg-finder-blue hover:bg-finder-lightBlue text-white block px-3 py-2 rounded-md text-base font-medium mt-2">
                    Register Business
                </a>
                <a href="admin-login.php" class="text-finder-dark hover:text-finder-blue block px-3 py-2 rounded-md text-base font-medium">
                    Admin
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.querySelector('.mobile-menu-icon');
        const closeIcon = document.querySelector('.mobile-menu-close');
        
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }
</script>
