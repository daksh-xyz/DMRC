# DMRC Alumni Portal

## Project Overview

The DMRC Alumni Portal is a web application designed to facilitate the interaction between alumni of DMRC (Delhi Metro Rail Corporation). This portal allows alumni to register, create profiles, connect with each other, and stay updated with the latest news and events. The project is developed using HTML, CSS, JavaScript, and PHP.

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

- **User Registration and Authentication:** Alumni can register and log in securely.
- **Profile Management:** Users can create and update their profiles with personal and professional information.
- **Search and Connect:** Alumni can search for and connect with other alumni.
- **News and Events:** Stay updated with the latest news and events related to DMRC.
- **Admin Dashboard:** Admins can manage users, news, and events.

## Technologies Used

- **Front-end:**
  - HTML
  - CSS
  - JavaScript

- **Back-end:**
  - PHP

- **Database:**
  - MySQL

## Installation

### Prerequisites

- A web server (e.g., Apache)
- PHP 7.0 or later
- MySQL

### Steps

1. **Clone the repository:**
   ```sh
   git clone https://github.com/daksh-xyz/DMRC.git
   ```

2. **Navigate to the project directory:**
   ```sh
   cd DMRC
   ```

3. **Set up the database:**
   - Create a MySQL database.
   - Import the `database.sql` file located in the `sql` folder to set up the required tables.

4. **Configure the database connection:**
   - Open the `config.php` file located in the `includes` folder.
   - Update the database credentials:
     ```php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'your-username');
     define('DB_PASSWORD', 'your-password');
     define('DB_NAME', 'your-database-name');
     ```

5. **Run the application:**
   - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
   - Open a web browser and navigate to `http://localhost/dmrc-alumni-portal`.

## Usage

1. **Register:**
   - Go to the registration page and create an account.

2. **Login:**
   - Log in with your registered email and password.

3. **Profile Management:**
   - Update your profile with personal and professional information.

4. **Search and Connect:**
   - Use the search feature to find other alumni and connect with them.

5. **Stay Updated:**
   - Check the news and events section to stay updated with the latest information.

## Contributing

We welcome contributions from the community. To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.


## Contact

For any inquiries or support, please contact:

- **WhatsApp :** 8287086661

---

Thank you for using the DMRC Alumni Portal! We hope it serves as a valuable resource for all DMRC alumni.
