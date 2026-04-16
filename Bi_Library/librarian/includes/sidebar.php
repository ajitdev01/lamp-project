        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Pages</div>
                            <a class="nav-link" href="students.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Students
                            </a>
                            <a class="nav-link" href="books.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Books
                            </a>
                            <a class="nav-link" href="requests.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Requests
                            </a>
                            <a class="nav-link" href="issued.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Issued
                            </a>
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $_SESSION['lb_name'] ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>