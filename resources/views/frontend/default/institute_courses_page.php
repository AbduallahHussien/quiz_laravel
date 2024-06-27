<?php
isset($layout) ? "" : $layout = "list";
isset($selected_category_id) ? "" : $selected_category_id = "all";
isset($selected_level) ? "" : $selected_level = "all";
isset($selected_language) ? "" : $selected_language = "all";
isset($selected_rating) ? "" : $selected_rating = "all";
isset($selected_price) ? "" : $selected_price = "all";
// echo $selected_category_id.'-'.$selected_level.'-'.$selected_language.'-'.$selected_rating.'-'.$selected_price;
$number_of_visible_categories = 10;
if (isset($sub_category_id)) {
    $sub_category_details = $this->crud_model->get_category_details_by_id($sub_category_id)->row_array();
    $category_details = $this->crud_model->get_categories($sub_category_details['parent'])->row_array();
    $category_name = $category_details['name'];
    $sub_category_name = $sub_category_details['name'];
}
?>
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/institute_courses.css' ?>">

<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <?php if (!(isset($semester_id) && $semester_id)) { ?>
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <?php echo $this->lang->line('courses'); ?>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('home/institute') ?>">
                                    <?php echo $this->lang->line('institute'); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="breadcrumb-item active">
                            <?php
                            if (isset($semester_id) && $semester_id) {
                                $semester = $this->db->get_where('semesters', array('id' => $semester_id))->row();
                                if ($semester) {
                                    echo $semester->title;
                                }
                            } else {
                                if ($selected_category_id == "all") {
                                    echo $this->lang->line('all_category');
                                } else {
                                    $category_details = $this->crud_model->get_category_details_by_id($selected_category_id)->row_array();
                                    echo $category_details['title'];
                                }
                            }
                            ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<section class="category-course-list-area">
    <div class="container">
        <!--        <div class="category-filter-box filter-box clearfix">
                    <span><?php //echo $this->lang->line('showing_on_this_page');           ?> : <?php //echo count($courses);           ?></span>
                    <a href="javascript::" onclick="toggleLayout('grid')" style=" font-size: 19px; margin-left: 5px;" class="layout_style"><i class="fas fa-th"></i></a>
                    <a href="javascript::" onclick="toggleLayout('list')" style=" font-size: 19px;" class="layout_style"><i class="fas fa-th-list"></i></a>
                    <a href="<?php //echo site_url('home/courses');           ?>" style=" font-size: 19px; margin-right: 5px;" class="layout_style"><i class="fas fa-sync-alt"></i></a>
                </div>-->
        <span class="section-wrapper__title  inProgress mt-5"><div class="section-wrapper__title-line"></div><i class="section-wrapper__title-icon ic ic-edraak primary-base"></i><span><?= $this->lang->line('courses') ?></span><div class="section-wrapper__title-line"></div></span>
        <div class="row mt-5 inner_container">

            <div class="col-lg-12">
                <div class="category-course-list">
                    <?php //include 'category_wise_course_' . $layout . '_layout.php'; ?>
                    <?php include 'institute_courses_body.php'; ?>
                    <?php if (count($courses) == 0): ?>
                        <?php echo $this->lang->line('no_result_found'); ?>
                    <?php endif; ?>
                </div>
                <nav>
                    <?php
                    if ($selected_category_id == "all" && $selected_price == 0 && $selected_level == 'all' && $selected_language == 'all' && $selected_rating == 'all') {
                        echo $this->pagination->create_links();
                    }
                    ?>
                </nav>
            </div>
        </div>
        <?php
        if (is_purchased($semester_id, 1)) {
            if ($semester_pass_percent >= $semester->min_percentage && $semester->certificate) {  // i added this to not show danger sign if i not pass the semester (show success div only)
                ?>
                <span class="section-wrapper__title  inProgress mt-5"><div class="section-wrapper__title-line"></div><i class="section-wrapper__title-icon ic ic-edraak"></i><span><?= $this->lang->line('certificate') ?></span><div class="section-wrapper__title-line"></div></span>
                <div class="certificate-btn-wrapper disabled <?= $semester_pass_percent >= $semester->min_percentage ? '' : 'bg-danger' ?>" id="certificates-section">
                    <h5 class="cert_title"><?= $this->lang->line('generate_certificate') ?></h5><span class="certificate-body"><?= $this->lang->line('passed_courses') ?> <?= $semester_pass_percent ?> <?= $this->lang->line('min_degree_to_pass') ?> <?= $semester->min_percentage ?></span>
                    <?php //if ($semester_pass_percent >= $semester->min_percentage) { ?>
                        <hr/>
                        <span><?= $this->lang->line('congratulations_u_passed') ?></span>
                        <br/>
                        <a href="<?php echo base_url(); ?>quiz/download_certificate/0/0/<?php echo base64_encode($semester->id); ?>" class="mt-3 btn btn-success btn-icon btn-sm mr--40" title="<?php echo $this->lang->line('download_certificate') ?> "><i class="fa fa-download" aria-hidden="true"></i></a>
                        <?php //} ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<script type="text/javascript">

    function get_url() {
        var urlPrefix = '<?php echo site_url('home/courses?'); ?>'
        var urlSuffix = "";
        var slectedCategory = "";
        var selectedPrice = "";
        var selectedLevel = "";
        var selectedLanguage = "";
        var selectedRating = "";

        // Get selected category
        $('.categories:checked').each(function () {
            slectedCategory = $(this).attr('value');
        });

        // Get selected price
        $('.prices:checked').each(function () {
            selectedPrice = $(this).attr('value');
        });

        // Get selected difficulty Level
        $('.level:checked').each(function () {
            selectedLevel = $(this).attr('value');
        });

        // Get selected difficulty Level
        $('.languages:checked').each(function () {
            selectedLanguage = $(this).attr('value');
        });

        // Get selected rating
        $('.ratings:checked').each(function () {
            selectedRating = $(this).attr('value');
        });

        urlSuffix = "category=" + slectedCategory + "&&price=" + selectedPrice + "&&level=" + selectedLevel + "&&language=" + selectedLanguage + "&&rating=" + selectedRating;
        var url = urlPrefix + urlSuffix;
        return url;
    }
    function filter() {
        var url = get_url();
        window.location.replace(url);
        //console.log(url);
    }

    function toggleLayout(layout) {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('home/set_layout_to_session'); ?>',
            data: {layout: layout,'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response) {
                location.reload();
            }
        });
    }

    function showToggle(elem, selector) {
        $('.' + selector).slideToggle(20);
        if ($(elem).text() === "<?php echo $this->lang->line('show_more'); ?>")
        {
            $(elem).text('<?php echo $this->lang->line('show_less'); ?>');
        } else
        {
            $(elem).text('<?php echo $this->lang->line('show_more'); ?>');
        }
    }
</script>
