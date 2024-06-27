<style>
    html{
        height: 100%;
    }
    body{
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .footer-area{
        margin-top: auto;
    }
</style>
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">

                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo $this->lang->line('photo'); ?></div>
                            <div class="subtitle"><?php echo $this->lang->line('update_your_photo'); ?>.</div>
                            <br/>
                            <img src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="" class="img-fluid">
                            <div class="name"><?php echo $this->lang->line('language') == 'english' ? $user_details['first_name'] : $user_details['name_arabic']; ?></div>
                        </div>
                        <div class="user-dashboard-menu col-3 float-left mt-4 mb-3">
                            <ul>
                                <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo $this->lang->line('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo $this->lang->line('account'); ?></a></li>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo $this->lang->line('photo'); ?></a></li>
                            </ul>
                        </div>
                        <?= form_open_multipart(site_url('home/update_profile/update_photo')) ?>
                        <!--<form action="<?php //echo site_url('home/update_profile/update_photo');  ?>" enctype="multipart/form-data" method="post">-->
                        <div class="content-box form-body col-9 float-left">
                            <div class="email-group">
                                <div class="form-group">
                                    <label for="user_image"><?php echo $this->lang->line('upload_image'); ?>:</label>
                                    <input type="file" class="form-control" name = "user_image" id="user_image">
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
