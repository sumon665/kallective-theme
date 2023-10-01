<?php
/*
Template Name: Careers
*/
get_header();
function career_filtered($row){
    if(isset($_GET['title']) && $_GET['title'] && $_GET['title'] != $row['title']) return false;
    if(isset($_GET['department']) && $_GET['department'] && $_GET['department'] != $row['department']) return false;
    if(isset($_GET['location']) && $_GET['location'] && $_GET['location'] != $row['location']) return false;
    return true;
}
?>
<div class="wrapper">
    <div class="breadcrumbs-section">
        <?php woocommerce_breadcrumb([
            'wrap_before' => '<ul class="breadcrumbs">',
            'before' => '<li class="breadcrumbs__item">',
            'wrap_after' => '</ul>',
            'after' => '</li>',
            'delimiter' => ''
        ]); ?>
    </div>
    <div class="career-section">
        <h1 class="career-top"><?php echo __('Explore the Careers', 'kallective');?></h1>
        <?php if( have_rows('careers') ): ?>
        <div class="career-layout">
            <?php $filters = [
                'titles' => [],
                'deps' => [],
                'locs' => []
            ]; ?>
            <div class="career-layout__list">
                <ul class="career-list">
                <?php 
                while( have_rows('careers') ): the_row(); 
                $row = get_row(true); 
                $filters['titles'][] = $row['title']; 
                $filters['deps'][] = $row['department']; 
                $filters['locs'][] = $row['location']; 
                if(!career_filtered($row)) continue;
                ?>
                <li class="career-list-item">
                    <h2 class="career-list-item__title"><?php echo $row['title']; ?></h2>
                    <p class="career-list-item__desc">
                    <?php if($row['department']) echo "{$row['department']} - "; ?><?php if($row['location']) echo "{$row['location']} - "; ?><?php echo $row['price']; ?></p>
                    <div>
                    <a href="javascript:;" class="btn-primary career-list-item__btn applyVacancy" data-title="<?php echo $row['title']; ?>"><?php echo __('Apply', 'kallective');?></a>
                    </div>
                </li>
                <?php endwhile; ?>
                </ul>
            </div>
            <?php $filters = array_map(function($item){return array_unique($item);},$filters); ?>
            <div class="career-layout__filters">
                <form class="career-filters" action="">
                    <input type="hidden" name="action" value="filter">
                    <div class="career-filters__header visible-desktop"><?php echo __('Filter By', 'kallective');?></div>
                    <span class="career-filters-toggle hidden-desktop"><?php echo esc_html__('<span>Show</span> filters', 'kallective');?></span>
                    <div class="career-filters__body">
                        <div class="career-filters-row-tablet">
                        <div class="career-filters-row">
                            <?php if(count($filters['titles'])):?>
                            <div class="control-select">
                            <div class="control-label"><?php echo __('Job Title', 'kallective');?></div>
                            <select data-placeholder="Choose Job Title" name="title">
                                <option></option>
                                <?php foreach($filters['titles'] as $title): ?>
                                <option value="<?php echo $title; ?>" <?php if(isset($_GET['title']) && $_GET['title'] == $title) echo "selected"; ?>><?php echo $title; ?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="career-filters-row">
                            <?php if(count($filters['locs'])):?>
                            <div class="control-select">
                            <div class="control-label"><?php echo __('Location', 'kallective');?></div>
                            <select data-placeholder="Choose Location" name="location">
                                <option></option>
                                <?php foreach($filters['locs'] as $location): ?>
                                <option value="<?php echo $location; ?>" <?php if(isset($_GET['location']) && $_GET['location'] == $location) echo "selected"; ?>><?php echo $location; ?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        </div>
                        <div class="career-filters-row">
                        <?php if(count($filters['deps'])):?>
                            <div class="control-select">
                            <div class="control-label"><?php echo __('Department', 'kallective');?></div>
                            <select data-placeholder="<?php echo __('Choose Department', 'kallective');?>" name="department">
                                <option></option>
                                <?php foreach($filters['deps'] as $department): ?>
                                <option value="<?php echo $department; ?>" <?php if(isset($_GET['department']) && $_GET['department'] == $department) echo "selected"; ?> ><?php echo $department; ?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div>
                        <button class="btn-secondary-outline career-filters-apply"><?php echo __('Show results', 'kallective');?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php else : ?>
        <p class="career-section__empty"><?php echo __('We don\'t currently have any open positions. Feel free to reach out to us to introduce yourself in the meantime.', 'kallective');?>
		</p>
        <?php endif; ?>
    </div>
    <div class="career-contact-section">
        <div class="contact-form-section">
        <h3 class="contact-form-section__title"><?php echo __('Contact us', 'kallective');?></h3>
        <p class="contact-form-section__txt"><?php echo __('If you have any questions about any of our positions, please reach out to us.', 'kallective');?></p>
        <?php echo do_shortcode('[contact-form-7 id="5" title="Contact form"]');?>
        </div>
    </div>
</div>
<?php
get_footer();