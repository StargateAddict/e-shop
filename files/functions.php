<?php


require_once 'Zebra_Image.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', 'http://localhost/e-shop');

$conn = new mysqli('localhost', 'root', '', 'e-shop');

function get_product($id)
{
    $sql = "SELECT * FROM products WHERE id = $id";
    global $conn;
    $data['pro'] = $conn->query($sql)->fetch_assoc();
    $cat ['cat'] = null;
    if($data['pro'] != null){
        $cat_id = $data['pro']['category_id']; 
        $sql = "SELECT * FROM categories WHERE id = $cat_id"; 
        $data['cat'] = $conn->query($sql)->fetch_assoc();
    }    
    return $data;
}

function get_product_thumb($json)
{
    $img = "assets/no_image.jpg";
    if ($json == null) {
        return $img;
    }
    if (strlen($json) < 4) {
        return $img;
    }
    $objects = json_decode($json);
    if (empty($objects)) {
        return $img;
    }
     
    if (!is_array($objects)) {
        $objects = [$objects];
    }

    if (!isset($objects[0]->thumb)) {
        return $img;
    }
    return $objects[0]->thumb;
}

function get_product_photos($json)
{
    $default = (object)[
        'src' => 'assets/no_image.jpg',
        'thumb' => 'assets/no_image.jpg'
    ];
    $photos = [$default];

    if ($json == null) {
        return $photos;
    }
    if (strlen($json) < 4) {
        return $photos;
    }
    $objects = json_decode($json);

    if (empty($objects)) {
        return $photos;
    }

    if (!is_array($objects)) {
        $objects = [$objects];
    }

    return $objects;
}

function db_select($table, $condition = null)
{
    $sql = "SELECT * FROM $table ";
    if ($condition != null) {
        $sql .= " WHERE $condition ";
    }
    global $conn;
    $res = $conn->query($sql);
    $rows = [];
    while ($row = $res->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function db_insert($table_name, $data)
{
    $sql = "INSERT INTO $table_name";

    $column_names = "(";
    $column_values = "(";

    $is_first = true;
    foreach ($data as $key => $value) {

        if ($is_first) {
            $is_first = false;
        } else {
            $column_names .= ",";
            $column_values .= ",";
        }

        $column_names .= $key;

        if (is_numeric($value)) {
            $column_values .= $value;
        } else {
            $column_values .= "'$value'";
        }
    }

    $column_names .= ")";
    $column_values .= ")";
    $sql .= $column_names . " VALUES " . $column_values;

    global $conn;
    if ($conn->query($sql)) {
        return true;
    } else {
        return false;
    }
}

use stefangabos\Zebra_Image\Zebra_Image;


function create_thumb($source, $target)
{
    $image = new Zebra_Image();

    ini_set('memory_limit', '-1');

    $image->auto_handle_exif_orientation = true;
    $image->source_path = $source;
    $image->target_path = $target;
    $image->preserve_aspect_ratio = true;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;
    $image->sharpen_images = true;
    $image->jpeg_quality = 90;

    $width = 500;
    $height = 500;

    if (!$image->resize($width, $height, ZEBRA_IMAGE_CROP_CENTER)) {
        return false;
    }

    return true;
}

function get_jpeg_quality($_size)
{
    $size = ($_size / 1000000);

    $qt = 50;
    if ($size > 5) {
        $qt = 10;
    } else if ($size > 4) {
        $qt = 13;
    } else if ($size > 2) {
        $qt = 15;
    } else if ($size > 1) {
        $qt = 17;
    } else if ($size > 0.8) {
        $qt = 50;
    } else if ($size > .5) {
        $qt = 80;
    } else {
        $qt = 90;
    }

    return $qt;
}

function upload_images($files)
{
    ini_set('memory_limit', '512M');
    if ($files == null || empty($files)) {
        return [];
    }
    $uploaded_images = array();

    foreach ($files as $file) {
        if (
            isset($file['name']) &&
            isset($file['type']) &&
            isset($file['tmp_name']) &&
            isset($file['error']) &&
            isset($file['size'])
        ) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name = time() . "-" . rand(1000, 10000) . "." . $ext;
            $destination = 'uploads/' . $file_name;
            $thumb_destination = 'uploads/thumb_' . $file_name;

            $res = move_uploaded_file($file['tmp_name'], $destination);
            if (!$res) {
                continue;
            }

            create_thumb($destination, $thumb_destination);
            $img['src'] = $destination;
            $img['thumb'] = $thumb_destination;
            $uploaded_images[] = $img;
        }
    }

    return $uploaded_images;
}

function url($path = "/")
{
    return BASE_URL . $path;
}

function protected_area()
{
    if (!isset($_SESSION['user'])) {
        alert('warning', 'Unauthorized access, login before you proceed.');
        header('Location: login.php');
        die();
    }
}

function logout()
{
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    alert('success', 'Logout successfully.');
    header('Location: login.php');
    die();
}

function is_logged_in()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

function alert($type, $message)
{
    $_SESSION['alert']['type'] = $type;
    $_SESSION['alert']['message'] = $message;
}


function login_user($email, $password)
{

    global $conn;
    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $res = $conn->query($sql);

    if ($res->num_rows < 1) {
        return false;
    }

    $row = $res->fetch_assoc();

    if (!password_verify($password, $row['password'])) {
        return false;
    }

    $_SESSION['user'] = $row;

    return true;
}

function text_input($data)
{
    $name = isset($data['name']) ? $data['name'] : "";
    $attributes = isset($data['attributes']) ? $data['attributes'] : "";

    $value = "";
    $error = "";
    $error_text = "";
    if (isset($_SESSION['form'])) {
        if (isset($_SESSION['form']['value'])) {
            if (isset($_SESSION['form']['value'][$name])) {
                $value = $_SESSION['form']['value'][$name];
            }
        }
    }



    if (isset($_SESSION['form'])) {
        if (isset($_SESSION['form']['error'])) {
            if (isset($_SESSION['form']['error'][$name])) {
                $error = $_SESSION['form']['error'][$name];
                $error_text = '<div class="form-text text-danger">' . $error . '</div>';
            }
        }
    }


    $label = isset($data['label']) ? $data['label'] : $name;
    $value = isset($data['value']) ? $data['value'] : $value;
    $error = isset($data['error']) ? $data['error'] : $error;


    return
        '<label class="form-label text-capitalize" for="' . $name . '">' . $label . '</label>' .
        '<input name="' . $name . '" value="' . $value . '" class="form-control" type="text" id="' . $name . '" placeholder="' . $label . '" ' . $attributes . '>' .
        $error_text;
}

function select_input($data, $options)
{
    $name = isset($data['name']) ? $data['name'] : "";
    $attributes = isset($data['attributes']) ? $data['attributes'] : "";

    $value = "";
    $error = "";
    $error_text = "";
    if (isset($_SESSION['form'])) {
        if (isset($_SESSION['form']['value'])) {
            if (isset($_SESSION['form']['value'][$name])) {
                $value = $_SESSION['form']['value'][$name];
            }
        }
    }

    if (isset($_SESSION['form'])) {
        if (isset($_SESSION['form']['error'])) {
            if (isset($_SESSION['form']['error'][$name])) {
                $error = $_SESSION['form']['error'][$name];
                $error_text = '<div class="form-text text-danger">' . $error . '</div>';
            }
        }
    }

    $label = isset($data['label']) ? $data['label'] : $name;
    $value = isset($data['value']) ? $data['value'] : $value;
    $error = isset($data['error']) ? $data['error'] : $error;

    $options_html = "";
    foreach ($options as $key => $option) {
        $selected = ($key == $value) ? 'selected' : '';
        $options_html .= '<option value="' . $key . '" ' . $selected . '>' . $option . '</option>';
    }

    return
        '<label class="form-label text-capitalize" for="' . $name . '">' . $label . '</label>' .
        '<select name="' . $name . '" class="form-control form-select" id="' . $name . '" ' . $attributes . '>' .
        $options_html .
        '</select>' .
        $error_text;
}


function product_item_ui_1($pro)
{
    $thumb = $pic = get_product_thumb($pro['photos']);
    $str = <<<EOF

    <div class="col-md-4 col-sm-6 px-2 mb-4">
        <div class="card product-card">
        <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="ci-heart"></i></button><a class="card-img-top d-block overflow-hidden" href="product.php?id={$pro['id']}">
                <img src="{$thumb} " alt="Product">
            </a>
            <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1" href="javascript:;">Sneakers &amp; Keds</a>
                <h3 class="product-title fs-sm"><a href="product.php?id={$pro['id']}"> {$pro['name']}</a></h3>
                <div class="d-flex justify-content-between">
                    <div class="product-price"><span class="text-accent">$ {$pro['selling_price']}</span></div>
                    <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star"></i>
                    </div>
                </div>
            </div>
            <div class="card-body card-body-hidden">
                <div class="text-center pb-2">
                    <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size1" id="s-75">
                        <label class="form-option-label" for="s-75">7.5</label>
                    </div>
                    <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size1" id="s-80" checked>
                        <label class="form-option-label" for="s-80">8</label>
                    </div>
                    <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size1" id="s-85">
                        <label class="form-option-label" for="s-85">8.5</label>
                    </div>
                        <div class="form-check form-option form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="size1" id="s-90">
                            <label class="form-option-label" for="s-90">9</label>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="button"><i class="ci-cart fs-sm me-1"></i>Add to Cart</button>
                    <div class="text-center"><a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div>
                </div>
            </div>
        <hr class="d-sm-none">
     </div>
    
    EOF;
    return $str;
}
