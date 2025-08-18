## 📝 Project: POS & Inventory Management System

### ✨ Overview

This is a comprehensive full-stack web application designed for managing a small business. It serves as a Point of Sale (POS) and Inventory Management System, providing a centralized dashboard to track sales, manage inventory, and handle customer data. The application is built with **Laravel**, **Inertia.js**, and **Vue.js**, offering a fast, modern, and seamless user experience.

### 🚀 Features

  * **User Authentication:** Secure user registration, login, and profile management with password hashing and a password reset flow via email OTP verification.
  * **Dashboard Analytics:** An intuitive dashboard that displays key business metrics, including total sales, VAT, payable amounts, and counts of products, categories, customers, and invoices.
  * **Product Management:** Create, read, update, and delete (CRUD) products with details like price, unit, and category.
  * **Category Management:** Organize products by creating and managing different categories.
  * **Customer Management:** Maintain a database of customers with their contact information.
  * **Invoice & Sales Tracking:** Generate and manage invoices, detailing each sale with product quantities and prices. The system supports tracking of total sales, discounts, and VAT.
  * **Sales Reporting:** Generate detailed sales reports based on a specific date range, providing a clear overview of business performance.
  * **Full-Stack Architecture:** The backend is powered by Laravel, handling all business logic and database interactions. The frontend is built with Vue.js and Inertia.js, ensuring a single-page application (SPA) feel without the complexity of a separate API.

### ⚙️ Technologies Used

  * **Backend:** PHP, Laravel Framework, MySQL
  * **Frontend:** Vue.js, Inertia.js, HTML, CSS
  * **Database:** MySQL
  * **Other:** Composer, npm

-----

### 📦 Installation and Setup

Follow these steps to get a copy of the project up and running on your local machine.

#### Prerequisites

  * PHP \>= 8.1
  * Composer
  * Node.js & npm
  * MySQL or other compatible database

#### Steps

1.  **Clone the repository:**

    ```bash
    git clone [your-repository-url]
    cd [your-project-folder]
    ```

2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4.  **Create and configure your `.env` file:**

    ```bash
    cp .env.example .env
    ```

    Open the `.env` file and update your database credentials.

5.  **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Run migrations and seed the database:**

    ```bash
    php artisan migrate --seed
    ```

7.  **Build the assets:**

    ```bash
    npm run build
    # or npm run dev for development
    ```

8.  **Start the local development server:**

    ```bash
    php artisan serve
    ```

9.  **Access the application:**
    Open your browser and visit `http://127.0.0.1:8000`.
