CREATE DATABASE IF NOT EXISTS timetable_management;
USE timetable_management;

CREATE TABLE permanent_timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    timeslot ENUM('08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30', '12:30-13:30', '13:30-14:30', '14:30-15:30', '15:30-16:30') NOT NULL,
    lab_name VARCHAR(50) NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    faculty_name VARCHAR(100) NOT NULL
);


CREATE TABLE reserve_timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_date DATE NOT NULL,
    timeslot ENUM('08:30-09:30', '09:30-10:30', '10:30-11:30', '11:30-12:30', '12:30-13:30', '13:30-14:30', '14:30-15:30', '15:30-16:30') NOT NULL,
    lab_name VARCHAR(50) NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    faculty_name VARCHAR(100) NOT NULL,
    reserved_by VARCHAR(100) NOT NULL, -- User or faculty reserving the slot
    status ENUM('Reserved', 'Cancelled') DEFAULT 'Reserved'
);

INSERT INTO permanent_timetable (day_of_week, timeslot, lab_name, subject_name, faculty_name)
VALUES
('Monday', '08:30-09:30', 'CL1', 'Mathematics', 'Dr. John Doe'),
('Monday', '09:30-10:30', 'CL1', 'Physics', 'Dr. Jane Smith'),
('Tuesday', '10:30-11:30', 'CL2', 'Chemistry', 'Dr. Emily Davis');

INSERT INTO reserve_timetable (reservation_date, timeslot, lab_name, subject_name, faculty_name, reserved_by)
VALUES
('2024-12-05', '08:30-09:30', 'CL1', 'Biology', 'Dr. Alan Turing', 'Admin'),
('2024-12-06', '09:30-10:30', 'CL2', 'English', 'Prof. Sarah Connor', 'Dr. Jane Smith');

01)Fetch Permanent Timetable
SELECT * FROM permanent_timetable
WHERE day_of_week = 'Monday';

02)Fetch Reserved Slots for a Specific Date
SELECT * FROM reserve_timetable
WHERE reservation_date = '2024-12-05';

03)Reserve a Slot
INSERT INTO reserve_timetable (reservation_date, timeslot, lab_name, subject_name, faculty_name, reserved_by)
VALUES ('2024-12-07', '10:30-11:30', 'CL1', 'Data Structures', 'Dr. Ada Lovelace', 'Admin');

04)Cancel a Reservation
UPDATE reserve_timetable
SET status = 'Cancelled'
WHERE id = 1; -- Replace with the specific reservation ID

05)Check Conflicts Between Permanent and Reserve Timetables
SELECT pt.day_of_week, pt.timeslot, pt.lab_name, rt.reservation_date
FROM permanent_timetable pt
JOIN reserve_timetable rt
ON pt.timeslot = rt.timeslot AND pt.lab_name = rt.lab_name
WHERE rt.status = 'Reserved';

06)Update Permanent Timetable
UPDATE permanent_timetable
SET subject_name = 'Advanced Mathematics', faculty_name = 'Dr. Isaac Newton'
WHERE id = 1; -- Replace with the specific timetable ID
