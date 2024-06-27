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
<style>
    .img-fluid {
        height: 150px;
    }
</style>

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
                                $semester = $this->db->get('semesters', array('id' => $semester_id))->row();
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

        <?php if (!isset($semester_id) || !$semester_id) { ?>
            <ul class="nav nav-tabs nav-justified mt-5 pr-0" id="myTab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link active" id="courses-tab" data-toggle="tab" href="#courses" role="tab" aria-controls="courses" aria-selected="true"><?= $this->lang->line('courses') ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tracks-tab" data-toggle="tab" href="#tracks" role="tab" aria-controls="tracks" aria-selected="false"><?= $this->lang->line('tracks') ?></a>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active px-3" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                    <div class="category-filter-box filter-box clearfix">
                        <span><?php echo $this->lang->line('showing_on_this_page'); ?> : <?php echo count($courses); ?></span>
<!--                        <a href="javascript::" onclick="toggleLayout('grid')" style=" font-size: 19px; margin-left: 5px;" class="layout_style"><i class="fas fa-th"></i></a>
                        <a href="javascript::" onclick="toggleLayout('list')" style=" font-size: 19px;" class="layout_style"><i class="fas fa-th-list"></i></a>
                        <a href="<?php //echo site_url('home/courses'); ?>" style=" font-size: 19px; margin-right: 5px;" class="layout_style"><i class="fas fa-sync-alt"></i></a>-->
                    </div>
                    <div class="row">
                        <div class="col-lg-3 filter-area mb-4">
                            <div class="card">
                                <a href="javascript::"  style="color: unset;">
                                    <div class="card-header filter-card-header" id="headingOne" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                                        <h6 class="mb-0">
                                            <?php echo $this->lang->line('filter'); ?>
                                            <i class="fas fa-sliders-h" style="float: right;"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFilter" class="collapse collapsed" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body pt-0">
                                        <div class="filter_type">
                                            <h6><?php echo $this->lang->line('categories'); ?></h6>
                                            <ul>
                                                <li class="ml-2">
                                                    <div class="">
                                                        <input type="radio" id="category_all" name="sub_category" class="categories custom-radio" value="all" onclick="filter(this)" <?php if ($selected_category_id == 'all') echo 'checked'; ?>>
                                                        <label for="category_all"><?php echo $this->lang->line('all_category'); ?></label>
                                                    </div>
                                                </li>
                                                <?php
                                                $counter = 1;
                                                $total_number_of_categories = $this->db->get('subjects_categories')->num_rows();
                                                $categories = $this->crud_model->get_categories()->result_array();
                                                foreach ($categories as $category):
                                                    ?>
                                                    <li class="">
                                                        <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
                                                            <input type="radio" id="category-<?php echo $category['id']; ?>" name="sub_category" class="categories custom-radio" value="<?php echo $category['title']; ?>" onclick="filter(this)" <?php if ($selected_category_id == $category['id']) echo 'checked'; ?>>
                                                            <label for="category-<?php echo $category['id']; ?>"><?php echo $category['title']; ?></label>
                                                        </div>
                                                    </li>
                                                    <?php
                                                    foreach ($this->crud_model->get_sub_categories($category['id']) as $sub_category):
                                                        $counter++;
                                                        ?>
                                                        <li class="ml-2">
                                                            <div class="<?php if ($counter > $number_of_visible_categories): ?> hidden-categories hidden <?php endif; ?>">
                                                                <input type="radio" id="sub_category-<?php echo $sub_category['id']; ?>" name="sub_category" class="categories custom-radio" value="<?php echo $sub_category['title']; ?>" onclick="filter(this)" <?php if ($selected_category_id == $sub_category['id']) echo 'checked'; ?>>
                                                                <label for="sub_category-<?php echo $sub_category['id']; ?>"><?php echo $sub_category['title']; ?></label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                            <a href="javascript::" id = "city-toggle-btn" onclick="showToggle(this, 'hidden-categories')" style="font-size: 12px;"><?php echo $total_number_of_categories > $number_of_visible_categories ? $this->lang->line('show_more') : ""; ?></a>
                                        </div>
                                        <!--<hr>-->
                                        <!--                            <div class="filter_type">
                                                                        <div class="form-group">
                                                                            <h6><?php //echo $this->lang->line('price');                ?></h6>
                                                                            <ul>
                                                                                <li>
                                                                                    <div class="">
                                                                                        <input type="radio" id="price_all" name="price" class="prices custom-radio" value="all" onclick="filter(this)" <?php //if($selected_price == 'all') echo 'checked';                ?>>
                                                                                        <label for="price_all"><?php //echo $this->lang->line('all');                ?></label>
                                                                                    </div>
                                                                                    <div class="">
                                                                                        <input type="radio" id="price_free" name="price" class="prices custom-radio" value="free" onclick="filter(this)" <?php //if($selected_price == 'free') echo 'checked';                ?>>
                                                                                        <label for="price_free"><?php //echo $this->lang->line('free');                ?></label>
                                                                                    </div>
                                                                                    <div class="">
                                                                                        <input type="radio" id="price_paid" name="price" class="prices custom-radio" value="paid" onclick="filter(this)" <?php //if($selected_price == 'paid') echo 'checked';                ?>>
                                                                                        <label for="price_paid"><?php //echo $this->lang->line('paid');                ?></label>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="filter_type">
                                                                        <h6><?php //echo $this->lang->line('level');                ?></h6>
                                                                        <ul>
                                                                            <li>
                                                                                <div class="">
                                                                                    <input type="radio" id="all" name="level" class="level custom-radio" value="all" onclick="filter(this)" <?php //if($selected_level == 'all') echo 'checked';                ?>>
                                                                                    <label for="all"><?php //echo $this->lang->line('all');                ?></label>
                                                                                </div>
                                                                                <div class="">
                                                                                    <input type="radio" id="beginner" name="level" class="level custom-radio" value="beginner" onclick="filter(this)" <?php //if($selected_level == 'beginner') echo 'checked';                ?>>
                                                                                    <label for="beginner"><?php //echo $this->lang->line('beginner');                ?></label>
                                                                                </div>
                                                                                <div class="">
                                                                                    <input type="radio" id="advanced" name="level" class="level custom-radio" value="advanced" onclick="filter(this)" <?php //if($selected_level == 'advanced') echo 'checked';                ?>>
                                                                                    <label for="advanced"><?php //echo $this->lang->line('advanced');                ?></label>
                                                                                </div>
                                                                                <div class="">
                                                                                    <input type="radio" id="intermediate" name="level" class="level custom-radio" value="intermediate" onclick="filter(this)" <?php //if($selected_level == 'intermediate') echo 'checked';                ?>>
                                                                                    <label for="intermediate"><?php //echo $this->lang->line('intermediate');                ?></label>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="filter_type">
                                                                        <h6><?php //echo $this->lang->line('language');                ?></h6>
                                                                        <ul>
                                                                            <li>
                                                                                <div class="">
                                                                                    <input type="radio" id="all_language" name="language" class="languages custom-radio" value="<?php //echo 'all';                ?>" onclick="filter(this)" <?php //if($selected_language == "all") echo 'checked';                ?>>
                                                                                    <label for="<?php //echo 'all_language';                ?>"><?php //echo $this->lang->line('all');                ?></label>
                                                                                </div>
                                                                            </li>
                                        <?php
//                                    $languages = $this->crud_model->get_all_languages();
//                                    foreach ($languages as $language): 
                                        ?>
                                                                                <li>
                                                                                    <div class="">
                                                                                        <input type="radio" id="language_<?php //echo $language;                ?>" name="language" class="languages custom-radio" value="<?php //echo $language;                ?>" onclick="filter(this)" <?php //if($selected_language == $language) echo 'checked';                ?>>
                                                                                        <label for="language_<?php //echo $language;               ?>"><?php //echo ucfirst($language);               ?></label>
                                                                                    </div>
                                                                                </li>
                                        <?php //endforeach;   ?>
                                                                        </ul>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="filter_type">
                                                                        <h6><?php //echo $this->lang->line('ratings');                ?></h6>
                                                                        <ul>
                                                                            <li>
                                                                                <div class="">
                                                                                    <input type="radio" id="all_rating" name="rating" class="ratings custom-radio" value="<?php //echo 'all';                ?>" onclick="filter(this)" <?php //if($selected_rating == "all") echo 'checked';                ?>>
                                                                                    <label for="all_rating"><?php //echo $this->lang->line('all');               ?></label>
                                                                                </div>
                                                                            </li>
                                        <?php //for($i = 1; $i <= 5; $i++):   ?>
                                                                                <li>
                                                                                    <div class="">
                                                                                        <input type="radio" id="rating_<?php //echo $i;                ?>" name="rating" class="ratings custom-radio" value="<?php //echo $i;                ?>" onclick="filter(this)" <?php //if($selected_rating == $i) echo 'checked';                ?>>
                                                                                        <label for="rating_<?php //echo $i;              ?>">
                                        <?php //for($j = 1; $j <= $i; $j++):  ?>
                                                                                                <i class="fas fa-star" style="color: #f4c150;"></i>
                                        <?php //endfor; ?>
                                        <?php //for($j = $i; $j < 5; $j++):   ?>
                                                                                                <i class="far fa-star" style="color: #dedfe0;"></i>
                                        <?php //endfor;   ?>
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                        <?php //endfor;   ?>
                                                                        </ul>
                                                                    </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="<?= isset($semester_id) && $semester_id && $layout == 'grid' ? 'col-lg-12' : 'col-lg-9' ?>">
                        <div class="category-course-list">
                            <?php include 'category_wise_course_' . $layout . '_layout.php'; ?>
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
                    <?php if (!isset($semester_id) || !$semester_id) { ?>
                    </div>
                </div>
                <div class="tab-pane px-3" id="tracks" role="tabpanel" aria-labelledby="tracks-tab">
                    <?php include 'institute_page.php'; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<script type="text/javascript">

    function get_url() {
        var urlPrefix = '<?php echo site_url('home/courses?'); ?>';
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
            data: {layout: layout, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
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
