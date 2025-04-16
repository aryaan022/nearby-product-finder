
-- Create businesses table with latitude and longitude
ALTER TABLE businesses ADD COLUMN latitude DECIMAL(10, 8) NULL AFTER postal_code;
ALTER TABLE businesses ADD COLUMN longitude DECIMAL(11, 8) NULL AFTER latitude;

-- In a real application, you would update existing records with actual coordinates
-- For demonstration purposes, you can use the following when creating a new business:

/*
-- Example when inserting a new business
INSERT INTO businesses (
    business_name, 
    category, 
    description, 
    address, 
    city, 
    state, 
    postal_code, 
    latitude, 
    longitude, 
    phone, 
    email, 
    password, 
    owner_name, 
    status
) VALUES (
    'Business Name', 
    'Category', 
    'Description', 
    '123 Main Street', 
    'City', 
    'State', 
    '12345', 
    12.3456789, 
    77.1234567, 
    '+91 12345 67890', 
    'email@example.com', 
    'hashed_password', 
    'Owner Name', 
    'approved'
);
*/

-- To update existing businesses with coordinates (in a real application)
-- UPDATE businesses SET latitude = 12.9352, longitude = 77.6245 WHERE id = 1;
