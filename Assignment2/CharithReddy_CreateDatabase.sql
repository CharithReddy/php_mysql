drop database if exists charith_reddy_262_cars;

create database charith_reddy_262_cars;

use charith_reddy_262_cars;

create table cars(
	carID int primary key auto_increment,
    carName VARCHAR(20),
    carDescription VARCHAR(300),
    quantityAvailable int,
    price decimal(8, 2),
    fuelType VARCHAR(10),
    driveType VARCHAR(5),
    addedBy VARCHAR(20),
    constraint fuel_ck check (fuelType in ('Gas', 'Electric', 'Hybrid')),
    constraint drive_ck check (driveType in ('AWD', 'FWD', 'RWD'))
);

INSERT INTO cars (carName, carDescription, quantityAvailable, price, fuelType, driveType, addedBy)
VALUES 
('Tesla Model S', 
'The Tesla Model S is a fast electric sedan with modern features and long range.',
10, 79999.99, 'Electric', 'AWD', 'Charith'),
('Ford Mustang', 
'The Ford Mustang is a classic muscle car with a powerful engine and sleek design.',
5, 55999.50, 'Gas', 'RWD', 'Charith'),
('Toyota Prius', 
'The Toyota Prius is a hybrid vehicle known for its exceptional fuel efficiency and eco-friendliness.',
12, 25999.99, 'Hybrid', 'FWD', 'Charith'),
('Chevrolet Bolt EV', 
'The Chevrolet Bolt EV is a compact, fully electric vehicle with excellent range and efficiency.',
7, 36999.99, 'Electric', 'FWD', 'Charith'),
('BMW X5', 
'The BMW X5 is a luxurious midsize SUV offering powerful performance and advanced features.',
6, 75999.00, 'Gas', 'AWD', 'Charith'),
('Honda Civic', 
'The Honda Civic is a practical, fuel-efficient compact car ideal for daily commuting.',
15, 23999.95, 'Gas', 'FWD', 'Charith'),
('Subaru Outback', 
'The Subaru Outback is an all-terrain wagon with AWD and excellent off-road capabilities.',
8, 34999.50, 'Gas', 'AWD', 'Charith'),
('Nissan Leaf', 
'The Nissan Leaf is an affordable electric car with modern features and solid range.',
9, 31999.99, 'Electric', 'FWD', 'Charith');

select * from cars;

