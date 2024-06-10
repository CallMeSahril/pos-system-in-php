<?php

include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");

        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', 'Please fill required fields');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone'     => $phone,
            'is_ban' => $is_ban,
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'Admin Creted Successfully!');
        } else {
            redirect('admins-crate.php', 'please fill required fields.');
        }
    } else {
        redirect('admins-crate.php', 'please fill required fields.');
    }
}

if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($password != '') {
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedpassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'phone'     => $phone,
            'is_ban' => $is_ban,
        ];
        $result = update('admins', $adminId, $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin Updated Successfully!');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something Went Wrong!');
        }
    } else {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields');
    }
}

if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = insert('categories', $data);
    if ($result) {
        redirect('categories.php', 'Category Creted Successfully!');
    } else {
        redirect('categories-crate.php', 'Something Went Wrong!');
    }
}

if (isset($_POST['updateCategory'])) {
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = update('categories', $categoryId, $data);
    if ($result) {
        redirect('categories-edit.php?id=' . $categoryId, 'Caregory Updated Succesfully!');
    } else {
        redirect('categories-created.php?id=' . $categoryId, 'Something Went Wrong!');
    }
}

if (isset($_POST['saveProduct'])) {
    $categoryId = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);

    $status = isset($_POST['status']) == true ? 1 : 0;
    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products/";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $path . "/" . $filename
        );
        $finalImage = "assets/uploads/products/" . $filename;
    } else {
        $finalImage = '';
    }
    $data = [
        'category_id' => $categoryId,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status,
    ];
    $result = insert('products', $data);
    if ($result) {
        redirect('products.php', 'Category Creted Successfully!');
    } else {
        redirect('products-crate.php', 'Something Went Wrong!');
    }
}

if (isset($_POST['updateProduct'])) {
    $product_id = validate($_POST['product_id']);
    $productData = getById('products', $product_id);
    if (!$productData) {
        redirect('products.php', 'No Such Product found');
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products/";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $path . "/" . $filename
        );
        $finalImage = "assets/uploads/products/" . $filename;
    } else {
        $finalImage = '';
    }
    $data = [
        'category_id' => $categoryId,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status,
    ];
    $result = insert('products', $data);
    if ($result) {
        redirect('products.php', 'Category Creted Successfully!');
    } else {
        redirect('products-crate.php', 'Something Went Wrong!');
    }
}
