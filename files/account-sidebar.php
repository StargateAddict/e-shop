<!-- Sidebar-->
          <aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
            <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
              <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
                <div class="d-md-flex align-items-center">
                  <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;"><img class="rounded-circle" src="img/shop/account/avatar.jpg" alt="<?= $_SESSION['user']['first_name'] ?>"></div>
                  <div class="ps-md-3">
                    <h3 class="fs-base mb-0"><?= $_SESSION['user']['first_name'] ?></h3><span class="text-accent fs-sm"><?= $_SESSION['user']['email'] ?></span>
                  </div>
                </div><a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false"><i class="ci-menu me-2"></i>Account menu</a>
              </div>
              <div class="d-lg-block collapse" id="account-menu">
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">AdminDashboard</h3>
                </div>
                
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-products-add.php"><i class="ci-user opacity-60 me-2"></i>Create Product</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-products.php"><i class="ci-user opacity-60 me-2"></i>Products</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-categories.php"><i class="ci-user opacity-60 me-2"></i>Products categories</a></li>
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-categories-add.php"><i class="ci-user opacity-60 me-2"></i>Create Product category</a></li>
                </ul>
                
                <div class="bg-secondary px-4 py-3">
                  <h3 class="fs-sm mb-0 text-muted">My Account</h3>
                </div>
                
                <ul class="list-unstyled mb-0">
                  <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="account-orders.php"><i class="ci-user opacity-60 me-2"></i>My Orders</a></li>
                  <li class=" border-top mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="logout.php"><i class="ci-sign-out opacity-60 me-2"></i>Sign out</a></li>
                </ul>
              </div>
            </div>
          </aside>