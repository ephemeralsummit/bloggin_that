<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'User Management') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --content-width: 720px;
            --sidebar-width: 300px;
        }
        button[data-bs-toggle="tab"].active {
            background-color: #212529;
            color: #fff;
            border-color: #212529;
        }

        /* Base tab style */
        #profileTabs .nav-link {
            background: transparent;
            color: #212529;
        }

        /* Underline indicator */
        #profileTabs .tab-btn {
            position: relative;
        }

        #profileTabs .tab-btn::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: transparent;
            transition: background-color 0.2s ease;
        }

        #profileTabs .tab-btn.active::after {
            background: #212529;
        }

        /* Vertical divider in the center */
        #profileTabs::after {
            content: "";
            position: absolute;
            top: 15%;
            bottom: 15%;
            left: 50%;
            width: 1px;
            background: #6c757d;
        }

        .nav .nav-item a.nav-link.active {
            color: #fff !important;
        }
        .sidebar {
            position: fixed;
            top: 56px; /* navbar height */
            left: calc(58% - (var(--content-width) / 2) - var(--sidebar-width));
            width: 150px;
            height: calc(100vh - 56px);
            z-index: 1000;
            padding-top:10px;
            padding-bottom:10px;
        }
        .sidebar .nav-link span, .sidebar .nav-link small {
            padding-left: 0;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            flex-direction: row;
            justify-content: flex-start;
            margin-right:15px;
            gap: 12px;
        }

        .main-content {
            min-height: calc(100vh - 56px);
            display: flex;
            justify-content: center;
        }

        .content-wrapper {
            width: 100%;
            max-width: var(--content-width);
            border-left: 1px solid #6C757D;
            border-right: 1px solid #6C757D;
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 20px;
            line-height: 1;
            justify-content: flex-end;
        }

        .sidebar span {
            font-size: 1.5rem;
        }

        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                top: auto !important;
                bottom: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 60px !important;
                z-index: 999;
                border-top: 1px solid #6C757D;
            }

            .sidebar .nav {
                display: flex;
                flex-direction: row !important;
                align-items: center;
                justify-content: space-around;
                width: 100%;

            }

             .sidebar .nav-link i {
                font-size: 22px;
            }

            .sidebar .nav-item.mt-auto {
                margin-top: 0 !important;
            }

            .sidebar .nav-link {
                justify-content: center;
                margin-right: 0;
            }

            .sidebar .nav-link span, .sidebar .nav-link small {
                display: none !important;
            }

            .sidebar .border-top {
                border-top: none !important;
            }

            .sidebar .border-bottom {
                border-bottom: none !important;
            }

            #toggleSidebar {
                display: none !important;
            }

            .nav .nav-item a.nav-link.active {
                color: #0d6efd !important;
                background: none;
                border-bottom: 4px solid #0d6efd !important;
                padding-bottom: 16px !important;
            }        
            .main-content {
                padding-bottom: 30px;
            }    
        }
    </style>
</head>
<body class="bg-light">
    <?php
    $tags = array_filter(array_map('trim', explode(',', $post['Tags'] ?? '')));
    ?>
    <nav class="navbar navbar-expand-lg sticky-top bg-light border-bottom border-secondary">
        <div class="container justify-content-center pt-1">
            <h4>Blog</h4>
            <!-- <div>
                <a href="<?= site_url('users') ?>" class="btn btn-outline-dark text-dark btn-sm">Users</a>
                <a href="<?= site_url('posts') ?>" class="btn btn-outline-dark text-dark btn-sm">Posts</a>
                <?php if (session()->has('UserID')): ?>
                    <a href="<?= site_url('users/profile/'.session()->get('UserID')) ?>"class="btn btn-outline-dark text-dark btn-sm">Profile</a>
                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>" class="btn btn-outline-primary btn-sm">Login</a>
                <?php endif; ?>
            </div> -->
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="bg-light sidebar" id="sidebar">
            <ul class="nav nav-pills flex-column h-100">
                <li class="nav-item">
                    <a href="<?= site_url('/') ?>" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                        <span>home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <span>search</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= site_url('posts/create') ?>" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span>post</span>
                    </a>
                </li>

                <?php if (session()->has('UserID')): ?>

                <li class="nav-item mt-auto">
                    <a href="<?= site_url('users') ?>" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-signing"></i>
                        <span>admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('users/profile/'.session()->get('UserID')) ?>" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-user"></i>
                        <span>profile</span>
                    </a>
                </li>

                <?php else: ?>
                <li class="nav-item mt-auto">
                    <a href="<?= site_url('login') ?>" class="nav-link py-2 rounded-0 text-black">
                        <i class="fa fa-hand-o-right"></i>
                        <span>login</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="main-content">
            <div class="content-wrapper">
                
                <?= $this->renderSection('content') ?>
            </div>
            
        </div>
    </div>
        
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
