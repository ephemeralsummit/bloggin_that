<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'bloggin` that') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --content-width: 720px;
            --sidebar-width: 300px;
        }

        /* --- Sidebar Core --- */
        .sidebar {
            position: fixed;
            z-index: 1000;
            background-color: #f8f9fa;
        }

        
        #profileTabs .tab-btn {
            position: relative;
            background: transparent !important;
            border: none !important;
        }

        
        #profileTabs .tab-btn.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 20%;  
            right: 20%;
            height: 4px;
            background-color: #212529; 
            border-radius: 2px 2px 0 0;
        }

        #profileTabs::before {
            content: "";
            position: absolute;
            top: 25%;
            bottom: 25%;
            left: 50%;
            width: 1px;
            background-color: #6C757D;
            z-index: 1;
        }

        #profileTabs .tab-btn:focus {
            box-shadow: none !important;
        }

        /* --- Desktop View --- */
        @media (min-width: 1136px) {
            .sidebar {
                top: 56px;
                left: calc(58% - (var(--content-width) / 2) - var(--sidebar-width));
                width: 160px;
                height: calc(100vh - 56px);
                padding-top: 15px; 
            }
            .sidebar .nav {
                flex-direction: column !important;
                gap: 2px; 
            }
            .sidebar .nav-link {
                padding: 8px 20px; 
                font-size: 1.4rem;
                justify-content: flex-start;
            }
            .sidebar .nav-link i {
                font-size: 24px;
            }
            .sidebar .nav-link.active::after {
                content: "";
                position: absolute;
                left: 0; 
                top: 15%;
                height: 70%;
                width: 5px;
                background-color: #212529;
                border-radius: 0 4px 4px 0;
            }
        }

        /* --- Mobile View --- */
        @media (max-width: 1135px) {
            .sidebar {
                bottom: 0;
                left: 0;
                width: 100% !important;
                height: 70px;
                border-top: 1px solid #6C757D;
                padding: 0;
            }
            .sidebar .nav {
                flex-direction: row !important;
                justify-content: space-around;
                align-items: center;
                height: 100%;
            }
            .sidebar .nav-item {
                flex: 1;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .sidebar .nav-link {
                width: 100%;
                height: 100%;
                justify-content: center;
                padding: 0;
            }
            .sidebar .nav-link i {
                font-size: 28px;
            }
            .sidebar span {
                display: none !important; 
            }
            .sidebar .nav-link.active::after {
                content: "";
                position: absolute;
                bottom: 4px;
                left: 25%;
                right: 25%;
                height: 5px;
                background-color: #212529;
                border-radius: 3px;
            }
            .sidebar .nav-item.mt-auto {
                margin-top: 0 !important;
            }
        }

        /* Global Styles */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            background-color: transparent !important;
            color: #212529 !important;
            text-decoration: none;
            transition: transform 0.1s ease;
        }
        
        .sidebar .nav-link:active {
            transform: scale(0.95);
        }

        .sidebar .nav-link.active {
            font-weight: bold;
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
            background-color: #fff;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg sticky-top bg-light border-bottom border-secondary">
        <div class="container justify-content-center pt-1">
            <h5 class="mb-1">bloggin` that</h5>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="sidebar" id="sidebar">
            <ul class="nav h-100">
                <li class="nav-item">
                    <a href="<?= site_url('/') ?>" class="nav-link <?= url_is('/') ? 'active' : '' ?>">
                        <i class="fa fa-square-o"></i>
                        <span>home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= site_url('posts/search') ?>" class="nav-link <?= url_is('posts/search*') ? 'active' : '' ?>">
                        <i class="fa fa-search"></i>
                        <span>search</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= site_url('posts/create') ?>" class="nav-link <?= url_is('posts/create') ? 'active' : '' ?>">
                        <i class="fa fa-plus"></i>
                        <span>post</span>
                    </a>
                </li>

                <?php if (session()->has('UserID')): ?>
                <li class="nav-item mt-auto">
                    <a href="<?= site_url('users/profile/'.session()->get('UserID')) ?>" 
                       class="nav-link <?= url_is('users*') ? 'active' : '' ?>">
                        <i class="fa fa-user"></i>
                        <span>profile</span>
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item mt-auto">
                    <a href="<?= site_url('login') ?>" class="nav-link <?= url_is('login') ? 'active' : '' ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>