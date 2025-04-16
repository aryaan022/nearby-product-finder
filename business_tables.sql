
-- SQL query to create businesses table

CREATE TABLE `businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text,
  `address` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample business data (this would typically be added through the registration form)
INSERT INTO `businesses` (
  `business_name`, 
  `category`, 
  `description`, 
  `address`, 
  `city`, 
  `state`, 
  `postal_code`, 
  `phone`, 
  `email`, 
  `password`, 
  `owner_name`, 
  `status`
) VALUES 
(
  'Chai & Coffee House', 
  'Coffee & Tea', 
  'A premium specialty coffee and tea experience in the heart of Delhi.', 
  '123 Connaught Place', 
  'New Delhi', 
  'Delhi', 
  '110001', 
  '+91 98765 43210', 
  'info@chaiandcoffee.com', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Rahul Sharma', 
  'approved'
),
(
  'Bookworm Haven', 
  'Books', 
  'Your favorite local bookstore with a vast collection of books across all genres.', 
  '45 MG Road', 
  'Bangalore', 
  'Karnataka', 
  '560001', 
  '+91 99887 76655', 
  'contact@bookwormhaven.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Meera Patel', 
  'approved'
),
(
  'Spice Route Restaurant', 
  'Food', 
  'Authentic Indian cuisine with a modern twist. We use locally sourced ingredients.', 
  '78 Park Street', 
  'Kolkata', 
  'West Bengal', 
  '700016', 
  '+91 88776 65544', 
  'eat@spiceroute.co.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Amit Roy', 
  'approved'
),
(
  'TechGadgets Store', 
  'Retail', 
  'Latest gadgets and electronics at competitive prices with expert service.', 
  '34 Linking Road', 
  'Mumbai', 
  'Maharashtra', 
  '400050', 
  '+91 77665 54433', 
  'sales@techgadgetsstore.com', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Vikram Shah', 
  'approved'
),
(
  'Urban Threads', 
  'Clothing', 
  'Trendy fashion boutique offering both western and ethnic wear for all occasions.', 
  '56 Model Town', 
  'Jaipur', 
  'Rajasthan', 
  '302001', 
  '+91 66554 43322', 
  'shop@urbanthreads.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Priya Joshi', 
  'approved'
),
(
  'Green Gardens Nursery', 
  'Outdoor', 
  'Complete selection of plants, gardening supplies and expert advice for your garden.', 
  '89 ECR Road', 
  'Chennai', 
  'Tamil Nadu', 
  '600041', 
  '+91 55443 32211', 
  'grow@greengardens.co.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Surya Raman', 
  'approved'
),
(
  'Craft Corner', 
  'Gifts', 
  'Handcrafted gifts and home decor items made by local artisans.', 
  '23 Civil Lines', 
  'Lucknow', 
  'Uttar Pradesh', 
  '226001', 
  '+91 44332 21100', 
  'hello@craftcorner.com', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Anjali Srivastava', 
  'approved'
),
(
  'Wellness Spa Center', 
  'Services', 
  'Rejuvenate your body and mind with our premium spa and wellness treatments.', 
  '12 Jubilee Hills', 
  'Hyderabad', 
  'Telangana', 
  '500033', 
  '+91 33221 10099', 
  'relax@wellnessspa.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Kiran Reddy', 
  'approved'
),
(
  'Mountain Trekkers', 
  'Outdoor', 
  'Your one-stop shop for all trekking and outdoor adventure equipment and guided tours.', 
  '78 Mall Road', 
  'Shimla', 
  'Himachal Pradesh', 
  '171001', 
  '+91 22110 09988', 
  'trek@mountaintrekkers.com', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Arun Thakur', 
  'pending'
),
(
  'Digital Solutions', 
  'Services', 
  'Professional web development and digital marketing services for small businesses.', 
  '45 IT Park', 
  'Pune', 
  'Maharashtra', 
  '411014', 
  '+91 11009 98877', 
  'info@digitalsolutions.in', 
  '$2y$10$kOKnNUi1xt4KGZyJthbCVu6ecA0mJIEhsQZOFJcLdZacZL9CQfqmO', -- Hashed password: password123
  'Nikhil Desai', 
  'pending'
);
