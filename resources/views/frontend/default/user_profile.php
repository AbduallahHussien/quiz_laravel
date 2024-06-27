<?php //$social_links = json_decode($user_details['social_links'], true);          ?>
<?php //include "profile_menus.php";          ?>
<link href="<?php echo base_url(); ?>assets/admin/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php if ($this->session->flashdata('error')) { ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                <div class="user-dashboard-box">
                     
                    <!--                    <div class="user-dashboard-sidebar">
                                            <div class="user-box d-block">
                                                <img src="<?php //echo $this->user_model->get_user_image_url($this->session->userdata('user_id'));  ?>" alt="" class="img-fluid">
                                                <div class="name">
                                                    <div class="name"><?php //echo $this->lang->line('language') == 'english' ? $user_details['first_name'] : $user_details['name_arabic'];  ?></div>
                                                </div>
                                            </div>
                                            <div class="user-dashboard-menu">
                                                <ul>
                                                    <li class="active"><a href="<?php //echo site_url('home/profile/user_profile');  ?>"><?php echo $this->lang->line('profile'); ?></a></li>
                                                    <li><a href="<?php //echo site_url('home/profile/user_credentials');  ?>"><?php echo $this->lang->line('account'); ?></a></li>
                                                    <li><a href="<?php //echo site_url('home/profile/user_photo');  ?>"><?php echo $this->lang->line('photo'); ?></a></li>
                                                </ul>
                                            </div>
                                        </div>-->
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('profile'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('add_information_about_yourself_to_share_on_your_profile'); ?>.</div>
                            <br/>
                            <img src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="" class="img-fluid">
                            <div class="name">
                                <div class="name"><?php echo $user_details['username']; //echo $this->lang->line('language') == 'english' ? $user_details['first_name'] : $user_details['name_arabic']; ?></div>
                            </div>
                        </div>
                        <div class="user-dashboard-menu col-3 float-left mt-5">
                            <ul>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo $this->lang->line('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo $this->lang->line('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo $this->lang->line('photo'); ?></a></li>
                            </ul>
                        </div>
                        <?= form_open(site_url('home/update_profile/update_basics')) ?>
                        <!--<form action="<?php //echo site_url('home/update_profile/update_basics');   ?>" method="post">-->
                        <div class="content-box form-body col-9 float-left">
                            <div class="basic-group">

                                <div class="form-group">
                                    <label for="FristName"><?php echo $this->lang->line('name_in_english'); ?>:</label>
                                    <input type="text" class="form-control" name = "first_name" id="FristName" placeholder="<?php echo $this->lang->line('name_in_english'); ?>" value="<?php echo $user_details['first_name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="FristName"><?php echo $this->lang->line('name_in_arabic'); ?>:</label>
                                    <input type="text" class="form-control" name = "name_arabic" placeholder="<?php echo $this->lang->line('name_in_arabic'); ?>" value="<?php echo $user_details['name_arabic']; ?>">
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-form-label">
                                        <?php echo $this->lang->line('admin_date_of_birth'); ?>
                                    </label>
                                    <div class="col-lg-12 px-0">
                                        <input type="text" id="dob" name="dob" class="form-control" placeholder="<?php echo $this->lang->line('admin_date_of_birth'); ?>" value="<?php echo $user_details['dob']; ?>" s/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile_no"><?php echo $this->lang->line('phone_number') ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" id="country_code_container">
                                            <select name="mobile_code" id="country_code" class="form-control select2" style="width: 100px;">
                                                <?php
                                                if ($country) {
                                                    foreach ($country as $key => $value) {
                                                        $selected = '';
                                                        if ($user_details['mobile_code'] == $value->phonecode ) {
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
                                        <input type="text" id="mobile_no" class="form-control" name="mobile_no" placeholder="<?php echo $this->lang->line('phone_number') ?>" value="<?php echo $user_details['mobile_no']; ?>"  required autofocus>
                                    </div>
                                    <label id="mobile_no-error" class="error" for="mobile_no"></label>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-2 col-form-label">
                                        <?php echo $this->lang->line('admin_gender'); ?>
                                    </label>
                                    <div class="col-lg-12 px-0">
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value=""><?php echo $this->lang->line('admin_select_gender'); ?></option>
                                            <option value="M" <?= $user_details['gender'] == 'M' ? 'selected' : '' ?>><?php echo $this->lang->line('admin_male'); ?></option>
                                            <option value="F" <?= $user_details['gender'] == 'F' ? 'selected' : '' ?>><?php echo $this->lang->line('admin_female'); ?></option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-2 col-form-label">
                                        <?php echo $this->lang->line('admin_nationality'); ?>
                                    </label>
                                    <div class="col-lg-12 px-0">
                                        <select id="country" name="nationality" class="form-control select2" >
                                            <?php
                                            if ($country) {
                                                foreach ($country as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value->id; ?>" id="<?php echo $value->iso; ?>"  <?php echo $value->id == $user_details['nationality'] ? "selected" : ""; ?>  ><?php echo $value->name; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <!--                                <div class="link-group">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" maxlength="60" name = "twitter_link" placeholder="<?php //echo $this->lang->line('twitter_link');          ?>" value="<?php //echo $social_links['twitter'];          ?>">
                                                                    <small class="form-text text-muted"><?php //echo $this->lang->line('add_your_twitter_link');          ?>.</small>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" maxlength="60" name = "facebook_link" placeholder="<?php //echo $this->lang->line('facebook_link');          ?>" value="<?php //echo $social_links['facebook'];          ?>">
                                                                    <small class="form-text text-muted"><?php //echo $this->lang->line('add_your_facebook_link');          ?>.</small>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" maxlength="60" name = "linkedin_link" placeholder="<?php //echo $this->lang->line('linkedin_link');          ?>" value="<?php //echo $social_links['linkedin'];          ?>">
                                                                    <small class="form-text text-muted"><?php //echo $this->lang->line('add_your_linkedin_link');          ?>.</small>
                                                                </div>
                                                            </div>-->
                        </div>
                        <div class="clearfix"></div>
                        <div class="content-update-box">
                            <button type="submit" class="btn"><?= $this->lang->line('save'); ?></button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/admin/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script>
    $("#dob").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
</script>
