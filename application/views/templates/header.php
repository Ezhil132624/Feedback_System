<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #7b2cbf, #5a189a);
            color: white;
            padding-top: 1rem;
            position: fixed;
            width: 240px;
            z-index: 11;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #fff;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #e0cfff;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 1rem;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(6px);
        }

        .sidebar a.active {
            background: linear-gradient(to right, #9d4edd, #7b2cbf);
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            border-left: 4px solid #ffffff;
            box-shadow: inset 3px 0 0 rgba(255, 255, 255, 0.2);
            border-radius: 0 8px 8px 0;
        }



        .content-area {
            margin-left: 240px;
            padding: 20px;
            transition: margin 0.3s ease;
        }

        .navbar {
            background-color: #ffffff;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .topbar-icons a {
            color: #6f42c1;
            margin-left: 20px;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .topbar-icons a:hover {
            color: #4b2993;
        }

        /* Overlay for mobile */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            height: 100%;
            width: 100%;
            z-index: 10;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                height: 100vh;
                width: 240px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-area {
                margin-left: 0;
            }

            #overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Overlay for mobile sidebar -->
    <div id="overlay"></div>

    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h4><i class="fas fa-bolt me-2"></i> Feedback Panel</h4>

            <a href="<?= base_url('view/home'); ?>" class="dashboard-link active">
                <i class="fas fa-tachometer-alt"></i> Feedback Dashboard
            </a>
            <a href="<?= base_url('view/question'); ?>">
                <i class="fas fa-question-circle"></i> Feedback Questions
            </a>
            <a href="<?= base_url('view/group'); ?>">
                <i class="fas fa-layer-group"></i> Feedback Groups
            </a>
            <a href="<?= base_url('View/feedback_answer'); ?>">
                <i class="fas fa-eye"></i> Feedback Answers
            </a>
        </div>

        <!-- Main Content -->
        <div class="content-area flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-expand justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <!-- Mobile Toggle -->
                    <button class="btn btn-outline-dark d-md-none me-3" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="fw-bold text-dark">Dashboard</span>
                </div>

                <div class="topbar-icons d-flex align-items-center">
                    <a href="#" title="Profile"><i class="fas fa-user-circle"></i></a>
                    <a href="<?= base_url('login'); ?>" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </nav>