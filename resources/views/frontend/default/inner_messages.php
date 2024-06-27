<?php if (!isset($message_thread_code)): ?>
    <div class="text-center empty-box"><?php echo $this->lang->line('select_a_message_thread_to_read_it_here'); ?>.</div>
<?php endif; ?>
<?php
if (isset($message_thread_code)):
    $message_thread_details = $this->db->get_where('messages', array('id' => $message_thread_code))->row_array();
//    if ($this->session->userdata('user_id') == $message_thread_details['from']){
//        $user_to_show_id = $message_thread_details['receiver'];
//    }
//    else{
//        $user_to_show_id = $message_thread_details['sender'];
//    }
//    $user_to_show_details = $this->user_model->get_user($user_to_show_id)->row_array();

    $messages = $this->Messages_Model->getWholeConversation($message_thread_code);
    ?>
    <div class="message-details d-show">
        <div class="message-header">
            <!--<a href="<?php //echo site_url('home/instructor_page');   ?>">-->
            <span class="sender-info">
                <span class="d-inline-block">
                    <img src="<?php echo $message_thread_details['from'] == $this->session->userdata('user_id') ? $this->user_model->get_user_image_url($this->session->userdata('user_id')) : $this->user_model->get_user_image_url(0); ?>" alt="">
                </span>
                <span class="d-inline-block">
                    <?php
                    if ($message_thread_details['from'] == $this->session->userdata('user_id')) {
                        $user_to_show_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
                        echo $this->session->userdata('language') == 'english' ? $user_to_show_details['first_name'] : $user_to_show_details['name_arabic'];
                    } else {
                        echo 'Admin.';
                    }
                    ?>
                </span>
            </span>
            <!--</a>-->
        </div>
        <div class="message-content">
            <?php $last_msg = 0;
            foreach ($messages as $message):
                ?>
        <?php if ($message->from == $this->session->userdata('user_id')): ?>
                    <div class="message-box-wrap me">
                        <div class="message-box">
                            <div class="time"><?php echo date('D, d-M-Y', strtotime($message->date)); ?></div>
                            <div class="message"><?php echo $message->msg; ?></div>
                        </div>
                    </div>
                    <?php $last_msg = $message->id;
                else:
                    ?>
                    <div class="message-box-wrap">
                        <div class="message-box">
                            <div class="time"><?php echo date('D, d-M-Y', strtotime($message->date)); ?></div>
                            <div class="message"><?php echo $message->msg; ?></div>
                        </div>
                    </div>
                    <?php $last_msg = $message->id;
                endif;
                ?>
    <?php endforeach; ?>
        </div>
        <div class="message-footer">
            <?= form_open_multipart(site_url('home/my_messages/send_reply/' . $last_msg)) ?>
                <textarea class="form-control" name="message" placeholder="<?php echo $this->lang->line('type_your_message'); ?>..."></textarea>
                <button class="btn send-btn" type="submit"><?php echo $this->lang->line('send'); ?></button>
            <?= form_close() ?>
        </div>
    </div>
<?php endif; ?>
