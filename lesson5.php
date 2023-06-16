<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "baitap2";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $mysqli_error());
}

// Tạo bảng "customers"
$sqlCreateTableCustomers = "CREATE TABLE customers (
    id INT PRIMARY KEY,
    name VARCHAR(20),
    email VARCHAR(35),
    phone VARCHAR(20)
)";

if (mysqli_query($conn,$sqlCreateTableCustomers) === TRUE) {
    echo "Bảng 'customers' đã được tạo thành công.<br>";
} else {
    echo "Lỗi khi tạo bảng 'customers': " . $mysqli_error();
}

// Thêm 5 khách hàng mới vào bảng "customers"
$sqlAddCustomers = "INSERT INTO customers (id, name, email, phone) VALUES
    (1, 'Nguyen Van A', '123a@example.com', '245576546'),
    (2, 'Nguyen Van B', '456b@example.com', '234365463'),
    (3, 'Nguyen Van C', '789c@example.com', '534473245'),
    (4, 'Nguyen Van D', '901d@gmail.com', '685345462'),
    (5, 'Nguyen Van E', 234e@examp1e.com', '2434654765')";

if (mysqli_query($conn, $sqlAddCustomers) === TRUE) {
    echo "Thêm khách hàng thành công.<br>";
} else {
    echo "Lỗi khi thêm khách hàng: " . $mysqli_error();
}

// Sửa thông tin của một khách hàng có id là 1
$sqlUpdateCustomers = "UPDATE customers SET name = 'Updated Name', email = 'updatedemail@example.com', phone = '999999999' WHERE id = 1";

if (mysqli_query($conn,$sqlUpdateCustomers) === TRUE) {
    echo "Thông tin khách hàng đã được cập nhật thành công.<br>";
} else {
    echo "Lỗi khi cập nhật thông tin khách hàng: " . $mysqli_error();
}

// Xoá một khách hàng có id là 5
$sqlDeleteCustomers = "DELETE FROM customers WHERE id = 5";

if (mysqli_query($conn,$sqlDeleteCustomers) === TRUE) {
    echo "Xoá khách hàng thành công.<br>";
} else {
    echo "Lỗi khi xoá khách hàng: " . $mysqli_error();
}

// Lấy tất cả các khách hàng có email là "example@gmail.com"
$sqlSelectCustomers = "SELECT * FROM customers WHERE email = 'example@gmail.com'";
$result = mysqli_query($conn, $sqlSelectCustomers);

if (mysqli_num_rows($result) > 0) {
    echo "Các khách hàng có email 'example@gmail.com':<br>";
    foreach ($result as $row) {
        echo "ID: " . $row["id"] . "<br>". "Name: " . $row["name"] . "<br>". "Email: " . $row["email"] ."<br>". "Phone: " . $row["phone"] . "<br>";
    }
} else {
    echo "Không tìm thấy khách hàng có email 'example@gmail.com'.<br>";
}


// Tạo bảng "orders" với ràng buộc khoá ngoại delete cascade
$sqlCreateTableOrders = "CREATE TABLE orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11),
    total_amount DECIMAL(10,2),
    order_date DATE,
    CONSTRAINT fk_customer_id FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sqlCreateTableOrders)) {
    echo "Tạo bảng orders thành công<br>";
} else {
    echo "Lỗi trong quá trình tạo bảng orders: " . mysqli_error($conn) . "<br>";
}

// Thêm một đơn hàng mới vào bảng "orders" cho khách hàng có id là 3
$sqlInsertOrder = "INSERT INTO orders (customer_id, total_amount, order_date)
                  VALUES (3, 100.00, '2023-06-07')";

if (mysqli_query($conn, $sqlInsertOrder)) {
    echo "Thêm đơn hàng mới thành công<br>";
} else {
    echo "Lỗi trong quá trình thêm đơn hàng mới: " . mysqli_error($conn) . "<br>";
}

// Lấy tất cả các đơn hàng của khách hàng có id là 3
$sqlSelectOrders = "SELECT * FROM orders WHERE customer_id = 3";
$result = mysqli_query($conn, $sqlSelectOrders);

if (mysqli_num_rows($result) > 0) {
    echo "Các đơn hàng của khách hàng có id là 3:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["id"] ."<br>". "Customer ID: " . $row["customer_id"] ."<br>". "Total Amount: " . $row["total_amount"] ."<br>". "Order Date: " . $row["order_date"] . "<br>";
    }
} else {
    echo "Không tìm thấy đơn hàng của khách hàng có id là 3<br>";
}

// Lấy danh sách khách hàng và đơn hàng của họ sử dụng câu lệnh JOIN
$sqlSelectCustomersOrders = "SELECT customers.id, customers.name, orders.id AS order_id, orders.total_amount, orders.order_date
                             FROM customers
                             JOIN orders ON customers.id = orders.customer_id";

$result = mysqli_query($conn, $sqlSelectCustomersOrders);

if (mysqli_num_rows($result) > 0) {
    echo "Danh sách khách hàng và đơn hàng của họ:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Customer ID: " . $row["id"] ."<br>". "Customer Name: " . $row["name"] ."<br>". "Order ID: " . $row["order_id"] ."<br>". "Total Amount: " ."<br>". $row["total_amount"] . "Order Date: " ."<br>". $row["order_date"] . "<br>";
    }
} else {
    echo "Không tìm thấy khách hàng và đơn hàng<br>";
}

// Lấy danh sách email của khách hàng sử dụng hàm DISTINCT
$sqlSelectDistinctEmails = "SELECT DISTINCT email FROM customers";
$result = mysqli_query($conn, $sqlSelectDistinctEmails);

if (mysqli_num_rows($result) > 0) {
    echo "Danh sách email của khách hàng:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Email: " . $row["email"] . "<br>";
    }
} else {
    echo "Không tìm thấy email của khách hàng<br>";
}