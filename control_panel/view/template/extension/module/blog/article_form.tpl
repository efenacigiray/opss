<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-article" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        
        <?php echo $handy_box; ?>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-article" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
                        <li><a href="#tab-customization" data-toggle="tab"><?php echo $tab_customization; ?></a></li>
                        <li><a href="#tab-related" data-toggle="tab"><?php echo $tab_related; ?></a></li>
                        <li><a href="#tab-gallery" data-toggle="tab"><?php echo $tab_gallery; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active in" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['title']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="article_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_title[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                        <div class="col-sm-10">
                                          <textarea name="article_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-content<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                                        <div class="col-sm-10">
                                          <textarea name="article_description[<?php echo $language['language_id']; ?>][content]" placeholder="<?php echo $entry_content; ?>" id="input-content<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['content'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tags<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tags; ?>"><?php echo $entry_tags; ?></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="article_description[<?php echo $language['language_id']; ?>][tags]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['tags'] : ''; ?>" placeholder="<?php echo $entry_tags; ?>" id="input-tags<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_tags[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_tags[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="article_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                                            <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                            <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="article_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                        <div class="col-sm-10">
                                            <textarea name="article_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-settings">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                                    <div id="article-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($article_categories as $article_category) { ?>
                                            <div id="article-category<?php echo $article_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article_category['name']; ?>
                                                <input type="hidden" name="article_category[]" value="<?php echo $article_category['category_id']; ?>" />
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                                <div class="col-sm-10">
                                    <div class="well well-sm" style="height: 150px; overflow: auto;">
                                        <div class="checkbox">
                                            <label>
                                                <?php if (in_array(0, $article_store)) { ?>
                                                    <input type="checkbox" name="article_store[]" value="0" checked="checked" />
                                                    <?php echo $text_default; ?>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="article_store[]" value="0" />
                                                    <?php echo $text_default; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <?php foreach ($stores as $store) { ?>
                                            <div class="checkbox">
                                                <label>
                                                    <?php if (in_array($store['store_id'], $article_store)) { ?>
                                                        <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                                        <?php echo $store['name']; ?>
                                                    <?php } else { ?>
                                                        <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" />
                                                        <?php echo $store['name']; ?>
                                                    <?php } ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
                                <div class="col-sm-10">
                                    <select name="author_id" id="input-author-id" class="form-control">
                                        <option value="0"><?php echo $text_no_selected ?></option>
                                        <?php if ($authors) { ?>
                                        <?php foreach($authors as $author):?>
                                        <option value="<?php echo $author['author_id'] ?>" <?php echo ($author_id == $author['author_id'] ? 'selected="selected"' : '') ?>><?php echo $author['name']; ?></option>
                                        <?php endforeach ?>    
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_thumbnail; ?>"><?php echo $entry_thumbnail; ?></span></label>
                                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                                    <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                </div>
                            </div>
                            <div class="form-group">  
                                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                                    <?php if ($error_keyword) { ?>
                                    <div class="text-danger"><?php echo $error_keyword; ?></div>
                                    <?php } ?>                
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
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
                                <label class="col-sm-2 control-label" for="input-status-comments"><?php echo $entry_allow_comments; ?></label>
                                <div class="col-sm-10">
                                    <select name="status_comments" id="input-status-comments" class="form-control">
                                        <?php if ($status_comments) { ?>
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
                        <div class="tab-pane fade" id="tab-customization">

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                                <div class="col-sm-3">
                                    <div class="input-group datetime">
                                        <input type="text" name="date_added" value="<?php echo $date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD HH:MM:ss" id="input-date-added" class="form-control" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-date-updated"><?php echo $entry_date_updated; ?></label>
                                <div class="col-sm-3">
                                    <div class="input-group datetime">
                                        <input type="text" name="date_updated" value="<?php echo $date_updated; ?>" placeholder="<?php echo $entry_date_updated; ?>" data-date-format="YYYY-MM-DD HH:MM:ss" id="input-date-updated" class="form-control" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-date-published"><?php echo $entry_date_published; ?></label>
                                <div class="col-sm-3">
                                    <div class="input-group datetime">
                                        <input type="text" name="date_published" value="<?php echo $date_published; ?>" placeholder="<?php echo $entry_date_published; ?>" data-date-format="YYYY-MM-DD HH:MM:ss" id="input-date-published" class="form-control" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span></div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="tab-pane" id="tab-related">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-related-product"><span data-toggle="tooltip" title="<?php echo $help_related_products; ?>"><?php echo $entry_related_products; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="related_products" value="" placeholder="<?php echo $entry_related_products; ?>" id="input-related" class="form-control" />
                                    <div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($product_relateds as $product_related) { ?>
                                            <div id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_related['name']; ?>
                                                <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-related-article"><span data-toggle="tooltip" title="<?php echo $help_related_articles; ?>"><?php echo $entry_related_articles; ?></span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="related_articles" value="" placeholder="<?php echo $entry_related_articles; ?>" id="input-related" class="form-control" />
                                    <div id="article-related" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($article_relateds as $article_related) { ?>
                                            <div id="product-related<?php echo $article_related['article_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article_related['title']; ?>
                                                <input type="hidden" name="article_related[]" value="<?php echo $article_related['article_id']; ?>" />
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tab-gallery">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-article-list-gallery-display"><?php echo $entry_article_list_gallery_display; ?></label>
                                <div class="col-sm-10">
                                    <select name="article_list_gallery_display" id="input-article-list-gallery-display" class="form-control">
                                        <option value="CLASSIC" <?php echo ($article_list_gallery_display == 'CLASSIC' ? 'selected="selected"' : '') ?>><?php echo $text_classic; ?></option>
                                        <option value="SLIDER" <?php echo ($article_list_gallery_display == 'SLIDER' ? 'selected="selected"' : '') ?>><?php echo $text_slider; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="images" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-left"><?php echo $entry_image; ?> / <?php echo $entry_link ?></td>
                                            <td class="text-center" style="width: 100px"><?php echo $entry_width; ?></td>
                                            <td class="text-center" style="width: 100px"><?php echo $entry_height; ?></td>
                                            <td class="text-center" ><?php echo $entry_sort_order; ?></td>
                                            <td class="text-center"><?php echo $entry_type; ?></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $gallery_row = 0; ?>
                                        <?php foreach ($article_galleries as $article_gallery) { ?>
                                            <tr id="gallery-row<?php echo $gallery_row; ?>">
                                                <?php if($article_gallery['type'] == 'IMG'): ?>
                                                <td class="text-left"><a href="" id="thumb-image<?php echo $gallery_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $article_gallery['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="article_gallery[<?php echo $gallery_row; ?>][path]" value="<?php echo $article_gallery['path']; ?>" id="input-image<?php echo $gallery_row; ?>" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][width]" value="<?php echo $article_gallery['width']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][height]" value="<?php echo $article_gallery['height']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>
                                                <td class="text-right"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][sort_order]" value="<?php echo $article_gallery['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="hidden" name="article_gallery[<?php echo $gallery_row; ?>][type]" value="<?php echo $article_gallery['type']; ?>" /><?php echo $entry_image ?></td>
                                                <td class="text-center"><button type="button" onclick="$('#gallery-row<?php echo $gallery_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                <?php elseif($article_gallery['type'] == 'YOUTUBE'): ?>
                                                <td class="text-left"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][path]" value="<?php echo $article_gallery['path']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][width]" value="<?php echo $article_gallery['width']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][height]" value="<?php echo $article_gallery['height']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>
                                                <td class="text-right"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][sort_order]" value="<?php echo $article_gallery['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="hidden" name="article_gallery[<?php echo $gallery_row; ?>][type]" value="<?php echo $article_gallery['type']; ?>" /><?php echo $entry_youtube?></td>
                                                <td class="text-center"><button type="button" onclick="$('#gallery-row<?php echo $gallery_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                <?php elseif($article_gallery['type'] == 'SOUNDCLOUD'): ?>
                                                <td class="text-left"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][path]" value="<?php echo $article_gallery['path']; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][width]" value="<?php echo $article_gallery['width']; ?>" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][height]" value="<?php echo $article_gallery['height']; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>                                             
                                                <td class="text-right"><input type="text" name="article_gallery[<?php echo $gallery_row; ?>][sort_order]" value="<?php echo $article_gallery['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                                                <td class="text-center"><input type="hidden" name="article_gallery[<?php echo $gallery_row; ?>][type]" value="<?php echo $article_gallery['type']; ?>" /><?php echo $entry_soundcloud ?></td>
                                                <td class="text-center"><button type="button" onclick="$('#gallery-row<?php echo $gallery_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                <?php endif;  ?>
                                            </tr>
                                            <?php $gallery_row++; ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5"></td>
                                            <td class="text-left" style="width: 230px">
                                                    <div class="col-sm-10" style="padding: 0">
                                                        <select id="gallery-type" class="form-control">
                                                            <option value="Image"><?php echo $entry_image ?></option>
                                                            <option value="Youtube"><?php echo $entry_youtube ?></option>
                                                            <option value="SoundCloud"><?php echo $entry_soundcloud ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2" style="padding: 0 1px">
                                                        <button type="button" onclick="window['add' + $('#gallery-type').val()]();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <script type="text/javascript"><!--
  <?php foreach ($languages as $language) { ?>
    $('#input-description<?php echo $language['language_id']; ?>').summernote({
    height: 300
    });
    $('#input-content<?php echo $language['language_id']; ?>').summernote({
    height: 400
    });
  <?php } ?>
      
    // Category
    $('input[name=\'category\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=extension/module/blog/category_autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',			
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['category_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'category\']').val('');

            $('#article-category' + item['value']).remove();

            $('#article-category').append('<div id="article-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_category[]" value="' + item['value'] + '" /></div>');	
        }
    });

    $('#article-category').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });

    // Related
    $('input[name=\'related_products\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&user_token=<?php echo $user_token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',			
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['product_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'related_products\']').val('');

            $('#product-related' + item['value']).remove();

            $('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');	
        }	
    });

    $('#product-related').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });
    
    $('input[name=\'related_articles\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=extension/module/blog/article_autocomplete&user_token=<?php echo $user_token; ?>&filter_title=' +  encodeURIComponent(request),
                dataType: 'json',			
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['title'],
                            value: item['article_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'related_articles\']').val('');

            $('#article-related' + item['value']).remove();

            $('#article-related').append('<div id="article-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_related[]" value="' + item['value'] + '" /></div>');	
        }	
    });

    $('#article-related').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });
      
      
  //--></script> 
  
  <script type="text/javascript"><!--
    var gallery_row = <?php echo $gallery_row; ?>;

    function addImage() {
        html  = '<tr id="gallery-row' + gallery_row + '">';
        html += '  <td class="text-left"><a href="" id="thumb-image' + gallery_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="article_gallery[' + gallery_row + '][path]" value="" id="input-image' + gallery_row + '" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][width]" value="" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][height]" value="" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="article_gallery[' + gallery_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="hidden" name="article_gallery[' + gallery_row + '][type]" value="IMG" /><?php echo $entry_image ?></td>';
        html += '  <td class="text-center"><button type="button" onclick="$(\'#gallery-row' + gallery_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#images tbody').append(html);

        gallery_row++;
    }
    function addYoutube() {
        html  = '<tr id="gallery-row' + gallery_row + '">';
        html += '  <td class="text-left"><input type="text" name="article_gallery[' + gallery_row + '][path]" value="" id="input-image' + gallery_row + '" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][width]" value="" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][height]" value="" placeholder="<?php echo $entry_height; ?>" class="form-control col-xs-2" /></td>';
        html += '  <td class="text-right"><input type="text" name="article_gallery[' + gallery_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="hidden" name="article_gallery[' + gallery_row + '][type]" value="YOUTUBE" /><?php echo $entry_youtube ?></td>';
        html += '  <td class="text-center"><button type="button" onclick="$(\'#gallery-row' + gallery_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#images tbody').append(html);

        gallery_row++;
    }
    function addSoundCloud() {
        html  = '<tr id="gallery-row' + gallery_row + '">';
        html += '  <td class="text-left"><input type="text" name="article_gallery[' + gallery_row + '][path]" value="" id="input-image' + gallery_row + '" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][width]" value="" placeholder="<?php echo $entry_width; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="text" name="article_gallery[' + gallery_row + '][height]" value="" placeholder="<?php echo $entry_height; ?>" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="text" name="article_gallery[' + gallery_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
        html += '  <td class="text-center"><input type="hidden" name="article_gallery[' + gallery_row + '][type]" value="SOUNDCLOUD" /><?php echo $entry_soundcloud ?></td>';
        html += '  <td class="text-center"><button type="button" onclick="$(\'#gallery-row' + gallery_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#images tbody').append(html);

        gallery_row++;
    }
//--></script> 
    
    
      <script type="text/javascript"><!--
    $('#language a:first').tab('show');
    //--></script>
      
      <script type="text/javascript"><!--
        $('.datetime').datetimepicker({
            pickDate: true,
            pickTime: true
        });
    //--></script>
</div>
<?php echo $footer; ?>