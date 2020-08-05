<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php echo $handy_box; ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-article" data-toggle="tab"><?php echo $tab_article; ?></a></li>
                        <li><a href="#tab-author" data-toggle="tab"><?php echo $tab_author; ?></a></li>
                        <li><a href="#tab-comment" data-toggle="tab"><?php echo $tab_comment; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active in" id="tab-general">
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-gallery-image-size"><?php echo $entry_gallery_image_size; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="gallery_image_width" value="<?php echo $gallery_image_width; ?>" id="input-gallery-image-width" class="form-control text-center" style="width: 60px; display: inline-block" />
                                        x
                                    <input type="text" name="gallery_image_height" value="<?php echo $gallery_image_height; ?>" id="input-gallery-image-height" class="form-control text-center" style="width: 60px; display: inline-block" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-gallery-youtube-size"><?php echo $entry_gallery_youtube_size; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="gallery_youtube_width" value="<?php echo $gallery_youtube_width; ?>" id="input-gallery-youtube-width" class="form-control text-center" style="width: 60px; display: inline-block" />
                                        x
                                    <input type="text" name="gallery_youtube_height" value="<?php echo $gallery_youtube_height; ?>" id="input-gallery-youtube-height" class="form-control text-center" style="width: 60px; display: inline-block" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-gallery-soundcloud-size"><?php echo $entry_gallery_soundcloud_size; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="gallery_soundcloud_width" value="<?php echo $gallery_soundcloud_width; ?>" id="input-gallery-soundcloud-width" class="form-control text-center" style="width: 60px; display: inline-block" />
                                        x
                                    <input type="text" name="gallery_soundcloud_height" value="<?php echo $gallery_soundcloud_height; ?>" id="input-gallery-soundcloud-height" class="form-control text-center" style="width: 60px; display: inline-block" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-page-limit"><?php echo $entry_article_page_limit; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="article_page_limit" value="<?php echo $article_page_limit; ?>" placeholder="<?php echo $entry_article_page_limit; ?>" id="input-article-page-limit" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-pagination-type"><?php echo $entry_pagination_type; ?></label>
                                <div class="col-sm-10">
                                    <select name="pagination_type" id="input-article-list-gallery-display" class="form-control">
                                        <option value="STANDARD" <?php echo ($pagination_type == 'STANDARD' ? 'selected="selected"' : '') ?>><?php echo $text_standard; ?></option>
                                        <option value="AJAX" <?php echo ($pagination_type == 'AJAX' ? 'selected="selected"' : '') ?>><?php echo $text_ajax; ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-article">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-list-template"><?php echo $entry_article_list_template; ?></label>
                                <div class="col-sm-10">
                                    <div class="module-layouts">
                                        <?php
                                        foreach ($templates as $template) {
                                            if (isset($article_list_templates[$template])) {
                                                $i = 0;
                                                echo '<div class="module-layout-title">' . $template . '</div>';
                                                foreach ($article_list_templates[$template] as $file_template) {
                                                    ?>
                                                    <div class="module-layout clearfix">
                                                        <input type="radio" name="article_list_template" value="<?php echo $file_template; ?>" <?php if ($article_list_template == $file_template) echo 'checked="checked"'; ?> class="input-article-list-template">
                                                        <p><?php echo $file_template; ?></p>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-detail-template"><?php echo $entry_article_detail_template; ?></label>
                                <div class="col-sm-10">
                                    <div class="module-layouts">
                                        <?php
                                        foreach ($templates as $template) {
                                            if (isset($article_detail_templates[$template])) {
                                                $i = 0;
                                                echo '<div class="module-layout-title">' . $template . '</div>';
                                                foreach ($article_detail_templates[$template] as $file_template) {
                                                    ?>
                                                    <div class="module-layout clearfix">
                                                        <input type="radio" name="article_detail_template" value="<?php echo $file_template; ?>" <?php if ($article_detail_template == $file_template) echo 'checked="checked"'; ?> class="input-article-detail-templates">
                                                        <p><?php echo $file_template; ?></p>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-product-related"><?php echo $entry_product_related; ?></label>
                                <div class="col-sm-10">
                                    <select name="product_related_status" id="input-product-related" class="form-control">
                                        <?php if ($product_related_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-product-scroll-related"><?php echo $entry_product_scroll_related; ?></label>
                                <div class="col-sm-10">
                                    <select name="product_scroll_related" id="input-product-scroll-related" class="form-control">
                                        <?php if ($product_scroll_related) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-product-per-row"><?php echo $entry_product_related_per_row; ?></label>
                                <div class="col-sm-10">
                                    <select name="product_related_per_row" id="input-product-per-row" class="form-control">
                                        <option value="3" <?php echo ($product_related_per_row == 3 ? 'selected="selected"' : '') ?>>3</option>
                                        <option value="4" <?php echo ($product_related_per_row == 4 ? 'selected="selected"' : '') ?>>4</option>
                                        <option value="5" <?php echo ($product_related_per_row == 5 ? 'selected="selected"' : '') ?>>5</option>
                                        <option value="6" <?php echo ($product_related_per_row == 6 ? 'selected="selected"' : '') ?>>6</option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-related"><?php echo $entry_article_related; ?></label>
                                <div class="col-sm-10">
                                    <select name="article_related_status" id="input-article-related" class="form-control">
                                        <?php if ($article_related_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-scroll-related"><?php echo $entry_article_scroll_related; ?></label>
                                <div class="col-sm-10">
                                    <select name="article_scroll_related" id="input-article-scroll-related" class="form-control">
                                        <?php if ($article_scroll_related) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-per-row"><?php echo $entry_article_related_per_row; ?></label>
                                <div class="col-sm-10">
                                    <select name="article_related_per_row" id="input-article-per-row" class="form-control">
                                        <option value="3" <?php echo ($article_related_per_row == 3 ? 'selected="selected"' : '') ?>>3</option>
                                        <option value="4" <?php echo ($article_related_per_row == 4 ? 'selected="selected"' : '') ?>>4</option>
                                        <option value="5" <?php echo ($article_related_per_row == 5 ? 'selected="selected"' : '') ?>>5</option>
                                        <option value="6" <?php echo ($article_related_per_row == 6 ? 'selected="selected"' : '') ?>>6</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-related-template"><?php echo $entry_article_related_template; ?></label>
                                <div class="col-sm-10">
                                    <div class="module-layouts">
                                        <?php
                                        foreach ($templates as $template) {
                                            if (isset($article_related_templates[$template])) {
                                                $i = 0;
                                                echo '<div class="module-layout-title">' . $template . '</div>';
                                                foreach ($article_related_templates[$template] as $file_template) {
                                                    ?>
                                                    <div class="module-layout clearfix">
                                                        <input type="radio" name="article_related_template" value="<?php echo $file_template; ?>" <?php if ($article_related_template == $file_template) echo 'checked="checked"'; ?> class="input-article-related-templates">
                                                        <p><?php echo $file_template; ?></p>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-gallery-related-article-size"><?php echo $entry_gallery_related_article_size; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="gallery_related_article_width" value="<?php echo $gallery_related_article_width; ?>" id="input-gallery-related-article-width" class="form-control text-center" style="width: 60px; display: inline-block" />
                                        x
                                    <input type="text" name="gallery_related_article_height" value="<?php echo $gallery_related_article_height; ?>" id="input-gallery-related-article-height" class="form-control text-center" style="width: 60px; display: inline-block" />
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="tab-pane fade" id="tab-author">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-author-description"><?php echo $entry_author_description; ?></label>
                                <div class="col-sm-10">
                                    <select name="author_description" id="input-author-description" class="form-control">
                                        <?php if ($author_description) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="tab-pane fade" id="tab-comment">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-comments-engine"><?php echo $entry_comments_engine; ?></label>
                                <div class="col-sm-10">
                                    <select name="comments_engine" id="input-comments-engine" class="form-control">
                                        <option value="LOCAL" <?php echo ($comments_engine == 'LOCAL' ? 'selected="selected"' : '') ?>><?php echo $text_local; ?></option>
                                        <option value="DISQUS" <?php echo ($comments_engine == 'DISQUS' ? 'selected="selected"' : '') ?>><?php echo $text_disqus; ?></option>
                                        <option value="FACEBOOK" <?php echo ($comments_engine == 'FACEBOOK' ? 'selected="selected"' : '') ?>><?php echo $text_facebook; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-facebook-id"><span data-toggle="tooltip" title="<?php echo $help_facebook_id; ?>"><?php echo $entry_facebook_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="facebook_id" value="<?php echo $facebook_id; ?>" placeholder="<?php echo $entry_facebook_id; ?>" id="input-facebook-id" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-disqus-name"><?php echo $entry_disqus_name ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="disqus_name" value="<?php echo $disqus_name ?>" placeholder="<?php echo $entry_disqus_name; ?>" id="input-disqus-name" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-comments-approval"><?php echo $entry_comments_approval; ?></label>
                                <div class="col-sm-10">
                                    <select name="comments_approval" id="input-comments-approval" class="form-control">
                                        <?php if ($comments_approval) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
</div>

<?php echo $footer; ?>