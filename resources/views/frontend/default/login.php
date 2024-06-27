<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo $page_title; ?>
                            </a>
                        </li>
                    </ol>
                </nav>
                <h1 class="category-name">
                    <?php echo $this->lang->line('registered_user'); ?>
                </h1>
            </div>
        </div>
    </div>
</section>
<?php echo $this->session->userdata('is_instructor'); ?>
<section class="category-course-list-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="user-dashboard-box mt-3">
                    <div class="user-dashboard-content w-100 login-form">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('login'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('provide_your_valid_login_credentials'); ?>.</div>
                        </div>
                        <!--<form action="<?php //echo site_url('home/validate_login'); ?>" method="post">-->
                        <?= form_open(site_url('home/validate_login')) ?>
                            <?php if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                            <div class="content-box">
                                <div class="basic-group">
                                    <div class="form-group">
                                        <label for="login-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo $this->lang->line('email'); ?>:</label>
                                        <input type="email" class="form-control" name = "email" id="login-email" placeholder="<?php echo $this->lang->line('email'); ?>" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="login-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo $this->lang->line('password'); ?>:</label>
                                        <input type="password" class="form-control" name = "password" placeholder="<?php echo $this->lang->line('password'); ?>" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn"><?php echo $this->lang->line('login'); ?></button>
                            </div>
                            <div class="forgot-pass text-center">
                                <span><?php echo $this->lang->line('or'); ?></span>
                                <a href="javascript::" onclick="toggoleForm('forgot_password')"><?php echo $this->lang->line('forgot_password'); ?></a>
                            </div>
                            <div class="account-have text-center">
                                <?php echo $this->lang->line('do_not_have_an_account'); ?>? <a href="<?= base_url() ?>home/sign_up"><?php echo $this->lang->line('sign_up'); ?></a> <!-- href="javascript::" onclick="toggoleForm('registration')" -->
                            </div>
                        <?= form_close() ?>
                    </div>
            

                    <div class="user-dashboard-content w-100 forgot-password-form hidden">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('forgot_password'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('provide_your_email_address_to_get_password'); ?>.</div>
                        </div>
                        <?= form_open(site_url('home/validate_forgot_password')) ?>
                        <!--<form action="<?php //echo site_url('home/validate_forgot_password'); ?>" method="post">-->
                            <div class="content-box">
                                <div class="basic-group">
                                    <div class="form-group">
                                        <label for="forgot-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo $this->lang->line('email'); ?>:</label>
                                        <input type="email" class="form-control" name = "email" id="forgot-email" placeholder="<?php echo $this->lang->line('email'); ?>" value="" required>
                                        <small class="form-text text-muted"><?php echo $this->lang->line('provide_your_email_address_to_get_password'); ?>.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn"><?php echo $this->lang->line('reset_password'); ?></button>
                            </div>
                            <div class="forgot-pass text-center">
                                <?php echo $this->lang->line('want_to_go_back'); ?>? <a href="javascript::" onclick="toggoleForm('login')"><?php echo $this->lang->line('login'); ?></a>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function toggoleForm(form_type) {
        if (form_type === 'login') {
            $('.login-form').show();
            $('.forgot-password-form').hide();
            $('.register-form').hide();
        } else if (form_type === 'registration') {
            $('.login-form').hide();
            $('.forgot-password-form').hide();
            $('.register-form').show();
        } else if (form_type === 'forgot_password') {
            $('.login-form').hide();
            $('.forgot-password-form').show();
            $('.register-form').hide();
        }
    }
</script>
