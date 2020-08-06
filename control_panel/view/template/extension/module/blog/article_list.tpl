<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-article').submit() : false;"><i class="fa fa-trash-o"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                </li>
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
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="form-group">
                                <label class="control-label" for="input-title"><?php echo $entry_title; ?></label>
                                <input type="text" name="filter_title" value="<?php echo $filter_title; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" id="button-filter" style="margin-top: 23px" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                        </div>
                    </div>
                </div>
                
                
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-article">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                    <td class="text-left"><?php if ($sort == 'name') { ?>
                                        <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right"><?php if ($sort == 'date_published') { ?>
                                        <a href="<?php echo $sort_date_published; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_published; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_date_published; ?>"><?php echo $column_date_published; ?></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right"><?php echo $column_comments; ?></td>
                                    <td class="text-right"><?php if ($sort == 'author') { ?>
                                        <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-right"><?php echo $column_action; ?></td>
                                </tr>
                            </thead>
                          <tbody>
                            <?php if ($articles) { ?>
                            <?php foreach ($articles as $article) { ?>
                            <tr>
                              <td class="text-center"><?php if (in_array($article['article_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $article['article_id']; ?>" />
                                <?php } ?></td>
                              <td class="text-left"><?php echo $article['title']; ?></td>
                              <td class="text-right"><?php echo $article['date_published']; ?></td>
                              <td class="text-right"><?php echo $article['comments']; ?></td>
                              <td class="text-right"><?php echo $article['author']; ?></td>
                              <td class="text-right"><a href="<?php echo $article['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                    <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $(function(){

        $('input[name=\'filter_title\']').keyup(function(e){
             if(e.keyCode == 13)
             {
                 $('#button-filter').trigger("click");
             }
        });

        $('#button-filter').click(function() {
            var url = 'index.php?route=extension/module/blog/article_list&user_token=<?php echo $user_token; ?>';

            var filter_title = $('input[name=\'filter_title\']').val();

            if (filter_title) {
                url += '&filter_title=' + encodeURIComponent(filter_title);
            }

            location = url;
        });  
    })
//--></script>
<?php echo $footer; ?>