<style>
    .flex-wrapper {
        display: flex;
        min-height: 65vh;
        flex-direction: column;
        justify-content: flex-start;
    }
    .footer-area {
        margin-top: auto;
    }
</style>
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

            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area flex-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="user-dashboard-box mt-3">
                    <div class="user-dashboard-content w-100 login-form">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('check_certificate'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('enter_the_cert_data'); ?>.</div>
                        </div>
                         <?= form_open(site_url('home/check_certificate')) ?>
                        <!--<form action="<?php //echo site_url('home/check_certificate'); ?>" method="get">-->
                            <?php if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error') || (isset($cert) && !$cert)) { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                    <?php
                                    if (!$this->session->flashdata('error')) {
                                        echo $this->lang->line('data_not_found');
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                            <?php if (!isset($cert) || (isset($cert) && !$cert)) { ?>
                                <div class="content-box">
                                    <div class="basic-group">
                                        <div class="form-group">
                                            <label for="login-email"><span class="input-field-icon"><i class="fas fa-qrcode"></i></span> &nbsp; <?php echo $this->lang->line('certificate_id'); ?>:</label>
                                            <input type="text" class="form-control" name = "cert_id" id="login-email" placeholder="<?php echo $this->lang->line('certificate_id'); ?>" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-update-box">
                                    <button type="submit" class="btn"><?php echo $this->lang->line('search'); ?></button>
                                </div>
                            <?php } else { ?>
                                <p class="p-4">
                                    <?= $this->lang->line('certificate_found') ?> <br/> 
                                    <?= $this->lang->line('this_cert_rewarded_to') ?> <?= $this->session->userdata('language') == 'english' ? $cert->first_name : $cert->name_arabic ?>
                                    <?= $this->lang->line('to_download_the_cert_details_plz_click_here') ?> <a class="text-primary" href="<?= base_url('home/download_certificate/' . base64_encode($cert->subject_id) . '/' . $cert->student_id) ?>"><?= $this->lang->line('here') ?></a>
                                </p>
                            <?php } ?>

                        </form>
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
