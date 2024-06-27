
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">

                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('account'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('edit_your_account_settings'); ?>.</div>
                            <br/>
                            <img src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="" class="img-fluid">
                            <div class="name"><?php echo $this->lang->line('language') == 'english' ? $user_details['first_name'] : $user_details['name_arabic']; ?></div>
                        </div>
                        <div class="user-dashboard-menu col-3 float-left mt-5">
                            <ul>
                                <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo $this->lang->line('profile'); ?></a></li>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo $this->lang->line('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo $this->lang->line('photo'); ?></a></li>
                            </ul>
                        </div>
                        <?= form_open(site_url('home/update_profile/update_credentials')) ?>
                        <!--<form action="<?php //echo site_url('home/update_profile/update_credentials');    ?>" method="post">-->
                        <div class="content-box form-body col-9 float-left">
                            <div class="email-group">
                                <div class="form-group">
                                    <label for="language"><?php echo $this->lang->line('language'); ?>:</label>
                                    <select class="form-control" name="language">
                                        <?php foreach ($languages as $language): ?>
                                            <?php if (trim($language) != ""): ?>
                                                <option value="<?php echo strtolower($language); ?>" <?php if ($user_details['language'] == $language): ?>selected<?php endif; ?>><?php echo ucwords($language); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email"><?php echo $this->lang->line('email'); ?>:</label>
                                    <input type="email" class="form-control" name = "email" id="email" placeholder="<?php echo $this->lang->line('email'); ?>" value="<?php echo $user_details['email']; ?>">
                                </div>
                            </div>
                            <div class="password-group">
                                <div class="form-group">
                                    <label for="password"><?php echo $this->lang->line('password'); ?>:</label>
                                    <input type="password" class="form-control" id="current_password" name = "current_password" placeholder="<?php echo $this->lang->line('enter_current_password'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name = "new_password" placeholder="<?php echo $this->lang->line('enter_new_password'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name = "confirm_password" placeholder="<?php echo $this->lang->line('re-type_your_password'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="content-update-box">
                            <button type="submit" class="btn"><?php echo $this->lang->line('save'); ?></button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
