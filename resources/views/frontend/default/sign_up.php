<?php $setting = setting(); ?>
<link href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />
<style>
    label > span{
        position: inherit;
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
                <h1 class="category-name">
                    <?php echo $this->lang->line('register_yourself'); ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="user-dashboard-box mt-3">
                    <div class="user-dashboard-content w-100 login-form hidden">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('login'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('provide_your_valid_login_credentials'); ?>.</div>
                        </div>
                        <?= form_open(site_url('home/validate_login')) ?>
                        <!--<form action="<?php //echo site_url('home/validate_login');  ?>" method="post">-->
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
                                    <input type="email" class="form-control" name = "email" id="login-email" placeholder="<?php echo $this->lang->line('email'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="login-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo $this->lang->line('password'); ?>:</label>
                                    <input type="password" class="form-control" name = "password" placeholder="<?php echo $this->lang->line('password'); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="content-update-box">
                            <button type="submit" class="btn"><?php echo $this->lang->line('login'); ?></button>
                        </div>
                        <div class="forgot-pass text-center">
                            <span>or</span>
                            <a href="javascript::" onclick="toggoleForm('forgot_password')"><?php echo $this->lang->line('forgot_password'); ?></a>
                        </div>
                        <div class="account-have text-center">
                            <?php echo $this->lang->line('do_not_have_an_account'); ?>? <a href="javascript::" onclick="toggoleForm('registration')"><?php echo $this->lang->line('sign_up'); ?></a>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <div class="user-dashboard-content w-100 register-form">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('registration_form'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('sign_up_and_start_learning'); ?>.</div>
                        </div>
                        <?= form_open(site_url('home/validate_register')) ?>
                        <!--<form action="<?php //echo site_url('home/validate_register');  ?>" method="post">-->
                        <?php if ($error) { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <div class="content-box">
                            <div class="basic-group">
                               <!-- <div class="form-group">
                                    <label for="first_name"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php //echo $this->lang->line('name_in_english'); ?>:</label>
                                    <input type="text" class="form-control" name = "first_name" id="first_name" placeholder="<?php //echo $this->lang->line('name_in_english'); ?>" value="<?= set_value('first_name') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="name_arabic"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php //echo $this->lang->line('name_in_arabic'); ?>:</label>
                                    <input type="text" class="form-control" name = "name_arabic" id="name_arabic" placeholder="<?php //echo $this->lang->line('name_in_arabic'); ?>" value="<?= set_value('name_arabic') ?>" required>
                                </div> -->
                               
                               <div class="form-group">
                                    <label for="username"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php echo $this->lang->line('username'); ?>:</label>
                                    <input type="text" class="form-control" name = "username" id="username" placeholder="<?php echo $this->lang->line('username'); ?>" value="<?= set_value('username') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="registration-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo $this->lang->line('email'); ?>:</label>
                                    <input type="email" class="form-control" name = "email" id="registration-email" placeholder="<?php echo $this->lang->line('email'); ?>" value="<?= set_value('email') ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender"><span class="input-field-icon"><i class="fas fa-male"></i></span> <?php echo $this->lang->line('gender'); ?>:</label>
                                    <select class="form-control select2" name="gender" id="gender">
                                        <option value=""><?php echo $this->lang->line('select_option') ?></option>
                                        <option value="M" <?= set_value('gender') == 'M' ? 'selected' : '' ?>><?php echo $this->lang->line('male') ?></option>
                                        <option value="F" <?= set_value('gender') == 'F' ? 'selected' : '' ?>><?php echo $this->lang->line('female') ?></option>
                                    </select>
                                </div>
                              <!--  <div class="form-group">
                                    <label for="dob"><span class="input-field-icon"><i class="fas fa-birthday-cake"></i></span> <?php //echo $this->lang->line('date_of_birth') ?></label>
                                    <input type="text" id="dob" class="form-control" name="dob" placeholder="<?php //echo $this->lang->line('date_of_birth') ?>" value="<?php //echo set_value('dob'); ?>" required autofocus>
                                </div> -->
                                <div class="form-group">
                                    <label for="nationality"><?php echo $this->lang->line('nationality') ?></label>
                                    <select id="nationality" name="nationality" class="form-control select2" id="nationality">
                                        <?php
                                        if ($country) {
                                            foreach ($country as $key => $value) {
                                                $selected = '';
                                                if (set_value('nationality') == $value->id || (!$this->input->post() && $value->id == "114")) {
                                                    $selected = 'selected';
                                                }
                                                ?>
                                                <option <?= $selected ?> value="<?php echo $value->id; ?>" id="<?php echo $value->phonecode; ?>" ><?= $value->name .' -- '. $value->country_arName ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                             <!--   <div class="form-group">
                                    <label for="language"><?php //echo $this->lang->line('language'); ?>:</label>
                                    <select class="form-control select2" name="language">
                                        <?php //foreach ($languages as $language): ?>
                                            <?php //if (trim($language) != ""): ?>
                                                <option value="<?php //echo strtolower($language); ?>" <?php //if ($this->input->post('language') == $language): ?>selected<?php //endif; ?>><?php //echo ucwords($language); ?></option>
                                            <?php //endif; ?>
                                        <?php //endforeach; ?>
                                    </select>
                                </div> -->

                                <div class="form-group">
                                    <label for="mobile_no"><?php echo $this->lang->line('phone_number') ?></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" id="country_code_container">
                                            <select name="mobile_code" id="country_code" class="form-control select2" style="width: 100px;">
                                                <?php
                                                if ($country) {
                                                    foreach ($country as $key => $value) {
                                                        $selected = '';
                                                        if (set_value('mobile_code') == $value->phonecode || (!$this->input->post() && $value->id == "114")) {
                                                            $selected = 'selected';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $value->phonecode; ?>" <?= $selected ?> >
                                                            <?php echo $value->iso3 . ' (+' . $value->phonecode . ')'; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="text" id="mobile_no" class="form-control" name="mobile_no" placeholder="<?php echo $this->lang->line('phone_number') ?>" value="<?php echo set_value('mobile_no'); ?>"  required autofocus>
                                    </div>
                                    <label id="mobile_no-error" class="error" for="mobile_no"></label>
                                </div>
                                <div class="form-group">
                                    <label for="registration-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo $this->lang->line('password'); ?>:</label>
                                    <input type="password" class="form-control" name = "password" id="registration-password" placeholder="<?php echo $this->lang->line('password'); ?>" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo $this->lang->line('confirm_password') ?></label>
                                    <input type="password" id="confirm_password" class="form-control"  name="confirm_password" placeholder="<?php echo $this->lang->line('confirm_password') ?>" required>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" class="form-check-input" name="agree" id="terms" required value="1">
                                    <label class="form-check-label mr-4" for="exampleCheck1"><?php echo $this->lang->line('i_agree') ?> <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" ><?= $this->lang->line('terms_and_condition') ?></a></label>
                                    <p><label id="agree-error" class="error" for="agree"></label></p>
                                </div>
                            </div>
                        </div>
                        <div class="content-update-box">
                            <button type="submit" class="btn" id="signup_btn"><?php echo $this->lang->line('sign_up'); ?></button>
                        </div>
                        <div class="account-have text-center">
                            <?php echo $this->lang->line('already_have_an_account'); ?>? <a href="javascript::" onclick="toggoleForm('login')"><?php echo $this->lang->line('login'); ?></a>
                        </div>
                        <?= form_close() ?>
                    </div>

                    <div class="user-dashboard-content w-100 forgot-password-form hidden">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('forgot_password'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('provide_your_email_address_to_get_password'); ?>.</div>
                        </div>
                        <?= form_open(site_url('home/validate_forgot_password')) ?>
                        <!--<form action="<?php //echo site_url('home/validate_forgot_password');  ?>" method="post">-->
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $this->lang->line('terms_condition') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo $this->session->userdata('language') == 'english' ? $setting->terms_condition : $setting->terms_condition_ar; ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>

<script type="text/javascript">
                                    $("#signup_btn").prop('disabled', true);
                                    $('#dob').datepicker({
                                        format: 'yyyy-mm-dd',
                                        endDate: '-3y',
                                        autoclose: true
                                    });
                                    //$(".select2").select2();
                                    $("#terms").change(function () {
                                        if ($(this).prop('checked')) {
                                            $("#signup_btn").prop('disabled', false);
                                        } else {
                                            $("#signup_btn").prop('disabled', true);
                                        }
                                    });
                                    $(document).ready(function () {
                                      /*  $("#nationality").change(function () {
                                            $("#country_code").select2('destroy');
                                            var selected_phone_code = $(this).find(":selected").prop('id');
                                            $("#country_code").val(selected_phone_code);
                                            $("#country_code").select2();
                                        });*/
                                    });
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
