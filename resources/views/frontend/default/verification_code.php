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
                          <div class="title"><?php echo $this->lang->line('enter_the_code_from_your_email'); ?></div>
                          <div class="subtitle"><?php echo $this->lang->line('let_us_know_that_this_email_address_belongs_to_you'); ?> <?php echo $this->lang->line('Enter_the_code_from_the_email_sent_to').' '.$this->session->userdata('register_email'); ?>.</div>
                      </div>
                      <?= form_open('javascript:;') ?>
                      <!--<form action="javascript:;" method="post">-->
                          <div class="content-box">
                              <div class="basic-group">
                                  <div class="form-group">
                                      <label for="login-email"><?php echo $this->lang->line('verification_code'); ?>:</label>
                                      <input type="text" class="form-control" id = "verification_code" required>
                                      <a href="javascript:;" class="text-left p-3" id="resend_mail_button" onclick="resend_verification_code()">
                                        <div class="float-left"><?= $this->lang->line('resend_mail') ?></div>
                                        <div id="resend_mail_loader" class="float-left pl-2"></div>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="content-update-box">
                              <a href="javascript:;" onclick="continue_verify()" class="btn"><?php echo $this->lang->line('continue'); ?></a>
                          </div>
                      <?= form_close() ?>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
  function continue_verify() {
    var email = '<?= $this->session->userdata('register_email'); ?>';
    var verification_code = $('#verification_code').val();
    $.ajax({
      type: 'post',
      url: '<?php echo site_url('login/verify_email_address/'); ?>',
      data: {verification_code : verification_code, email : email, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
      success: function(response){
        if(response){
          window.location.replace('<?= site_url('home/login'); ?>');
        }else{
          location.reload();
        }
      }
    });
  }
  
  function resend_verification_code() {
    $("#resend_mail_loader").html('<img src="<?= base_url('assets/global/gif/page-loader-3.gif'); ?>" style="width: 25px;">');
    var email = '<?= $this->session->userdata('register_email'); ?>';
    $.ajax({
      type: 'post',
      url: '<?php echo site_url('login/resend_verification_code/'); ?>',
      data: {email : email, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
      success: function(response){
        toastr.success('<?php echo $this->lang->line('mail_successfully_sent_to_your_inbox');?>');
        $("#resend_mail_loader").html('');
      }
    });
  }
</script>
