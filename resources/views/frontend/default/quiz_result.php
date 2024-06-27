<link href="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" />
<style>
    .rtl .card-body{
        direction: rtl !important;
        text-align: right !important;
    }
    html{
        height: 100%;
    }
    body{
        display: flex;
        flex-direction: column;
        min-height: 100%;
        max-width: 100%;
        /*overflow: hidden;*/
        overflow-x: hidden;
    }
    .footer-area{
        margin-top: auto;
    }
    .dataTable{
        width: 100% !important;
    }
    .dataTable td{
        width: 100% !important;
    }
    .rtl .dataTable{
       text-align: right;
    }
    .dataTables_wrapper .row{
        direction: ltr;
        margin: 5px 0 5px 0;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card text-white bg-quiz-result-info mb-3">
            <div class="card-body" style="color: #000">
                <h5 class="card-title"><?php echo $this->lang->line('exam_result'); ?>.</h5>
                <?php if ($general_quiz_data->total_time == NULL) { ?>
                    <strong class="text-danger"><?= $this->lang->line('you_didnt_submit_the_quiz') ?></strong>
                <?php } else { ?>
                    <p class="card-text"><?php echo $this->lang->line('you_got') . ' <strong class="text-danger">' . $general_quiz_data->total_points . '</strong> ' . $this->lang->line('out_of_degree') . ' <strong class="text-danger">' . $general_quiz_data->total_question . '</strong> ' . $this->lang->line('correct'); ?> .</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
//foreach ($quiz_answered_questions as $each):
//$question_details = $this->crud_model->get_quiz_question_by_id($each->question_id'])->row_array();
//if($each->qu_type == 0) {
//    $options = $this->db->get_where('answer_list', array('question_id' => $each->id, 'correct_answer' => 1))->row_array();
//}
//    $correct_answers = json_decode($each->correct_answers']);
//  $submitted_answers = $this->crud_model->get_question_answer($each->id);
//    $correct = 0;
//    if ($each->qu_type == 0) {
//        $correct = $each->correct_answer == 1;
//    } else {
//        $correct = $each->answer_status == 1;
//    }
?>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card text-left card-with-no-color-no-border">
            <table class="table table-striped" id="dataTables">
                <thead>
                    <tr>
                        <th style="display:none"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <!-- <div class="card-body">
                <h6 class="card-title"><img src="<?php //echo $correct == 1 ? base_url('assets/frontend/default/img/green-tick.png') : base_url('assets/frontend/default/img/red-cross.png');     ?>" alt="" height="15px;"> <?php //echo $each->name;     ?></h6>
            <?php //for ($i = 0; $i < count($options); $i++):  ?>
                <p class="card-text"> -
            <?php //echo $each->qu_type == 0 ? $each->correct_answer_txt : '---'; ?>
                    <img src="<?php //echo base_url('assets/frontend/default/img/green-circle-tick.png');     ?>" alt="" height="15px;">
                </p>
            <?php //endfor;  ?>
                <p class="card-text"> <strong><?php //echo $this->lang->line("submitted_answers");     ?>: </strong> [
            <?php
//                        if ($each->qu_type == 0) {
//                            echo ($each->answer) ? $each->answer : $this->lang->line('no_answer');
//                        } else if ($each->qu_type == 1 || $each->qu_type == 2) {
//                            echo ($each->answers_id) ? $each->answers_id : $this->lang->line('no_answer');
//                        } else if ($each->qu_type == 3) {
//                            echo '<a style="color:blue" href="' . base_url('uploads/answers/' . $each->answers_id) . '" download>' . $each->answers_id . '</a>';
//                        }
            ?>
                    ]</p>
            </div> -->
        </div>
    </div>
</div>
<?php // endforeach;  ?>

<script src="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTables').DataTable({
            //responsive: true,
            scrollX: true,
            // Processing indicator
            "processing": true,
            // DataTables server-side processing mode
            "serverSide": true,
            // Initial no order.
            "order": [],
            "ordering": false,
            "pageLength": 10,
            "bFilter": false,
            // Load data from an Ajax source
            "ajax": {
                "url": "<?= base_url() ?>home/getQuizResult/<?= $general_quiz_data->detail_id ?>",
                                "type": "POST",
                                data: {'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'}
                            },
                            // Pagination settings
                            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\
           <'row'<'col-sm-12'tr>>\
           <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                            "buttons": [
                                {
                                    "extend": 'excel',
                                    "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>Excel',
                                    "titleAttr": 'Excel',
                                    "action": newexportaction
                                },
                                {
                                    "extend": 'pdf',
                                    "text": '<i class="fa fa-file-pdf-o" style="color: green;"></i>PDF',
                                    "titleAttr": 'Pdf',
                                    "action": newexportaction
                                },
                                {
                                    "extend": 'csv',
                                    "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>CSV',
                                    "titleAttr": 'CSV',
                                    "action": newexportaction
                                },
                                {
                                    "extend": 'print',
                                    "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>Print',
                                    "titleAttr": 'print',
                                    "action": newexportaction
                                },
                            ],

                        });
                    });

                    function newexportaction(e, dt, button, config) {
                        var self = this;
                        var oldStart = dt.settings()[0]._iDisplayStart;
                        dt.one('preXhr', function (e, s, data) {
                            // Just this once, load all data from the server...
                            data.start = 0;
                            data.length = 2147483647;
                            dt.one('preDraw', function (e, settings) {
                                // Call the original action function
                                if (button[0].className.indexOf('buttons-copy') >= 0) {
                                    $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                                } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                                    $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                                } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                                    $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                                } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                                    $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                                } else if (button[0].className.indexOf('buttons-print') >= 0) {
                                    $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                                }
                                dt.one('preXhr', function (e, s, data) {
                                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                    // Set the property to what it was before exporting.
                                    settings._iDisplayStart = oldStart;
                                    data.start = oldStart;
                                });
                                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                                setTimeout(dt.ajax.reload, 0);
                                // Prevent rendering of the full data to the DOM
                                return false;
                            });
                        });
                        // Requery the server with the new one-time export settings
                        dt.ajax.reload();
                    }
</script>

