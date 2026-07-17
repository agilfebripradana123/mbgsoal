<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="<?=base_url();?>">
            <img src="<?=base_url();?>assets/images/logo.png"
                 width="50"
                 height="50"
                 class="me-2">

            <div>
                <h5 class="mb-0 fw-bold">Universitas MBG</h5>
                <small class="text-light">Sistem Ujian Online</small>
            </div>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse"
             id="navbarSupportedContent">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link active" href="<?=base_url();?>">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Fakultas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Program Studi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Panduan
                    </a>
                </li>

            </ul>

            <?php
            if($this->session->userdata('loginMasuk')==FALSE){
            ?>

                <a href="<?=base_url();?>login"
                   class="btn btn-warning fw-bold px-4 rounded-pill">
                    Login
                </a>

            <?php
            }else{
            ?>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-bs-toggle="dropdown">

                        👤 <?=$this->session->userdata('nama_user');?>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>
                            <a class="dropdown-item" href="#">
                                Profil Saya
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger"
                               href="<?=base_url();?>login/keluar">
                                Keluar
                            </a>
                        </li>

                    </ul>

                </li>
            </ul>

            <?php } ?>

        </div>

    </div>
</nav>