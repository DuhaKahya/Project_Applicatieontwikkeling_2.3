# Project Applicatie Ontwikkeling 2.3

## Overview

- [Project Overview](#Project-Overview)
- [Features](#Features)
- [Prerequisites](#Prerequisites)
- [Installation](#Installation)
- [Appendix](#Appendix)
- [Login Credentials](#Login-Credentials)
- [Authors](#Authors)
- [License](#License)

## Project Overview

The Haarlem Festival implementation project is designed to enhance the festival experience for visitors and customers through an intuitive and secure online platform. This system aims to streamline processes such as user registration, account management, and authentication, ensuring a seamless and user-friendly interface for festival attendees.

## Features

- User Registration and Login: Users can register for an account using their email address, with security measures such as CAPTCHA and hashed passwords to protect user information. The login functionality will support authentication via username or email and password.
  <br>
  <br>
- Password Reset: Customers can reset their passwords through a secure process involving a link sent to their registered email address.
  <br>
  <br>
- Account Management: Registered customers will have the ability to manage their accounts, including editing email, name, password, and adding optional profile pictures. This feature is designed to be intuitive, allowing users to easily update their personal information.
  <br>
  <br>
- Ticket Purchasing: Users will have the ability to browse available tickets for different events within the Haarlem Festival and purchase them through the platform. This feature will include options for selecting different ticket types, quantities, and secure payment processing. After purchase, users will receive their tickets electronically, which can be accessed from their account or via an email confirmation.
  <br>
  <br>
- Security and Privacy: The platform will prioritize user privacy and data security, implementing industry-standard practices for data protection, user authentication, and secure payment processing to ensure the safety of transactional and personal data.

## Prerequisites

Docker Desktop for Windows and Mac or Docker Engine for Linux.

## Prerequisites

Docker Desktop for Windows and Mac or Docker Engine for Linux.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/rangodemango/Project_Applicatieontwikkeling_2.3.git
    ```

### Starting the Application

1. Navigate to the project directory:
    ```bash
    cd webdevelopment_end_assigment
    ```

2. Start the Docker containers:
    ```bash
    docker-compose up
    ```

The NGINX server will serve files located in the `app/public` directory. You can visit the application by accessing [http://localhost](http://localhost) in your browser.

To get to the api you can enter the `http://localhost/api/note`.

PHPMyAdmin will be accessible at [http://localhost:8080](http://localhost:8080).

## Stopping the Application

To stop the Docker containers, you can press `Ctrl+C` in the terminal where the containers are running.

Alternatively, you can stop the containers using the following command in the terminal:
```bash
docker-compose down
```

## Appendix

Ensure that the ports 80 for the web server and 8080 for PHPMyAdmin are available and not being used by other services.



## Login credentials
Username: test
Password: test
Role: admin

Further users can be created by signing up for the aplication!

## Authors

- [@rangodemango](https://github.com/rangodemango) 🥭
- [@Lucas-Light](https://github.com/Lucas-Light)
- [@DuhaKahya](https://github.com/DuhaKahya)


## License

[WTFPL](https://choosealicense.com/licenses/wtfpl/)
