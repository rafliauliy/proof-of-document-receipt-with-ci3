<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAL BTTD Online</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <!-- Optionally, load custom CSS -->
    <!-- <link rel="stylesheet" href="path/to/custom.css"> -->
</head>

<body>

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5 pt-lg-5">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-lg-5 p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- Image Column (Visible on Large Screens) -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <!-- Form Column -->
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h1 class="h4 text-gray-900">KAL BTTD Online</h1>
                                    <span class="text-muted">Login</span>
                                </div>
                                <!-- Flash Data Message -->
                                <?= $this->session->flashdata('pesan'); ?>
                                <!-- Login Form -->
                                <?= form_open('', ['class' => 'user']); ?>
                                <div class="form-group">
                                    <input autofocus="autofocus" autocomplete="off" value="<?= set_value('username'); ?>" type="text" name="username" class="form-control form-control-user" placeholder="Username">
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <div class="text-center mt-4">
                                    <span class="small">
                                        <?= anchor('https://drive.google.com/file/d/1NQkgkX4cGPG9xepGFPPADRJ4547ZdHA8/view?usp=drive_link/', 'Panduan Penggunaan Aplikasi'); ?></span>
                                    </span>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Bootstrap JS -->
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>

</body>

</html>