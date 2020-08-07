<?php echo $header; ?>
<?php

function get_fonts() {
    $fonts = array(
        'standard',
        'ABeeZee',
        'Abel',
        'Abril Fatface',
        'Aclonica',
        'Acme',
        'Actor',
        'Adamina',
        'Advent Pro',
        'Aguafina Script',
        'Akronim',
        'Aladin',
        'Aldrich',
        'Alef',
        'Alegreya',
        'Alegreya SC',
        'Alex Brush',
        'Alfa Slab One',
        'Alice',
        'Alike',
        'Alike Angular',
        'Allan',
        'Allerta',
        'Allerta Stencil',
        'Allura',
        'Almendra',
        'Almendra Display',
        'Almendra SC',
        'Amarante',
        'Amaranth',
        'Amatic SC',
        'Amethysta',
        'Anaheim',
        'Andada',
        'Andika',
        'Angkor',
        'Annie Use Your Telescope',
        'Anonymous Pro',
        'Antic',
        'Antic Didone',
        'Antic Slab',
        'Anton',
        'Arapey',
        'Arbutus',
        'Arbutus Slab',
        'Architects Daughter',
        'Archivo Black',
        'Archivo Narrow',
        'Arial',
        'Arimo',
        'Arizonia',
        'Armata',
        'Artifika',
        'Arvo',
        'Asap',
        'Asset',
        'Astloch',
        'Asul',
        'Atomic Age',
        'Aubrey',
        'Audiowide',
        'Autour One',
        'Average',
        'Average Sans',
        'Averia Gruesa Libre',
        'Averia Libre',
        'Averia Sans Libre',
        'Averia Serif Libre',
        'Bad Script',
        'Balthazar',
        'Bangers',
        'Basic',
        'Battambang',
        'Baumans',
        'Bayon',
        'Belgrano',
        'Belleza',
        'BenchNine',
        'Bentham',
        'Berkshire Swash',
        'Bevan',
        'Bigelow Rules',
        'Bigshot One',
        'Bilbo',
        'Bilbo Swash Caps',
        'Bitter',
        'Black Ops One',
        'Bokor',
        'Bonbon',
        'Boogaloo',
        'Bowlby One',
        'Bowlby One SC',
        'Brawler',
        'Bree Serif',
        'Bubblegum Sans',
        'Bubbler One',
        'Buda',
        'Buenard',
        'Butcherman',
        'Butterfly Kids',
        'Cabin',
        'Cabin Condensed',
        'Cabin Sketch',
        'Caesar Dressing',
        'Cagliostro',
        'Calligraffitti',
        'Cambo',
        'Candal',
        'Cantarell',
        'Cantata One',
        'Cantora One',
        'Capriola',
        'Cardo',
        'Carme',
        'Carrois Gothic',
        'Carrois Gothic SC',
        'Carter One',
        'Caudex',
        'Cedarville Cursive',
        'Ceviche One',
        'Changa One',
        'Chango',
        'Chau Philomene One',
        'Chela One',
        'Chelsea Market',
        'Chenla',
        'Cherry Cream Soda',
        'Cherry Swash',
        'Chewy',
        'Chicle',
        'Chivo',
        'Cinzel',
        'Cinzel Decorative',
        'Clicker Script',
        'Coda',
        'Coda Caption',
        'Codystar',
        'Combo',
        'Comfortaa',
        'Coming Soon',
        'Concert One',
        'Condiment',
        'Content',
        'Contrail One',
        'Convergence',
        'Cookie',
        'Copse',
        'Corben',
        'Courgette',
        'Cousine',
        'Coustard',
        'Covered By Your Grace',
        'Crafty Girls',
        'Creepster',
        'Crete Round',
        'Crimson Text',
        'Croissant One',
        'Crushed',
        'Cuprum',
        'Cutive',
        'Cutive Mono',
        'Damion',
        'Dancing Script',
        'Dangrek',
        'Dawning of a New Day',
        'Days One',
        'Delius',
        'Delius Swash Caps',
        'Delius Unicase',
        'Della Respira',
        'Denk One',
        'Devonshire',
        'Didact Gothic',
        'Diplomata',
        'Diplomata SC',
        'Domine',
        'Donegal One',
        'Doppio One',
        'Dorsa',
        'Dosis',
        'Dr Sugiyama',
        'Droid Sans',
        'Droid Sans Mono',
        'Droid Serif',
        'Duru Sans',
        'Dynalight',
        'EB Garamond',
        'Eagle Lake',
        'Eater',
        'Economica',
        'Electrolize',
        'Elsie',
        'Elsie Swash Caps',
        'Emblema One',
        'Emilys Candy',
        'Engagement',
        'Englebert',
        'Enriqueta',
        'Erica One',
        'Esteban',
        'Euphoria Script',
        'Ewert',
        'Exo',
        'Expletus Sans',
        'Fanwood Text',
        'Fascinate',
        'Fascinate Inline',
        'Faster One',
        'Fasthand',
        'Fauna One',
        'Federant',
        'Federo',
        'Felipa',
        'Fenix',
        'Finger Paint',
        'Fjalla One',
        'Fjord One',
        'Flamenco',
        'Flavors',
        'Fondamento',
        'Fontdiner Swanky',
        'Forum',
        'Francois One',
        'Freckle Face',
        'Fredericka the Great',
        'Fredoka One',
        'Freehand',
        'Fresca',
        'Frijole',
        'Fruktur',
        'Fugaz One',
        'GFS Didot',
        'GFS Neohellenic',
        'Gabriela',
        'Gafata',
        'Galdeano',
        'Galindo',
        'Gentium Basic',
        'Gentium Book Basic',
        'Geo',
        'Georgia',
        'Geostar',
        'Geostar Fill',
        'Germania One',
        'Gilda Display',
        'Give You Glory',
        'Glass Antiqua',
        'Glegoo',
        'Gloria Hallelujah',
        'Goblin One',
        'Gochi Hand',
        'Gorditas',
        'Goudy Bookletter 1911',
        'Graduate',
        'Grand Hotel',
        'Gravitas One',
        'Great Vibes',
        'Griffy',
        'Gruppo',
        'Gudea',
        'Habibi',
        'Hammersmith One',
        'Hanalei',
        'Hanalei Fill',
        'Handlee',
        'Hanuman',
        'Happy Monkey',
        'Headland One',
        'Henny Penny',
        'Herr Von Muellerhoff',
        'Holtwood One SC',
        'Homemade Apple',
        'Homenaje',
        'IM Fell DW Pica',
        'IM Fell DW Pica SC',
        'IM Fell Double Pica',
        'IM Fell Double Pica SC',
        'IM Fell English',
        'IM Fell English SC',
        'IM Fell French Canon',
        'IM Fell French Canon SC',
        'IM Fell Great Primer',
        'IM Fell Great Primer SC',
        'Iceberg',
        'Iceland',
        'Imprima',
        'Inconsolata',
        'Inder',
        'Indie Flower',
        'Inika',
        'Irish Grover',
        'Istok Web',
        'Italiana',
        'Italianno',
        'Jacques Francois',
        'Jacques Francois Shadow',
        'Jim Nightshade',
        'Jockey One',
        'Jolly Lodger',
        'Josefin Sans',
        'Josefin Slab',
        'Joti One',
        'Judson',
        'Julee',
        'Julius Sans One',
        'Junge',
        'Jura',
        'Just Another Hand',
        'Just Me Again Down Here',
        'Kameron',
        'Karla',
        'Kaushan Script',
        'Kavoon',
        'Keania One',
        'Kelly Slab',
        'Kenia',
        'Khmer',
        'Kite One',
        'Knewave',
        'Kotta One',
        'Koulen',
        'Kranky',
        'Kreon',
        'Kristi',
        'Krona One',
        'La Belle Aurore',
        'Lancelot',
        'Lato',
        'League Script',
        'Leckerli One',
        'Ledger',
        'Lekton',
        'Lemon',
        'Libre Baskerville',
        'Life Savers',
        'Lilita One',
        'Lily Script One',
        'Limelight',
        'Linden Hill',
        'Lobster',
        'Lobster Two',
        'Londrina Outline',
        'Londrina Shadow',
        'Londrina Sketch',
        'Londrina Solid',
        'Lora',
        'Love Ya Like A Sister',
        'Loved by the King',
        'Lovers Quarrel',
        'Luckiest Guy',
        'Lusitana',
        'Lustria',
        'Macondo',
        'Macondo Swash Caps',
        'Magra',
        'Maiden Orange',
        'Mako',
        'Marcellus',
        'Marcellus SC',
        'Marck Script',
        'Margarine',
        'Marko One',
        'Marmelad',
        'Marvel',
        'Mate',
        'Mate SC',
        'Maven Pro',
        'McLaren',
        'Meddon',
        'MedievalSharp',
        'Medula One',
        'Megrim',
        'Meie Script',
        'Merienda',
        'Merienda One',
        'Merriweather',
        'Merriweather Sans',
        'Metal',
        'Metal Mania',
        'Metamorphous',
        'Metrophobic',
        'Michroma',
        'Milonga',
        'Miltonian',
        'Miltonian Tattoo',
        'Miniver',
        'Miss Fajardose',
        'Modern Antiqua',
        'Molengo',
        'Molle',
        'Monda',
        'Monofett',
        'Monoton',
        'Monsieur La Doulaise',
        'Montaga',
        'Montez',
        'Montserrat',
        'Montserrat Alternates',
        'Montserrat Subrayada',
        'Moul',
        'Moulpali',
        'Mountains of Christmas',
        'Mouse Memoirs',
        'Mr Bedfort',
        'Mr Dafoe',
        'Mr De Haviland',
        'Mrs Saint Delafield',
        'Mrs Sheppards',
        'Muli',
        'Mystery Quest',
        'Neucha',
        'Neuton',
        'New Rocker',
        'News Cycle',
        'Niconne',
        'Nixie One',
        'Nobile',
        'Nokora',
        'Norican',
        'Nosifer',
        'Nothing You Could Do',
        'Noticia Text',
        'Noto Sans',
        'Noto Serif',
        'Nova Cut',
        'Nova Flat',
        'Nova Mono',
        'Nova Oval',
        'Nova Round',
        'Nova Script',
        'Nova Slim',
        'Nova Square',
        'Numans',
        'Nunito',
        'Odor Mean Chey',
        'Offside',
        'Old Standard TT',
        'Oldenburg',
        'Oleo Script',
        'Oleo Script Swash Caps',
        'Open Sans',
        'Open Sans Condensed',
        'Oranienbaum',
        'Orbitron',
        'Oregano',
        'Orienta',
        'Original Surfer',
        'Oswald',
        'Over the Rainbow',
        'Overlock',
        'Overlock SC',
        'Ovo',
        'Oxygen',
        'Oxygen Mono',
        'PT Mono',
        'PT Sans',
        'PT Sans Caption',
        'PT Sans Narrow',
        'PT Serif',
        'PT Serif Caption',
        'Pacifico',
        'Paprika',
        'Parisienne',
        'Passero One',
        'Passion One',
        'Pathway Gothic One',
        'Patrick Hand',
        'Patrick Hand SC',
        'Patua One',
        'Paytone One',
        'Peralta',
        'Permanent Marker',
        'Petit Formal Script',
        'Petrona',
        'Philosopher',
        'Piedra',
        'Pinyon Script',
        'Pirata One',
        'Plaster',
        'Play',
        'Playball',
        'Playfair Display',
        'Playfair Display SC',
        'Podkova',
        'Poiret One',
        'Poller One',
        'Poly',
        'Pompiere',
        'Pontano Sans',
        'Port Lligat Sans',
        'Port Lligat Slab',
        'Prata',
        'Preahvihear',
        'Press Start 2P',
        'Princess Sofia',
        'Prociono',
        'Prosto One',
        'Puritan',
        'Purple Purse',
        'Quando',
        'Quantico',
        'Quattrocento',
        'Quattrocento Sans',
        'Questrial',
        'Quicksand',
        'Quintessential',
        'Qwigley',
        'Racing Sans One',
        'Radley',
        'Raleway',
        'Raleway Dots',
        'Rambla',
        'Rammetto One',
        'Ranchers',
        'Rancho',
        'Rationale',
        'Redressed',
        'Reenie Beanie',
        'Revalia',
        'Ribeye',
        'Ribeye Marrow',
        'Righteous',
        'Risque',
        'Roboto',
        'Roboto Condensed',
        'Roboto Slab',
        'Rochester',
        'Rock Salt',
        'Rokkitt',
        'Romanesco',
        'Ropa Sans',
        'Rosario',
        'Rosarivo',
        'Rouge Script',
        'Ruda',
        'Rufina',
        'Ruge Boogie',
        'Ruluko',
        'Rum Raisin',
        'Ruslan Display',
        'Russo One',
        'Ruthie',
        'Rye',
        'Sacramento',
        'Sail',
        'Salsa',
        'Sanchez',
        'Sancreek',
        'Sansita One',
        'Sarina',
        'Satisfy',
        'Scada',
        'Schoolbell',
        'Seaweed Script',
        'Sevillana',
        'Seymour One',
        'Shadows Into Light',
        'Shadows Into Light Two',
        'Shanti',
        'Share',
        'Share Tech',
        'Share Tech Mono',
        'Shojumaru',
        'Short Stack',
        'Siemreap',
        'Sigmar One',
        'Signika',
        'Signika Negative',
        'Simonetta',
        'Sintony',
        'Sirin Stencil',
        'Six Caps',
        'Skranji',
        'Slackey',
        'Smokum',
        'Smythe',
        'Sniglet',
        'Snippet',
        'Snowburst One',
        'Sofadi One',
        'Sofia',
        'Sonsie One',
        'Sorts Mill Goudy',
        'Source Code Pro',
        'Source Sans Pro',
        'Special Elite',
        'Spicy Rice',
        'Spinnaker',
        'Spirax',
        'Squada One',
        'Stalemate',
        'Stalinist One',
        'Stardos Stencil',
        'Stint Ultra Condensed',
        'Stint Ultra Expanded',
        'Stoke',
        'Strait',
        'Sue Ellen Francisco',
        'Sunshiney',
        'Supermercado One',
        'Suwannaphum',
        'Swanky and Moo Moo',
        'Syncopate',
        'Tangerine',
        'Taprom',
        'Tauri',
        'Telex',
        'Tenor Sans',
        'Text Me One',
        'The Girl Next Door',
        'Tienne',
        'Times New Roman',
        'Tinos',
        'Titan One',
        'Titillium Web',
        'Trade Winds',
        'Trocchi',
        'Trochut',
        'Trykker',
        'Tulpen One',
        'Ubuntu',
        'Ubuntu Condensed',
        'Ubuntu Mono',
        'Ultra',
        'Uncial Antiqua',
        'Underdog',
        'Unica One',
        'UnifrakturCook',
        'UnifrakturMaguntia',
        'Unkempt',
        'Unlock',
        'Unna',
        'VT323',
        'Vampiro One',
        'Varela',
        'Varela Round',
        'Vast Shadow',
        'Vibur',
        'Vidaloka',
        'Viga',
        'Voces',
        'Volkhov',
        'Vollkorn',
        'Voltaire',
        'Waiting for the Sunrise',
        'Wallpoet',
        'Walter Turncoat',
        'Warnes',
        'Wellfleet',
        'Wendy One',
        'Wire One',
        'Yanone Kaffeesatz',
        'Yellowtail',
        'Yeseva One',
        'Yesteryear',
        'Zeyada'
    );
    return $fonts;
}

?>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="view/stylesheet/css/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/template_options.css" />
<script type="text/javascript" src="view/javascript/jquery/colorpicker.js"></script>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.cookie.js"></script>
<script type="text/javascript">
$.fn.tabs = function() {
    var selector = this;

    this.each(function() {
        var obj = $(this);

        $(obj.attr('href')).hide();

        $(obj).click(function() {
            $(selector).removeClass('selected');

            $(selector).each(function(i, element) {
                $($(element).attr('href')).hide();
            });

            $(this).addClass('selected');

            $($(this).attr('href')).show();

            return false;
        });
    });

    $(this).show();

    $(this).first().click();
};
</script>

<?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
    <div class="page-header">
        <h1>Porto Theme Options</h1>
        <ul class="breadcrumb">
             <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
              <?php } ?>
        </ul>
      </div>

    <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php } elseif ($success) {  ?>
        <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php } ?>

<!-- Theme Options -->

<div class="set-size" id="theme-options">

    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

        <!-- MULTISTORE -->
        <div id="tb_store_select">
            <label class="inline">Store</label>
            <select name="d_store_id" id="d_store_id">
            <?php foreach ($stores as $store): ?>
                <option value="<?php echo 'index.php?route=extension/module/porto&store_id=' . $store['store_id'] . '&user_token=' . $_GET['user_token']; ?>"<?php if($store_id == $store['store_id']) echo ' selected="selected"'; ?>><?php echo $store['name']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="store_id" value="<?php echo $store_id; ?>" />

        <script type="text/javascript">
            $(document).ready(function (){
                $("#d_store_id").bind("change", function() {
                    window.location = $(this).val();
                });

                $("#form input").keypress(function(event) {
                    if (event.which == 13) {
                        return false;
                    }
                });

                $(".button-add").click(function() {
                    $(".add-skin").show();
                    return false;
                });
            });
        </script>
        <!-- END MULTISTORE -->

        <!-- Unlimited theme skins -->
        <div class="content theme-skins">
            <div>
                <ul class="skins">
                    <?php $liczba_skinow = 0; if(isset($skins)) { foreach($skins as $skin) { $liczba_skinow++; } } ?>
                    <?php $aktywny_skin = false; if($liczba_skinow > 0) { ?>
                    <li><p>Active skin: <br><span><?php echo $active_skin; ?></span></p></li>
                    <li>
                        <select name="skin">
                            <?php foreach($skins as $skin) { ?>
                            <option<?php if($skin == $active_skin_edit) { $aktywny_skin = true; echo ' selected="selected"'; } ?> value="<?php echo $skin; ?>"><?php echo $skin; ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="save_skin" value="<?php echo $active_skin_edit; ?>" />
                    </li>
                    <li><input type="submit" name="button-active" class="button-active"></li>
                    <?php } ?>
                    <li><a onclick="#" class="button-add"><span>Add</span></a><div class="add-skin"><input type="text" name="add-skin-name" class="add-skin-name" value=""><input type="submit" name="add-skin" value="Add skin" class="button-add-skin"></div></li>
                    <?php if($liczba_skinow > 0) { ?>
                    <li><input type="submit" name="button-edit" class="button-edit"></li>
                    <li><input type="submit" name="button-delete" class="button-delete" onclick="return confirm('Are you sure you want to delete?')"></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <?php if($liczba_skinow > 0 && ($active_skin != '' || $aktywny_skin == true)) { ?>
        <!-- Content -->

        <div class="content">

            <div>
                <!-- Tabs -->

                <div class="bg-tabs">

                    <!-- General, Design, Footer TABS -->

                    <div id="tabs" class="htabs main-tabs">

                        <a href="#tab_general" id="general"><span>General</span></a>
                        <a href="#tab_design" id="design"><span>Design</span></a>
                        <a href="#tab_custom_block" id="tcustomblock"><span>Custom block</span></a>
                        <a href="#tab_custom_code" id="tcustomcode"><span>Custom code</span></a>
                        <a href="#tab_widgets" id="twidgets"><span>Widgets</span></a>
                        <a href="#tab_install_data" id="tinstalldata"><span>Install data</span></a>

                    </div>

                    <!-- End General, Design Footer Tabs -->

                    <!-- /////////////////// General -->

                    <div id="tab_general" class="tab-content2">

                        <!-- Font, colors, background TABS -->

                        <div id="tabs_general" class="htabs tabs-design">

                            <a href="#tab_layout" id="tlayout"><span>Layout</span></a>
                            <a href="#tab_product" id="tproduct"><span>Product</span></a>
                            <a href="#tab_category" id="tcategory"><span>Category</span></a>
                            <a href="#tab_header" id="theader"><span>Header</span></a>
                            <a href="#tab_footer" id="tlayout"><span>Footer</span></a>
                            <a href="#tab_translations" id="ttranslations"><span>Translations</span></a>

                        </div>

                        <!-- **************** Tab GENERAL OPTIONS -->

                        <div id="tab_layout" class="tab-content">
                            <h4 style="padding-top:30px">Layout</h4>
                            <!-- Input -->
                            <div class="input">
                                <p>Layout type:</p>
                                <select name="layout_type" class="select-page-width">
                                    <option value="1" <?php if($layout_type == 1) { echo 'selected="selected"'; } ?>>Standard</option>
                                    <option value="2" <?php if($layout_type == 2) { echo 'selected="selected"'; } ?>>Boxed short</option>
                                    <option value="4" <?php if($layout_type == 4) { echo 'selected="selected"'; } ?>>Boxed long</option>
                                    <option value="3" <?php if($layout_type == 3) { echo 'selected="selected"'; } ?>>Full width</option>
                                    <option value="5" <?php if($layout_type == 5) { echo 'selected="selected"'; } ?>>Wide width</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <h4 style="padding-top:30px">Body custom class</h4>
                            <div class="input">
                                <p>Custom class:</p>
                                <input type="text" name="body_custom_class" <?php if(isset($body_custom_class)) { echo 'value="'.$body_custom_class.'"'; } ?>>
                                <div class="clear"></div>
                            </div>

                            <h4 style="padding-top:30px">Page Direction</h4>
                                    <!-- Input -->
                                    <div class="input">
                                        <p>Page Direction:</p>
                                        <div class="list-language">
                                            <?php foreach($languages as $language) { ?>
                                            <div class="language select">
                                                <?php $language_id = $language['language_id']; ?>
                                                <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                                <select type="text" name="page_direction[<?php echo $language_id; ?>]" >
                                            <option value="LTR" <?php if(isset($page_direction[$language_id]) && $page_direction[$language_id] == 'LTR') { echo 'selected'; } ?>>LTR (Left To Right)</option>
                                            <option value="RTL" <?php if(isset($page_direction[$language_id]) && $page_direction[$language_id] == 'RTL') { echo 'selected'; } ?>>RTL (Right To Left)</option>
                                        </select>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                        </div>

                        <!-- Product -->
                        <div id="tab_product" class="tab-content">
                            <h4>Lazy loading images</h4>
                            <div class="input with-status">
                                <p style="width:270px">Lazy loading images:</p>
                                <?php if($lazy_loading_images == 0 && $lazy_loading_images != '') { echo '<div class="status status-off" title="0" rel="lazy_loading_images"></div>'; } else { echo '<div class="status status-on" title="1" rel="lazy_loading_images"></div>'; } ?>
                                <input name="lazy_loading_images" value="<?php echo $lazy_loading_images; ?>" id="lazy_loading_images" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <h4 style="margin-top: 20px">Sale badge</h4>
                            <div class="input with-status">
                                <p style="width:270px">Display Sale:</p>
                                <?php if($display_text_sale == 0 && $display_text_sale != '') { echo '<div class="status status-off" title="0" rel="display_text_sale"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_text_sale"></div>'; } ?>
                                <input name="display_text_sale" value="<?php echo $display_text_sale; ?>" id="display_text_sale" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Type Sale:</p>
                                <select name="type_sale">
                                    <option value="0" <?php if($type_sale =='0'){echo ' selected="selected"';} ?>>Text</option>
                                    <option value="1" <?php if($type_sale =='1'){echo ' selected="selected"';} ?>>%</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Text Sale:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="sale_text[<?php echo $language_id; ?>]" <?php if(isset($sale_text[$language_id])) { echo 'value="'.$sale_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <h4 style="margin-top: 20px">New badge</h4>
                                <div class="input with-status">
                                    <p style="width:270px">Display New:</p>
                                    <?php if($display_text_new == 0 && $display_text_new != '') { echo '<div class="status status-off" title="0" rel="display_text_new"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_text_new"></div>'; } ?>
                                    <input name="display_text_new" value="<?php echo $display_text_new; ?>" id="display_text_new" type="hidden" />
                                    <div class="clear"></div>
                                </div>

                                <div class="input">
                                    <p style="width:270px">Text New:</p>
                                    <div class="list-language">
                                        <?php foreach($languages as $language) { ?>
                                        <div class="language">
                                            <?php $language_id = $language['language_id']; ?>
                                            <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                            <input type="text" name="new_text[<?php echo $language_id; ?>]" <?php if(isset($new_text[$language_id])) { echo 'value="'.$new_text[$language_id].'"'; } ?>>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                            <h4 style="margin-top: 20px">Product page</h4>
                            <div class="input">
                                <p style="width:270px">Previous next products buttons:</p>
                                <select name="product_breadcrumb">
                                    <option value="0" <?php if($product_breadcrumb =='0'){echo ' selected="selected"';} ?>>Enabled</option>
                                    <option value="2" <?php if($product_breadcrumb =='2'){echo ' selected="selected"';} ?>>Disabled</option>
                                </select>
                                <div class="clear"></div>
                            </div>
                            <div class="input">
                                <p style="width:270px">Product image zoom:</p>
                                <select name="product_image_zoom">
                                    <option value="0" <?php if($product_image_zoom =='0'){echo ' selected="selected"';} ?>>Cloud Zoom</option>
                                    <option value="1" <?php if($product_image_zoom =='1'){echo ' selected="selected"';} ?>>Inner Cloud Zoom</option>
                                    <option value="2" <?php if($product_image_zoom =='2'){echo ' selected="selected"';} ?>>Default</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Product image size:</p>
                                <select name="product_image_size">
                                    <option value="1" <?php if($product_image_size =='1'){echo ' selected="selected"';} ?>>Small</option>
                                    <option value="2" <?php if($product_image_size =='2' || $product_image_size < 1){echo ' selected="selected"';} ?>>Medium</option>
                                    <option value="3" <?php if($product_image_size =='3'){echo ' selected="selected"';} ?>>Large</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Position image additional:</p>
                                <select name="position_image_additional">
                                    <option value="1" <?php if($position_image_additional =='1'){echo ' selected="selected"';} ?>>Bottom</option>
                                    <option value="2" <?php if($position_image_additional =='2'){echo ' selected="selected"';} ?>>Left</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">Product social share:</p>
                                <?php if($product_social_share == 0 && $product_social_share != '') { echo '<div class="status status-off" title="0" rel="product_social_share"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_social_share"></div>'; } ?>
                                <input name="product_social_share" value="<?php echo $product_social_share; ?>" id="product_social_share" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">Related products:</p>
                                <?php if($product_related_status == 0 && $product_related_status != '') { echo '<div class="status status-off" title="0" rel="product_related_status"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_related_status"></div>'; } ?>
                                <input name="product_related_status" value="<?php echo $product_related_status; ?>" id="product_related_status" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">Add to cart sticky:</p>
                                <?php if($add_to_cart_sticky == 0) { echo '<div class="status status-off" title="0" rel="add_to_cart_sticky"></div>'; } else { echo '<div class="status status-on" title="1" rel="add_to_cart_sticky"></div>'; } ?>
                                <input name="add_to_cart_sticky" value="<?php echo $add_to_cart_sticky; ?>" id="add_to_cart_sticky" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Type of product tabs:</p>
                                <select name="position_product_tabs">
                                    <option value="1" <?php if($position_product_tabs =='1'){echo ' selected="selected"';} ?>>Horizontal</option>
                                    <option value="2" <?php if($position_product_tabs =='2'){echo ' selected="selected"';} ?>>Vertical</option>
                                    <option value="3" <?php if($position_product_tabs =='3'){echo ' selected="selected"';} ?>>Moved</option>
                                    <option value="4" <?php if($position_product_tabs =='4'){echo ' selected="selected"';} ?>>Accordion</option>
                                    <option value="5" <?php if($position_product_tabs =='5'){echo ' selected="selected"';} ?>>Sticky</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <h4 style="margin-top: 20px">Product page - options styles</h4>
                            <div class="input">
                                <p style="width:270px">Option radio style:</p>
                                <select name="product_page_radio_style">
                                    <option value="0" <?php if($product_page_radio_style =='0'){echo ' selected="selected"';} ?>>Default</option>
                                    <option value="1" <?php if($product_page_radio_style =='1'){echo ' selected="selected"';} ?>>Button</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Option radio image size:</p>
                                <input type="text" name="product_page_radio_image_width" style="width:60px" value="<?php echo $product_page_radio_image_width; ?>" />
                                <div style="float:left;width:auto;padding-right:15px;position:relative;margin-left:-5px;padding-top:5px"> x </div>
                                <input type="text" name="product_page_radio_image_height" style="width:60px" value="<?php echo $product_page_radio_image_height; ?>" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Option checkbox style:</p>
                                <select name="product_page_checkbox_style">
                                    <option value="0" <?php if($product_page_checkbox_style =='0'){echo ' selected="selected"';} ?>>Default</option>
                                    <option value="1" <?php if($product_page_checkbox_style =='1'){echo ' selected="selected"';} ?>>Button</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <h4 style="margin-top: 20px">Product grid</h4>
                            <div class="input">
                                <p style="width:270px">Product number per row:</p>
                                <select name="product_per_pow">
                                    <option value="3"<?php if($product_per_pow =='3'){echo ' selected="selected"';} ?>>3</option>
                                    <option value="4"<?php if($product_per_pow =='4' || $product_per_pow < 3){echo ' selected="selected"';} ?>>4</option>
                                    <option value="5"<?php if($product_per_pow =='5'){echo ' selected="selected"';} ?>>5</option>
                                    <option value="6"<?php if($product_per_pow =='6'){echo ' selected="selected"';} ?>>6</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Product image effect:</p>
                                <select name="product_image_effect">
                                    <option value="0"<?php if($product_image_effect =='0'){echo ' selected="selected"';} ?>>None</option>
                                    <option value="1"<?php if($product_image_effect =='1'){echo ' selected="selected"';} ?>>Swap image effect</option>
                                    <option value="2"<?php if($product_image_effect =='2'){echo ' selected="selected"';} ?>>Zoom image effect</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">Quick view:</p>
                                <?php if($quick_view == 0) { echo '<div class="status status-off" title="0" rel="quick_view"></div>'; } else { echo '<div class="status status-on" title="1" rel="quick_view"></div>'; } ?>
                                <input name="quick_view" value="<?php echo $quick_view; ?>" id="quick_view" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:250px">Display elements on product grid:</p>
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- rating</p>
                                <?php if($display_rating == 0 && $display_rating != '') { echo '<div class="status status-off" title="0" rel="display_rating"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_rating"></div>'; } ?>
                                <input name="display_rating" value="<?php echo $display_rating; ?>" id="display_rating" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- add to compare</p>
                                <?php if($display_add_to_compare == 0 && $display_add_to_compare != '') { echo '<div class="status status-off" title="0" rel="display_add_to_compare"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_add_to_compare"></div>'; } ?>
                                <input name="display_add_to_compare" value="<?php echo $display_add_to_compare; ?>" id="display_add_to_compare" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- add to wishlist</p>
                                <?php if($display_add_to_wishlist == 0 && $display_add_to_wishlist != '') { echo '<div class="status status-off" title="0" rel="display_add_to_wishlist"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_add_to_wishlist"></div>'; } ?>
                                <input name="display_add_to_wishlist" value="<?php echo $display_add_to_wishlist; ?>" id="display_add_to_wishlist" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- add to cart</p>
                                <?php if($display_add_to_cart == 0 && $display_add_to_cart != '') { echo '<div class="status status-off" title="0" rel="display_add_to_cart"></div>'; } else { echo '<div class="status status-on" title="1" rel="display_add_to_cart"></div>'; } ?>
                                <input name="display_add_to_cart" value="<?php echo $display_add_to_cart; ?>" id="display_add_to_cart" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p>Product scroll:</p>
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- latest</p>
                                <?php if($product_scroll_latest == 0 && $product_scroll_latest != '') { echo '<div class="status status-off" title="0" rel="product_scroll_latest"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_scroll_latest"></div>'; } ?>
                                <input name="product_scroll_latest" value="<?php echo $product_scroll_latest; ?>" id="product_scroll_latest" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- featured</p>
                                <?php if($product_scroll_featured == 0 && $product_scroll_featured != '') { echo '<div class="status status-off" title="0" rel="product_scroll_featured"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_scroll_featured"></div>'; } ?>
                                <input name="product_scroll_featured" value="<?php echo $product_scroll_featured; ?>" id="product_scroll_featured" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- bestsellers</p>
                                <?php if($product_scroll_bestsellers == 0 && $product_scroll_bestsellers != '') { echo '<div class="status status-off" title="0" rel="product_scroll_bestsellers"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_scroll_bestsellers"></div>'; } ?>
                                <input name="product_scroll_bestsellers" value="<?php echo $product_scroll_bestsellers; ?>" id="product_scroll_bestsellers" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- specials</p>
                                <?php if($product_scroll_specials == 0 && $product_scroll_specials != '') { echo '<div class="status status-off" title="0" rel="product_scroll_specials"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_scroll_specials"></div>'; } ?>
                                <input name="product_scroll_specials" value="<?php echo $product_scroll_specials; ?>" id="product_scroll_specials" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input with-status">
                                <p style="width:270px">&nbsp;&nbsp;&nbsp;- related</p>
                                <?php if($product_scroll_related == 0 && $product_scroll_related != '') { echo '<div class="status status-off" title="0" rel="product_scroll_related"></div>'; } else { echo '<div class="status status-on" title="1" rel="product_scroll_related"></div>'; } ?>
                                <input name="product_scroll_related" value="<?php echo $product_scroll_related; ?>" id="product_scroll_related" type="hidden" />
                                <div class="clear"></div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div id="tab_category" class="tab-content">
                            <h4>Category page</h4>
                            <!-- Input -->
                            <div class="input">
                                <p style="width:270px">Product grid number per row:</p>
                                <select name="product_per_pow2">
                                    <option value="2"<?php if($product_per_pow2 =='2'){echo ' selected="selected"';} ?>>2</option>
                                    <option value="3"<?php if($product_per_pow2 =='3'){echo ' selected="selected"';} ?>>3</option>
                                    <option value="4"<?php if($product_per_pow2 =='4' || $product_per_pow2 < 2){echo ' selected="selected"';} ?>>4</option>
                                    <option value="5"<?php if($product_per_pow2 =='5'){echo ' selected="selected"';} ?>>5</option>
                                    <option value="6"<?php if($product_per_pow2 =='6'){echo ' selected="selected"';} ?>>6</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <!-- Input -->
                            <div class="input">
                                <p style="width:270px">Default list/grid:</p>
                                <select name="default_list_grid">
                                    <option value="0" <?php if($default_list_grid =='0'){echo ' selected="selected"';} ?>>List</option>
                                    <option value="1" <?php if($default_list_grid =='1'){echo ' selected="selected"';} ?>>Grid</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <!-- Input -->
                            <div class="input">
                                <p style="width:270px">Refine search style:</p>
                                <select name="refine_search_style">
                                    <option value="0" <?php if($refine_search_style =='0'){echo ' selected="selected"';} ?>>With images</option>
                                    <option value="1" <?php if($refine_search_style =='1'){echo ' selected="selected"';} ?>>Text only</option>
                                    <option value="2" <?php if($refine_search_style =='2'){echo ' selected="selected"';} ?>>Disable</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Refine search number per row:</p>
                                <select name="refine_search_number">
                                    <option value="2"<?php if($refine_search_number =='2'){echo ' selected="selected"';} ?>>2</option>
                                    <option value="3"<?php if($refine_search_number =='3'|| $refine_search_number < 2){echo ' selected="selected"';} ?>>3</option>
                                    <option value="4"<?php if($refine_search_number =='4'){echo ' selected="selected"';} ?>>4</option>
                                    <option value="5"<?php if($refine_search_number =='5'){echo ' selected="selected"';} ?>>5</option>
                                    <option value="6"<?php if($refine_search_number =='6'){echo ' selected="selected"';} ?>>6</option>
                                </select>
                                <div class="clear"></div>
                            </div>

                            <!-- Input -->
                            <div class="input">
                                <p style="width:270px">Refine search image size:</p>
                                <input type="text" name="refine_image_width" style="width:60px" value="<?php echo $refine_image_width; ?>" />
                                <div style="float:left;width:auto;padding-right:15px;position:relative;margin-left:-5px;padding-top:5px"> x </div>
                                <input type="text" name="refine_image_height" style="width:60px" value="<?php echo $refine_image_height; ?>" />
                                <div class="clear"></div>
                            </div>
                        </div>

                        <!-- Header -->
                        <div id="tab_header" class="tab-content">
                            <h4>Settings</h4>

                            <div class="input with-status">
                                <p style="width:270px">Fixed Header:</p>
                                <?php if($fixed_header == 0) { echo '<div class="status status-off" title="0" rel="fixed_header"></div>'; } else { echo '<div class="status status-on" title="1" rel="fixed_header"></div>'; } ?>
                                <input name="fixed_header" value="<?php echo $fixed_header; ?>" id="fixed_header" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <h4 style="margin-top: 20px">Select Type</h4>

                            <div class="input">
                                <p>Header Type:</p>
                                <div style="float:left;width:600px">
                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="1" <?php if($header_type < 2) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_01.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="2" <?php if($header_type == 2) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_02.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="3" <?php if($header_type == 3) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_03.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="4" <?php if($header_type == 4) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_04.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="5" <?php if($header_type == 5) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_05.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="6" <?php if($header_type == 6) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_06.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="7" <?php if($header_type == 7) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_07.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="8" <?php if($header_type == 8) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_08.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="9" <?php if($header_type == 9) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_09.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="10" <?php if($header_type == 10) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_10.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="11" <?php if($header_type == 11) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_11.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="12" <?php if($header_type == 12) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_12.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="13" <?php if($header_type == 13) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_13.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="14" <?php if($header_type == 14) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_14.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="15" <?php if($header_type == 15) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_15.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="16" <?php if($header_type == 16) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_16.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="17" <?php if($header_type == 17) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_17.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="18" <?php if($header_type == 18) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_18.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="19" <?php if($header_type == 19) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_19.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="20" <?php if($header_type == 20) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_20.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="21" <?php if($header_type == 21) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_21.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="22" <?php if($header_type == 22) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_22.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="23" <?php if($header_type == 23) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_23.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="24" <?php if($header_type == 24) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_24.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="25" <?php if($header_type == 25) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_25.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="26" <?php if($header_type == 26) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_26.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="27" <?php if($header_type == 27) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_27.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="28" <?php if($header_type == 28) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_28.png" alt="" />
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="header_type">
                                        <input type="radio" name="header_type" value="29" <?php if($header_type == 29) { echo 'checked="checked"'; } ?> />
                                        <img src="view/image/module_template/header_29.png" alt="" />
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <!-- Header -->
                        <div id="tab_footer" class="tab-content">

                            <h4>Footer badge</h4>

                            <div class="input with-status">
                                <p style="width:270px">Footer badge:</p>
                                <?php if($footer_badge == 0) { echo '<div class="status status-off" title="0" rel="footer_badge"></div>'; } else { echo '<div class="status status-on" title="1" rel="footer_badge"></div>'; } ?>
                                <input name="footer_badge" value="<?php echo $footer_badge; ?>" id="footer_badge" type="hidden" />
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:270px">Footer badge text:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="footer_badge_text[<?php echo $language_id; ?>]" <?php if(isset($footer_badge_text[$language_id])) { echo 'value="'.$footer_badge_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                        </div>

                        <!-- Translations -->
                        <div id="tab_translations" class="tab-content">
                            <h4>Translate words</h4>
                            <div class="input">
                                <p style="width:200px">All categories text:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="all_categories_text[<?php echo $language_id; ?>]" <?php if(isset($all_categories_text[$language_id])) { echo 'value="'.$all_categories_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Links text:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="links_text[<?php echo $language_id; ?>]" <?php if(isset($links_text[$language_id])) { echo 'value="'.$links_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Load more text:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="load_more_text[<?php echo $language_id; ?>]" <?php if(isset($load_more_text[$language_id])) { echo 'value="'.$load_more_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Welcome text in top bar:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="welcome_text[<?php echo $language_id; ?>]" <?php if(isset($welcome_text[$language_id])) { echo 'value="'.$welcome_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Text item(s):</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="shopping_cart_text[<?php echo $language_id; ?>]" <?php if(isset($shopping_cart_text[$language_id])) { echo 'value="'.$shopping_cart_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Home:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="home_text[<?php echo $language_id; ?>]" <?php if(isset($home_text[$language_id])) { echo 'value="'.$home_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Add to compare:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="add_to_compare_text[<?php echo $language_id; ?>]" <?php if(isset($add_to_compare_text[$language_id])) { echo 'value="'.$add_to_compare_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Add to wishlist:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="add_to_wishlist_text[<?php echo $language_id; ?>]" <?php if(isset($add_to_wishlist_text[$language_id])) { echo 'value="'.$add_to_wishlist_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Quickview:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="quickview_text[<?php echo $language_id; ?>]" <?php if(isset($quickview_text[$language_id])) { echo 'value="'.$quickview_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">More details:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="more_details_text[<?php echo $language_id; ?>]" <?php if(isset($more_details_text[$language_id])) { echo 'value="'.$more_details_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="input">
                                <p style="width:200px">Read more:</p>
                                <div class="list-language">
                                    <?php foreach($languages as $language) { ?>
                                    <div class="language">
                                        <?php $language_id = $language['language_id']; ?>
                                        <img src="../image/flags/<?php echo $language['image'] ?>" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
                                        <input type="text" name="readmore_text[<?php echo $language_id; ?>]" <?php if(isset($readmore_text[$language_id])) { echo 'value="'.$readmore_text[$language_id].'"'; } ?>>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <!-- **************** END TAB GENERAL OPTIONS -->

                    </div>

                    <!-- ////////////////////// End General -->

                    <!-- Design -->

                    <div id="tab_design" class="tab-content2">

                        <!-- Font, colors, background TABS -->

                        <div id="tabs_design" class="htabs tabs-design">

                            <a href="#tab_font" id="tfont"><span>Font</span></a>
                            <a href="#tab_colors" id="tcolors"><span>Colors</span></a>
                            <a href="#tab_backgrounds" id="tbackgrounds"><span>Backgrounds</span></a>

                        </div>

                        <!-- Font, colors, background -->

                        <!-- Font -->

                        <div id="tab_font" class="tab-content">

                            <!-- Status -->

                            <?php if($font_status == 1) { echo '<div class="status status-on" title="1" rel="font_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="font_status"></div>'; } ?>

                            <input name="font_status" value="<?php echo $font_status; ?>" id="font_status" type="hidden" />

                            <!-- Title -->

                            <h4>Font settings</h4>

                            <!-- Input -->

                            <div class="input">

                                <p>Body Font:</p>
                                <select name="body_font">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($body_font == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="body_font_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($body_font_weight==$x || ($x == 4 && $body_font_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>
                                <select name="body_font_px" style="width:80px;margin-right:25px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($body_font_px==$x || ($x == 13 && $body_font_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Categories bar:</p>
                                <select name="categories_bar">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($categories_bar == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="categories_bar_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($categories_bar_weight==$x || ($x == 4 && $categories_bar_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>
                                <select name="categories_bar_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($categories_bar_px==$x || ($x == 16 && $categories_bar_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Price:</p>
                                <select name="custom_price">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($custom_price == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="custom_price_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($custom_price_weight==$x || ($x == 4 && $custom_price_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>
                                <p style="width:54px">Big</p>
                                <select name="custom_price_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($custom_price_px==$x || ($x == 36 && $custom_price_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>
                                <p style="width:81px">Medium</p>
                                <select name="custom_price_px_medium" style="width:80px;margin-right:0px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($custom_price_px_medium==$x || ($x == 24 && $custom_price_px_medium < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear" style="height:15px"></div>

                                <div style="float:left;width:410px;height:10px"></div>

                                <p style="width:54px">Small</p>
                                <select name="custom_price_px_small" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($custom_price_px_small==$x || ($x == 13 && $custom_price_px_small < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>
                                <p style="width:81px">Old price</p>
                                <select name="custom_price_px_old_price" style="width:80px;margin-right:0px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($custom_price_px_old_price==$x || ($x == 13 && $custom_price_px_old_price < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>


                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Headlines:</p>
                                <select name="headlines">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($headlines == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="headlines_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($headlines_weight==$x || ($x == 4 && $headlines_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>

                                <select name="headlines_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($headlines_px==$x || ($x == 18 && $headlines_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Footer headlines:</p>
                                <select name="footer_headlines">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($footer_headlines == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="footer_headlines_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($footer_headlines_weight==$x || ($x == 4 && $footer_headlines_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>
                                <select name="footer_headlines_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($footer_headlines_px==$x || ($x == 20 && $footer_headlines_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Page name:</p>
                                <select name="page_name">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($page_name == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                                </select>
                                <select name="page_name_weight" style="width:60px;margin-right:20px">

                                    <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($page_name_weight==$x || ($x == 6 && $page_name_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                    <?php } ?>

                                </select>
                                <select name="page_name_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($page_name_px==$x || ($x == 24 && $page_name_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->
                            <!-- Input -->

                            <div class="input">

                                <p>Button:</p>
                                <select name="button_font">

                                <?php foreach (get_fonts() as $key => $font) {


                                    if ($button_font == $font) {
                                        $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }

                                    echo '<option '.$selected.' value="'.$font.'">'.$font.'</option>';

                                } ?>

                            </select>
                            <select name="button_font_weight" style="width:60px;margin-right:20px">

                                <?php for( $x = 3; $x <= 8; $x++ ) { ?>
                              <option value="<?php echo $x; ?>" <?php if($button_font_weight==$x || ($x == 4 && $button_font_weight < 3)){echo ' selected="selected"';} ?>><?php echo $x*100; ?></option>
                                <?php } ?>

                            </select>
                                <select name="button_font_px" style="width:80px">

                                    <?php for( $x = 9; $x <= 50; $x++ ) { ?>
                                  <option value="<?php echo $x; ?>" <?php if($button_font_px==$x || ($x == 14 && $button_font_px < 6)){echo ' selected="selected"';} ?>><?php echo $x; ?> px</option>
                                    <?php } ?>

                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                        </div>

                        <!-- End Font -->

                        <!-- Colors -->

                        <div id="tab_colors" class="tab-content">

                            <!-- Status -->

                            <?php if($colors_status == 1) { echo '<div class="status status-on" title="1" rel="colors_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="colors_status"></div>'; } ?>

                            <input name="colors_status" value="<?php echo $colors_status; ?>" id="colors_status" type="hidden" />

                            <?php $i = 0; foreach($colors_data as $colors) {
                                echo '<div class="colors_left" ';
                                echo $i == 0 ? 'style="padding-top: 0px"' : '';
                                echo '>';
                                echo '  <h4>' . $colors['name'] . '</h4>';
                                    foreach($colors['content'] as $color) {
                                        echo '<div class="color_input">';
                                        echo '  <p>' . $color['name'] . ':</p>';
                                        echo '  <div><input type="text" value="' . ${$color['id']} . '" id="' . $color['id'] . '" name="' . $color['id'] . '"';
                                        echo ${$color['id']} != '' ? 'style="border-right: 20px solid ' . ${$color['id']} . '"' : '';
                                        echo ' /></div>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                            $i++; } ?>

                        </div>

                        <!-- End Colors -->

                        <!-- Backgrounds -->
                        <div id="tab_backgrounds" class="tab-content">

                            <!-- Status -->
                            <?php if($background_status == 1) { echo '<div class="status status-on" title="1" rel="background_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="background_status"></div>'; } ?>

                            <input name="background_status" value="<?php echo $background_status; ?>" id="background_status" type="hidden" />

                            <h4>Body</h4>

                            <!-- Input -->

                            <div class="input">

                                <p>Background:</p>
                                <select name="body_background_background">
                                    <option value="0"<?php if($body_background_background < 1) { echo ' selected="selected"'; } ?>>Standard</option>
                                    <option value="1"<?php if($body_background_background == 1) { echo ' selected="selected"'; } ?>>None</option>
                                    <option value="2"<?php if($body_background_background == 2) { echo ' selected="selected"'; } ?>>Own</option>
                                    <option value="3"<?php if($body_background_background == 3) { echo ' selected="selected"'; } ?>>Subtle patterns</option>
                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">
                                <p>Own background:</p>

                                <div class="own_image">
                                    <input type="hidden" name="body_background" value="<?php echo $body_background; ?>" id="input-body-background" />

                                    <?php if($body_background == '') { ?>
                                        <a href="" id="thumb-body-background" class="img-thumbnail img-edit" data-toggle="image"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                                    <?php } else { ?>
                                        <a href="" id="thumb-body-background" class="img-thumbnail img-edit" data-toggle="image"><img src="../image/<?php echo $body_background; ?>" alt="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                                    <?php } ?>
                                </div>

                                <div class="clear"></div>
                            </div>

                            <!-- End Input -->

                            <div class="input">

                                <p>Subtle patterns:</p>
                                <div class="subtle-patterns">
                                    <?php

                                        if($body_background_subtle_patterns != '') { ?>

                                        <div class="subtle-pattern">
                                            <input type="radio" name="body_background_subtle_patterns" value="<?php echo $body_background_subtle_patterns; ?>" class="input-subtle-pattern" checked="checked">
                                            <img src="../image/subtle_patterns/<?php echo $body_background_subtle_patterns; ?>" width="50px" height="50px">
                                            <p><?php echo $body_background_subtle_patterns; ?></p>
                                            <div class="clear"></div>
                                        </div>

                                        <?php

                                        }

                                        $dir = opendir ("../image/subtle_patterns/");
                                        while (false !== ($file = readdir($dir))) {
                                            if ($file<>"." && $file<>"..") {
                                                if (strpos($file, '.gif',1) || strpos($file, '.jpg',1) || strpos($file, '.png',3) ) { ?>

                                            <div class="subtle-pattern">
                                                <input type="radio" name="body_background_subtle_patterns" value="<?php echo $file; ?>" class="input-subtle-pattern">
                                                <img src="../image/subtle_patterns/<?php echo $file; ?>" width="50px" height="50px">
                                                <p><?php echo $file; ?></p>
                                                <div class="clear"></div>
                                            </div>

                                    <?php
                                                }

                                            }
                                        }

                                    ?>
                                </div>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                                <!-- Input -->

                            <div class="input">

                                <p>Position:</p>
                                <select name="body_background_position">
                                    <option value="top left"<?php if($body_background_position == 'top left') { echo ' selected="selected"'; } ?>>Top left</option>
                                    <option value="top center"<?php if($body_background_position == 'top center') { echo ' selected="selected"'; } ?>>Top center</option>
                                    <option value="top right"<?php if($body_background_position == 'top right') { echo ' selected="selected"'; } ?>>Top right</option>
                                    <option value="bottom left"<?php if($body_background_position == 'bottom left') { echo ' selected="selected"'; } ?>>Bottom left</option>
                                    <option value="bottom center"<?php if($body_background_position == 'bottom center') { echo ' selected="selected"'; } ?>>Bottom center</option>
                                    <option value="bottom right"<?php if($body_background_position == 'bottom right') { echo ' selected="selected"'; } ?>>Bottom right</option>
                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                                <!-- Input -->

                            <div class="input">

                                <p>Repeat:</p>
                                <select name="body_background_repeat">
                                    <option value="no-repeat"<?php if($body_background_repeat == 'no-repeat') { echo ' selected="selected"'; } ?>>no-repeat</option>
                                    <option value="repeat-x"<?php if($body_background_repeat == 'repeat-x') { echo ' selected="selected"'; } ?>>repeat-x</option>
                                    <option value="repeat-y"<?php if($body_background_repeat == 'repeat-y') { echo ' selected="selected"'; } ?>>repeat-y</option>
                                    <option value="repeat"<?php if($body_background_repeat == 'repeat') { echo ' selected="selected"'; } ?>>repeat</option>
                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                                <!-- Input -->

                            <div class="input">

                                <p>Attachment:</p>
                                <select name="body_background_attachment">
                                    <option value="scroll"<?php if($body_background_attachment == 'scroll') { echo ' selected="selected"'; } ?>>scroll</option>
                                    <option value="fixed"<?php if($body_background_attachment == 'fixed') { echo ' selected="selected"'; } ?>>fixed</option>
                                </select>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                        </div>

                    </div>

                    <!-- End Design -->

                    <!-- Custom code -->

                    <div id="tab_custom_code" class="tab-content2">

                        <!-- Font, colors, background TABS -->

                        <div id="tabs_custom_code" class="htabs tabs-design">

                            <a href="#tab_css" id="tcss"><span>Css</span></a>
                            <a href="#tab_javascript" id="tjavascript"><span>Javascript</span></a>

                        </div>

                        <!-- ....... TABS CSS -->

                        <div id="tab_css" class="tab-content">

                            <!-- Status -->

                            <?php if($custom_code_css_status == 1) { echo '<div class="status status-on" title="1" rel="custom_code_css_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="custom_code_css_status"></div>'; } ?>

                            <input name="custom_code_css_status" value="<?php echo $custom_code_css_status; ?>" id="custom_code_css_status" type="hidden" />

                            <!-- Input -->

                            <div class="input">

                                <?php if(isset($custom_code_css)) { ?>
                                <textarea rows="0" cols="0" name="custom_code_css"><?php echo $custom_code_css; ?></textarea>
                                <?php } else { ?>
                                <textarea rows="0" cols="0" name="custom_code_css"></textarea>
                                <?php } ?>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                        </div>

                        <!-- ....... END TABS CSS -->

                        <!-- ....... TABS JAVASCRIPT -->

                        <div id="tab_javascript" class="tab-content">

                            <!-- Status -->

                            <?php if($custom_code_javascript_status == 1) { echo '<div class="status status-on" title="1" rel="custom_code_javascript_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="custom_code_javascript_status"></div>'; } ?>

                            <input name="custom_code_javascript_status" value="<?php echo $custom_code_javascript_status; ?>" id="custom_code_javascript_status" type="hidden" />

                            <!-- Input -->

                            <div class="input">

                                <?php if(isset($custom_code_js)) { ?>
                                <textarea rows="0" cols="0" name="custom_code_js"><?php echo $custom_code_js; ?></textarea>
                                <?php } else { ?>
                                <textarea rows="0" cols="0" name="custom_code_js"></textarea>
                                <?php } ?>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                        </div>

                        <!-- ....... END TABS JAVASCRIPT -->

                    </div>

                    <!-- End Custom code -->

                    <!-- Widget -->

                    <div id="tab_widgets" class="tab-content2">

                        <div id="tabs_widgets" class="htabs tabs-design">

                            <a href="#tab_widget_facebook" class="tfacebook"><span>Facebook</span></a>
                            <a href="#tab_widget_twitter" class="ttwitter"><span>Twitter</span></a>
                            <a href="#tab_widget_custom" class="tcustomblock"><span>Custom</span></a>

                        </div>

                        <div id="tab_widget_facebook" class="tab-content">

                            <!-- Status -->

                            <?php if($widget_facebook_status == 1) { echo '<div class="status status-on" title="1" rel="widget_facebook_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="widget_facebook_status"></div>'; } ?>

                            <input name="widget_facebook_status" value="<?php echo $widget_facebook_status; ?>" id="widget_facebook_status" type="hidden" />

                            <h4>Facebook</h4>

                            <!-- Input -->

                            <div class="input">

                                <p>Facebook ID:</p>
                                <?php if(isset($widget_facebook_id)) { ?>
                                    <input name="widget_facebook_id" type="text" value="<?php echo $widget_facebook_id; ?>" />
                                <?php } else { ?>
                                    <input name="widget_facebook_id" type="text" value="" />
                                <?php } ?>

                                <a href="http://findmyfacebookid.com/" target="_blank" style="display: block;float: left;width: auto;margin-top: 7px">Find your Facebook ID »</a>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->
                            <!-- Input -->

                            <div class="input">

                                <p>Position:</p>
                                <select name="widget_facebook_position">
                                    <?php if(isset($widget_facebook_position)) { ?>
                                       <option value="0" <?php if($widget_facebook_position =='0'){echo ' selected="selected"';} ?>>Right</option>
                                       <option value="1" <?php if($widget_facebook_position =='1'){echo ' selected="selected"';} ?>>Left</option>
                                     <?php } else { ?>
                                        <option value="0" selected="selected">Right</option>
                                        <option value="1">Left</option>
                                     <?php } ?>
                                </select>

                                <div class="clear"></div>

                             </div>

                            <!-- End Input -->

                        </div>

                        <div id="tab_widget_twitter" class="tab-content">

                            <!-- Status -->

                            <?php if($widget_twitter_status == 1) { echo '<div class="status status-on" title="1" rel="widget_twitter_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="widget_twitter_status"></div>'; } ?>

                            <input name="widget_twitter_status" value="<?php echo $widget_twitter_status; ?>" id="widget_twitter_status" type="hidden" />

                            <h4>Twitter</h4>

                            <!-- Input -->

                            <div class="input">

                                <p>Twitter username:</p>
                                <?php if(isset($widget_twitter_user_name)) { ?>
                                    <input name="widget_twitter_user_name" type="text" value="<?php echo $widget_twitter_user_name; ?>" />
                                <?php } else { ?>
                                    <input name="widget_twitter_user_name" type="text" value="" />
                                <?php } ?>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Widget ID:</p>
                                <?php if(isset($widget_twitter_id)) { ?>
                                    <input name="widget_twitter_id" type="text" value="<?php echo $widget_twitter_id; ?>" />
                                <?php } else { ?>
                                    <input name="widget_twitter_id" type="text" value="" />
                                <?php } ?>

                                <div class="clear"></div>

                            </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Tweet limit:</p>
                                <select name="widget_twitter_limit">
                                    <?php if(isset($widget_twitter_limit)) { ?>
                                       <option value="1" <?php if($widget_twitter_limit =='1'){echo ' selected="selected"';} ?>>1</option>
                                       <option value="2" <?php if($widget_twitter_limit =='2'){echo ' selected="selected"';} ?>>2</option>
                                       <option value="3" <?php if($widget_twitter_limit =='3'){echo ' selected="selected"';} ?>>3</option>
                                     <?php } else { ?>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected="selected">3</option>
                                     <?php } ?>
                                </select>

                                <div class="clear"></div>

                             </div>

                            <!-- End Input -->

                            <!-- Input -->

                            <div class="input">

                                <p>Position:</p>
                                <select name="widget_twitter_position">
                                    <?php if(isset($widget_twitter_position)) { ?>
                                       <option value="0" <?php if($widget_twitter_position =='0'){echo ' selected="selected"';} ?>>Right</option>
                                       <option value="1" <?php if($widget_twitter_position =='1'){echo ' selected="selected"';} ?>>Left</option>
                                     <?php } else { ?>
                                        <option value="0" selected="selected">Right</option>
                                        <option value="1">Left</option>
                                     <?php } ?>
                                </select>

                                <div class="clear"></div>

                             </div>

                            <!-- End Input -->

                        </div>

                        <div id="tab_widget_custom" class="tab-content">

                            <!-- Status -->

                            <?php if($widget_custom_status == 1) { echo '<div class="status status-on" title="1" rel="widget_custom_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="widget_custom_status"></div>'; } ?>

                            <input name="widget_custom_status" value="<?php echo $widget_custom_status; ?>" id="widget_custom_status" type="hidden" />

                            <h4>Custom block</h4>

                            <div class="customblocktabs htabs">
                                <?php foreach ($languages as $language) { ?>
                                <a href="#content_customblock_<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                                <?php } ?>
                            </div>

                            <?php foreach ($languages as $language) { $lang_id = $language['language_id']; ?>
                            <!-- Input -->
                            <div id="content_customblock_<?php echo $language['language_id']; ?>" class="content_customblock">
                                <div class="input-with-editor clearfix">
                                    <textarea name="widget_custom_content[<?php echo $language['language_id']; ?>]" id="widget_custom_content_<?php echo $language['language_id']; ?>" style="float: none;clear: both"><?php if(isset($widget_custom_content[$lang_id])) { echo $widget_custom_content[$lang_id]; } ?></textarea>
                                </div>
                            </div>
                            <?php } ?>

                            <!-- Input -->

                            <div class="input">

                                <p>Position:</p>
                                <select name="widget_custom_position">
                                    <?php if(isset($widget_custom_position)) { ?>
                                       <option value="0" <?php if($widget_custom_position =='0'){echo ' selected="selected"';} ?>>Right</option>
                                       <option value="1" <?php if($widget_custom_position =='1'){echo ' selected="selected"';} ?>>Left</option>
                                     <?php } else { ?>
                                            <option value="0" selected="selected">Right</option>
                                        <option value="1">Left</option>
                                     <?php } ?>
                                </select>

                                <div class="clear"></div>

                             </div>

                            <!-- End Input -->

                        </div>

                    </div>

                    <!-- End Widgets -->


                    <!-- Compressor Code -->

                    <div id="tab_install_data" class="tab-content">

                        <p style="font-family:Open Sans;color:#4c4c4c;font-size:12px;line-height: 21px;padding-top: 12px">If you want to make your shop look exactly like our demo. Install sample data.<br><br>If you will have problem with installing sample data for custom module in 19 th version (blank homepage), just login to admin panel in that demo version (login: demo, pass: demo) and copy content of custom module manually.</p>

                        <div class="input" style="border: none">

                            <p style="width:180px">Select version:</p>
                            <select name="select_demo" id="select_demo">
                                 <option value="1" <?php if($select_demo == '1'){echo ' selected="selected"';} ?>>default</option>
                                 <option value="21" <?php if($select_demo == '21'){echo ' selected="selected"';} ?>>default - new</option>
                                 <option value="2" <?php if($select_demo == '2'){echo ' selected="selected"';} ?>>index2</option>
                                 <option value="22" <?php if($select_demo == '22'){echo ' selected="selected"';} ?>>index2 - new</option>
                                 <option value="3" <?php if($select_demo == '3'){echo ' selected="selected"';} ?>>index3</option>
                                 <option value="4" <?php if($select_demo == '4'){echo ' selected="selected"';} ?>>index4</option>
                                 <option value="23" <?php if($select_demo == '23'){echo ' selected="selected"';} ?>>index4 - new</option>
                                 <option value="5" <?php if($select_demo == '5'){echo ' selected="selected"';} ?>>index5</option>
                                 <option value="28" <?php if($select_demo == '28'){echo ' selected="selected"';} ?>>index5 - new</option>
                                 <option value="6" <?php if($select_demo == '6'){echo ' selected="selected"';} ?>>index6</option>
                                 <option value="7" <?php if($select_demo == '7'){echo ' selected="selected"';} ?>>index7</option>
                                 <option value="25" <?php if($select_demo == '25'){echo ' selected="selected"';} ?>>index7 - new</option>
                                 <option value="8" <?php if($select_demo == '8'){echo ' selected="selected"';} ?>>index8</option>
                                 <option value="9" <?php if($select_demo == '9'){echo ' selected="selected"';} ?>>index9</option>
                                 <option value="10" <?php if($select_demo == '10'){echo ' selected="selected"';} ?>>index10</option>
                                 <option value="11" <?php if($select_demo == '11'){echo ' selected="selected"';} ?>>index11</option>
                                 <option value="27" <?php if($select_demo == '27'){echo ' selected="selected"';} ?>>index11 - new</option>
                                 <option value="12" <?php if($select_demo == '12'){echo ' selected="selected"';} ?>>index12</option>
                                 <option value="26" <?php if($select_demo == '26'){echo ' selected="selected"';} ?>>index12 - new</option>
                                 <option value="13" <?php if($select_demo == '13'){echo ' selected="selected"';} ?>>index13</option>
                                 <option value="14" <?php if($select_demo == '14'){echo ' selected="selected"';} ?>>index14</option>
                                 <option value="15" <?php if($select_demo == '15'){echo ' selected="selected"';} ?>>index15</option>
                                 <option value="24" <?php if($select_demo == '24'){echo ' selected="selected"';} ?>>index15 - new</option>
                                 <option value="16" <?php if($select_demo == '16'){echo ' selected="selected"';} ?>>index16</option>
                                 <option value="17" <?php if($select_demo == '17'){echo ' selected="selected"';} ?>>index17</option>
                                 <option value="18" <?php if($select_demo == '18'){echo ' selected="selected"';} ?>>index18</option>
                                 <option value="19" <?php if($select_demo == '19'){echo ' selected="selected"';} ?>>index19</option>
                                 <option value="20" <?php if($select_demo == '20'){echo ' selected="selected"';} ?>>index20</option>
                            </select>

                            <div class="clear"></div>

                         </div>

                        <h4>Install sample data <span id="demo">for default version</span>:</h4>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-19 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">Advanced grid:</p>
                            <input type="submit" name="install_advanced_grid" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-19 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">Popup:</p>
                            <input type="submit" name="install_popup" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-19 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">Custom module (banners):</p>
                            <input type="submit" name="install_custom_module" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-5 version-8 version-9 version-12 version-21 version-22 version-24 version-26">
                            <p style="width:240px">Camera slider:</p>
                            <input type="submit" name="install_camera_slider" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">MegaMenu:</p>
                            <input type="submit" name="install_megamenu" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-19 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">Mobile Menu:</p>
                            <input type="submit" name="install_mobile_menu" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-4 version-7 version-9 version-11 version-12 version-13 version-16 version-17 version-18 version-21 version-23 version-25 version-26 version-27">
                            <p style="width:240px">Filter product:</p>
                            <input type="submit" name="install_filter_product" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-2 version-3 version-4 version-5 version-6 version-7 version-8 version-9 version-10 version-11 version-12 version-13 version-14  version-15 version-16 version-17 version-18 version-19 version-20 version-21 version-22 version-23 version-24 version-25 version-26 version-27 version-28">
                            <p style="width:240px">Breadcrumb background image:</p>
                            <input type="submit" name="install_breadcrumb_background_image" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-4 version-12 version-16 version-21 version-26">
                            <p style="width:240px">Latest posts:</p>
                            <input type="submit" name="install_latest_posts" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input versions version-1 version-21">
                            <p style="width:240px">Newsletter:</p>
                            <input type="submit" name="install_newsletter" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input">
                            <p style="width:240px">Faq:</p>
                            <input type="submit" name="install_faq" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>

                        <div class="input">
                            <p style="width:240px">Blog:</p>
                            <input type="submit" name="install_blog" class="button-install" onclick="return confirm('Are you sure you want to install sample data?')" value="">

                            <div class="clear"></div>
                        </div>
                    </div>

                    <!-- End Compressor Code -->

                    <!-- Custom block -->

                    <div id="tab_custom_block" class="tab-content3">
                        <div class="footer_left" style="margin-top: 149px">
                            <div id="tabs_custom_block" class="htabs main-tabs">
                                <?php foreach ($languages as $language): ?>
                                <a href="#tab_custom_block_<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" /><span><?php echo $language['name']; ?></span></a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="footer_right">
                            <?php foreach ($languages as $language) { ?>
                            <?php $language_id = $language['language_id']; ?>
                            <div id="tab_custom_block_<?php echo $language_id; ?>">
                                <div id="tabs_custom_block_<?php echo $language_id; ?>" class="htabs tabs-design">
                                    <a href="#tab_contact_page_<?php echo $language_id; ?>" class="tcontact"><span>Contact page</span></a>
                                </div>

                                <div id="tab_contact_page_<?php echo $language_id; ?>" class="tab-content4">
                                    <!-- Status -->
                                    <?php if(isset($custom_block['contact_page'][$language_id]['status'])) { ?>
                                    <?php if($custom_block['contact_page'][$language_id]['status'] == 1) { echo '<div class="status status-on" title="1" rel="custom_block_contact_page_'.$language_id.'_status"></div>'; } else { echo '<div class="status status-off" title="0" rel="custom_block_contact_page_'.$language_id.'_status"></div>'; } ?>

                                    <input name="custom_block[contact_page][<?php echo $language_id; ?>][status]" value="<?php echo $custom_block['contact_page'][$language_id]['status']; ?>" id="custom_block_contact_page_<?php echo $language_id; ?>_status" type="hidden" />
                                    <?php } else { ?>
                                    <?php echo '<div class="status status-off" title="0" rel="custom_block_contact_page_'.$language_id.'_status"></div>'; ?>
                                    <input name="custom_block[contact_page][<?php echo $language_id; ?>][status]" value="0" id="custom_block_contact_page_<?php echo $language_id; ?>_status" type="hidden" />
                                    <?php } ?>

                                    <h4>Custom block</h4>
                                    <div class="input">
                                        <p>Heading:</p>
                                        <?php if(isset($custom_block['contact_page'][$language_id]['heading'])) { ?>
                                        <input name="custom_block[contact_page][<?php echo $language_id; ?>][heading]" type="text" value="<?php echo $custom_block['contact_page'][$language_id]['heading']; ?>" />
                                        <?php } else { ?>
                                        <input name="custom_block[contact_page][<?php echo $language_id; ?>][heading]" type="text" value="" />
                                        <?php } ?>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="input-with-editor editor-no-border">
                                        <?php if(isset($custom_block['contact_page'][$language_id]['text'])) { ?>
                                        <textarea rows="0" cols="0" name="custom_block[contact_page][<?php echo $language_id; ?>][text]" id="custom_block_contact_page_<?php echo $language_id; ?>_text"><?php echo $custom_block['contact_page'][$language_id]['text']; ?></textarea>
                                        <?php } else { ?>
                                        <textarea rows="0" cols="0" name="custom_block[contact_page][<?php echo $language_id; ?>][text]" id="custom_block_contact_page_<?php echo $language_id; ?>_text"></textarea>
                                        <?php } ?>
                                        <div class="clear"></div>

                                        <script type="text/javascript">
                                            $('#custom_block_contact_page_<?php echo $language_id; ?>_text').summernote({
                                                height: 400
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>

                            <script type="text/javascript"><!--
                            $('#tabs_custom_block_<?php echo $language_id; ?> a').tabs();
                            if($.cookie('tabs_custom_block_<?php echo $language_id; ?>') > 0) {
                                $('#tabs_custom_block_<?php echo $language_id; ?> a').eq($.cookie('tabs_custom_block_<?php echo $language_id; ?>')).trigger("click");
                            }
                            $('#tabs_custom_block_<?php echo $language_id; ?> a').click(function() {
                                var element_index = $('#tabs_custom_block_<?php echo $language_id; ?> a').index(this);
                                $.cookie('tabs_custom_block_<?php echo $language_id; ?>', element_index);
                            });
                            //--></script>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- End Custom block -->

                    <p style="font-size:1px;line-height:1px;height:1px;clear:both;margin:0px;padding:0px;position:relative;margin-top:-1px"></p>

                </div>

                <!-- End Tabs -->

                <!-- Buttons -->

                <div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>

                <!-- End Buttons -->

            </div>

        </div>
        <!-- End Content -->
        <?php } else { ?>
            <div class="content">
                <div style="padding:20px 40px;text-align:center;">
                    You need to add or active skin.
                </div>
            </div>
        <?php } ?>

    </form>

</div>
<!-- End Theme Options -->

</div>

<!-- END #CONTENT -->

<script type="text/javascript">

$(document).ready(function() {

    $('.color_input input').ColorPicker({
        onChange: function (hsb, hex, rgb, el) {
            $(el).val("#" +hex);
            $(el).css("border-right", "20px solid #" + hex);
        },
        onShow: function (colpkr) {
            $(colpkr).show();
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).hide();
            return false;
        }
    });
});
</script>
<script type="text/javascript"><!--
$(document).ready(function(){
    $('#tabs a').tabs();
    if($.cookie('tabs_cookie') > 0) {
        $('#tabs a').eq($.cookie('tabs_cookie')).trigger("click");
    }
    $('#tabs a').click(function() {
        var element_index = $('#tabs a').index(this);
        $.cookie('tabs_cookie', element_index);
    });

    $('#tabs_design a').tabs();
    if($.cookie('tabs_design_cookie') > 0) {
        $('#tabs_design a').eq($.cookie('tabs_design_cookie')).trigger("click");
    }
    $('#tabs_design a').click(function() {
        var element_index = $('#tabs_design a').index(this);
        $.cookie('tabs_design_cookie', element_index);
    });

    $('#tabs_footer a').tabs();
    if($.cookie('tabs_footer_cookie') > 0) {
        $('#tabs_footer a').eq($.cookie('tabs_footer_cookie')).trigger("click");
    }
    $('#tabs_footer a').click(function() {
        var element_index = $('#tabs_footer a').index(this);
        $.cookie('tabs_footer_cookie', element_index);
    });

    $('#tabs_general a').tabs();
    if($.cookie('tabs_general_cookie') > 0) {
        $('#tabs_general a').eq($.cookie('tabs_general_cookie')).trigger("click");
    }
    $('#tabs_general a').click(function() {
        var element_index = $('#tabs_general a').index(this);
        $.cookie('tabs_general_cookie', element_index);
    });

    $('#tabs_widgets a').tabs();
    if($.cookie('tabs_widgets_cookie') > 0) {
        $('#tabs_widgets a').eq($.cookie('tabs_widgets_cookie')).trigger("click");
    }
    $('#tabs_widgets a').click(function() {
        var element_index = $('#tabs_widgets a').index(this);
        $.cookie('tabs_widgets_cookie', element_index);
    });

    $('#tabs_custom_code a').tabs();
    if($.cookie('tabs_custom_code_cookie') > 0) {
        $('#tabs_custom_code a').eq($.cookie('tabs_custom_code_cookie')).trigger("click");
    }
    $('#tabs_custom_code a').click(function() {
        var element_index = $('#tabs_custom_code a').index(this);
        $.cookie('tabs_custom_code_cookie', element_index);
    });

    $('#tabs_custom_block a').tabs();
    if($.cookie('tabs_custom_block') > 0) {
        $('#tabs_custom_block a').eq($.cookie('tabs_custom_block')).trigger("click");
    }
    $('#tabs_custom_block a').click(function() {
        var element_index = $('#tabs_custom_block a').index(this);
        $.cookie('tabs_custom_block', element_index);
    });
});
//--></script>

<script type="text/javascript">
    <?php foreach ($languages as $language) { ?>
    $('#widget_custom_content_<?php echo $language['language_id']; ?>').summernote({
        height: 200
    });
    <?php } ?>

    $('.customblocktabs a').tabs();
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {

    $('#theme-options').on('click', '.status', function () {

        var styl = $(this).attr("rel");
        var co = $(this).attr("title");

        if(co == 1) {

            $(this).removeClass('status-on');
            $(this).addClass('status-off');
            $(this).attr("title", "0");

            $("#"+styl+"").val(0);

        }

        if(co == 0) {

            $(this).addClass('status-on');
            $(this).removeClass('status-off');
            $(this).attr("title", "1");

            $("#"+styl+"").val(1);

        }

    });

});
</script>
<script type="text/javascript">
$(document).ready(function() {

    $('#theme-options').on('change', 'select#select_demo', function () {
        $("select#select_demo option:selected").each(function() {
            $(".versions").hide();
            $(".version-" + $(this).val()).show();
            $("#demo").html("for " + $(this).text() + " version");
        });
    });

    <?php if($select_demo > 1) { ?>
         $(".versions").hide();
         $(".version-<?php echo $select_demo; ?>").show();
         $("#demo").html("for " + $("#select_demo option:selected").text() + " version");
    <?php } ?>

    $('#theme-options').on('change', 'select.select-page-width', function () {
        $("select.select-page-width option:selected").each(function() {
            if($(this).val() == 2) {
                $(".page-width").show();
            } else {
                $(".page-width").hide();
            }
        });
    });

    $('#theme-options').on('change', '.input-subtle-pattern', function () {
        $("#content").css("background-image", "url(../image/subtle_patterns/" + $(this).val() + ")");
    });

});
</script>
<?php echo $footer; ?>
