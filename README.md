# jual-beli-backend
# Jual Beli Barang Bekas - Backend API

Backend API untuk mendukung sistem jual beli barang bekas. Dibangun menggunakan PHP dan MySQL untuk pengelolaan data, dengan dukungan CRUD pada entitas utama seperti **Users**, **Products**, dan **Transactions**.

## Fitur
- **Users**: CRUD untuk mengelola pengguna (registrasi, pembaruan, penghapusan).
- **Products**: CRUD untuk mengelola produk yang dijual.
- **Transactions**: CRUD untuk mencatat transaksi pembelian barang.
- Validasi input dan pengecekan data untuk setiap endpoint.

## Struktur Folder
📂 jual-beli-backend/ ├── 📂 users/ │ ├── create.php │ ├── read.php │ ├── update.php │ ├── delete.php ├── 📂 products/ │ ├── create.php │ ├── read.php │ ├── update.php │ ├── delete.php ├── 📂 transactions/ │ ├── create.php │ ├── read.php │ ├── update.php │ ├── delete.php ├── db.php ├── .gitignore └── README.md

## Tabel mysql
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    buyer_id INT NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (buyer_id) REFERENCES users(user_id)
);
