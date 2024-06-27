<?php
// $instructor_list = $this->user_model->get_instructor_list()->result_array();
?>

<?php //include "profile_menus.php"; ?>
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
<section class="message-area">
    <div class="container">
        <div class="row no-gutters align-items-stretch">
            <div class="col-lg-5">
                <div class="message-sender-list-box">
                    <button class="btn compose-btn" type="button" id="NewMessage" onclick="NewMessage(event)"><?= $this->lang->line('compose') ?></button>
                    <hr>
                    <ul class="message-sender-list">

                        <?php
                       // $this->load->model('Messages_Model');
                        //$message_threads = $this->Messages_Model->get_all_student_msgs();
//                        $current_user = $this->session->userdata('user_id');
//                        $this->db->where('sender', $current_user);
//                        $this->db->or_where('receiver', $current_user);
//                        $message_threads = $this->db->get('message_thread')->result_array();
                        foreach ($message_threads as $row):
                            $messages = $this->Messages_Model->getWholeConversation($row['id']);
                            $msgs_count = count($messages);
                            // defining the user to show
                            //                 $last_messages_details = $this->crud_model->get_last_message_by_message_thread_code($row['message_thread_code'])->row_array();
                            ?>
                            <a href="<?php echo site_url('home/my_messages/read_message/' . $row['id']); ?>">
                                <li>
                                    <div class="message-sender-wrap">
                                        <div class="message-sender-head clearfix">
                                            <div class="message-sender-info d-inline-block">
                                                <div class="sender-image d-inline-block">
                                                    <!--<img src="<?php //echo $messages[$msgs_count - 1]->from == $this->session->userdata('user_id') ? $this->user_model->get_user_image_url($this->session->userdata('user_id')) : $this->user_model->get_user_image_url(0); ?>" alt="" class="img-fluid">-->
                                                    <img src="<?php echo $this->user_model->get_user_image_url(0); ?>" alt="" class="img-fluid">
                                                </div>
                                                <div class="sender-name d-inline-block">
                                                    <?php
//                                                    if ($messages[$msgs_count-1]->from == $this->session->userdata('user_id')) {
//                                                        $user_to_show_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
//                                                        echo $this->session->userdata('language') == 'english' ? $user_to_show_details['first_name'] : $user_to_show_details['name_arabic'];
//                                                    } else {
                                                        echo 'Admin.';
                                                    //}
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="message-time d-inline-block float-right"><?php echo date('D, d-M-Y', strtotime($messages[$msgs_count-1]->date)); ?></div>
                                        </div>
                                        <div class="message-sender-body">
                                            <?php echo $messages[$msgs_count-1]->msg; ?>
                                        </div>
                                    </div>
                                </li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="message-details-box" id = "toggle-1">
                    <?php include 'inner_messages.php'; ?>
                </div>
                <div class="message-details-box" id = "toggle-2" style="display: none;">
                    <div class="new-message-details"><div class="message-header">
                            <div class="sender-info">
                                <span class="d-inline-block">
                                    <i class="far fa-user"></i>
                                </span>
                                <span class="d-inline-block"><?php echo $this->lang->line('new_message'); ?></span>
                            </div>
                        </div>
                        <?= form_open(site_url('home/my_messages/send_new')) ?>
                        <!--<form class="" action="<?php //echo site_url('home/my_messages/send_new'); ?>" method="post">-->
                            <div class="message-body">
                                <div class="form-group">
                                    <select name="type" id="type" class="form-control select2">
                                        <option value="suggestion"><?= $this->lang->line('suggestion') ?></option>
                                        <option value="complain"><?= $this->lang->line('complain') ?></option>
                                        <option value="inquiry"><?= $this->lang->line('inquiry') ?></option>
                                        <option value="other"><?= $this->lang->line('other') ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn send-btn"><?php echo $this->lang->line('send'); ?></button>
                                <button type="button" class="btn cancel-btn" onclick = "CancelNewMessage(event)">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function NewMessage(e) {

        e.preventDefault();
        $('#toggle-1').hide();
        $('#toggle-2').show();
        $('#NewMessage').removeAttr('onclick');
    }

    function CancelNewMessage(e) {

        e.preventDefault();
        $('#toggle-2').hide();
        $('#toggle-1').show();

        $('#NewMessage').attr('onclick', 'NewMessage(event)');
    }
</script>
