<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container py-1">
            <a class="navbar-brand" href="<?php echo URLROOT; ?>/">
                <img src="<?php echo URLROOT; ?>/images/logo.svg" alt="<?php echo SITENAME; ?>" height="40">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/products">Products</a>
                    </li>
                </ul>

                <form class="d-flex me-3" action="<?php echo URLROOT; ?>/products/search" method="GET" onsubmit="return validateSearch(event)">
                    <div class="input-group">
                        <input class="form-control border-end-0 bg-light" type="search" name="q" placeholder="Search" aria-label="Search" 
                               value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        <span class="input-group-text bg-light border-start-0">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </form>

                <div class="d-flex align-items-center">
                    <a href="<?php echo URLROOT; ?>/cart" class="btn btn-link text-dark position-relative me-2">
                        <i class="bi bi-bag"></i>
                        <?php if(isset($_SESSION['user_id'])): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo get_cart_count(); ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="nav-item dropdown">
                            <a class="btn btn-link text-dark dropdown-toggle p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/users/profile">Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/orders">Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo URLROOT; ?>/auth/logout">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-link text-dark">
                            <i class="bi bi-person"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">