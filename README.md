#   Bookify platform

## Description

The idea of this project is to create a small portal for the management of apartments and their reservations.

For this, Clean Architecture concepts combined with previous knowledge of PHP and Symfony have been applied.

This project is designed to implement Clean Architecture principles using Symfony 7. 
It focuses on separating system responsibilities into different layers, ensuring that business logic, infrastructure and user interfaces are decoupled. 
The goal is to provide a scalable and easy to maintain structure, applying design concepts such as dependency inversion and separation of concerns.

## Installation

1. Clone this repo. 😀
2. I added a makefile to execute the commands to build and start the docker containers.
   - `make install` to build the project stack and start it
   - `make uninstall` to stop the project stack and remove it
   - `make composer-install` to install composer dependencies

## Bibliography

1. [Problem with using a UUID primary key in MySQL](https://planetscale.com/blog/the-problem-with-using-a-uuid-primary-key-in-mysql)
2. [Domain Driven Desing in PHP](https://www.amazon.es/Domain-Driven-Design-PHP-Carlos-Buenosvinos/dp/1787284948). Carlos Buenosvinos, Christian Soronellas, Keyvan Akbary. 