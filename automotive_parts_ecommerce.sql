-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 10:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `automotive_parts_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address_type` enum('billing','shipping') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`) VALUES
(1, 'Weight (Kg)'),
(2, 'Dimensions (L/W/H inches)'),
(3, 'Color'),
(4, 'Voltage'),
(5, 'Material'),
(6, 'Engine Type Compatibility');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(1, 1, 1, 1, '2024-11-07 14:52:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`, `featured`) VALUES
(1, 'Electric Powertrain', 'Parts related to electric propulsion systems, including components like electric motors, inverters, batteries, and cooling systems essential for electric vehicles (EVs) to function efficiently.', NULL, 0),
(2, 'ICE Powertrain', 'Components of the internal combustion engine (ICE), including engine structural parts, valvetrain, fuel systems, and other elements responsible for traditional gasoline or diesel engine operation.', NULL, 0),
(3, 'Driveline Parts', 'Components that transmit power from the engine or motor to the wheels, including differentials, axles, driveshafts, and propeller shafts, ensuring efficient movement and control of the vehicle.', NULL, 1),
(4, 'AD / ADAS / Telematics', 'Systems for autonomous driving, driver assistance, and vehicle communication. These include advanced driver assistance systems (ADAS), telematics, cameras, radars, and other sensors that enhance safety and navigation.', NULL, 0),
(5, 'Electrical / Electronic Parts', 'Components that provide electrical power and control within the vehicle, including ECUs (Electronic Control Units), wiring harnesses, batteries, alternators, sensors, and connectors, ensuring proper function of all electronic systems.', NULL, 0),
(6, 'Interior Parts', 'Components inside the vehicle cabin, such as seats, dashboards, instrument panels, trim, airbag modules, and various controls that contribute to the vehicle’s aesthetics, functionality, and safety.', NULL, 0),
(7, 'Exterior Parts', 'The external components of the vehicle, including bumpers, grilles, mirrors, lighting systems, and body moldings, which provide both aesthetic appeal and protection.', NULL, 0),
(8, 'Chassis Parts', 'The structural framework of the vehicle that supports the body and various mechanical systems, including suspension components, control arms, cross members, and stabilizers, which ensure vehicle stability and handling.', NULL, 0),
(9, 'Body Parts', 'Panels and structural elements that form the exterior shell of the vehicle, including doors, hoods, trunks, fenders, and other protective reinforcements that provide safety and support to the overall structure.', NULL, 0),
(10, 'General Parts', 'Miscellaneous components used throughout the vehicle, such as fasteners, bolts, nuts, clips, adhesives, seals, and general commodities that play a crucial role in the assembly and maintenance of various systems.', NULL, 1),
(11, 'Drive Motor', 'The main electric motor responsible for vehicle propulsion, converting electrical energy into mechanical energy to drive the wheels.', 1, 0),
(12, 'e-Axle', 'A compact unit that integrates an electric motor, transmission, and power electronics to drive the vehicle’s axle, optimizing power delivery and efficiency.', 1, 0),
(13, 'Electric Powertrain System', 'The overall system that includes electric components responsible for generating, storing, and distributing power to drive the vehicle.', 1, 0),
(14, 'Electric Powertrain System Parts', 'Individual components within the electric powertrain system, such as inverters, converters, and control units, which manage power flow and conversion.', 1, 0),
(15, 'Fuel Cell System', 'A system that converts chemical energy from hydrogen into electricity through a fuel cell stack, providing an alternative power source for electric vehicles.', 1, 0),
(16, 'Battery Related Parts', 'Components involved in energy storage for electric vehicles, including battery modules, cells, and management systems like BMS (Battery Management System).', 1, 0),
(17, 'EV Cooling System', 'A system designed to manage the temperature of various electric vehicle components, including batteries, motors, and power electronics, ensuring optimal performance and safety.', 1, 0),
(18, 'Engine Structural Parts', 'Fundamental components that form the engine’s structure, including the engine block, cylinder head, pistons, and crankshaft, which provide support and shape to the internal combustion engine.', 2, 0),
(19, 'Valvetrain', 'Components that control the operation of the engine’s intake and exhaust valves, such as camshafts, valve lifters, and timing belts, ensuring proper air-fuel intake and exhaust gas expulsion.', 2, 0),
(20, 'Fuel Supply System', 'Parts responsible for delivering fuel to the engine, including fuel injectors, pumps, rails, and regulators, ensuring the correct amount of fuel is supplied for combustion.', 2, 0),
(21, 'Air Intake and Exhaust Systems', 'Systems managing air entering and exiting the engine, including air filters, intake manifolds, exhaust manifolds, catalytic converters, and mufflers, ensuring efficient combustion and emission control.', 2, 0),
(22, 'Turbochargers / Superchargers', 'Forced induction components, such as turbochargers and superchargers, that increase engine power by compressing air entering the combustion chamber.', 2, 0),
(23, 'Ignition System', 'Components responsible for igniting the air-fuel mixture, including spark plugs, ignition coils, distributors, and ignition modules, essential for engine starting and running.', 2, 0),
(24, 'Engine Lubrication Components', 'Parts that lubricate the engine’s moving components, such as oil pumps, filters, coolers, and oil pans, reducing friction and wear during operation.', 2, 0),
(25, 'Engine Cooling System', 'Components that manage engine temperature, including radiators, water pumps, thermostats, and cooling fans, preventing the engine from overheating.', 2, 0),
(26, 'Engine Electrical Parts', 'Electrical components involved in engine operation, such as alternators, starter motors, batteries, and engine control modules, ensuring the engine starts and runs efficiently.', 2, 0),
(27, 'Automatic Transmission', 'A type of transmission that automatically shifts gears without the need for driver input, including components like torque converters and planetary gear sets.', 2, 0),
(28, 'CVT (Continuously Variable Transmission)', 'A type of transmission that uses a belt and pulley system to provide seamless acceleration without traditional gear shifts, optimizing fuel efficiency and smoothness.', 2, 0),
(29, 'DCT (Dual Clutch Transmission)', 'A transmission with two clutches that allows for faster and more efficient gear changes, improving performance and fuel economy.', 2, 0),
(30, 'AMT (Automated Manual Transmission)', 'A manual transmission with automated gear and clutch controls, combining the efficiency of manual transmissions with the ease of automatic shifting.', 2, 0),
(31, 'Manual Transmission', 'A transmission that requires the driver to manually shift gears using a clutch and gear stick, providing greater control over the vehicle’s power delivery.', 2, 0),
(32, 'Clutch', 'Components that engage and disengage the engine from the transmission, including clutch discs, pressure plates, and release bearings, enabling smooth gear changes.', 2, 0),
(33, 'Transmission Parts', 'Various components involved in power transmission from the engine to the wheels, including gear sets, synchronizers, shafts, and shift levers.', 2, 0),
(34, 'Differential', 'A component that allows the wheels on the same axle to rotate at different speeds, crucial for smooth turns and traction control.', 3, 0),
(35, 'LSD (Limited Slip Differential)', 'A type of differential that limits the amount of slip between the two wheels, improving traction and handling, especially in low-grip conditions.', 3, 0),
(36, '4WD Transfer', 'The system that transfers power to both the front and rear axles in a four-wheel-drive vehicle, allowing for better control and traction on uneven terrain.', 3, 0),
(37, 'Axle', 'A central shaft that rotates the wheels and supports the weight of the vehicle. Axles can be solid or split depending on the vehicle type.', 3, 0),
(38, 'Power Take-off', 'A device that transfers mechanical power from the engine to auxiliary equipment, commonly used in agricultural or industrial vehicles.', 3, 0),
(39, 'AD / ADAS', 'Autonomous Driving (AD) and Advanced Driver Assistance Systems (ADAS) are technologies that assist the driver in vehicle operation, enhancing safety and convenience. These systems include features like lane-keeping assistance, adaptive cruise control, and automated emergency braking.', 4, 0),
(40, 'AD / ADAS Parts', 'Components that enable AD and ADAS functionalities, such as cameras, radar sensors, ultrasonic sensors, LiDAR, and control units, which gather and process data for real-time vehicle monitoring and assistance.', 4, 0),
(41, 'Telematics / Car Navigation', 'Systems that provide navigation, communication, and vehicle tracking through GPS, In-Vehicle Infotainment (IVI), and other connectivity technologies. These systems ensure drivers have real-time traffic information and connectivity for seamless travel.', 4, 0),
(42, 'Entertainment / Audio', 'In-vehicle entertainment systems, including audio systems (radio, speakers, amplifiers) and multimedia units, that enhance the in-car experience with music, video, and interactive media.', 4, 0),
(43, 'Security', 'Vehicle security systems that include keyless entry, immobilizers, and alarm systems to protect the vehicle from theft or unauthorized access.', 4, 1),
(44, 'Motor', 'Electric motors that power various vehicle systems, including window motors, wiper motors, radiator fans, and power steering motors, providing mechanical movement using electrical energy.', 5, 0),
(45, 'Interior Switch', 'Controls located inside the vehicle for various functions, such as the headlamp switch, wiper switch, mirror control switch, and power window switch, allowing the driver and passengers to operate vehicle features.', 5, 0),
(46, 'Hidden Switch', 'Switches that are not typically visible but play essential roles in vehicle operation, such as the oil pressure switch, brake lamp switch, and hood switch, which monitor and control critical functions behind the scenes.', 5, 0),
(47, 'Sensor', 'Electronic devices that detect and measure conditions such as temperature, pressure, and speed. Common examples include oxygen sensors, wheel speed sensors (ABS), and engine temperature sensors, providing essential data for vehicle systems.', 5, 0),
(48, 'Climate Control', 'This system regulates the temperature and air quality within the vehicle\'s cabin, ensuring passenger comfort and maintaining the proper function of temperature-sensitive components. It includes air conditioning, heating, and ventilation systems, as well as components specific to electric vehicles like battery cooling systems and PTC heaters.', NULL, 0),
(49, 'Air Conditioner', 'A system that cools the interior of the vehicle by circulating refrigerant to remove heat and humidity. Components include compressors, condensers, evaporators, and air conditioner hoses to maintain a comfortable cabin environment.', 48, 0),
(50, 'Heater', 'A system that warms the vehicle interior by transferring heat from the engine coolant to the cabin air through heater cores, hoses, and fans, providing comfort during cold weather.', 48, 0),
(51, 'EV Climate Control Parts', 'Specialized components for electric vehicles that regulate the temperature inside the cabin and manage battery cooling or heating. These include PTC heaters (Positive Temperature Coefficient heaters), heat pumps, and EV-specific air conditioning systems.', 48, 0),
(52, 'Climate Control Peripherals', 'Auxiliary components that support climate control functions, such as defrosters, blowers, air ducts, cabin air filters, and electric air purifiers, ensuring air quality and proper airflow within the cabin.', 48, 0),
(53, 'Instrument Panel', 'The dashboard area of the vehicle that houses essential controls and instruments, such as the speedometer, fuel gauge, and warning lights, providing the driver with critical information about the vehicle’s operation.', 6, 0),
(54, 'Display', 'Screens or panels that provide visual information, including LCD displays, touchscreens, and head-up displays (HUDs), which show navigation, entertainment, and vehicle data.', 6, 0),
(55, 'Airbag', 'Safety devices located in the steering wheel, dashboard, side panels, and other areas, designed to deploy in the event of a collision to protect occupants by reducing the impact force.', 6, 0),
(56, 'Seat', 'Components that provide seating for passengers and the driver, including seat frames, cushions, and adjusters. Seats may also include features such as heating, cooling, and electric adjustment controls.', 6, 0),
(57, 'Seat Belt', 'A critical safety system designed to restrain occupants during a collision. Components include the seat belt webbing, retractors, buckles, and adjusters, ensuring occupant safety.', 6, 0),
(58, 'Pedal', 'Controls used by the driver to operate the vehicle, including accelerator, brake, and clutch pedals, essential for vehicle speed regulation and stopping.', 6, 0),
(59, 'Interior Parts', 'General components within the vehicle cabin, including trim pieces, armrests, cup holders, and other fittings that enhance functionality, comfort, and aesthetics.', 6, 0),
(60, 'Lighting', 'Exterior lighting components such as headlights, tail lights, fog lamps, and turn signals that ensure visibility for the driver and signal the vehicle\'s movements to other road users.', 7, 1),
(61, 'Bumper', 'Protective components located at the front and rear of the vehicle, designed to absorb minor impacts and reduce damage during low-speed collisions.', 7, 0),
(62, 'Exterior Parts', 'General exterior components including mirrors, grilles, moldings, and other parts that contribute to both the aesthetic and protective functions of the vehicle.', 7, 0),
(63, 'Chassis Module', 'The structural frame of the vehicle that supports all mechanical components, including the suspension, engine, and transmission, providing the foundation for vehicle stability and safety.', 8, 0),
(64, 'Brake', 'The primary braking system that includes components like brake discs, pads, and calipers, responsible for slowing down or stopping the vehicle by converting kinetic energy into heat.', 8, 0),
(65, 'Sub-brake', 'Auxiliary braking systems such as the parking brake, electric parking brake (EPB), and auxiliary brakes, which provide additional control and safety.', 8, 0),
(66, 'ABS / TCS / ESC', 'Electronic systems that enhance vehicle stability and safety, including Anti-lock Braking System (ABS), Traction Control System (TCS), and Electronic Stability Control (ESC), which prevent wheel lockup and skidding.', 8, 0),
(67, 'Steering', 'The system that enables the driver to control the direction of the vehicle, consisting of components like the steering wheel, steering rack, and power steering systems.', 8, 0),
(68, 'Suspension', 'Components like control arms, shock absorbers, and springs that support vehicle handling, comfort, and stability by absorbing road impacts and maintaining wheel alignment.', 8, 0),
(69, 'Tire & Wheel', 'The tires and wheels that provide traction, support the vehicle’s weight, and ensure smooth movement. This includes components like tire valves, steel and alloy wheels, and wheel covers.', 8, 1),
(70, 'Body Panel / Frame', 'Structural components that form the exterior and framework of the vehicle, including roof panels, side panels, and frames that provide rigidity and protection.', 9, 0),
(71, 'Body Reinforcement and Protector', 'Components that strengthen and protect vulnerable areas of the vehicle body, such as side impact beams, splash guards, and mudguards, enhancing durability and safety.', 9, 0),
(72, 'Door', 'The panels that provide access to the vehicle interior, including hinges, door locks, handles, and power window mechanisms, ensuring security and ease of use.', 9, 0),
(73, 'Hood', 'The panel that covers the engine compartment, providing protection while allowing easy access for maintenance. It includes parts like hood locks, hinges, and gas springs.', 9, 0),
(74, 'Wiper', 'The system that clears rain, snow, and debris from the windshield and rear windows, including wiper arms, blades, and motors to ensure visibility during adverse weather conditions.', 9, 0),
(75, 'Fuel Tank', 'The storage component that holds fuel, including associated parts like filler pipes, valves, and gauges, ensuring safe containment and delivery of fuel to the engine.', 9, 0),
(76, 'Component', 'General vehicle components such as gears, bearings, and fasteners, which are used in various mechanical systems to facilitate movement and operation.', 10, 0),
(77, 'Pipe / Hose', 'Tubes and hoses that carry fluids and gases throughout the vehicle, including fuel lines, brake lines, and coolant hoses, essential for maintaining vehicle operation.', 10, 0),
(78, 'Bush / Seal', 'Components like rubber or metal bushings and seals that reduce friction and wear between moving parts, providing insulation and preventing leaks in various vehicle systems.', 10, 0),
(79, 'Adhesive / Tape', 'Materials used for bonding and securing components, including adhesives, tapes, and films, which provide structural integrity and protection during vehicle assembly and repair.', 10, 0),
(80, 'Paint', 'Coatings applied to the vehicle’s surface for aesthetic appeal and protection against corrosion, including primers, base coats, and clear coats to ensure a durable finish.', 10, 0),
(81, 'General Commodity', 'Miscellaneous parts and tools used in vehicle maintenance and operation, such as jacks, tool sets, child seats, and battery chargers, essential for various tasks and safety.', 10, 0),
(82, 'Drive motor', 'Permanent magnet synchronous motors for electric drive motors, providing efficient and reliable operation.', 11, 0),
(83, 'Motor core for drive motor', 'Core components of the drive motor, responsible for the conversion of electrical energy into mechanical power.', 11, 0),
(84, 'Rotor for drive motor', 'The rotating part of the drive motor that interacts with the stator to generate torque.', 11, 0),
(85, 'Rotor parts for drive motor', 'Various parts that make up the rotor, including laminations, shaft, and end rings.', 11, 0),
(86, 'Stator for drive motor', 'The stationary part of the drive motor that produces a magnetic field for rotor interaction.', 11, 0),
(87, 'Stator parts for drive motor', 'Components of the stator, including windings, core, and insulation, essential for motor operation.', 11, 0),
(88, 'Drive motor shaft', 'The central shaft that transmits mechanical power from the motor to the drivetrain.', 11, 0),
(89, 'Drive motor housing', 'The outer casing of the drive motor that protects internal components and supports the structure.', 11, 0),
(90, 'Drive motor resolver (angle sensor)', 'A sensor used in the drive motor to measure the rotational position of the rotor.', 11, 0),
(91, 'Parts for drive motor resolver (angle sensor)', 'Various components that make up the resolver, ensuring precise rotor position measurement.', 11, 0),
(92, 'e-Axle', 'A compact unit integrating electric motor, transmission, and power electronics for efficient axle power delivery.', 12, 0),
(93, 'Electric powertrain system', 'The complete system that encompasses all electric propulsion components, ensuring the vehicle’s efficient power delivery.', 13, 0),
(94, 'PCU (Power Control Unit)', 'The Power Control Unit that manages and distributes electrical power in electric vehicles.', 14, 0),
(95, 'Inverter', 'A device that converts DC power from the battery into AC power for the electric motor.', 14, 0),
(96, 'DC-DC converter for PCU', 'A component that steps down high-voltage DC power from the battery to low-voltage DC for vehicle electronics.', 14, 0),
(97, 'PCU parts', 'Various components that make up the Power Control Unit, ensuring proper power management.', 14, 0),
(98, 'EV speed reducer (reduction gear)', 'A gear system that reduces the motor’s high rotational speed to a usable level for driving the wheels.', 14, 0),
(99, 'Generator for HEV', 'A generator that converts mechanical energy into electrical energy, used in hybrid electric vehicles (HEVs).', 14, 0),
(100, 'In-wheel motor', 'An electric motor mounted inside the wheel, directly driving the wheel for enhanced control and efficiency.', 14, 0),
(101, 'In-wheel motor parts', 'Various components used in in-wheel motors, including windings, magnets, and housings.', 14, 0),
(102, 'Fuel cell system', 'The complete fuel cell system responsible for generating electricity from hydrogen and oxygen.', 15, 0),
(103, 'Fuel cell', 'A device that converts chemical energy from hydrogen into electricity via a chemical reaction.', 15, 0),
(104, 'Fuel cell stack', 'A collection of individual fuel cells that combine to generate the required power.', 15, 0),
(105, 'Hydrogen tank', 'The storage tank for hydrogen gas, providing fuel for the fuel cell system.', 15, 0),
(106, 'Fuel cell system parts', 'Various components that make up the fuel cell system, including stacks, separators, and tanks.', 15, 0),
(107, 'Fuel cell stack parts', 'Parts of the fuel cell stack, such as membranes and electrodes, essential for energy generation.', 15, 0),
(108, 'Fuel cell electrolyte membrane', 'The membrane in a fuel cell that allows ions to pass while keeping the gases separated.', 15, 0),
(109, 'Fuel cell separator', 'A component that separates individual fuel cells within the stack.', 15, 0),
(110, 'Fuel cell catalyst', 'A material that accelerates the chemical reaction within the fuel cell, often made of platinum.', 15, 0),
(111, 'Fuel cell electrodes', 'Electrodes that facilitate the electrochemical reaction in a fuel cell.', 15, 0),
(112, 'Fuel cell parts', 'General parts used within the fuel cell system, including catalysts, separators, and membranes.', 15, 0),
(113, 'BMS (Battery Management System)', 'A system that manages the battery’s performance, monitoring and controlling charge and discharge.', 16, 0),
(114, 'Battery case', 'The protective casing for batteries, ensuring safety and structural integrity.', 16, 0),
(115, 'Busbar', 'A conductive material used to distribute power within the battery system.', 16, 0),
(116, 'Super capacitor', 'A high-capacity capacitor that stores energy for quick discharge in hybrid and electric vehicles.', 16, 0),
(117, 'On-board battery charger', 'A charger integrated within the vehicle that charges the battery from external sources.', 16, 0),
(118, 'Charging equipment (normal / fast)', 'Equipment used for charging electric vehicles, either through normal or fast charging stations.', 16, 0),
(119, 'Integrated thermal management system for EV', 'A system that manages the temperature of various components in electric vehicles.', 17, 0),
(120, 'Thermal management system parts for EV', 'Various components that make up the thermal management system, such as pumps and fans.', 17, 0),
(121, 'Drive motor cooling system', 'A cooling system designed specifically to manage the temperature of the electric drive motor.', 17, 0),
(122, 'Drive motor cooling system parts', 'Individual components used in the cooling system for electric drive motors.', 17, 0),
(123, 'Battery cooling system', 'A system that cools the battery to maintain optimal performance and longevity.', 17, 0),
(124, 'Battery cooling plate', 'A plate that assists in the cooling of battery modules.', 17, 0),
(125, 'Battery cooling system parts', 'Components of the battery cooling system, such as pumps, pipes, and radiators.', 17, 0),
(126, 'Inverter cooling system', 'A system that cools the inverter, preventing overheating during high power loads.', 17, 0),
(127, 'Inverter cooling system parts', 'Parts of the inverter cooling system, including fans, pumps, and heat exchangers.', 17, 0),
(128, 'PCU cooling system', 'A system that cools the Power Control Unit (PCU) in electric vehicles.', 17, 0),
(129, 'PCU cooling system parts', 'Components used in the cooling system for the PCU, ensuring optimal temperature regulation.', 17, 0),
(130, 'Cylinder head cover', 'A cover that protects the cylinder head and its components from dust, dirt, and debris.', 18, 0),
(131, 'Cylinder head gasket', 'A gasket that seals the cylinder head to the engine block, preventing leaks.', 18, 0),
(132, 'Cylinder head bolt', 'Bolts used to secure the cylinder head to the engine block.', 18, 0),
(133, 'Piston', 'A component that moves within the cylinder to create compression for engine power.', 18, 0),
(134, 'Piston ring', 'Rings that provide a seal between the piston and cylinder wall, preventing gas leakage.', 18, 0),
(135, 'Piston pin', 'A pin connecting the piston to the connecting rod, allowing smooth movement.', 18, 0),
(136, 'Crankshaft', 'A rotating shaft that converts the pistons’ linear motion into rotational motion.', 18, 0),
(137, 'Balance shaft', 'A shaft designed to reduce engine vibration by counterbalancing the rotating components.', 18, 0),
(138, 'Balance shaft gear', 'A gear that transfers motion from the crankshaft to the balance shaft.', 18, 0),
(139, 'Crankcase', 'The lower part of the engine block that houses the crankshaft and other moving parts.', 18, 0),
(140, 'Crankcase ventilation system', 'A system that removes gases from the crankcase to reduce pressure and prevent oil leaks.', 18, 0),
(141, 'Crankcase ventilation valve', 'A valve that controls the release of gases from the crankcase.', 18, 0),
(142, 'Flywheel', 'A rotating disc that stores energy and helps smooth out engine operation.', 18, 0),
(143, 'Flywheel ring gear', 'The outer gear of the flywheel that engages with the starter motor to crank the engine.', 18, 0),
(144, 'Valvetrain system', 'A system that controls the operation of the intake and exhaust valves in an engine.', 19, 0),
(145, 'Intake valve', 'A valve that allows air to enter the combustion chamber during the intake stroke.', 19, 0),
(146, 'Exhaust valve', 'A valve that releases exhaust gases from the combustion chamber after combustion.', 19, 0),
(147, 'Valve spring', 'A spring that keeps the valves closed when not actuated by the camshaft.', 19, 0),
(148, 'Valve retainer', 'A component that holds the valve spring in place, ensuring proper valve operation.', 19, 0),
(149, 'Push rod', 'A rod that transfers motion from the camshaft to the rocker arms in overhead valve engines.', 19, 0),
(150, 'Camshaft', 'A shaft with lobes that controls the timing of valve opening and closing.', 19, 0),
(151, 'Timing chain/Belt', 'A chain or belt that synchronizes the movement of the camshaft and crankshaft.', 19, 0),
(152, 'Timing gear', 'Gears that work with the timing chain/belt to ensure proper timing between the crankshaft and camshaft.', 19, 0),
(153, 'Idler', 'A pulley that maintains tension on the timing chain/belt.', 19, 0),
(154, 'Chain tensioner', 'A device that maintains proper tension on the timing chain to prevent it from slipping.', 19, 0),
(155, 'Gasoline fuel injection system', 'A system that delivers fuel into the engine’s combustion chamber under high pressure.', 20, 0),
(156, 'Fuel rail', 'A pipe that distributes fuel to the fuel injectors in the fuel injection system.', 20, 0),
(157, 'Fuel injector', 'A device that sprays fuel into the engine’s combustion chamber for mixing with air.', 20, 0),
(158, 'Fuel injection nozzle', 'The nozzle at the end of the injector that atomizes the fuel for efficient combustion.', 20, 0),
(159, 'Throttle body', 'A component that controls the amount of air entering the engine, regulating engine power.', 20, 0),
(160, 'Throttle valve', 'A valve that regulates the airflow into the engine.', 20, 0),
(161, 'Pressure regulator', 'A device that maintains the proper fuel pressure for the fuel injection system.', 20, 0),
(162, 'Idle speed control valve', 'A valve that controls the amount of air entering the engine at idle to maintain a stable idle speed.', 20, 0),
(163, 'Swirl control valve', 'A valve that creates a swirling motion in the intake air for better fuel-air mixing.', 20, 0),
(164, 'Diesel injection system', 'A system that delivers diesel fuel into the engine’s combustion chamber under high pressure.', 20, 0),
(165, 'Diesel injection pump', 'A pump that delivers pressurized diesel fuel to the fuel injectors.', 20, 0),
(166, 'Injector nozzle', 'The nozzle at the end of the diesel fuel injector that atomizes the fuel.', 20, 0),
(167, 'Fuel filter', 'A filter that removes impurities from the fuel before it enters the engine.', 20, 0),
(168, 'Fuel filter housing', 'The casing that holds the fuel filter in place.', 20, 0),
(169, 'Fuel filter parts', 'Various components of the fuel filter system, including the housing and seals.', 20, 0),
(170, 'Air / Fuel module', 'A module that manages the mixture of air and fuel entering the engine for combustion.', 21, 0),
(171, 'Air intake module', 'A module that directs air into the engine’s intake manifold for combustion.', 21, 0),
(172, 'Intake manifold module', 'A module that distributes the air-fuel mixture to the cylinders in the engine.', 21, 0),
(173, 'Intake manifold', 'A part of the engine that distributes air to the cylinders.', 21, 0),
(174, 'Air cleaner', 'A device that removes contaminants from the air entering the engine.', 21, 0),
(175, 'Carburetor', 'A device that mixes air and fuel for combustion in older engines.', 21, 0),
(176, 'Automatic choke', 'A device that controls the amount of air entering the carburetor during engine starting.', 21, 0),
(177, 'Carburetor parts', 'Various components of the carburetor, including jets, needles, and valves.', 21, 0),
(178, 'Exhaust system', 'A system that removes exhaust gases from the engine and reduces noise.', 21, 0),
(179, 'Exhaust module', 'A module that manages the exhaust gases leaving the engine.', 21, 0),
(180, 'Exhaust manifold', 'A component that collects exhaust gases from multiple cylinders and directs them into the exhaust pipe.', 21, 0),
(181, 'Exhaust pipe', 'A pipe that directs exhaust gases out of the vehicle.', 21, 0),
(182, 'Muffler', 'A device that reduces the noise of the exhaust system.', 21, 0),
(183, 'Catalytic converter', 'A device that reduces harmful emissions from the exhaust gases.', 21, 0),
(184, 'Converter housing', 'The outer casing of the catalytic converter that houses the catalyst material.', 21, 0),
(185, 'Catalyst carrier', 'The structure that holds the catalyst material inside the catalytic converter.', 21, 0),
(186, 'Catalyst', 'A substance inside the catalytic converter that promotes the reduction of emissions.', 21, 0),
(187, 'Catalytic converter parts', 'Various components that make up the catalytic converter, including the catalyst and housing.', 21, 0),
(188, 'Air pump', 'A pump that injects air into the exhaust system to reduce emissions.', 21, 0),
(189, 'Turbocharger', 'A forced induction component that increases engine power by compressing intake air.', 22, 0),
(190, 'Turbine wheel', 'The rotating component of the turbocharger that drives compressed air into the engine.', 22, 0),
(191, 'Turbocharger parts', 'Various parts that make up the turbocharger, including housings, bearings, and compressors.', 22, 0),
(192, 'Supercharger', 'A forced induction component driven by a belt connected to the engine, increasing power output.', 22, 0),
(193, 'Supercharger intercooler', 'A component that cools the compressed air before it enters the engine, increasing efficiency.', 22, 0),
(194, 'Ignition system', 'A system that ignites the air-fuel mixture in the engine’s combustion chamber.', 23, 0),
(195, 'Ignition module', 'A control module that manages the ignition timing and coil operation.', 23, 0),
(196, 'Distributor', 'A component that routes high-voltage electricity from the ignition coil to the spark plugs.', 23, 0),
(197, 'Ignition coil', 'A component that converts low-voltage power to high-voltage power needed for spark plugs.', 23, 0),
(198, 'Igniter', 'A device that initiates combustion in the engine’s cylinders by igniting the fuel mixture.', 23, 0),
(199, 'Spark plug', 'A device that creates a spark to ignite the air-fuel mixture in the combustion chamber.', 23, 0),
(200, 'Glow plug', 'A heating device used to warm the combustion chamber in diesel engines.', 23, 0),
(201, 'High tension cable', 'Cables that deliver high-voltage electricity from the ignition coil to the spark plugs.', 23, 0),
(202, 'Ignition parts', 'Various components of the ignition system, including wires, plugs, and coils.', 23, 0),
(203, 'Oil pump', 'A pump that circulates oil to lubricate the engine’s moving parts.', 24, 0),
(204, 'Oil filter', 'A filter that removes contaminants from the engine oil.', 24, 0),
(205, 'Oil strainer', 'A device that filters large particles from the oil before it reaches the pump.', 24, 0),
(206, 'Oil cooler', 'A component that cools the engine oil to maintain optimal viscosity and performance.', 24, 0),
(207, 'Oil seal', 'A seal that prevents oil leakage from the engine.', 24, 0),
(208, 'Oil level gauge', 'A gauge that measures the amount of oil in the engine.', 24, 0),
(209, 'Engine cooling module', 'A module that manages the engine’s temperature through cooling components.', 25, 0),
(210, 'Cooling fan module', 'A module that controls the operation of the cooling fans to prevent engine overheating.', 25, 0),
(211, 'Cooling fan control module', 'A module that regulates the speed and operation of the engine’s cooling fans.', 25, 0),
(212, 'Radiator', 'A device that transfers heat from the engine coolant to the air to cool the engine.', 25, 0),
(213, 'Radiator cap', 'A cap that seals the radiator and maintains the correct pressure in the cooling system.', 25, 0),
(214, 'Cooling fan', 'A fan that blows air through the radiator to help cool the engine.', 25, 0),
(215, 'Cooling fan coupling', 'A coupling that connects the cooling fan to the engine.', 25, 0),
(216, 'Radiator fan shroud', 'A shroud that directs airflow through the radiator to improve cooling efficiency.', 25, 0),
(217, 'Cooling fan belt', 'A belt that drives the cooling fan, helping to maintain engine temperature.', 25, 0),
(218, 'Radiator hose', 'A hose that connects the engine to the radiator, allowing coolant flow.', 25, 0),
(219, 'Radiator hose clip', 'A clip that secures the radiator hose to prevent leaks.', 25, 0),
(220, 'Thermostat', 'A device that regulates the flow of coolant to maintain the engine at the correct temperature.', 25, 0),
(221, 'Starter motor', 'A motor that starts the engine by turning the crankshaft.', 26, 0),
(222, 'Alternator', 'A device that generates electrical power to charge the battery and run the vehicle’s electrical systems.', 26, 0),
(223, 'Battery', 'A storage device that provides electrical power for starting the engine and running accessories.', 26, 0),
(224, 'Battery cable', 'Cables that connect the battery to the starter and other electrical components.', 26, 0),
(225, 'IC regulator', 'A regulator that controls the output voltage of the alternator.', 26, 0),
(226, 'Ignition switch', 'A switch that activates the ignition system and starts the engine.', 26, 0),
(227, 'On-Board Diagnostics (OBD)', 'A system that monitors and reports vehicle performance and emissions.', 26, 0),
(228, 'Engine control parts', 'Various electronic components that manage and monitor the engine’s operation.', 26, 0),
(229, 'Automatic transmission assembly', 'The complete automatic transmission system, which shifts gears without driver input.', 27, 0),
(230, 'Torque converter', 'A component that transmits and multiplies engine torque to the transmission.', 27, 0),
(231, 'Torque converter parts', 'Various components of the torque converter, including the stator and impeller.', 27, 0),
(232, 'Lock Up Mechanism', 'A mechanism that locks the torque converter at higher speeds to improve efficiency.', 27, 0),
(233, 'Lock Up Mechanism Parts', 'Components that make up the lock up mechanism, including the clutch and valve.', 27, 0),
(234, 'Automatic transmission carrier', 'A component that holds the transmission gears and shafts.', 27, 0),
(235, 'Automatic transmission clutch', 'A clutch that engages and disengages the gears in an automatic transmission.', 27, 0),
(236, 'Automatic transmission fluid pump', 'A pump that circulates transmission fluid to cool and lubricate the transmission.', 27, 0),
(237, 'Automatic transmission shift lock mechanism', 'A mechanism that prevents the driver from shifting out of park without pressing the brake.', 27, 0),
(238, 'Automatic transmission control parts', 'Various components that control the operation of the automatic transmission.', 27, 0),
(239, 'CVT assembly', 'The complete Continuously Variable Transmission system, which provides smooth, gearless shifting.', 28, 0),
(240, 'CVT belt', 'A belt used in CVTs to transfer power between pulleys.', 28, 0),
(241, 'CVT parts', 'Various components used in the CVT, including pulleys and belts.', 28, 0),
(242, 'DCT assembly', 'The complete Dual Clutch Transmission system, providing faster gear shifts with two clutches.', 29, 0),
(243, 'DCT parts', 'Various components used in the Dual Clutch Transmission system.', 29, 0),
(244, 'AMT assembly', 'The complete Automated Manual Transmission system, which automates manual gear shifting.', 30, 0),
(245, 'AMT parts', 'Various components used in the Automated Manual Transmission system.', 30, 0),
(246, 'Manual transmission assembly', 'The complete manual transmission system that requires the driver to manually shift gears.', 31, 0),
(247, 'Transmission shaft', 'A rotating shaft that transmits power between the engine and the transmission.', 31, 0),
(248, 'Input shaft', 'A shaft that receives power from the engine and transmits it to the transmission gears.', 31, 0),
(249, 'Countershaft', 'A secondary shaft that transmits power to the output shaft through gears.', 31, 0),
(250, 'Output shaft', 'A shaft that transmits power from the transmission to the driveshaft.', 31, 0),
(251, 'Transmission gear', 'A set of gears that control the speed and torque output of the transmission.', 31, 0),
(252, 'Clutch assembly', 'The complete clutch system that engages and disengages the engine from the transmission.', 32, 0),
(253, 'Clutch cover complete', 'The complete cover assembly that protects and houses the clutch components.', 32, 0),
(254, 'Clutch cover', 'A protective cover for the clutch components.', 32, 0),
(255, 'Clutch spring', 'A spring that helps return the clutch to its engaged position.', 32, 0),
(256, 'Clutch pressure plate', 'A plate that applies pressure to the clutch disc, engaging the transmission.', 32, 0),
(257, 'Clutch disc', 'The disc that transmits power between the engine and the transmission when the clutch is engaged.', 32, 0),
(258, 'Clutch facing', 'The friction material on the clutch disc that engages with the flywheel.', 32, 0),
(259, 'Clutch master cylinder / pump', 'A hydraulic component that controls the engagement and disengagement of the clutch.', 32, 0),
(260, 'Shift lever', 'A lever used by the driver to manually shift gears in a transmission.', 33, 0),
(261, 'Shift knob', 'The handle at the end of the shift lever used to shift gears.', 33, 0),
(262, 'Shift lever parts', 'Various components associated with the shift lever, including linkages and bushings.', 33, 0),
(263, 'Shift fork', 'A component that engages and disengages gears by moving the synchronizers.', 33, 0),
(264, 'Transmission case', 'The housing that contains and protects the transmission gears and components.', 33, 0),
(265, 'Transmission rear cover', 'The rear cover that seals and protects the transmission case.', 33, 0),
(266, 'Differential', 'A mechanical component that allows the wheels on an axle to rotate at different speeds.', 34, 0),
(267, 'Differential case', 'The housing that encloses the differential gears and supports the axle shafts.', 34, 0),
(268, 'Differential gear', 'The gears within the differential that transfer power and allow for different wheel speeds.', 34, 0),
(269, 'Differential drive pinion gear', 'The gear that transfers rotational power from the driveshaft to the differential.', 34, 0),
(270, 'Differential pinion gear', 'A smaller gear that meshes with the ring gear to transfer power in the differential.', 34, 0),
(271, 'Differential side gear', 'A gear that transfers power to the axle shafts, allowing for differential movement.', 34, 0),
(272, 'Differential ring gear', 'The large gear that connects to the pinion gear to transfer power to the wheels.', 34, 0),
(273, 'Differential pinion shaft', 'The shaft that supports the pinion gear inside the differential.', 34, 0),
(274, 'Multiple LSD', 'A type of limited slip differential with multiple clutch plates for better traction control.', 35, 0),
(275, 'Torque sensing LSD', 'An LSD that senses torque differences and adjusts power distribution accordingly.', 35, 0),
(276, 'Viscous LSD', 'An LSD that uses a viscous fluid to distribute torque between the wheels.', 35, 0),
(277, 'Viscous coupling', 'A device that transfers torque using a viscous fluid, commonly found in LSD systems.', 35, 0),
(278, '4WD transfer', 'A component that distributes power to both the front and rear axles in a 4WD system.', 36, 0),
(279, '4WD transfer case', 'The case that houses the gears and components of the 4WD transfer system.', 36, 0),
(280, '4WD transfer gear', 'The gear that transfers power between the front and rear axles in a 4WD system.', 36, 0),
(281, '4WD parts', 'Various components that make up the 4WD transfer system, including gears and shafts.', 36, 0),
(282, 'Axle module', 'A complete axle assembly that includes the axle, differential, and supporting components.', 37, 0),
(283, 'Front axle module', 'A module that houses the front axle and its components.', 37, 0),
(284, 'Front axle corner module', 'A module that includes the front axle corners and wheel hubs.', 37, 0),
(285, 'Rear axle module', 'A module that houses the rear axle and its components.', 37, 0),
(286, 'Front axle', 'The axle that connects the front wheels of the vehicle.', 37, 0),
(287, 'Rear axle', 'The axle that connects the rear wheels of the vehicle.', 37, 0),
(288, 'Driveshaft', 'A shaft that transfers power from the transmission to the axle.', 37, 0),
(289, 'Axle shaft', 'A shaft that transfers power from the differential to the wheels.', 37, 0),
(290, 'Propeller shaft', 'A shaft that transfers rotational power from the transmission to the differential.', 37, 0),
(291, 'Propeller shaft center bearing', 'A bearing that supports the center of the propeller shaft to reduce vibrations.', 37, 0),
(292, 'Universal joint', 'A joint that allows the driveshaft to flex and rotate at different angles.', 37, 0),
(293, 'Wheel hub', 'The central component of the wheel that attaches to the axle and allows for wheel rotation.', 37, 0),
(294, 'Axle parts', 'Various components of the axle, including bearings, seals, and joints.', 37, 0),
(295, 'Power take-off', 'A device that transfers mechanical power from the engine to auxiliary equipment.', 38, 0),
(296, 'Autonomous Driving (AD) system', 'A system that controls the vehicle autonomously without human input.', 39, 0),
(297, 'Advanced Driver Assistance System (ADAS)', 'A suite of safety technologies designed to prevent accidents and assist drivers.', 39, 0),
(298, 'Forward Collision Warning (FCW)', 'A system that warns the driver of an impending collision.', 39, 0),
(299, 'Automatic Emergency Brake (AEB)', 'A system that automatically applies the brakes to prevent or mitigate a collision.', 39, 0),
(300, 'Lane Departure Warning System (LDWS)', 'A system that alerts the driver if the vehicle begins to drift out of its lane.', 39, 0),
(301, 'Adaptive Cruise Control (ACC)', 'A system that maintains a set distance from the vehicle in front by adjusting the car’s speed.', 39, 0),
(302, 'Cruise control', 'A system that automatically controls the speed of the vehicle.', 39, 0),
(303, 'Blind Spot Warning (BSW)', 'A system that alerts the driver when there is a vehicle in their blind spot.', 39, 0),
(304, 'Surround view monitor', 'A system that provides a 360-degree view around the vehicle to assist with parking and maneuvering.', 39, 0),
(305, 'Automatic parking system', 'A system that automates the parking process.', 39, 0),
(306, 'Parking assist', 'A system that assists the driver with steering and braking during parking maneuvers.', 39, 0),
(307, 'Tire Pressure Monitoring System (TPMS)', 'A system that monitors the air pressure inside the tires and warns the driver when it is low.', 39, 0),
(308, 'Rear View Monitor System (RVS)', 'A system that provides the driver with a view of the rear of the vehicle.', 40, 0),
(309, 'Image recognition camera', 'A camera that recognizes objects, signs, and other vehicles to aid autonomous driving.', 40, 0),
(310, 'View camera', 'A camera that provides a live feed of the vehicle’s surroundings.', 40, 0),
(311, 'Lens', 'The optical component of a camera used to capture images.', 40, 0),
(312, 'Millimeter wave radar', 'A radar system that uses millimeter waves to detect objects around the vehicle.', 40, 0),
(313, 'Light Detection And Ranging (LiDAR)', 'A remote sensing method that uses light in the form of a pulsed laser to measure distances.', 40, 0),
(314, 'Car navigation', 'A system that uses GPS to provide turn-by-turn directions.', 41, 0),
(315, 'Car navigation parts', 'Various components used in the car navigation system, such as GPS modules.', 41, 0),
(316, 'GPS', 'A satellite-based navigation system that provides location and time information.', 41, 0),
(317, 'GPS antenna', 'An antenna that receives GPS signals to determine the vehicle’s location.', 41, 0),
(318, 'In-Vehicle Infotainment (IVI) system', 'A system that provides entertainment and information to drivers and passengers through multimedia interfaces.', 41, 0),
(319, 'Car audio', 'An in-car audio system that provides music and radio playback.', 42, 0),
(320, 'Car radio', 'A radio system installed in the vehicle for receiving and playing broadcasted stations.', 42, 0),
(321, 'Audio amplifier', 'A device that increases the power of audio signals for louder sound output.', 42, 0),
(322, 'Speaker', 'A component that converts audio signals into audible sound.', 42, 0),
(323, 'Audio equalizer', 'A device that adjusts the balance between frequency components in an audio signal.', 42, 0),
(324, 'CD player / DVD player', 'A device that plays audio and video content from CDs and DVDs.', 42, 0),
(325, 'Car audio parts', 'Various components and accessories used in car audio systems.', 42, 0),
(326, 'Security system', 'A system that protects the vehicle from theft and unauthorized access.', 43, 0),
(327, 'Key set', 'A set of keys used to lock, unlock, and start the vehicle.', 43, 0),
(328, 'Keyless entry system', 'A system that allows the driver to lock and unlock the vehicle without using a key.', 43, 0),
(329, 'Immobilizer', 'A system that prevents the vehicle from being started without the correct key or code.', 43, 0),
(330, 'Throttle body motor', 'A motor that controls the opening and closing of the throttle body to regulate air intake.', 44, 0),
(331, 'Idle speed control motor', 'A motor that controls the engine’s idle speed by adjusting the air intake.', 44, 0),
(332, 'Fuel pump motor', 'A motor that powers the fuel pump, delivering fuel from the tank to the engine.', 44, 0),
(333, 'Radiator fan motor', 'A motor that powers the radiator fan to cool the engine.', 44, 0),
(334, 'Water pump motor', 'A motor that powers the water pump to circulate coolant through the engine.', 44, 0),
(335, 'Power steering motor', 'A motor that assists the driver in steering by providing hydraulic or electric power.', 44, 0),
(336, 'Steering position motor', 'A motor that adjusts the steering position based on the driver’s input.', 44, 0),
(337, 'Suspension leveling motor', 'A motor that adjusts the vehicle’s suspension height for a smoother ride.', 44, 0),
(338, 'ABS motor', 'A motor that controls the anti-lock braking system, preventing wheel lockup.', 44, 0),
(339, 'Power window motor', 'A motor that controls the up and down movement of the vehicle’s windows.', 44, 0),
(340, 'Wiper motor', 'A motor that powers the windshield wipers to clear rain and debris from the windshield.', 44, 0),
(341, 'Rear wiper motor', 'A motor that powers the rear windshield wipers.', 44, 0),
(342, 'Washer pump motor', 'A motor that pumps washer fluid onto the windshield for cleaning.', 44, 0),
(343, 'Blower fan motor', 'A motor that powers the blower fan in the HVAC system.', 44, 0),
(344, 'Heater fan motor', 'A motor that powers the fan in the vehicle’s heater system.', 44, 0),
(345, 'Door mirror retraction motor', 'A motor that folds the door mirrors when the vehicle is parked or moving in tight spaces.', 44, 0),
(346, 'Combination switch', 'A switch that combines multiple functions, such as turn signals, headlights, and wipers.', 45, 0),
(347, 'Lamp switch', 'A switch used to control the vehicle’s exterior lighting.', 45, 0),
(348, 'Turn signal switch', 'A switch that activates the turn signals.', 45, 0),
(349, 'Wiper switch', 'A switch that controls the operation of the windshield wipers.', 45, 0),
(350, 'Hazard switch', 'A switch that activates the vehicle’s hazard lights.', 45, 0),
(351, 'Rear defogger switch', 'A switch that activates the rear window defroster.', 45, 0),
(352, 'Fog lamp switch', 'A switch that activates the vehicle’s fog lights.', 45, 0),
(353, 'Mirror control switch', 'A switch that controls the adjustment of the side mirrors.', 45, 0),
(354, 'Power window switch', 'A switch that controls the movement of the power windows.', 45, 0),
(355, 'Steering switch', 'A switch located on the steering wheel that controls various functions like audio and cruise control.', 45, 0),
(356, 'Push lock switch', 'A switch that locks or unlocks the doors with a push button.', 45, 0),
(357, 'Panel switch', 'A switch located on the vehicle’s dashboard or center console for various functions.', 45, 0),
(358, 'Oil pressure switch', 'A switch that monitors engine oil pressure and alerts the driver when it is too low.', 46, 0),
(359, 'Thermo switch', 'A switch that controls the operation of temperature-dependent components.', 46, 0),
(360, 'Inhibitor switch', 'A switch that prevents the vehicle from starting unless it is in park or neutral.', 46, 0),
(361, 'Gear selector switch', 'A switch that detects the position of the gear selector and controls gear shifting.', 46, 0),
(362, 'Hood switch', 'A switch that detects whether the hood is open or closed.', 46, 0),
(363, 'Trunk lid switch', 'A switch that detects whether the trunk lid is open or closed.', 46, 0),
(364, 'Brake lamp switch', 'A switch that activates the brake lights when the brake pedal is pressed.', 46, 0);
INSERT INTO `categories` (`id`, `name`, `description`, `parent_id`, `featured`) VALUES
(365, 'Reverse lamp switch', 'A switch that activates the reverse lights when the vehicle is in reverse gear.', 46, 0),
(366, 'Horn switch', 'A switch that activates the vehicle’s horn.', 46, 0),
(367, 'Blower switch', 'A switch that controls the blower fan in the vehicle’s HVAC system.', 46, 0),
(368, 'Air conditioner pressure switch', 'A switch that monitors the pressure in the air conditioning system.', 46, 0),
(369, 'Air conditioner temperature switch', 'A switch that controls the operation of the air conditioning system based on temperature.', 46, 0),
(370, 'Air conditioner fan switch', 'A switch that controls the fan speed in the vehicle’s air conditioning system.', 46, 0),
(371, 'Engine temperature sensor', 'A sensor that measures the temperature of the engine to prevent overheating.', 47, 0),
(372, 'Air flow sensor', 'A sensor that measures the amount of air entering the engine.', 47, 0),
(373, 'Oxygen (O2) sensor', 'A sensor that measures the oxygen levels in the exhaust gases to optimize fuel combustion.', 47, 0),
(374, 'NOx sensor', 'A sensor that measures the levels of nitrogen oxides in the exhaust gases.', 47, 0),
(375, 'MAP (Manifold Absolute Pressure) sensor', 'A sensor that measures the pressure inside the intake manifold.', 47, 0),
(376, 'Accelerator pedal sensor', 'A sensor that detects the position of the accelerator pedal to regulate engine power.', 47, 0),
(377, 'Engine speed sensor', 'A sensor that measures the rotational speed of the engine.', 47, 0),
(378, 'Oil level sensor', 'A sensor that measures the amount of oil in the engine.', 47, 0),
(379, 'Oil condition sensor', 'A sensor that measures the quality and condition of the engine oil.', 47, 0),
(380, 'Fuel level sensor', 'A sensor that measures the amount of fuel remaining in the tank.', 47, 0),
(381, 'Speed sensor', 'A sensor that measures the speed of the vehicle.', 47, 0),
(382, 'Wheel speed sensor (ABS sensor)', 'A sensor that measures the rotational speed of the wheels to prevent skidding.', 47, 0),
(383, 'Steering angle sensor', 'A sensor that measures the angle of the steering wheel.', 47, 0),
(384, 'Airbag sensor', 'A sensor that detects a collision and triggers the airbag deployment.', 47, 0),
(385, 'Air conditioner temperature sensor', 'A sensor that measures the temperature inside the vehicle for climate control.', 47, 0),
(386, 'Climate control system', 'A system that regulates the temperature and air quality inside the vehicle.', 48, 0),
(387, 'Air conditioner', 'A system that cools the interior of the vehicle by circulating refrigerant.', 49, 0),
(388, 'Air conditioner compressor', 'A component that compresses and circulates refrigerant through the air conditioning system.', 49, 0),
(389, 'Air conditioner condenser', 'A heat exchanger that cools the refrigerant in the air conditioning system.', 49, 0),
(390, 'Air conditioner evaporator', 'A component that absorbs heat from the air to cool the vehicle interior.', 49, 0),
(391, 'Air conditioner clutch', 'A clutch that engages the air conditioner compressor.', 49, 0),
(392, 'Air conditioner hose', 'Hoses that carry refrigerant between the components of the air conditioning system.', 49, 0),
(393, 'Air conditioner parts', 'Various components that make up the air conditioning system.', 49, 0),
(394, 'Heater module', 'A module that provides heat to the vehicle interior using engine coolant.', 50, 0),
(395, 'Heater core', 'A component that transfers heat from the engine coolant to the cabin air.', 50, 0),
(396, 'Heater solenoid valve', 'A valve that controls the flow of coolant through the heater core.', 50, 0),
(397, 'Heater control unit', 'A unit that controls the temperature and airflow of the heater.', 50, 0),
(398, 'Heater hose', 'Hoses that carry coolant to and from the heater core.', 50, 0),
(399, 'Heater parts', 'Various components that make up the vehicle’s heater system.', 50, 0),
(400, 'Auxiliary heater', 'A secondary heater used to provide additional warmth in cold weather.', 50, 0),
(401, 'PTC heater', 'A Positive Temperature Coefficient heater used in electric vehicles to provide heat.', 51, 0),
(402, 'PTC heater parts', 'Various components that make up the PTC heater.', 51, 0),
(403, 'Heat pump system', 'A system that heats and cools the cabin in electric vehicles using a heat pump.', 51, 0),
(404, 'Heat pump system parts', 'Various components of the heat pump system in electric vehicles.', 51, 0),
(405, 'Defroster', 'A system that removes frost from the windshield by blowing warm air onto it.', 52, 0),
(406, 'Ventilator', 'A system that circulates fresh air throughout the vehicle cabin.', 52, 0),
(407, 'Blower', 'A fan that forces air through the climate control system.', 52, 0),
(408, 'Other ventilator parts', 'Various components used in the ventilation system of the vehicle.', 52, 0),
(409, 'Air duct', 'A duct that carries air from the climate control system to different parts of the cabin.', 52, 0),
(410, 'Cabin air filter', 'A filter that removes dust, pollen, and other particles from the air entering the vehicle cabin.', 52, 0),
(411, 'Electric air purifier', 'A device that cleans and purifies the air inside the vehicle.', 52, 0),
(412, 'Air purifier parts', 'Various components used in the vehicle’s air purification system.', 52, 0),
(413, 'Instrument panel assembly', 'The complete dashboard assembly that holds the vehicle’s instruments and controls.', 53, 0),
(414, 'Instrument panel', 'The panel that displays the vehicle’s speed, fuel level, and other vital information.', 53, 0),
(415, 'Instrument meter', 'A gauge that displays information such as speed, fuel level, and engine temperature.', 53, 0),
(416, 'Instrument panel parts', 'Various components used in the assembly of the instrument panel.', 53, 0),
(417, 'Full LCD meter', 'An electronic display that shows vehicle information in place of traditional gauges.', 53, 0),
(418, 'Speedometer', 'A gauge that displays the speed of the vehicle.', 53, 0),
(419, 'Speedometer cable', 'A cable that connects the transmission to the speedometer to measure vehicle speed.', 53, 0),
(420, 'Tachometer', 'A gauge that measures the engine’s RPM (revolutions per minute).', 53, 0),
(421, 'Fuel meter', 'A gauge that displays the amount of fuel remaining in the tank.', 53, 0),
(422, 'LCD unit', 'A liquid crystal display unit used to display information in the vehicle.', 54, 0),
(423, 'EL display unit', 'An electroluminescent display unit that provides bright, clear vehicle information.', 54, 0),
(424, 'Head Up Display (HUD)', 'A display that projects important information onto the windshield for easy viewing.', 54, 0),
(425, 'Display parts', 'Various components used in the vehicle’s display systems.', 54, 0),
(426, 'Airbag module', 'The complete airbag system that deploys in the event of a collision.', 55, 0),
(427, 'Driver airbag module', 'The airbag module located in the steering wheel that protects the driver.', 55, 0),
(428, 'Passenger airbag module', 'The airbag module located in the dashboard that protects the passenger.', 55, 0),
(429, 'Seat', 'A component that provides seating for the driver and passengers in the vehicle.', 56, 1),
(430, 'Seat cushion / Seat back', 'The cushion and backrest of the seat that provide comfort and support.', 56, 0),
(431, 'Side bolster', 'A component that provides lateral support to the seat, keeping occupants in place during turns.', 56, 0),
(432, 'Seat fabric', 'The material used to cover the seat, providing comfort and aesthetics.', 56, 0),
(433, 'Headrest', 'A component that supports the occupant’s head and helps prevent neck injuries in a collision.', 56, 0),
(434, 'Seat frame', 'The structural framework of the seat that supports the cushion and backrest.', 56, 0),
(435, 'Seat adjustor', 'A mechanism that allows the seat position to be adjusted for driver and passenger comfort.', 56, 0),
(436, 'Seat slide', 'A mechanism that allows the seat to slide forward and backward.', 56, 0),
(437, 'Seat reclining device', 'A mechanism that allows the seatback to be reclined for comfort.', 56, 0),
(438, 'Lumbar adjustor', 'A feature that allows the occupant to adjust lumbar support for better back comfort.', 56, 0),
(439, 'Seat plastic parts', 'Various plastic components used in the seat assembly.', 56, 0),
(440, 'Seat metal parts', 'Various metal components used in the seat assembly for structural support.', 56, 0),
(441, 'Seat belt', 'A safety device that restrains occupants in their seats to prevent injury during a collision.', 57, 0),
(442, 'Seat belt retractor', 'A mechanism that winds up the seat belt when not in use and locks it during a collision.', 57, 0),
(443, 'Seat belt buckle', 'A component that secures the seat belt in place when fastened.', 57, 0),
(444, 'Seat belt webbing', 'The fabric part of the seat belt that secures the occupant in place.', 57, 0),
(445, 'Seat belt adjustor', 'A mechanism that allows for the adjustment of the seat belt height for comfort.', 57, 0),
(446, 'Pedal', 'A foot-operated control used by the driver to accelerate, brake, or engage the clutch.', 58, 0),
(447, 'Accelerator pedal module', 'The assembly that controls the vehicle’s speed by regulating engine power.', 58, 0),
(448, 'Brake pedal', 'A pedal that activates the braking system to slow or stop the vehicle.', 58, 0),
(449, 'Clutch pedal', 'A pedal that disengages the engine from the transmission to allow for gear changes.', 58, 0),
(450, 'Pedal parts', 'Various components used in the pedal assembly.', 58, 0),
(451, 'Cupholder', 'A holder designed to secure cups or bottles in the vehicle.', 59, 0),
(452, 'Clock', 'A device that displays the time in the vehicle.', 59, 0),
(453, 'Glove box', 'A storage compartment located in the dashboard for small items.', 59, 0),
(454, 'Room lamp', 'An interior light that illuminates the cabin of the vehicle.', 59, 0),
(455, 'Inside mirror', 'A rear-view mirror located inside the vehicle.', 59, 0),
(456, 'Sun visor', 'A panel that blocks sunlight from entering the vehicle and impairing the driver’s vision.', 59, 0),
(457, 'Headlamp', 'A lamp mounted at the front of the vehicle that illuminates the road ahead.', 60, 0),
(458, 'Fog lamp', 'A lamp designed to improve visibility in foggy or low-visibility conditions.', 60, 0),
(459, 'Rear combination lamp', 'A light unit that includes brake lights, turn signals, and reverse lights.', 60, 0),
(460, 'Turn signal lamp', 'A lamp that indicates the vehicle’s intention to turn.', 60, 0),
(461, 'Parking lamp', 'A lamp that illuminates when the vehicle is parked to increase visibility.', 60, 0),
(462, 'License plate lamp', 'A light that illuminates the vehicle’s license plate.', 60, 0),
(463, 'Hazard lamp', 'A lamp that flashes to indicate a hazard or emergency situation.', 60, 0),
(464, 'Various lamps', 'Different types of lamps used for various lighting functions in the vehicle.', 60, 0),
(465, 'Lamp parts', 'Various components used in the assembly of vehicle lamps.', 60, 0),
(466, 'Bumper', 'A protective component located at the front and rear of the vehicle.', 61, 0),
(467, 'Bumper fascia', 'The outer cover of the bumper that provides aesthetic and aerodynamic functions.', 61, 0),
(468, 'Bumper energy absorbing parts', 'Components that absorb energy during a collision to reduce impact forces.', 61, 0),
(469, 'Bumper parts', 'Various components that make up the vehicle’s bumper system.', 61, 0),
(470, 'Front grille', 'A grille located at the front of the vehicle that allows air to flow to the radiator.', 62, 0),
(471, 'Molding (exterior)', 'Trim pieces that enhance the appearance of the vehicle’s exterior.', 62, 0),
(472, 'Emblem', 'A badge or logo that represents the vehicle’s brand or model.', 62, 0),
(473, 'Spoiler', 'An aerodynamic component that reduces lift and improves stability.', 62, 0),
(474, 'Weatherstrip', 'Seals around doors and windows that prevent water and air from entering the vehicle.', 62, 0),
(475, 'Glass run channel', 'A rubber or plastic strip that guides the movement of the window glass.', 62, 0),
(476, 'Roof rail', 'Rails located on the roof of the vehicle for securing cargo.', 62, 0),
(477, 'Tire carrier', 'A component that holds and secures the vehicle’s spare tire.', 62, 0),
(478, 'Exterior decorative parts', 'Various components that enhance the vehicle’s exterior appearance.', 62, 0),
(479, 'Chassis module', 'The structural framework that supports the vehicle’s body and components.', 63, 0),
(480, 'Front chassis module', 'The front section of the chassis that supports the engine and front suspension.', 63, 0),
(481, 'Rear chassis module', 'The rear section of the chassis that supports the rear suspension.', 63, 0),
(482, 'Suspension module', 'A module that includes the suspension components responsible for vehicle handling.', 63, 0),
(483, 'Front suspension module', 'The suspension components located at the front of the vehicle.', 63, 0),
(484, 'Rear suspension module', 'The suspension components located at the rear of the vehicle.', 63, 0),
(485, 'Brake', 'The primary system that slows or stops the vehicle.', 64, 0),
(486, 'Brake shoe', 'A component that presses against the brake drum to slow the vehicle in drum brake systems.', 64, 0),
(487, 'Brake wheel cylinder', 'A component that applies hydraulic pressure to the brake shoes in drum brakes.', 64, 0),
(488, 'Brake disc', 'A component that the brake pads clamp onto to slow the vehicle in disc brake systems.', 64, 0),
(489, 'Brake pad', 'A friction material that presses against the brake disc to slow the vehicle.', 64, 0),
(490, 'Brake caliper', 'A component that holds the brake pads and presses them against the brake disc.', 64, 0),
(491, 'Brake caliper piston', 'A piston that applies pressure to the brake pads within the brake caliper.', 64, 0),
(492, 'Brake lining', 'A material that provides friction in drum brake systems.', 64, 0),
(493, 'Brake hose', 'A flexible hose that carries brake fluid to the brake calipers and wheel cylinders.', 64, 0),
(494, 'Brake tube', 'A rigid tube that carries brake fluid from the master cylinder to the brake components.', 64, 0),
(495, 'Brake valve', 'A valve that regulates the flow of brake fluid in the braking system.', 64, 0),
(496, 'Air brake', 'A brake system that uses compressed air to apply the brakes, commonly found in heavy vehicles.', 64, 0),
(497, 'Electric brake (Brake-by-wire)', 'A brake system that uses electrical signals to control the braking force.', 64, 0),
(498, 'Body reinforcement parts', 'Components that strengthen the vehicle body and improve crash protection.', 71, 0),
(499, 'Body insulator', 'A material that provides insulation for the vehicle body to reduce noise and vibration.', 71, 0),
(500, 'Engine undercover', 'A panel that protects the underside of the engine from road debris and damage.', 71, 0),
(501, 'Splash guard', 'A protective panel that prevents water and debris from splashing onto critical components.', 71, 0),
(502, 'Mudguard', 'A component that prevents mud and debris from being thrown up by the tires.', 71, 0),
(503, 'Door', 'A hinged panel that provides access to the vehicle’s interior.', 72, 0),
(504, 'Door module', 'An assembly that integrates various components such as locks, windows, and handles.', 72, 0),
(505, 'Window frame', 'A frame that holds the window glass in place within the door.', 72, 0),
(506, 'Door hinge', 'A pivot point that allows the door to open and close.', 72, 0),
(507, 'Door check', 'A mechanism that holds the door in place when opened to prevent it from swinging back.', 72, 0),
(508, 'Window regulator', 'A mechanism that raises and lowers the window glass.', 72, 0),
(509, 'Power window', 'An electric system that allows the driver or passengers to raise or lower the windows.', 72, 0),
(510, 'Outside handle', 'The exterior handle used to open the door.', 72, 0),
(511, 'Inside handle', 'The interior handle used to open the door.', 72, 0),
(512, 'Door lock', 'A mechanism that secures the door in a closed position.', 72, 0),
(513, 'Door lock parts', 'Various components that make up the door lock assembly.', 72, 0),
(514, 'Door lock module', 'An electronic module that controls the locking and unlocking of the doors.', 72, 0),
(515, 'Door lock controller', 'A system that manages the operation of the door locks.', 72, 0),
(516, 'Door closure', 'A system that ensures the door is securely closed.', 72, 0),
(517, 'Hood', 'A panel that covers the engine compartment, providing access for maintenance.', 73, 0),
(518, 'Hood lock', 'A mechanism that secures the hood in a closed position.', 73, 0),
(519, 'Hood hinges', 'A pivot that allows the hood to be opened and closed.', 73, 0),
(520, 'Wiper', 'A system that clears rain, snow, and debris from the windshield.', 74, 0),
(521, 'Wiper arm', 'A component that holds the wiper blade and moves it across the windshield.', 74, 0),
(522, 'Wiper blade', 'A rubber component that wipes water and debris off the windshield.', 74, 0),
(523, 'Wiper link', 'A mechanism that connects the wiper motor to the wiper arms.', 74, 0),
(524, 'Fuel tank', 'A storage component that holds the vehicle’s fuel.', 75, 0),
(525, 'Filler pipe', 'A pipe that connects the fuel tank to the outside of the vehicle, allowing fuel to be added.', 75, 0),
(526, 'Filler neck', 'The opening through which fuel is added to the tank.', 75, 0),
(527, 'Rollover valve', 'A valve that prevents fuel from leaking in the event of a rollover.', 75, 0),
(528, 'Fuel tank gauge', 'A gauge that measures the amount of fuel in the tank.', 75, 0),
(529, 'Spring', 'A component that absorbs shocks and provides support in the suspension system.', 76, 0),
(530, 'Bearing', 'A component that reduces friction between moving parts.', 76, 0),
(531, 'Gear', 'A toothed component that transmits mechanical power between moving parts.', 76, 0),
(532, 'Shaft', 'A rotating component that transmits power in mechanical systems.', 76, 0),
(533, 'Pin', 'A small rod used to hold parts together or align them.', 76, 0),
(534, 'Valve', 'A component that controls the flow of fluids in various vehicle systems.', 76, 0),
(535, 'Control cable', 'A cable that transmits mechanical force to operate various vehicle components.', 76, 0),
(536, 'Wire mesh', 'A mesh used for filtration or as a protective barrier in vehicle systems.', 76, 0),
(537, 'Pipe/Tube (Hard)', 'A rigid pipe or tube used for transporting fluids or gases in vehicle systems.', 77, 0),
(538, 'Hose', 'A flexible tube that carries fluids or gases in vehicle systems.', 77, 0),
(539, 'Duct', 'A passage or tube that conveys air or other gases.', 77, 0),
(540, 'Bush', 'A component that reduces friction between two moving parts.', 78, 0),
(541, 'Heat insulator', 'A material that provides insulation to protect vehicle components from heat.', 78, 0),
(542, 'Seal', 'A component that prevents the leakage of fluids between different sections of a system.', 78, 0),
(543, 'Gasket', 'A seal that fills the space between two mating surfaces to prevent leakage.', 78, 0),
(544, 'O-ring', 'A circular seal used to prevent fluid or gas leakage.', 78, 0),
(545, 'Adhesive', 'A substance used to bond components together.', 79, 0),
(546, 'Film', 'A thin layer of material used for various protective or bonding purposes.', 79, 0),
(547, 'Tape', 'A strip of material used for bonding or sealing.', 79, 0),
(548, 'Paint', 'A coating applied to the vehicle’s surface for protection and aesthetic purposes.', 80, 0),
(549, 'Surface treatment agent', 'A substance applied to the vehicle’s surface to enhance adhesion, protection, or appearance.', 80, 0),
(550, 'Jack', 'A tool used to lift the vehicle for maintenance or repairs.', 81, 0),
(551, 'Tool set', 'A set of tools used for vehicle maintenance and repairs.', 81, 0),
(552, 'Child seat', 'A safety seat designed for children, used in vehicles to protect them during travel.', 81, 0),
(553, 'Battery booster cable', 'Cables used to jump-start a vehicle’s battery.', 81, 0),
(554, 'Battery charger', 'A device used to charge the vehicle’s battery.', 81, 0),
(555, 'Steering system', 'The complete system that allows the driver to control the direction of the vehicle.', 67, 0),
(556, 'Steering wheel', 'The wheel used by the driver to steer the vehicle.', 67, 0),
(557, 'Armature', 'The rotating part of the steering motor responsible for creating the force needed to steer.', 67, 0),
(558, 'Steering wheel parts', 'Various components that make up the steering wheel assembly.', 67, 0),
(559, 'Steering column', 'A column that connects the steering wheel to the steering mechanism.', 67, 0),
(560, 'Steering column module', 'A module that contains electrical and mechanical components for steering control.', 67, 0),
(561, 'Steering shaft', 'A shaft that transfers rotational motion from the steering wheel to the steering mechanism.', 67, 0),
(562, 'Steering joint', 'A joint that connects different sections of the steering shaft.', 67, 0),
(563, 'Steering lock', 'A security device that locks the steering wheel to prevent unauthorized use of the vehicle.', 67, 0),
(564, 'Power steering', 'A system that uses hydraulic or electric power to assist the driver in steering.', 67, 0),
(565, 'Power steering pump', 'A pump that supplies hydraulic fluid to the power steering system.', 67, 0),
(566, 'Power steering reservoir tank', 'A tank that holds the hydraulic fluid used in the power steering system.', 67, 0),
(567, 'Suspension system', 'The system that supports the vehicle’s weight and absorbs shocks from the road.', 68, 0),
(568, 'Suspension rod', 'A component that connects and supports various parts of the suspension.', 68, 0),
(569, 'Leaf spring', 'A spring made of layers of metal that provides support for the vehicle’s weight.', 68, 0),
(570, 'Coil spring', 'A spring that compresses and expands to absorb shocks.', 68, 0),
(571, 'Stabilizer', 'A component that reduces body roll during cornering.', 68, 0),
(572, 'Suspension ball joint', 'A pivot point that connects the control arms to the steering knuckles.', 68, 0),
(573, 'Shock absorber', 'A component that dampens the oscillations of the suspension system.', 68, 0),
(574, 'Shock absorber module', 'A complete shock absorber assembly that includes all necessary components.', 68, 0),
(575, 'Tire', 'A rubber covering that fits around the wheel and provides traction on the road.', 69, 0),
(576, 'Tire valve / Valve core', 'A valve that allows air to be added to or removed from the tire.', 69, 0),
(577, 'Tire cord', 'The reinforcing material inside a tire that provides strength and shape.', 69, 0),
(578, 'Tire parts', 'Various components that make up the tire assembly.', 69, 0),
(579, 'Steel wheel', 'A wheel made of steel that supports the tire.', 69, 0),
(580, 'Alloy wheel', 'A wheel made of an alloy of aluminum or magnesium for better performance and aesthetics.', 69, 0),
(581, 'Wheel cap / cover', 'A decorative cover that fits over the center of the wheel.', 69, 0),
(582, 'Road wheel parts', 'Various components of the wheel assembly that provide support and movement.', 69, 0),
(583, 'Parking brake', 'A brake system that prevents the vehicle from moving when parked.', 65, 0),
(584, 'Parking brake parts', 'Various components used in the parking brake system.', 65, 0),
(585, 'Electric Parking Brake (EPB)', 'An electronic system that applies and releases the parking brake.', 65, 0),
(586, 'Electric parking brake parts', 'Various components used in the Electric Parking Brake (EPB) system.', 65, 0),
(587, 'Auxiliary brake', 'A secondary braking system that provides additional control during braking.', 65, 0),
(588, 'ABS', 'Anti-lock Braking System that prevents the wheels from locking during braking.', 66, 0),
(589, 'ABS actuator', 'A component that controls the ABS system by modulating brake pressure.', 66, 0),
(590, 'ABS parts', 'Various components used in the ABS system.', 66, 0),
(591, 'Traction Control System (TCS)', 'A system that prevents wheel spin by controlling power delivery.', 66, 0),
(592, 'TCS parts', 'Various components used in the Traction Control System.', 66, 0),
(593, 'Electronic Stability Control (ESC) system', 'A system that helps the driver maintain control of the vehicle during oversteer or understeer.', 66, 0),
(594, 'ESC system parts', 'Various components used in the ESC system.', 66, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_images`
--

CREATE TABLE `category_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_images`
--

INSERT INTO `category_images` (`id`, `image_path`, `category_id`) VALUES
(1, '/e-commerce/assets/category_images/tires_and_wheels.png', 69),
(2, '/e-commerce/assets/category_images/interior_accessories.png', 429),
(3, '/e-commerce/assets/category_images/safety_and_security.png', 43),
(4, '/e-commerce/assets/category_images/performance_parts.png', 3),
(5, '/e-commerce/assets/category_images/lights_and_electronics.png', 60),
(6, '/e-commerce/assets/category_images/car_maintenance.png', 10),
(7, '/e-commerce/assets/category_images/bumper_cover.png', 61),
(8, '/e-commerce/assets/category_images/bumper_cover.png', 466),
(9, '/e-commerce/assets/category_images/grille_assembly_bundles_images.png', 470);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `logo_path`, `specialty`) VALUES
(1, 'Roberts', '/e-commerce/assets/brands/RAIPMC.png', 'radiators'),
(2, 'MarkLines', '/e-commerce/assets/brands/Marklines.png', 'OEM parts'),
(3, 'Primal Enterprises Corporation', '/e-commerce/assets/brands/Primal_Ent.png', 'mechanical components'),
(4, 'PartsPro', '/e-commerce/assets/brands/PartsPro.png', 'wheels and tires'),
(5, 'International Wiring Systems', '/e-commerce/assets/brands/IWS.png', 'wirings'),
(6, 'Denso', '/e-commerce/assets/brands/Denso.png', 'thermal and electronic systems'),
(7, 'LAMCOR', '/e-commerce/assets/brands/Lamcor.png', 'electronic components'),
(8, 'Bimparts', '/e-commerce/assets/brands/Bimparts.png', 'automotive parts'),
(9, 'Bosch', '/e-commerce/assets/brands/Bosch.png', 'batteries, starters, and electronic systems'),
(10, 'Autophil Zone', '/e-commerce/assets/brands/AutophilZone.png', 'lubricants, tires, brake parts'),
(11, 'Momo Italy', '/e-commerce/assets/brands/Momo.png', 'Wheels and Steering Wheels'),
(12, 'AutoSky', '/e-commerce/assets/brands/AutoSky.png', 'automotive gadgets');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `short_description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `feature_product` tinyint(1) DEFAULT 0,
  `old_price` decimal(10,2) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `short_description`, `price`, `description`, `feature_product`, `old_price`, `manufacturer_id`) VALUES
(1, 'Aluminum Intercooler', 'ALT-001', 'High-quality car alternator for enhanced performance.', 1350.00, 'High-quality aluminum intercooler designed to provide enhanced cooling efficiency.', 1, 1500.00, 1),
(2, 'Power Steering Pump', 'PSP-002', 'Reliable power steering pump for smooth steering.', 1620.00, 'This power steering pump ensures smooth and responsive steering.', 1, 1800.00, 2),
(3, 'Rim and Tire Set', 'RT-003', 'Premium rims and tires for enhanced style and performance.', 3150.00, 'These rims and tires offer superior performance and add a stylish touch to your vehicle.', 1, 4500.00, 4),
(4, 'Ball Joints', 'BJ-004', 'Heavy-duty ball joints for smoother suspension.', 810.00, 'These ball joints are designed for strength and durability, providing smoother suspension and steering.', 1, 900.00, 8),
(5, 'Oxygen Sensors', 'OS-005', 'High-quality oxygen sensors for better fuel efficiency.', 1800.00, 'These oxygen sensors ensure better fuel efficiency by monitoring the oxygen levels in the exhaust gases.', 1, 2000.00, 7),
(6, 'Momo MOD27/C Steering Wheel', 'SW-006', 'High-quality Momo steering wheel for improved control.', 6750.00, 'This Momo steering wheel offers exceptional control and grip for a superior driving experience.', 1, 7600.00, 11),
(7, 'AutoSky Reverse Backup Camera', 'RC-007', 'High-resolution reverse camera for better visibility.', 4500.00, 'This reverse backup camera offers clear visibility when reversing, improving safety and convenience.', 1, 5000.00, 12),
(8, 'Bosch Oil Filter', 'OF-008', 'High-performance oil filter by Bosch.', 4500.00, 'This Bosch oil filter ensures clean engine oil for better engine health and longevity.', 1, 5000.00, 9),
(9, 'Spark Plug Car', 'SP-009', 'High-performance spark plugs for efficient ignition.', 675.00, 'These spark plugs offer efficient ignition for improved engine performance and fuel economy.', 0, 750.00, 2),
(10, 'Front and Rear Autospecialty Brake Kit', 'BK-010', 'Complete brake kit for superior braking performance.', 9000.00, 'This comprehensive brake kit includes all necessary components for optimal braking performance.', 0, 10000.00, 10),
(11, 'Car Battery Charger', 'BC-011', 'Portable car battery charger for emergencies.', 13500.00, 'This car battery charger is perfect for keeping your car battery charged during emergencies.', 0, 15000.00, 6),
(12, 'Catalytic Converters', 'CC-012', 'Advanced catalytic converters for reduced emissions.', 4950.00, 'These catalytic converters help reduce emissions and improve overall engine efficiency.', 0, 5500.00, 8),
(13, 'Gear Stick', 'GS-013', 'Durable gear stick for smooth shifting.', 1350.00, 'This gear stick is designed for smooth and precise shifting, enhancing your driving experience.', 0, 1500.00, 11),
(14, 'Momo R1907/33S Steering Wheel', 'SW-014', 'Stylish Momo steering wheel with superior grip.', 1800.00, 'This stylish Momo steering wheel provides excellent grip and adds a sporty touch to your vehicle.', 0, 2000.00, 11),
(15, 'Recliner Car Seat', 'CS-015', 'Comfortable and ergonomic car seat.', 13500.00, 'This ergonomic car seat provides maximum comfort and support during long drives.', 0, 15000.00, 11),
(16, 'Engine Piston and Spark Plug Isolated White', 'EP-016', 'Durable piston spark plugs for enhanced performance.', 7200.00, 'These piston spark plugs are designed to improve performance and durability.', 0, 8000.00, 3),
(17, 'Brake Disc', 'BD-017', 'High-quality brake discs for reliable stopping power.', 4500.00, 'These brake discs provide exceptional braking performance, ensuring reliable stopping power in all conditions.', 0, 5000.00, 10),
(18, 'Alternator Electrical Wires & Cable Spare Part', 'ALT-018', 'Alternator designed to provide high electrical output.', 18000.00, 'This alternator provides high electrical output for improved engine performance.', 0, 20000.00, 3),
(19, 'Spark Plugs', 'SP-019', 'Premium spark plugs for improved ignition and fuel efficiency.', 2250.00, 'These premium spark plugs enhance engine performance and fuel efficiency by ensuring reliable ignition.', 0, 2500.00, 2),
(20, 'Service Tyre', 'ST-020', 'Durable service tyre for long-lasting performance.', 7200.00, 'This service tyre is built to withstand tough conditions, offering long-lasting performance.', 0, 8000.00, 4),
(21, 'Ctek Battery Charger and Maintainer', 'CTEK-CHRG-001', 'Smart battery charger and maintainer for all types of lead-acid batteries.', 79.99, 'The Ctek Battery Charger and Maintainer is an advanced, fully automatic battery charger designed to prolong battery life and ensure maximum performance. Suitable for all types of lead-acid batteries, including wet, MF, AGM, and gel batteries.', 0, 0.00, 4),
(22, 'Spy Car Alarm System', 'SPY-ALM-002', 'Advanced car alarm system with remote control and anti-theft features.', 59.99, 'The Spy Car Alarm System offers a complete vehicle security solution with remote control capabilities, anti-theft features, and a loud siren to deter intruders. Comes with wiring harness, control unit, and two key fobs for convenient control.', 0, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`product_id`, `attribute_id`, `value`) VALUES
(1, 1, '5.5'),
(1, 2, '24 x 12 x 6'),
(1, 3, ''),
(1, 4, ''),
(1, 5, 'Aluminum'),
(1, 6, 'Turbocharged Engines'),
(2, 1, '3.2'),
(2, 2, '8 x 6 x 5'),
(2, 3, ''),
(2, 4, '12V'),
(2, 5, 'Aluminum'),
(2, 6, 'Gasoline Engines'),
(3, 1, '20 per tire'),
(3, 2, '32 x 32 x 12'),
(3, 3, 'Black'),
(3, 4, ''),
(3, 5, 'Rubber and Steel'),
(3, 6, 'All-Terrain Vehicles'),
(4, 1, '1.2'),
(4, 2, ''),
(4, 3, ''),
(4, 4, ''),
(4, 5, 'Steel'),
(4, 6, 'Various'),
(5, 1, '0.15'),
(5, 2, '3 x 1 x 1'),
(5, 3, ''),
(5, 4, '12V'),
(5, 5, 'Stainless Steel'),
(5, 6, 'Gasoline Engines'),
(6, 1, '1.5'),
(6, 2, '14 x 14 x 3'),
(6, 3, 'Black'),
(6, 4, ''),
(6, 5, 'Leather and Aluminum'),
(6, 6, ''),
(7, 1, '0.2'),
(7, 2, '3 x 2 x 1.5'),
(7, 3, ''),
(7, 4, '12V'),
(7, 5, 'Plastic'),
(7, 6, ''),
(8, 1, '0.5'),
(8, 2, '4 x 4 x 4'),
(8, 3, 'Black'),
(8, 4, ''),
(8, 5, 'Steel'),
(8, 6, 'Gasoline and Diesel Engines'),
(9, 1, '0.05'),
(9, 2, ''),
(9, 3, ''),
(9, 4, ''),
(9, 5, 'Nickel Alloy'),
(9, 6, 'Gasoline Engines'),
(10, 1, '18'),
(10, 2, '14 x 12 x 4'),
(10, 3, ''),
(10, 4, ''),
(10, 5, 'Steel'),
(10, 6, ''),
(11, 1, '3'),
(11, 2, ''),
(11, 3, 'Red'),
(11, 4, '12V/24V'),
(11, 5, 'Plastic and Steel'),
(11, 6, ''),
(12, 1, '6.8'),
(12, 2, '12 x 8 x 5'),
(12, 3, ''),
(12, 4, ''),
(12, 5, 'Stainless Steel'),
(12, 6, 'Gasoline and Diesel Engines'),
(13, 1, '0.7'),
(13, 2, '5 x 3 x 3'),
(13, 3, 'Silver'),
(13, 4, ''),
(13, 5, 'Steel'),
(13, 6, ''),
(14, 1, '1.2'),
(14, 2, '14 x 14 x 3'),
(14, 3, 'Black'),
(14, 4, ''),
(14, 5, 'Steel'),
(14, 6, ''),
(15, 1, '12'),
(15, 2, '20 x 20 x 40'),
(15, 3, 'Black and Brown'),
(15, 4, ''),
(15, 5, 'Leather and Steel'),
(15, 6, ''),
(16, 1, '2.5'),
(16, 2, ''),
(16, 3, ''),
(16, 4, ''),
(16, 5, 'Steel and Alloy'),
(16, 6, 'V6 and V8 Engines'),
(17, 1, '5'),
(17, 2, '14 x 14 x 2'),
(17, 3, ''),
(17, 4, ''),
(17, 5, 'Steel'),
(17, 6, ''),
(18, 1, '7'),
(18, 2, ''),
(18, 3, ''),
(18, 4, '12V'),
(18, 5, 'Copper and Steel'),
(18, 6, 'Gasoline and Diesel Engines'),
(19, 1, '0.05'),
(19, 2, ''),
(19, 3, ''),
(19, 4, ''),
(19, 5, 'Nickel Alloy'),
(19, 6, 'Gasoline Engines'),
(20, 1, '10 per tire'),
(20, 2, '30 x 30 x 10'),
(20, 3, 'Black'),
(20, 4, ''),
(20, 5, 'Rubber and Steel'),
(20, 6, ''),
(21, 1, '0.8'),
(21, 2, '6.5 x 3.2 x 1.9'),
(21, 3, 'Black and Silver'),
(21, 4, '12V'),
(21, 5, 'ABS Plastic'),
(21, 6, ''),
(22, 1, '1.2'),
(22, 2, '7.5 x 5.0 x 2.0'),
(22, 3, 'Black'),
(22, 4, '12V'),
(22, 5, ''),
(22, 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `product_id`, `category_id`) VALUES
(1, 1, 193),
(2, 2, 565),
(3, 3, 579),
(4, 4, 572),
(5, 5, 373),
(6, 6, 556),
(7, 7, 308),
(8, 8, 204),
(9, 9, 199),
(10, 10, 485),
(11, 11, 554),
(12, 12, 183),
(13, 13, 260),
(14, 14, 556),
(15, 15, 429),
(17, 17, 488),
(19, 19, 199),
(20, 20, 582),
(25, 16, 199),
(26, 16, 133),
(27, 18, 222),
(28, 18, 224),
(31, 21, 117),
(32, 21, 554),
(33, 22, 326);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(1, 1, '/e-commerce/assets/products/aluminum-intercooler.png'),
(2, 2, '/e-commerce/assets/products/power-steering-pump.png'),
(3, 3, '/e-commerce/assets/products/rims-tires.png'),
(4, 4, '/e-commerce/assets/products/ball-joints.png'),
(5, 5, '/e-commerce/assets/products/oxygen-sensors.png'),
(6, 6, '/e-commerce/assets/products/momo-steering-wheel-1.png'),
(7, 7, '/e-commerce/assets/products/reverse-backup-camera.png'),
(8, 8, '/e-commerce/assets/products/bosch-oil-filter.png'),
(9, 9, '/e-commerce/assets/products/car-spark-plug.png'),
(10, 10, '/e-commerce/assets/products/brake-kit.png'),
(11, 11, '/e-commerce/assets/products/car-battery-charger.png'),
(12, 12, '/e-commerce/assets/products/catalytic-converters.png'),
(13, 13, '/e-commerce/assets/products/gear-stick.png'),
(14, 14, '/e-commerce/assets/products/momo-steering-wheel-2.png'),
(15, 15, '/e-commerce/assets/products/car-seat.png'),
(16, 16, '/e-commerce/assets/products/piston-sparkplug.png'),
(17, 17, '/e-commerce/assets/products/brake-disc.png'),
(18, 18, '/e-commerce/assets/products/alternator.png'),
(19, 19, '/e-commerce/assets/products/spark-plugs.png'),
(20, 20, '/e-commerce/assets/products/service-tyre.png'),
(21, 21, '/e-commerce/assets/products/ctek_battery_charger.png'),
(22, 22, '/e-commerce/assets/products/spy_car_alarm.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`, `created_at`) VALUES
(1, 'testtest', 'asdqwe', 'vanbala@gmail.com', 'customer', '2024-11-07 14:52:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `category_images`
--
ALTER TABLE `category_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_manufacturer` (`manufacturer_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`product_id`,`attribute_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=595;

--
-- AUTO_INCREMENT for table `category_images`
--
ALTER TABLE `category_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `addresses_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_images`
--
ALTER TABLE `category_images`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `product_categories_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
