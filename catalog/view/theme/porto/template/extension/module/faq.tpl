<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
$s = 1;
include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_top.tpl'); ?>

<div class="row">
    <div class="col-sm-12">
    <?php if(!empty($sections)):?>
        <div class="faq-area">
        <?php $i = 0; ?>
        <?php foreach($sections as $section):?>
            <?php if(!empty($section['items'])):?>
                <div class="faq-section">
                     <?php if(!$section['hidden']):?>
                     <h2 class="section-title"><?php echo $section['title']; ?></h2>
                     <?php $s = 1; ?>
                     <?php endif; ?>
                     
                     <div id="accordion">
                          <?php foreach($section['items'] as $item):?>
                              <?php if(trim($item['question']) == '') continue; ?>
                              <div class="panel panel-faq">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <?php if($settings['collapse']):?>
                                          <a data-toggle="collapse" data-parent="#questions" href="#answer-<?php echo $i; ?>" aria-expanded="false" class="collapsed">
                                              <?php echo  $s . '. ' . $item['question']; ?>
                                          </a>
                                          <?php else:?>
                                          <span><?php echo $s . '. ' . $item['question']; ?></span>
                                          <?php endif; ?>
                                      </h4>
                                  </div>
                                  <div id="answer-<?php echo $i; ?>" <?php if($settings['collapse']):?> class="panel-collapse collapse" aria-expanded="false" <?php endif; ?>>
                                      <div class="panel-body">
                                          <?php echo $item['answer']; ?>
                                      </div>
                                  </div>
                              </div>
                               <?php $i++; $s++; ?>
                          <?php endforeach; ?>
                     </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>    
    </div>
</div>


<?php include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/new_elements/wrapper_bottom.tpl'); ?>
<?php echo $footer; ?>