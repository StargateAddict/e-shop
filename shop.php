<?php
require_once('files/header.php');

$condition = ' 1 ORDER BY id DESC';
if (isset($_GET['category_id'])) {
    $cat_id = (int)$_GET['category_id'];
    $condition = " category_id = $cat_id ORDER BY id DESC";
}
$products = db_select('products', $condition);
?>

<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="index.php"><i class="ci-home"></i>Home</a></li>
                    <li class="breadcrumb-item text-nowrap"><a href="shop.php">Shop</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Grid left sidebar</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Shop</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <aside class="col-lg-4">
            <div class="offcanvas offcanvas-collapse bg-white w-100 rounded-3 shadow-lg py-1" id="shop-sidebar" style="max-width: 22rem;">
                <div class="offcanvas-header align-items-center shadow-sm">
                    <h2 class="h5 mb-0">Filters</h2>
                    <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body py-grid-gutter px-lg-grid-gutter">
                    <div class="widget widget-categories mb-4 pb-4 border-bottom">
                        <h3 class="widget-title">Categories</h3>
                        <div class="accordion mt-n1" id="shop-categories">
                            <?php
                            $cats = db_select('categories');
                            foreach ($cats as $cat):
                            ?>
                                <div class="accordion-item">
                                    <h3 class="accordion-header">
                                        <a class="accordion-button collapsed" href="#cat-<?= $cat['id'] ?>" role="button" data-bs-toggle="collapse">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </a>
                                    </h3>
                                    <div class="accordion-collapse collapse" id="cat-<?= $cat['id'] ?>">
                                        <div class="accordion-body">
                                            <a href="shop.php?category_id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                Zobraziť produkty
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="widget mb-4 pb-4 border-bottom">
                        <h3 class="widget-title">Price</h3>
                        <div class="range-slider" data-start-min="250" data-start-max="680" data-min="0" data-max="1000" data-step="1">
                            <div class="range-slider-ui"></div>
                            <div class="d-flex pb-1">
                                <div class="w-50 pe-2 me-2">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input class="form-control range-slider-value-min" type="text">
                                    </div>
                                </div>
                                <div class="w-50 ps-2">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input class="form-control range-slider-value-max" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <section class="col-lg-8">
            <div class="d-flex justify-content-center justify-content-sm-between align-items-center pt-2 pb-4 pb-sm-5">
                <div class="d-flex flex-wrap">
                    <div class="d-flex align-items-center flex-nowrap me-3 me-sm-4 pb-3">
                        <label class="text-light opacity-75 text-nowrap fs-sm me-2 d-none d-sm-block" for="sorting">Sort by:</label>
                        <select class="form-select" id="sorting">
                            <option>Popularity</option>
                            <option>Low - High Price</option>
                            <option>High - Low Price</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mx-n2">
                <?php
                if (!empty($products)) {
                    foreach ($products as $pro) {
                        echo product_item_ui_1($pro);
                    }
                } else {
                    echo '<div class="col-12 text-center py-5"><h3>No products found!</h3></div>';
                }
                ?>
            </div>

            <hr class="my-3">

            <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#"><i class="ci-arrow-left me-2"></i>Prev</a></li>
                </ul>
                <ul class="pagination">
                    <li class="page-item active"><span class="page-link">1</span></li>
                </ul>
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#" aria-label="Next">Next<i class="ci-arrow-right ms-2"></i></a></li>
                </ul>
            </nav>
        </section>
    </div>
</div>

<?php
require_once('files/footer.php');
?>